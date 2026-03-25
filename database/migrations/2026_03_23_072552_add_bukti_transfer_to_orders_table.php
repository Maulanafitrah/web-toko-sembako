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
        Schema::table('orders', function (Blueprint $table) {
            // Kita cek dulu: jika kolom belum ada, baru kita buat
            if (!Schema::hasColumn('orders', 'bukti_transfer')) {
                $table->string('bukti_transfer')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'bukti_transfer')) {
                $table->dropColumn('bukti_transfer');
            }
        });
    }
};