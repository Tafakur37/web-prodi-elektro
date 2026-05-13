<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BerkasFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'folder_id',
        'name',
        'file_path',
        'extension',
        'size',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function folder()
    {
        return $this->belongsTo(BerkasFolder::class, 'folder_id');
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
