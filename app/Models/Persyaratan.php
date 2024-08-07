<?php

namespace App\Models;

use App\Models\Perizinan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Persyaratan extends Model
{
    use HasFactory;

    protected $fillable = [
        'perizinan_id',
        'nama_persyaratan',
        'deskripsi_persyaratan',
        'template',
    ];

    public function perizinan()
    {
        return $this->belongsTo(Perizinan::class);
    }
}
