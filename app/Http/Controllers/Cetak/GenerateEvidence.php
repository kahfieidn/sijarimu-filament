<?php

namespace App\Http\Controllers\Cetak;

use App\Models\Permohonan;
use App\Models\ProfileUsaha;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class GenerateEvidence extends Controller
{
    //
    public function generateEvidence($permohonan_id)
    {
        $permohonan = Permohonan::find($permohonan_id);
        $get_id_users = $permohonan->user->id;
        $get_nama_izin = $permohonan->perizinan->nama_perizinan;
        $nama_user = $permohonan->user->name;
        
        $nama_perusahaan_or_perorangan = $permohonan->profile_usaha->nama_perusahaan ?? $permohonan->user->name;

        $data = [
            'permohonan' => $permohonan,
            'nama_perusahaan_or_perorangan' => $nama_perusahaan_or_perorangan
        ];
        $pdf = FacadePdf::loadView('cetak.evidence.request', compact('permohonan', 'nama_perusahaan_or_perorangan'));
        $pdf->set_paper('a4');
        $pdf->render();

        // $pdf = PDF::loadView('cetak.izin', compact('permohonan'));

        return $pdf->stream('Lembar Verifikasi Berkas' . '_' . $nama_user . '_' . $permohonan->id . '.pdf');
    }
}
