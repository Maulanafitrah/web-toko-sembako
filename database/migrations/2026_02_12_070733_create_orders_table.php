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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique(); 
            $table->text('produk');               // Menggunakan text agar muat banyak nama produk dari keranjang
            $table->integer('total_bayar');       // Total keseluruhan belanja
            $table->string('nama_pembeli');
            $table->string('no_telp')->nullable(); // Menambah kolom nomor telepon
            $table->string('metode_pembayaran');  // transfer atau cod
            $table->string('bukti_transfer')->nullable(); // NULLABLE: Penting agar COD bisa simpan tanpa gambar
            $table->string('status')->default('pending'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders'); 
    }
};