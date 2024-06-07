<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreFlow extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id',
        'features',
    ];

    protected $casts = [
        'feature' => 'json',
    ];
}
