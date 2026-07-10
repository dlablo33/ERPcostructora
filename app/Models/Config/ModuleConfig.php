<?php

namespace App\Models\Config;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleConfig extends Model
{
    

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'module_config';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'display_name',
        'icon',
        'route',
        'is_enabled',
        'is_visible',
        'order',
        'required_roles',
        'settings',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_enabled' => 'boolean',
        'is_visible' => 'boolean',
        'required_roles' => 'array',
        'settings' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the user who created this record.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this record.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Check if the module is enabled.
     */
    public function isEnabled()
    {
        return $this->is_enabled && $this->is_visible;
    }

    /**
     * Check if a user can access this module.
     */
    public function userCanAccess($user)
    {
        if (!$this->isEnabled()) {
            return false;
        }

        if (empty($this->required_roles)) {
            return true;
        }

        return in_array($user->rol, $this->required_roles);
    }

    /**
     * Scope a query to only include enabled modules.
     */
    public function scopeEnabled($query)
    {
        return $query->where('is_enabled', true)->where('is_visible', true);
    }

    /**
     * Scope a query to only include visible modules.
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * Scope a query ordered by the order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Get all enabled modules for a user.
     */
    public static function getEnabledForUser($user)
    {
        return self::enabled()
            ->ordered()
            ->get()
            ->filter(function ($module) use ($user) {
                return $module->userCanAccess($user);
            });
    }
}