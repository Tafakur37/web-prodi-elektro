<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Material extends Model
{
    // Tambahkan user_id ke dalam list di bawah ini
    protected $fillable = [
        'subject_id',
        'title', 
        'description', 
        'file_path', 
        'file_name',
        'file_type', 
        'target_role', 
        'cohort', 
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}