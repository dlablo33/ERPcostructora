@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Retenciones - ISR e IVA -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Retenciones - ISR e IVA
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Filtro mensual y botón de descarga -->
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 30px; gap: 15px; flex-wrap: wrap;">
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
                        <button id="btnConsultar" style="background-color: #083CAE; color: white; border: none; border-radius: 8px; padding: 10px 20px; font-size: 14px; font-weight: 600; cursor: pointer;">
                            <i class="fas fa-search"></i> Consultar
                        </button>
                        <a href="{{ route('conta.retenciones') }}" style="background-color: #6c757d; color: white; border: none; border-radius: 8px; padding: 10px 20px; font-size: 14px; font-weight: 600; text-decoration: none;">
                            <i class="fas fa-undo"></i> Limpiar
                        </a>
                        <a href="#" id="btnDescargar" style="background-color: #2CBF1F; color: white; border: none; border-radius: 8px; padding: 12px 30px; font-size: 14px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
                            <i class="fas fa-download"></i> Descargar Reporte
                        </a>
                    </div>
                </div>

                <!-- Tarjetas de resumen -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 48px; height: 48px; background-color: #e6f2ff; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-percent" style="color: #083CAE; font-size: 24px;"></i>
                            </div>
                            <div>
                                <div style="font-size: 13px; color: #6c757d; margin-bottom: 5px;">Total ISR Retenido</div>
                                <div style="font-size: 20px; font-weight: bold; color: #083CAE;" id="totalIsr">$0.00</div>
                            </div>
                        </div>
                    </div>

                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 48px; height: 48px; background-color: #e6f2ff; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-chart-line" style="color: #083CAE; font-size: 24px;"></i>
                            </div>
                            <div>
                                <div style="font-size: 13px; color: #6c757d; margin-bottom: 5px;">Total IVA Retenido</div>
                                <div style="font-size: 20px; font-weight: bold; color: #083CAE;" id="totalIva">$0.00</div>
                            </div>
                        </div>
                    </div>

                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 48px; height: 48px; background-color: #fff3cd; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-users" style="color: #856404; font-size: 24px;"></i>
                            </div>
                            <div>
                                <div style="font-size: 13px; color: #6c757d; margin-bottom: 5px;">Proveedores</div>
                                <div style="font-size: 20px; font-weight: bold; color: #856404;" id="totalProveedores">0</div>
                            </div>
                        </div>
                    </div>

                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 48px; height: 48px; background-color: #d4edda; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-file-invoice" style="color: #155724; font-size: 24px;"></i>
                            </div>
                            <div>
                                <div style="font-size: 13px; color: #6c757d; margin-bottom: 5px;">Total Operaciones</div>
                                <div style="font-size: 20px; font-weight: bold; color: #155724;" id="totalOperaciones">0</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loading spinner -->
                <div id="loadingSpinner" style="display: none; text-align: center; padding: 40px;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #083CAE;"></i>
                    <p style="margin-top: 15px; color: #6c757d;">Cargando datos...</p>
                </div>

                <!-- Pestañas -->
                <div style="border-bottom: 2px solid #dee2e6; margin-bottom: 20px; display: flex; gap: 5px;">
                    <button class="tab-button active" data-tab="isr" style="background-color: #083CAE; color: white; border: none; padding: 10px 25px; font-size: 14px; font-weight: 600; border-radius: 8px 8px 0 0; cursor: pointer;">
                        <i class="fas fa-percent" style="margin-right: 8px;"></i> Retenciones ISR
                    </button>
                    <button class="tab-button" data-tab="iva" style="background-color: #e9ecef; color: #495057; border: none; padding: 10px 25px; font-size: 14px; font-weight: 600; border-radius: 8px 8px 0 0; cursor: pointer;">
                        <i class="fas fa-chart-line" style="margin-right: 8px;"></i> Retenciones IVA
                    </button>
                    <button class="tab-button" data-tab="resumen" style="background-color: #e9ecef; color: #495057; border: none; padding: 10px 25px; font-size: 14px; font-weight: 600; border-radius: 8px 8px 0 0; cursor: pointer;">
                        <i class="fas fa-clipboard-list" style="margin-right: 8px;"></i> Resumen
                    </button>
                </div>

                <!-- CONTENIDO: Retenciones ISR -->
                <div id="tab-isr" class="tab-content" style="display: block;">
                    <div style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; background-color: #6B8ACE; padding: 15px 20px; font-weight: 700; color: white; border-bottom: 2px solid #083CAE;">
                            <div>Razón Social / RFC</div>
                            <div style="text-align: right;">Subtotal</div>
                            <div style="text-align: right;">Tasa ISR</div>
                            <div style="text-align: right;">ISR Retenido</div>
                            <div style="text-align: center;">Acciones</div>
                        </div>
                        <div id="tablaIsrBody" style="padding: 5px 0;">
                            <div style="text-align: center; padding: 40px; color: #6c757d;">
                                <i class="fas fa-info-circle"></i> Seleccione un período para cargar los datos
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CONTENIDO: Retenciones IVA -->
                <div id="tab-iva" class="tab-content" style="display: none;">
                    <div style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; background-color: #6B8ACE; padding: 15px 20px; font-weight: 700; color: white; border-bottom: 2px solid #083CAE;">
                            <div>Razón Social / RFC</div>
                            <div style="text-align: right;">Subtotal</div>
                            <div style="text-align: right;">Tasa IVA</div>
                            <div style="text-align: right;">IVA Retenido</div>
                            <div style="text-align: center;">Acciones</div>
                        </div>
                        <div id="tablaIvaBody" style="padding: 5px 0;">
                            <div style="text-align: center; padding: 40px; color: #6c757d;">
                                <i class="fas fa-info-circle"></i> Seleccione un período para cargar los datos
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CONTENIDO: Resumen -->
                <div id="tab-resumen" class="tab-content" style="display: none;">
                    <div id="resumenContainer" style="text-align: center; padding: 40px; color: #6c757d;">
                        <i class="fas fa-info-circle"></i> Seleccione un período para cargar los datos
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
    .tab-button {
        transition: all 0.3s ease;
        border: 1px solid #dee2e6;
        border-bottom: none;
        margin-bottom: -2px;
    }
    .tab-button:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }
    .tab-button.active {
        background-color: #083CAE !important;
        color: white !important;
        border-color: #083CAE;
    }
    [style*="grid-template-columns: repeat(4, 1fr)"] > div {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    [style*="grid-template-columns: repeat(4, 1fr)"] > div:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
    }
    .fa-eye:hover, .fa-file-pdf:hover {
        transform: scale(1.2);
        transition: transform 0.2s;
    }
    .fa-eye:hover {
        color: #0056b3 !important;
    }
    .fa-file-pdf:hover {
        color: #b02a37 !important;
    }
    .progress-bar {
        width: 100%;
        height: 8px;
        background-color: #e9ecef;
        border-radius: 4px;
        overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 0.5s ease;
    }
    @media (max-width: 768px) {
        [style*="grid-template-columns: repeat(4, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
        [style*="display: flex; justify-content: flex-end"] {
            flex-direction: column;
            align-items: stretch !important;
        }
        .tab-button {
            flex: 1;
            text-align: center;
            padding: 10px !important;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
// API URLs
const API_URL = '/api/retenciones/data';
const API_EXPORTAR = '/api/retenciones/exportar';

// Elementos DOM
const mesSelect = document.getElementById('mes');
const anioSelect = document.getElementById('anio');
const btnConsultar = document.getElementById('btnConsultar');
const btnDescargar = document.getElementById('btnDescargar');
const loadingSpinner = document.getElementById('loadingSpinner');

// Variables
let datosActuales = null;

// Formatear moneda
function formatCurrency(value) {
    return '$' + parseFloat(value).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

// Cargar datos
async function cargarDatos() {
    const mes = mesSelect.value;
    const anio = anioSelect.value;
    
    loadingSpinner.style.display = 'block';
    
    try {
        const response = await fetch(`${API_URL}?mes=${mes}&anio=${anio}`);
        const result = await response.json();
        
        loadingSpinner.style.display = 'none';
        
        if (result.success) {
            datosActuales = result.data;
            actualizarEstadisticas(result.data.estadisticas);
            renderizarIsr(result.data.retenciones_isr);
            renderizarIva(result.data.retenciones_iva);
            renderizarResumen(result.data.resumen_general);
        } else {
            mostrarToast('Error al cargar datos: ' + result.message, 'error');
        }
    } catch (error) {
        loadingSpinner.style.display = 'none';
        console.error('Error:', error);
        mostrarToast('Error de conexión', 'error');
    }
}

// Actualizar tarjetas de estadísticas
function actualizarEstadisticas(estadisticas) {
    if (!estadisticas) return;
    document.getElementById('totalIsr').textContent = estadisticas.total_isr_formateado || '$0.00';
    document.getElementById('totalIva').textContent = estadisticas.total_iva_formateado || '$0.00';
    document.getElementById('totalProveedores').textContent = estadisticas.total_proveedores || 0;
    document.getElementById('totalOperaciones').textContent = estadisticas.total_operaciones || 0;
}

// Renderizar tabla ISR
function renderizarIsr(retenciones) {
    const container = document.getElementById('tablaIsrBody');
    
    if (!retenciones || retenciones.length === 0) {
        container.innerHTML = '<div style="text-align: center; padding: 40px; color: #6c757d;"><i class="fas fa-info-circle"></i> No hay retenciones de ISR en el período seleccionado</div>';
        return;
    }
    
    let html = '<div style="padding: 5px 0;">';
    let index = 0;
    
    retenciones.forEach(retencion => {
        const bgColor = index % 2 === 0 ? '#ffffff' : '#f8f9fa';
        html += `
            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: ${bgColor};">
                <div>
                    <div style="font-weight: 500;">${escapeHtml(retencion.razon_social || retencion.nombre)}</div>
                    <div style="font-size: 11px; color: #6c757d;">${escapeHtml(retencion.rfc || '-')}</div>
                </div>
                <div style="text-align: right; font-family: monospace;">${formatCurrency(retencion.subtotal)}</div>
                <div style="text-align: right;">10%</div>
                <div style="text-align: right; font-family: monospace; font-weight: 600; color: #083CAE;">${formatCurrency(retencion.isr_retenido)}</div>
                <div style="text-align: center;">
                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver detalle" data-rfc="${retencion.rfc}" data-tipo="isr"></i>
                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;" title="Descargar PDF" data-rfc="${retencion.rfc}" data-tipo="isr"></i>
                </div>
            </div>
        `;
        index++;
    });
    
    html += '</div>';
    container.innerHTML = html;
}

// Renderizar tabla IVA
function renderizarIva(retenciones) {
    const container = document.getElementById('tablaIvaBody');
    
    if (!retenciones || retenciones.length === 0) {
        container.innerHTML = '<div style="text-align: center; padding: 40px; color: #6c757d;"><i class="fas fa-info-circle"></i> No hay retenciones de IVA en el período seleccionado</div>';
        return;
    }
    
    let html = '<div style="padding: 5px 0;">';
    let index = 0;
    
    retenciones.forEach(retencion => {
        const bgColor = index % 2 === 0 ? '#ffffff' : '#f8f9fa';
        html += `
            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: ${bgColor};">
                <div>
                    <div style="font-weight: 500;">${escapeHtml(retencion.razon_social || retencion.nombre)}</div>
                    <div style="font-size: 11px; color: #6c757d;">${escapeHtml(retencion.rfc || '-')}</div>
                </div>
                <div style="text-align: right; font-family: monospace;">${formatCurrency(retencion.subtotal)}</div>
                <div style="text-align: right;">${retencion.tasa_formateada || '16%'}</div>
                <div style="text-align: right; font-family: monospace; font-weight: 600; color: #083CAE;">${formatCurrency(retencion.iva_retenido)}</div>
                <div style="text-align: center;">
                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver detalle" data-rfc="${retencion.rfc}" data-tipo="iva"></i>
                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;" title="Descargar PDF" data-rfc="${retencion.rfc}" data-tipo="iva"></i>
                </div>
            </div>
        `;
        index++;
    });
    
    html += '</div>';
    container.innerHTML = html;
}

// Renderizar resumen
function renderizarResumen(resumen) {
    const container = document.getElementById('resumenContainer');
    
    if (!resumen) {
        container.innerHTML = '<div style="text-align: center; padding: 40px; color: #6c757d;"><i class="fas fa-info-circle"></i> No hay datos para el período seleccionado</div>';
        return;
    }
    
    // Calcular porcentajes para gráficos
    const totalIsr = resumen.total_isr || 0;
    const totalIva = resumen.total_iva || 0;
    const totalGeneral = totalIsr + totalIva;
    
    let isrHtml = '';
    let ivaHtml = '';
    let resumenTablaHtml = '';
    
    // ISR por concepto
    if (resumen.isr_por_concepto && resumen.isr_por_concepto.length > 0) {
        resumen.isr_por_concepto.forEach(item => {
            const porcentaje = totalIsr > 0 ? (item.retencion / totalIsr * 100).toFixed(1) : 0;
            isrHtml += `
                <div style="margin-bottom: 10px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span style="font-size: 13px;">${escapeHtml(item.concepto)}</span>
                        <span style="font-size: 13px; font-weight: 600;">${formatCurrency(item.retencion)}</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: ${porcentaje}%; background-color: #083CAE;"></div>
                    </div>
                </div>
            `;
        });
    }
    
    // IVA por tasa
    if (resumen.iva_por_tasa && resumen.iva_por_tasa.length > 0) {
        resumen.iva_por_tasa.forEach(item => {
            const porcentaje = totalIva > 0 ? (item.retencion / totalIva * 100).toFixed(1) : 0;
            ivaHtml += `
                <div style="margin-bottom: 10px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span style="font-size: 13px;">IVA ${item.tasa || 16}%</span>
                        <span style="font-size: 13px; font-weight: 600;">${formatCurrency(item.retencion)}</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: ${porcentaje}%; background-color: #28a745;"></div>
                    </div>
                </div>
            `;
        });
    }
    
    // Resumen de conceptos
    resumenTablaHtml = `
        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; background-color: #6B8ACE; padding: 15px 20px; font-weight: 700; color: white; border-bottom: 2px solid #083CAE;">
            <div>Concepto</div>
            <div style="text-align: right;">Base</div>
            <div style="text-align: right;">Tasa</div>
            <div style="text-align: right;">Retención</div>
            <div style="text-align: right;">% del Total</div>
        </div>
        <div style="padding: 5px 0;">
    `;
    
    if (resumen.isr_por_concepto) {
        resumen.isr_por_concepto.forEach((item, idx) => {
            const bgColor = idx % 2 === 0 ? '#ffffff' : '#f8f9fa';
            const porcentaje = totalGeneral > 0 ? (item.retencion / totalGeneral * 100).toFixed(1) : 0;
            resumenTablaHtml += `
                <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; background-color: ${bgColor};">
                    <div style="font-weight: 500;">ISR - ${escapeHtml(item.concepto)}</div>
                    <div style="text-align: right; font-family: monospace;">${formatCurrency(item.base)}</div>
                    <div style="text-align: right;">10%</div>
                    <div style="text-align: right; font-family: monospace; font-weight: 600;">${formatCurrency(item.retencion)}</div>
                    <div style="text-align: right;">${porcentaje}%</div>
                </div>
            `;
        });
    }
    
    if (resumen.iva_por_tasa) {
        resumen.iva_por_tasa.forEach((item, idx) => {
            const bgColor = (resumen.isr_por_concepto?.length + idx) % 2 === 0 ? '#ffffff' : '#f8f9fa';
            const porcentaje = totalGeneral > 0 ? (item.retencion / totalGeneral * 100).toFixed(1) : 0;
            resumenTablaHtml += `
                <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; background-color: ${bgColor};">
                    <div style="font-weight: 500;">IVA - Tasa ${item.tasa || 16}%</div>
                    <div style="text-align: right; font-family: monospace;">${formatCurrency(item.base)}</div>
                    <div style="text-align: right;">${item.tasa || 16}%</div>
                    <div style="text-align: right; font-family: monospace; font-weight: 600;">${formatCurrency(item.retencion)}</div>
                    <div style="text-align: right;">${porcentaje}%</div>
                </div>
            `;
        });
    }
    
    resumenTablaHtml += `
            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; padding: 12px 20px; background-color: #e9ecef; font-weight: 700;">
                <div style="color: #083CAE;">TOTALES</div>
                <div style="text-align: right; font-family: monospace;">${resumen.total_base_formateado || '$0.00'}</div>
                <div style="text-align: right;"></div>
                <div style="text-align: right; font-family: monospace;">${resumen.total_retencion_formateado || '$0.00'}</div>
                <div style="text-align: right;">100%</div>
            </div>
        </div>
    `;
    
    container.innerHTML = `
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div style="border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; background-color: white;">
                <h4 style="color: #083CAE; font-size: 16px; font-weight: 600; margin-bottom: 15px;">
                    <i class="fas fa-percent" style="margin-right: 8px;"></i> Distribución ISR por Concepto
                </h4>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    ${isrHtml || '<p>No hay datos de ISR</p>'}
                </div>
            </div>
            <div style="border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; background-color: white;">
                <h4 style="color: #083CAE; font-size: 16px; font-weight: 600; margin-bottom: 15px;">
                    <i class="fas fa-chart-line" style="margin-right: 8px;"></i> Distribución IVA por Tasa
                </h4>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    ${ivaHtml || '<p>No hay datos de IVA</p>'}
                </div>
            </div>
        </div>
        <div style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden;">
            ${resumenTablaHtml}
        </div>
    `;
}

// Descargar reporte
function descargarReporte() {
    const mes = mesSelect.value;
    const anio = anioSelect.value;
    const url = `${API_EXPORTAR}?mes=${mes}&anio=${anio}`;
    window.open(url, '_blank');
    mostrarToast('Descargando reporte...', 'success');
}

// Mostrar toast
function mostrarToast(msg, tipo = 'success') {
    const container = document.getElementById('toastContainer') || (() => {
        const div = document.createElement('div');
        div.id = 'toastContainer';
        div.style.cssText = 'position:fixed; bottom:20px; right:20px; z-index:9999; display:flex; flex-direction:column; gap:10px;';
        document.body.appendChild(div);
        return div;
    })();
    const toast = document.createElement('div');
    toast.className = `toast ${tipo}`;
    toast.style.cssText = `background:#1A1D23; color:white; padding:12px 20px; border-radius:8px; font-size:13px; display:flex; align-items:center; gap:12px; min-width:300px; box-shadow:0 8px 24px rgba(0,0,0,0.2); animation:slideInRight 0.3s ease; border-left:4px solid ${tipo === 'success' ? '#28a745' : '#dc3545'};`;
    const icon = tipo === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
    toast.innerHTML = `<i class="fas ${icon}"></i> ${msg}`;
    container.appendChild(toast);
    setTimeout(() => {
        toast.style.animation = 'slideInRight 0.3s reverse';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Escapar HTML
function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

// Manejo de pestañas
function showTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(content => {
        content.style.display = 'none';
    });
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active');
        button.style.backgroundColor = '#e9ecef';
        button.style.color = '#495057';
    });
    document.getElementById(`tab-${tabId}`).style.display = 'block';
    const activeButton = document.querySelector(`[data-tab="${tabId}"]`);
    activeButton.classList.add('active');
    activeButton.style.backgroundColor = '#083CAE';
    activeButton.style.color = 'white';
}

// Eventos
document.addEventListener('DOMContentLoaded', function() {
    // Eventos de pestañas
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', function() {
            showTab(this.dataset.tab);
        });
    });
    
    // Eventos de botones
    btnConsultar.addEventListener('click', cargarDatos);
    btnDescargar.addEventListener('click', descargarReporte);
    
    // Cargar datos iniciales
    cargarDatos();
    
    // Eventos delegados para iconos
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('fa-eye')) {
            const rfc = e.target.dataset.rfc;
            const tipo = e.target.dataset.tipo;
            mostrarToast(`Ver detalle de retención ${tipo.toUpperCase()} para RFC: ${rfc}`, 'info');
        } else if (e.target.classList.contains('fa-file-pdf')) {
            const rfc = e.target.dataset.rfc;
            const tipo = e.target.dataset.tipo;
            mostrarToast(`Descargando PDF de retención ${tipo.toUpperCase()} para RFC: ${rfc}`, 'success');
        }
    });
});

// Estilos adicionales
const style = document.createElement('style');
style.textContent = `
    .toast-container { position: fixed; bottom: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; }
    @keyframes slideInRight { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    .progress-bar { width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px; overflow: hidden; }
    .progress-fill { height: 100%; border-radius: 4px; transition: width 0.5s ease; }
`;
document.head.appendChild(style);
</script>
@endsection