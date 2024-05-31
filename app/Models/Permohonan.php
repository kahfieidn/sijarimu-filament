<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    use HasFactory;

    protected $fillable = [
        'perizinan_id',
        'user_id',
        'status_permohonan_id',
        'nama_pemohon',
        'berkas',
        'formulir',
        'status',
    ];

    protected $casts = [
        'berkas' => 'json',
        'formulir' => 'json',
    ];

    public function perizinan()
    {
        return $this->belongsTo(Perizinan::class);
    }

    public function status_permohonan()
    {
        return $this->belongsTo(StatusPermohonan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
