<?php

namespace App\Models\Config;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecurityConfig extends Model
{
    

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'security_config';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'password_min_length',
        'password_max_length',
        'password_require_uppercase',
        'password_require_lowercase',
        'password_require_numbers',
        'password_require_special',
        'password_expiration_days',
        'password_history_count',
        'two_factor_enabled',
        'two_factor_method',
        'max_login_attempts',
        'lockout_time_minutes',
        'session_timeout_enabled',
        'session_timeout_minutes',
        'single_session_per_user',
        'ip_restriction_enabled',
        'allowed_ips',
        'user_agent_restriction_enabled',
        'audit_enabled',
        'audit_retention_days',
        'is_active',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'password_require_uppercase' => 'boolean',
        'password_require_lowercase' => 'boolean',
        'password_require_numbers' => 'boolean',
        'password_require_special' => 'boolean',
        'two_factor_enabled' => 'boolean',
        'session_timeout_enabled' => 'boolean',
        'single_session_per_user' => 'boolean',
        'ip_restriction_enabled' => 'boolean',
        'allowed_ips' => 'array',
        'user_agent_restriction_enabled' => 'boolean',
        'audit_enabled' => 'boolean',
        'is_active' => 'boolean',
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
     * Get the password requirements as an array.
     */
    public function getPasswordRequirementsAttribute()
    {
        return [
            'min_length' => $this->password_min_length,
            'max_length' => $this->password_max_length,
            'require_uppercase' => $this->password_require_uppercase,
            'require_lowercase' => $this->password_require_lowercase,
            'require_numbers' => $this->password_require_numbers,
            'require_special' => $this->password_require_special,
            'expiration_days' => $this->password_expiration_days,
            'history_count' => $this->password_history_count,
        ];
    }

    /**
     * Check if an IP is allowed.
     */
    public function isIpAllowed($ip)
    {
        if (!$this->ip_restriction_enabled) {
            return true;
        }

        if (empty($this->allowed_ips)) {
            return true;
        }

        return in_array($ip, $this->allowed_ips);
    }

    /**
     * Get the lockout time in minutes.
     */
    public function getLockoutMinutesAttribute()
    {
        return $this->lockout_time_minutes;
    }

    /**
     * Get the session timeout in minutes.
     */
    public function getSessionTimeoutMinutesAttribute()
    {
        return $this->session_timeout_enabled ? $this->session_timeout_minutes : 0;
    }
}