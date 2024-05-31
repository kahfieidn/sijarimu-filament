<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perizinan extends Model
{
    use HasFactory;

    protected $fillable = [
        'sektor_id',
        'nama_perizinan',
    ];

    public function sektor()
    {
        return $this->belongsTo(Sektor::class);
    }

    public function persyaratan()
    {
        return $this->hasMany(Persyaratan::class);
    }

    public function formulir()
    {
        return $this->hasMany(Formulir::class);
    }

}
