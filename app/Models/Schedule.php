<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    // Pastikan user_id ada di fillable
    protected $fillable = ['subject_id', 'user_id', 'day', 'start_time', 'end_time', 'room', 'cohort'];

    /**
     * Relasi ke Model User (Dosen)
     */
    public function dosen(): BelongsTo
    {
        // 'user_id' adalah nama kolom di tabel schedules yang merujuk ke id di tabel users
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Model Subject (Mata Kuliah)
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    /**
     * Relasi ke Model ScheduleOverride
     */
    public function overrides()
    {
        return $this->hasMany(ScheduleOverride::class);
    }
}