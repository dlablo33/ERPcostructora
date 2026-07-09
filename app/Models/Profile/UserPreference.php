<?php

namespace App\Models\Profile;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPreference extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_preferences';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'theme',
        'language',
        'timezone',
        'date_format',
        'time_format',
        'currency',
        'number_format',
        'notifications_email',
        'notifications_system',
        'notifications_whatsapp',
        'dashboard_widgets',
        'favorite_menus',
        'signature_path',
        'default_document_config',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'notifications_email' => 'boolean',
        'notifications_system' => 'boolean',
        'notifications_whatsapp' => 'boolean',
        'dashboard_widgets' => 'array',
        'favorite_menus' => 'array',
        'default_document_config' => 'array',
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
     * Get the user that owns the preference.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the full name of the user.
     */
    public function getUserNameAttribute()
    {
        return $this->user ? $this->user->name : null;
    }

    /**
     * Get the theme class for the user.
     */
    public function getThemeClassAttribute()
    {
        $themes = [
            'light' => 'light-mode',
            'dark' => 'dark-mode',
            'auto' => 'auto-mode',
        ];

        return $themes[$this->theme] ?? 'light-mode';
    }

    /**
     * Get the formatted date for the user.
     */
    public function formatDate($date)
    {
        if (!$date) {
            return null;
        }

        try {
            return \Carbon\Carbon::parse($date)->format($this->date_format ?? 'd/m/Y');
        } catch (\Exception $e) {
            return $date;
        }
    }

    /**
     * Get the formatted currency for the user.
     */
    public function formatCurrency($amount)
    {
        $symbols = [
            'MXN' => '$',
            'USD' => '$',
            'EUR' => '€',
        ];

        $symbol = $symbols[$this->currency] ?? '$';
        return $symbol . number_format($amount, 2, '.', ',');
    }

    /**
     * Get default preferences for a new user.
     */
    public static function getDefaults()
    {
        return [
            'theme' => 'light',
            'language' => 'es',
            'timezone' => 'America/Mexico_City',
            'date_format' => 'd/m/Y',
            'time_format' => 'H:i',
            'currency' => 'MXN',
            'number_format' => 'es',
            'notifications_email' => true,
            'notifications_system' => true,
            'notifications_whatsapp' => false,
            'dashboard_widgets' => null,
            'favorite_menus' => null,
        ];
    }

    /**
     * Create default preferences for a user.
     */
    public static function createDefaults($userId)
    {
        return self::create([
            'user_id' => $userId,
            ...self::getDefaults(),
        ]);
    }
}