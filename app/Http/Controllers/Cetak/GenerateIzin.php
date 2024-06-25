<?php

namespace App\Http\Controllers\Cetak;

use App\Models\Permohonan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;


class GenerateIzin extends Controller
{
    //

    public function sample($permohonan_id)
    {
        $permohonan = Permohonan::find($permohonan_id);
        $get_id_users = $permohonan->user->id;
        $get_nama_izin = $permohonan->perizinan->nama_perizinan;
        $nama_user = $permohonan->user->name;
        $data = [
            'permohonan' => $permohonan,
        ];
        $pdf = FacadePdf::loadView('cetak.izin.sample', $data);
        $customPaper = array(0, 0, 609.4488, 935.433);
        $pdf->set_paper($customPaper);
        $pdf->render();

        // $pdf = PDF::loadView('cetak.izin', compact('permohonan'));

        return $pdf->stream($get_nama_izin . '_' . $nama_user . '.pdf');
    }

    public function generateIzin($permohonan_id)
    {
        $permohonan = Permohonan::find($permohonan_id);
        $get_id_users = $permohonan->user->id;
        $get_nama_izin = $permohonan->perizinan->nama_perizinan;
        $nama_user = $permohonan->user->name;
        $template_izin = $permohonan->perizinan->template_izin;
        $data = [
            'permohonan' => $permohonan,
        ];
        $pdf = FacadePdf::loadView('cetak.izin.request', compact('permohonan'));
        $customPaper = array(0, 0, 609.4488, 935.433);
        $pdf->set_paper($customPaper);
        $pdf->render();

        // $pdf = PDF::loadView('cetak.izin', compact('permohonan'));

        return $pdf->stream($get_nama_izin . '_' . $nama_user . '.pdf');
    }
}
