@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="card mt-2">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 22px;">
                            <i class="fas fa-balance-scale"></i> Balance General
                        </h2>
                        <p style="color: #6c757d; font-size: 13px; margin: 5px 0 0 0;">
                            Selecciona proyectos para filtrar
                        </p>
                    </div>
                    <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                        <select id="anioSelector" class="form-control" style="width: 100px; border-color: #083CAE;">
                            @foreach($aniosDisponibles as $year)
                                <option value="{{ $year }}" {{ $anio == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                        <select id="mesSelector" class="form-control" style="width: 130px; border-color: #083CAE;">
                            @foreach($meses as $num => $nombre)
                                <option value="{{ $num }}" {{ $mes == $num ? 'selected' : '' }}>{{ $nombre }}</option>
                            @endforeach
                        </select>
                        
                        <!-- Selector de proyectos -->
                        <div class="dropdown" style="position: relative;">
                            <button id="btnSeleccionarProyectos" type="button" class="btn" style="background-color: #083CAE; color: white; border: none; padding: 6px 15px; border-radius: 4px;">
                                <i class="fas fa-check-square"></i> Proyectos 
                                <span id="proyectosCount" class="badge" style="background-color: #ffc107; color: #333; margin-left: 5px;">0</span>
                            </button>
                            <div id="panelProyectos" class="dropdown-menu" style="display: none; position: absolute; top: 100%; right: 0; background: white; border: 1px solid #dee2e6; border-radius: 8px; width: 380px; max-height: 420px; overflow-y: auto; z-index: 1000; box-shadow: 0 4px 12px rgba(0,0,0,0.15); margin-top: 5px;">
                                <div style="padding: 12px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; border-radius: 8px 8px 0 0;">
                                    <div style="display: flex; gap: 10px;">
                                        <button id="btnSeleccionarTodos" type="button" class="btn btn-sm" style="background-color: #28a745; color: white; border: none; padding: 5px 12px; border-radius: 4px;">
                                            <i class="fas fa-check-double"></i> Todos
                                        </button>
                                        <button id="btnLimpiarSeleccion" type="button" class="btn btn-sm" style="background-color: #6c757d; color: white; border: none; padding: 5px 12px; border-radius: 4px;">
                                            <i class="fas fa-times"></i> Ninguno
                                        </button>
                                    </div>
                                </div>
                                <div id="listaProyectos" style="padding: 10px; max-height: 320px; overflow-y: auto;">
                                    @foreach($proyectos as $proyecto)
                                        <div class="checkbox-item" style="margin-bottom: 10px; padding: 8px; border-radius: 6px; transition: background-color 0.2s;">
                                            <label style="display: flex; align-items: center; cursor: pointer; margin: 0; width: 100%;">
                                                <input type="checkbox" class="proyecto-checkbox" value="{{ $proyecto->id }}" 
                                                    data-codigo="{{ $proyecto->codigo }}"
                                                    data-nombre="{{ $proyecto->nombre }}"
                                                    style="margin-right: 12px; width: 16px; height: 16px;">
                                                <span style="font-size: 13px;">
                                                    <strong style="color: #083CAE;">{{ $proyecto->codigo }}</strong> - {{ Str::limit($proyecto->nombre, 45) }}
                                                </span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        <button id="btnFiltrar" class="btn" style="background-color: #083CAE; color: white; border: none; padding: 6px 18px; border-radius: 4px;">
                            <i class="fas fa-sync-alt"></i> Actualizar
                        </button>
                        <button id="btnExportarExcel" class="btn" style="background-color: #28a745; color: white; border: none; padding: 6px 18px; border-radius: 4px;">
                            <i class="fas fa-file-excel"></i> Excel
                        </button>
                    </div>
                </div>
                <div class="mt-2" id="proyectosSeleccionadosInfo" style="font-size: 12px; color: #083CAE;">
                    <i class="fas fa-info-circle"></i> Selecciona uno o más proyectos para filtrar
                </div>
            </div>

            <div class="card-body p-4">
                <!-- Métricas resumen -->
                <div style="display: flex; gap: 1px; margin-bottom: 25px; background: #dee2e6; border-radius: 8px; overflow: hidden; flex-wrap: wrap;">
                    <div style="flex: 1; background: #fff; padding: 15px; text-align: center;">
                        <div style="font-size: 11px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px;">Período</div>
                        <div style="font-size: 16px; font-weight: bold; color: #083CAE;" id="periodoTexto">{{ $meses[$mes] }} {{ $anio }}</div>
                    </div>
                    <div style="flex: 1; background: #fff; padding: 15px; text-align: center;">
                        <div style="font-size: 11px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px;">Total Activo</div>
                        <div style="font-size: 18px; font-weight: bold; color: #28a745;" id="totalActivoSpan">$0.00</div>
                    </div>
                    <div style="flex: 1; background: #fff; padding: 15px; text-align: center;">
                        <div style="font-size: 11px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px;">Total Pasivo</div>
                        <div style="font-size: 18px; font-weight: bold; color: #dc3545;" id="totalPasivoSpan">$0.00</div>
                    </div>
                    <div style="flex: 1; background: #fff; padding: 15px; text-align: center;">
                        <div style="font-size: 11px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px;">Total Capital</div>
                        <div style="font-size: 18px; font-weight: bold; color: #17a2b8;" id="totalCapitalSpan">$0.00</div>
                    </div>
                </div>

                <!-- Mensaje sin datos -->
                <div id="sinDatosMensaje" style="text-align: center; padding: 50px; background: #f8f9fa; border-radius: 8px; display: none;">
                    <i class="fas fa-balance-scale" style="font-size: 56px; color: #adb5bd;"></i>
                    <h4 style="color: #6c757d; margin-top: 15px;">No hay datos disponibles</h4>
                    <p style="color: #adb5bd; font-size: 14px;">Seleccione uno o más proyectos para ver los datos</p>
                </div>

                <!-- Botones de expansión -->
 

                <!-- Tabla de Balance General -->
                <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;">
                    <table class="table table-bordered" id="tablaResultados" style="width: 100%; font-size: 13px; margin-bottom: 0;">
                        <thead id="tablaHeader">
                            <tr style="background-color: #083CAE; color: white;">
                                <th style="width: 40px; text-align: center; padding: 12px 8px;"></th>
                                <th style="width: 220px; padding: 12px 8px;">Cuenta</th>
                                <th style="width: 120px; padding: 12px 8px;">Código</th>
                                <th style="text-align: right; min-width: 140px; padding: 12px 8px;">Saldo</th>
                                <th style="text-align: right; min-width: 90px; background-color: #2c3e50; color: white; padding: 12px 8px;">%</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <td><td colspan="5" style="text-align: center; padding: 40px;">Cargando datos...<\/td></tr>
                        </tbody>
                        <tfoot id="tablaFooter"></tfoot>
                    </table>
                </div>
            </div>
            
            <div class="card-footer text-center" style="background-color: #f8f9fa; font-size: 11px; color: #6c757d; border-top: 1px solid #dee2e6; padding: 12px;">
                <i class="fas fa-info-circle"></i> Reporte generado el {{ now()->format('d/m/Y H:i:s') }}
            </div>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Datos desde el controlador
    const anio = {{ $anio }};
    const mes = {{ $mes }};
    const proyectosData = @json($proyectos);
    const datosBalance = @json($datosBalance);
    let proyectosSeleccionados = @json($proyectosSeleccionados ?? []);
    
    // Estado de expansión
    let expandedGroups = new Set(['activo', 'pasivo', 'capital']);
    
    function formatCurrency(amount) {
        if (amount === undefined || amount === null || isNaN(amount)) amount = 0;
        return '$' + parseFloat(amount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }
    
    // Panel de selección
    const btnSeleccionar = document.getElementById('btnSeleccionarProyectos');
    const panelProyectos = document.getElementById('panelProyectos');
    
    if (btnSeleccionar) {
        btnSeleccionar.addEventListener('click', function(e) {
            e.stopPropagation();
            panelProyectos.style.display = panelProyectos.style.display === 'none' ? 'block' : 'none';
        });
    }
    
    document.addEventListener('click', function(event) {
        if (panelProyectos && btnSeleccionar) {
            if (!panelProyectos.contains(event.target) && !btnSeleccionar.contains(event.target)) {
                panelProyectos.style.display = 'none';
            }
        }
    });
    
    function actualizarContadorProyectos() {
        const checkboxes = document.querySelectorAll('.proyecto-checkbox:checked');
        const count = checkboxes.length;
        const countSpan = document.getElementById('proyectosCount');
        if (countSpan) {
            countSpan.textContent = count;
            countSpan.style.backgroundColor = count > 0 ? '#28a745' : '#ffc107';
        }
        
        proyectosSeleccionados = Array.from(checkboxes).map(cb => parseInt(cb.value));
        
        const infoDiv = document.getElementById('proyectosSeleccionadosInfo');
        if (count > 0) {
            const nombres = proyectosSeleccionados.map(id => {
                const p = proyectosData.find(p => p.id == id);
                return p ? p.codigo : '';
            }).join(', ');
            infoDiv.innerHTML = `<i class="fas fa-check-circle" style="color: #28a745;"></i> <strong>${count}</strong> proyecto(s) seleccionado(s): ${nombres}`;
        } else {
            infoDiv.innerHTML = '<i class="fas fa-info-circle"></i> Selecciona uno o más proyectos para filtrar';
        }
        return count;
    }
    
    // Seleccionar todos
    const btnSeleccionarTodos = document.getElementById('btnSeleccionarTodos');
    if (btnSeleccionarTodos) {
        btnSeleccionarTodos.addEventListener('click', function() {
            document.querySelectorAll('.proyecto-checkbox').forEach(cb => cb.checked = true);
            actualizarContadorProyectos();
            renderTabla();
            if (panelProyectos) panelProyectos.style.display = 'none';
        });
    }
    
    // Limpiar selección
    const btnLimpiarSeleccion = document.getElementById('btnLimpiarSeleccion');
    if (btnLimpiarSeleccion) {
        btnLimpiarSeleccion.addEventListener('click', function() {
            document.querySelectorAll('.proyecto-checkbox').forEach(cb => cb.checked = false);
            actualizarContadorProyectos();
            renderTabla();
            if (panelProyectos) panelProyectos.style.display = 'none';
        });
    }
    
    // Cambio de checkbox
    document.querySelectorAll('.proyecto-checkbox').forEach(cb => {
        cb.addEventListener('change', function() {
            actualizarContadorProyectos();
            renderTabla();
        });
    });
    
    // Calcular saldos por proyecto según los proyectos seleccionados
    function calcularSaldosPorProyecto() {
        let saldoBancos = datosBalance.saldoBancos || 0;
        let totalClientes = 0;
        let totalInventario = 0;
        let totalActivosFijos = 0;
        let totalProveedores = datosBalance.totalProveedores || 0;
        let impuestosPorPagar = 0;
        let prestamos = datosBalance.prestamos || 0;
        let ingresos = 0;
        let gastos = 0;
        
        let clientesDetalle = [];
        let inventarioDetalle = [];
        let activosFijosDetalle = [];
        let proveedoresDetalle = datosBalance.proveedores || [];
        
        // Si no hay proyectos seleccionados, sumar todos
        const usarTodos = proyectosSeleccionados.length === 0;
        
        for (const proy of proyectosData) {
            const incluir = usarTodos || proyectosSeleccionados.includes(proy.id);
            if (!incluir) continue;
            
            // Clientes
            if (datosBalance.clientesPorProyecto && datosBalance.clientesPorProyecto[proy.id]) {
                for (const cliente of datosBalance.clientesPorProyecto[proy.id]) {
                    totalClientes += cliente.saldo;
                    clientesDetalle.push({
                        id: cliente.contacto_id,
                        nombre: cliente.razon_social,
                        saldo: cliente.saldo
                    });
                }
            }
            
            // Inventario
            if (datosBalance.inventarioPorProyecto && datosBalance.inventarioPorProyecto[proy.id]) {
                for (const item of datosBalance.inventarioPorProyecto[proy.id]) {
                    totalInventario += item.valor;
                    inventarioDetalle.push({
                        codigo: item.codigo,
                        nombre: item.articulo,
                        valor: item.valor
                    });
                }
            }
            
            // Activos fijos
            if (datosBalance.activosFijosPorProyecto && datosBalance.activosFijosPorProyecto[proy.id]) {
                for (const item of datosBalance.activosFijosPorProyecto[proy.id]) {
                    totalActivosFijos += item.valor;
                    activosFijosDetalle.push({
                        codigo: item.codigo,
                        nombre: item.nombre,
                        valor: item.valor
                    });
                }
            }
            
            // Impuestos
            if (datosBalance.impuestosPorProyecto && datosBalance.impuestosPorProyecto[proy.id]) {
                impuestosPorPagar += datosBalance.impuestosPorProyecto[proy.id];
            }
            
            // Ingresos y gastos para utilidad
            if (datosBalance.ingresosPorProyecto && datosBalance.ingresosPorProyecto[proy.id]) {
                ingresos += datosBalance.ingresosPorProyecto[proy.id];
            }
            if (datosBalance.gastosPorProyecto && datosBalance.gastosPorProyecto[proy.id]) {
                gastos += datosBalance.gastosPorProyecto[proy.id];
            }
        }
        
        const utilidad = ingresos - gastos;
        const totalActivo = saldoBancos + totalClientes + totalInventario + totalActivosFijos;
        const totalPasivo = totalProveedores + impuestosPorPagar + prestamos;
        const capitalSocial = totalActivo - totalPasivo - utilidad;
        const totalCapital = capitalSocial + utilidad;
        
        return {
            saldoBancos,
            totalClientes,
            totalInventario,
            totalActivosFijos,
            totalProveedores,
            impuestosPorPagar,
            prestamos,
            utilidad,
            capitalSocial,
            totalActivo,
            totalPasivo,
            totalCapital,
            clientesDetalle: clientesDetalle.slice(0, 20),
            inventarioDetalle: inventarioDetalle.slice(0, 20),
            activosFijosDetalle: activosFijosDetalle.slice(0, 20),
            proveedoresDetalle: proveedoresDetalle.slice(0, 20)
        };
    }
    
    function toggleGroup(groupName) {
        if (expandedGroups.has(groupName)) {
            expandedGroups.delete(groupName);
        } else {
            expandedGroups.add(groupName);
        }
        renderTabla();
    }
    
    function expandirTodo() {
        expandedGroups.add('activo');
        expandedGroups.add('activoCorto');
        expandedGroups.add('activoLargo');
        expandedGroups.add('pasivo');
        expandedGroups.add('pasivoCorto');
        expandedGroups.add('pasivoLargo');
        expandedGroups.add('capital');
        renderTabla();
    }
    
    function contraerTodo() {
        expandedGroups.clear();
        expandedGroups.add('activo');
        expandedGroups.add('pasivo');
        expandedGroups.add('capital');
        renderTabla();
    }
    
    function renderTabla() {
        const tbody = document.getElementById('tablaBody');
        if (!tbody) return;
        
        const saldos = calcularSaldosPorProyecto();
        const totalActivo = saldos.totalActivo;
        
        // Actualizar métricas
        document.getElementById('totalActivoSpan').textContent = formatCurrency(saldos.totalActivo);
        document.getElementById('totalPasivoSpan').textContent = formatCurrency(saldos.totalPasivo);
        document.getElementById('totalCapitalSpan').textContent = formatCurrency(saldos.totalCapital);
        
        if (proyectosSeleccionados.length === 0) {
            document.getElementById('sinDatosMensaje').style.display = 'block';
            document.getElementById('tablaHeader').innerHTML = '<tr style="background-color: #083CAE; color: white;"><th style="width: 40px; text-align: center; padding: 12px 8px;"></th><th style="width: 220px; padding: 12px 8px;">Cuenta</th><th style="width: 120px; padding: 12px 8px;">Código</th><th style="text-align: right; min-width: 140px; padding: 12px 8px;">Saldo</th><th style="text-align: right; min-width: 90px; background-color: #2c3e50; color: white; padding: 12px 8px;">%</th></tr>';
            tbody.innerHTML = '<tr><td colspan="5" style="text-align: center; padding: 40px;">Seleccione proyectos para visualizar datos<\/td></tr>';
            return;
        }
        
        document.getElementById('sinDatosMensaje').style.display = 'none';
        
        // Construir encabezado
        let headerHtml = '<tr style="background-color: #083CAE; color: white;">';
        headerHtml += '<th style="width: 40px; text-align: center; padding: 12px 8px;"></th>';
        headerHtml += '<th style="width: 220px; padding: 12px 8px;">Cuenta</th>';
        headerHtml += '<th style="width: 120px; padding: 12px 8px;">Código</th>';
        headerHtml += '<th style="text-align: right; min-width: 140px; padding: 12px 8px;">Saldo</th>';
        headerHtml += '<th style="text-align: right; min-width: 90px; background-color: #2c3e50; color: white; padding: 12px 8px;">%</th>';
        headerHtml += '</tr>';
        document.getElementById('tablaHeader').innerHTML = headerHtml;
        
        // ==================== ACTIVO ====================
        const isActivoExpanded = expandedGroups.has('activo');
        const activoIcon = isActivoExpanded ? 'fa-minus-square' : 'fa-plus-square';
        
        let html = `<tr style="background-color: #d4edda; cursor: pointer; font-weight: bold;" onclick="toggleGroup('activo')">
            <td style="text-align: center; padding: 12px 8px;"><i class="fas ${activoIcon}" style="color: #155724;"></i></td>
            <td style="padding: 12px 8px;">ACTIVO</td>
            <td style="padding: 12px 8px;"><code>100</code></td>
            <td style="text-align: right; padding: 12px 8px;">${formatCurrency(saldos.totalActivo)}</td>
            <td style="text-align: right; padding: 12px 8px;">100%</td>
        </tr>`;
        
        if (isActivoExpanded) {
            // Activo a corto plazo (100.01)
            const isActivoCortoExpanded = expandedGroups.has('activoCorto');
            const activoCortoIcon = isActivoCortoExpanded ? 'fa-minus-square' : 'fa-plus-square';
            const activoCortoTotal = saldos.saldoBancos + saldos.totalClientes + saldos.totalInventario;
            
            html += `<tr style="background-color: #e8f5e9; cursor: pointer;" onclick="toggleGroup('activoCorto')">
                <td style="text-align: center; padding: 10px 8px;"><i class="fas ${activoCortoIcon}" style="color: #2e7d32;"></i></td>
                <td style="padding: 10px 8px; padding-left: 20px;">Activo a corto plazo</td>
                <td style="padding: 10px 8px;"><code>100.01</code></td>
                <td style="text-align: right; padding: 10px 8px;">${formatCurrency(activoCortoTotal)}</td>
                <td style="text-align: right; padding: 10px 8px;">${saldos.totalActivo > 0 ? ((activoCortoTotal / saldos.totalActivo) * 100).toFixed(2) : 0}%</td>
            </tr>`;
            
            if (isActivoCortoExpanded) {
                // Efectivo (101)
                html += `<tr>
                    <td style="padding: 8px 8px;">&nbsp;</td>
                    <td style="padding: 8px 8px; padding-left: 40px;">Efectivo y equivalentes</td>
                    <td style="padding: 8px 8px;"><code>101</code></td>
                    <td style="text-align: right; padding: 8px 8px;">${formatCurrency(saldos.saldoBancos)}</td>
                    <td style="text-align: right; padding: 8px 8px;">${saldos.totalActivo > 0 ? ((saldos.saldoBancos / saldos.totalActivo) * 100).toFixed(2) : 0}%</td>
                </tr>`;
                
                // Cuentas por cobrar (102)
                html += `<tr>
                    <td style="padding: 8px 8px;">&nbsp;</td>
                    <td style="padding: 8px 8px; padding-left: 40px;">Cuentas por cobrar</td>
                    <td style="padding: 8px 8px;"><code>102</code></td>
                    <td style="text-align: right; padding: 8px 8px;">${formatCurrency(saldos.totalClientes)}</td>
                    <td style="text-align: right; padding: 8px 8px;">${saldos.totalActivo > 0 ? ((saldos.totalClientes / saldos.totalActivo) * 100).toFixed(2) : 0}%</td>
                </tr>`;
                
                // Inventarios (103)
                html += `<tr>
                    <td style="padding: 8px 8px;">&nbsp;</td>
                    <td style="padding: 8px 8px; padding-left: 40px;">Inventarios</td>
                    <td style="padding: 8px 8px;"><code>103</code></td>
                    <td style="text-align: right; padding: 8px 8px;">${formatCurrency(saldos.totalInventario)}</td>
                    <td style="text-align: right; padding: 8px 8px;">${saldos.totalActivo > 0 ? ((saldos.totalInventario / saldos.totalActivo) * 100).toFixed(2) : 0}%</td>
                </tr>`;
            }
            
            // Activo a largo plazo (100.02)
            const isActivoLargoExpanded = expandedGroups.has('activoLargo');
            const activoLargoIcon = isActivoLargoExpanded ? 'fa-minus-square' : 'fa-plus-square';
            
            html += `<tr style="background-color: #e8f5e9; cursor: pointer;" onclick="toggleGroup('activoLargo')">
                <td style="text-align: center; padding: 10px 8px;"><i class="fas ${activoLargoIcon}" style="color: #2e7d32;"></i></td>
                <td style="padding: 10px 8px; padding-left: 20px;">Activo a largo plazo</td>
                <td style="padding: 10px 8px;"><code>100.02</code></td>
                <td style="text-align: right; padding: 10px 8px;">${formatCurrency(saldos.totalActivosFijos)}</td>
                <td style="text-align: right; padding: 10px 8px;">${saldos.totalActivo > 0 ? ((saldos.totalActivosFijos / saldos.totalActivo) * 100).toFixed(2) : 0}%</td>
            </tr>`;
            
            if (isActivoLargoExpanded) {
                html += `<tr>
                    <td style="padding: 8px 8px;">&nbsp;</td>
                    <td style="padding: 8px 8px; padding-left: 40px;">Activos fijos</td>
                    <td style="padding: 8px 8px;"><code>104</code></td>
                    <td style="text-align: right; padding: 8px 8px;">${formatCurrency(saldos.totalActivosFijos)}</td>
                    <td style="text-align: right; padding: 8px 8px;">${saldos.totalActivo > 0 ? ((saldos.totalActivosFijos / saldos.totalActivo) * 100).toFixed(2) : 0}%</td>
                </tr>`;
            }
        }
        
        // ==================== PASIVO ====================
        const isPasivoExpanded = expandedGroups.has('pasivo');
        const pasivoIcon = isPasivoExpanded ? 'fa-minus-square' : 'fa-plus-square';
        
        html += `<tr style="background-color: #f8d7da; cursor: pointer; font-weight: bold;" onclick="toggleGroup('pasivo')">
            <td style="text-align: center; padding: 12px 8px;"><i class="fas ${pasivoIcon}" style="color: #721c24;"></i></td>
            <td style="padding: 12px 8px;">PASIVO</td>
            <td style="padding: 12px 8px;"><code>200</code></td>
            <td style="text-align: right; padding: 12px 8px;">${formatCurrency(saldos.totalPasivo)}</td>
            <td style="text-align: right; padding: 12px 8px;">${saldos.totalActivo > 0 ? ((saldos.totalPasivo / saldos.totalActivo) * 100).toFixed(2) : 0}%</td>
        </tr>`;
        
        if (isPasivoExpanded) {
            // Pasivo a corto plazo (200.01)
            const isPasivoCortoExpanded = expandedGroups.has('pasivoCorto');
            const pasivoCortoIcon = isPasivoCortoExpanded ? 'fa-minus-square' : 'fa-plus-square';
            const pasivoCortoTotal = saldos.totalProveedores + saldos.impuestosPorPagar;
            
            html += `<tr style="background-color: #fce4d6; cursor: pointer;" onclick="toggleGroup('pasivoCorto')">
                <td style="text-align: center; padding: 10px 8px;"><i class="fas ${pasivoCortoIcon}" style="color: #a94442;"></i></td>
                <td style="padding: 10px 8px; padding-left: 20px;">Pasivo a corto plazo</td>
                <td style="padding: 10px 8px;"><code>200.01</code></td>
                <td style="text-align: right; padding: 10px 8px;">${formatCurrency(pasivoCortoTotal)}</td>
                <td style="text-align: right; padding: 10px 8px;">${saldos.totalActivo > 0 ? ((pasivoCortoTotal / saldos.totalActivo) * 100).toFixed(2) : 0}%</td>
            </tr>`;
            
            if (isPasivoCortoExpanded) {
                html += `<tr>
                    <td style="padding: 8px 8px;">&nbsp;</td>
                    <td style="padding: 8px 8px; padding-left: 40px;">Proveedores</td>
                    <td style="padding: 8px 8px;"><code>201</code></td>
                    <td style="text-align: right; padding: 8px 8px;">${formatCurrency(saldos.totalProveedores)}</td>
                    <td style="text-align: right; padding: 8px 8px;">${saldos.totalActivo > 0 ? ((saldos.totalProveedores / saldos.totalActivo) * 100).toFixed(2) : 0}%</td>
                </tr>`;
                
                html += `<tr>
                    <td style="padding: 8px 8px;">&nbsp;</td>
                    <td style="padding: 8px 8px; padding-left: 40px;">Impuestos por pagar</td>
                    <td style="padding: 8px 8px;"><code>202</code></td>
                    <td style="text-align: right; padding: 8px 8px;">${formatCurrency(saldos.impuestosPorPagar)}</td>
                    <td style="text-align: right; padding: 8px 8px;">${saldos.totalActivo > 0 ? ((saldos.impuestosPorPagar / saldos.totalActivo) * 100).toFixed(2) : 0}%</td>
                </tr>`;
            }
            
            // Pasivo a largo plazo (200.02)
            const isPasivoLargoExpanded = expandedGroups.has('pasivoLargo');
            const pasivoLargoIcon = isPasivoLargoExpanded ? 'fa-minus-square' : 'fa-plus-square';
            
            html += `<tr style="background-color: #fce4d6; cursor: pointer;" onclick="toggleGroup('pasivoLargo')">
                <td style="text-align: center; padding: 10px 8px;"><i class="fas ${pasivoLargoIcon}" style="color: #a94442;"></i></td>
                <td style="padding: 10px 8px; padding-left: 20px;">Pasivo a largo plazo</td>
                <td style="padding: 10px 8px;"><code>200.02</code></td>
                <td style="text-align: right; padding: 10px 8px;">${formatCurrency(saldos.prestamos)}</td>
                <td style="text-align: right; padding: 10px 8px;">${saldos.totalActivo > 0 ? ((saldos.prestamos / saldos.totalActivo) * 100).toFixed(2) : 0}%</td>
            </tr>`;
            
            if (isPasivoLargoExpanded) {
                html += `<tr>
                    <td style="padding: 8px 8px;">&nbsp;</td>
                    <td style="padding: 8px 8px; padding-left: 40px;">Préstamos bancarios</td>
                    <td style="padding: 8px 8px;"><code>203</code></td>
                    <td style="text-align: right; padding: 8px 8px;">${formatCurrency(saldos.prestamos)}</td>
                    <td style="text-align: right; padding: 8px 8px;">${saldos.totalActivo > 0 ? ((saldos.prestamos / saldos.totalActivo) * 100).toFixed(2) : 0}%</td>
                </tr>`;
            }
        }
        
        // ==================== CAPITAL ====================
        const isCapitalExpanded = expandedGroups.has('capital');
        const capitalIcon = isCapitalExpanded ? 'fa-minus-square' : 'fa-plus-square';
        
        html += `<tr style="background-color: #d1ecf1; cursor: pointer; font-weight: bold;" onclick="toggleGroup('capital')">
            <td style="text-align: center; padding: 12px 8px;"><i class="fas ${capitalIcon}" style="color: #0c5460;"></i></td>
            <td style="padding: 12px 8px;">CAPITAL CONTABLE</td>
            <td style="padding: 12px 8px;"><code>300</code></td>
            <td style="text-align: right; padding: 12px 8px;">${formatCurrency(saldos.totalCapital)}</td>
            <td style="text-align: right; padding: 12px 8px;">${saldos.totalActivo > 0 ? ((saldos.totalCapital / saldos.totalActivo) * 100).toFixed(2) : 0}%</td>
         </tr>`;
        
        if (isCapitalExpanded) {
            html += `<tr>
                <td style="padding: 8px 8px;">&nbsp;</td>
                <td style="padding: 8px 8px; padding-left: 20px;">Capital social</td>
                <td style="padding: 8px 8px;"><code>301</code></td>
                <td style="text-align: right; padding: 8px 8px;">${formatCurrency(saldos.capitalSocial)}</td>
                <td style="text-align: right; padding: 8px 8px;">${saldos.totalActivo > 0 ? ((saldos.capitalSocial / saldos.totalActivo) * 100).toFixed(2) : 0}%</td>
             </tr>`;
            
            html += `<tr>
                <td style="padding: 8px 8px;">&nbsp;</td>
                <td style="padding: 8px 8px; padding-left: 20px;">Resultado del ejercicio</td>
                <td style="padding: 8px 8px;"><code>302</code></td>
                <td style="text-align: right; padding: 8px 8px; ${saldos.utilidad >= 0 ? 'color: #155724;' : 'color: #721c24;'}">${formatCurrency(saldos.utilidad)}</td>
                <td style="text-align: right; padding: 8px 8px;">${saldos.totalActivo > 0 ? ((saldos.utilidad / saldos.totalActivo) * 100).toFixed(2) : 0}%</td>
             </tr>`;
        }
        
        tbody.innerHTML = html;
        
        // Verificar ecuación contable
        const ecuacionDiv = document.getElementById('ecuacionSpan');
        if (ecuacionDiv) {
            const totalGeneral = saldos.totalPasivo + saldos.totalCapital;
            if (Math.abs(saldos.totalActivo - totalGeneral) <= 0.01) {
                ecuacionDiv.innerHTML = '✅ A = P + C';
                ecuacionDiv.style.color = '#28a745';
            } else {
                ecuacionDiv.innerHTML = '⚠️ A ≠ P + C';
                ecuacionDiv.style.color = '#dc3545';
            }
        }
    }
    
    // Botones
    const btnFiltrar = document.getElementById('btnFiltrar');
    if (btnFiltrar) {
        btnFiltrar.addEventListener('click', function() {
            const anio = document.getElementById('anioSelector').value;
            const mes = document.getElementById('mesSelector').value;
            const checkboxes = document.querySelectorAll('.proyecto-checkbox:checked');
            const proyectos = Array.from(checkboxes).map(cb => cb.value).join(',');
            let url = `/conta/balance?anio=${anio}&mes=${mes}`;
            if (proyectos) {
                url += `&proyectos=${proyectos}`;
            }
            window.location.href = url;
        });
    }
    
    const btnExportarExcel = document.getElementById('btnExportarExcel');
    if (btnExportarExcel) {
        btnExportarExcel.addEventListener('click', function() {
            const params = new URLSearchParams(window.location.search);
            window.location.href = '/conta/balance/excel?' + params.toString();
        });
    }
    
    const btnExpandirTodo = document.getElementById('btnExpandirTodo');
    if (btnExpandirTodo) {
        btnExpandirTodo.addEventListener('click', expandirTodo);
    }
    
    const btnContraerTodo = document.getElementById('btnContraerTodo');
    if (btnContraerTodo) {
        btnContraerTodo.addEventListener('click', contraerTodo);
    }
    
    window.toggleGroup = toggleGroup;
    
    document.addEventListener('DOMContentLoaded', function() {
        // Sincronizar checkboxes iniciales
        if (proyectosSeleccionados && proyectosSeleccionados.length > 0) {
            document.querySelectorAll('.proyecto-checkbox').forEach(cb => {
                if (proyectosSeleccionados.includes(parseInt(cb.value))) {
                    cb.checked = true;
                }
            });
        }
        actualizarContadorProyectos();
        renderTabla();
        
        const mesSelect = document.getElementById('mesSelector');
        const anioSelect = document.getElementById('anioSelector');
        if (mesSelect && anioSelect) {
            const mesNombre = mesSelect.options[mesSelect.selectedIndex]?.text || '';
            const anioVal = anioSelect.value;
            const periodoTexto = document.getElementById('periodoTexto');
            if (periodoTexto) periodoTexto.innerHTML = `${mesNombre} ${anioVal}`;
        }
    });
</script>

<style>
    .checkbox-item:hover { 
        background-color: #e8f0fe; 
    }
    .table th { 
        font-size: 12px; 
    }
    .table td { 
        font-size: 12px; 
    }
    .dropdown-menu {
        position: absolute;
        right: 0;
        left: auto;
    }
    .btn {
        transition: all 0.2s ease;
    }
    .btn:hover {
        opacity: 0.85;
        transform: translateY(-1px);
    }
    code {
        background-color: #f8f9fa;
        padding: 2px 5px;
        border-radius: 4px;
        font-size: 11px;
    }
    @media print {
        .btn, #btnSeleccionarProyectos, #panelProyectos, #btnFiltrar, #btnExportarExcel, 
        #btnExpandirTodo, #btnContraerTodo { 
            display: none; 
        }
        .card-header, .card-footer {
            background-color: #f8f9fa !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .table th {
            background-color: #083CAE !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>
@endsection