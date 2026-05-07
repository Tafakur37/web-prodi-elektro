<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = ['student_id', 'dosen_id', 'requested_date', 'topic', 'status'];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }
}
