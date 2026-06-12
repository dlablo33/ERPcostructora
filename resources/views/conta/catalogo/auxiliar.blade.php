@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Auxiliar Cuenta Contable -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Auxiliar Cuenta Contable
                </h2>
            </div>

            <div class="card-body p-4">
                @php
                    // Inicializar variables
                    $cuentas = $cuentas ?? collect();
                    $cuentaId = $cuentaId ?? '';
                    $codigoCuenta = $codigoCuenta ?? '';
                    $nombreCuenta = $nombreCuenta ?? '';
                    $fechaInicio = $fechaInicio ?? date('Y-m-01');
                    $fechaFin = $fechaFin ?? date('Y-m-t');
                    $saldoInicialFormateado = $saldoInicialFormateado ?? '$0.00';
                    $totalCargosFormateado = $totalCargosFormateado ?? '$0.00';
                    $totalAbonosFormateado = $totalAbonosFormateado ?? '$0.00';
                    $saldoFinalFormateado = $saldoFinalFormateado ?? '$0.00';
                    $movimientos = $movimientos ?? collect();
                    $nombreEmpresa = $nombreEmpresa ?? 'EMPRESA DEMO';
                    $totalRegistros = $totalRegistros ?? 0;
                @endphp

                <!-- Filtros a la derecha -->
                <form method="GET" action="{{ route('conta.auxiliar') }}" id="filtrosForm">
                    <div style="display: flex; justify-content: flex-end; align-items: center; gap: 15px; margin-bottom: 25px; flex-wrap: wrap;">
                        <!-- Fecha inicio -->
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="font-weight: 600; color: #083CAE; font-size: 14px;">Fecha inicio:</span>
                            <div style="border: 1px solid #ced4da; border-radius: 4px; padding: 6px 12px; background-color: white;">
                                <input type="date" name="fecha_inicio" value="{{ $fechaInicio }}" style="border: none; background: transparent; font-size: 14px; outline: none; width: 140px;">
                            </div>
                        </div>

                        <!-- Fecha fin -->
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="font-weight: 600; color: #083CAE; font-size: 14px;">Fecha fin:</span>
                            <div style="border: 1px solid #ced4da; border-radius: 4px; padding: 6px 12px; background-color: white;">
                                <input type="date" name="fecha_fin" value="{{ $fechaFin }}" style="border: none; background: transparent; font-size: 14px; outline: none; width: 140px;">
                            </div>
                        </div>

                        <!-- Cuenta Contable -->
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="font-weight: 600; color: #083CAE; font-size: 14px;">Cuenta:</span>
                            <div style="border: 1px solid #ced4da; border-radius: 4px; padding: 6px 12px; background-color: white; min-width: 350px;">
                                <select name="cuenta_id" style="border: none; background: transparent; font-size: 14px; width: 100%; outline: none;">
                                    <option value="">-- Seleccione una cuenta --</option>
                                    @foreach($cuentas as $cuenta)
                                        <option value="{{ $cuenta->id }}" {{ $cuentaId == $cuenta->id ? 'selected' : '' }}>
                                            {{ $cuenta->codigo }} - {{ $cuenta->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Botón Buscar -->
                        <button type="submit" id="buttonBusqueda" style="background-color: #2378e1; color: white; border: none; border-radius: 4px; padding: 8px 20px; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-search"></i> Buscar
                        </button>

                        <!-- Botón Limpiar -->
                        <a href="{{ route('conta.auxiliar') }}" style="background-color: #6c757d; color: white; border: none; border-radius: 4px; padding: 8px 20px; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; text-decoration: none;">
                            <i class="fas fa-undo"></i> Limpiar
                        </a>

                        <!-- Botón Excel -->
                        <a href="{{ route('conta.auxiliar.exportar', request()->all()) }}" id="buttonExcel" style="background-color: #2CBF1F; color: white; border: none; border-radius: 4px; padding: 8px 20px; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; text-decoration: none;">
                            <i class="fas fa-file-excel"></i> Excel
                        </a>
                    </div>
                </form>

                <!-- Línea divisoria -->
                <hr style="border: 1px solid #dee2e6; margin: 20px 0;">

                <!-- Info boxes (4 cuadros de resumen) -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
                    <!-- Saldo Inicial -->
                    <div style="background-color: white; border: 2px solid #083CAE; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); text-align: center;">
                        <div style="font-size: 14px; font-weight: 600; color: #6c757d; margin-bottom: 10px; text-transform: uppercase;">Saldo Inicial</div>
                        <div style="font-size: 28px; font-weight: bold; color: #000000;">{{ $saldoInicialFormateado }}</div>
                    </div>

                    <!-- Cargos -->
                    <div style="background-color: white; border: 2px solid #083CAE; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); text-align: center;">
                        <div style="font-size: 14px; font-weight: 600; color: #6c757d; margin-bottom: 10px; text-transform: uppercase;">Cargos</div>
                        <div style="font-size: 28px; font-weight: bold; color: #000000;">{{ $totalCargosFormateado }}</div>
                    </div>

                    <!-- Abonos -->
                    <div style="background-color: white; border: 2px solid #083CAE; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); text-align: center;">
                        <div style="font-size: 14px; font-weight: 600; color: #6c757d; margin-bottom: 10px; text-transform: uppercase;">Abonos</div>
                        <div style="font-size: 28px; font-weight: bold; color: #000000;">{{ $totalAbonosFormateado }}</div>
                    </div>

                    <!-- Saldo Final -->
                    <div style="background-color: white; border: 2px solid #083CAE; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); text-align: center;">
                        <div style="font-size: 14px; font-weight: 600; color: #6c757d; margin-bottom: 10px; text-transform: uppercase;">Saldo Final</div>
                        <div style="font-size: 28px; font-weight: bold; color: #000000;">{{ $saldoFinalFormateado }}</div>
                    </div>
                </div>

                <!-- Información de la empresa y cuenta -->
                <div style="margin-bottom: 15px; padding: 10px 15px; background-color: #f8f9fa; border-radius: 8px; border: 1px solid #dee2e6;">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-building" style="color: #083CAE;"></i>
                            <span style="font-weight: 600; color: #083CAE; font-size: 16px;">{{ $nombreEmpresa }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-hashtag" style="color: #083CAE;"></i>
                            <span style="font-weight: 600;">{{ $codigoCuenta }} - {{ $nombreCuenta }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-calendar-alt" style="color: #083CAE;"></i>
                            <span>De {{ date('d/m/Y', strtotime($fechaInicio)) }} a {{ date('d/m/Y', strtotime($fechaFin)) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Tabla de Auxiliar -->
                <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: auto; max-height: 500px;">
                    <table class="table table-bancos" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20;">
                            <tr style="background-color: #2378e1; color: white;">
                                <th style="padding: 12px 10px; text-align: center;">Fecha</th>
                                <th style="padding: 12px 10px; text-align: center;">Póliza</th>
                                <th style="padding: 12px 10px; text-align: center;">Módulo</th>
                                <th style="padding: 12px 10px; text-align: center;">Folio</th>
                                <th style="padding: 12px 10px; text-align: left;">Descripción</th>
                                <th style="padding: 12px 10px; text-align: center;">Proyecto</th>
                                <th style="padding: 12px 10px; text-align: right;">Cargo</th>
                                <th style="padding: 12px 10px; text-align: right;">Abono</th>
                                <th style="padding: 12px 10px; text-align: right;">Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($movimientos->count() > 0)
                                @foreach($movimientos as $mov)
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <td style="padding: 10px; text-align: center;">{{ $mov->fecha_formateada }}</td>
                                    <td style="padding: 10px; text-align: center;">{{ $mov->poliza }}</td>
                                    <td style="padding: 10px; text-align: center;">{{ $mov->modulo }}</td>
                                    <td style="padding: 10px; text-align: center;">{{ $mov->folio_origen }}</td>
                                    <td style="padding: 10px;">{{ $mov->descripcion }}</td>
                                    <td style="padding: 10px; text-align: center;">{{ $mov->proyecto_nombre }}</td>
                                    <td style="padding: 10px; text-align: right; font-family: monospace;">{{ $mov->cargo_formateado }}</td>
                                    <td style="padding: 10px; text-align: right; font-family: monospace;">{{ $mov->abono_formateado }}</td>
                                    <td style="padding: 10px; text-align: right; font-family: monospace; font-weight: 600;">{{ $mov->saldo_formateado }}</td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" style="text-align: center; padding: 40px;">
                                        <i class="fas fa-chart-line" style="font-size: 48px; color: #ced4da; margin-bottom: 15px; display: block;"></i>
                                        <h3 style="color: #6c757d; margin: 0;">Sin movimientos</h3>
                                        <p style="color: #adb5bd; margin-top: 5px;">No hay movimientos en el período seleccionado para esta cuenta.</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        @if($movimientos->count() > 0)
                        <tfoot style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="6" style="padding: 12px 10px; text-align: right; border-top: 2px solid #083CAE;">TOTALES</td>
                                <td style="padding: 12px 10px; text-align: right; border-top: 2px solid #083CAE; font-family: monospace;">{{ $totalCargosFormateado }}</td>
                                <td style="padding: 12px 10px; text-align: right; border-top: 2px solid #083CAE; font-family: monospace;">{{ $totalAbonosFormateado }}</td>
                                <td style="padding: 12px 10px; text-align: right; border-top: 2px solid #083CAE; font-family: monospace; font-weight: 700;">{{ $saldoFinalFormateado }}</td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>

                <!-- Paginación -->
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 20px; gap: 15px;">
                    <span style="color: #6c757d; font-size: 14px;">Mostrando {{ $totalRegistros }} registros</span>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .semaforo .card-header {
        background-color: #f4f6f9;
        border-bottom: 2px solid #083CAE;
    }
    
    .semaforo .card-header h2 {
        color: #083CAE !important;
    }
    
    /* Estilo para tarjetas de resumen */
    [style*="grid-template-columns: repeat(4, 1fr)"] > div {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    [style*="grid-template-columns: repeat(4, 1fr)"] > div:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(8, 60, 174, 0.15) !important;
    }
    
    /* Estilos de tabla */
    .table-bancos {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table-bancos thead tr {
        background-color: #2378e1 !important;
        color: white;
    }
    
    .table-bancos th {
        background-color: #2378e1 !important;
        color: white;
        font-weight: 600;
        padding: 12px 10px;
        white-space: nowrap;
    }
    
    .table-bancos tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }
    
    .table-bancos tbody tr:hover {
        background-color: #e3f2fd !important;
    }
    
    .table-bancos td {
        padding: 10px;
        border-bottom: 1px solid #dee2e6;
    }
    
    .table-bancos tfoot td {
        font-weight: bold;
        background-color: #e9ecef !important;
        border-top: 2px solid #083CAE;
    }
    
    /* Estilo para el botón Buscar */
    #buttonBusqueda {
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(8, 60, 174, 0.2);
    }
    
    #buttonBusqueda:hover {
        background-color: #0a4ad0 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(8, 60, 174, 0.3);
    }
    
    /* Estilo para inputs y selects */
    input[type="date"], select {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    input[type="date"]:hover, select:hover {
        border-color: #2CBF1F !important;
    }
    
    input[type="date"]:focus, select:focus {
        outline: none;
        border-color: #083CAE;
        box-shadow: 0 0 0 2px rgba(8, 60, 174, 0.2);
    }
    
    /* Estilo para los contenedores de filtros */
    [style*="border: 1px solid #ced4da"] {
        background-color: white;
        transition: border-color 0.2s;
    }
    
    [style*="border: 1px solid #ced4da"]:hover {
        border-color: #083CAE !important;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        [style*="grid-template-columns: repeat(4, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
        
        [style*="display: flex; justify-content: flex-end"] {
            flex-direction: column;
            align-items: stretch !important;
        }
        
        [style*="min-width: 350px"] {
            min-width: 100% !important;
        }
        
        #buttonBusqueda, #buttonExcel, [href*="limpiar"] {
            width: 100%;
            justify-content: center;
        }
        
        input[type="date"] {
            width: 140px;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM cargado - Auxiliar Contable');
        
        // Auto-submit cuando cambia la cuenta
        const cuentaSelect = document.querySelector('select[name="cuenta_id"]');
        if (cuentaSelect) {
            cuentaSelect.addEventListener('change', function() {
                document.getElementById('filtrosForm').submit();
            });
        }
        
        // Auto-submit cuando cambian las fechas
        const fechaInicio = document.querySelector('input[name="fecha_inicio"]');
        const fechaFin = document.querySelector('input[name="fecha_fin"]');
        
        if (fechaInicio) {
            fechaInicio.addEventListener('change', function() {
                document.getElementById('filtrosForm').submit();
            });
        }
        
        if (fechaFin) {
            fechaFin.addEventListener('change', function() {
                document.getElementById('filtrosForm').submit();
            });
        }
        
        // Feedback visual para botones
        const buttons = document.querySelectorAll('#buttonBusqueda, #buttonExcel');
        buttons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (this.id === 'buttonExcel') return; // El enlace ya maneja la navegación
                
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 200);
            });
        });
    });
</script>
@endsection