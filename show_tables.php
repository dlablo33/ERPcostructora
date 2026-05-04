<?php
// Habilitar output buffering para capturar todo
ob_start();

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

$output = "";

$output .= "=== BASES DE DATOS Y TABLAS ===\n\n";
$output .= "Fecha: " . date('Y-m-d H:i:s') . "\n";
$output .= "Conexión: " . DB::connection()->getDatabaseName() . "\n\n";

// Obtener todas las tablas
$tables = DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public' AND table_type = 'BASE TABLE' ORDER BY table_name");

$output .= "=== TABLAS ENCONTRADAS ===\n";
$output .= "Total de tablas: " . count($tables) . "\n\n";

foreach ($tables as $table) {
    $tableName = $table->table_name;
    $output .= "\n📋 TABLA: $tableName\n";
    $output .= str_repeat("-", 70) . "\n";
    
    try {
        $columns = Schema::getColumnListing($tableName);
        $output .= "Columnas (" . count($columns) . "):\n";
        foreach ($columns as $column) {
            $output .= "  • $column\n";
        }
    } catch (\Exception $e) {
        $output .= "  Error: " . $e->getMessage() . "\n";
    }
}

// Mostrar específicamente las tablas que nos interesan
$importantTables = ['proyectos', 'nominas', 'plantillas', 'activo_maquinarias', 'activo_vehiculos', 'activo_herramientas', 'proyecto_costos', 'proyecto_partidas', 'cuentas_por_pagar', 'cuentas_por_cobrar', 'nomina_deduccions', 'nomina_percepcions'];

$output .= "\n\n" . str_repeat("=", 70) . "\n";
$output .= "=== TABLAS IMPORTANTES (DETALLE COMPLETO) ===\n";
$output .= str_repeat("=", 70) . "\n";

foreach ($importantTables as $table) {
    $output .= "\n🔍 TABLA: $table\n";
    $output .= str_repeat("-", 70) . "\n";
    
    if (Schema::hasTable($table)) {
        $columns = Schema::getColumnListing($table);
        $output .= "✓ Tabla existe\n";
        $output .= "Columnas encontradas (" . count($columns) . "):\n";
        
        foreach ($columns as $column) {
            // Intentar obtener el tipo de dato
            try {
                $type = DB::select("SELECT data_type, is_nullable, column_default FROM information_schema.columns WHERE table_name = '$table' AND column_name = '$column'");
                if (!empty($type)) {
                    $typeInfo = $type[0]->data_type ?? 'unknown';
                    $nullable = $type[0]->is_nullable == 'YES' ? 'NULL' : 'NOT NULL';
                    $default = $type[0]->column_default ? " DEFAULT " . $type[0]->column_default : '';
                    $output .= "  • $column : $typeInfo ($nullable)$default\n";
                } else {
                    $output .= "  • $column\n";
                }
            } catch (\Exception $e) {
                $output .= "  • $column\n";
            }
        }
        
        // Mostrar 3 registros de ejemplo
        $sample = DB::table($table)->limit(3)->get();
        if ($sample->count() > 0) {
            $output .= "\n📊 Ejemplo de datos (primeros 3 registros):\n";
            $counter = 1;
            foreach ($sample as $row) {
                $output .= "\n  Registro $counter:\n";
                $rowArray = (array)$row;
                $displayed = 0;
                foreach ($rowArray as $key => $value) {
                    if ($displayed < 8) { // Mostrar máximo 8 campos por registro
                        $valueStr = is_string($value) ? substr($value, 0, 60) : (string)$value;
                        if ($valueStr === "") $valueStr = "[vacío]";
                        if ($valueStr === "0") $valueStr = "0";
                        $output .= "    $key: $valueStr\n";
                        $displayed++;
                    }
                }
                if (count($rowArray) > 8) {
                    $output .= "    ... y " . (count($rowArray) - 8) . " campos más\n";
                }
                $counter++;
            }
        } else {
            $output .= "\n📊 No hay datos en esta tabla\n";
        }
    } else {
        $output .= "❌ Tabla NO existe\n";
    }
}

$output .= "\n" . str_repeat("=", 70) . "\n";
$output .= "✅ Script completado exitosamente\n";
$output .= "Total de tablas analizadas: " . count($tables) . "\n";

// Guardar en archivo
$filename = __DIR__ . '/database_schema_' . date('Y-m-d_H-i-s') . '.txt';
file_put_contents($filename, $output);

// También mostrar en consola
echo $output;
echo "\n\n📁 Archivo guardado en: " . $filename . "\n";
