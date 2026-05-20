@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Estado de Resultados Operativo -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #2378e1; padding: 15px 20px;">
                <div style="display: flex; justify-content: center; align-items: center; position: relative; flex-wrap: wrap; gap: 15px;">
                    <h2 style="color: #2378e1; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                        Estado de Resultados Operativo - Construcción
                    </h2>
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <span style="color: #6c757d; font-size: 14px;">Período:</span>
                        <select id="periodoSelector" style="padding: 6px 12px; border: 1px solid #2378e1; border-radius: 4px; font-size: 14px; background-color: white; color: #2378e1; font-weight: 500;">
                            <option value="">Cargando períodos...</option>
                        </select>
                    </div>
                </div>
                <p style="color: #083CAE !important; font-size: 14px; margin: 5px 0 0 0; text-align: center;">
                    (Real vs Presupuesto)
                </p>
            </div>

            <div class="card-body p-4">
                <!-- Indicador de carga -->
                <div style="text-align: center; padding: 40px 20px; display: none;" id="loadingMensaje">
                    <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #2378e1; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Cargando datos...</h3>
                </div>

                <!-- Mensaje "Sin datos" -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-chart-line" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay información para el período seleccionado</p>
                </div>

                <!-- Mensaje de error -->
                <div style="text-align: center; padding: 40px 20px; background-color: #fee2e2; border: 1px solid #ef4444; border-radius: 8px; margin: 20px 0; display: none;" id="errorMensaje">
                    <i class="fas fa-exclamation-triangle" style="font-size: 48px; color: #ef4444; margin-bottom: 15px;"></i>
                    <h3 style="color: #dc2626; font-size: 18px; margin: 0;">Error al cargar datos</h3>
                    <p style="color: #991b1b; font-size: 14px; margin-top: 5px;" id="errorTexto">Intente nuevamente más tarde</p>
                </div>

                <!-- Tabla de Estado de Resultados -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaEstadoResultados" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: left; background-color: #2378e1; color: white; min-width: 300px;">Concepto</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #2378e1; color: white; min-width: 120px;">Real</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #2378e1; color: white; min-width: 80px;">%</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #2378e1; color: white; min-width: 120px;">Presupuesto</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #2378e1; color: white; min-width: 80px;">%</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #2378e1; color: white; min-width: 120px;">Diferencia</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #2378e1; color: white; min-width: 80px;">%</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr><td colspan="7" style="text-align: center; padding: 40px;">Seleccione un período para cargar datos</td></tr>
                        </tbody>
                        <tfoot id="tablaFoot" style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: left; background-color: #e9ecef; font-weight: bold;">TOTALES</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef;" id="totalReal">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef;" id="totalRealPorcentaje">0.00%</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef;" id="totalPresupuesto">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef;" id="totalPresupuestoPorcentaje">0.00%</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef;" id="totalDiferencia">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef;" id="totalDiferenciaPorcentaje">0.00%</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .semaforo .card-header { background-color: #f4f6f9; border-bottom: 2px solid #083CAE; }
    .semaforo .card-header h2 { color: #083CAE !important; }
    .table th { white-space: nowrap; font-size: 12px; background-color: #2378e1 !important; color: white; font-weight: 600; padding: 12px 8px; }
    .table td { white-space: nowrap; font-size: 12px; padding: 12px 8px; color: #000000 !important; }
    .fila-encabezado { background-color: #f0f4ff !important; font-weight: bold; cursor: pointer; }
    .fila-encabezado:hover { background-color: #e1f0ff !important; }
    .fila-encabezado i { transition: transform 0.2s; color: #083CAE; margin-right: 8px; }
    .fila-detalle { background-color: #ffffff; }
    .fila-detalle:hover { background-color: #f2f2f2; }
    .fila-detalle td:first-child { padding-left: 30px !important; }
    .fila-detalle:nth-child(even) { background-color: #fafbfc; }
    .text-danger { color: #dc3545 !important; }
    tfoot td { font-weight: bold; background-color: #e9ecef !important; border-top: 2px solid #2378e1; color: #000000 !important; }
    @media (max-width: 768px) { select { width: 100% !important; } .table-responsive { overflow-x: auto; } }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Estado de Resultados Construcción - Inicializado');
    
    let expandedHeaders = new Set();
    
    function formatCurrency(amount) {
        if (amount === undefined || amount === null) amount = 0;
        const signo = amount < 0 ? '-' : '';
        const valor = Math.abs(amount);
        return signo + '$' + valor.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }
    
    function calcularPorcentaje(valor, base) {
        if (base === 0 || base === undefined || valor === 0) return 0;
        return (valor / base) * 100;
    }
    
    function toggleExpand(id) {
        if (expandedHeaders.has(id)) expandedHeaders.delete(id);
        else expandedHeaders.add(id);
        renderizarTabla();
    }
    
    function renderizarTabla() {
        const tablaBody = document.getElementById('tablaBody');
        if (!tablaBody || !window.estructuraActual || !window.estructuraActual.length) return;
        
        tablaBody.innerHTML = '';
        let totalReal = 0, totalPresupuesto = 0;
        let baseReal = window.estructuraActual[0]?.real || 1;
        
        function renderConceptos(conceptos, nivel = 0) {
            for (let concepto of conceptos) {
                const real = concepto.real || 0;
                const presupuesto = concepto.presupuesto || 0;
                const diferencia = real - presupuesto;
                const porcReal = calcularPorcentaje(real, baseReal);
                const porcPres = calcularPorcentaje(presupuesto, baseReal);
                const porcDif = calcularPorcentaje(diferencia, baseReal);
                
                if (nivel === 0) {
                    totalReal += real;
                    totalPresupuesto += presupuesto;
                }
                
                const row = document.createElement('tr');
                
                if (concepto.esEncabezado) {
                    row.className = 'fila-encabezado';
                    const icono = expandedHeaders.has(concepto.id) ? 'fa-chevron-down' : 'fa-chevron-right';
                    row.innerHTML = `
                        <td style="font-weight: bold;"><i class="fas ${icono}" style="margin-right: 8px;"></i>${concepto.concepto}</td>
                        <td style="text-align: right; ${real < 0 ? 'color:#dc3545' : ''}">${formatCurrency(real)}</td>
                        <td style="text-align: right;">${porcReal.toFixed(2)}%</td>
                        <td style="text-align: right; ${presupuesto < 0 ? 'color:#dc3545' : ''}">${formatCurrency(presupuesto)}</td>
                        <td style="text-align: right;">${porcPres.toFixed(2)}%</td>
                        <td style="text-align: right; ${diferencia < 0 ? 'color:#dc3545' : ''}">${formatCurrency(diferencia)}</td>
                        <td style="text-align: right;">${porcDif.toFixed(2)}%</td>
                    `;
                    row.addEventListener('click', (e) => { e.stopPropagation(); toggleExpand(concepto.id); });
                } else {
                    row.className = 'fila-detalle';
                    row.innerHTML = `
                        <td style="padding-left: ${30 + (nivel * 20)}px;">${concepto.concepto}</td>
                        <td style="text-align: right; ${real < 0 ? 'color:#dc3545' : ''}">${formatCurrency(real)}</td>
                        <td style="text-align: right;">${porcReal.toFixed(2)}%</td>
                        <td style="text-align: right; ${presupuesto < 0 ? 'color:#dc3545' : ''}">${formatCurrency(presupuesto)}</td>
                        <td style="text-align: right;">${porcPres.toFixed(2)}%</td>
                        <td style="text-align: right; ${diferencia < 0 ? 'color:#dc3545' : ''}">${formatCurrency(diferencia)}</td>
                        <td style="text-align: right;">${porcDif.toFixed(2)}%</td>
                    `;
                }
                tablaBody.appendChild(row);
                
                if (concepto.esEncabezado && expandedHeaders.has(concepto.id) && concepto.subconceptos?.length) {
                    renderConceptos(concepto.subconceptos, nivel + 1);
                }
            }
        }
        
        renderConceptos(window.estructuraActual);
        
        const totalDif = totalReal - totalPresupuesto;
        document.getElementById('totalReal').textContent = formatCurrency(totalReal);
        document.getElementById('totalRealPorcentaje').textContent = totalReal !== 0 ? '100.00%' : '0.00%';
        document.getElementById('totalPresupuesto').textContent = formatCurrency(totalPresupuesto);
        document.getElementById('totalPresupuestoPorcentaje').textContent = totalPresupuesto !== 0 ? '100.00%' : '0.00%';
        document.getElementById('totalDiferencia').textContent = formatCurrency(totalDif);
        document.getElementById('totalDiferenciaPorcentaje').textContent = totalReal !== 0 ? ((totalDif / totalReal) * 100).toFixed(2) + '%' : '0.00%';
    }
    
    function cargarDatos(mes, anio) {
        const loading = document.getElementById('loadingMensaje');
        const sinDatos = document.getElementById('sinDatosMensaje');
        const errorDiv = document.getElementById('errorMensaje');
        const tabla = document.getElementById('tablaContainer');
        
        loading.style.display = 'block';
        sinDatos.style.display = 'none';
        errorDiv.style.display = 'none';
        tabla.style.display = 'block';
        
        fetch(`/api/estado-resultados/construccion?mes=${mes}&anio=${anio}`)
            .then(res => res.json())
            .then(result => {
                loading.style.display = 'none';
                if (result.success && result.estructura) {
                    window.estructuraActual = result.estructura;
                    renderizarTabla();
                } else {
                    sinDatos.style.display = 'block';
                    tabla.style.display = 'none';
                }
            })
            .catch(error => {
                loading.style.display = 'none';
                document.getElementById('errorTexto').textContent = error.message;
                errorDiv.style.display = 'block';
                tabla.style.display = 'none';
            });
    }
    
    function cargarPeriodos() {
        fetch('/api/estado-resultados/construccion/periodos')
            .then(res => res.json())
            .then(result => {
                const selector = document.getElementById('periodoSelector');
                if (result.success && result.periodos?.length) {
                    selector.innerHTML = '';
                    result.periodos.forEach(periodo => {
                        const option = document.createElement('option');
                        option.value = `${periodo.mes}|${periodo.anio}`;
                        option.textContent = periodo.label;
                        selector.appendChild(option);
                    });
                    const primero = result.periodos[0];
                    selector.value = `${primero.mes}|${primero.anio}`;
                    cargarDatos(primero.mes, primero.anio);
                } else {
                    selector.innerHTML = '<option value="">Error al cargar períodos</option>';
                }
            })
            .catch(error => {
                document.getElementById('periodoSelector').innerHTML = '<option value="">Error: ' + error.message + '</option>';
            });
    }
    
    document.getElementById('periodoSelector')?.addEventListener('change', function() {
        const [mes, anio] = this.value.split('|');
        if (mes && anio) cargarDatos(parseInt(mes), parseInt(anio));
    });
    
    cargarPeriodos();
});
</script>
@endsection