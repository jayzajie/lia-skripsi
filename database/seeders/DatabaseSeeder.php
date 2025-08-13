<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the seeders in the right order
        $this->call([
            AcademicYearSeeder::class,
            UserSeeder::class,
            RombelSeeder::class,
            StudentSeeder::class,
        ]);
    }
}
