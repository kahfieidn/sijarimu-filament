<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerizinanConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_configuration',
        'prefix_nomor_rekomendasi',
        'suffix_nomor_rekomendasi',
        'nomor_rekomendasi',
        'prefix_nomor_izin',
        'suffix_nomor_izin',
        'nomor_izin',
    ];
}
