<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BerkasFolder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'parent_id',
        'name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(BerkasFolder::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(BerkasFolder::class, 'parent_id');
    }

    public function files()
    {
        return $this->hasMany(BerkasFile::class, 'folder_id');
    }

    public function shares()
    {
        return $this->morphMany(BerkasShare::class, 'shareable');
    }

    public function stars()
    {
        return $this->morphMany(BerkasStar::class, 'starrable');
    }
}
