<?php

namespace App\Models\Profile;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class UserApiToken extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_api_tokens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'token',
        'abilities',
        'client_name',
        'client_ip',
        'client_user_agent',
        'is_active',
        'last_used_at',
        'expires_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'abilities' => 'array',
        'is_active' => 'boolean',
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
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
        'token',
        'deleted_at',
    ];

    /**
     * Get the user that owns the token.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the token mask (first and last 4 characters).
     */
    public function getTokenMaskAttribute()
    {
        if (strlen($this->token) < 8) {
            return $this->token;
        }

        $first = substr($this->token, 0, 4);
        $last = substr($this->token, -4);
        $stars = str_repeat('*', strlen($this->token) - 8);

        return $first . $stars . $last;
    }

    /**
     * Get the token short (last 8 characters).
     */
    public function getTokenShortAttribute()
    {
        return '...' . substr($this->token, -8);
    }

    /**
     * Check if token is expired.
     */
    public function isExpired()
    {
        if (!$this->expires_at) {
            return false;
        }

        return $this->expires_at->isPast();
    }

    /**
     * Check if token is active.
     */
    public function isActive()
    {
        return $this->is_active && !$this->isExpired();
    }

    /**
     * Revoke the token.
     */
    public function revoke()
    {
        $this->update([
            'is_active' => false,
        ]);
    }

    /**
     * Update last used timestamp.
     */
    public function touchLastUsed()
    {
        $this->update([
            'last_used_at' => now(),
        ]);
    }

    /**
     * Generate a new token string.
     */
    public static function generateToken()
    {
        return Str::random(60);
    }

    /**
     * Scope a query to only include active tokens.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            });
    }

    /**
     * Scope a query to only include expired tokens.
     */
    public function scopeExpired($query)
    {
        return $query->where('is_active', true)
            ->where('expires_at', '<=', now());
    }

    /**
     * Scope a query to only include revoked tokens.
     */
    public function scopeRevoked($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Create a new API token for a user.
     */
    public static function createToken($userId, $name, $abilities = null, $expiresInDays = null)
    {
        $token = self::generateToken();

        return self::create([
            'user_id' => $userId,
            'name' => $name,
            'token' => hash('sha256', $token),
            'abilities' => $abilities,
            'expires_at' => $expiresInDays ? now()->addDays($expiresInDays) : null,
        ]);
    }
}