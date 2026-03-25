<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan data lama agar tidak duplikat saat dijalankan ulang
        DB::table('products')->truncate();

        $products = [
            [
                'nama' => 'Beras Premium 5kg',
                'harga' => 75000,
                'stok' => 50,
                'kategori' => 'Beras', // Mengatasi error field 'kategori'
                'image' => 'beras.jpg',  // Referensi file di public/images/
                'gambar' => 'beras.jpg', // Mengatasi error field 'gambar'
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Minyak Goreng 2L',
                'harga' => 34000,
                'stok' => 30,
                'kategori' => 'Minyak',
                'image' => 'minyak.jpg',
                'gambar' => 'minyak.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Gula Pasir 1kg',
                'harga' => 17000,
                'stok' => 100,
                'kategori' => 'Gula',
                'image' => 'gula.jpg',
                'gambar' => 'gula.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // Memasukkan data ke tabel products di database db_toko_sembakol
        DB::table('products')->insert($products);
    }
}