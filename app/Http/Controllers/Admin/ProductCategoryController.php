<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\Product; // Pastikan model Product diimpor jika ingin menghitung relasi
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <--- PASTIKAN BARIS INI ADA UNTUK MENGGUNAKAN DB::table()
// use Illuminate\Support\Str; // BARIS INI DIHAPUS: Tidak perlu Str jika tidak pakai slug

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ProductCategory::query();

        // Implementasi fitur pencarian jika ada
        if ($request->has('search_category') && $request->search_category != '') {
            $query->where('name', 'like', '%' . $request->search_category . '%')
                  ->orWhere('description', 'like', '%' . $request->search_category . '%');
        }

        $categories = $query->withCount('products')->orderBy('name')->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products_category,name',
            'description' => 'nullable|string',
        ]);

        ProductCategory::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori produk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $category // Mengubah tipe hint ke string untuk mendapatkan ID secara langsung
     * @return \Illuminate\Http\Response
     */
    public function show(string $category) // Mengubah parameter
    {
        // Cari kategori secara manual untuk mengatasi masalah model binding
        $productCategory = ProductCategory::where('id_product_category', $category)->firstOrFail();
        return view('admin.categories.show', compact('productCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $category // Mengubah tipe hint ke string untuk mendapatkan ID secara langsung
     * @return \Illuminate\Http\Response
     */
    public function edit(string $category) // Mengubah parameter
    {
        // Cari kategori secara manual untuk mengatasi masalah model binding
        $productCategory = ProductCategory::where('id_product_category', $category)->firstOrFail();
        return view('admin.categories.edit', compact('productCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $category // Mengubah tipe hint ke string untuk mendapatkan ID secara langsung
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $category) // Mengubah parameter
    {
        // Cari kategori secara manual untuk mengatasi masalah model binding
        $productCategory = ProductCategory::where('id_product_category', $category)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255|unique:products_category,name,' . $productCategory->id_product_category . ',id_product_category',
            'description' => 'nullable|string',
        ]);

        $productCategory->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori produk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $category // Mengubah tipe hint ke string untuk mendapatkan ID secara langsung
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $category) // Mengubah parameter
    {
        // Cari kategori secara manual untuk mengatasi masalah model binding
        $productCategory = ProductCategory::where('id_product_category', $category)->firstOrFail();

        if ($productCategory->products()->exists()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus kategori karena masih ada produk yang terkait!');
        }

        $deleted = DB::table('products_category')
                     ->where('id_product_category', $productCategory->id_product_category)
                     ->delete();

        if ($deleted) {
            return redirect()->route('admin.categories.index')->with('success', 'Kategori produk berhasil dihapus!');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus kategori. Data tidak ditemukan atau ada masalah lain.');
        }
    }
}