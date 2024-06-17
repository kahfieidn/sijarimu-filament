<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerizinanConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_configuration',
        'format_nomor_rekomendasi',
        'iteration_rekomendasi',
        'format_nomor_izin',
        'iteration_izin',
    ];
}
