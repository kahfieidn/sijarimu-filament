<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
