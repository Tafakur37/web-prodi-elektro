<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['subject_id', 'cohort', 'date', 'start_time', 'end_time', 'room', 'type'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
