<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DiotController extends Controller
{
    /**
     * Display the DIOT view.
     */
    public function vista()
    {
        return view('conta.fiscal.diot');
    }

    /**
     * Get DIOT data for the selected month and year (API).
     */
    public function getData(Request $request)
    {
        try {
            $mes = $request->input('mes', date('m'));
            $anio = $request->input('anio', date('Y'));
            
            // ============================================
            // OBTENER OPERACIONES DESDE TABLA PAGOS
            // ============================================
            $pagos = DB::table('pagos')
                ->select(
                    'proveedor_rfc as rfc',
                    'proveedor_nombre as nombre',
                    DB::raw('SUM(monto) as subtotal'),
                    DB::raw('SUM(monto * 0.16) as iva_16'),
                    DB::raw('0 as iva_8'),
                    DB::raw('0 as iva_0'),
                    DB::raw('0 as iva_exento')
                )
                ->whereRaw('EXTRACT(MONTH FROM fecha_pago) = ?', [$mes])
                ->whereRaw('EXTRACT(YEAR FROM fecha_pago) = ?', [$anio])
                ->where('estatus', 'completado')
                ->whereNotNull('proveedor_rfc')
                ->groupBy('proveedor_rfc', 'proveedor_nombre')
                ->get();
            
            // ============================================
            // OBTENER OPERACIONES DESDE TABLA CHEQUES_TRANSFERENCIAS
            // ============================================
            $cheques = DB::table('cheques_transferencias')
                ->select(
                    'rfc',
                    'proveedor as nombre',
                    DB::raw('SUM(monto) as subtotal'),
                    DB::raw('SUM(monto * 0.16) as iva_16'),
                    DB::raw('0 as iva_8'),
                    DB::raw('0 as iva_0'),
                    DB::raw('0 as iva_exento')
                )
                ->whereRaw('EXTRACT(MONTH FROM fecha) = ?', [$mes])
                ->whereRaw('EXTRACT(YEAR FROM fecha) = ?', [$anio])
                ->where('estatus', 'completado')
                ->whereNotNull('rfc')
                ->groupBy('rfc', 'proveedor')
                ->get();
            
            // ============================================
            // COMBINAR RESULTADOS MANUALMENTE (sin unionAll)
            // ============================================
            $resultados = [];
            
            // Procesar pagos
            foreach ($pagos as $pago) {
                $key = $pago->rfc;
                if (!isset($resultados[$key])) {
                    $resultados[$key] = (object)[
                        'rfc' => $pago->rfc,
                        'razon_social' => $pago->nombre,
                        'subtotal' => 0,
                        'iva_16' => 0,
                        'iva_8' => 0,
                        'iva_0' => 0,
                        'iva_exento' => 0
                    ];
                }
                $resultados[$key]->subtotal += $pago->subtotal;
                $resultados[$key]->iva_16 += $pago->iva_16;
            }
            
            // Procesar cheques
            foreach ($cheques as $cheque) {
                $key = $cheque->rfc;
                if (!isset($resultados[$key])) {
                    $resultados[$key] = (object)[
                        'rfc' => $cheque->rfc,
                        'razon_social' => $cheque->nombre,
                        'subtotal' => 0,
                        'iva_16' => 0,
                        'iva_8' => 0,
                        'iva_0' => 0,
                        'iva_exento' => 0
                    ];
                }
                $resultados[$key]->subtotal += $cheque->subtotal;
                $resultados[$key]->iva_16 += $cheque->iva_16;
            }
            
            // ============================================
            // OBTENER RAZÓN SOCIAL DESDE TABLA PROVEEDORES
            // ============================================
            $proveedores = DB::table('proveedores')
                ->where('activo', true)
                ->get(['rfc', 'razon_social', 'nombre']);
            
            foreach ($resultados as $rfc => $item) {
                $proveedor = $proveedores->firstWhere('rfc', $rfc);
                if ($proveedor) {
                    $item->razon_social = $proveedor->razon_social ?? $proveedor->nombre ?? $item->razon_social;
                }
            }
            
            // ============================================
            // CALCULAR TOTALES
            // ============================================
            $totales = (object)[
                'subtotal' => collect($resultados)->sum('subtotal'),
                'iva_16' => collect($resultados)->sum('iva_16'),
                'iva_8' => collect($resultados)->sum('iva_8'),
                'iva_0' => collect($resultados)->sum('iva_0'),
                'iva_exento' => collect($resultados)->sum('iva_exento')
            ];
            
            return response()->json([
                'success' => true,
                'data' => array_values($resultados),
                'totales' => $totales,
                'mes' => $mes,
                'anio' => $anio
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en DiotController@getData: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar datos: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Generate and download DIOT .txt file for SAT.
     */
    public function descargarTxt(Request $request)
    {
        try {
            $mes = $request->input('mes', date('m'));
            $anio = $request->input('anio', date('Y'));
            $mesNombre = $this->getMesNombre($mes);
            
            // Obtener datos de la empresa
            $empresa = DB::table('datos_generales')
                ->where('activo', true)
                ->first();
            
            if (!$empresa) {
                return back()->withErrors(['error' => 'No se encontraron datos de la empresa']);
            }
            
            $rfcEmpresa = $empresa->rfc;
            
            // Obtener operaciones del período
            $operaciones = $this->getOperacionesPeriodo($mes, $anio);
            
            // Generar contenido del archivo .txt
            $contenido = $this->generarArchivoSAT($operaciones, $rfcEmpresa, $mes, $anio);
            
            // Crear archivo para descarga
            $nombreArchivo = "DIOT_{$rfcEmpresa}_{$anio}{$mes}.txt";
            
            return response($contenido)
                ->header('Content-Type', 'text/plain')
                ->header('Content-Disposition', "attachment; filename=\"{$nombreArchivo}\"");
                
        } catch (\Exception $e) {
            Log::error('Error en DiotController@descargarTxt: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error al generar archivo: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Get operations for the period.
     */
    private function getOperacionesPeriodo($mes, $anio)
    {
        // Pagos a proveedores
        $pagos = DB::table('pagos')
            ->select(
                'proveedor_rfc as rfc',
                'proveedor_nombre as nombre',
                DB::raw('SUM(monto) as total')
            )
            ->whereRaw('EXTRACT(MONTH FROM fecha_pago) = ?', [$mes])
            ->whereRaw('EXTRACT(YEAR FROM fecha_pago) = ?', [$anio])
            ->where('estatus', 'completado')
            ->whereNotNull('proveedor_rfc')
            ->groupBy('proveedor_rfc', 'proveedor_nombre')
            ->get();
        
        // Cheques y transferencias
        $cheques = DB::table('cheques_transferencias')
            ->select(
                'rfc',
                'proveedor as nombre',
                DB::raw('SUM(monto) as total')
            )
            ->whereRaw('EXTRACT(MONTH FROM fecha) = ?', [$mes])
            ->whereRaw('EXTRACT(YEAR FROM fecha) = ?', [$anio])
            ->where('estatus', 'completado')
            ->whereNotNull('rfc')
            ->groupBy('rfc', 'proveedor')
            ->get();
        
        // Combinar resultados
        $operaciones = [];
        
        foreach ($pagos as $pago) {
            $key = $pago->rfc;
            if (!isset($operaciones[$key])) {
                $operaciones[$key] = (object)[
                    'rfc' => $pago->rfc,
                    'nombre' => $pago->nombre,
                    'total' => 0
                ];
            }
            $operaciones[$key]->total += $pago->total;
        }
        
        foreach ($cheques as $cheque) {
            $key = $cheque->rfc;
            if (!isset($operaciones[$key])) {
                $operaciones[$key] = (object)[
                    'rfc' => $cheque->rfc,
                    'nombre' => $cheque->nombre,
                    'total' => 0
                ];
            }
            $operaciones[$key]->total += $cheque->total;
        }
        
        // Enriquecer con datos de proveedores
        $proveedores = DB::table('proveedores')
            ->where('activo', true)
            ->get(['rfc', 'razon_social', 'nombre']);
        
        foreach ($operaciones as $rfc => $op) {
            $proveedor = $proveedores->firstWhere('rfc', $rfc);
            if ($proveedor) {
                $op->nombre = $proveedor->razon_social ?? $proveedor->nombre ?? $op->nombre;
            }
        }
        
        return array_values($operaciones);
    }
    
    /**
     * Generate SAT format .txt file content.
     */
    private function generarArchivoSAT($operaciones, $rfcEmpresa, $mes, $anio)
    {
        // Formato SAT para DIOT
        $lineas = [];
        
        // Encabezado (opcional)
        $lineas[] = "DIOT|{$rfcEmpresa}|{$anio}|{$mes}|" . date('Ymd');
        
        // Registros de operaciones por proveedor
        foreach ($operaciones as $op) {
            $rfcProveedor = str_pad($op->rfc ?? '', 13, ' ');
            $subtotal = number_format($op->total, 2, '.', '');
            $iva = number_format($op->total * 0.16, 2, '.', '');
            $tasaIva = '16';
            
            $lineas[] = "{$rfcProveedor}|{$subtotal}|{$iva}|{$tasaIva}";
        }
        
        return implode("\n", $lineas);
    }
    
    /**
     * Get month name.
     */
    private function getMesNombre($mes)
    {
        $meses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];
        return $meses[(int)$mes] ?? 'Desconocido';
    }
    
    /**
     * Test endpoint to verify API is working.
     */
    public function test()
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'API DIOT funcionando correctamente',
                'timestamp' => now()->toDateTimeString()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}