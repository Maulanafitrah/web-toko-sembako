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
        Schema::table('products', function (Blueprint $table) {
            // Menambahkan kolom deskripsi setelah kolom kategori
            // Gunakan nullable() agar produk lama yang tidak punya deskripsi tidak error
            if (!Schema::hasColumn('products', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('kategori');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Menghapus kolom deskripsi jika migrasi di-rollback
            if (Schema::hasColumn('products', 'deskripsi')) {
                $table->dropColumn('deskripsi');
            }
        });
    }
};