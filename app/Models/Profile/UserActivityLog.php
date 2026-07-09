<?php

namespace App\Models\Profile;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserActivityLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_activity_log';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
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
     * Get the time ago for the activity.
     */
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get the action label.
     */
    public function getActionLabelAttribute()
    {
        $labels = [
            'login' => 'Inicio de sesión',
            'logout' => 'Cierre de sesión',
            'update_profile' => 'Actualizó perfil',
            'change_password' => 'Cambió contraseña',
            'update_preferences' => 'Actualizó preferencias',
            'create' => 'Creó',
            'update' => 'Actualizó',
            'delete' => 'Eliminó',
            'restore' => 'Restauró',
        ];

        return $labels[$this->action] ?? $this->action;
    }

    /**
     * Get the action color.
     */
    public function getActionColorAttribute()
    {
        $colors = [
            'login' => 'green',
            'logout' => 'gray',
            'update_profile' => 'blue',
            'change_password' => 'orange',
            'update_preferences' => 'purple',
            'create' => 'green',
            'update' => 'blue',
            'delete' => 'red',
            'restore' => 'green',
        ];

        return $colors[$this->action] ?? 'gray';
    }

    /**
     * Get the action icon.
     */
    public function getActionIconAttribute()
    {
        $icons = [
            'login' => 'fa-sign-in-alt',
            'logout' => 'fa-sign-out-alt',
            'update_profile' => 'fa-user-edit',
            'change_password' => 'fa-key',
            'update_preferences' => 'fa-sliders-h',
            'create' => 'fa-plus-circle',
            'update' => 'fa-edit',
            'delete' => 'fa-trash',
            'restore' => 'fa-undo',
        ];

        return $icons[$this->action] ?? 'fa-clock';
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