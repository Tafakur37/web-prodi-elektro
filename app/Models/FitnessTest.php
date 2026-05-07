<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FitnessTest extends Model
{
    protected $fillable = [
        'user_id',
        'semester',
        'test_date',
        // Legacy columns
        'score_a',
        'score_b',
        'score_c',
        'score',
        'status',
        // Raw input data
        'raw_lari',
        'raw_pull_up',
        'raw_chinning',
        'raw_sit_up',
        'raw_push_up',
        'raw_shuttle_run',
        'raw_renang',
        // Nilai konversi (0-100)
        'nilai_lari',
        'nilai_pull_up',
        'nilai_chinning',
        'nilai_sit_up',
        'nilai_push_up',
        'nilai_shuttle_run',
        'nilai_renang',
        // Total
        'total_score',
    ];

    protected $casts = [
        'test_date' => 'date',
        'raw_lari' => 'decimal:2',
        'raw_shuttle_run' => 'decimal:2',
        'raw_renang' => 'decimal:2',
        'total_score' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Label status otomatis berdasarkan total_score
     */
    public function getStatusLabelAttribute(): string
    {
        if ($this->total_score === null) {
            return $this->status ?? '-';
        }
        return $this->total_score >= 60 ? 'Lulus' : 'Tidak Lulus';
    }

    /**
     * Badge class untuk status
     */
    public function getStatusBadgeAttribute(): string
    {
        $status = $this->status ?? $this->status_label;
        return match($status) {
            'Lulus' => 'bg-success',
            'Tidak Lulus' => 'bg-danger',
            default => 'bg-warning text-dark',
        };
    }
}
