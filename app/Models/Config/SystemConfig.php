<?php

namespace App\Models\Config;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemConfig extends Model
{
    

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'system_config';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
        'label',
        'description',
        'order',
        'is_editable',
        'is_visible',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_editable' => 'boolean',
        'is_visible' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the user who created this config.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this config.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the value cast to the correct type.
     */
    public function getTypedValueAttribute()
    {
        return match ($this->type) {
            'boolean' => filter_var($this->value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $this->value,
            'float' => (float) $this->value,
            'json' => json_decode($this->value, true),
            'array' => json_decode($this->value, true),
            'file' => $this->value,
            default => $this->value,
        };
    }

    /**
     * Set the value with proper type handling.
     */
    public function setValueAttribute($value)
    {
        if ($this->type === 'json' || $this->type === 'array') {
            $this->attributes['value'] = is_array($value) ? json_encode($value) : $value;
        } else {
            $this->attributes['value'] = $value;
        }
    }

    /**
     * Scope a query to only include configs from a specific group.
     */
    public function scopeGroup($query, $group)
    {
        return $query->where('group', $group);
    }

    /**
     * Scope a query to only include editable configs.
     */
    public function scopeEditable($query)
    {
        return $query->where('is_editable', true);
    }

    /**
     * Scope a query to only include visible configs.
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * Get a config value by key.
     */
    public static function getValue($key, $default = null)
    {
        $config = self::where('key', $key)->first();
        return $config ? $config->typed_value : $default;
    }

    /**
     * Set a config value by key.
     */
    public static function setValue($key, $value)
    {
        $config = self::where('key', $key)->first();
        if ($config) {
            $config->value = $value;
            $config->save();
            return $config;
        }
        return self::create(['key' => $key, 'value' => $value]);
    }

    /**
     * Get all configs grouped by their group.
     */
    public static function getGrouped()
    {
        return self::orderBy('order')
            ->get()
            ->groupBy('group');
    }
}