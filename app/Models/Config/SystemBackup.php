<?php

namespace App\Models\Config;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemBackup extends Model
{
    

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'system_backups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'file_path',
        'file_name',
        'file_size',
        'metadata',
        'description',
        'status',
        'completed_at',
        'error_message',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'metadata' => 'array',
        'file_size' => 'integer',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the user who created this backup.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the formatted file size.
     */
    public function getFormattedSizeAttribute()
    {
        if (!$this->file_size) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;
        
        while ($this->file_size >= 1024 && $i < count($units) - 1) {
            $this->file_size /= 1024;
            $i++;
        }
        
        return round($this->file_size, 2) . ' ' . $units[$i];
    }

    /**
     * Get the download URL.
     */
    public function getDownloadUrlAttribute()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }

    /**
     * Check if the backup is completed.
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if the backup is failed.
     */
    public function isFailed()
    {
        return $this->status === 'failed';
    }

    /**
     * Check if the backup is pending.
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Scope a query to only include completed backups.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include pending backups.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include failed backups.
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Scope a query by type.
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Mark backup as completed.
     */
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'error_message' => null,
        ]);
    }

    /**
     * Mark backup as failed.
     */
    public function markAsFailed($error)
    {
        $this->update([
            'status' => 'failed',
            'completed_at' => now(),
            'error_message' => $error,
        ]);
    }

    /**
     * Mark backup as in progress.
     */
    public function markAsInProgress()
    {
        $this->update([
            'status' => 'in_progress',
            'error_message' => null,
        ]);
    }

    /**
     * Delete the backup file from storage.
     */
    public function deleteFile()
    {
        if ($this->file_path && file_exists(storage_path('app/public/' . $this->file_path))) {
            unlink(storage_path('app/public/' . $this->file_path));
        }
    }
}