@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Movimientos Bancarios -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Movimientos Bancarios
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Fila con selector de bancos, fechas, buscar y botón Excel -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 15px; margin-bottom: 20px; flex-wrap: wrap;">
                    <!-- Selector de Cuentas Bancarias -->
                    <div style="display: flex; align-items: center; gap: 10px; flex: 2; min-width: 300px;">
                        <div style="font-weight: 600; color: #083CAE; white-space: nowrap;">Filtrar por Banco:</div>
                        <select id="selectCuenta" style="padding: 8px 12px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 100%; background-color: white;">
                            <option value="0">Todas las cuentas</option>
                            @php
                                use App\Models\CuentaBancaria;
                                $cuentas = CuentaBancaria::with('banco')->get();
                            @endphp
                            @foreach($cuentas as $cuenta)
                                <option value="{{ $cuenta->id }}">
                                    {{ $cuenta->banco->nombre ?? 'Banco' }} - {{ $cuenta->numero_cuenta }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Fechas -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div style="display: flex; align-items: center; gap: 5px;">
                            <span style="color: #083CAE;">Desde:</span>
                            <input type="date" id="fechaInicio" value="{{ date('Y-m-01') }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <div style="display: flex; align-items: center; gap: 5px;">
                            <span style="color: #083CAE;">Hasta:</span>
                            <input type="date" id="fechaFin" value="{{ date('Y-m-t') }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>
                        
                        <!-- Botón para aplicar filtros -->
                        <button id="btnFiltrar" style="background-color: #2378e1; border: none; border-radius: 4px; padding: 8px 16px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 8px; color: white; font-weight: 500;">
                            <i class="fas fa-filter"></i>
                            <span>Buscar</span>
                        </button>
                    </div>

                    <!-- Buscador y botón Excel -->
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #6c757d;"></i>
                            <input type="text" id="buscador" placeholder="Buscar movimiento..." style="padding: 8px 8px 8px 35px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>

                        <div>
                            <button id="btnExcel" 
                                    style="background-color: #28a745; border: 1px solid #28a745; border-radius: 4px; padding: 8px 16px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 8px; color: white; font-weight: 500;"
                                    title="Exportar a Excel">
                                <i class="fas fa-file-excel"></i>
                                <span>Excel</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 4 CUADROS DE RESUMEN -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 200px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Saldo Inicial</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="saldoInicial">$0.00</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 200px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Cargos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="totalCargos">$0.00</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 200px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Abonos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="totalAbonos">$0.00</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 200px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Saldo Final</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="saldoFinal">$0.00</div>
                        </div>
                    </div>
                </div>

                <!-- Loading Spinner -->
                <div id="loadingSpinner" style="text-align: center; padding: 40px; display: none;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #083CAE;"></i>
                    <p style="margin-top: 10px; color: #6c757d;">Cargando datos...</p>
                </div>

                <!-- Mensaje "Sin datos" -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-exchange-alt" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros para mostrar</p>
                </div>

                <!-- Tabla de Movimientos -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaMovimientos" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">Fecha</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">Folio</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">Referencia</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">Ref. Bancaria</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">Origen</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">Descripción</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">Cargos</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">Abonos</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">Saldo Final</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">Detalles</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody"></tbody>
                        <tfoot id="tablaFoot" style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="6" style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">Totales:</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;" id="sumCargos">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;" id="sumAbonos">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;" id="sumSaldoFinal">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 15px; gap: 5px;">
                    <button class="pagination-btn" id="btnPrimera" style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer;">
                        <i class="fas fa-angle-double-left"></i>
                    </button>
                    <button class="pagination-btn" id="btnAnterior" style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer;">
                        <i class="fas fa-angle-left"></i>
                    </button>
                    <span style="padding: 5px 10px; background-color: #2378e1; color: white; border-radius: 4px;" id="paginaActual">1</span>
                    <button class="pagination-btn" id="btnSiguiente" style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer;">
                        <i class="fas fa-angle-right"></i>
                    </button>
                    <button class="pagination-btn" id="btnUltima" style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer;">
                        <i class="fas fa-angle-double-right"></i>
                    </button>
                    <span style="margin-left: 10px; color: #6c757d;" id="paginacionInfo">Mostrando 0-0 de 0 registros</span>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .custom-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .custom-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(8, 60, 174, 0.15) !important;
    }
    .table th {
        white-space: nowrap;
        font-size: 12px;
        background-color: #2378e1 !important;
        color: white;
        font-weight: 600;
    }
    .table td {
        white-space: nowrap;
        font-size: 12px;
        color: #000000 !important;
    }
    #tablaBody tr:nth-child(odd) { background-color: #ffffff; }
    #tablaBody tr:nth-child(even) { background-color: #f2f2f2; }
    #tablaBody tr:hover { background-color: #e0e0e0; }
    tfoot td { font-weight: bold; background-color: #e9ecef !important; border-top: 2px solid #083CAE; }
    .pagination-btn:hover { background-color: #e9ecef !important; }
    .pagination-btn:disabled { opacity: 0.5; cursor: not-allowed; }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuración
    let datosOriginales = [];
    let datosFiltrados = [];
    let currentPage = 1;
    let rowsPerPage = 10;
    
    // Cargar datos iniciales
    cargarDatos();
    
    // Event Listeners
    document.getElementById('btnFiltrar')?.addEventListener('click', () => cargarDatos());
    document.getElementById('selectCuenta')?.addEventListener('change', () => cargarDatos());
    document.getElementById('fechaInicio')?.addEventListener('change', () => cargarDatos());
    document.getElementById('fechaFin')?.addEventListener('change', () => cargarDatos());
    document.getElementById('buscador')?.addEventListener('input', debounce(() => cargarDatos(), 500));
    document.getElementById('btnExcel')?.addEventListener('click', exportToExcel);
    
    // Eventos de paginación
    document.getElementById('btnPrimera')?.addEventListener('click', () => { currentPage = 1; renderTable(); });
    document.getElementById('btnAnterior')?.addEventListener('click', () => { if (currentPage > 1) { currentPage--; renderTable(); } });
    document.getElementById('btnSiguiente')?.addEventListener('click', () => { const maxPage = Math.ceil(datosFiltrados.length / rowsPerPage); if (currentPage < maxPage) { currentPage++; renderTable(); } });
    document.getElementById('btnUltima')?.addEventListener('click', () => { currentPage = Math.ceil(datosFiltrados.length / rowsPerPage); renderTable(); });
    
    // Funciones auxiliares
    function formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        return date.toLocaleDateString('es-MX');
    }
    
    function formatCurrency(amount) {
        if (amount === null || amount === undefined) return '$0.00';
        return '$' + parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }
    
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => { clearTimeout(timeout); func(...args); };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    // Cargar datos desde el backend
    async function cargarDatos() {
        mostrarLoading(true);
        
        try {
            const params = new URLSearchParams({
                cuenta_id: document.getElementById('selectCuenta').value,
                fecha_inicio: document.getElementById('fechaInicio').value,
                fecha_fin: document.getElementById('fechaFin').value,
                busqueda: document.getElementById('buscador').value
            });
            
            // Usar la ruta con autenticación
            const response = await fetch(`/movimientos-bancarios-data?${params.toString()}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin'
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            
            if (result.success) {
                datosOriginales = result.data;
                datosFiltrados = [...datosOriginales];
                currentPage = 1;
                
                // Actualizar resumen
                if (result.resumen) {
                    document.getElementById('saldoInicial').textContent = formatCurrency(result.resumen.saldo_inicial);
                    document.getElementById('totalCargos').textContent = formatCurrency(result.resumen.total_cargos);
                    document.getElementById('totalAbonos').textContent = formatCurrency(result.resumen.total_abonos);
                    document.getElementById('saldoFinal').textContent = formatCurrency(result.resumen.saldo_final);
                }
                
                renderTable();
            } else {
                console.error('Error en la respuesta:', result.message);
                mostrarSinDatos(true);
            }
        } catch (error) {
            console.error('Error cargando datos:', error);
            mostrarSinDatos(true);
        } finally {
            mostrarLoading(false);
        }
    }
    
    // Renderizar tabla
    function renderTable() {
        const tbody = document.getElementById('tablaBody');
        const sinDatosMensaje = document.getElementById('sinDatosMensaje');
        const tablaContainer = document.getElementById('tablaContainer');
        
        if (!datosFiltrados || datosFiltrados.length === 0) {
            mostrarSinDatos(true);
            tbody.innerHTML = '';
            document.getElementById('sumCargos').textContent = formatCurrency(0);
            document.getElementById('sumAbonos').textContent = formatCurrency(0);
            document.getElementById('sumSaldoFinal').textContent = formatCurrency(0);
            document.getElementById('paginacionInfo').textContent = 'Mostrando 0-0 de 0 registros';
            return;
        }
        
        mostrarSinDatos(false);
        
        // Paginación
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const pageData = datosFiltrados.slice(start, end);
        
        // Calcular totales
        const totalCargos = datosFiltrados.reduce((sum, item) => sum + (parseFloat(item.cargos) || 0), 0);
        const totalAbonos = datosFiltrados.reduce((sum, item) => sum + (parseFloat(item.abonos) || 0), 0);
        const totalSaldoFinal = datosFiltrados.length > 0 ? datosFiltrados[datosFiltrados.length - 1].saldo_final : 0;
        
        document.getElementById('sumCargos').textContent = formatCurrency(totalCargos);
        document.getElementById('sumAbonos').textContent = formatCurrency(totalAbonos);
        document.getElementById('sumSaldoFinal').textContent = formatCurrency(totalSaldoFinal);
        
        // Generar filas
        tbody.innerHTML = pageData.map(item => `
            <tr>
                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${formatDate(item.fecha)}</td>
                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.folio || '-'}</td>
                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.referencia || '-'}</td>
                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.ref_bancaria || '-'}</td>
                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.origen || '-'}</td>
                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.descripcion || '-'}</td>
                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${item.cargos ? formatCurrency(item.cargos) : '-'}</td>
                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${item.abonos ? formatCurrency(item.abonos) : '-'}</td>
                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${item.saldo_final ? formatCurrency(item.saldo_final) : '-'}</td>
                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">
                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver detalles" data-id="${item.id}"></i>
                    <i class="fas fa-print" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Imprimir" data-id="${item.id}"></i>
                </td>
            </tr>
        `).join('');
        
        // Actualizar información de paginación
        const totalPages = Math.ceil(datosFiltrados.length / rowsPerPage);
        document.getElementById('paginaActual').textContent = currentPage;
        document.getElementById('paginacionInfo').textContent = `Mostrando ${start + 1}-${Math.min(end, datosFiltrados.length)} de ${datosFiltrados.length} registros`;
        
        // Actualizar estado de botones de paginación
        document.getElementById('btnPrimera').disabled = currentPage === 1;
        document.getElementById('btnAnterior').disabled = currentPage === 1;
        document.getElementById('btnSiguiente').disabled = currentPage === totalPages || totalPages === 0;
        document.getElementById('btnUltima').disabled = currentPage === totalPages || totalPages === 0;
        
        // Agregar event listeners a los iconos
        document.querySelectorAll('#tablaBody i.fa-eye').forEach(icon => {
            icon.addEventListener('click', () => verDetalle(icon.dataset.id));
        });
        document.querySelectorAll('#tablaBody i.fa-print').forEach(icon => {
            icon.addEventListener('click', () => imprimirMovimiento(icon.dataset.id));
        });
    }
    
    function mostrarLoading(show) {
        const spinner = document.getElementById('loadingSpinner');
        const tablaContainer = document.getElementById('tablaContainer');
        const sinDatosMensaje = document.getElementById('sinDatosMensaje');
        if (show) {
            spinner.style.display = 'block';
            tablaContainer.style.display = 'none';
            sinDatosMensaje.style.display = 'none';
        } else {
            spinner.style.display = 'none';
        }
    }
    
    function mostrarSinDatos(show) {
        const mensaje = document.getElementById('sinDatosMensaje');
        const tablaContainer = document.getElementById('tablaContainer');
        if (show) {
            mensaje.style.display = 'block';
            tablaContainer.style.display = 'none';
        } else {
            mensaje.style.display = 'none';
            tablaContainer.style.display = 'block';
        }
    }
    
    function verDetalle(id) {
        window.location.href = `/movimientos/${id}`;
    }
    
    function imprimirMovimiento(id) {
        window.open(`/movimientos/${id}/print`, '_blank');
    }
    
    function exportToExcel() {
        if (!datosFiltrados || datosFiltrados.length === 0) {
            alert('No hay datos para exportar');
            return;
        }
        
        // Crear tabla para exportar
        let excelContent = `
            <table border="1">
                <thead>
                    <tr>
                        <th>Fecha</th><th>Folio</th><th>Referencia</th><th>Ref. Bancaria</th>
                        <th>Origen</th><th>Descripción</th><th>Cargos</th><th>Abonos</th><th>Saldo Final</th>
                    </tr>
                </thead>
                <tbody>
        `;
        
        datosFiltrados.forEach(item => {
            excelContent += `
                <tr>
                    <td>${item.fecha || ''}</td>
                    <td>${item.folio || ''}</td>
                    <td>${item.referencia || ''}</td>
                    <td>${item.ref_bancaria || ''}</td>
                    <td>${item.origen || ''}</td>
                    <td>${item.descripcion || ''}</td>
                    <td>${item.cargos || 0}</td>
                    <td>${item.abonos || 0}</td>
                    <td>${item.saldo_final || 0}</td>
                </tr>
            `;
        });
        
        excelContent += '</tbody></table>';
        
        const blob = new Blob([excelContent], { type: 'application/vnd.ms-excel' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        link.href = url;
        link.download = `movimientos_bancarios_${new Date().toISOString().split('T')[0]}.xls`;
        link.click();
        URL.revokeObjectURL(url);
    }
});
</script>
@endsection