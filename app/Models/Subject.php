<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'code', 'name', 'sks', 'semester', 
        'kkm_uts', 'kkm_uas', 'meetings',
        'weight_task', 'weight_uts', 'weight_uas'
    ];

    public function grades()
    {
        return $this->hasMany(Grade::class, 'subject_id');
    }

    public function lecturers()
    {
        return $this->belongsToMany(User::class, 'lecturer_subject', 'subject_id', 'user_id');
    }

    public function materials()
    {
        return $this->hasMany(Material::class, 'subject_id');
    }
}
