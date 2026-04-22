<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activo extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $table = 'activos';
    
    protected $fillable = [
        'codigo',
        'nombre',
        'tipo_activo',
        'categoria',
        'marca',
        'modelo',
        'serie',
        'anio',
        'color',
        'ubicacion_fisica',
        'proyecto_asignado_id',
        'fecha_asignacion',
        'responsable_asignado_id',
        'estado_general',
        'estatus',
        'fecha_adquisicion',
        'costo_adquisicion',
        'valor_actual',
        'proveedor_id',
        'factura',
        'cuenta_contable',
        'descripcion',
        'observaciones',
        'created_by'
    ];
    
    protected $casts = [
        'anio' => 'integer',
        'fecha_asignacion' => 'date',
        'fecha_adquisicion' => 'date',
        'costo_adquisicion' => 'decimal:2',
        'valor_actual' => 'decimal:2'
    ];
    
    // Relaciones polimórficas con tablas complementarias
    public function herramienta()
    {
        return $this->hasOne(ActivoHerramienta::class);
    }
    
    public function maquinaria()
    {
        return $this->hasOne(ActivoMaquinaria::class);
    }
    
    public function vehiculo()
    {
        return $this->hasOne(ActivoVehiculo::class);
    }
    
    // Relaciones comunes
    public function proyectoAsignado()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_asignado_id');
    }
    
    public function responsableAsignado()
    {
        return $this->belongsTo(User::class, 'responsable_asignado_id');
    }
    
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
    
    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function requisiciones()
    {
        return $this->hasMany(RequisicionActivo::class);
    }
    
    public function asignaciones()
    {
        return $this->hasMany(AsignacionActivo::class);
    }
    
    public function movimientos()
    {
        return $this->hasMany(MovimientoActivo::class);
    }
    
    // Accessors
    public function getNombreCompletoAttribute()
    {
        return $this->codigo . ' - ' . $this->nombre;
    }
    
    public function getEstaDisponibleAttribute()
    {
        return $this->estatus === 'Disponible';
    }
    
    public function getEstaAsignadoAttribute()
    {
        return $this->estatus === 'Asignado';
    }
    
    // Scopes
    public function scopeDisponibles($query)
    {
        return $query->where('estatus', 'Disponible');
    }
    
    public function scopeAsignados($query)
    {
        return $query->where('estatus', 'Asignado');
    }
    
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo_activo', $tipo);
    }
    
    // Métodos
    public function getDatosEspecificos()
    {
        switch ($this->tipo_activo) {
            case 'herramienta':
                return $this->herramienta;
            case 'maquinaria':
                return $this->maquinaria;
            case 'vehiculo':
                return $this->vehiculo;
            default:
                return null;
        }
    }
    
    public static function generarCodigo($tipoActivo)
    {
        $prefijos = [
            'herramienta' => 'HER',
            'maquinaria' => 'MAQ',
            'vehiculo' => 'VEH'
        ];
        
        $prefijo = $prefijos[$tipoActivo] ?? 'ACT';
        
        $ultimo = self::withTrashed()->where('codigo', 'LIKE', "{$prefijo}-%")
            ->orderBy('id', 'desc')
            ->first();
            
        if ($ultimo && $ultimo->codigo) {
            $numero = intval(substr($ultimo->codigo, 4)) + 1;
        } else {
            $numero = 1;
        }
        
        return $prefijo . '-' . str_pad($numero, 5, '0', STR_PAD_LEFT);
    }
}