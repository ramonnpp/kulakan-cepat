<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalesMaterialController extends Controller
{
    /**
     * Menampilkan halaman materi penjualan.
     */
    public function index(Request $request)
    {
        // Data contoh (statis) untuk materi penjualan
        $allMaterials = collect([
            ['id' => 1, 'title' => 'Brosur Produk Kopi & Teh', 'category' => 'Brosur', 'file_type' => 'PDF', 'size' => '2.5 MB', 'upload_date' => '2023-10-26', 'url' => '#'],
            ['id' => 2, 'title' => 'Presentasi Keunggulan Produk', 'category' => 'Presentasi', 'file_type' => 'PPTX', 'size' => '10.8 MB', 'upload_date' => '2023-10-25', 'url' => '#'],
            ['id' => 3, 'title' => 'Daftar Harga Grosir Q3 2023', 'category' => 'Daftar Harga', 'file_type' => 'XLSX', 'size' => '1.2 MB', 'upload_date' => '2023-09-15', 'url' => '#'],
            ['id' => 4, 'title' => 'Video Iklan Produk Sirup', 'category' => 'Video', 'file_type' => 'MP4', 'size' => '55.2 MB', 'upload_date' => '2023-10-20', 'url' => '#'],
            ['id' => 5, 'title' => 'Panduan Skenario Penjualan', 'category' => 'Panduan', 'file_type' => 'DOCX', 'size' => '0.8 MB', 'upload_date' => '2023-09-30', 'url' => '#'],
            ['id' => 6, 'title' => 'Katalog Lengkap Produk 2023', 'category' => 'Brosur', 'file_type' => 'PDF', 'size' => '15.0 MB', 'upload_date' => '2023-08-01', 'url' => '#'],
            ['id' => 7, 'title' => 'Update Harga Eceran Q4 2023', 'category' => 'Daftar Harga', 'file_type' => 'XLSX', 'size' => '1.3 MB', 'upload_date' => '2023-10-01', 'url' => '#'],
        ]);

        // Logika untuk filter dan pencarian
        $materials = $allMaterials->when($request->search, function ($query, $search) {
            return $query->filter(function ($item) use ($search) {
                return str_contains(strtolower($item['title']), strtolower($search));
            });
        })->when($request->category, function ($query, $category) {
            return $query->where('category', $category);
        });

        // Mendapatkan semua kategori unik untuk filter
        $categories = $allMaterials->pluck('category')->unique()->sort();

        return view('sales.sales-material', compact('materials', 'categories'));
    }
}
