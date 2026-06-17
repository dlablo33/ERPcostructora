<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReporteFotograficoGrupo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reportes_fotograficos_grupos';

    protected $fillable = [
        'proyecto_id',
        'created_by',
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'estado'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $appends = [
        'estado_nombre',
        'total_fotos'
    ];

    // ==================== RELACIONES ====================

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function fotos()
    {
        return $this->belongsToMany(ReporteFotografico::class, 'reporte_fotos', 'reporte_id', 'foto_id')
            ->withPivot('orden')
            ->withTimestamps()
            ->orderBy('orden');
    }

    // ==================== ACCESSORS ====================

    public function getEstadoNombreAttribute(): string
    {
        $estados = [
            'borrador' => 'Borrador',
            'publicado' => 'Publicado',
            'archivado' => 'Archivado'
        ];
        return $estados[$this->estado] ?? $this->estado;
    }

    public function getTotalFotosAttribute(): int
    {
        return $this->fotos()->count();
    }

    // ==================== SCOPES ====================

    public function scopeByProyecto($query, $proyectoId)
    {
        if ($proyectoId) {
            return $query->where('proyecto_id', $proyectoId);
        }
        return $query;
    }

    public function scopePublicados($query)
    {
        return $query->where('estado', 'publicado');
    }

    public function scopeBorradores($query)
    {
        return $query->where('estado', 'borrador');
    }

    // ==================== MÉTODOS ====================

    public function agregarFoto(ReporteFotografico $foto, int $orden = null): void
    {
        $this->fotos()->attach($foto->id, [
            'orden' => $orden ?? $this->fotos()->count() + 1
        ]);
    }

    public function removerFoto(ReporteFotografico $foto): void
    {
        $this->fotos()->detach($foto->id);
    }

    public function publicar(): bool
    {
        $this->estado = 'publicado';
        return $this->save();
    }

    public function archivar(): bool
    {
        $this->estado = 'archivado';
        return $this->save();
    }
}