<?php
// app/Models/IAKnowledgeBase.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IAKnowledgeBase extends Model
{
    protected $table = 'ia_knowledge_base';
    
    protected $fillable = [
        'keyword', 'module_name', 'response_text', 'method_name',
        'controller_class', 'confidence_score', 'times_used', 'last_used_at'
    ];
    
    protected $casts = [
        'last_used_at' => 'datetime',
        'confidence_score' => 'integer',
        'times_used' => 'integer'
    ];
}