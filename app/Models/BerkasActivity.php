<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action', // upload, create_folder, delete, rename, move, share
        'subject_id',
        'subject_type',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->morphTo(); // BerkasFolder or BerkasFile
    }
}
