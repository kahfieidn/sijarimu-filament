<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\User::factory()->create([
            'name' => 'Administrator',
            'email' => 'mhmmdkahfi2000@gmail.com',
            'password' => bcrypt('jika12345'),
            'nomor_hp' => '081234567890',
        ]);

        $this->call([
            FeatureSeeder::class,
            StatusPermohonanSeeder::class,
        ]);
    }
}
