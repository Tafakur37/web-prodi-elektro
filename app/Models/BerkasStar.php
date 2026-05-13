<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasStar extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'starrable_id',
        'starrable_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function starrable()
    {
        return $this->morphTo(); // BerkasFolder or BerkasFile
    }
}
