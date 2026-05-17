<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'gender',
        'email',
        'password',
        'nim',
        'cohort',
        'role',
        'profile_photo',
        'theme',
    ];

    /**
     * Accessor: Tampilkan label gender yang ramah
     */
    public function getGenderLabelAttribute(): string
    {
        return match($this->gender) {
            'L' => 'Laki-laki',
            'P' => 'Perempuan',
            default => '-',
        };
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // app/Models/User.php

public function grades()
{
    // Pastikan model Grade sudah ada
    return $this->hasMany(Grade::class, 'user_id');
}

public function teachingSubjects()
{
    return $this->belongsToMany(Subject::class, 'lecturer_subject', 'user_id', 'subject_id');
}       

public function submissions()
{
    return $this->hasMany(Submission::class);
}

public function meetingsAsStudent()
{
    return $this->hasMany(Meeting::class, 'student_id');
}

public function meetingsAsDosen()
{
    return $this->hasMany(Meeting::class, 'dosen_id');
}

public function achievements()
{
    return $this->hasMany(Achievement::class);
}

public function violations()
{
    return $this->hasMany(Violation::class);
}

public function fitnessTests()
{
    return $this->hasMany(FitnessTest::class);
}

public function suggestions()
{
    return $this->hasMany(Suggestion::class);
}

public function attendancesAsStudent()
{
    return $this->hasMany(Attendance::class, 'student_id');
}

public function attendancesAsLecturer()
{
    return $this->hasMany(Attendance::class, 'lecturer_id');
}

public function sentChats()
{
    return $this->hasMany(Chat::class, 'sender_id');
}

public function receivedChats()
{
    return $this->hasMany(Chat::class, 'receiver_id');
}

/**
 * Override: gunakan notifikasi reset password berbahasa Indonesia
 */
public function sendPasswordResetNotification($token): void
{
    $this->notify(new ResetPasswordNotification($token));
}
}

