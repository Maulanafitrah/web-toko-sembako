<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menghapus data admin lama agar tidak duplikat, lalu memasukkan yang baru
        DB::table('admins')->updateOrInsert(
            ['username' => 'admin toko'], // Username pilihan Anda
            [
                'password' => Hash::make('fitrah123'), // Password pilihan Anda
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}