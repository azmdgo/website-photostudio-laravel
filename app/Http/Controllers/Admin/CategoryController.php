<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ServiceCategory::withCount('services')
                                   ->latest()
                                   ->paginate(15);
        
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:service_categories',
            'description' => 'required|string',
            'is_active' => 'boolean'
        ]);
        
        ServiceCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active')
        ]);
        
        return redirect()->route('admin.categories.index')
                        ->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceCategory $category)
    {
        $category->load(['services' => function($query) {
            $query->withCount('bookings');
        }]);
        
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:service_categories,name,' . $category->id,
            'description' => 'required|string',
            'is_active' => 'boolean'
        ]);
        
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active')
        ]);
        
        return redirect()->route('admin.categories.index')
                        ->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceCategory $category)
    {
        // Check if category has services
        if ($category->services()->count() > 0) {
            return redirect()->back()
                           ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki layanan!');
        }
        
        $category->delete();
        
        return redirect()->route('admin.categories.index')
                        ->with('success', 'Kategori berhasil dihapus!');
    }
}
