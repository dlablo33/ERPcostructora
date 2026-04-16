@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #2378e1; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Flujo de Dinero Mensual
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <label for="mes_inicio" style="font-weight: 600; color: #2378e1;">Desde:</label>
                        <select id="mes_inicio" style="padding: 8px 12px; border: 1px solid #2378e1; border-radius: 4px; font-size: 14px; width: 140px; background-color: white;">
                            <option value="2024-1">Ene 2024</option>
                            <option value="2024-2">Feb 2024</option>
                            <option value="2024-3">Mar 2024</option>
                            <option value="2024-4">Abr 2024</option>
                            <option value="2024-5">May 2024</option>
                            <option value="2024-6">Jun 2024</option>
                            <option value="2024-7">Jul 2024</option>
                            <option value="2024-8">Ago 2024</option>
                            <option value="2024-9">Sep 2024</option>
                            <option value="2024-10">Oct 2024</option>
                            <option value="2024-11">Nov 2024</option>
                            <option value="2024-12">Dic 2024</option>
                            <option value="2025-1">Ene 2025</option>
                            <option value="2025-2">Feb 2025</option>
                            <option value="2025-3">Mar 2025</option>
                            <option value="2025-4">Abr 2025</option>
                            <option value="2025-5">May 2025</option>
                            <option value="2025-6">Jun 2025</option>
                            <option value="2025-7">Jul 2025</option>
                            <option value="2025-8">Ago 2025</option>
                            <option value="2025-9">Sep 2025</option>
                            <option value="2025-10">Oct 2025</option>
                            <option value="2025-11">Nov 2025</option>
                            <option value="2025-12">Dic 2025</option>
                            <option value="2026-1">Ene 2026</option>
                            <option value="2026-2" selected>Feb 2026</option>
                            <option value="2026-3">Mar 2026</option>
                            <option value="2026-4">Abr 2026</option>
                            <option value="2026-5">May 2026</option>
                            <option value="2026-6">Jun 2026</option>
                            <option value="2026-7">Jul 2026</option>
                            <option value="2026-8">Ago 2026</option>
                            <option value="2026-9">Sep 2026</option>
                            <option value="2026-10">Oct 2026</option>
                            <option value="2026-11">Nov 2026</option>
                            <option value="2026-12">Dic 2026</option>
                        </select>

                        <label for="mes_fin" style="font-weight: 600; color: #2378e1;">Hasta:</label>
                        <select id="mes_fin" style="padding: 8px 12px; border: 1px solid #2378e1; border-radius: 4px; font-size: 14px; width: 140px; background-color: white;">
                            <option value="2024-1">Ene 2024</option>
                            <option value="2024-2">Feb 2024</option>
                            <option value="2024-3">Mar 2024</option>
                            <option value="2024-4">Abr 2024</option>
                            <option value="2024-5">May 2024</option>
                            <option value="2024-6">Jun 2024</option>
                            <option value="2024-7">Jul 2024</option>
                            <option value="2024-8">Ago 2024</option>
                            <option value="2024-9">Sep 2024</option>
                            <option value="2024-10">Oct 2024</option>
                            <option value="2024-11">Nov 2024</option>
                            <option value="2024-12">Dic 2024</option>
                            <option value="2025-1">Ene 2025</option>
                            <option value="2025-2">Feb 2025</option>
                            <option value="2025-3">Mar 2025</option>
                            <option value="2025-4">Abr 2025</option>
                            <option value="2025-5">May 2025</option>
                            <option value="2025-6">Jun 2025</option>
                            <option value="2025-7">Jul 2025</option>
                            <option value="2025-8">Ago 2025</option>
                            <option value="2025-9">Sep 2025</option>
                            <option value="2025-10">Oct 2025</option>
                            <option value="2025-11">Nov 2025</option>
                            <option value="2025-12">Dic 2025</option>
                            <option value="2026-1">Ene 2026</option>
                            <option value="2026-2">Feb 2026</option>
                            <option value="2026-3" selected>Mar 2026</option>
                            <option value="2026-4">Abr 2026</option>
                            <option value="2026-5">May 2026</option>
                            <option value="2026-6">Jun 2026</option>
                            <option value="2026-7">Jul 2026</option>
                            <option value="2026-8">Ago 2026</option>
                            <option value="2026-9">Sep 2026</option>
                            <option value="2026-10">Oct 2026</option>
                            <option value="2026-11">Nov 2026</option>
                            <option value="2026-12">Dic 2026</option>
                        </select>

                        <button id="btnExcel" 
                                style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #2378e1;">
                            <i class="fas fa-file-excel" style="color: #2378e1;"></i> Excel
                        </button>
                    </div>
                </div>

                <!-- Tabla -->
                <div class="table-responsive" style="margin-top: 10px; border: 1px solid #dee2e6; border-radius: 8px; overflow: auto;">
                    <table class="table table-bordered" id="tablaFlujoMensual" style="width: 100%; margin-bottom: 0; font-size: 12px;">
                        <thead id="theadDinamico" style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="min-width: 300px;">Cuentas</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr><td colspan="10" style="text-align: center; padding: 40px;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Cargando...</span>
                                </div>
                                <br>Cargando datos...
                            <\/td><\/tr>
                        </tbody>
                    </table>
                </div>
                
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-file-invoice" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay información para el período seleccionado</p>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .table th { background-color: #2378e1 !important; color: white; font-size: 12px; padding: 12px 8px; white-space: nowrap; }
    .table td { font-size: 12px; padding: 10px 8px; }
    .cuenta-principal { font-weight: bold; background-color: #f8f9fc !important; cursor: pointer; }
    .cuenta-principal:hover { background-color: #e9ecef !important; }
    .cuenta-principal i { transition: transform 0.2s; color: #2378e1; margin-right: 8px; }
    .subcuenta { padding-left: 30px !important; background-color: #ffffff; }
    .subcuenta:hover { background-color: #f2f2f2; }
    .text-right { text-align: right; }
    .text-danger { color: #dc3545 !important; }
    
    /* Optimización de rendimiento */
    .table-responsive {
        will-change: transform;
        contain: layout style paint;
    }
    
    .cuenta-principal, .subcuenta {
        contain: layout style;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
// Optimización: Usar requestIdleCallback para cargar datos sin bloquear la UI
document.addEventListener('DOMContentLoaded', function() {
    const mesInicioSelect = document.getElementById('mes_inicio');
    const mesFinSelect = document.getElementById('mes_fin');
    const btnExcel = document.getElementById('btnExcel');
    const tablaBody = document.getElementById('tablaBody');
    const theadDinamico = document.getElementById('theadDinamico');
    const sinDatosMensaje = document.getElementById('sinDatosMensaje');

    let datosExpandidos = { 1: false, 2: false };
    let cargando = false;

    function formatCurrency(amount) {
        if (amount === undefined || amount === null) amount = 0;
        const esNegativo = amount < 0;
        const valor = Math.abs(amount);
        const formateado = '$' + valor.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        return esNegativo ? `<span class="text-danger">-${formateado}</span>` : formateado;
    }

    function toggleExpand(cuentaId) {
        datosExpandidos[cuentaId] = !datosExpandidos[cuentaId];
        cargarDatos();
    }

    function mostrarLoading() {
        tablaBody.innerHTML = `<tr><td colspan="10" style="text-align: center; padding: 40px;">
            <div class="spinner-border text-primary" role="status" style="width: 2rem; height: 2rem;">
                <span class="sr-only">Cargando...</span>
            </div>
            <br>Cargando datos...
        <\/td><\/tr>`;
        sinDatosMensaje.style.display = 'none';
    }

    function cargarDatos() {
        if (cargando) return;
        cargando = true;
        
        const mesInicio = mesInicioSelect.value;
        const mesFin = mesFinSelect.value;
        
        mostrarLoading();
        
        const url = `/admin/api/flujo-mensual?mes_inicio=${mesInicio}&mes_fin=${mesFin}`;
        
        fetch(url, {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(result => {
            if (result.success && result.data) {
                renderizarTabla(result.data);
            } else {
                tablaBody.innerHTML = '<tr><td colspan="10" style="text-align: center; color: red;">Error al cargar datos<\/td><\/tr>';
                sinDatosMensaje.style.display = 'block';
            }
            cargando = false;
        })
        .catch(error => {
            console.error('Error:', error);
            tablaBody.innerHTML = '<tr><td colspan="10" style="text-align: center; color: red;">Error de conexión<\/td><\/tr>';
            sinDatosMensaje.style.display = 'block';
            cargando = false;
        });
    }

    function renderizarTabla(data) {
        const { cuentas, meses, totales_por_mes, acumulados_por_cuenta } = data;
        const acumulados = acumulados_por_cuenta || {};
        
        if (!cuentas || cuentas.length === 0 || !meses || meses.length === 0) {
            sinDatosMensaje.style.display = 'block';
            tablaBody.innerHTML = '';
            theadDinamico.innerHTML = '<tr><th>Cuentas</th></tr>';
            return;
        }

        sinDatosMensaje.style.display = 'none';
        
        // Generar encabezados
        let theadHTML = '<tr><th style="min-width: 300px;">Cuentas</th>';
        meses.forEach(mes => {
            theadHTML += `<th style="text-align: right; min-width: 120px;">${mes.nombre_corto} ${mes.anio}</th>`;
        });
        theadHTML += '<th style="text-align: right; min-width: 150px;">Acumulado</th></tr>';
        theadDinamico.innerHTML = theadHTML;
        
        // Generar cuerpo usando DocumentFragment para mejor rendimiento
        const fragment = document.createDocumentFragment();
        
        cuentas.forEach(cuenta => {
            const icono = datosExpandidos[cuenta.id] ? 'fa-chevron-down' : 'fa-chevron-right';
            
            // Calcular totales por mes
            let totalesCuenta = {};
            meses.forEach(mes => { totalesCuenta[mes.clave] = 0; });
            
            cuenta.subcuentas.forEach(sub => {
                meses.forEach(mes => {
                    totalesCuenta[mes.clave] += sub.meses[mes.clave] || 0;
                });
            });
            
            // Calcular acumulado
            let acumuladoCuenta = 0;
            cuenta.subcuentas.forEach(sub => {
                acumuladoCuenta += acumulados[sub.codigo] || 0;
            });
            
            // Fila principal
            const row = document.createElement('tr');
            row.className = 'cuenta-principal';
            row.setAttribute('data-cuenta-id', cuenta.id);
            row.style.cursor = 'pointer';
            
            let rowHTML = `<td style="font-weight: bold;">
                <i class="fas ${icono}" style="margin-right: 8px; color: #2378e1;"></i>
                ${cuenta.codigo} - ${cuenta.nombre}
            </td>`;
            
            meses.forEach(mes => {
                rowHTML += `<td class="text-right">${formatCurrency(totalesCuenta[mes.clave])}</td>`;
            });
            rowHTML += `<td class="text-right"><strong>${formatCurrency(acumuladoCuenta)}</strong></td>`;
            
            row.innerHTML = rowHTML;
            row.addEventListener('click', (e) => {
                if (e.target.classList.contains('fas')) {
                    toggleExpand(cuenta.id);
                } else {
                    toggleExpand(cuenta.id);
                }
            });
            fragment.appendChild(row);
            
            // Subcuentas si está expandido
            if (datosExpandidos[cuenta.id]) {
                cuenta.subcuentas.forEach(sub => {
                    const subRow = document.createElement('tr');
                    subRow.className = 'subcuenta';
                    let subHTML = `<td style="padding-left: 35px;">${sub.codigo} - ${sub.nombre}</td>`;
                    meses.forEach(mes => {
                        const valor = sub.meses[mes.clave] || 0;
                        subHTML += `<td class="text-right">${formatCurrency(valor)}</td>`;
                    });
                    const acumuladoSub = acumulados[sub.codigo] || 0;
                    subHTML += `<td class="text-right">${formatCurrency(acumuladoSub)}</td>`;
                    subRow.innerHTML = subHTML;
                    fragment.appendChild(subRow);
                });
            }
        });
        
        // Limpiar y agregar fragment
        tablaBody.innerHTML = '';
        tablaBody.appendChild(fragment);
    }

    // Event listeners
    mesInicioSelect.addEventListener('change', cargarDatos);
    mesFinSelect.addEventListener('change', cargarDatos);
    
    btnExcel.addEventListener('click', function() {
        const mesInicio = mesInicioSelect.value;
        const mesFin = mesFinSelect.value;
        window.location.href = `/admin/api/flujo-mensual/exportar-excel?mes_inicio=${mesInicio}&mes_fin=${mesFin}`;
    });

    // Cargar datos con requestIdleCallback para no bloquear la UI
    if (window.requestIdleCallback) {
        requestIdleCallback(() => cargarDatos());
    } else {
        setTimeout(cargarDatos, 100);
    }
});
</script>
@endsection