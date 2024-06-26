<?php

namespace App\Models;

use App\Models\Perizinan;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Formulir extends Model
{
    use HasFactory;

    protected $fillable = [
        'perizinan_id',
        'features',
        'nama_formulir',
        'type',
        'options',
        'is_columnSpanFull',
    ];

    protected $casts = [
        'options' => 'json',
        'features' => 'json',
    ];

    public function perizinan()
    {
        return $this->belongsTo(Perizinan::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
