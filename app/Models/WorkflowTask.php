<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkflowTask extends Model
{
    use HasFactory, SoftDeletes; // Agregamos SoftDeletes

    protected $table = 'workflow_tasks';

    protected $fillable = [
        'module',
        'record_id',
        'title',
        'description',
        'created_by',
        'assigned_to',
        'status',
        'priority',
        'due_date',
        'metadata',        // ← NUEVO: Para guardar datos adicionales
        'completed_at'     // ← NUEVO: Para saber cuándo se completó
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'completed_at' => 'datetime',
        'metadata' => 'array'  // ← NUEVO: Para convertir metadata a array
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function logs()
    {
        return $this->hasMany(WorkflowLog::class);
    }

    // ← NUEVA RELACIÓN: Relación polimórfica con requisiciones
    public function taskable()
    {
        return $this->morphTo();
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    // ← NUEVOS SCOPES
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeByModule($query, $module)
    {
        return $query->where('module', $module);
    }

    public function scopeByRecord($query, $recordId)
    {
        return $query->where('record_id', $recordId);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    // ← NUEVOS HELPERS
    public function isInProgress()
    {
        return $this->status === 'in_progress';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Marca la tarea como completada
     */
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);
    }

    /**
     * Marca la tarea como en progreso
     */
    public function markAsInProgress()
    {
        $this->update([
            'status' => 'in_progress'
        ]);
    }

    /**
     * Obtiene el valor de un campo del metadata
     */
    public function getMetadataValue($key, $default = null)
    {
        return data_get($this->metadata, $key, $default);
    }

    /**
     * Verifica si la tarea tiene un tipo específico en metadata
     */
    public function hasMetadataType($type)
    {
        return $this->getMetadataValue('tipo') === $type;
    }

    /**
     * Obtiene la URL para la acción de la tarea
     */
    public function getActionUrl()
    {
        $module = $this->module;
        $recordId = $this->record_id;

        switch ($module) {
            case 'requisiciones':
                return route('requisiciones.show', $recordId);
            case 'cotizaciones':
                return route('cotizaciones.show', $recordId);
            default:
                return '#';
        }
    }

    /**
     * Obtiene el badge de módulo para mostrar en la vista
     */
    public function getModuleBadgeAttribute()
    {
        $badges = [
            'requisiciones' => '<span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs"><i class="fas fa-file-invoice mr-1"></i> Requisición</span>',
            'cotizaciones' => '<span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs"><i class="fas fa-file-pdf mr-1"></i> Cotización</span>',
            'orden_compra' => '<span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs"><i class="fas fa-shopping-cart mr-1"></i> Orden Compra</span>',
        ];

        return $badges[$this->module] ?? '<span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">' . ucfirst($this->module) . '</span>';
    }

    /**
     * Obtiene el color de prioridad para mostrar en la vista
     */
    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'high' => 'bg-red-100 text-red-800',
            'medium' => 'bg-yellow-100 text-yellow-800',
            'low' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Obtiene el label de prioridad
     */
    public function getPriorityLabelAttribute()
    {
        return match($this->priority) {
            'high' => 'Alta',
            'medium' => 'Media',
            'low' => 'Baja',
            default => ucfirst($this->priority)
        };
    }

    /**
     * Obtiene el color de estatus
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'in_progress' => 'bg-blue-100 text-blue-800',
            'completed' => 'bg-green-100 text-green-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Obtiene el label de estatus
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Pendiente',
            'in_progress' => 'En Progreso',
            'completed' => 'Completada',
            'approved' => 'Aprobada',
            'rejected' => 'Rechazada',
            default => ucfirst($this->status)
        };
    }

    /**
     * Obtiene el icono para el tipo de tarea
     */
    public function getTaskIconAttribute()
    {
        $type = $this->getMetadataValue('tipo');
        
        return match($type) {
            'requisicion_creada' => 'fa-file-invoice',
            'orden_compra' => 'fa-shopping-cart',
            'revision_cotizacion' => 'fa-file-pdf',
            default => 'fa-tasks'
        };
    }
}