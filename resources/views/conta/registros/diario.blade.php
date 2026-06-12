@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Diario General
                </h2>
            </div>

            <div class="card-body p-4">
                @php
                    // Consultas directas para obtener datos
                    $proyectos = DB::table('proyectos')
                        ->select('id', 'nombre', 'codigo')
                        ->whereNull('deleted_at')
                        ->orderBy('nombre')
                        ->get();
                    
                    $cuentasBancarias = DB::table('cuentas_bancarias as cb')
                        ->leftJoin('bancos as b', 'cb.banco_id', '=', 'b.id')
                        ->select('cb.id', 'cb.numero_cuenta', 'b.nombre as banco_nombre')
                        ->whereNull('cb.deleted_at')
                        ->where('cb.activa', true)
                        ->get()
                        ->map(function($cuenta) {
                            $cuenta->nombre_display = ($cuenta->banco_nombre ?? 'Banco') . ' - ' . $cuenta->numero_cuenta;
                            return $cuenta;
                        });
                    
                    $fechaInicio = request('fecha_inicio', date('Y-01-01'));
                    $fechaFin = request('fecha_fin', date('Y-m-t'));
                    
                    $query = DB::table('polizas_contables as pc')
                        ->join('movimientos_poliza as mp', 'pc.poliza_contable_id', '=', 'mp.poliza_contable_id')
                        ->leftJoin('cuentas_contables as cc', 'mp.cuenta_contable_id', '=', 'cc.id')
                        ->leftJoin('proyectos as p', 'pc.proyecto_id', '=', 'p.id')
                        ->select(
                            'mp.id',
                            'pc.fecha',
                            'pc.folio as poliza',
                            'mp.debe',
                            'mp.haber',
                            'mp.descripcion',
                            'cc.codigo as cuenta_codigo',
                            'cc.nombre as cuenta_nombre',
                            'p.nombre as proyecto_nombre'
                        )
                        ->whereNull('pc.deleted_at')
                        ->whereBetween('pc.fecha', [$fechaInicio, $fechaFin]);
                    
                    if (request('proyecto_id')) {
                        $query->where('pc.proyecto_id', request('proyecto_id'));
                    }
                    
                    $movimientos = $query->orderBy('pc.fecha', 'desc')->get();
                    
                    $totalPolizas = $movimientos->unique('poliza')->count();
                    $totalCargos = $movimientos->sum('debe');
                    $totalAbonos = $movimientos->sum('haber');
                @endphp

                <!-- 4 CUADROS ESTADÍSTICOS -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600;">Total Pólizas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;">{{ $totalPolizas }}</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600;">Total Movimientos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;">{{ $movimientos->count() }}</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600;">Total Cargos</div>
                            <div style="color: #000000; font-size: 28px; font-weight: bold;">${{ number_format($totalCargos, 2) }}</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600;">Total Abonos</div>
                            <div style="color: #000000; font-size: 28px; font-weight: bold;">${{ number_format($totalAbonos, 2) }}</div>
                        </div>
                    </div>
                </div>

                <!-- FILTROS -->
                <form method="GET" action="{{ route('conta.diario.data') }}" id="filtrosForm">
                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                        <div style="display: flex; align-items: center; gap: 8px;" id="grupoAgrupacion">
                            <i class="fas fa-layer-group" style="color: #2378e1; font-size: 14px; cursor: pointer;"></i>
                            <span style="color: #6c757d; font-size: 12px; font-style: italic;">arrastra una columna para agrupar</span>
                            <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                        </div>
                        
                        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                            <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio', $fechaInicio) }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; width: 140px;">
                            <input type="date" name="fecha_fin" value="{{ request('fecha_fin', $fechaFin) }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; width: 140px;">
                            
                            <select name="proyecto_id" style="padding: 6px 10px; border: 1px solid #083CAE; border-radius: 4px; min-width: 180px;">
                                <option value="">Todos los proyectos</option>
                                @foreach($proyectos as $proyecto)
                                    <option value="{{ $proyecto->id }}" {{ request('proyecto_id') == $proyecto->id ? 'selected' : '' }}>
                                        {{ $proyecto->codigo }} - {{ $proyecto->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            
                            <select name="cuenta_bancaria_id" style="padding: 6px 10px; border: 1px solid #083CAE; border-radius: 4px; min-width: 200px;">
                                <option value="">Todas las cuentas bancarias</option>
                                @foreach($cuentasBancarias as $cuenta)
                                    <option value="{{ $cuenta->id }}" {{ request('cuenta_bancaria_id') == $cuenta->id ? 'selected' : '' }}>
                                        {{ $cuenta->nombre_display }}
                                    </option>
                                @endforeach
                            </select>
                            
                            <button type="submit" style="background: #083CAE; border: none; border-radius: 4px; padding: 6px 16px; color: white; cursor: pointer;">
                                <i class="fas fa-search"></i> Aplicar
                            </button>
                            
                            <a href="{{ route('conta.diario.data') }}" style="background: #6c757d; border-radius: 4px; padding: 6px 16px; color: white; text-decoration: none;">
                                <i class="fas fa-undo"></i> Limpiar
                            </a>
                            
                            <a href="{{ route('conta.diario.exportar', request()->all()) }}" style="background: white; border: 1px solid #083CAE; border-radius: 4px; padding: 6px 12px; color: #083CAE; text-decoration: none;">
                                <i class="fas fa-file-excel"></i> Excel
                            </a>
                            
                            <div style="position: relative;">
                                <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                                <input type="text" name="search" placeholder="Buscar..." value="{{ request('search') }}" style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; width: 200px;">
                            </div>
                        </div>
                    </div>
                </form>

                <!-- TABLA -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto;">
                    <table class="table table-bordered" style="width: 100%; font-size: 12px; margin-bottom: 0;">
                        <thead style="position: sticky; top: 0; background: #2378e1; z-index: 20;">
                            <tr>
                                <th style="background:#2378e1;color:white;">Fecha</th>
                                <th style="background:#2378e1;color:white;">Póliza</th>
                                <th style="background:#2378e1;color:white;">Cuenta</th>
                                <th style="background:#2378e1;color:white;">Nombre Cuenta</th>
                                <th style="background:#2378e1;color:white;">Concepto</th>
                                <th style="background:#2378e1;color:white;text-align:right;">Cargo</th>
                                <th style="background:#2378e1;color:white;text-align:right;">Abono</th>
                                <th style="background:#2378e1;color:white;">Tipo</th>
                                <th style="background:#2378e1;color:white;">Proyecto</th>
                                <th style="background:#2378e1;color:white;position:sticky;right:0;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($movimientos as $mov)
                            @php
                                $tipo = $mov->debe > 0 ? 'Ingreso' : ($mov->haber > 0 ? 'Egreso' : 'Diario');
                                $badgeClass = $tipo == 'Ingreso' ? 'badge-ingreso' : ($tipo == 'Egreso' ? 'badge-egreso' : 'badge-diario');
                            @endphp
                            <tr>
                                <td>{{ date('d/m/Y', strtotime($mov->fecha)) }}</td>
                                <td>{{ $mov->poliza }}</td>
                                <td>{{ $mov->cuenta_codigo ?? '-' }}</td>
                                <td>{{ $mov->cuenta_nombre ?? '-' }}</td>
                                <td>{{ $mov->descripcion ?? '-' }}</td>
                                <td style="text-align:right;">{{ $mov->debe > 0 ? '$'.number_format($mov->debe, 2) : '-' }}</td>
                                <td style="text-align:right;">{{ $mov->haber > 0 ? '$'.number_format($mov->haber, 2) : '-' }}</td>
                                <td><span class="badge {{ $badgeClass }}">{{ $tipo }}</span></td>
                                <td>{{ $mov->proyecto_nombre ?? '-' }}</td>
                                <td style="background:white;position:sticky;right:0;">
                                    <div style="display:flex; gap:8px; justify-content:center;">
                                        <i class="fas fa-eye" style="cursor:pointer;color:#083CAE;" title="Ver"></i>
                                        <i class="fas fa-edit" style="cursor:pointer;color:#083CAE;" title="Editar"></i>
                                        <i class="fas fa-trash-alt" style="cursor:pointer;color:#083CAE;" title="Eliminar"></i>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" style="text-align:center; padding:40px;">
                                    <i class="fas fa-book" style="font-size:48px; color:#ced4da;"></i>
                                    <h3 style="color:#6c757d;">Sin datos</h3>
                                    <p style="color:#adb5bd;">No hay movimientos en el diario general para mostrar</p>
                                    <p style="color:#dc3545; font-size:12px;">
                                        <i class="fas fa-info-circle"></i> 
                                        No hay movimientos registrados. 
                                    </p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if($movimientos->count() > 0)
                        <tfoot style="position:sticky;bottom:0;background:#e9ecef;">
                            <tr>
                                <td colspan="5"><strong>Totales</strong></td>
                                <td style="text-align:right;"><strong>${{ number_format($movimientos->sum('debe'), 2) }}</strong></td>
                                <td style="text-align:right;"><strong>${{ number_format($movimientos->sum('haber'), 2) }}</strong></td>
                                <td colspan="3"></td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .custom-card { transition: transform 0.2s; }
    .custom-card:hover { transform: translateY(-3px); box-shadow: 0 8px 16px rgba(8,60,174,0.15); }
    .badge { padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; }
    .badge-ingreso { background: #28a745; color: white; }
    .badge-egreso { background: #dc3545; color: white; }
    .badge-diario { background: #17a2b8; color: white; }
    .table td { white-space: nowrap; padding: 8px 4px; }
    .table th { white-space: nowrap; padding: 10px 4px; }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('filtrosForm');
    const filtros = document.querySelectorAll('#filtrosForm select, #filtrosForm input[type="date"]');
    const buscador = document.querySelector('#filtrosForm input[name="search"]');
    
    filtros.forEach(el => {
        if (el && el.id !== 'buscador') {
            el.addEventListener('change', () => form.submit());
        }
    });
    
    if (buscador) {
        let timeout;
        buscador.addEventListener('input', () => {
            clearTimeout(timeout);
            timeout = setTimeout(() => form.submit(), 500);
        });
    }
});
</script>
@endsection