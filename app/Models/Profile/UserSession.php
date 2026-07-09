<?php

namespace App\Models\Profile;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_sessions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'session_id',
        'ip_address',
        'user_agent',
        'device_type',
        'browser',
        'browser_version',
        'platform',
        'country',
        'city',
        'is_active',
        'is_current',
        'last_activity',
        'expires_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_current' => 'boolean',
        'last_activity' => 'datetime',
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'session_id',
    ];

    /**
     * Get the user that owns the session.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the device icon class.
     */
    public function getDeviceIconAttribute()
    {
        $icons = [
            'desktop' => 'fa-desktop',
            'mobile' => 'fa-mobile-alt',
            'tablet' => 'fa-tablet-alt',
        ];

        return $icons[$this->device_type] ?? 'fa-laptop';
    }

    /**
     * Get the device label.
     */
    public function getDeviceLabelAttribute()
    {
        $labels = [
            'desktop' => 'Computadora',
            'mobile' => 'Teléfono',
            'tablet' => 'Tableta',
        ];

        return $labels[$this->device_type] ?? 'Dispositivo';
    }

    /**
     * Get the browser icon class.
     */
    public function getBrowserIconAttribute()
    {
        $icons = [
            'Chrome' => 'fa-chrome',
            'Firefox' => 'fa-firefox',
            'Safari' => 'fa-safari',
            'Edge' => 'fa-edge',
            'Opera' => 'fa-opera',
        ];

        return $icons[$this->browser] ?? 'fa-globe';
    }

    /**
     * Get the platform icon class.
     */
    public function getPlatformIconAttribute()
    {
        $icons = [
            'Windows' => 'fa-windows',
            'macOS' => 'fa-apple',
            'Linux' => 'fa-linux',
            'iOS' => 'fa-apple',
            'Android' => 'fa-android',
        ];

        return $icons[$this->platform] ?? 'fa-microchip';
    }

    /**
     * Get the last activity human readable.
     */
    public function getLastActivityHumanAttribute()
    {
        if (!$this->last_activity) {
            return 'Nunca';
        }

        return $this->last_activity->diffForHumans();
    }

    /**
     * Scope a query to only include active sessions.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include current session.
     */
    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }

    /**
     * Check if session is expired.
     */
    public function isExpired()
    {
        if (!$this->expires_at) {
            return false;
        }

        return $this->expires_at->isPast();
    }

    /**
     * Terminate a session.
     */
    public function terminate()
    {
        $this->update([
            'is_active' => false,
        ]);
    }

    /**
     * Parse user agent to detect device.
     */
    public static function parseUserAgent($userAgent)
    {
        $data = [
            'device_type' => 'desktop',
            'browser' => null,
            'browser_version' => null,
            'platform' => null,
        ];

        if (empty($userAgent)) {
            return $data;
        }

        // Detect mobile
        if (preg_match('/Mobile|Android|iPhone|iPad/i', $userAgent)) {
            $data['device_type'] = 'mobile';
        }

        // Detect tablet
        if (preg_match('/iPad|Tablet/i', $userAgent)) {
            $data['device_type'] = 'tablet';
        }

        // Detect browser
        if (preg_match('/Chrome\/(\d+)/i', $userAgent, $matches)) {
            $data['browser'] = 'Chrome';
            $data['browser_version'] = $matches[1];
        } elseif (preg_match('/Firefox\/(\d+)/i', $userAgent, $matches)) {
            $data['browser'] = 'Firefox';
            $data['browser_version'] = $matches[1];
        } elseif (preg_match('/Safari\/(\d+)/i', $userAgent, $matches)) {
            $data['browser'] = 'Safari';
            $data['browser_version'] = $matches[1];
        } elseif (preg_match('/Edge\/(\d+)/i', $userAgent, $matches)) {
            $data['browser'] = 'Edge';
            $data['browser_version'] = $matches[1];
        } elseif (preg_match('/Opera\/(\d+)/i', $userAgent, $matches)) {
            $data['browser'] = 'Opera';
            $data['browser_version'] = $matches[1];
        }

        // Detect platform
        if (preg_match('/Windows/i', $userAgent)) {
            $data['platform'] = 'Windows';
        } elseif (preg_match('/macOS|Mac OS X/i', $userAgent)) {
            $data['platform'] = 'macOS';
        } elseif (preg_match('/Linux/i', $userAgent)) {
            $data['platform'] = 'Linux';
        } elseif (preg_match('/iOS|iPhone|iPad/i', $userAgent)) {
            $data['platform'] = 'iOS';
        } elseif (preg_match('/Android/i', $userAgent)) {
            $data['platform'] = 'Android';
        }

        return $data;
    }
}