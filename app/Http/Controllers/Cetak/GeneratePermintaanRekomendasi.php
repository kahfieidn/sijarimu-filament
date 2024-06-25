<?php

namespace App\Http\Controllers\Cetak;

use App\Models\Permohonan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class GeneratePermintaanRekomendasi extends Controller
{
    //
    public function generatePermintaanRekomendasi($permohonan_id)
    {
        $permohonan = Permohonan::find($permohonan_id);
        $get_id_users = $permohonan->user->id;
        $get_nama_izin = $permohonan->perizinan->nama_perizinan;
        $nama_user = $permohonan->user->name;
        $data = [
            'permohonan' => $permohonan,
        ];
        $pdf = FacadePdf::loadView('cetak.rekomendasi.request', compact('permohonan'));
        $customPaper = array(0, 0, 609.4488, 935.433);
        $pdf->set_paper($customPaper);
        $pdf->render();

        // $pdf = PDF::loadView('cetak.izin', compact('permohonan'));

        return $pdf->stream($get_nama_izin . '_' . $nama_user . '.pdf');
    }
}
