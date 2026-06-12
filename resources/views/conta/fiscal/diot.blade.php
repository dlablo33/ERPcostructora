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

                <!-- Loading spinner -->
                <div id="loadingSpinner" style="display: none; text-align: center; padding: 40px;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #083CAE;"></i>
                    <p style="margin-top: 15px; color: #6c757d;">Cargando datos...</p>
                </div>

                <!-- Tabla DIOT -->
                <div id="tablaContainer" style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <!-- Encabezados de tabla -->
                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr; background-color: #6B8ACE; padding: 15px 20px; font-weight: 700; color: white; border-bottom: 2px solid #083CAE;">
                        <div>Razón Social</div>
                        <div>RFC</div>
                        <div style="text-align: right;">Subtotal</div>
                        <div style="text-align: right;">IVA 16%</div>
                        <div style="text-align: right;">IVA 8%</div>
                        <div style="text-align: right;">IVA 0%</div>
                        <div style="text-align: right;">IVA Exento</div>
                        <div style="text-align: right;">Total</div>
                    </div>

                    <!-- Cuerpo de la tabla -->
                    <div id="tablaBody" style="padding: 5px 0;">
                        <div style="text-align: center; padding: 40px; color: #6c757d;">
                            <i class="fas fa-info-circle"></i> Selecciona un período para cargar los datos
                        </div>
                    </div>

                    <!-- Pie de tabla con totales -->
                    <div id="tablaFooter" style="display: none; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr; background-color: #e9ecef; padding: 15px 20px; font-weight: 700; color: #083CAE; border-top: 2px solid #083CAE;">
                        <div style="font-size: 14px;">TOTALES</div>
                        <div></div>
                        <div id="totalSubtotal" style="text-align: right; font-family: monospace;">$0.00</div>
                        <div id="totalIva16" style="text-align: right; font-family: monospace;">$0.00</div>
                        <div id="totalIva8" style="text-align: right; font-family: monospace;">$0.00</div>
                        <div id="totalIva0" style="text-align: right; font-family: monospace;">$0.00</div>
                        <div id="totalIvaExento" style="text-align: right; font-family: monospace;">$0.00</div>
                        <div id="totalGeneral" style="text-align: right; font-family: monospace;">$0.00</div>
                    </div>
                </div>

                <!-- Sin datos -->
                <div id="sinDatosMensaje" style="display: none; text-align: center; padding: 40px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin-top: 20px;">
                    <i class="fas fa-folder-open" style="font-size: 48px; color: #ced4da;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin-top: 15px;">Sin datos</h3>
                    <p style="color: #adb5bd;">No hay operaciones con proveedores en el período seleccionado</p>
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
    .fila-operacion:nth-child(even) {
        background-color: #f8f9fa;
    }

    .fila-operacion:nth-child(odd) {
        background-color: #ffffff;
    }

    .fila-operacion:hover {
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

    /* Estilo para números */
    .mono {
        font-family: 'SFMono-Regular', Consolas, monospace;
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
// API URLs
const API_URL = '/api/diot/data';
const API_DESCARGAR = '/api/diot/descargar';

// Elementos del DOM
const mesSelect = document.getElementById('mes');
const anioSelect = document.getElementById('anio');
const btnDescargar = document.getElementById('btnDescargar');
const loadingSpinner = document.getElementById('loadingSpinner');
const tablaContainer = document.getElementById('tablaContainer');
const tablaBody = document.getElementById('tablaBody');
const tablaFooter = document.getElementById('tablaFooter');
const sinDatosMensaje = document.getElementById('sinDatosMensaje');

// Variables
let datosActuales = [];

// Formatear moneda
function formatCurrency(value) {
    return '$' + parseFloat(value).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

// Formatear número
function formatNumber(value) {
    return parseFloat(value).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

// Cargar datos
async function cargarDatos() {
    const mes = mesSelect.value;
    const anio = anioSelect.value;
    
    // Mostrar loading
    loadingSpinner.style.display = 'block';
    tablaBody.innerHTML = '';
    tablaFooter.style.display = 'none';
    sinDatosMensaje.style.display = 'none';
    
    try {
        const response = await fetch(`${API_URL}?mes=${mes}&anio=${anio}`);
        const result = await response.json();
        
        loadingSpinner.style.display = 'none';
        
        if (result.success && result.data && result.data.length > 0) {
            datosActuales = result.data;
            renderizarTabla(result.data);
            renderizarTotales(result.totales);
            tablaFooter.style.display = 'grid';
            sinDatosMensaje.style.display = 'none';
        } else {
            tablaBody.innerHTML = `
                <div style="text-align: center; padding: 40px; color: #6c757d;">
                    <i class="fas fa-info-circle"></i> No hay operaciones con proveedores en el período seleccionado
                </div>
            `;
            tablaFooter.style.display = 'none';
            sinDatosMensaje.style.display = 'block';
        }
    } catch (error) {
        console.error('Error:', error);
        loadingSpinner.style.display = 'none';
        tablaBody.innerHTML = `
            <div style="text-align: center; padding: 40px; color: #dc3545;">
                <i class="fas fa-exclamation-triangle"></i> Error al cargar los datos
            </div>
        `;
        mostrarToast('Error al cargar datos', 'error');
    }
}

// Renderizar tabla
function renderizarTabla(datos) {
    if (!datos || datos.length === 0) {
        tablaBody.innerHTML = `
            <div style="text-align: center; padding: 40px; color: #6c757d;">
                <i class="fas fa-info-circle"></i> No hay datos para mostrar
            </div>
        `;
        return;
    }
    
    let html = '<div style="padding: 5px 0;">';
    
    datos.forEach((item, index) => {
        const subtotal = parseFloat(item.subtotal) || 0;
        const iva16 = parseFloat(item.iva_16) || 0;
        const iva8 = parseFloat(item.iva_8) || 0;
        const iva0 = parseFloat(item.iva_0) || 0;
        const ivaExento = parseFloat(item.iva_exento) || 0;
        const total = subtotal + iva16 + iva8 + iva0 + ivaExento;
        
        html += `
            <div class="fila-operacion" style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center;">
                <div style="font-weight: 500;">${escapeHtml(item.razon_social || item.nombre || 'Sin nombre')}</div>
                <div>${escapeHtml(item.rfc || '-')}</div>
                <div style="text-align: right; font-family: monospace;">${formatCurrency(subtotal)}</div>
                <div style="text-align: right; font-family: monospace;">${formatCurrency(iva16)}</div>
                <div style="text-align: right; font-family: monospace;">${formatCurrency(iva8)}</div>
                <div style="text-align: right; font-family: monospace;">${formatCurrency(iva0)}</div>
                <div style="text-align: right; font-family: monospace;">${formatCurrency(ivaExento)}</div>
                <div style="text-align: right; font-family: monospace; font-weight: 600;">${formatCurrency(total)}</div>
            </div>
        `;
    });
    
    html += '</div>';
    tablaBody.innerHTML = html;
}

// Renderizar totales
function renderizarTotales(totales) {
    if (!totales) return;
    
    const subtotal = parseFloat(totales.subtotal) || 0;
    const iva16 = parseFloat(totales.iva_16) || 0;
    const iva8 = parseFloat(totales.iva_8) || 0;
    const iva0 = parseFloat(totales.iva_0) || 0;
    const ivaExento = parseFloat(totales.iva_exento) || 0;
    const totalGeneral = subtotal + iva16 + iva8 + iva0 + ivaExento;
    
    document.getElementById('totalSubtotal').textContent = formatCurrency(subtotal);
    document.getElementById('totalIva16').textContent = formatCurrency(iva16);
    document.getElementById('totalIva8').textContent = formatCurrency(iva8);
    document.getElementById('totalIva0').textContent = formatCurrency(iva0);
    document.getElementById('totalIvaExento').textContent = formatCurrency(ivaExento);
    document.getElementById('totalGeneral').textContent = formatCurrency(totalGeneral);
}

// Descargar archivo
async function descargarArchivo() {
    const mes = mesSelect.value;
    const anio = anioSelect.value;
    const mesNombre = mesSelect.options[mesSelect.selectedIndex].text;
    
    try {
        btnDescargar.disabled = true;
        btnDescargar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generando...';
        
        const response = await fetch(`${API_DESCARGAR}?mes=${mes}&anio=${anio}`);
        
        if (response.ok) {
            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `DIOT_${mesNombre}_${anio}.txt`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
            mostrarToast('Archivo descargado correctamente', 'success');
        } else {
            const error = await response.json();
            mostrarToast(error.message || 'Error al generar archivo', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarToast('Error al descargar archivo', 'error');
    } finally {
        btnDescargar.disabled = false;
        btnDescargar.innerHTML = '<i class="fas fa-download"></i> Descargar .txt';
    }
}

// Mostrar toast
function mostrarToast(msg, tipo = 'success') {
    const container = document.getElementById('toastContainer');
    if (!container) {
        // Crear container si no existe
        const newContainer = document.createElement('div');
        newContainer.className = 'toast-container';
        newContainer.id = 'toastContainer';
        newContainer.style.cssText = 'position: fixed; bottom: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 10px;';
        document.body.appendChild(newContainer);
    }
    
    const toastContainer = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = `toast ${tipo}`;
    const icon = tipo === 'success' ? 'fa-check-circle' : tipo === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle';
    toast.innerHTML = `<i class="fas ${icon}"></i> ${msg}`;
    toast.style.cssText = 'background: #1A1D23; color: white; padding: 12px 20px; border-radius: 8px; font-size: 13px; display: flex; align-items: center; gap: 12px; min-width: 300px; max-width: 400px; box-shadow: 0 8px 24px rgba(0,0,0,0.2); animation: slideInRight 0.3s ease; border-left: 4px solid;';
    
    if (tipo === 'success') toast.style.borderLeftColor = '#28a745';
    else if (tipo === 'warning') toast.style.borderLeftColor = '#ffc107';
    else toast.style.borderLeftColor = '#dc3545';
    
    toastContainer.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideInRight 0.3s reverse';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Escapar HTML
function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

// Eventos
document.addEventListener('DOMContentLoaded', function() {
    // Cargar datos iniciales
    cargarDatos();
    
    // Evento cambio de mes/año
    mesSelect.addEventListener('change', cargarDatos);
    anioSelect.addEventListener('change', cargarDatos);
    
    // Evento descarga
    btnDescargar.addEventListener('click', descargarArchivo);
});

// Estilos adicionales para toast
const style = document.createElement('style');
style.textContent = `
    .toast-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
`;
document.head.appendChild(style);
</script>
@endsection