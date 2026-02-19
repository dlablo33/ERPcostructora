@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Flujo de Dinero Mensual -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #6B8ACE; padding: 15px 20px;">
                <h2 style="color: #6B8ACE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Flujo de Dinero Mensual
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Barra de herramientas con filtro de mes y año -->
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
                    
                    <!-- Filtros a la derecha -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <label for="mes" style="font-weight: 600; color: #6B8ACE;">Mes:</label>
                        <select id="mes" style="padding: 8px 12px; border: 1px solid #6B8ACE; border-radius: 4px; font-size: 14px; width: 120px; background-color: white;">
                            <option value="1">Enero</option>
                            <option value="2" selected>Febrero</option>
                            <option value="3">Marzo</option>
                            <option value="4">Abril</option>
                            <option value="5">Mayo</option>
                            <option value="6">Junio</option>
                            <option value="7">Julio</option>
                            <option value="8">Agosto</option>
                            <option value="9">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>

                        <label for="anio" style="font-weight: 600; color: #6B8ACE;">Año:</label>
                        <select id="anio" style="padding: 8px 12px; border: 1px solid #6B8ACE; border-radius: 4px; font-size: 14px; width: 100px; background-color: white;">
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026" selected>2026</option>
                        </select>

                        <!-- Botón Exportar Excel -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid #6B8ACE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #6B8ACE;"
                                    title="Exportar a Excel">
                                <i class="fas fa-file-excel" style="color: #6B8ACE;"></i>
                            </button>
                        </div>

                        <!-- Botón Columnas -->

                    </div>
                </div>

                <!-- Tabla de Flujo de Dinero Mensual -->
                <div class="table-responsive" style="margin-top: 10px; border: 1px solid #dee2e6; border-radius: 8px; overflow: auto;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaFlujoDineroMensual" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #6B8ACE; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: left; background-color: #6B8ACE; color: white; min-width: 300px;">
                                    <span>Cuentas</span>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #6B8ACE; color: white; min-width: 150px;">
                                    <span id="mesActual">Febrero</span>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #6B8ACE; color: white; min-width: 150px;">
                                    <span>Acumulado</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <!-- Las filas se generan dinámicamente -->
                        </tbody>
                        <tfoot style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: left; background-color: #e9ecef; font-weight: bold;">TOTALES</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalMes">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalAcumulado">$0.00</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-file-invoice" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay información para el mes seleccionado</p>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .semaforo .card-header {
        background-color: #f4f6f9;
        border-bottom: 2px solid #6B8ACE;
    }
    
    .custom-card {
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
    }
    
    .custom-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(107, 138, 206, 0.15) !important;
        border-color: #6B8ACE !important;
    }
    
    /* Estilos de tabla */
    .table th {
        white-space: nowrap;
        font-size: 12px;
        background-color: #6B8ACE !important;
        color: white;
        font-weight: 600;
        padding: 12px 8px;
    }
    
    .table td {
        white-space: nowrap;
        font-size: 12px;
        padding: 10px 8px;
    }
    
    /* Estilo para las filas de cuentas principales */
    .cuenta-principal {
        font-weight: bold;
        background-color: #f8f9fc !important;
        cursor: pointer;
    }
    
    .cuenta-principal:hover {
        background-color: #e9ecef !important;
    }
    
    .cuenta-principal i {
        transition: transform 0.2s;
        color: #6B8ACE;
        margin-right: 8px;
    }
    
    /* Estilo para subcuentas */
    .subcuenta {
        padding-left: 30px !important;
        background-color: #ffffff;
    }
    
    .subcuenta:hover {
        background-color: #f2f2f2;
    }
    
    /* Estilo para las filas alternadas en subcuentas */
    .subcuenta:nth-child(even) {
        background-color: #fafbfc;
    }
    
    /* Estilo para el pie de tabla (totales) */
    tfoot td {
        font-weight: bold;
        background-color: #e9ecef !important;
        border-top: 2px solid #6B8ACE;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        div[style*="justify-content: flex-end"] {
            justify-content: center !important;
        }
        
        select {
            width: 100% !important;
        }
        
        button {
            width: 100%;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM completamente cargado - Flujo de Dinero Mensual');
        
        // Datos de flujo de dinero por mes
        const datosFlujoPorMes = {
            '2026-1': { // Enero 2026
                mes: 'Enero',
                anio: 2026,
                cuentas: [
                    {
                        id: 1,
                        codigo: '100-00',
                        nombre: 'Ingresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 101, codigo: '101-00', nombre: 'Cobranza', total: 185000.00 },
                            { id: 102, codigo: '102-00', nombre: 'Otros Ingresos', total: 28400.00 },
                            { id: 103, codigo: '103-00', nombre: 'Traspasos Entre Ctas. Entradas', total: 52000.00 }
                        ]
                    },
                    {
                        id: 2,
                        codigo: '200-00',
                        nombre: 'Egresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 201, codigo: '201-00', nombre: 'Costos Operativos', total: 68500.00 },
                            { id: 202, codigo: '202-00', nombre: 'Costos Indirectos Operación', total: 32400.00 },
                            { id: 203, codigo: '203-00', nombre: 'Costos Indirectos Mantenimiento', total: 18900.00 },
                            { id: 204, codigo: '204-00', nombre: 'Gastos Administrativos', total: 42300.00 },
                            { id: 205, codigo: '205-00', nombre: 'Arrendamientos', total: 40000.00 },
                            { id: 206, codigo: '206-00', nombre: 'Impuestos', total: 15600.00 },
                            { id: 207, codigo: '207-00', nombre: 'Traspasos Entre Ctas. Salidas', total: 38000.00 },
                            { id: 299, codigo: '299-00', nombre: 'Gastos 50 Flujo', total: 5434.00 }
                        ]
                    }
                ]
            },
            '2026-2': { // Febrero 2026
                mes: 'Febrero',
                anio: 2026,
                cuentas: [
                    {
                        id: 1,
                        codigo: '100-00',
                        nombre: 'Ingresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 101, codigo: '101-00', nombre: 'Cobranza', total: 192000.00 },
                            { id: 102, codigo: '102-00', nombre: 'Otros Ingresos', total: 31200.00 },
                            { id: 103, codigo: '103-00', nombre: 'Traspasos Entre Ctas. Entradas', total: 48500.00 }
                        ]
                    },
                    {
                        id: 2,
                        codigo: '200-00',
                        nombre: 'Egresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 201, codigo: '201-00', nombre: 'Costos Operativos', total: 71200.00 },
                            { id: 202, codigo: '202-00', nombre: 'Costos Indirectos Operación', total: 35600.00 },
                            { id: 203, codigo: '203-00', nombre: 'Costos Indirectos Mantenimiento', total: 20300.00 },
                            { id: 204, codigo: '204-00', nombre: 'Gastos Administrativos', total: 45800.00 },
                            { id: 205, codigo: '205-00', nombre: 'Arrendamientos', total: 40000.00 },
                            { id: 206, codigo: '206-00', nombre: 'Impuestos', total: 16800.00 },
                            { id: 207, codigo: '207-00', nombre: 'Traspasos Entre Ctas. Salidas', total: 42500.00 },
                            { id: 299, codigo: '299-00', nombre: 'Gastos 50 Flujo', total: 5434.00 }
                        ]
                    }
                ]
            },
            '2026-3': { // Marzo 2026
                mes: 'Marzo',
                anio: 2026,
                cuentas: [
                    {
                        id: 1,
                        codigo: '100-00',
                        nombre: 'Ingresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 101, codigo: '101-00', nombre: 'Cobranza', total: 210000.00 },
                            { id: 102, codigo: '102-00', nombre: 'Otros Ingresos', total: 35600.00 },
                            { id: 103, codigo: '103-00', nombre: 'Traspasos Entre Ctas. Entradas', total: 51200.00 }
                        ]
                    },
                    {
                        id: 2,
                        codigo: '200-00',
                        nombre: 'Egresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 201, codigo: '201-00', nombre: 'Costos Operativos', total: 75400.00 },
                            { id: 202, codigo: '202-00', nombre: 'Costos Indirectos Operación', total: 37800.00 },
                            { id: 203, codigo: '203-00', nombre: 'Costos Indirectos Mantenimiento', total: 21500.00 },
                            { id: 204, codigo: '204-00', nombre: 'Gastos Administrativos', total: 48700.00 },
                            { id: 205, codigo: '205-00', nombre: 'Arrendamientos', total: 40000.00 },
                            { id: 206, codigo: '206-00', nombre: 'Impuestos', total: 18200.00 },
                            { id: 207, codigo: '207-00', nombre: 'Traspasos Entre Ctas. Salidas', total: 46800.00 },
                            { id: 299, codigo: '299-00', nombre: 'Gastos 50 Flujo', total: 5434.00 }
                        ]
                    }
                ]
            }
        };

        // Datos acumulados anuales
        const datosAcumulados = {
            '101-00': 587000.00, // Cobranza
            '102-00': 95200.00,  // Otros Ingresos
            '103-00': 151700.00, // Traspasos Entradas
            '201-00': 215100.00, // Costos Operativos
            '202-00': 105800.00, // Costos Indirectos Operación
            '203-00': 60700.00,  // Costos Indirectos Mantenimiento
            '204-00': 136800.00, // Gastos Administrativos
            '205-00': 120000.00, // Arrendamientos
            '206-00': 50600.00,  // Impuestos
            '207-00': 127300.00, // Traspasos Salidas
            '299-00': 16302.00   // Gastos 50 Flujo
        };

        // Variables globales
        let mesActual = 2; // Febrero
        let anioActual = 2026;
        
        // Elementos del DOM
        const selectMes = document.getElementById('mes');
        const selectAnio = document.getElementById('anio');
        const mesActualSpan = document.getElementById('mesActual');
        const btnExcel = document.getElementById('btnExcel');
        const btnColumnas = document.getElementById('btnColumnas');
        const tablaBody = document.getElementById('tablaBody');
        const sinDatosMensaje = document.getElementById('sinDatosMensaje');
        
        // Elementos de totales
        const totalMes = document.getElementById('totalMes');
        const totalAcumulado = document.getElementById('totalAcumulado');

        // Nombres de meses
        const nombresMeses = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];

        // Función para formatear moneda
        function formatCurrency(amount) {
            return '$' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }

        // Estado de expansión de cuentas (TODAS RETRAÍDAS POR DEFECTO)
        let datosExpandidos = {
            1: false, // Ingresos retraído
            2: false  // Egresos retraído
        };

        // Función para alternar expansión de cuenta principal
        function toggleExpand(cuentaId) {
            datosExpandidos[cuentaId] = !datosExpandidos[cuentaId];
            cargarTabla();
        }

        // Función para cargar la tabla
        function cargarTabla() {
            const clave = `${anioActual}-${mesActual}`;
            const mesData = datosFlujoPorMes[clave];
            
            if (!mesData || !mesData.cuentas || mesData.cuentas.length === 0) {
                sinDatosMensaje.style.display = 'block';
                tablaBody.innerHTML = '';
                return;
            }

            sinDatosMensaje.style.display = 'none';
            tablaBody.innerHTML = '';

            // Actualizar el nombre del mes en el encabezado
            mesActualSpan.textContent = nombresMeses[mesActual - 1];

            let totalMesValor = 0;
            let totalAcumuladoValor = 0;

            mesData.cuentas.forEach(cuenta => {
                // Calcular total de la cuenta principal para el mes
                let totalCuentaMes = 0;
                let totalCuentaAcumulado = 0;

                cuenta.subcuentas.forEach(sub => {
                    totalCuentaMes += sub.total || 0;
                    totalCuentaAcumulado += datosAcumulados[sub.codigo] || 0;
                });

                // Fila de cuenta principal (expandible/colapsable)
                const rowPrincipal = document.createElement('tr');
                rowPrincipal.className = 'cuenta-principal';
                rowPrincipal.setAttribute('data-cuenta-id', cuenta.id);
                
                const icono = datosExpandidos[cuenta.id] ? 'fa-chevron-down' : 'fa-chevron-right';
                
                rowPrincipal.innerHTML = `
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; font-weight: bold;">
                        <i class="fas ${icono}" style="margin-right: 8px; color: #6B8ACE;"></i>
                        ${cuenta.codigo} - ${cuenta.nombre}
                    </td>
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right;">${formatCurrency(totalCuentaMes)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; font-weight: bold;">${formatCurrency(totalCuentaAcumulado)}</td>
                `;
                
                rowPrincipal.addEventListener('click', (e) => {
                    // Evitar que el click en el icono dispare dos veces
                    if (e.target.classList.contains('fas')) {
                        toggleExpand(cuenta.id);
                    } else {
                        toggleExpand(cuenta.id);
                    }
                });
                
                tablaBody.appendChild(rowPrincipal);

                // Agregar subcuentas si está expandido
                if (datosExpandidos[cuenta.id]) {
                    cuenta.subcuentas.forEach(sub => {
                        const subAcumulado = datosAcumulados[sub.codigo] || 0;
                        
                        const rowSub = document.createElement('tr');
                        rowSub.className = 'subcuenta';
                        rowSub.innerHTML = `
                            <td style="border: 1px solid #dee2e6; padding: 10px 8px; padding-left: 35px;">${sub.codigo} - ${sub.nombre}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 8px; text-align: right;">${formatCurrency(sub.total || 0)}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 8px; text-align: right;">${formatCurrency(subAcumulado)}</td>
                        `;
                        tablaBody.appendChild(rowSub);
                    });
                }

                // Acumular totales generales
                totalMesValor += totalCuentaMes;
                totalAcumuladoValor += totalCuentaAcumulado;
            });

            // Actualizar totales en el pie de tabla
            totalMes.textContent = formatCurrency(totalMesValor);
            totalAcumulado.textContent = formatCurrency(totalAcumuladoValor);
        }

        // Event Listeners
        selectMes.addEventListener('change', function() {
            mesActual = parseInt(selectMes.value);
            cargarTabla();
        });

        selectAnio.addEventListener('change', function() {
            anioActual = parseInt(selectAnio.value);
            cargarTabla();
        });

        btnExcel.addEventListener('click', function() {
            alert('Exportar a Excel - Funcionalidad en desarrollo');
        });

        btnColumnas.addEventListener('click', function() {
            alert('Selector de Columnas - Funcionalidad en desarrollo');
        });

        // Cargar datos iniciales
        cargarTabla();
    });
</script>
@endsection