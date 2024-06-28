<?php

namespace App\Models;

use App\Models\PerizinanLifecycle;
use App\Models\PerizinanConfiguration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Perizinan extends Model
{
    use HasFactory;

    protected $fillable = [
        'sektor_id',
        'nama_perizinan',
        'perizinan_lifecycle_id',
        'perizinan_configuration_id',
        'is_template_rekomendasi',
        'is_template_izin',
        'template_rekomendasi',
        'template_izin',
        'is_save_as_template_rekomendasi',
        'is_save_as_template_izin'
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

    public function perizinan_configuration(){
        return $this->belongsTo(PerizinanConfiguration::class, 'perizinan_configuration_id', 'id');
    }

}
