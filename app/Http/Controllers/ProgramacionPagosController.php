<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;
use App\Models\ChequesTransferencia;
use App\Models\Factura;
use App\Models\Proveedor;
use DB;

class ProgramacionPagosController extends Controller
{
    /**
     * Obtener programación de pagos para DataTable
     */
    public function getProgramacionPagos(Request $request)
    {
        try {
            // Consulta principal combinando pagos y cheques_transferencias
            $pagos = $this->obtenerPagos($request);
            $cheques = $this->obtenerChequesTransferencias($request);
            
            // Unir y ordenar por fecha
            $resultados = $pagos->concat($cheques)->sortByDesc('fecha')->values();
            
            // Aplicar búsqueda si existe
            if ($request->has('buscar') && !empty($request->buscar)) {
                $buscar = $request->buscar;
                $resultados = $resultados->filter(function($item) use ($buscar) {
                    return stripos($item['proveedor'], $buscar) !== false ||
                           stripos($item['descripcion'], $buscar) !== false ||
                           stripos($item['estatus'], $buscar) !== false;
                });
            }
            
            return response()->json([
                'success' => true,
                'data' => $resultados->values(),
                'total' => $resultados->count()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obtener pagos de la tabla 'pagos'
     */
    private function obtenerPagos(Request $request)
    {
        $query = DB::table('pagos as p')
            ->leftJoin('proveedores as prov', 'p.proveedor_id', '=', 'prov.id')
            ->leftJoin('proyectos as proy', 'p.proyecto_id', '=', 'proy.id')
            ->select([
                'p.id',
                'p.folio',
                'p.fecha_pago as fecha',
                'p.monto',
                'p.monto as saldo',
                'p.concepto as descripcion',
                'p.estatus',
                DB::raw("COALESCE(prov.nombre, p.proveedor_nombre) as proveedor"),
                'p.fecha_pago as fecha_estimada',
                DB::raw("'pago' as tipo")
            ]);
        
        // Filtro por fechas
        if ($request->has('fecha_inicio')) {
            $query->whereDate('p.fecha_pago', '>=', $request->fecha_inicio);
        }
        if ($request->has('fecha_fin')) {
            $query->whereDate('p.fecha_pago', '<=', $request->fecha_fin);
        }
        
        return $query->get()->map(function($item) {
            return (array) $item;
        });
    }
    
    /**
     * Obtener cheques y transferencias
     */
    private function obtenerChequesTransferencias(Request $request)
    {
        $query = DB::table('cheques_transferencias as ct')
            ->leftJoin('proveedores as prov', 'ct.proveedor', '=', 'prov.id')
            ->leftJoin('proyectos as proy', 'ct.proyecto_id', '=', 'proy.id')
            ->select([
                'ct.id',
                'ct.folio',
                'ct.fecha',
                'ct.monto',
                'ct.monto_restante as saldo',
                'ct.descripcion',
                'ct.estatus',
                DB::raw("COALESCE(prov.nombre, ct.proveedor) as proveedor"),
                'ct.fecha_vencimiento as fecha_estimada',
                DB::raw("'cheque_transferencia' as tipo")
            ]);
        
        // Filtro por fechas
        if ($request->has('fecha_inicio')) {
            $query->whereDate('ct.fecha', '>=', $request->fecha_inicio);
        }
        if ($request->has('fecha_fin')) {
            $query->whereDate('ct.fecha', '<=', $request->fecha_fin);
        }
        
        return $query->get()->map(function($item) {
            return (array) $item;
        });
    }
    
    /**
     * Exportar a Excel
     */
    public function exportarExcel(Request $request)
    {
        $pagos = $this->obtenerPagos($request);
        $cheques = $this->obtenerChequesTransferencias($request);
        
        $resultados = $pagos->concat($cheques)->sortByDesc('fecha')->values();
        
        // Generar Excel usando Laravel Excel o cualquier otra librería
        // Implementación según tu preferencia
        
        return response()->json([
            'success' => true,
            'data' => $resultados,
            'message' => 'Exportación exitosa'
        ]);
    }
}