<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    protected $fillable = ['user_id', 'category', 'content', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dismissedBy()
    {
        return $this->belongsToMany(User::class, 'suggestion_dismissals')->withTimestamps();
    }

    /**
     * Scope: hanya saran yang belum di-dismiss oleh user tertentu & belum lewat 30 hari
     */
    public function scopeVisibleFor($query, $userId)
    {
        return $query->where('created_at', '>=', now()->subDays(30))
            ->whereDoesntHave('dismissedBy', function ($q) use ($userId) {
                $q->where('users.id', $userId);
            });
    }
}
