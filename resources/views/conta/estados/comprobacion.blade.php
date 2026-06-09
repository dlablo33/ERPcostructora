@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="card mt-2">
            <div class="card-header" style="background-color: #f8f9fa; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 22px;">
                            <i class="fas fa-balance-scale"></i> Balanza de Comprobación
                        </h2>
                        <p style="color: #6c757d; font-size: 13px; margin: 5px 0 0 0;">
                            Saldos y movimientos por cuenta contable
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
                        
                        <div class="dropdown" style="position: relative;">
                            <button id="btnSeleccionarProyectos" type="button" class="btn" style="background-color: #083CAE; color: white; border: none; padding: 6px 15px; border-radius: 4px;">
                                <i class="fas fa-check-square"></i> Proyectos 
                                <span id="proyectosCount" class="badge" style="background-color: #ffc107; color: #333; margin-left: 5px;">{{ count($proyectosSeleccionados) }}</span>
                            </button>
                            <div id="panelProyectos" class="dropdown-menu" style="display: none; position: absolute; top: 100%; right: 0; background: white; border: 1px solid #dee2e6; border-radius: 8px; width: 380px; max-height: 420px; overflow-y: auto; z-index: 1000; box-shadow: 0 4px 12px rgba(0,0,0,0.15); margin-top: 5px;">
                                <div style="padding: 12px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa;">
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
                                        <div class="checkbox-item" style="margin-bottom: 8px; padding: 6px; border-radius: 6px;">
                                            <label style="display: flex; align-items: center; cursor: pointer; margin: 0;">
                                                <input type="checkbox" class="proyecto-checkbox" value="{{ $proyecto->id }}" 
                                                    {{ in_array($proyecto->id, $proyectosSeleccionados) ? 'checked' : '' }}
                                                    style="margin-right: 10px;">
                                                <span style="font-size: 12px;">
                                                    <strong>{{ $proyecto->codigo }}</strong> - {{ Str::limit($proyecto->nombre, 40) }}
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
                    @if(count($proyectosSeleccionados) > 0)
                        <i class="fas fa-check-circle" style="color: #28a745;"></i> 
                        <strong>{{ count($proyectosSeleccionados) }}</strong> proyecto(s) seleccionado(s)
                    @else
                        <i class="fas fa-info-circle"></i> Mostrando TODOS los proyectos
                    @endif
                </div>
            </div>

            <div class="card-body p-4">
                <!-- Métricas resumen -->
                <div style="display: flex; gap: 1px; margin-bottom: 25px; background: #dee2e6; border-radius: 8px; overflow: hidden; flex-wrap: wrap;">
                    <div style="flex: 1; background: #fff; padding: 12px; text-align: center;">
                        <div style="font-size: 10px; color: #6c757d;">Período</div>
                        <div style="font-size: 14px; font-weight: bold; color: #083CAE;" id="periodoTexto">{{ $meses[$mes] }} {{ $anio }}</div>
                    </div>
                    <div style="flex: 1; background: #fff; padding: 12px; text-align: center;">
                        <div style="font-size: 10px; color: #6c757d;">Total Ingresos</div>
                        <div style="font-size: 14px; font-weight: bold; color: #28a745;">${{ number_format($totalIngresosGrupo, 2) }}</div>
                    </div>
                    <div style="flex: 1; background: #fff; padding: 12px; text-align: center;">
                        <div style="font-size: 10px; color: #6c757d;">Total Gastos</div>
                        <div style="font-size: 14px; font-weight: bold; color: #dc3545;">${{ number_format($totalGastosGrupo, 2) }}</div>
                    </div>
                    <div style="flex: 1; background: #fff; padding: 12px; text-align: center;">
                        <div style="font-size: 10px; color: #6c757d;">Utilidad/Pérdida</div>
                        <div style="font-size: 14px; font-weight: bold; color: #17a2b8;">${{ number_format($utilidad, 2) }}</div>
                    </div>
                </div>

                <!-- Tabla de Balanza con Acordeón -->
                <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;">
                    <table class="table table-bordered" style="width: 100%; font-size: 12px; margin-bottom: 0;">
                        <thead style="background-color: #083CAE; color: white; position: sticky; top: 0; z-index: 10;">
                            <tr>
                                <th style="width: 40px; text-align: center; padding: 12px 8px;"></th>
                                <th style="width: 100px; padding: 12px 8px;">Código</th>
                                <th style="padding: 12px 8px;">Cuenta</th>
                                <th style="width: 100px; text-align: center; padding: 12px 8px;">Naturaleza</th>
                                <th style="width: 140px; text-align: right; padding: 12px 8px;">Cargos (Debe)</th>
                                <th style="width: 140px; text-align: right; padding: 12px 8px;">Abonos (Haber)</th>
                                <th style="width: 140px; text-align: right; padding: 12px 8px;">Saldo</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            @php
                                // Función para renderizar filas con acordeón
                                function renderAcordeon($cuentas, $nivel = 0, $padreId = null) {
                                    $html = '';
                                    foreach ($cuentas as $key => $cuenta) {
                                        $id = 'row_' . $key . '_' . $nivel;
                                        $hasChildren = !empty($cuenta['subcuentas']);
                                        $childId = 'children_' . $key . '_' . $nivel;
                                        $indent = $nivel * 20;
                                        
                                        $naturalezaClass = $cuenta['naturaleza'] == 'Deudora' ? 'naturaleza-deudora' : 'naturaleza-acreedora';
                                        $rowStyle = $nivel == 0 ? 'font-weight: bold; background-color: #f8f9fa;' : '';
                                        
                                        $html .= '<tr id="' . $id . '" style="' . $rowStyle . '">';
                                        $html .= '<td style="text-align: center; padding: 10px 4px; padding-left: ' . $indent . 'px;">';
                                        
                                        if ($hasChildren) {
                                            $html .= '<i class="fas fa-folder toggle-icon" style="color: #083CAE; cursor: pointer;" onclick="toggleChildren(\'' . $childId . '\', this)"></i>';
                                        } else {
                                            $html .= '<i class="fas fa-file-alt" style="color: #adb5bd;"></i>';
                                        }
                                        
                                        $html .= '</td>';
                                        $html .= '<td style="padding: 10px 6px; font-family: monospace;">' . $cuenta['codigo'] . '</td>';
                                        $html .= '<td style="padding: 10px 6px;">' . $cuenta['nombre'] . '</td>';
                                        $html .= '<td style="text-align: center; padding: 10px 6px;" class="' . $naturalezaClass . '">' . $cuenta['naturaleza'] . '</td>';
                                        $html .= '<td style="text-align: right; padding: 10px 6px;">$' . number_format($cuenta['cargos'], 2) . '</td>';
                                        $html .= '<td style="text-align: right; padding: 10px 6px;">$' . number_format($cuenta['abonos'], 2) . '</td>';
                                        $html .= '<td style="text-align: right; padding: 10px 6px;">$' . number_format($cuenta['saldo'], 2) . '</td>';
                                        $html .= '</tr>';
                                        
                                        if ($hasChildren) {
                                            $html .= '<tbody id="' . $childId . '" class="children-row" style="display: none;">';
                                            $html .= renderAcordeon($cuenta['subcuentas'], $nivel + 1, $key);
                                            $html .= '</tbody>';
                                        }
                                    }
                                    return $html;
                                }
                                
                                // Construir estructura jerárquica
                                $estructura = [];
                                
                                // Función para construir árbol jerárquico
                                function construirArbol($cuentas) {
                                    $tree = [];
                                    $nivel1 = ['100' => 'ACTIVO', '200' => 'PASIVO', '300' => 'CAPITAL CONTABLE', '400' => 'INGRESOS NETOS', '500' => 'COSTOS Y GASTOS'];
                                    
                                    foreach ($nivel1 as $codigo => $nombre) {
                                        $hijos = [];
                                        foreach ($cuentas as $cuenta) {
                                            if (strpos($cuenta['codigo'], $codigo) === 0 && $cuenta['codigo'] != $codigo) {
                                                $hijos[] = $cuenta;
                                            }
                                        }
                                        $tree[] = [
                                            'codigo' => $codigo,
                                            'nombre' => $nombre,
                                            'naturaleza' => in_array($codigo, ['100', '500']) ? 'Deudora' : 'Acreedora',
                                            'cargos' => array_sum(array_column($hijos, 'cargos')),
                                            'abonos' => array_sum(array_column($hijos, 'abonos')),
                                            'saldo' => array_sum(array_column($hijos, 'saldo')),
                                            'subcuentas' => $hijos
                                        ];
                                    }
                                    
                                    return $tree;
                                }
                                
                                $estructura = construirArbol($grupos['100']['cuentas']);
                            @endphp
                            
                            @php
                                // Construir estructura jerárquica manual
                                $gruposData = [
                                    '100' => ['nombre' => 'ACTIVO', 'tipo' => 'Deudora', 'cuentas' => []],
                                    '200' => ['nombre' => 'PASIVO', 'tipo' => 'Acreedora', 'cuentas' => []],
                                    '300' => ['nombre' => 'CAPITAL CONTABLE', 'tipo' => 'Acreedora', 'cuentas' => []],
                                    '400' => ['nombre' => 'INGRESOS NETOS', 'tipo' => 'Acreedora', 'cuentas' => []],
                                    '500' => ['nombre' => 'COSTOS Y GASTOS', 'tipo' => 'Deudora', 'cuentas' => []],
                                ];
                                
                                // Clasificar cuentas por su código
                                foreach ($grupos as $grupoKey => $grupo) {
                                    if (isset($gruposData[$grupoKey])) {
                                        foreach ($grupo['cuentas'] as $cuenta) {
                                            $gruposData[$grupoKey]['cuentas'][] = $cuenta;
                                        }
                                        $gruposData[$grupoKey]['total_cargos'] = $grupo['total'];
                                        $gruposData[$grupoKey]['total_abonos'] = 0;
                                        $gruposData[$grupoKey]['total_saldo'] = $grupo['total'];
                                    }
                                }
                                
                                // Añadir utilidad al grupo 300
                                $gruposData['300']['cuentas'][] = [
                                    'codigo' => '305',
                                    'nombre' => 'Resultado del Ejercicio',
                                    'naturaleza' => 'Acreedora',
                                    'cargos' => 0,
                                    'abonos' => $utilidad,
                                    'saldo' => $utilidad,
                                    'subcuentas' => []
                                ];
                                $gruposData['300']['total_saldo'] += $utilidad;
                                
                                // Construir jerarquía por niveles (por longitud de código)
                                foreach ($gruposData as $grupoKey => &$grupo) {
                                    $cuentasAgrupadas = [];
                                    foreach ($grupo['cuentas'] as $cuenta) {
                                        $codigo = $cuenta['codigo'];
                                        $partes = explode('.', $codigo);
                                        $nivel = count($partes);
                                        
                                        if ($nivel == 2) {
                                            // Cuentas de nivel 2
                                            if (!isset($cuentasAgrupadas[$codigo])) {
                                                $cuentasAgrupadas[$codigo] = [
                                                    'codigo' => $codigo,
                                                    'nombre' => $cuenta['nombre'],
                                                    'naturaleza' => $cuenta['naturaleza'],
                                                    'cargos' => 0,
                                                    'abonos' => 0,
                                                    'saldo' => 0,
                                                    'subcuentas' => []
                                                ];
                                            }
                                            $cuentasAgrupadas[$codigo]['cargos'] += $cuenta['cargos'];
                                            $cuentasAgrupadas[$codigo]['abonos'] += $cuenta['abonos'];
                                            $cuentasAgrupadas[$codigo]['saldo'] += $cuenta['saldo'];
                                        } elseif ($nivel >= 3) {
                                            // Cuentas de nivel 3 o más
                                            $padre = $partes[0] . '.' . $partes[1];
                                            if (!isset($cuentasAgrupadas[$padre])) {
                                                $cuentasAgrupadas[$padre] = [
                                                    'codigo' => $padre,
                                                    'nombre' => $partes[1],
                                                    'naturaleza' => $cuenta['naturaleza'],
                                                    'cargos' => 0,
                                                    'abonos' => 0,
                                                    'saldo' => 0,
                                                    'subcuentas' => []
                                                ];
                                            }
                                            $cuentasAgrupadas[$padre]['subcuentas'][] = $cuenta;
                                            $cuentasAgrupadas[$padre]['cargos'] += $cuenta['cargos'];
                                            $cuentasAgrupadas[$padre]['abonos'] += $cuenta['abonos'];
                                            $cuentasAgrupadas[$padre]['saldo'] += $cuenta['saldo'];
                                        } else {
                                            // Cuentas de nivel 1 (individuales)
                                            if (!isset($cuentasAgrupadas[$codigo])) {
                                                $cuentasAgrupadas[$codigo] = $cuenta;
                                                $cuentasAgrupadas[$codigo]['subcuentas'] = [];
                                            }
                                        }
                                    }
                                    
                                    // Ordenar y asignar
                                    ksort($cuentasAgrupadas);
                                    $grupo['cuentas'] = array_values($cuentasAgrupadas);
                                }
                            @endphp
                            
                            <!-- Renderizar cada grupo -->
                            @foreach($gruposData as $grupoKey => $grupo)
                                @php
                                    $idGrupo = 'grupo_' . $grupoKey;
                                    $hasChildren = count($grupo['cuentas']) > 0;
                                @endphp
                                <tr id="{{ $idGrupo }}" style="background-color: {{ $grupoKey == '100' ? '#d4edda' : ($grupoKey == '200' ? '#f8d7da' : ($grupoKey == '300' ? '#d1ecf1' : ($grupoKey == '400' ? '#d4edda' : '#f8d7da'))) }}; font-weight: bold; cursor: pointer;" onclick="toggleChildren('children_{{ $grupoKey }}', this)">
                                    <td style="text-align: center; padding: 12px 8px;">
                                        <i class="fas fa-folder toggle-icon" style="color: #083CAE;"></i>
                                    </td>
                                    <td style="padding: 12px 8px; font-family: monospace;">{{ $grupoKey }}</td>
                                    <td style="padding: 12px 8px;">{{ $grupo['nombre'] }}</td>
                                    <td style="text-align: center; padding: 12px 8px;" class="{{ $grupo['tipo'] == 'Deudora' ? 'naturaleza-deudora' : 'naturaleza-acreedora' }}">{{ $grupo['tipo'] }}</td>
                                    <td style="text-align: right; padding: 12px 8px;">${{ number_format($grupo['total_cargos'] ?? 0, 2) }}</td>
                                    <td style="text-align: right; padding: 12px 8px;">${{ number_format($grupo['total_abonos'] ?? 0, 2) }}</td>
                                    <td style="text-align: right; padding: 12px 8px;">${{ number_format($grupo['total_saldo'] ?? 0, 2) }}</td>
                                </tr>
                                <tbody id="children_{{ $grupoKey }}" class="children-row" style="display: none;">
                                    @foreach($grupo['cuentas'] as $cuenta)
                                        @php
                                            $hasSubChildren = isset($cuenta['subcuentas']) && count($cuenta['subcuentas']) > 0;
                                            $subId = 'sub_' . $grupoKey . '_' . preg_replace('/[^a-zA-Z0-9]/', '_', $cuenta['codigo']);
                                        @endphp
                                        <tr style="background-color: #f8f9fa;">
                                            <td style="text-align: center; padding: 8px 4px; padding-left: 20px;">
                                                @if($hasSubChildren)
                                                    <i class="fas fa-folder toggle-icon" style="color: #083CAE; cursor: pointer;" onclick="toggleChildren('{{ $subId }}', this)"></i>
                                                @else
                                                    <i class="fas fa-file-alt" style="color: #adb5bd;"></i>
                                                @endif
                                            </td>
                                            <td style="padding: 8px 6px; font-family: monospace;">{{ $cuenta['codigo'] }}</td>
                                            <td style="padding: 8px 6px;">&nbsp;&nbsp;&nbsp;&nbsp;{{ $cuenta['nombre'] }}</td>
                                            <td style="text-align: center; padding: 8px 6px;" class="{{ $cuenta['naturaleza'] == 'Deudora' ? 'naturaleza-deudora' : 'naturaleza-acreedora' }}">{{ $cuenta['naturaleza'] }}</td>
                                            <td style="text-align: right; padding: 8px 6px;">${{ number_format($cuenta['cargos'], 2) }}</td>
                                            <td style="text-align: right; padding: 8px 6px;">${{ number_format($cuenta['abonos'], 2) }}</td>
                                            <td style="text-align: right; padding: 8px 6px;">${{ number_format($cuenta['saldo'], 2) }}</td>
                                        </tr>
                                        @if($hasSubChildren)
                                            <tbody id="{{ $subId }}" class="children-row" style="display: none;">
                                                @foreach($cuenta['subcuentas'] as $subCuenta)
                                                    <tr>
                                                        <td style="text-align: center; padding: 6px 4px; padding-left: 40px;">
                                                            <i class="fas fa-file-alt" style="color: #adb5bd;"></i>
                                                        </td>
                                                        <td style="padding: 6px 6px; font-family: monospace;">{{ $subCuenta['codigo'] }}</td>
                                                        <td style="padding: 6px 6px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $subCuenta['nombre'] }}</td>
                                                        <td style="text-align: center; padding: 6px 6px;" class="{{ $subCuenta['naturaleza'] == 'Deudora' ? 'naturaleza-deudora' : 'naturaleza-acreedora' }}">{{ $subCuenta['naturaleza'] }}</td>
                                                        <td style="text-align: right; padding: 6px 6px;">${{ number_format($subCuenta['cargos'], 2) }}</td>
                                                        <td style="text-align: right; padding: 6px 6px;">${{ number_format($subCuenta['abonos'], 2) }}</td>
                                                        <td style="text-align: right; padding: 6px 6px;">${{ number_format($subCuenta['saldo'], 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        @endif
                                    @endforeach
                                </tbody>
                            @endforeach
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="3" class="text-right">TOTALES</td>
                                <td class="text-right"></td>
                                <td class="text-right">${{ number_format($totalIngresosGrupo + $totalGastosGrupo, 2) }}</td>
                                <td class="text-right">$0.00</td>
                                <td class="text-right">${{ number_format($totalActivo, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Ecuación contable -->

            </div>
            
            <div class="card-footer text-center" style="background-color: #f8f9fa; font-size: 11px; color: #6c757d;">
                <i class="fas fa-info-circle"></i> Reporte generado el {{ now()->format('d/m/Y H:i:s') }}
            </div>
        </div>
    </section>
</div>

<script>
    // Función para expandir/contraer hijos
    function toggleChildren(childId, element) {
        const childDiv = document.getElementById(childId);
        if (childDiv) {
            if (childDiv.style.display === 'none') {
                childDiv.style.display = '';
                // Cambiar ícono a abierto
                const icon = element.querySelector('.toggle-icon');
                if (icon) {
                    icon.classList.remove('fa-folder');
                    icon.classList.add('fa-folder-open');
                }
            } else {
                childDiv.style.display = 'none';
                // Cambiar ícono a cerrado
                const icon = element.querySelector('.toggle-icon');
                if (icon) {
                    icon.classList.remove('fa-folder-open');
                    icon.classList.add('fa-folder');
                }
            }
        }
    }
    
    // Expandir todos los grupos
    function expandirTodo() {
        const allChildren = document.querySelectorAll('.children-row');
        const allIcons = document.querySelectorAll('.toggle-icon');
        
        allChildren.forEach(child => {
            child.style.display = '';
        });
        
        allIcons.forEach(icon => {
            if (icon.classList.contains('fa-folder')) {
                icon.classList.remove('fa-folder');
                icon.classList.add('fa-folder-open');
            }
        });
    }
    
    // Contraer todos los grupos
    function contraerTodo() {
        const allChildren = document.querySelectorAll('.children-row');
        const allIcons = document.querySelectorAll('.toggle-icon');
        
        allChildren.forEach(child => {
            child.style.display = 'none';
        });
        
        allIcons.forEach(icon => {
            if (icon.classList.contains('fa-folder-open')) {
                icon.classList.remove('fa-folder-open');
                icon.classList.add('fa-folder');
            }
        });
    }
    
    // Eventos de botones
    document.getElementById('btnExpandirTodo')?.addEventListener('click', expandirTodo);
    document.getElementById('btnContraerTodo')?.addEventListener('click', contraerTodo);
    
    document.getElementById('btnFiltrar')?.addEventListener('click', function() {
        const anio = document.getElementById('anioSelector').value;
        const mes = document.getElementById('mesSelector').value;
        const checkboxes = document.querySelectorAll('.proyecto-checkbox:checked');
        const proyectos = Array.from(checkboxes).map(cb => cb.value).join(',');
        
        let url = `/conta/comprobacion?anio=${anio}&mes=${mes}`;
        if (proyectos) {
            url += `&proyectos=${proyectos}`;
        }
        window.location.href = url;
    });
    
    document.getElementById('btnExportarExcel')?.addEventListener('click', function() {
        const params = new URLSearchParams(window.location.search);
        window.location.href = '/conta/comprobacion/excel?' + params.toString();
    });
    
    // Panel de proyectos
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
        if (countSpan) countSpan.textContent = count;
        
        const infoDiv = document.getElementById('proyectosSeleccionadosInfo');
        if (count > 0) {
            infoDiv.innerHTML = `<i class="fas fa-check-circle" style="color: #28a745;"></i> <strong>${count}</strong> proyecto(s) seleccionado(s)`;
        } else {
            infoDiv.innerHTML = '<i class="fas fa-info-circle"></i> Mostrando TODOS los proyectos';
        }
    }
    
    document.getElementById('btnSeleccionarTodos')?.addEventListener('click', function() {
        document.querySelectorAll('.proyecto-checkbox').forEach(cb => cb.checked = true);
        actualizarContadorProyectos();
        if (panelProyectos) panelProyectos.style.display = 'none';
    });
    
    document.getElementById('btnLimpiarSeleccion')?.addEventListener('click', function() {
        document.querySelectorAll('.proyecto-checkbox').forEach(cb => cb.checked = false);
        actualizarContadorProyectos();
        if (panelProyectos) panelProyectos.style.display = 'none';
    });
    
    document.querySelectorAll('.proyecto-checkbox').forEach(cb => {
        cb.addEventListener('change', actualizarContadorProyectos);
    });
    
    actualizarContadorProyectos();
    
    const mesSelect = document.getElementById('mesSelector');
    const anioSelect = document.getElementById('anioSelector');
    if (mesSelect && anioSelect) {
        const mesNombre = mesSelect.options[mesSelect.selectedIndex]?.text || '';
        const anioVal = anioSelect.value;
        document.getElementById('periodoTexto').innerHTML = `${mesNombre} ${anioVal}`;
    }
    
    window.toggleChildren = toggleChildren;
    window.expandirTodo = expandirTodo;
    window.contraerTodo = contraerTodo;
</script>

<style>
    .naturaleza-deudora {
        background-color: #d4edda !important;
        color: #155724 !important;
    }
    .naturaleza-acreedora {
        background-color: #fff3cd !important;
        color: #856404 !important;
    }
    .table th {
        background-color: #083CAE !important;
        color: white;
    }
    .table td {
        vertical-align: middle;
    }
    .table tbody tr:hover {
        background-color: #f5f5f5 !important;
    }
    .checkbox-item:hover {
        background-color: #e8f0fe;
    }
    .dropdown-menu {
        position: absolute;
        right: 0;
        left: auto;
    }
    .toggle-icon {
        transition: transform 0.2s ease;
    }
    .toggle-icon:hover {
        transform: scale(1.1);
    }
    .children-row {
        transition: all 0.3s ease;
    }
    @media print {
        .btn, .dropdown, .btn-group { display: none; }
        .table th { background-color: #083CAE !important; -webkit-print-color-adjust: exact; }
    }
</style>
@endsection