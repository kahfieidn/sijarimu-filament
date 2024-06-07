<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        \App\Models\Feature::create([
            'nama_feature' => 'pilih_perizinan',
            'deskripsi' => '-',
        ]);
        \App\Models\Feature::create([
            'nama_feature' => 'profile_usaha_relation',
            'deskripsi' => '-',
        ]);
        \App\Models\Feature::create([
            'nama_feature' => 'checklist_berkas',
            'deskripsi' => '-',
        ]);
        \App\Models\Feature::create([
            'nama_feature' => 'checklist_formulir',
            'deskripsi' => '-',
        ]);
        \App\Models\Feature::create([
            'nama_feature' => 'konfirmasi_pemohon',
            'deskripsi' => '-',
        ]);
        \App\Models\Feature::create([
            'nama_feature' => 'fo_moderation',
            'deskripsi' => '-',
        ]);
        \App\Models\Feature::create([
            'nama_feature' => 'bo_moderation',
            'deskripsi' => '-',
        ]);

    }
}
