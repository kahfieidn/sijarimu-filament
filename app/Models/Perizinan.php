<?php

namespace App\Models;

use App\Models\PerizinanLifecycle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Perizinan extends Model
{
    use HasFactory;

    protected $fillable = [
        'sektor_id',
        'nama_perizinan',
        'perizinan_lifecycle_id',
        'template_rekomendasi',
        'template_izin'
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

    public function perizinan_lifecycle(){
        return $this->belongsTo(PerizinanLifecycle::class, 'perizinan_lifecycle_id', 'id');
    }

}
