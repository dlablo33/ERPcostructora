<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkflowLog extends Model
{
    use HasFactory;

    protected $table = 'workflow_logs';

    protected $fillable = [
        'workflow_task_id',
        'user_id',
        'action',
        'comments'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function task()
    {
        return $this->belongsTo(WorkflowTask::class, 'workflow_task_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}