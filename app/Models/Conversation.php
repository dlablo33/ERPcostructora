<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conversation extends Model
{
    protected $fillable = [
        'user_one_id',
        'user_two_id',
        'last_message_at',
        'last_read_at_user_one',
        'last_read_at_user_two'
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
        'last_read_at_user_one' => 'datetime',
        'last_read_at_user_two' => 'datetime',
    ];

    public function userOne(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function userTwo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function getOtherUser($userId)
    {
        return $this->user_one_id == $userId ? $this->userTwo : $this->userOne;
    }

    public function getLastReadAt($userId)
    {
        return $this->user_one_id == $userId 
            ? $this->last_read_at_user_one 
            : $this->last_read_at_user_two;
    }

    public function updateLastReadAt($userId)
    {
        if ($this->user_one_id == $userId) {
            $this->update(['last_read_at_user_one' => now()]);
        } else {
            $this->update(['last_read_at_user_two' => now()]);
        }
    }
}