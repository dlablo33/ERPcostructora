<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientTicket extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'client_tickets';

    protected $fillable = [
        'cliente_id',
        'titulo',
        'descripcion',
        'tipo',
        'prioridad',
        'estado',
        'soporte_id',
        'desarrollador_id',
        'tiempo_estimado',
        'tiempo_real',
        'motivo_rechazo',
        'info_requerida',
        'correcciones',
        'fecha_aprobacion',
        'fecha_asignacion',
        'fecha_inicio',
        'fecha_completado'
    ];

    protected $casts = [
        'fecha_aprobacion' => 'datetime',
        'fecha_asignacion' => 'datetime',
        'fecha_inicio' => 'datetime',
        'fecha_completado' => 'datetime',
        'tiempo_estimado' => 'integer',
        'tiempo_real' => 'integer'
    ];

    // ========== RELACIONES ==========

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function soporte()
    {
        return $this->belongsTo(User::class, 'soporte_id');
    }

    public function desarrollador()
    {
        return $this->belongsTo(DesarrolladorAcceso::class, 'desarrollador_id');
    }

    public function comentarios()
    {
        return $this->hasMany(TicketComentario::class)->orderBy('created_at', 'asc');
    }

    public function comentariosPublicos()
    {
        return $this->hasMany(TicketComentario::class)
            ->where('es_interno', false)
            ->orderBy('created_at', 'asc');
    }

    public function comentariosInternos()
    {
        return $this->hasMany(TicketComentario::class)
            ->where('es_interno', true)
            ->orderBy('created_at', 'asc');
    }

    public function archivos()
    {
        return $this->hasMany(TicketArchivo::class);
    }

    // ========== MÉTODOS DE ESTADO ==========

    public function isPending()
    {
        return $this->estado === 'pendiente';
    }

    public function isApproved()
    {
        return $this->estado === 'aprobado';
    }

    public function isInDevelopment()
    {
        return $this->estado === 'en_desarrollo';
    }

    public function isCompleted()
    {
        return $this->estado === 'completado';
    }

    public function isRejected()
    {
        return $this->estado === 'rechazado';
    }

    public function isInfoRequired()
    {
        return $this->estado === 'info_requerida';
    }

    // ========== MÉTODOS DE ACCIÓN ==========

    public function approve($soporteId)
    {
        $this->update([
            'estado' => 'aprobado',
            'soporte_id' => $soporteId,
            'fecha_aprobacion' => now()
        ]);

        // Agregar comentario automático
        $this->addComment(
            $soporteId,
            '✅ Ticket aprobado y enviado a desarrollo',
            true
        );
    }

    public function reject($soporteId, $motivo)
    {
        $this->update([
            'estado' => 'rechazado',
            'soporte_id' => $soporteId,
            'motivo_rechazo' => $motivo
        ]);

        $this->addComment(
            $soporteId,
            "❌ Ticket rechazado. Motivo: {$motivo}",
            false // Público para que el cliente vea
        );
    }

    public function requestInfo($soporteId, $pregunta)
    {
        $this->update([
            'estado' => 'info_requerida',
            'soporte_id' => $soporteId,
            'info_requerida' => $pregunta
        ]);

        $this->addComment(
            $soporteId,
            "🔍 Se requiere información adicional: {$pregunta}",
            false // Público para que el cliente vea
        );
    }

    public function assignToDeveloper($desarrolladorId, $tiempoEstimado = null)
    {
        $this->update([
            'desarrollador_id' => $desarrolladorId,
            'tiempo_estimado' => $tiempoEstimado,
            'fecha_asignacion' => now()
        ]);

        $this->addComment(
            $desarrolladorId,
            "👨‍💻 Ticket asignado a desarrollador",
            true // Interno
        );
    }

    public function startDevelopment($desarrolladorId)
    {
        $this->update([
            'estado' => 'en_desarrollo',
            'fecha_inicio' => now()
        ]);

        $this->addComment(
            $desarrolladorId,
            "🚀 Desarrollo iniciado",
            true // Interno
        );
    }

    public function completeDevelopment($desarrolladorId, $tiempoReal = null)
    {
        $this->update([
            'estado' => 'completado',
            'tiempo_real' => $tiempoReal,
            'fecha_completado' => now()
        ]);

        $this->addComment(
            $desarrolladorId,
            "✅ Desarrollo completado",
            true // Interno
        );
    }

    public function addComment($userId, $comentario, $esInterno = false)
    {
        return TicketComentario::create([
            'ticket_id' => $this->id,
            'user_id' => $userId,
            'comentario' => $comentario,
            'es_interno' => $esInterno
        ]);
    }

    // ========== SCOPES ==========

    public function scopeForClient($query, $clienteId)
    {
        return $query->where('cliente_id', $clienteId);
    }

    public function scopeForDeveloper($query, $desarrolladorId)
    {
        return $query->where('desarrollador_id', $desarrolladorId);
    }

    public function scopePendingReview($query)
    {
        return $query->whereIn('estado', ['pendiente', 'en_revision']);
    }

    public function scopeActive($query)
    {
        return $query->whereNotIn('estado', ['completado', 'rechazado', 'cancelado']);
    }
}