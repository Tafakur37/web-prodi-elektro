<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleOverride extends Model
{
    protected $fillable = [
        'schedule_id',
        'override_date',
        'new_start_time',
        'new_end_time',
        'new_room',
        'status',
        'note',
    ];

    protected $casts = [
        'override_date' => 'date',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
