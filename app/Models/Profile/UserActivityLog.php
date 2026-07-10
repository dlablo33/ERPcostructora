<?php

namespace App\Models\Profile;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserActivityLog extends Model
{
    protected $table = 'user_activity_log';

    protected $fillable = [
        'user_id',
        'action',
        'module',
        'description',
        'subjectable_type',
        'subjectable_id',
        'old_values',
        'new_values',
        'metadata',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the activity log.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subjectable model (polymorphic).
     */
    public function subjectable()
    {
        return $this->morphTo();
    }

    /**
     * Log an activity.
     */
    public static function log($userId, $action, $data = [])
    {
        return self::create([
            'user_id' => $userId,
            'action' => $action,
            'module' => $data['module'] ?? null,
            'description' => $data['description'] ?? null,
            'subjectable_type' => $data['subjectable_type'] ?? null,
            'subjectable_id' => $data['subjectable_id'] ?? null,
            'old_values' => $data['old_values'] ?? null,
            'new_values' => $data['new_values'] ?? null,
            'metadata' => $data['metadata'] ?? null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

}
