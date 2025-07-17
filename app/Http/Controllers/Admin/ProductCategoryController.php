<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; // <-- Tambahkan ini

class ProductCategoryController extends Controller
{
    // ... (method index dan create tidak perlu diubah)

    public function index(Request $request)
    {
        $query = ProductCategory::query();

        if ($request->has('search_category') && $request->search_category != '') {
            $query->where('name', 'like', '%' . $request->search_category . '%')
                  ->orWhere('description', 'like', '%' . $request->search_category . '%');
        }

        $categories = $query->withCount('products')->orderBy('name')->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }
    
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255|unique:products_category,name',
        'description' => 'nullable|string',
        // --- PERBAIKAN DI SINI ---
        'icon' => ['sometimes', 'nullable', 'image', 'mimes:jpg,jpeg', 'max:2048'],
    ]);

    if ($request->hasFile('icon')) {
        $path = $request->file('icon')->store('public/category_icons');
        $validatedData['icon'] = $path;
    }

    ProductCategory::create($validatedData);

    return redirect()->route('admin.categories.index')->with('success', 'Kategori produk berhasil ditambahkan!');
}

    // ... (method show tidak perlu diubah)
     public function show(string $category) 
    {
        $productCategory = ProductCategory::where('id_product_category', $category)->firstOrFail();
        return view('admin.categories.show', compact('productCategory'));
    }


    public function edit(string $category)
    {
        $productCategory = ProductCategory::where('id_product_category', $category)->firstOrFail();
        return view('admin.categories.edit', compact('productCategory'));
    }

   public function update(Request $request, string $category)
{
    $productCategory = ProductCategory::where('id_product_category', $category)->firstOrFail();

    $validatedData = $request->validate([
        'name' => 'required|string|max:255|unique:products_category,name,' . $productCategory->id_product_category . ',id_product_category',
        'description' => 'nullable|string',
        // --- PERBAIKAN DI SINI ---
        'icon' => ['sometimes', 'nullable', 'image', 'mimes:jpg,jpeg', 'max:2048'],
    ]);

    if ($request->hasFile('icon')) {
        if ($productCategory->icon && Storage::exists($productCategory->icon)) {
            Storage::delete($productCategory->icon);
        }
        $path = $request->file('icon')->store('public/category_icons');
        $validatedData['icon'] = $path;
    }

    $productCategory->update($validatedData);

    return redirect()->route('admin.categories.index')->with('success', 'Kategori produk berhasil diperbarui!');
}

    public function destroy(string $category)
    {
        $productCategory = ProductCategory::where('id_product_category', $category)->firstOrFail();

        if ($productCategory->products()->exists()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus kategori karena masih ada produk yang terkait!');
        }
        
        // Hapus file ikon dari storage sebelum menghapus record dari database
        if ($productCategory->icon && Storage::exists($productCategory->icon)) {
            Storage::delete($productCategory->icon);
        }

        $productCategory->delete(); // Menggunakan metode delete dari Eloquent

        return redirect()->route('admin.categories.index')->with('success', 'Kategori produk berhasil dihapus!');
    }
}