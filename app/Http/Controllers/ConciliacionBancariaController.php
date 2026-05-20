<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Reader\Xls as XlsReader;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Reader\Csv as CsvReader;

class ConciliacionBancariaController extends Controller
{
    public function index()
    {
        Log::info('=== CONCILIACION BANCARIA - INDEX ===');
        
        $cuentasBancarias = DB::table('cuentas_bancarias')
            ->join('bancos', 'cuentas_bancarias.banco_id', '=', 'bancos.id')
            ->select('cuentas_bancarias.id', 'bancos.nombre as banco', 'cuentas_bancarias.numero_cuenta', 'cuentas_bancarias.saldo_actual')
            ->where('cuentas_bancarias.activa', true)
            ->get();
        
        Log::info('Cuentas bancarias encontradas: ' . $cuentasBancarias->count());
        
        return view('administracion.tesoreria.conciliacion', compact('cuentasBancarias'));
    }
    
    /**
     * Obtener movimientos del sistema desde movimientos_bancarios
     */
    public function getMovimientosSistema(Request $request)
    {
        Log::info('=== getMovimientosSistema INICIO ===');
        
        try {
            $cuentaId = $request->cuenta_id;
            $fechaInicio = $request->fecha_inicio;
            $fechaFin = $request->fecha_fin;
            
            Log::info("Parámetros:", compact('cuentaId', 'fechaInicio', 'fechaFin'));
            
            $movimientos = DB::table('movimientos_bancarios')
                ->select(
                    'id',
                    'fecha',
                    'concepto as descripcion',
                    'referencia',
                    DB::raw("CASE WHEN tipo = 'egreso' THEN monto ELSE 0 END as egreso"),
                    DB::raw("CASE WHEN tipo = 'ingreso' THEN monto ELSE 0 END as ingreso"),
                    'referencia as numero_transaccion'
                )
                ->where('cuenta_bancaria_id', $cuentaId)
                ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                ->where('status', 'aplicado')
                ->orderBy('fecha')
                ->get();
            
            $totalIngresos = $movimientos->sum('ingreso');
            $totalEgresos = $movimientos->sum('egreso');
            
            Log::info("Movimientos encontrados: " . $movimientos->count());
            
            return response()->json([
                'success' => true,
                'data' => $movimientos,
                'total_ingresos' => $totalIngresos,
                'total_egresos' => $totalEgresos,
                'total_movimientos' => $movimientos->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error getMovimientosSistema: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Subir y procesar Excel del extracto bancario
     */
    public function uploadExcel(Request $request)
    {
        Log::info('=== uploadExcel INICIO ===');
        
        try {
            $request->validate([
                'archivo_excel' => 'required|file|mimes:xlsx,xls,csv',
                'cuenta_id' => 'required|exists:cuentas_bancarias,id',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date'
            ]);
            
            $file = $request->file('archivo_excel');
            $extension = $file->getClientOriginalExtension();
            Log::info("Archivo recibido: " . $file->getClientOriginalName() . " (Extensión: {$extension})");
            
            // Guardar archivo
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $filePath = $file->storeAs('conciliacion', $fileName, 'public');
            Log::info("Archivo guardado en: " . $filePath);
            
            // Leer el archivo según su extensión
            $spreadsheet = null;
            
            if ($extension === 'xls') {
                Log::info("Usando lector XLS");
                $reader = new XlsReader();
                $spreadsheet = $reader->load($file->getPathname());
            } elseif ($extension === 'xlsx') {
                Log::info("Usando lector XLSX");
                $reader = new XlsxReader();
                $spreadsheet = $reader->load($file->getPathname());
            } elseif ($extension === 'csv') {
                Log::info("Usando lector CSV");
                $reader = new CsvReader();
                $reader->setDelimiter(',');
                $reader->setEnclosure('"');
                $reader->setSheetIndex(0);
                $spreadsheet = $reader->load($file->getPathname());
            } else {
                throw new \Exception("Formato de archivo no soportado: {$extension}");
            }
            
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            
            Log::info("Total filas en archivo: " . count($rows));
            
            // Saltar encabezado (primera fila)
            $headers = array_shift($rows);
            Log::info("Encabezados detectados: ", $headers);
            
            $movimientosExtracto = [];
            $totalIngresos = 0;
            $totalEgresos = 0;
            $errores = [];
            
            foreach ($rows as $index => $row) {
                // Limpiar fila vacía
                if (empty(array_filter($row))) {
                    continue;
                }
                
                try {
                    // Obtener valores con índices seguros
                    $fechaRaw = $row[0] ?? null;
                    $descripcion = $row[1] ?? '';
                    $referencia = $row[2] ?? null;
                    $egresoRaw = $row[3] ?? 0;
                    $ingresoRaw = $row[4] ?? 0;
                    $numeroTransaccion = $row[5] ?? $row[2] ?? null;
                    
                    // Parsear fecha
                    $fecha = $this->parseFecha($fechaRaw);
                    
                    // Parsear montos (quitar $, comas, espacios)
                    $egreso = $this->parseMonto($egresoRaw);
                    $ingreso = $this->parseMonto($ingresoRaw);
                    
                    Log::debug("Fila " . ($index + 2) . ": fecha={$fecha}, descripcion={$descripcion}, egreso={$egreso}, ingreso={$ingreso}");
                    
                    $totalIngresos += $ingreso;
                    $totalEgresos += $egreso;
                    
                    $movimientosExtracto[] = [
                        'id' => 'ext_' . ($index + 1),
                        'origen' => 'extracto',
                        'fecha' => $fecha,
                        'descripcion' => $descripcion,
                        'referencia' => $referencia,
                        'egreso' => $egreso,
                        'ingreso' => $ingreso,
                        'numero_transaccion' => $numeroTransaccion,
                        'conciliado' => false,
                        'conciliado_con' => null
                    ];
                } catch (\Exception $e) {
                    $errorMsg = "Error en fila " . ($index + 2) . ": " . $e->getMessage();
                    Log::warning($errorMsg);
                    $errores[] = $errorMsg;
                }
            }
            
            Log::info("Movimientos procesados: " . count($movimientosExtracto));
            Log::info("Totales - Ingresos: {$totalIngresos}, Egresos: {$totalEgresos}");
            
            // Guardar en sesión
            session(['movimientos_extracto' => $movimientosExtracto]);
            session(['archivo_excel' => $fileName]);
            
            return response()->json([
                'success' => true,
                'data' => $movimientosExtracto,
                'total_ingresos' => $totalIngresos,
                'total_egresos' => $totalEgresos,
                'total_movimientos' => count($movimientosExtracto),
                'errores' => $errores
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error uploadExcel: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el archivo: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Parsear fecha a formato Y-m-d
     */
    private function parseFecha($fecha)
    {
        if (!$fecha) {
            return date('Y-m-d');
        }
        
        // Si es número (fecha de Excel)
        if (is_numeric($fecha)) {
            try {
                return date('Y-m-d', Date::excelToTimestamp($fecha));
            } catch (\Exception $e) {
                Log::warning("Error parseando fecha numérica: {$fecha}");
                return date('Y-m-d');
            }
        }
        
        // Convertir a string y limpiar
        $fechaStr = trim((string)$fecha);
        
        // Si ya está en formato Y-m-d
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $fechaStr)) {
            return $fechaStr;
        }
        
        // Formato dd/mm/yyyy
        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $fechaStr)) {
            $parts = explode('/', $fechaStr);
            return "{$parts[2]}-{$parts[1]}-{$parts[0]}";
        }
        
        // Formato dd/mm/yy
        if (preg_match('/^\d{2}\/\d{2}\/\d{2}$/', $fechaStr)) {
            $parts = explode('/', $fechaStr);
            $year = $parts[2] < 30 ? '20' . $parts[2] : '19' . $parts[2];
            return "{$year}-{$parts[1]}-{$parts[0]}";
        }
        
        // Formato dd-mm-yyyy
        if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $fechaStr)) {
            $parts = explode('-', $fechaStr);
            return "{$parts[2]}-{$parts[1]}-{$parts[0]}";
        }
        
        // Intentar con strtotime
        $timestamp = strtotime($fechaStr);
        if ($timestamp !== false) {
            return date('Y-m-d', $timestamp);
        }
        
        Log::warning("No se pudo parsear fecha: {$fechaStr}, usando fecha actual");
        return date('Y-m-d');
    }
    
    /**
     * Parsear monto (quitar $, comas, espacios)
     */
    private function parseMonto($monto)
    {
        if (is_numeric($monto)) {
            return floatval($monto);
        }
        
        // Quitar $, comas, espacios y convertir a número
        $limpio = preg_replace('/[^0-9.-]/', '', (string)$monto);
        return floatval($limpio);
    }
    
    /**
     * Guardar conciliación
     */
    public function guardarConciliacion(Request $request)
    {
        Log::info('=== guardarConciliacion INICIO ===');
        Log::info('Datos recibidos:', $request->all());
        
        try {
            DB::beginTransaction();
            
            // Generar folio
            $folio = 'CB-' . date('Ymd') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
            Log::info("Folio generado: " . $folio);
            
            // Obtener saldo inicial del extracto
            $saldoInicialExtracto = $request->saldo_inicial_extracto ?? 0;
            
            // Crear conciliación
            $conciliacionId = DB::table('conciliacion_bancaria')->insertGetId([
                'cuenta_bancaria_id' => $request->cuenta_id,
                'folio' => $folio,
                'fecha_conciliacion' => now(),
                'periodo_inicio' => $request->fecha_inicio,
                'periodo_fin' => $request->fecha_fin,
                'saldo_inicial_sistema' => $request->saldo_inicial_sistema ?? 0,
                'saldo_inicial_extracto' => $saldoInicialExtracto,
                'total_ingresos_sistema' => $request->total_ingresos_sistema ?? 0,
                'total_egresos_sistema' => $request->total_egresos_sistema ?? 0,
                'total_ingresos_extracto' => $request->total_ingresos_extracto ?? 0,
                'total_egresos_extracto' => $request->total_egresos_extracto ?? 0,
                'saldo_final_sistema' => $request->saldo_final_sistema ?? 0,
                'saldo_final_extracto' => $request->saldo_final_extracto ?? 0,
                'diferencia' => $request->diferencia ?? 0,
                'archivo_excel' => session('archivo_excel'),
                'estatus' => ($request->diferencia == 0) ? 'Conciliado' : 'Descuadre',
                'observaciones' => $request->observaciones,
                'created_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            Log::info("Conciliación creada ID: " . $conciliacionId);
            
            // Guardar movimientos conciliados
            $movimientosConciliados = json_decode($request->movimientos_conciliados, true);
            
            if ($movimientosConciliados && is_array($movimientosConciliados)) {
                $contador = 0;
                foreach ($movimientosConciliados as $mov) {
                    // Corregir el valor de origen - debe ser exactamente como lo espera la BD
                    $origen = $mov['origen'] ?? 'Sistema';
                    
                    // Validar que el origen sea válido (Sistema o Extracto)
                    if (!in_array($origen, ['Sistema', 'Extracto'])) {
                        Log::warning("Origen inválido: {$origen}, usando 'Sistema'");
                        $origen = 'Sistema';
                    }
                    
                    // Parsear fecha correctamente
                    $fecha = $mov['fecha'] ?? now();
                    $fecha = $this->parseFecha($fecha);
                    
                    DB::table('conciliacion_detalle')->insert([
                        'conciliacion_id' => $conciliacionId,
                        'origen' => $origen,
                        'fecha' => $fecha,
                        'descripcion' => $mov['descripcion'] ?? '',
                        'referencia' => $mov['referencia'] ?? null,
                        'egreso' => floatval($mov['egreso'] ?? 0),
                        'ingreso' => floatval($mov['ingreso'] ?? 0),
                        'numero_transaccion' => $mov['numero_transaccion'] ?? null,
                        'estatus' => ($mov['conciliado'] ?? false) ? 'Conciliado' : 'Diferencia',
                        'conciliado_con' => $mov['conciliado_con'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    $contador++;
                }
                Log::info("Movimientos guardados: " . $contador);
            } else {
                Log::warning("No se recibieron movimientos conciliados");
            }
            
            DB::commit();
            
            // Limpiar sesión
            session()->forget(['movimientos_extracto', 'archivo_excel']);
            
            return response()->json([
                'success' => true,
                'message' => 'Conciliación guardada exitosamente',
                'folio' => $folio,
                'conciliacion_id' => $conciliacionId
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error guardarConciliacion: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Descargar plantilla Excel
     */
    public function downloadTemplate()
    {
        Log::info('=== downloadTemplate INICIO ===');
        
        try {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Encabezados
            $headers = ['Fecha', 'Descripcion', 'Referencia', 'Egresos', 'Ingresos', 'Numero Transaccion'];
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . '1', $header);
                $sheet->getColumnDimension($col)->setAutoSize(true);
                $col++;
            }
            
            // Estilo encabezados
            $sheet->getStyle('A1:F1')->getFont()->setBold(true);
            $sheet->getStyle('A1:F1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF2378e1');
            $sheet->getStyle('A1:F1')->getFont()->getColor()->setARGB('FFFFFFFF');
            
            // Datos de ejemplo
            $ejemplos = [
                [date('Y-m-d'), 'Ejemplo de pago a proveedor', 'REF-001', 1500.00, 0, 'TRX-001'],
                [date('Y-m-d'), 'Ejemplo de transferencia recibida', 'REF-002', 0, 5000.00, 'TRX-002'],
                [date('Y-m-d'), 'Ejemplo de gasto de operación', 'REF-003', 750.50, 0, 'TRX-003'],
            ];
            
            $fila = 2;
            foreach ($ejemplos as $ejemplo) {
                $sheet->setCellValue('A' . $fila, $ejemplo[0]);
                $sheet->setCellValue('B' . $fila, $ejemplo[1]);
                $sheet->setCellValue('C' . $fila, $ejemplo[2]);
                $sheet->setCellValue('D' . $fila, $ejemplo[3]);
                $sheet->setCellValue('E' . $fila, $ejemplo[4]);
                $sheet->setCellValue('F' . $fila, $ejemplo[5]);
                $fila++;
            }
            
            // Guardar como XLS
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
            $filename = 'Plantilla_Conciliacion_Bancaria.xls';
            
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            
            $writer->save('php://output');
            exit;
            
        } catch (\Exception $e) {
            Log::error('Error downloadTemplate: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obtener lista de conciliaciones
     */
    public function getConciliaciones(Request $request)
    {
        try {
            $query = DB::table('conciliacion_bancaria as cb')
                ->join('cuentas_bancarias as c', 'cb.cuenta_bancaria_id', '=', 'c.id')
                ->join('bancos as b', 'c.banco_id', '=', 'b.id')
                ->select(
                    'cb.id',
                    'cb.folio',
                    'cb.estatus',
                    'cb.fecha_conciliacion',
                    'cb.periodo_inicio',
                    'cb.periodo_fin',
                    'cb.diferencia',
                    'b.nombre as banco',
                    'c.numero_cuenta'
                )
                ->orderBy('cb.created_at', 'desc');
            
            if ($request->fecha_inicio) {
                $query->where('cb.periodo_inicio', '>=', $request->fecha_inicio);
            }
            if ($request->fecha_fin) {
                $query->where('cb.periodo_fin', '<=', $request->fecha_fin);
            }
            if ($request->buscar) {
                $query->where(function($q) use ($request) {
                    $q->where('cb.folio', 'LIKE', "%{$request->buscar}%")
                      ->orWhere('b.nombre', 'LIKE', "%{$request->buscar}%");
                });
            }
            
            $conciliaciones = $query->get();
            
            return response()->json([
                'success' => true,
                'data' => $conciliaciones
            ]);
        } catch (\Exception $e) {
            Log::error('Error getConciliaciones: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obtener detalle de una conciliación
     */
    public function getDetalleConciliacion($id)
    {
        try {
            $conciliacion = DB::table('conciliacion_bancaria')->where('id', $id)->first();
            
            if (!$conciliacion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Conciliación no encontrada'
                ], 404);
            }
            
            $detalle = DB::table('conciliacion_detalle')
                ->where('conciliacion_id', $id)
                ->orderBy('fecha')
                ->get();
            
            return response()->json([
                'success' => true,
                'conciliacion' => $conciliacion,
                'detalle' => $detalle
            ]);
        } catch (\Exception $e) {
            Log::error('Error getDetalleConciliacion: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Eliminar conciliación
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            // Verificar si existe
            $conciliacion = DB::table('conciliacion_bancaria')->where('id', $id)->first();
            if (!$conciliacion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Conciliación no encontrada'
                ], 404);
            }
            
            // Eliminar detalle primero
            $detalleEliminados = DB::table('conciliacion_detalle')->where('conciliacion_id', $id)->delete();
            Log::info("Detalles eliminados: " . $detalleEliminados);
            
            // Eliminar conciliación
            DB::table('conciliacion_bancaria')->where('id', $id)->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Conciliación eliminada correctamente'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error destroy: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}