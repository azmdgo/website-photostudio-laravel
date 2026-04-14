<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display all services.
     */
    public function index(Request $request)
    {
        $query = Service::with('category')->withCount('bookings');
        
        // Get total statistics (not filtered) for display
        $totalServices = Service::count();
        $activeServices = Service::where('is_active', true)->count();
        $inactiveServices = Service::where('is_active', false)->count();
        $totalCategories = ServiceCategory::count();
        $totalBookings = Service::withCount('bookings')->get()->sum('bookings_count');
        
        // Apply search filter if provided
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('category', function($categoryQuery) use ($search) {
                      $categoryQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        $services = $query->latest()->paginate(15);
        
        return view('admin.services.index', compact(
            'services',
            'totalServices',
            'activeServices', 
            'inactiveServices',
            'totalCategories',
            'totalBookings'
        ));
    }
    
    /**
     * Show form to create new service.
     */
    public function create()
    {
        $categories = ServiceCategory::active()->get();
        
        return view('admin.services.create', compact('categories'));
    }
    
    /**
     * Store new service.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:service_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'nullable|boolean'
        ]);

        $serviceData = [
            'service_category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration_minutes' => $request->duration_minutes,
            'is_active' => $request->boolean('is_active')
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('services', $imageName, 'public');
            $serviceData['image'] = $imagePath;
        }

        Service::create($serviceData);

        return redirect()->route('admin.services.index')
                         ->with('success', 'Service created successfully.');
    }
    
    /**
     * Show service details.
     */
    public function show(Service $service)
    {
        $service->load(['category', 'bookings.user']);
        
        return view('admin.services.show', compact('service'));
    }
    
    /**
     * Show form to edit service.
     */
    public function edit(Service $service)
    {
        $categories = ServiceCategory::active()->get();
        
        return view('admin.services.edit', compact('service', 'categories'));
    }
    
    /**
     * Update service.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'category_id' => 'required|exists:service_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'nullable|boolean'
        ]);
        
        $serviceData = [
            'service_category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'duration_minutes' => $request->duration_minutes,
            'is_active' => $request->boolean('is_active')
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($service->image && \Storage::disk('public')->exists($service->image)) {
                \Storage::disk('public')->delete($service->image);
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('services', $imageName, 'public');
            $serviceData['image'] = $imagePath;
        }
        
        $service->update($serviceData);
        
        return redirect()->route('admin.services.index')
                        ->with('success', 'Service berhasil diupdate!');
    }
    
    /**
     * Delete service.
     */
    public function destroy(Service $service)
    {
        // Check if service has bookings
        if ($service->bookings()->count() > 0) {
            return redirect()->back()
                           ->with('error', 'Service tidak dapat dihapus karena masih memiliki booking!');
        }
        
        // Delete image if exists
        if ($service->image && \Storage::disk('public')->exists($service->image)) {
            \Storage::disk('public')->delete($service->image);
        }
        
        $service->delete();
        
        return redirect()->route('admin.services.index')
                        ->with('success', 'Service berhasil dihapus!');
    }
}
