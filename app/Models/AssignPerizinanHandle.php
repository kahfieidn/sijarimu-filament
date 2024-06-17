<?php

namespace App\Models;

use App\Models\User;
use App\Models\Perizinan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignPerizinanHandle extends Model
{
    use HasFactory;

    protected $fillable = [
        'perizinan_id',
        'user_id',
        'is_all_perizinan'
    ];

    protected $casts = [
        'perizinan_id' => 'json'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function perizinan()
    {
        return $this->belongsTo(Perizinan::class);
    }
}
