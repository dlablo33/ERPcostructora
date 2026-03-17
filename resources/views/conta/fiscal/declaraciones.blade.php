@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Cierre de Mes -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Cierre de Mes
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Filtro mensual y botón de cierre - TODO A LA DERECHA -->
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 30px; gap: 15px; flex-wrap: wrap;">
                    <!-- Filtro de mes y año -->
                    <div style="display: flex; gap: 15px; align-items: center;">
                        <div style="font-weight: 600; color: #083CAE; font-size: 15px;">Período a cerrar:</div>
                        <div style="display: flex; border: 1px solid #083CAE; border-radius: 8px; overflow: hidden;">
                            <select id="mes" style="padding: 10px 15px; border: none; font-size: 14px; background-color: white; width: 120px; border-right: 1px solid #dee2e6;">
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
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
                            <select id="anio" style="padding: 10px 15px; border: none; font-size: 14px; background-color: white; width: 100px;">
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026" selected>2026</option>
                            </select>
                        </div>
                    </div>

                    <!-- Botón de cierre de mes -->
                    <button id="btnCierre" style="background-color: #2CBF1F; color: white; border: none; border-radius: 8px; padding: 12px 30px; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-lock"></i> Ejecutar Cierre de Mes
                    </button>
                </div>

                <!-- Tarjetas de resumen -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
                    <!-- Período actual -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 48px; height: 48px; background-color: #e6f2ff; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-calendar-alt" style="color: #083CAE; font-size: 24px;"></i>
                            </div>
                            <div>
                                <div style="font-size: 13px; color: #6c757d; margin-bottom: 5px;">Período Actual</div>
                                <div style="font-size: 20px; font-weight: bold; color: #083CAE;">Febrero 2026</div>
                            </div>
                        </div>
                    </div>

                    <!-- Último cierre -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 48px; height: 48px; background-color: #e6f2ff; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-history" style="color: #083CAE; font-size: 24px;"></i>
                            </div>
                            <div>
                                <div style="font-size: 13px; color: #6c757d; margin-bottom: 5px;">Último Cierre</div>
                                <div style="font-size: 20px; font-weight: bold; color: #083CAE;">Enero 2026</div>
                            </div>
                        </div>
                    </div>

                    <!-- Estado del período -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 48px; height: 48px; background-color: #fff3cd; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-clock" style="color: #856404; font-size: 24px;"></i>
                            </div>
                            <div>
                                <div style="font-size: 13px; color: #6c757d; margin-bottom: 5px;">Estado</div>
                                <div style="font-size: 20px; font-weight: bold; color: #856404;">Pendiente</div>
                            </div>
                        </div>
                    </div>

                    <!-- Movimientos sin contabilizar -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 48px; height: 48px; background-color: #f8d7da; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-exclamation-circle" style="color: #721c24; font-size: 24px;"></i>
                            </div>
                            <div>
                                <div style="font-size: 13px; color: #6c757d; margin-bottom: 5px;">Pendientes</div>
                                <div style="font-size: 20px; font-weight: bold; color: #721c24;">23 movimientos</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lista de verificación pre-cierre -->
                <div style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden; margin-bottom: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <div style="background-color: #6B8ACE; padding: 15px 20px; color: white; font-weight: 700; border-bottom: 2px solid #083CAE;">
                        <i class="fas fa-check-circle mr-2"></i> Lista de Verificación Pre-Cierre
                    </div>
                    <div style="padding: 20px;">
                        <!-- Item 1 -->
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #dee2e6;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <i class="fas fa-check-circle" style="color: #28a745; font-size: 18px;"></i>
                                <span style="font-weight: 500;">Bancos conciliados</span>
                            </div>
                            <span style="font-size: 13px; color: #28a745; background-color: #d4edda; padding: 4px 10px; border-radius: 20px;">Completado</span>
                        </div>

                        <!-- Item 2 -->
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #dee2e6;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <i class="fas fa-check-circle" style="color: #28a745; font-size: 18px;"></i>
                                <span style="font-weight: 500;">Facturas emitidas registradas</span>
                            </div>
                            <span style="font-size: 13px; color: #28a745; background-color: #d4edda; padding: 4px 10px; border-radius: 20px;">Completado</span>
                        </div>

                        <!-- Item 3 -->
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #dee2e6;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <i class="fas fa-check-circle" style="color: #28a745; font-size: 18px;"></i>
                                <span style="font-weight: 500;">Facturas recibidas registradas</span>
                            </div>
                            <span style="font-size: 13px; color: #28a745; background-color: #d4edda; padding: 4px 10px; border-radius: 20px;">Completado</span>
                        </div>

                        <!-- Item 4 -->
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #dee2e6;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <i class="fas fa-exclamation-triangle" style="color: #ffc107; font-size: 18px;"></i>
                                <span style="font-weight: 500;">Nómina procesada</span>
                            </div>
                            <span style="font-size: 13px; color: #856404; background-color: #fff3cd; padding: 4px 10px; border-radius: 20px;">En proceso</span>
                        </div>

                        <!-- Item 5 -->
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #dee2e6;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <i class="fas fa-times-circle" style="color: #dc3545; font-size: 18px;"></i>
                                <span style="font-weight: 500;">Depreciaciones calculadas</span>
                            </div>
                            <span style="font-size: 13px; color: #dc3545; background-color: #f8d7da; padding: 4px 10px; border-radius: 20px;">Pendiente</span>
                        </div>

                        <!-- Item 6 -->
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #dee2e6;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <i class="fas fa-times-circle" style="color: #dc3545; font-size: 18px;"></i>
                                <span style="font-weight: 500;">Pólizas de diario registradas</span>
                            </div>
                            <span style="font-size: 13px; color: #dc3545; background-color: #f8d7da; padding: 4px 10px; border-radius: 20px;">Pendiente</span>
                        </div>

                        <!-- Item 7 -->
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 0;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <i class="fas fa-check-circle" style="color: #28a745; font-size: 18px;"></i>
                                <span style="font-weight: 500;">Inventarios actualizados</span>
                            </div>
                            <span style="font-size: 13px; color: #28a745; background-color: #d4edda; padding: 4px 10px; border-radius: 20px;">Completado</span>
                        </div>
                    </div>
                </div>

                <!-- Tabla de movimientos pendientes -->
                <div style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <!-- Encabezados de tabla -->
                    <div style="display: grid; grid-template-columns: 1fr 1.5fr 1fr 1fr 1fr 1fr; background-color: #6B8ACE; padding: 15px 20px; font-weight: 700; color: white; border-bottom: 2px solid #083CAE;">
                        <div>Fecha</div>
                        <div>Concepto</div>
                        <div>Tipo</div>
                        <div style="text-align: right;">Cargo</div>
                        <div style="text-align: right;">Abono</div>
                        <div style="text-align: center;">Estado</div>
                    </div>

                    <!-- Cuerpo de la tabla con datos -->
                    <div style="padding: 5px 0;">
                        <!-- Fila 1 -->
                        <div style="display: grid; grid-template-columns: 1fr 1.5fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: #ffffff;">
                            <div>2026-02-28</div>
                            <div>Pago a proveedor - Materiales</div>
                            <div>Egreso</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$15,230.50</div>
                            <div style="text-align: center;">
                                <span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Pendiente</span>
                            </div>
                        </div>

                        <!-- Fila 2 -->
                        <div style="display: grid; grid-template-columns: 1fr 1.5fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: #f8f9fa;">
                            <div>2026-02-27</div>
                            <div>Factura de venta - Cliente A</div>
                            <div>Ingreso</div>
                            <div style="text-align: right; font-family: monospace;">$45,000.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: center;">
                                <span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Pendiente</span>
                            </div>
                        </div>

                        <!-- Fila 3 -->
                        <div style="display: grid; grid-template-columns: 1fr 1.5fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: #ffffff;">
                            <div>2026-02-26</div>
                            <div>Gastos de operación</div>
                            <div>Egreso</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$8,750.00</div>
                            <div style="text-align: center;">
                                <span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Pendiente</span>
                            </div>
                        </div>

                        <!-- Fila 4 -->
                        <div style="display: grid; grid-template-columns: 1fr 1.5fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: #f8f9fa;">
                            <div>2026-02-25</div>
                            <div>Pago de nómina</div>
                            <div>Egreso</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$22,630.00</div>
                            <div style="text-align: center;">
                                <span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Crítico</span>
                            </div>
                        </div>

                        <!-- Fila 5 -->
                        <div style="display: grid; grid-template-columns: 1fr 1.5fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: #ffffff;">
                            <div>2026-02-24</div>
                            <div>Pago a subcontratista</div>
                            <div>Egreso</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$12,500.00</div>
                            <div style="text-align: center;">
                                <span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Pendiente</span>
                            </div>
                        </div>

                        <!-- Fila 6 -->
                        <div style="display: grid; grid-template-columns: 1fr 1.5fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: #f8f9fa;">
                            <div>2026-02-23</div>
                            <div>Depreciación de equipo</div>
                            <div>Póliza</div>
                            <div style="text-align: right; font-family: monospace;">$5,600.00</div>
                            <div style="text-align: right; font-family: monospace;">$5,600.00</div>
                            <div style="text-align: center;">
                                <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Completado</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información adicional y botón de confirmación -->
                <div style="margin-top: 25px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; background-color: #f8f9fa; padding: 15px; border-radius: 8px; border: 1px solid #dee2e6;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <i class="fas fa-info-circle" style="color: #083CAE; font-size: 20px;"></i>
                        <span style="font-size: 13px; color: #495057;">Una vez cerrado el mes, no podrás modificar movimientos de este período</span>
                    </div>
                    <div style="display: flex; gap: 15px;">
                        <button id="btnValidar" style="background-color: #6c757d; color: white; border: none; border-radius: 8px; padding: 10px 25px; font-size: 14px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-check"></i> Validar
                        </button>
                        <button id="btnCierreConfirmar" style="background-color: #083CAE; color: white; border: none; border-radius: 8px; padding: 10px 25px; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-lock"></i> Confirmar Cierre
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

    /* Estilo para los encabezados de tabla */
    [style*="background-color: #6B8ACE"] {
        transition: background-color 0.2s ease;
        letter-spacing: 0.3px;
    }

    /* Estilo para filas alternadas */
    [style*="background-color: #f8f9fa"] {
        transition: background-color 0.2s ease;
    }

    [style*="background-color: #ffffff"]:hover,
    [style*="background-color: #f8f9fa"]:hover {
        background-color: #e3f2fd !important;
        cursor: default;
    }

    /* Estilo para el botón de cierre */
    #btnCierre {
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(44, 191, 31, 0.2);
    }

    #btnCierre:hover {
        background-color: #249e1a !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(44, 191, 31, 0.3);
    }

    #btnCierre:active {
        transform: translateY(0);
    }

    /* Estilo para selects */
    select {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    select:hover {
        border-color: #2CBF1F !important;
    }

    select:focus {
        outline: none;
        border-color: #083CAE;
        box-shadow: 0 0 0 2px rgba(8, 60, 174, 0.2);
    }

    /* Estilo para números en monospace */
    [style*="font-family: monospace"] {
        font-size: 13px;
    }

    /* Estilo para tarjetas */
    [style*="grid-template-columns: repeat(4, 1fr)"] > div {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    [style*="grid-template-columns: repeat(4, 1fr)"] > div:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
    }

    /* Estilo para badges de estado */
    [style*="border-radius: 20px"] {
        font-size: 12px;
        font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 768px) {
        [style*="grid-template-columns: 1fr 1.5fr 1fr 1fr 1fr 1fr"] {
            grid-template-columns: 1fr !important;
            gap: 10px;
        }
        
        [style*="grid-template-columns: repeat(4, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
        
        [style*="display: flex; justify-content: flex-end"] {
            flex-direction: column;
            align-items: stretch !important;
        }
        
        .semaforo .card-header h2 {
            font-size: 18px !important;
        }
        
        [style*="padding: 12px 20px"] {
            padding: 10px !important;
        }
        
        /* Ajustar el filtro en móvil */
        [style*="display: flex; gap: 15px; align-items: center"] {
            width: 100%;
            justify-content: space-between;
        }
        
        [style*="display: flex; border: 1px solid #083CAE; border-radius: 8px; overflow: hidden"] {
            flex: 1;
        }
        
        #btnCierre {
            width: 100%;
            justify-content: center;
        }
        
        [style*="margin-top: 25px; display: flex; justify-content: space-between"] {
            flex-direction: column;
            align-items: flex-start !important;
        }
        
        [style*="display: flex; gap: 15px"] {
            width: 100%;
        }
        
        #btnValidar, #btnCierreConfirmar {
            flex: 1;
            justify-content: center;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnCierre = document.getElementById('btnCierre');
        const btnValidar = document.getElementById('btnValidar');
        const btnCierreConfirmar = document.getElementById('btnCierreConfirmar');
        const mes = document.getElementById('mes');
        const anio = document.getElementById('anio');

        // Evento para el botón de cierre
        btnCierre.addEventListener('click', function() {
            const mesSel = mes.options[mes.selectedIndex].text;
            const anioSel = anio.value;
            
            // Simular proceso de cierre
            if (confirm(`¿Estás seguro de que deseas ejecutar el cierre para ${mesSel} ${anioSel}? Esta acción no se puede deshacer.`)) {
                alert(`Procesando cierre de mes para ${mesSel} ${anioSel}...`);
                
                // Aquí iría la lógica de cierre
                setTimeout(() => {
                    alert('Cierre de mes completado exitosamente');
                }, 2000);
            }
            
            // Feedback visual
            btnCierre.style.transform = 'scale(0.95)';
            setTimeout(() => {
                btnCierre.style.transform = 'scale(1)';
            }, 200);
        });

        // Evento para el botón de validar
        btnValidar.addEventListener('click', function() {
            const mesSel = mes.options[mes.selectedIndex].text;
            const anioSel = anio.value;
            
            alert(`Validando movimientos para ${mesSel} ${anioSel}...`);
            
            // Feedback visual
            btnValidar.style.transform = 'scale(0.95)';
            setTimeout(() => {
                btnValidar.style.transform = 'scale(1)';
            }, 200);
        });

        // Evento para el botón de confirmar cierre
        btnCierreConfirmar.addEventListener('click', function() {
            const mesSel = mes.options[mes.selectedIndex].text;
            const anioSel = anio.value;
            
            if (confirm(`¿CONFIRMAS EL CIERRE DEFINITIVO para ${mesSel} ${anioSel}? Esta acción bloqueará todas las modificaciones del período.`)) {
                alert(`Cerrando definitivamente el mes ${mesSel} ${anioSel}...`);
            }
            
            // Feedback visual
            btnCierreConfirmar.style.transform = 'scale(0.95)';
            setTimeout(() => {
                btnCierreConfirmar.style.transform = 'scale(1)';
            }, 200);
        });

        // Evento para cambio de período (simulado)
        [mes, anio].forEach(select => {
            select.addEventListener('change', function() {
                const mesSel = mes.options[mes.selectedIndex].text;
                const anioSel = anio.value;
                console.log(`Cambiando a período: ${mesSel} ${anioSel}`);
                
                // Aquí se podría actualizar la tabla con datos del nuevo período
                // Por ahora solo mostramos un mensaje en consola
            });
        });

        // Formato de moneda (opcional)
        function formatCurrency(value) {
            return '$' + value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
    });
</script>
@endsection