<?php

namespace App\Http\Controllers\Facturacion;

use App\Http\Controllers\Controller;
use App\Models\Facturacion\Factura;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReporteFacturasController extends Controller
{
    public function resumenMensual(Request $request)
    {
        $year = $request->year ?? Carbon::now()->year;
        $month = $request->month ?? Carbon::now()->month;
        
        $facturas = Factura::whereYear('fecha', $year)
            ->whereMonth('fecha', $month)
            ->where('estatus', 19)
            ->get();
        
        $totalFacturas = $facturas->count();
        $totalMonto = $facturas->sum('total');
        $ivaTotal = $facturas->sum('iva');
        
        return response()->json([
            'status' => 'ok',
            'data' => [
                'year' => $year,
                'month' => $month,
                'total_facturas' => $totalFacturas,
                'total_monto' => $totalMonto,
                'total_iva' => $ivaTotal,
            ]
        ]);
    }
    
    public function facturasPorCliente(Request $request)
    {
        $startDate = $request->startDate ?? Carbon::now()->startOfYear();
        $endDate = $request->endDate ?? Carbon::now();
        
        $data = Factura::whereBetween('fecha', [$startDate, $endDate])
            ->where('estatus', 19)
            ->with('contacto')
            ->get()
            ->groupBy('contacto_id')
            ->map(function($group) {
                return [
                    'contacto' => $group->first()->contacto->razon_social,
                    'total_facturas' => $group->count(),
                    'total_monto' => $group->sum('total'),
                ];
            })
            ->values();
        
        return response()->json(['status' => 'ok', 'data' => $data]);
    }
    
    public function facturasPorProyecto(Request $request)
    {
        $startDate = $request->startDate ?? Carbon::now()->startOfYear();
        $endDate = $request->endDate ?? Carbon::now();
        
        $data = Factura::whereBetween('fecha', [$startDate, $endDate])
            ->where('estatus', 19)
            ->whereNotNull('proyecto_id')
            ->with('proyecto')
            ->get()
            ->groupBy('proyecto_id')
            ->map(function($group) {
                return [
                    'proyecto' => $group->first()->proyecto->nombre ?? 'Sin proyecto',
                    'total_facturas' => $group->count(),
                    'total_monto' => $group->sum('total'),
                ];
            })
            ->values();
        
        return response()->json(['status' => 'ok', 'data' => $data]);
    }
}