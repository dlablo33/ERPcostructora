<?php

namespace App\Models\Config;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailConfig extends Model
{
   

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'email_config';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mailer',
        'host',
        'port',
        'encryption',
        'username',
        'password',
        'from_address',
        'from_name',
        'reply_to_address',
        'reply_to_name',
        'timeout',
        'max_emails_per_minute',
        'is_active',
        'is_verified',
        'verified_at',
        'last_test_at',
        'last_test_error',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'last_test_at' => 'datetime',
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
     * Get the mail configuration array for Laravel.
     */
    public function getMailConfigAttribute()
    {
        return [
            'driver' => $this->mailer,
            'host' => $this->host,
            'port' => $this->port,
            'encryption' => $this->encryption,
            'username' => $this->username,
            'password' => $this->password,
            'from' => [
                'address' => $this->from_address,
                'name' => $this->from_name,
            ],
            'reply_to' => [
                'address' => $this->reply_to_address,
                'name' => $this->reply_to_name,
            ],
        ];
    }

    /**
     * Scope a query to only include active configurations.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include verified configurations.
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Mark as verified.
     */
    public function markAsVerified()
    {
        $this->update([
            'is_verified' => true,
            'verified_at' => now(),
            'last_test_error' => null,
        ]);
    }

    /**
     * Mark as unverified with error.
     */
    public function markAsUnverified($error = null)
    {
        $this->update([
            'is_verified' => false,
            'last_test_error' => $error,
            'last_test_at' => now(),
        ]);
    }

    /**
     * Test the email configuration.
     */
    public function test($to = null)
    {
        $to = $to ?? $this->from_address;
        
        try {
            \Illuminate\Support\Facades\Mail::raw('Test email from ERP', function ($message) use ($to) {
                $message->to($to)
                    ->subject('Test de Configuración de Correo');
            });
            
            $this->markAsVerified();
            return ['success' => true, 'message' => 'Correo enviado correctamente'];
        } catch (\Exception $e) {
            $this->markAsUnverified($e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}