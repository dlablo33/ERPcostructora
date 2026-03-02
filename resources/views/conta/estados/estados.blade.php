@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Estado de Resultados Operativo
        rgb(120, 205, 247); 
        -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #2378e1; padding: 15px 20px;">
                <div style="display: flex; justify-content: center; align-items: center; position: relative;">
                    <h2 style="color: #2378e1; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                        Estado de Resultados Operativo
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
        background-color:rgb(120, 205, 247);E !important;
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
        console.log('DOM completamente cargado - Estado de Resultados Operativo');
        
        // Datos para Enero 2026
        const datosEnero = {
            // Ingresos Netos y sus subconceptos
            1: { real: 21000.00, presupuesto: 20000.00 },
            2: { real: 5000.00, presupuesto: 4800.00 },
            3: { real: 3000.00, presupuesto: 3200.00 },
            4: { real: 4000.00, presupuesto: 3800.00 },
            5: { real: 6000.00, presupuesto: 5800.00 },
            6: { real: 2000.00, presupuesto: 1800.00 },
            7: { real: 0.00, presupuesto: 0.00 },
            8: { real: 0.00, presupuesto: 0.00 },
            9: { real: 0.00, presupuesto: 0.00 },
            10: { real: 0.00, presupuesto: 0.00 },
            11: { real: 0.00, presupuesto: 0.00 },
            12: { real: 1000.00, presupuesto: 600.00 },
            13: { real: 0.00, presupuesto: 0.00 },
            // Costo Directo de Operación
            14: { real: 6800.00, presupuesto: 6500.00 },
            15: { real: 4200.00, presupuesto: 4000.00 },
            16: { real: -200.00, presupuesto: 0.00 },
            17: { real: 1100.00, presupuesto: 1000.00 },
            18: { real: 0.00, presupuesto: 0.00 },
            19: { real: 0.00, presupuesto: 0.00 },
            20: { real: 1700.00, presupuesto: 1500.00 },
            // Utilidad Antes De Indirectos
            21: { real: 14200.00, presupuesto: 13500.00 },
            // Costo Indirecto De Mantenimiento
            22: { real: 82000.00, presupuesto: 80000.00 },
            23: { real: 0.00, presupuesto: 0.00 },
            24: { real: 0.00, presupuesto: 0.00 },
            25: { real: 0.00, presupuesto: 0.00 },
            26: { real: 0.00, presupuesto: 0.00 },
            27: { real: 41000.00, presupuesto: 40000.00 },
            28: { real: 0.00, presupuesto: 0.00 },
            29: { real: 41000.00, presupuesto: 40000.00 },
            30: { real: 0.00, presupuesto: 0.00 },
            31: { real: 0.00, presupuesto: 0.00 },
            // Depreciación
            32: { real: 0.00, presupuesto: 0.00 },
            33: { real: 0.00, presupuesto: 0.00 },
            // Gastos De Administracion
            34: { real: 125000.00, presupuesto: 120000.00 },
            35: { real: 0.00, presupuesto: 0.00 },
            36: { real: 125000.00, presupuesto: 120000.00 },
            37: { real: 0.00, presupuesto: 0.00 },
            38: { real: 0.00, presupuesto: 0.00 },
            39: { real: 0.00, presupuesto: 0.00 },
            40: { real: 0.00, presupuesto: 0.00 },
            41: { real: 0.00, presupuesto: 0.00 },
            42: { real: 0.00, presupuesto: 0.00 },
            // Gastos De Transportacion
            43: { real: 850.00, presupuesto: 800.00 },
            44: { real: 0.00, presupuesto: 0.00 },
            45: { real: 0.00, presupuesto: 0.00 },
            46: { real: 850.00, presupuesto: 800.00 },
            47: { real: 0.00, presupuesto: 0.00 },
            48: { real: 0.00, presupuesto: 0.00 },
            49: { real: 0.00, presupuesto: 0.00 },
            50: { real: 0.00, presupuesto: 0.00 },
            // Gastos Estados Resultados Default
            51: { real: 0.00, presupuesto: 0.00 },
            52: { real: 0.00, presupuesto: 0.00 },
            // Gastos Financieros
            53: { real: 0.00, presupuesto: 0.00 },
            54: { real: 0.00, presupuesto: 0.00 },
            55: { real: 0.00, presupuesto: 0.00 },
            56: { real: 0.00, presupuesto: 0.00 },
            // Utilidad O Perdida
            57: { real: -193650.00, presupuesto: -185800.00 },
            // Ebitda
            58: { real: -193650.00, presupuesto: -185800.00 }
        };

        // Datos para Febrero 2026 (los originales)
        const datosFebrero = {
            // Ingresos Netos y sus subconceptos
            1: { real: 22000.00, presupuesto: 0.00 },
            2: { real: 0.00, presupuesto: 0.00 },
            3: { real: 0.00, presupuesto: 0.00 },
            4: { real: 0.00, presupuesto: 0.00 },
            5: { real: 22000.00, presupuesto: 0.00 },
            6: { real: 0.00, presupuesto: 0.00 },
            7: { real: 0.00, presupuesto: 0.00 },
            8: { real: 0.00, presupuesto: 0.00 },
            9: { real: 0.00, presupuesto: 0.00 },
            10: { real: 0.00, presupuesto: 0.00 },
            11: { real: 0.00, presupuesto: 0.00 },
            12: { real: 0.00, presupuesto: 0.00 },
            13: { real: 0.00, presupuesto: 0.00 },
            // Costo Directo de Operación
            14: { real: 7120.00, presupuesto: 0.00 },
            15: { real: 4420.00, presupuesto: 0.00 },
            16: { real: -300.00, presupuesto: 0.00 },
            17: { real: 1200.00, presupuesto: 0.00 },
            18: { real: 0.00, presupuesto: 0.00 },
            19: { real: 0.00, presupuesto: 0.00 },
            20: { real: 1800.00, presupuesto: 0.00 },
            // Utilidad Antes De Indirectos
            21: { real: 14880.00, presupuesto: 0.00 },
            // Costo Indirecto De Mantenimiento
            22: { real: 86000.00, presupuesto: 0.00 },
            23: { real: 0.00, presupuesto: 0.00 },
            24: { real: 0.00, presupuesto: 0.00 },
            25: { real: 0.00, presupuesto: 0.00 },
            26: { real: 0.00, presupuesto: 0.00 },
            27: { real: 43000.00, presupuesto: 0.00 },
            28: { real: 0.00, presupuesto: 0.00 },
            29: { real: 43000.00, presupuesto: 0.00 },
            30: { real: 0.00, presupuesto: 0.00 },
            31: { real: 0.00, presupuesto: 0.00 },
            // Depreciación
            32: { real: 0.00, presupuesto: 0.00 },
            33: { real: 0.00, presupuesto: 0.00 },
            // Gastos De Administracion
            34: { real: 130000.00, presupuesto: 0.00 },
            35: { real: 0.00, presupuesto: 0.00 },
            36: { real: 130000.00, presupuesto: 0.00 },
            37: { real: 0.00, presupuesto: 0.00 },
            38: { real: 0.00, presupuesto: 0.00 },
            39: { real: 0.00, presupuesto: 0.00 },
            40: { real: 0.00, presupuesto: 0.00 },
            41: { real: 0.00, presupuesto: 0.00 },
            42: { real: 0.00, presupuesto: 0.00 },
            // Gastos De Transportacion
            43: { real: 880.00, presupuesto: 0.00 },
            44: { real: 0.00, presupuesto: 0.00 },
            45: { real: 0.00, presupuesto: 0.00 },
            46: { real: 880.00, presupuesto: 0.00 },
            47: { real: 0.00, presupuesto: 0.00 },
            48: { real: 0.00, presupuesto: 0.00 },
            49: { real: 0.00, presupuesto: 0.00 },
            50: { real: 0.00, presupuesto: 0.00 },
            // Gastos Estados Resultados Default
            51: { real: 0.00, presupuesto: 0.00 },
            52: { real: 0.00, presupuesto: 0.00 },
            // Gastos Financieros
            53: { real: 0.00, presupuesto: 0.00 },
            54: { real: 0.00, presupuesto: 0.00 },
            55: { real: 0.00, presupuesto: 0.00 },
            56: { real: 0.00, presupuesto: 0.00 },
            // Utilidad O Perdida
            57: { real: -202000.00, presupuesto: 0.00 },
            // Ebitda
            58: { real: -202000.00, presupuesto: 0.00 }
        };

        // Estructura de conceptos (igual que antes)
        const datosEstadoResultados = [
            {
                id: 1,
                concepto: 'Ingresos Netos',
                esEncabezado: true,
                nivel: 0,
                subconceptos: [
                    { id: 2, concepto: 'Unidad De Negocio Prueba', esEncabezado: false, nivel: 1 },
                    { id: 3, concepto: 'Prueba Soporte', esEncabezado: false, nivel: 1 },
                    { id: 4, concepto: 'Refrigerados', esEncabezado: false, nivel: 1 },
                    { id: 5, concepto: 'Foraneo', esEncabezado: false, nivel: 1 },
                    { id: 6, concepto: 'Almacenamiento Y Distribucion', esEncabezado: false, nivel: 1 },
                    { id: 7, concepto: 'Foraneos Laredo', esEncabezado: false, nivel: 1 },
                    { id: 8, concepto: '123', esEncabezado: false, nivel: 1 },
                    { id: 9, concepto: 'Exportacion', esEncabezado: false, nivel: 1 },
                    { id: 10, concepto: 'Un Bajio', esEncabezado: false, nivel: 1 },
                    { id: 11, concepto: 'Local', esEncabezado: false, nivel: 1 },
                    { id: 12, concepto: 'Regional', esEncabezado: false, nivel: 1 },
                    { id: 13, concepto: 'Otros Costos De Operacion', esEncabezado: false, nivel: 1 }
                ]
            },
            {
                id: 14,
                concepto: 'Costo Directo De Operación (liquidaciones Cerradas)',
                esEncabezado: true,
                nivel: 0,
                subconceptos: [
                    { id: 15, concepto: 'Diesel', esEncabezado: false, nivel: 1 },
                    { id: 16, concepto: 'Adicionales', esEncabezado: false, nivel: 1 },
                    { id: 17, concepto: 'Gastos De Viaje Operadores', esEncabezado: false, nivel: 1 },
                    { id: 18, concepto: 'Urea', esEncabezado: false, nivel: 1 },
                    { id: 19, concepto: 'Casetas', esEncabezado: false, nivel: 1 },
                    { id: 20, concepto: 'Sueldos Operadores', esEncabezado: false, nivel: 1 }
                ]
            },
            {
                id: 21,
                concepto: 'Utilidad Antes De Indirectos',
                esEncabezado: true,
                nivel: 0,
                subconceptos: []
            },
            {
                id: 22,
                concepto: 'Costo Indirecto De Mantenimiento',
                esEncabezado: true,
                nivel: 0,
                subconceptos: [
                    { id: 23, concepto: 'Mantenimiento Correctivo', esEncabezado: false, nivel: 1 },
                    { id: 24, concepto: 'Talleres Externos', esEncabezado: false, nivel: 1 },
                    { id: 25, concepto: 'Sueldos Mtto.', esEncabezado: false, nivel: 1 },
                    { id: 26, concepto: 'Otros Gastos Mtto.', esEncabezado: false, nivel: 1 },
                    { id: 27, concepto: 'Llantas', esEncabezado: false, nivel: 1 },
                    { id: 28, concepto: 'Gasolina Y Mtto. Utilitarios', esEncabezado: false, nivel: 1 },
                    { id: 29, concepto: 'Mantenimiento Preventivo', esEncabezado: false, nivel: 1 },
                    { id: 30, concepto: 'Cuotas Patronales Mtto.', esEncabezado: false, nivel: 1 },
                    { id: 31, concepto: 'Siniestros', esEncabezado: false, nivel: 1 }
                ]
            },
            {
                id: 32,
                concepto: 'Depreciación',
                esEncabezado: true,
                nivel: 0,
                subconceptos: [
                    { id: 33, concepto: 'Depreciación', esEncabezado: false, nivel: 1 }
                ]
            },
            {
                id: 34,
                concepto: 'Gastos De Administracion',
                esEncabezado: true,
                nivel: 0,
                subconceptos: [
                    { id: 35, concepto: 'Gastos De Viaje', esEncabezado: false, nivel: 1 },
                    { id: 36, concepto: 'Otros Gastos Admon.', esEncabezado: false, nivel: 1 },
                    { id: 37, concepto: 'Renta Y Vigilancia', esEncabezado: false, nivel: 1 },
                    { id: 38, concepto: 'Cuotas Patronales Admon.', esEncabezado: false, nivel: 1 },
                    { id: 39, concepto: 'Sistemas Y Mtto. Computo', esEncabezado: false, nivel: 1 },
                    { id: 40, concepto: 'Servicios', esEncabezado: false, nivel: 1 },
                    { id: 41, concepto: 'Gasolina Y Mtto. Utilitarios', esEncabezado: false, nivel: 1 },
                    { id: 42, concepto: 'Sueldos', esEncabezado: false, nivel: 1 }
                ]
            },
            {
                id: 43,
                concepto: 'Gastos De Transportacion',
                esEncabezado: true,
                nivel: 0,
                subconceptos: [
                    { id: 44, concepto: 'Costo Exportación', esEncabezado: false, nivel: 1 },
                    { id: 45, concepto: 'Deducibles Siniestros', esEncabezado: false, nivel: 1 },
                    { id: 46, concepto: 'Indirectos Operadores', esEncabezado: false, nivel: 1 },
                    { id: 47, concepto: 'Seguros', esEncabezado: false, nivel: 1 },
                    { id: 48, concepto: 'Rastreo Satelital Y Monitoreo', esEncabezado: false, nivel: 1 },
                    { id: 49, concepto: 'Multas', esEncabezado: false, nivel: 1 },
                    { id: 50, concepto: 'Otros Gastos Transportación', esEncabezado: false, nivel: 1 }
                ]
            },
            {
                id: 51,
                concepto: 'Gastos Estados Resultados Default',
                esEncabezado: true,
                nivel: 0,
                subconceptos: [
                    { id: 52, concepto: 'Gastos Estados Resultados Default', esEncabezado: false, nivel: 1 }
                ]
            },
            {
                id: 53,
                concepto: 'Gastos Financieros',
                esEncabezado: true,
                nivel: 0,
                subconceptos: [
                    { id: 54, concepto: 'Arrendamiento', esEncabezado: false, nivel: 1 },
                    { id: 55, concepto: 'Utilidad O Perdida Cambiaria', esEncabezado: false, nivel: 1 },
                    { id: 56, concepto: 'Intereses Por Financiamiento', esEncabezado: false, nivel: 1 }
                ]
            },
            {
                id: 57,
                concepto: 'Utilidad O Perdida',
                esEncabezado: true,
                nivel: 0,
                subconceptos: []
            },
            {
                id: 58,
                concepto: 'Ebitda',
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

        // Estado de expansión de encabezados
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
            let totalDiferencia = 0;
            let baseReal = valoresConceptos[1]?.real || 0; // Ingresos Netos como base para %

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
                    if (!e.target.classList.contains('fas')) {
                        toggleExpand(encabezado.id);
                    }
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
            totalDiferencia = totalReal - totalPresupuesto;
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

        // Cargar datos iniciales (Febrero por defecto)
        cargarTabla();

        // Event Listener para cambio de mes
        document.getElementById('mesSelector')?.addEventListener('change', function() {
            cargarTabla();
        });
    });
</script>
@endsection