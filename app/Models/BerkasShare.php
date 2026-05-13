<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasShare extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Sharer
        'shareable_id',
        'shareable_type',
        'shared_with_user_id',
        'shared_with_role',
        'permission', // view, edit
    ];

    public function user()
    {
        return $this->belongsTo(User::class); // The one who shared
    }

    public function sharedWithUser()
    {
        return $this->belongsTo(User::class, 'shared_with_user_id');
    }

    public function shareable()
    {
        return $this->morphTo(); // BerkasFolder or BerkasFile
    }
}
