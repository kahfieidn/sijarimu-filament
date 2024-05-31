<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persyaratan extends Model
{
    use HasFactory;

    protected $fillable = [
        'perizinan_id',
        'nama_persyaratan',
        'deskripsi_persyaratan'
    ];

    public function perizinan()
    {
        return $this->belongsTo(Perizinan::class);
    }
}
