<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['sender_id', 'receiver_id', 'message', 'file_path', 'is_read', 'deleted_by_sender', 'deleted_by_receiver', 'is_deleted_for_everyone'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
