<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerizinanLifecycle extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_flow',
        'flow',
    ];

    protected $casts = [
        'flow' => 'json',
    ];
}
