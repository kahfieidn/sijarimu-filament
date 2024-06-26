<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusPermohonanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        \App\Models\StatusPermohonan::create([
            'general_status' => 'Permohonan Anda Ditolak',
            'nama_status' => 'Ditolak',
            'icon' => 'heroicon-o-x-circle',
            'color' => 'danger',
        ]);
        \App\Models\StatusPermohonan::create([
            'general_status' => 'Permohonan Anda Perlu Direvisi',
            'nama_status' => 'Revisi',
            'icon' => 'heroicon-o-exclamation-triangle',
            'color' => 'warning',
        ]);
        \App\Models\StatusPermohonan::create([
            'general_status' => 'Permohonan Sedang Ditinjau Oleh Front Office',
            'nama_status' => 'Permintaan Persetujuan Front Office',
            'icon' => 'heroicon-o-document-duplicate',
            'color' => 'primary',
        ]);
        \App\Models\StatusPermohonan::create([
            'general_status' => 'Back Office Cross Check Berkas & Membuat Draft Permintaan Rekomendasi',
            'nama_status' => 'Permintaan Back Office Cross Check Berkas & Membuat Draft Permintaan Rekomendasi',
            'icon' => 'heroicon-o-document-duplicate',
            'color' => 'primary',
        ]);
        \App\Models\StatusPermohonan::create([
            'general_status' => 'Verifikator Permintaan Rekomendasi',
            'nama_status' => 'Persetujuan Permintaan Rekomendasi Oleh Verifikator',
            'icon' => 'heroicon-o-document-duplicate',
            'color' => 'primary',
        ]);
        \App\Models\StatusPermohonan::create([
            'general_status' => 'Persetujuan Kepala Dinas Permintaan Rekomendasi',
            'nama_status' => 'Persetujuan Permintaan Rekomendasi Oleh Kepala Dinas',
            'icon' => 'heroicon-o-document-duplicate',
            'color' => 'primary',
        ]);
        \App\Models\StatusPermohonan::create([
            'general_status' => 'OPD Teknis Melakukan Kajian Teknis',
            'nama_status' => 'Permintaan OPD Melakukan Kajian Teknis',
            'icon' => 'heroicon-o-document-duplicate',
            'color' => 'primary',
        ]);
        \App\Models\StatusPermohonan::create([
            'general_status' => 'Back Office Membuat Draft Izin',
            'nama_status' => 'Permintaan Back Office Membuat Draft Izin',
            'icon' => 'heroicon-o-document-duplicate',
            'color' => 'primary',
        ]);
        \App\Models\StatusPermohonan::create([
            'general_status' => 'Verifikator Izin',
            'nama_status' => 'Persetujuan Izin Oleh Verifikator',
            'icon' => 'heroicon-o-document-duplicate',
            'color' => 'primary',
        ]);
        \App\Models\StatusPermohonan::create([
            'general_status' => 'Menunggu Persetujuan Izin Oleh Kepala Dinas',
            'nama_status' => 'Persetujuan Izin Oleh Kepala Dinas',
            'icon' => 'heroicon-o-document-duplicate',
            'color' => 'primary',
        ]);
        \App\Models\StatusPermohonan::create([
            'general_status' => 'Izin Anda Telah Terbit',
            'nama_status' => 'Terbitkan Izin',
            'icon' => 'heroicon-o-check-badge',
            'color' => 'success',
        ]);
    }
}
