<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaAsistencia extends Model
{
    use HasFactory;

    protected $table = 'listas_asistencia';

    protected $fillable = [
        'folio',
        'fecha',
        'total_empleados',
        'presentes',
        'retardos',
        'ausentes',
        'justificados',
        'cerrada',
        'fecha_cierre',
        'observaciones_generales',
        'creado_por'
    ];

    protected $casts = [
        'fecha' => 'date',
        'fecha_cierre' => 'datetime',
        'cerrada' => 'boolean',
        'total_empleados' => 'integer',
        'presentes' => 'integer',
        'retardos' => 'integer',
        'ausentes' => 'integer',
        'justificados' => 'integer'
    ];

    // Relación con los detalles
    public function detalles()
    {
        return $this->hasMany(DetalleListaAsistencia::class, 'lista_asistencia_id');
    }

    // Scope por fecha
    public function scopePorFecha($query, $fecha)
    {
        return $query->whereDate('fecha', $fecha);
    }

    // Scope por rango de fechas
    public function scopePorRangoFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
    }

    // Generar folio automático
    public static function generarFolio($fecha)
    {
        $fechaFormateada = date('Ymd', strtotime($fecha));
        $ultimo = self::where('folio', 'LIKE', "LIS-{$fechaFormateada}%")
            ->orderBy('id', 'desc')
            ->first();
        
        if ($ultimo) {
            $numero = intval(substr($ultimo->folio, -4)) + 1;
            $numero = str_pad($numero, 4, '0', STR_PAD_LEFT);
        } else {
            $numero = '0001';
        }
        
        return "LIS-{$fechaFormateada}-{$numero}";
    }

    // Actualizar estadísticas
    public function actualizarEstadisticas()
    {
        $this->total_empleados = $this->detalles()->count();
        $this->presentes = $this->detalles()->where('estado', 'presente')->count();
        $this->retardos = $this->detalles()->where('estado', 'retardo')->count();
        $this->ausentes = $this->detalles()->where('estado', 'ausente')->count();
        $this->justificados = $this->detalles()->where('estado', 'justificado')->count();
        $this->save();
        
        return $this;
    }
}