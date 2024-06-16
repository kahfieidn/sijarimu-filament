<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerizinanConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'format_nomor_izin',
        'iteration',
    ];
}
