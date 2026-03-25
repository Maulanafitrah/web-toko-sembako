<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nama');      // Nama Produk (Beras, Telur, dll)
            $table->string('kategori');  // Kategori Produk
            $table->integer('harga');    // Harga dalam angka
            $table->integer('stok')->default(0); // Jumlah stok tersedia
            $table->string('gambar');    // Nama file gambar di folder public/images
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};