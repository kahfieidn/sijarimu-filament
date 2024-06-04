<?php

namespace App\Models;

use App\Models\StatusPermohonan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PerizinanLifecycle extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_flow',
        'flow',
        'flow_status',
    ];

    protected $casts = [
        'flow' => 'json',
        'flow_status' => 'json',
    ];
    
}
