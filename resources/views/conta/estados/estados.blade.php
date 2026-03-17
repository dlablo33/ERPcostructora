@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Estado de Resultados Operativo -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #2378e1; padding: 15px 20px;">
                <div style="display: flex; justify-content: center; align-items: center; position: relative;">
                    <h2 style="color: #2378e1; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                        Estado de Resultados Operativo - Construcción
                    </h2>
                    <div style="position: absolute; right: 0; display: flex; align-items: center; gap: 10px;">
                        <span style="color: #6c757d; font-size: 14px;">Al día de:</span>
                        <select id="mesSelector" style="padding: 6px 12px; border: 1px solid #2378e1; border-radius: 4px; font-size: 14px; background-color: white; color: #2378e1; font-weight: 500;">
                            <option value="Enero 2026">Enero 2026</option>
                            <option value="Febrero 2026" selected>Febrero 2026</option>
                        </select>
                    </div>
                </div>
                <p style="color: #083CAE !important; font-size: 14px; margin: 5px 0 0 0; text-align: center;">
                    (Real vs Presupuesto)
                </p>
            </div>

            <div class="card-body p-4">
                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-chart-line" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay información para el período seleccionado</p>
                </div>

                <!-- Tabla de Estado de Resultados -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaEstadoResultados" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: left; background-color: #2378e1; color: white; min-width: 300px;">
                                    <span>Concepto</span>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #2378e1; color: white; min-width: 120px;">
                                    <span>Real</span>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #2378e1; color: white; min-width: 80px;">
                                    <span>%</span>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #2378e1; color: white; min-width: 120px;">
                                    <span>Presupuesto</span>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #2378e1; color: white; min-width: 80px;">
                                    <span>%</span>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #2378e1; color: white; min-width: 120px;">
                                    <span>Diferencia</span>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #2378e1; color: white; min-width: 80px;">
                                    <span>%</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <!-- Las filas se insertarán dinámicamente -->
                        </tbody>
                        <!-- Fila de totales -->
                        <tfoot id="tablaFoot" style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold; display: table-footer-group;">
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: left; background-color: #e9ecef; color: #000000; font-weight: bold;">TOTALES</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; color: #000000;" id="totalReal">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; color: #000000;" id="totalRealPorcentaje">0.00%</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; color: #000000;" id="totalPresupuesto">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; color: #000000;" id="totalPresupuestoPorcentaje">0.00%</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; color: #000000;" id="totalDiferencia">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; color: #000000;" id="totalDiferenciaPorcentaje">0.00%</td>
                            </tr>
                        </tfoot>
                    </table>
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
    
    /* Estilos de tabla */
    .table th {
        white-space: nowrap;
        font-size: 12px;
        background-color: #2378e1 !important;
        color: white;
        font-weight: 600;
        padding: 12px 8px;
    }
    
    .table td {
        white-space: nowrap;
        font-size: 12px;
        padding: 12px 8px;
        color: #000000 !important;
    }
    
    /* Estilo para las filas de encabezados de sección */
    .fila-encabezado {
        background-color: #f0f4ff !important;
        font-weight: bold;
        cursor: pointer;
    }
    
    .fila-encabezado:hover {
        background-color: #e1f0ff !important;
    }
    
    .fila-encabezado i {
        transition: transform 0.2s;
        color: #083CAE;
        margin-right: 8px;
    }
    
    .fila-encabezado:not(.expandido) i {
        transform: rotate(-90deg);
    }
    
    /* Estilo para filas de detalle */
    .fila-detalle {
        background-color: #ffffff;
    }
    
    .fila-detalle:hover {
        background-color: #f2f2f2;
    }
    
    .fila-detalle td:first-child {
        padding-left: 30px !important;
    }
    
    /* Estilo para filas alternadas en detalles */
    .fila-detalle:nth-child(even) {
        background-color: #fafbfc;
    }
    
    /* Estilo para números negativos */
    .text-danger {
        color: #dc3545 !important;
    }
    
    /* Estilo para el pie de tabla (totales) */
    tfoot td {
        font-weight: bold;
        background-color: #e9ecef !important;
        border-top: 2px solid #2378e1;
        color: #000000 !important;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        select {
            width: 100% !important;
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
        console.log('DOM completamente cargado - Estado de Resultados Operativo - Construcción');
        
        // Datos para Enero 2026 (Constructora)
        const datosEnero = {
            // Ingresos por Obra
            1: { real: 12500000.00, presupuesto: 12000000.00 },
            2: { real: 5500000.00, presupuesto: 5200000.00 },
            3: { real: 3800000.00, presupuesto: 3500000.00 },
            4: { real: 3200000.00, presupuesto: 3300000.00 },
            5: { real: 0.00, presupuesto: 0.00 },
            
            // Costo Directo de Construcción
            6: { real: 4250000.00, presupuesto: 4000000.00 },
            7: { real: 2850000.00, presupuesto: 2700000.00 },
            8: { real: 1650000.00, presupuesto: 1500000.00 },
            9: { real: 980000.00, presupuesto: 900000.00 },
            10: { real: 650000.00, presupuesto: 600000.00 },
            11: { real: 450000.00, presupuesto: 400000.00 },
            12: { real: 120000.00, presupuesto: 100000.00 },
            
            // Utilidad Bruta
            13: { real: 8250000.00, presupuesto: 8000000.00 },
            
            // Costos Indirectos de Obra
            14: { real: 1250000.00, presupuesto: 1200000.00 },
            15: { real: 380000.00, presupuesto: 350000.00 },
            16: { real: 220000.00, presupuesto: 200000.00 },
            17: { real: 150000.00, presupuesto: 140000.00 },
            18: { real: 95000.00, presupuesto: 90000.00 },
            19: { real: 450000.00, presupuesto: 400000.00 },
            20: { real: 280000.00, presupuesto: 250000.00 },
            21: { real: 120000.00, presupuesto: 100000.00 },
            22: { real: 0.00, presupuesto: 0.00 },
            
            // Gastos Generales
            23: { real: 2150000.00, presupuesto: 2000000.00 },
            24: { real: 680000.00, presupuesto: 650000.00 },
            25: { real: 320000.00, presupuesto: 300000.00 },
            26: { real: 185000.00, presupuesto: 180000.00 },
            27: { real: 520000.00, presupuesto: 500000.00 },
            28: { real: 380000.00, presupuesto: 350000.00 },
            29: { real: 95000.00, presupuesto: 90000.00 },
            30: { real: 0.00, presupuesto: 0.00 },
            31: { real: 420000.00, presupuesto: 400000.00 },
            32: { real: 150000.00, presupuesto: 100000.00 },
            
            // Utilidad de Operación
            33: { real: 4850000.00, presupuesto: 4800000.00 },
            
            // Gastos Financieros
            34: { real: 350000.00, presupuesto: 300000.00 },
            35: { real: 150000.00, presupuesto: 150000.00 },
            36: { real: 200000.00, presupuesto: 150000.00 },
            
            // Utilidad Antes de Impuestos
            37: { real: 4500000.00, presupuesto: 4500000.00 },
            
            // EBITDA
            38: { real: 5200000.00, presupuesto: 5100000.00 },
            
            // Impuestos
            39: { real: 1350000.00, presupuesto: 1350000.00 },
            40: { real: 1350000.00, presupuesto: 1350000.00 },
            
            // Utilidad Neta
            41: { real: 3150000.00, presupuesto: 3150000.00 }
        };

        // Datos para Febrero 2026 (Constructora)
        const datosFebrero = {
            // Ingresos por Obra
            1: { real: 13800000.00, presupuesto: 13000000.00 },
            2: { real: 6200000.00, presupuesto: 5800000.00 },
            3: { real: 4100000.00, presupuesto: 3800000.00 },
            4: { real: 3500000.00, presupuesto: 3400000.00 },
            5: { real: 0.00, presupuesto: 0.00 },
            
            // Costo Directo de Construcción
            6: { real: 4680000.00, presupuesto: 4400000.00 },
            7: { real: 3120000.00, presupuesto: 2950000.00 },
            8: { real: 1820000.00, presupuesto: 1650000.00 },
            9: { real: 1080000.00, presupuesto: 980000.00 },
            10: { real: 720000.00, presupuesto: 650000.00 },
            11: { real: 520000.00, presupuesto: 450000.00 },
            12: { real: 140000.00, presupuesto: 120000.00 },
            
            // Utilidad Bruta
            13: { real: 9120000.00, presupuesto: 8600000.00 },
            
            // Costos Indirectos de Obra
            14: { real: 1380000.00, presupuesto: 1300000.00 },
            15: { real: 420000.00, presupuesto: 380000.00 },
            16: { real: 250000.00, presupuesto: 220000.00 },
            17: { real: 165000.00, presupuesto: 150000.00 },
            18: { real: 105000.00, presupuesto: 95000.00 },
            19: { real: 520000.00, presupuesto: 450000.00 },
            20: { real: 320000.00, presupuesto: 280000.00 },
            21: { real: 140000.00, presupuesto: 120000.00 },
            22: { real: 0.00, presupuesto: 0.00 },
            
            // Gastos Generales
            23: { real: 2320000.00, presupuesto: 2150000.00 },
            24: { real: 720000.00, presupuesto: 680000.00 },
            25: { real: 350000.00, presupuesto: 320000.00 },
            26: { real: 195000.00, presupuesto: 185000.00 },
            27: { real: 580000.00, presupuesto: 520000.00 },
            28: { real: 420000.00, presupuesto: 380000.00 },
            29: { real: 105000.00, presupuesto: 95000.00 },
            30: { real: 0.00, presupuesto: 0.00 },
            31: { real: 450000.00, presupuesto: 420000.00 },
            32: { real: 150000.00, presupuesto: 120000.00 },
            
            // Utilidad de Operación
            33: { real: 5420000.00, presupuesto: 5150000.00 },
            
            // Gastos Financieros
            34: { real: 380000.00, presupuesto: 320000.00 },
            35: { real: 160000.00, presupuesto: 150000.00 },
            36: { real: 220000.00, presupuesto: 170000.00 },
            
            // Utilidad Antes de Impuestos
            37: { real: 5040000.00, presupuesto: 4830000.00 },
            
            // EBITDA
            38: { real: 5800000.00, presupuesto: 5470000.00 },
            
            // Impuestos
            39: { real: 1512000.00, presupuesto: 1449000.00 },
            40: { real: 1512000.00, presupuesto: 1449000.00 },
            
            // Utilidad Neta
            41: { real: 3528000.00, presupuesto: 3381000.00 }
        };

        // Estructura de conceptos para Constructora (expanden/contraen)
        const datosEstadoResultados = [
            {
                id: 1,
                concepto: 'Ingresos por Obra',
                esEncabezado: true,
                nivel: 0,
                subconceptos: [
                    { id: 2, concepto: 'Torre Norte Corporativa', esEncabezado: false, nivel: 1 },
                    { id: 3, concepto: 'Hospital Regional', esEncabezado: false, nivel: 1 },
                    { id: 4, concepto: 'Parque Industrial Norte', esEncabezado: false, nivel: 1 },
                    { id: 5, concepto: 'Puente Vehicular Sur', esEncabezado: false, nivel: 1 }
                ]
            },
            {
                id: 6,
                concepto: 'Costo Directo de Construcción',
                esEncabezado: true,
                nivel: 0,
                subconceptos: [
                    { id: 7, concepto: 'Materiales', esEncabezado: false, nivel: 1 },
                    { id: 8, concepto: 'Mano de Obra Directa', esEncabezado: false, nivel: 1 },
                    { id: 9, concepto: 'Maquinaria y Equipo', esEncabezado: false, nivel: 1 },
                    { id: 10, concepto: 'Subcontratos Especializados', esEncabezado: false, nivel: 1 },
                    { id: 11, concepto: 'Herramienta Menor', esEncabezado: false, nivel: 1 },
                    { id: 12, concepto: 'Otros Costos Directos', esEncabezado: false, nivel: 1 }
                ]
            },
            {
                id: 13,
                concepto: 'Utilidad Bruta',
                esEncabezado: true,
                nivel: 0,
                subconceptos: []
            },
            {
                id: 14,
                concepto: 'Costos Indirectos de Obra',
                esEncabezado: true,
                nivel: 0,
                subconceptos: [
                    { id: 15, concepto: 'Residente de Obra', esEncabezado: false, nivel: 1 },
                    { id: 16, concepto: 'Supervisión Técnica', esEncabezado: false, nivel: 1 },
                    { id: 17, concepto: 'Topografía', esEncabezado: false, nivel: 1 },
                    { id: 18, concepto: 'Control de Calidad', esEncabezado: false, nivel: 1 },
                    { id: 19, concepto: 'Seguridad e Higiene', esEncabezado: false, nivel: 1 },
                    { id: 20, concepto: 'Renta de Oficinas de Obra', esEncabezado: false, nivel: 1 },
                    { id: 21, concepto: 'Vigilancia', esEncabezado: false, nivel: 1 },
                    { id: 22, concepto: 'Otros Indirectos', esEncabezado: false, nivel: 1 }
                ]
            },
            {
                id: 23,
                concepto: 'Gastos Generales',
                esEncabezado: true,
                nivel: 0,
                subconceptos: [
                    { id: 24, concepto: 'Sueldos Administrativos', esEncabezado: false, nivel: 1 },
                    { id: 25, concepto: 'Renta de Oficinas Centrales', esEncabezado: false, nivel: 1 },
                    { id: 26, concepto: 'Servicios (Luz, Agua, Internet)', esEncabezado: false, nivel: 1 },
                    { id: 27, concepto: 'Honorarios Profesionales', esEncabezado: false, nivel: 1 },
                    { id: 28, concepto: 'Papelería y Útiles', esEncabezado: false, nivel: 1 },
                    { id: 29, concepto: 'Capacitación', esEncabezado: false, nivel: 1 },
                    { id: 30, concepto: 'Gastos de Viaje', esEncabezado: false, nivel: 1 },
                    { id: 31, concepto: 'Mantenimiento de Oficinas', esEncabezado: false, nivel: 1 },
                    { id: 32, concepto: 'Otros Gastos Generales', esEncabezado: false, nivel: 1 }
                ]
            },
            {
                id: 33,
                concepto: 'Utilidad de Operación',
                esEncabezado: true,
                nivel: 0,
                subconceptos: []
            },
            {
                id: 34,
                concepto: 'Gastos Financieros',
                esEncabezado: true,
                nivel: 0,
                subconceptos: [
                    { id: 35, concepto: 'Intereses Bancarios', esEncabezado: false, nivel: 1 },
                    { id: 36, concepto: 'Comisiones', esEncabezado: false, nivel: 1 }
                ]
            },
            {
                id: 37,
                concepto: 'Utilidad Antes de Impuestos',
                esEncabezado: true,
                nivel: 0,
                subconceptos: []
            },
            {
                id: 38,
                concepto: 'EBITDA',
                esEncabezado: true,
                nivel: 0,
                subconceptos: []
            },
            {
                id: 39,
                concepto: 'Impuestos',
                esEncabezado: true,
                nivel: 0,
                subconceptos: [
                    { id: 40, concepto: 'ISR', esEncabezado: false, nivel: 1 }
                ]
            },
            {
                id: 41,
                concepto: 'Utilidad Neta',
                esEncabezado: true,
                nivel: 0,
                subconceptos: []
            }
        ];

        // Función para formatear moneda
        function formatCurrency(amount) {
            const formatted = '$' + Math.abs(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            return amount < 0 ? '-' + formatted : formatted;
        }

        // Función para calcular porcentaje
        function calcularPorcentaje(valor, base) {
            if (base === 0) return 0;
            return (valor / base) * 100;
        }

        // Estado de expansión de encabezados - TODOS CONTRAÍDOS POR DEFECTO
        let expandedHeaders = new Set();

        // Función para alternar expansión de encabezado
        function toggleExpand(id) {
            if (expandedHeaders.has(id)) {
                expandedHeaders.delete(id);
            } else {
                expandedHeaders.add(id);
            }
            cargarTabla();
        }

        // Función para obtener los datos según el mes seleccionado
        function obtenerDatosMes(mes) {
            if (mes === 'Enero 2026') {
                return datosEnero;
            } else {
                return datosFebrero;
            }
        }

        // Función para generar la tabla
        function cargarTabla() {
            const tablaBody = document.getElementById('tablaBody');
            if (!tablaBody) return;

            const mesSeleccionado = document.getElementById('mesSelector').value;
            const valoresConceptos = obtenerDatosMes(mesSeleccionado);

            tablaBody.innerHTML = '';

            // Variable para calcular totales
            let totalReal = 0;
            let totalPresupuesto = 0;
            let baseReal = valoresConceptos[1]?.real || 0; // Ingresos por Obra como base para %

            datosEstadoResultados.forEach(encabezado => {
                const valorEnc = valoresConceptos[encabezado.id] || { real: 0, presupuesto: 0 };
                const diferenciaEnc = valorEnc.real - valorEnc.presupuesto;
                const porcentajeRealEnc = calcularPorcentaje(valorEnc.real, baseReal);
                const porcentajePresupuestoEnc = calcularPorcentaje(valorEnc.presupuesto, baseReal);
                const porcentajeDiferenciaEnc = calcularPorcentaje(diferenciaEnc, baseReal);

                // Acumular totales
                totalReal += valorEnc.real;
                totalPresupuesto += valorEnc.presupuesto;

                // Fila de encabezado principal
                const encabezadoRow = document.createElement('tr');
                encabezadoRow.className = 'fila-encabezado';
                encabezadoRow.dataset.id = encabezado.id;
                
                const icono = expandedHeaders.has(encabezado.id) ? 'fa-chevron-down' : 'fa-chevron-right';
                
                encabezadoRow.innerHTML = `
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; font-weight: bold; color: #000000;">
                        <i class="fas ${icono}" style="margin-right: 8px; color: #2378e1;"></i>
                        ${encabezado.concepto}
                    </td>
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; color: #000000; ${valorEnc.real < 0 ? 'color: #dc3545;' : ''}">${formatCurrency(valorEnc.real)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; color: #000000;">${porcentajeRealEnc.toFixed(2)}%</td>
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; color: #000000; ${valorEnc.presupuesto < 0 ? 'color: #dc3545;' : ''}">${formatCurrency(valorEnc.presupuesto)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; color: #000000;">${porcentajePresupuestoEnc.toFixed(2)}%</td>
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; color: #000000; ${diferenciaEnc < 0 ? 'color: #dc3545;' : ''}">${formatCurrency(diferenciaEnc)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; color: #000000;">${porcentajeDiferenciaEnc.toFixed(2)}%</td>
                `;

                encabezadoRow.addEventListener('click', (e) => {
                    e.stopPropagation();
                    toggleExpand(encabezado.id);
                });

                tablaBody.appendChild(encabezadoRow);

                // Mostrar subconceptos si está expandido
                if (expandedHeaders.has(encabezado.id) && encabezado.subconceptos && encabezado.subconceptos.length > 0) {
                    encabezado.subconceptos.forEach(sub => {
                        const valorSub = valoresConceptos[sub.id] || { real: 0, presupuesto: 0 };
                        const diferenciaSub = valorSub.real - valorSub.presupuesto;
                        const porcentajeRealSub = calcularPorcentaje(valorSub.real, baseReal);
                        const porcentajePresupuestoSub = calcularPorcentaje(valorSub.presupuesto, baseReal);
                        const porcentajeDiferenciaSub = calcularPorcentaje(diferenciaSub, baseReal);

                        const subRow = document.createElement('tr');
                        subRow.className = 'fila-detalle';
                        subRow.innerHTML = `
                            <td style="border: 1px solid #dee2e6; padding: 12px 8px; padding-left: 40px; color: #000000;">${sub.concepto}</td>
                            <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; color: #000000; ${valorSub.real < 0 ? 'color: #dc3545;' : ''}">${formatCurrency(valorSub.real)}</td>
                            <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; color: #000000;">${porcentajeRealSub.toFixed(2)}%</td>
                            <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; color: #000000; ${valorSub.presupuesto < 0 ? 'color: #dc3545;' : ''}">${formatCurrency(valorSub.presupuesto)}</td>
                            <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; color: #000000;">${porcentajePresupuestoSub.toFixed(2)}%</td>
                            <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; color: #000000; ${diferenciaSub < 0 ? 'color: #dc3545;' : ''}">${formatCurrency(diferenciaSub)}</td>
                            <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; color: #000000;">${porcentajeDiferenciaSub.toFixed(2)}%</td>
                        `;
                        tablaBody.appendChild(subRow);
                    });
                }
            });

            // Calcular totales
            const totalDiferencia = totalReal - totalPresupuesto;
            const porcentajeTotalReal = totalReal !== 0 ? 100 : 0;
            const porcentajeTotalPresupuesto = totalPresupuesto !== 0 ? 100 : 0;
            const porcentajeTotalDiferencia = totalReal !== 0 ? (totalDiferencia / totalReal) * 100 : 0;

            document.getElementById('totalReal').textContent = formatCurrency(totalReal);
            document.getElementById('totalRealPorcentaje').textContent = porcentajeTotalReal.toFixed(2) + '%';
            document.getElementById('totalPresupuesto').textContent = formatCurrency(totalPresupuesto);
            document.getElementById('totalPresupuestoPorcentaje').textContent = porcentajeTotalPresupuesto.toFixed(2) + '%';
            document.getElementById('totalDiferencia').textContent = formatCurrency(totalDiferencia);
            document.getElementById('totalDiferenciaPorcentaje').textContent = porcentajeTotalDiferencia.toFixed(2) + '%';
        }

        // Cargar datos iniciales (Febrero por defecto) - TODOS CONTRAÍDOS
        cargarTabla();

        // Event Listener para cambio de mes
        document.getElementById('mesSelector')?.addEventListener('change', function() {
            cargarTabla();
        });
    });
</script>
@endsection