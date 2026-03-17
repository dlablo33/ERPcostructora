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
                <!-- Título principal -->


                <!-- Filtros a la derecha -->
                <div style="display: flex; justify-content: flex-end; align-items: center; gap: 15px; margin-bottom: 25px; flex-wrap: wrap;">
                    <!-- Fecha inicio -->
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-weight: 600; color: #083CAE; font-size: 14px;">Fecha inicio:</span>
                        <div style="border: 1px solid #ced4da; border-radius: 4px; padding: 6px 12px; background-color: white;">
                            <input type="date" id="dateStart" value="2025-09-01" style="border: none; background: transparent; font-size: 14px; outline: none; width: 140px;">
                        </div>
                    </div>

                    <!-- Fecha fin -->
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-weight: 600; color: #083CAE; font-size: 14px;">Fecha fin:</span>
                        <div style="border: 1px solid #ced4da; border-radius: 4px; padding: 6px 12px; background-color: white;">
                            <input type="date" id="dateEnd" value="2026-03-31" style="border: none; background: transparent; font-size: 14px; outline: none; width: 140px;">
                        </div>
                    </div>

                    <!-- Cuenta Contable -->
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-weight: 600; color: #083CAE; font-size: 14px;">Cuenta:</span>
                        <div style="border: 1px solid #ced4da; border-radius: 4px; padding: 6px 12px; background-color: white; min-width: 300px;">
                            <select id="cuenta_contable_sat_id" style="border: none; background: transparent; font-size: 14px; width: 100%; outline: none;">
                                <option value="8" selected>101-01-03 - ACTIVO A CORTO PLAZO PRUEBA</option>
                                <option value="4">101-01-01 - Caja y efectivo</option>
                                <option value="7">101-02-01 - Bancos nacionales</option>
                            </select>
                        </div>
                    </div>

                    <!-- Botón Buscar -->
                    <button id="buttonBusqueda" style="background-color: #2378e1; color: white; border: none; border-radius: 4px; padding: 8px 20px; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-search"></i> Buscar
                    </button>

                    <!-- Botón Excel -->
                    <button id="buttonExcel" style="background-color: #2CBF1F; color: white; border: none; border-radius: 4px; padding: 8px 20px; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-file-excel"></i> Excel
                    </button>
                </div>

                <!-- Línea divisoria -->
                <hr style="border: 1px solid #dee2e6; margin: 20px 0;">

                <!-- Info boxes (4 cuadros de resumen) - SIN ICONOS, SOLO TEXTO NEGRO -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
                    <!-- Saldo Inicial -->
                    <div style="background-color: white; border: 2px solid #083CAE; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); text-align: center;">
                        <div style="font-size: 14px; font-weight: 600; color: #6c757d; margin-bottom: 10px; text-transform: uppercase;">Saldo Inicial</div>
                        <div style="font-size: 28px; font-weight: bold; color: #000000;">$ 12.00</div>
                    </div>

                    <!-- Cargos -->
                    <div style="background-color: white; border: 2px solid #083CAE; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); text-align: center;">
                        <div style="font-size: 14px; font-weight: 600; color: #6c757d; margin-bottom: 10px; text-transform: uppercase;">Cargos</div>
                        <div style="font-size: 28px; font-weight: bold; color: #000000;">$ 11,712.50</div>
                    </div>

                    <!-- Abonos -->
                    <div style="background-color: white; border: 2px solid #083CAE; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); text-align: center;">
                        <div style="font-size: 14px; font-weight: 600; color: #6c757d; margin-bottom: 10px; text-transform: uppercase;">Abonos</div>
                        <div style="font-size: 28px; font-weight: bold; color: #000000;">$ 12.50</div>
                    </div>

                    <!-- Saldo Final -->
                    <div style="background-color: white; border: 2px solid #083CAE; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); text-align: center;">
                        <div style="font-size: 14px; font-weight: 600; color: #6c757d; margin-bottom: 10px; text-transform: uppercase;">Saldo Final</div>
                        <div style="font-size: 28px; font-weight: bold; color: #000000;">$ 11,712.00</div>
                    </div>
                </div>

                <!-- Información de la empresa y cuenta -->
                <div style="margin-bottom: 15px; padding: 10px 15px; background-color: #f8f9fa; border-radius: 8px; border: 1px solid #dee2e6;">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-building" style="color: #083CAE;"></i>
                            <span style="font-weight: 600; color: #083CAE; font-size: 16px;">Empresa DEMO</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-hashtag" style="color: #083CAE;"></i>
                            <span style="font-weight: 600;">101-01-03 - ACTIVO A CORTO PLAZO PRUEBA</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-calendar-alt" style="color: #083CAE;"></i>
                            <span>De 2025-09-01 a 2026-03-31</span>
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
                                <th style="padding: 12px 10px; text-align: right;">Saldo Inicial</th>
                                <th style="padding: 12px 10px; text-align: right;">Cargos</th>
                                <th style="padding: 12px 10px; text-align: right;">Abonos</th>
                                <th style="padding: 12px 10px; text-align: right;">Saldo Final</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="background-color: #ffffff; border-bottom: 1px solid #dee2e6;">
                                <td style="padding: 10px; text-align: center;">2025-09-22</td>
                                <td style="padding: 10px; text-align: center;">344</td>
                                <td style="padding: 10px; text-align: center;">Entradas Almacen</td>
                                <td style="padding: 10px; text-align: center;">100</td>
                                <td style="padding: 10px;">ARTICULO PRUEBA ROMEX</td>
                                <td style="padding: 10px; text-align: right; font-family: monospace;">12.00</td>
                                <td style="padding: 10px; text-align: right; font-family: monospace;">12.50</td>
                                <td style="padding: 10px; text-align: right; font-family: monospace;">0.00</td>
                                <td style="padding: 10px; text-align: right; font-family: monospace; font-weight: 600;">24.50</td>
                            </tr>
                            <tr style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
                                <td style="padding: 10px; text-align: center;">2025-09-22</td>
                                <td style="padding: 10px; text-align: center;">345</td>
                                <td style="padding: 10px; text-align: center;">Salidas Almacen</td>
                                <td style="padding: 10px; text-align: center;">79</td>
                                <td style="padding: 10px;">Almacen</td>
                                <td style="padding: 10px; text-align: right; font-family: monospace;">24.50</td>
                                <td style="padding: 10px; text-align: right; font-family: monospace;">0.00</td>
                                <td style="padding: 10px; text-align: right; font-family: monospace;">12.50</td>
                                <td style="padding: 10px; text-align: right; font-family: monospace; font-weight: 600;">12.00</td>
                            </tr>
                            <tr style="background-color: #ffffff; border-bottom: 1px solid #dee2e6;">
                                <td style="padding: 10px; text-align: center;">2025-09-24</td>
                                <td style="padding: 10px; text-align: center;">352</td>
                                <td style="padding: 10px; text-align: center;">Entradas Almacen</td>
                                <td style="padding: 10px; text-align: center;">104</td>
                                <td style="padding: 10px;">PAPELERIA</td>
                                <td style="padding: 10px; text-align: right; font-family: monospace;">12.00</td>
                                <td style="padding: 10px; text-align: right; font-family: monospace;">6,300.00</td>
                                <td style="padding: 10px; text-align: right; font-family: monospace;">0.00</td>
                                <td style="padding: 10px; text-align: right; font-family: monospace; font-weight: 600;">6,312.00</td>
                            </tr>
                            <tr style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
                                <td style="padding: 10px; text-align: center;">2025-09-24</td>
                                <td style="padding: 10px; text-align: center;">352</td>
                                <td style="padding: 10px; text-align: center;">Entradas Almacen</td>
                                <td style="padding: 10px; text-align: center;">104</td>
                                <td style="padding: 10px;">BATERIA</td>
                                <td style="padding: 10px; text-align: right; font-family: monospace;">6,312.00</td>
                                <td style="padding: 10px; text-align: right; font-family: monospace;">5,400.00</td>
                                <td style="padding: 10px; text-align: right; font-family: monospace;">0.00</td>
                                <td style="padding: 10px; text-align: right; font-family: monospace; font-weight: 600;">11,712.00</td>
                            </tr>
                        </tbody>
                        <!-- Fila de totales -->
                        <tfoot style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="5" style="padding: 12px 10px; text-align: right; border-top: 2px solid #083CAE;">TOTALES</td>
                                <td style="padding: 12px 10px; text-align: right; border-top: 2px solid #083CAE; font-family: monospace;">$ 12.00</td>
                                <td style="padding: 12px 10px; text-align: right; border-top: 2px solid #083CAE; font-family: monospace;">$ 11,712.50</td>
                                <td style="padding: 12px 10px; text-align: right; border-top: 2px solid #083CAE; font-family: monospace;">$ 12.50</td>
                                <td style="padding: 12px 10px; text-align: right; border-top: 2px solid #083CAE; font-family: monospace; font-weight: 700;">$ 11,712.00</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Paginación -->
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 20px; gap: 15px;">
                    <span style="color: #6c757d; font-size: 14px;">Mostrando 1-4 de 4 registros</span>
                    <div style="display: flex; gap: 5px;">
                        <button style="padding: 6px 10px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: not-allowed; color: #6c757d;" disabled>
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button style="padding: 6px 10px; border: 1px solid #083CAE; background: #083CAE; color: white; border-radius: 4px;">1</button>
                        <button style="padding: 6px 10px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: not-allowed; color: #6c757d;" disabled>
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
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
    
    /* Estilo para tarjetas de resumen - SOLO BORDE AZUL, SIN ICONOS */
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
    
    /* Estilo para números en monospace */
    [style*="font-family: monospace"] {
        font-size: 12px;
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
    
    #buttonBusqueda:active {
        transform: translateY(0);
    }
    
    /* Estilo para el botón Excel */
    #buttonExcel {
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(44, 191, 31, 0.2);
    }
    
    #buttonExcel:hover {
        background-color: #249e1a !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(44, 191, 31, 0.3);
    }
    
    #buttonExcel:active {
        transform: translateY(0);
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
    
    /* Estilo para botones de paginación */
    button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    button:not(:disabled):hover {
        transform: translateY(-2px);
        transition: transform 0.2s;
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
        
        [style*="display: flex; align-items: center; gap: 10px"] {
            width: 100%;
            justify-content: space-between;
        }
        
        [style*="min-width: 300px"] {
            min-width: 100% !important;
        }
        
        #buttonBusqueda, #buttonExcel {
            width: 100%;
            justify-content: center;
        }
        
        [style*="display: flex; justify-content: space-between; align-items: center"] {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start !important;
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
        
        // Evento del botón Buscar
        document.getElementById('buttonBusqueda')?.addEventListener('click', function() {
            const fechaInicio = document.getElementById('dateStart').value;
            const fechaFin = document.getElementById('dateEnd').value;
            const cuentaSelect = document.getElementById('cuenta_contable_sat_id');
            const cuentaText = cuentaSelect.options[cuentaSelect.selectedIndex]?.text || '';
            
            alert('Buscando...\n' + 
                  'Fecha inicio: ' + fechaInicio + '\n' +
                  'Fecha fin: ' + fechaFin + '\n' +
                  'Cuenta: ' + cuentaText);
            
            // Feedback visual
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 200);
        });
        
        // Evento del botón Excel
        document.getElementById('buttonExcel')?.addEventListener('click', function() {
            exportTableToExcel('table-bancos', 'Auxiliar_Contable');
            alert('Exportando a Excel...');
            
            // Feedback visual
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 200);
        });
        
        // Función para exportar a Excel
        function exportTableToExcel(tableClass, filename = '') {
            const table = document.querySelector('.' + tableClass);
            if (!table) return;
            
            let html = table.outerHTML;
            
            // Agregar información de encabezados
            const empresa = document.querySelector('[style*="font-weight: 600; color: #083CAE; font-size: 16px"]')?.textContent || 'Empresa DEMO';
            const cuenta = document.querySelector('[style*="font-weight: 600"]:nth-child(2)')?.textContent || 'Cuenta';
            const periodo = document.querySelector('[style*="display: flex; align-items: center; gap: 10px"]:nth-child(3) span')?.textContent || 'Período';
            
            html = '<h2>Auxiliar Cuenta Contable</h2>' +
                   '<h3>' + empresa + '</h3>' +
                   '<h4>' + cuenta + '</h4>' +
                   '<h5>' + periodo + '</h5>' +
                   html;
            
            var url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
            var link = document.createElement('a');
            link.href = url;
            link.download = filename + '.xls';
            link.click();
        }
    });
</script>
@endsection