@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="card mt-2">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 22px;">
                            <i class="fas fa-chart-line"></i> Estado de Resultados Contable
                        </h2>
                        <p style="color: #6c757d; font-size: 13px; margin: 5px 0 0 0;">
                            Selecciona proyectos para comparar
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
                        
                        <!-- Selector de proyectos mejorado -->
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
                    <i class="fas fa-info-circle"></i> Selecciona uno o más proyectos para comparar
                </div>
            </div>

            <div class="card-body p-4">
                <!-- Métricas resumen más grandes -->
                <div style="display: flex; gap: 1px; margin-bottom: 25px; background: #dee2e6; border-radius: 8px; overflow: hidden; flex-wrap: wrap;">
                    <div style="flex: 1; background: #fff; padding: 15px; text-align: center;">
                        <div style="font-size: 11px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px;">Período</div>
                        <div style="font-size: 16px; font-weight: bold; color: #083CAE;" id="periodoTexto">{{ $meses[$mes] }} {{ $anio }}</div>
                    </div>
                    <div style="flex: 1; background: #fff; padding: 15px; text-align: center;">
                        <div style="font-size: 11px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px;">Total Ingresos</div>
                        <div style="font-size: 18px; font-weight: bold; color: #28a745;" id="totalIngresosSpan">$0.00</div>
                    </div>
                    <div style="flex: 1; background: #fff; padding: 15px; text-align: center;">
                        <div style="font-size: 11px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px;">Total Gastos</div>
                        <div style="font-size: 18px; font-weight: bold; color: #dc3545;" id="totalGastosSpan">$0.00</div>
                    </div>
                    <div style="flex: 1; background: #fff; padding: 15px; text-align: center;">
                        <div style="font-size: 11px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px;">Utilidad Neta</div>
                        <div style="font-size: 18px; font-weight: bold;" id="utilidadSpan">$0.00</div>
                    </div>
                    <div style="flex: 1; background: #fff; padding: 15px; text-align: center;">
                        <div style="font-size: 11px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px;">Margen Promedio</div>
                        <div style="font-size: 18px; font-weight: bold;" id="margenSpan">0%</div>
                    </div>
                </div>

                <!-- Mensaje sin datos -->
                <div id="sinDatosMensaje" style="text-align: center; padding: 50px; background: #f8f9fa; border-radius: 8px; display: none;">
                    <i class="fas fa-chart-line" style="font-size: 56px; color: #adb5bd;"></i>
                    <h4 style="color: #6c757d; margin-top: 15px;">No hay datos disponibles</h4>
                    <p style="color: #adb5bd; font-size: 14px;">Seleccione uno o más proyectos para ver los datos</p>
                </div>

                <!-- Tabla de resultados mejorada -->
                <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;">
                    <table class="table table-bordered" id="tablaResultados" style="width: 100%; font-size: 13px; margin-bottom: 0;">
                        <thead id="tablaHeader">
                            <tr style="background-color: #083CAE; color: white;">
                                <th style="width: 40px; text-align: center; padding: 12px 8px;"></th>
                                <th style="width: 220px; padding: 12px 8px;">Concepto</th>
                                <th style="width: 120px; padding: 12px 8px;">Código SAT</th>
                             </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr><td colspan="3" style="text-align: center; padding: 40px;">Seleccione proyectos para visualizar数据<\/td></tr>
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
    const ingresosPorProyectoRaw = @json($ingresosPorProyecto);
    const gastosPorProyectoRaw = @json($gastosPorProyecto);
    
    // Estado de expansión
    let expandedGroups = new Set(['INGRESOS', 'GASTOS']);
    
    // Organizar datos por proyecto
    let datosPorProyecto = {};
    
    // Inicializar datos por proyecto
    proyectosData.forEach(p => {
        datosPorProyecto[p.id] = {
            id: p.id,
            codigo: p.codigo,
            nombre: p.nombre,
            ingresos: [],
            gastos: [],
            totalIngresos: 0,
            totalGastos: 0
        };
    });
    
    // Llenar ingresos
    if (ingresosPorProyectoRaw && ingresosPorProyectoRaw.length > 0) {
        ingresosPorProyectoRaw.forEach(item => {
            if (datosPorProyecto[item.proyecto_id]) {
                datosPorProyecto[item.proyecto_id].ingresos.push({
                    codigo_agrupador: item.codigo_agrupador || '',
                    nombre_cuenta: item.nombre_cuenta || '',
                    nivel: item.nivel || 1,
                    total: parseFloat(item.total) || 0
                });
                datosPorProyecto[item.proyecto_id].totalIngresos += parseFloat(item.total) || 0;
            }
        });
    }
    
    // Llenar gastos
    if (gastosPorProyectoRaw && gastosPorProyectoRaw.length > 0) {
        gastosPorProyectoRaw.forEach(item => {
            if (datosPorProyecto[item.proyecto_id]) {
                datosPorProyecto[item.proyecto_id].gastos.push({
                    codigo_agrupador: item.codigo_agrupador || '',
                    nombre_cuenta: item.nombre_cuenta || '',
                    nivel: item.nivel || 1,
                    total: parseFloat(item.total) || 0
                });
                datosPorProyecto[item.proyecto_id].totalGastos += parseFloat(item.total) || 0;
            }
        });
    }
    
    function formatCurrency(amount) {
        if (amount === undefined || amount === null || isNaN(amount)) amount = 0;
        return '$' + parseFloat(amount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }
    
    // Panel de selección mejorado
    const btnSeleccionar = document.getElementById('btnSeleccionarProyectos');
    const panelProyectos = document.getElementById('panelProyectos');
    
    if (btnSeleccionar) {
        btnSeleccionar.addEventListener('click', function(e) {
            e.stopPropagation();
            panelProyectos.style.display = panelProyectos.style.display === 'none' ? 'block' : 'none';
        });
    }
    
    // Cerrar panel al hacer clic fuera
    document.addEventListener('click', function(event) {
        if (panelProyectos && btnSeleccionar) {
            if (!panelProyectos.contains(event.target) && !btnSeleccionar.contains(event.target)) {
                panelProyectos.style.display = 'none';
            }
        }
    });
    
    // Actualizar contador de proyectos seleccionados
    function actualizarContadorProyectos() {
        const checkboxes = document.querySelectorAll('.proyecto-checkbox:checked');
        const count = checkboxes.length;
        const countSpan = document.getElementById('proyectosCount');
        if (countSpan) {
            countSpan.textContent = count;
        }
        return count;
    }
    
    // Seleccionar todos
    const btnSeleccionarTodos = document.getElementById('btnSeleccionarTodos');
    if (btnSeleccionarTodos) {
        btnSeleccionarTodos.addEventListener('click', function() {
            document.querySelectorAll('.proyecto-checkbox').forEach(cb => cb.checked = true);
            actualizarContadorProyectos();
            actualizarTabla();
            if (panelProyectos) panelProyectos.style.display = 'none';
        });
    }
    
    // Limpiar selección
    const btnLimpiarSeleccion = document.getElementById('btnLimpiarSeleccion');
    if (btnLimpiarSeleccion) {
        btnLimpiarSeleccion.addEventListener('click', function() {
            document.querySelectorAll('.proyecto-checkbox').forEach(cb => cb.checked = false);
            actualizarContadorProyectos();
            actualizarTabla();
            if (panelProyectos) panelProyectos.style.display = 'none';
        });
    }
    
    // Expandir/Contraer funciones
    function toggleGroup(groupName) {
        if (expandedGroups.has(groupName)) {
            expandedGroups.delete(groupName);
        } else {
            expandedGroups.add(groupName);
        }
        actualizarTabla();
    }
    
    // Cuando cambia un checkbox, actualizar tabla automáticamente
    document.querySelectorAll('.proyecto-checkbox').forEach(cb => {
        cb.addEventListener('change', function() {
            actualizarContadorProyectos();
            actualizarTabla();
        });
    });
    
    // Actualizar tabla
    function actualizarTabla() {
        // Obtener proyectos seleccionados
        const checkboxes = document.querySelectorAll('.proyecto-checkbox:checked');
        const idsSeleccionados = Array.from(checkboxes).map(cb => parseInt(cb.value));
        
        if (idsSeleccionados.length === 0) {
            document.getElementById('sinDatosMensaje').style.display = 'block';
            document.getElementById('tablaHeader').innerHTML = '<tr style="background-color: #083CAE; color: white;"><th style="width: 40px; text-align: center; padding: 12px 8px;"></th><th style="width: 220px; padding: 12px 8px;">Concepto</th><th style="width: 120px; padding: 12px 8px;">Código SAT</th> </td>';
            document.getElementById('tablaBody').innerHTML = '<tr><td colspan="3" style="text-align: center; padding: 40px;">Seleccione proyectos para visualizar datos</td></tr>';
            document.getElementById('tablaFooter').innerHTML = '';
            document.getElementById('proyectosSeleccionadosInfo').innerHTML = '<i class="fas fa-info-circle"></i> Selecciona uno o más proyectos para comparar';
            // Resetear métricas
            document.getElementById('totalIngresosSpan').textContent = formatCurrency(0);
            document.getElementById('totalGastosSpan').textContent = formatCurrency(0);
            document.getElementById('utilidadSpan').textContent = formatCurrency(0);
            document.getElementById('margenSpan').textContent = '0%';
            return;
        }
        
        document.getElementById('sinDatosMensaje').style.display = 'none';
        
        // Obtener datos de los proyectos seleccionados
        const proyectosSeleccionados = [];
        let totalIngresosGeneral = 0;
        let totalGastosGeneral = 0;
        
        for (const id of idsSeleccionados) {
            if (datosPorProyecto[id]) {
                proyectosSeleccionados.push(datosPorProyecto[id]);
                totalIngresosGeneral += datosPorProyecto[id].totalIngresos || 0;
                totalGastosGeneral += datosPorProyecto[id].totalGastos || 0;
            }
        }
        
        // Actualizar métricas
        const utilidadGeneral = totalIngresosGeneral - totalGastosGeneral;
        const margenGeneral = totalIngresosGeneral > 0 ? (utilidadGeneral / totalIngresosGeneral) * 100 : 0;
        document.getElementById('totalIngresosSpan').textContent = formatCurrency(totalIngresosGeneral);
        document.getElementById('totalGastosSpan').textContent = formatCurrency(totalGastosGeneral);
        document.getElementById('utilidadSpan').textContent = formatCurrency(utilidadGeneral);
        document.getElementById('margenSpan').textContent = margenGeneral.toFixed(2) + '%';
        
        if (utilidadGeneral >= 0) {
            document.getElementById('utilidadSpan').style.color = '#28a745';
        } else {
            document.getElementById('utilidadSpan').style.color = '#dc3545';
        }
        
        // Construir encabezado con azul corporativo
        let headerHtml = '<tr style="background-color: #083CAE; color: white;">';
        headerHtml += '<th style="width: 40px; text-align: center; padding: 12px 8px;"></th>';
        headerHtml += '<th style="width: 220px; padding: 12px 8px;">Concepto</th>';
        headerHtml += '<th style="width: 120px; padding: 12px 8px;">Código SAT</th>';
        for (const proy of proyectosSeleccionados) {
            headerHtml += `<th style="text-align: right; min-width: 140px; padding: 12px 8px;">${proy.codigo}<br><small style="font-weight: normal; font-size: 10px;">${proy.nombre.substring(0, 25)}</small></th>`;
        }
        headerHtml += '<th style="text-align: right; min-width: 130px; background-color: #2c3e50; color: white; padding: 12px 8px;">TOTAL</th>';
        headerHtml += '<th style="text-align: right; min-width: 90px; background-color: #2c3e50; color: white; padding: 12px 8px;">%</th>';
        headerHtml += '</tr>';
        document.getElementById('tablaHeader').innerHTML = headerHtml;
        
        // Obtener todos los códigos SAT únicos
        const codigosSAT = new Set();
        for (const proy of proyectosSeleccionados) {
            if (proy.ingresos) {
                for (const ing of proy.ingresos) {
                    if (ing.codigo_agrupador) codigosSAT.add(ing.codigo_agrupador);
                }
            }
            if (proy.gastos) {
                for (const gas of proy.gastos) {
                    if (gas.codigo_agrupador) codigosSAT.add(gas.codigo_agrupador);
                }
            }
        }
        
        const codigosOrdenados = Array.from(codigosSAT).sort();
        const codigosIngresos = codigosOrdenados.filter(c => c && c.startsWith('4'));
        const codigosGastos = codigosOrdenados.filter(c => c && !c.startsWith('4'));
        
        let tbodyHtml = '';
        
        // Función para renderizar sección con acordeón
        function renderSeccion(titulo, codigos, esIngreso, groupName) {
            if (codigos.length === 0) return;
            
            const isExpanded = expandedGroups.has(groupName);
            const icon = isExpanded ? 'fa-minus-square' : 'fa-plus-square';
            const bgColor = esIngreso ? '#d4edda' : '#f8d7da';
            
            // Fila principal de la sección
            tbodyHtml += `<tr style="background-color: ${bgColor}; cursor: pointer; font-weight: bold;" onclick="toggleGroup('${groupName}')">
                <td style="text-align: center; padding: 12px 8px;"><i class="fas ${icon}" style="color: ${esIngreso ? '#155724' : '#721c24'}; font-size: 16px;"></i></td>
                <td colspan="2" style="padding: 12px 8px;"><strong style="font-size: 14px;">${titulo}</strong></td>`;
            
            for (const proy of proyectosSeleccionados) {
                const total = esIngreso ? (proy.totalIngresos || 0) : (proy.totalGastos || 0);
                tbodyHtml += `<td style="text-align: right; padding: 12px 8px;"><strong>${formatCurrency(total)}</strong></td>`;
            }
            tbodyHtml += `<td style="text-align: right; padding: 12px 8px; font-weight: bold;">${formatCurrency(esIngreso ? totalIngresosGeneral : totalGastosGeneral)}</td>`;
            tbodyHtml += `<td style="text-align: right; padding: 12px 8px; font-weight: bold;">${totalIngresosGeneral > 0 ? ((esIngreso ? totalIngresosGeneral : totalGastosGeneral) / totalIngresosGeneral * 100).toFixed(2) : 0}%</td>`;
            tbodyHtml += `</tr>`;
            
            // Filas de detalle (solo si está expandido)
            if (isExpanded) {
                for (const codigo of codigos) {
                    let nombreCuenta = codigo;
                    let nivel = 2;
                    
                    for (const proy of proyectosSeleccionados) {
                        const items = esIngreso ? proy.ingresos : proy.gastos;
                        const item = items.find(i => i.codigo_agrupador === codigo);
                        if (item) {
                            nombreCuenta = item.nombre_cuenta || codigo;
                            nivel = item.nivel || 2;
                            break;
                        }
                    }
                    
                    const indent = '&nbsp;&nbsp;'.repeat((nivel - 1) * 2);
                    let filaHtml = `<tr class="fila-detalle">
                        <td style="padding: 10px 8px;"></td>
                        <td style="padding: 10px 8px; padding-left: ${20 + (nivel - 1) * 15}px;">${indent}${nombreCuenta}</td>
                        <td style="padding: 10px 8px;"><code style="font-size: 11px;">${codigo}</code></td>`;
                    
                    let totalFila = 0;
                    for (const proy of proyectosSeleccionados) {
                        const items = esIngreso ? proy.ingresos : proy.gastos;
                        const item = items.find(i => i.codigo_agrupador === codigo);
                        const monto = item ? (parseFloat(item.total) || 0) : 0;
                        totalFila += monto;
                        filaHtml += `<td style="text-align: right; padding: 10px 8px;">${formatCurrency(monto)}</td>`;
                    }
                    
                    const porcentaje = totalIngresosGeneral > 0 ? (totalFila / totalIngresosGeneral) * 100 : 0;
                    filaHtml += `<td style="text-align: right; padding: 10px 8px; font-weight: 600;">${formatCurrency(totalFila)}</td>`;
                    filaHtml += `<td style="text-align: right; padding: 10px 8px;">${porcentaje.toFixed(2)}%</td>`;
                    filaHtml += `</tr>`;
                    
                    tbodyHtml += filaHtml;
                }
            }
        }
        
        // Renderizar secciones
        renderSeccion('INGRESOS', codigosIngresos, true, 'INGRESOS');
        renderSeccion('GASTOS Y COSTOS', codigosGastos, false, 'GASTOS');
        
        // Resultado
        tbodyHtml += `<tr style="background-color: #d1ecf1; font-weight: bold;">
            <td style="padding: 12px 8px;"><i class="fas fa-chart-line" style="color: #0c5460;"></i></td>
            <td colspan="2" style="padding: 12px 8px; font-size: 14px;">RESULTADO DEL EJERCICIO</td>`;
        
        for (const proy of proyectosSeleccionados) {
            const utilidad = (proy.totalIngresos || 0) - (proy.totalGastos || 0);
            tbodyHtml += `<td style="text-align: right; padding: 12px 8px; ${utilidad >= 0 ? 'color: #155724;' : 'color: #721c24;'}">${formatCurrency(utilidad)}</td>`;
        }
        tbodyHtml += `<td style="text-align: right; padding: 12px 8px; ${utilidadGeneral >= 0 ? 'color: #155724;' : 'color: #721c24;'}">${formatCurrency(utilidadGeneral)}</td>`;
        tbodyHtml += `<td style="text-align: right; padding: 12px 8px;">${margenGeneral.toFixed(2)}%</td>`;
        tbodyHtml += `</tr>`;
        
        document.getElementById('tablaBody').innerHTML = tbodyHtml;
        
        // Información de proyectos seleccionados
        const count = idsSeleccionados.length;
        const nombres = idsSeleccionados.map(id => {
            const p = proyectosData.find(p => p.id == id);
            return p ? p.codigo : '';
        }).join(', ');
        document.getElementById('proyectosSeleccionadosInfo').innerHTML = `<i class="fas fa-check-circle" style="color: #28a745;"></i> <strong>${count}</strong> proyecto(s) seleccionado(s): ${nombres}`;
    }
    
    // Sincronizar checkboxes con la selección inicial
    function sincronizarCheckboxesIniciales() {
        const proyectosSeleccionadosIds = @json($proyectosSeleccionadosIds ?? []);
        if (proyectosSeleccionadosIds && proyectosSeleccionadosIds.length > 0) {
            document.querySelectorAll('.proyecto-checkbox').forEach(cb => {
                if (proyectosSeleccionadosIds.includes(parseInt(cb.value))) {
                    cb.checked = true;
                }
            });
        }
        actualizarContadorProyectos();
        actualizarTabla();
    }
    
    // Botones
    const btnFiltrar = document.getElementById('btnFiltrar');
    if (btnFiltrar) {
        btnFiltrar.addEventListener('click', function() {
            const anio = document.getElementById('anioSelector').value;
            const mes = document.getElementById('mesSelector').value;
            const checkboxes = document.querySelectorAll('.proyecto-checkbox:checked');
            const proyectos = Array.from(checkboxes).map(cb => cb.value).join(',');
            window.location.href = `/conta/estados?anio=${anio}&mes=${mes}&proyectos=${proyectos}`;
        });
    }
    
    const btnExportarExcel = document.getElementById('btnExportarExcel');
    if (btnExportarExcel) {
        btnExportarExcel.addEventListener('click', function() {
            const params = new URLSearchParams(window.location.search);
            window.location.href = '/conta/estados/excel?' + params.toString();
        });
    }
    
    // Hacer toggleGroup global para onclick
    window.toggleGroup = toggleGroup;
    
    // Inicializar
    document.addEventListener('DOMContentLoaded', function() {
        sincronizarCheckboxesIniciales();
        
        const mesSelect = document.getElementById('mesSelector');
        const anioSelect = document.getElementById('anioSelector');
        if (mesSelect && anioSelect) {
            const mesNombre = mesSelect.options[mesSelect.selectedIndex]?.text || '';
            const anioVal = anioSelect.value;
            document.getElementById('periodoTexto').innerHTML = `${mesNombre} ${anioVal}`;
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
    .fila-detalle:hover {
        background-color: #f8f9fa;
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
    @media print {
        .btn, #btnSeleccionarProyectos, #panelProyectos, #btnFiltrar, #btnExportarExcel { 
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