<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\ProfileUsaha;
use App\Enums\PermohonanStatus;
use App\Models\StatusPermohonan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permohonan extends Model
{
    use HasFactory;

    protected $fillable = [
        'perizinan_id',
        'user_id',
        'status_permohonan_id',
        'profile_usaha_id',
        'message',
        'message_bo',
        'nama_pemohon',
        'berkas',
        'formulir',
        'status',
        'nomor_izin',
        'nomor_rekomendasi',
        'nomor_kajian_teknis',
        'tanggal_rekomendasi_terbit',
        'tanggal_izin_terbit',
        'kajian_teknis',
        'rekomendasi_terbit',
        'izin_terbit',
    ];

    protected $casts = [
        'berkas' => 'json',
        'formulir' => 'json',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }


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

    public function profile_usaha()
    {
        return $this->belongsTo(ProfileUsaha::class);
    }
}
