<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // 1. Mengambil input 'kategori' dari link yang Anda klik di menu awal
        $kategori = $request->query('kategori');

        // 2. Logika penyaringan: Jika ada kategori, cari yang sesuai saja
        if ($kategori && $kategori !== 'all') {
            // Mencari produk yang kolom kategorinya mirip dengan yang diklik
            $products = Product::where('kategori', 'LIKE', '%' . $kategori . '%')->get();
        } else {
            // Jika tidak ada kategori (akses langsung), tampilkan semua produk
            $products = Product::all();
        }

        // 3. Mengirim data produk ke index.blade.php
        return view('index', compact('products'));
    }
}