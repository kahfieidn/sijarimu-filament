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
        'role_id',
        'nama_formulir',
        'type',
        'options',
    ];

    protected $casts = [
        'options' => 'json',
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
