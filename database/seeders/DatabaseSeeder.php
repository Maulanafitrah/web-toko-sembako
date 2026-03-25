<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Gunakan format string jika ProductSeeder::class masih kuning
        $this->call([
            'Database\Seeders\ProductSeeder',
        ]);
    }
}