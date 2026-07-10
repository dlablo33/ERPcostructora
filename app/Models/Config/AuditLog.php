<?php

namespace App\Models\Config;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'audit_log';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'action',
        'module',
        'section',
        'subsection',
        'old_values',
        'new_values',
        'metadata',
        'ip_address',
        'user_agent',
        'session_id',
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
     * Get the user who performed the action.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the action description.
     */
    public function getDescriptionAttribute()
    {
        $descriptions = [
            'create' => 'Creó',
            'update' => 'Actualizó',
            'delete' => 'Eliminó',
            'restore' => 'Restauró',
            'login' => 'Inició sesión',
            'logout' => 'Cerró sesión',
            'config_update' => 'Actualizó configuración',
            'module_toggle' => 'Cambió estado de módulo',
        ];

        return $descriptions[$this->action] ?? $this->action;
    }

    /**
     * Get the action icon.
     */
    public function getActionIconAttribute()
    {
        $icons = [
            'create' => 'fa-plus-circle',
            'update' => 'fa-edit',
            'delete' => 'fa-trash',
            'restore' => 'fa-undo',
            'login' => 'fa-sign-in-alt',
            'logout' => 'fa-sign-out-alt',
            'config_update' => 'fa-cog',
            'module_toggle' => 'fa-toggle-on',
        ];

        return $icons[$this->action] ?? 'fa-clock';
    }

    /**
     * Get the action color.
     */
    public function getActionColorAttribute()
    {
        $colors = [
            'create' => 'green',
            'update' => 'blue',
            'delete' => 'red',
            'restore' => 'green',
            'login' => 'blue',
            'logout' => 'gray',
            'config_update' => 'purple',
            'module_toggle' => 'orange',
        ];

        return $colors[$this->action] ?? 'gray';
    }

    /**
     * Log an audit entry.
     */
    public static function log($userId, $action, $data = [])
    {
        return self::create([
            'user_id' => $userId,
            'action' => $action,
            'module' => $data['module'] ?? null,
            'section' => $data['section'] ?? null,
            'subsection' => $data['subsection'] ?? null,
            'old_values' => $data['old_values'] ?? null,
            'new_values' => $data['new_values'] ?? null,
            'metadata' => $data['metadata'] ?? null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'session_id' => session()->getId(),
        ]);
    }

    /**
     * Scope a query by module.
     */
    public function scopeModule($query, $module)
    {
        return $query->where('module', $module);
    }

    /**
     * Scope a query by action.
     */
    public function scopeAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope a query by user.
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include recent logs.
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}