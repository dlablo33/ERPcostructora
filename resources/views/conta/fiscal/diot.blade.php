@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- DIOT - Declaración Informativa de Operaciones con Terceros -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    DIOT
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Filtro mensual y botón de descarga - TODO A LA DERECHA -->
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 30px; gap: 15px; flex-wrap: wrap;">
                    <!-- Filtro de mes y año -->
                    <div style="display: flex; gap: 15px; align-items: center;">
                        <div style="font-weight: 600; color: #083CAE; font-size: 15px;">Período:</div>
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

                    <!-- Botón de descarga verde -->
                    <button id="btnDescargar" style="background-color: #2CBF1F; color: white; border: none; border-radius: 8px; padding: 12px 30px; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-download"></i> Descargar .txt
                    </button>
                </div>

                <!-- Tabla DIOT -->
                <div style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <!-- Encabezados de tabla -->
                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr; background-color: #6B8ACE; padding: 15px 20px; font-weight: 700; color: white; border-bottom: 2px solid #083CAE;">
                        <div>Razón Social</div>
                        <div>Proveedor</div>
                        <div>Categoría</div>
                        <div style="text-align: right;">Subtotal</div>
                        <div style="text-align: right;">IVA 16%</div>
                        <div style="text-align: right;">IVA 8%</div>
                        <div style="text-align: right;">IVA 0%</div>
                        <div style="text-align: right;">IVA Exento</div>
                    </div>

                    <!-- Cuerpo de la tabla con datos -->
                    <div style="padding: 5px 0;">
                        <!-- Fila 1 -->
                        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: #ffffff;">
                            <div style="font-weight: 500;">Constructora del Norte S.A. de C.V.</div>
                            <div>PROV-001</div>
                            <div>Materiales</div>
                            <div style="text-align: right; font-family: monospace;">$45,230.50</div>
                            <div style="text-align: right; font-family: monospace;">$7,236.88</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                        </div>

                        <!-- Fila 2 -->
                        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: #f8f9fa;">
                            <div style="font-weight: 500;">Servicios Integrales de Logística</div>
                            <div>PROV-002</div>
                            <div>Servicios</div>
                            <div style="text-align: right; font-family: monospace;">$18,500.00</div>
                            <div style="text-align: right; font-family: monospace;">$2,960.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                        </div>

                        <!-- Fila 3 -->
                        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: #ffffff;">
                            <div style="font-weight: 500;">Proveedora de Materiales y Equipos</div>
                            <div>PROV-003</div>
                            <div>Equipos</div>
                            <div style="text-align: right; font-family: monospace;">$32,150.75</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$2,572.06</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                        </div>

                        <!-- Fila 4 -->
                        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: #f8f9fa;">
                            <div style="font-weight: 500;">Consultoría y Asesoría Empresarial</div>
                            <div>PROV-004</div>
                            <div>Honorarios</div>
                            <div style="text-align: right; font-family: monospace;">$12,000.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$12,000.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                        </div>

                        <!-- Fila 5 -->
                        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: #ffffff;">
                            <div style="font-weight: 500;">Comercializadora Internacional</div>
                            <div>PROV-005</div>
                            <div>Importaciones</div>
                            <div style="text-align: right; font-family: monospace;">$87,450.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$87,450.00</div>
                        </div>

                        <!-- Fila 6 -->
                        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: #f8f9fa;">
                            <div style="font-weight: 500;">Servicios de Transporte y Carga</div>
                            <div>PROV-006</div>
                            <div>Transporte</div>
                            <div style="text-align: right; font-family: monospace;">$23,800.00</div>
                            <div style="text-align: right; font-family: monospace;">$3,808.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                        </div>

                        <!-- Fila 7 -->
                        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: #ffffff;">
                            <div style="font-weight: 500;">Proveedora de Alimentos y Bebidas</div>
                            <div>PROV-007</div>
                            <div>Insumos</div>
                            <div style="text-align: right; font-family: monospace;">$9,850.25</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$788.02</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                        </div>

                        <!-- Fila 8 -->
                        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: #f8f9fa;">
                            <div style="font-weight: 500;">Arrendadora de Maquinaria Pesada</div>
                            <div>PROV-008</div>
                            <div>Rentas</div>
                            <div style="text-align: right; font-family: monospace;">$42,000.00</div>
                            <div style="text-align: right; font-family: monospace;">$6,720.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                        </div>

                        <!-- Fila 9 -->
                        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: #ffffff;">
                            <div style="font-weight: 500;">Servicios de Limpieza Industrial</div>
                            <div>PROV-009</div>
                            <div>Servicios</div>
                            <div style="text-align: right; font-family: monospace;">$5,600.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$5,600.00</div>
                        </div>

                        <!-- Fila 10 -->
                        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: #f8f9fa;">
                            <div style="font-weight: 500;">Distribuidora de Material Eléctrico</div>
                            <div>PROV-010</div>
                            <div>Materiales</div>
                            <div style="text-align: right; font-family: monospace;">$28,450.00</div>
                            <div style="text-align: right; font-family: monospace;">$4,552.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                            <div style="text-align: right; font-family: monospace;">$0.00</div>
                        </div>
                    </div>

                    <!-- Pie de tabla con totales -->
                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr; background-color: #e9ecef; padding: 15px 20px; font-weight: 700; color: #083CAE; border-top: 2px solid #083CAE;">
                        <div style="font-size: 14px;">TOTALES</div>
                        <div></div>
                        <div></div>
                        <div style="text-align: right; font-family: monospace;">$305,031.50</div>
                        <div style="text-align: right; font-family: monospace;">$25,276.88</div>
                        <div style="text-align: right; font-family: monospace;">$3,360.08</div>
                        <div style="text-align: right; font-family: monospace;">$12,000.00</div>
                        <div style="text-align: right; font-family: monospace;">$93,050.00</div>
                    </div>
                </div>

                <!-- Información adicional -->
                
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

    /* Estilo para el botón de descarga */
    #btnDescargar {
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(44, 191, 31, 0.2);
    }

    #btnDescargar:hover {
        background-color: #249e1a !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(44, 191, 31, 0.3);
    }

    #btnDescargar:active {
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

    /* Responsive */
    @media (max-width: 768px) {
        [style*="grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr"] {
            grid-template-columns: 1fr !important;
            gap: 10px;
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
        
        #btnDescargar {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnDescargar = document.getElementById('btnDescargar');
        const mes = document.getElementById('mes');
        const anio = document.getElementById('anio');

        // Evento para el botón de descarga
        btnDescargar.addEventListener('click', function() {
            const mesSel = mes.options[mes.selectedIndex].text;
            const anioSel = anio.value;
            
            // Simular descarga
            alert(`Descargando archivo DIOT para ${mesSel} ${anioSel}...`);
            
            // Crear contenido de ejemplo para el archivo .txt
            const contenido = `DIOT - Declaración Informativa de Operaciones con Terceros\n`;
            const contenido2 = `Período: ${mesSel} ${anioSel}\n`;
            const contenido3 = `Generado: ${new Date().toLocaleString()}\n`;
            const contenido4 = `Total de registros: 10\n`;
            
            console.log('Archivo .txt generado:', contenido + contenido2 + contenido3 + contenido4);
            
            // Feedback visual
            btnDescargar.style.transform = 'scale(0.95)';
            setTimeout(() => {
                btnDescargar.style.transform = 'scale(1)';
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

        // Formato de moneda (opcional, para valores simulados)
        function formatCurrency(value) {
            return '$' + value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
    });
</script>
@endsection