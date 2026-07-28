<?php
// app/Models/PushSubscription.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PushSubscription extends Model
{
    protected $fillable = [
        'user_id',
        'endpoint',
        'keys',
        'expiration_time'
    ];
    
    protected $casts = [
        'keys' => 'array',
        'expiration_time' => 'datetime'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}