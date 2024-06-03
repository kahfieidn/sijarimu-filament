<?php

namespace App\Models;

use App\Models\Permohonan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProfileUsaha extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_perusahaan',
        'npwp',
        'npwp_file',
        'nib',
        'nib_file',
        'alamat',
        'provinsi',
        'domisili',        
    ];


}
