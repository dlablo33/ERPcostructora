<?php

namespace App\Console\Commands;

use App\Models\ListaAsistencia;
use App\Models\DetalleListaAsistencia;
use App\Models\Plantilla;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GenerarListaAsistenciaDiaria extends Command
{
    protected $signature = 'asistencia:generar-lista {fecha?}';
    protected $description = 'Genera la lista de asistencia diaria para la fecha especificada o para hoy';

    public function handle()
    {
        $fecha = $this->argument('fecha') ?? date('Y-m-d');
        
        $this->info("==========================================");
        $this->info("Generando lista de asistencia para: " . $fecha);
        $this->info("==========================================");
        
        try {
            DB::beginTransaction();
            
            // Verificar si ya existe lista para esta fecha
            $existe = ListaAsistencia::where('fecha', $fecha)->exists();
            if ($existe) {
                $this->error("❌ Ya existe una lista de asistencia para la fecha {$fecha}");
                return 1;
            }
            
            // Obtener empleados activos usando el modelo Plantilla
            $empleados = Plantilla::where('estatus', 'Activo')
                ->orWhere('estatus', '1')
                ->get();
            
            if ($empleados->count() == 0) {
                $this->warn("⚠️ No hay empleados activos. Creando empleados de prueba...");
                
                for ($i = 1; $i <= 10; $i++) {
                    Plantilla::create([
                        'nombre' => 'Empleado ' . $i,
                        'apellido_paterno' => 'Apellido' . $i,
                        'apellido_materno' => 'Materno' . $i,
                        'estatus' => 'Activo',
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
                
                $empleados = Plantilla::where('estatus', 'Activo')->get();
                $this->info("✓ " . $empleados->count() . " empleados de prueba creados");
            }
            
            $this->info("✓ Empleados encontrados: " . $empleados->count());
            
            // Generar folio
            $fechaFormateada = date('Ymd', strtotime($fecha));
            $folio = ListaAsistencia::generarFolio($fecha);
            
            $this->info("Folio: {$folio}");
            
            // Crear la lista
            $lista = ListaAsistencia::create([
                'folio' => $folio,
                'fecha' => $fecha,
                'total_empleados' => $empleados->count(),
                'presentes' => 0,
                'retardos' => 0,
                'ausentes' => $empleados->count(),
                'justificados' => 0,
                'cerrada' => false,
                'creado_por' => auth()->id() ?? 1
            ]);
            
            $this->info("✓ Lista creada con ID: {$lista->id}");
            
            // Crear los detalles para cada empleado
            $contador = 0;
            foreach ($empleados as $emp) {
                // Obtener el puesto - usar la relación
                $puesto = $emp->puesto ? $emp->puesto->nombre : 'N/A';
                
                // Limitar a 100 caracteres
                $puesto = substr($puesto, 0, 100);
                
                // Construir nombre completo usando el accesor del modelo
                $nombreCompleto = $emp->nombre_completo;
                
                $this->info("  Procesando: {$nombreCompleto} - ID: {$emp->plantilla_id} - Puesto: {$puesto}");
                
                DetalleListaAsistencia::create([
                    'lista_asistencia_id' => $lista->id,
                    'empleado_id' => $emp->plantilla_id,
                    'empleado_nombre' => $nombreCompleto,
                    'puesto' => $puesto,
                    'hora_entrada' => null,
                    'hora_salida' => null,
                    'estado' => 'ausente',
                    'observaciones' => null,
                    'horas_trabajadas' => 0,
                    'justificado' => false
                ]);
                $contador++;
            }
            
            DB::commit();
            
            $this->info("==========================================");
            $this->info("✅ LISTA DE ASISTENCIA GENERADA EXITOSAMENTE!");
            $this->info("==========================================");
            $this->info("  📅 Fecha: " . date('d/m/Y', strtotime($fecha)));
            $this->info("  🆔 Folio: {$folio}");
            $this->info("  👥 Total empleados: {$contador}");
            $this->info("==========================================");
            
            return 0;
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ ERROR: " . $e->getMessage());
            $this->error("Detalles: " . $e->getTraceAsString());
            Log::error('Error en comando asistencia:generar-lista: ' . $e->getMessage());
            return 1;
        }
    }
}