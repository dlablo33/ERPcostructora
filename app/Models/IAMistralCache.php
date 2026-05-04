<?php
// app/Models/IAMistralCache.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IAMistralCache extends Model
{
    protected $table = 'ia_mistral_cache';
    
    protected $fillable = [
        'user_question', 'ai_response', 'context_hash', 'expires_at'
    ];
    
    protected $casts = [
        'expires_at' => 'datetime'
    ];
}