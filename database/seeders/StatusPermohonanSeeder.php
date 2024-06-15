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
            'general_status' => 'Back Office Membuat Draft Rekomendasi',
            'nama_status' => 'Permintaan Back Office Membuat Draft Rekomendasi',
            'icon' => 'heroicon-o-document-duplicate',
            'color' => 'primary',
        ]);
        \App\Models\StatusPermohonan::create([
            'general_status' => 'Verifikator 1 Cross Check Draft Rekomendasi',
            'nama_status' => 'Permintaan Persetujuan Draft Rekomendasi Verifikator 1',
            'icon' => 'heroicon-o-document-duplicate',
            'color' => 'primary',
        ]);
        \App\Models\StatusPermohonan::create([
            'general_status' => 'Verifikator 2 Cross Check Draft Rekomendasi',
            'nama_status' => 'Permintaan Persetujuan Draft Rekomendasi Verifikator 2',
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
            'general_status' => 'Verifikator 1 Cross Check Draft Izin',
            'nama_status' => 'Permintaan Persetujuan Draft Izin Verifikator 1',
            'icon' => 'heroicon-o-document-duplicate',
            'color' => 'primary',
        ]);
        \App\Models\StatusPermohonan::create([
            'general_status' => 'Verifikator 2 Cross Check Draft Izin',
            'nama_status' => 'Permintaan Persetujuan Draft Izin Verifikator 2',
            'icon' => 'heroicon-o-document-duplicate',
            'color' => 'primary',
        ]);
        \App\Models\StatusPermohonan::create([
            'general_status' => 'Menunggu Persetujuan Izin Oleh Kepala Dinas',
            'nama_status' => 'Permintaan Persetujuan Izin Terbit Oleh Kepala Dinas',
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
