<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPermohonan extends Model
{
    use HasFactory;

    protected $fillable = [
        'general_status',
        'nama_status',
        'icon',
        'color',
        'role_id'
    ];

    protected $casts = [
        'role_id' => 'json',
    ];
}
