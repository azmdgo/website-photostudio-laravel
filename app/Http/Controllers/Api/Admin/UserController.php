<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        $users = $query->withCount('bookings')
                      ->latest()
                      ->paginate(15);
        
        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:customer,admin,studio_staff,owner',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(), // Auto verify for admin-created users
            'is_active' => true,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil dibuat',
            'data' => $user->load('bookings')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load(['bookings.service.category', 'bookings.payment']);
        $user->loadCount('bookings');
        
        // Add formatted_id to response
        $userData = $user->toArray();
        $userData['formatted_id'] = $user->getFormattedId();
        
        return response()->json([
            'success' => true,
            'data' => $userData
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Prevent self-demotion from admin
        if ($user->id === auth()->id() && $request->role !== 'admin' && $request->role !== 'owner') {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat mengubah peran admin Anda sendiri'
            ], 403);
        }
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:customer,admin,studio_staff,owner',
            'password' => 'nullable|string|min:8|confirmed',
            'is_active' => 'boolean',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'is_active' => $request->boolean('is_active', true),
        ];
        
        // Only update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        
        $user->update($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil diperbarui',
            'data' => $user->fresh()->load('bookings')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat menghapus akun Anda sendiri'
            ], 403);
        }
        
        // Check if user has bookings
        if ($user->bookings()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus pengguna dengan pemesanan yang ada. Batalkan atau transfer pemesanan terlebih dahulu.'
            ], 400);
        }
        
        $userName = $user->name;
        $user->delete();
        
        return response()->json([
            'success' => true,
            'message' => "Pengguna '{$userName}' berhasil dihapus"
        ]);
    }
    
    /**
     * Toggle user status (active/inactive)
     */
    public function toggleStatus(User $user)
    {
        // Prevent self-deactivation
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat menonaktifkan akun Anda sendiri'
            ], 403);
        }
        
        $user->update([
            'is_active' => !$user->is_active
        ]);
        
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return response()->json([
            'success' => true,
            'message' => "Pengguna berhasil {$status}",
            'data' => $user
        ]);
    }
}
