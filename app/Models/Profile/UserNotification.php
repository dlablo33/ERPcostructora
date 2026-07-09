<?php

namespace App\Models\Profile;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserNotification extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type',
        'category',
        'module',
        'reference_id',
        'title',
        'message',
        'link',
        'icon',
        'color',
        'action_text',
        'action_url',
        'action_data',
        'is_read',
        'read_at',
        'is_dismissed',
        'dismissed_at',
        'sent_email',
        'sent_email_at',
        'sent_push',
        'sent_push_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'reference_id' => 'integer',
        'action_data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'is_dismissed' => 'boolean',
        'dismissed_at' => 'datetime',
        'sent_email' => 'boolean',
        'sent_email_at' => 'datetime',
        'sent_push' => 'boolean',
        'sent_push_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];

    /**
     * Get the user that owns the notification.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category color class.
     */
    public function getCategoryColorAttribute()
    {
        $colors = [
            'info' => 'blue',
            'success' => 'green',
            'warning' => 'yellow',
            'danger' => 'red',
            'system' => 'gray',
            'project' => 'indigo',
            'task' => 'purple',
            'security' => 'red',
            'alert' => 'orange',
        ];

        return $colors[$this->category] ?? 'blue';
    }

    /**
     * Get the icon class.
     */
    public function getIconClassAttribute()
    {
        $icons = [
            'info' => 'fa-info-circle',
            'success' => 'fa-check-circle',
            'warning' => 'fa-exclamation-triangle',
            'danger' => 'fa-times-circle',
            'system' => 'fa-cog',
            'project' => 'fa-project-diagram',
            'task' => 'fa-tasks',
            'security' => 'fa-shield-alt',
            'alert' => 'fa-bell',
        ];

        return $icons[$this->category] ?? 'fa-bell';
    }

    /**
     * Get the time ago for the notification.
     */
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Mark notification as unread.
     */
    public function markAsUnread()
    {
        $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    /**
     * Dismiss notification.
     */
    public function dismiss()
    {
        $this->update([
            'is_dismissed' => true,
            'dismissed_at' => now(),
        ]);
    }

    /**
     * Scope a query to only include unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false)->where('is_dismissed', false);
    }

    /**
     * Scope a query to only include read notifications.
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Scope a query to only include dismissed notifications.
     */
    public function scopeDismissed($query)
    {
        return $query->where('is_dismissed', true);
    }

    /**
     * Scope a query to only include active notifications.
     */
    public function scopeActive($query)
    {
        return $query->where('is_dismissed', false);
    }

    /**
     * Create a new notification for a user.
     */
    public static function createNotification($userId, $data)
    {
        return self::create([
            'user_id' => $userId,
            'type' => $data['type'] ?? 'system',
            'category' => $data['category'] ?? 'info',
            'module' => $data['module'] ?? null,
            'reference_id' => $data['reference_id'] ?? null,
            'title' => $data['title'] ?? 'Notificación',
            'message' => $data['message'] ?? null,
            'link' => $data['link'] ?? null,
            'icon' => $data['icon'] ?? null,
            'color' => $data['color'] ?? null,
            'action_text' => $data['action_text'] ?? null,
            'action_url' => $data['action_url'] ?? null,
            'action_data' => $data['action_data'] ?? null,
        ]);
    }
}