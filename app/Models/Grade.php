<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    // app/Models/Grade.php

    // App\Models\Grade.php
protected $fillable = [
    'user_id', 
    'subject_id', 
    'attendance', 
    'tugas', 
    'uts', 
    'remedial_uts', 
    'uas', 
    'remedial_uas', 
    'grade', 
    'cohort',
    'final_score',
    'grade_point'
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
