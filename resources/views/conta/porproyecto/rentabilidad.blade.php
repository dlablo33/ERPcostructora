@extends('layouts.navigation')

@section('content')

{{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    :root {
        --brand: #083CAE;
        --brand-dark: #062D8A;
        --brand-light: #EAF0FA;
        --border: #DEE2E6;
        --bg: #F4F6F9;
        --surface: #FFFFFF;
        --surface2: #F8F9FA;
        --text: #000000;
        --text-2: #000000;
        --text-3: #000000;
        --radius: 6px;
        --radius-lg: 10px;
        --shadow: 0 2px 8px rgba(8,60,174,.07), 0 1px 3px rgba(0,0,0,.04);
        --shadow-hover: 0 6px 20px rgba(8,60,174,.13);
        --success: #28a745;
        --warning: #ffc107;
        --danger: #dc3545;
        --info: #17a2b8;
    }

    .min-h-screen {
        min-height: 100vh;
        background-color: #f9fafb;
        color: #000000;
    }

    .content {
        padding: 1rem 1.5rem;
    }

    .container-fluid {
        width: 100%;
        max-width: 100%;
    }

    .py-3 {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .mt-2 {
        margin-top: 0.5rem;
    }

    /* Estilos de tarjeta principal */
    .semaforo.card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 1.5rem;
        border: 1px solid #e5e7eb;
    }

    .semaforo .card-header {
        background-color: #f4f6f9;
        border-bottom: 2px solid #083CAE;
        padding: 15px 20px;
        text-align: center;
    }

    .semaforo .card-header h2 {
        color: #083CAE;
        font-weight: bold;
        margin: 0;
        font-size: 24px;
    }

    /* KPIs - Centrados y texto negro */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        padding: 20px;
        background-color: white;
        border-bottom: 1px solid #e5e7eb;
    }

    .kpi-card {
        background: white;
        border-radius: 8px;
        padding: 20px 15px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        text-align: center;
    }

    .kpi-card .label {
        font-size: 14px;
        font-weight: 600;
        color: #000000;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
        text-align: center;
    }

    .kpi-card .value {
        font-size: 28px;
        font-weight: 700;
        color: #000000;
        margin-bottom: 5px;
        text-align: center;
        line-height: 1.2;
    }

    .kpi-card .sub {
        font-size: 12px;
        color: #6b7280;
        margin-top: 5px;
    }

    .kpi-card .trend {
        font-size: 13px;
        font-weight: 600;
        margin-top: 8px;
    }

    .trend.up {
        color: var(--success);
    }

    .trend.down {
        color: var(--danger);
    }

    /* Botones de acción */
    .btn-icon {
        background: transparent;
        border: 1px solid #083CAE;
        border-radius: 20px;
        color: #083CAE;
        cursor: pointer;
        padding: 8px 16px;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .btn-icon:hover {
        background-color: #083CAE;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(8,60,174,0.3);
    }

    .btn-icon i {
        font-size: 14px;
    }

    /* Selector de período */
    .periodo-selector {
        display: flex;
        gap: 10px;
        align-items: center;
        background: white;
        padding: 10px 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .periodo-btn {
        background: transparent;
        border: 1px solid #dee2e6;
        color: #6b7280;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .periodo-btn:hover {
        border-color: #083CAE;
        color: #083CAE;
    }

    .periodo-btn.active {
        background: #083CAE;
        border-color: #083CAE;
        color: white;
    }

    .date-range {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-left: auto;
    }

    .date-input {
        padding: 6px 12px;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        font-size: 13px;
        color: #000000;
    }

    .date-input:focus {
        outline: none;
        border-color: #083CAE;
    }

    /* Gráfico de rentabilidad */
    .chart-container {
        padding: 20px;
        background: white;
        border-bottom: 1px solid #e5e7eb;
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .chart-title {
        font-size: 16px;
        font-weight: 600;
        color: #000000;
    }

    .chart-legend {
        display: flex;
        gap: 20px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
    }

    .legend-color {
        width: 12px;
        height: 12px;
        border-radius: 3px;
    }

    .legend-color.ingresos {
        background: #083CAE;
    }

    .legend-color.costos {
        background: #C4540A;
    }

    .legend-color.rentabilidad {
        background: #28a745;
    }

    /* Barras de rentabilidad */
    .barras-container {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-top: 20px;
    }

    .barra-item {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .barra-label {
        width: 120px;
        font-size: 13px;
        font-weight: 600;
        color: #000000;
    }

    .barra-proyecto {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .proyecto-dot {
        width: 10px;
        height: 10px;
        border-radius: 2px;
    }

    .barra-contenedor {
        flex: 1;
        height: 30px;
        background: #e9ecef;
        border-radius: 6px;
        overflow: hidden;
        display: flex;
    }

    .barra-ingresos {
        height: 100%;
        background: #083CAE;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding-right: 8px;
        color: white;
        font-size: 11px;
        font-weight: 600;
        transition: width 0.5s ease;
    }

    .barra-costos {
        height: 100%;
        background: #C4540A;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding-right: 8px;
        color: white;
        font-size: 11px;
        font-weight: 600;
        transition: width 0.5s ease;
    }

    .barra-rentabilidad {
        width: 80px;
        font-size: 13px;
        font-weight: 700;
        text-align: right;
    }

    .rentabilidad-positiva {
        color: var(--success);
    }

    .rentabilidad-negativa {
        color: var(--danger);
    }

    /* Tabla de rentabilidad por hora */
    .table-container {
        overflow-x: auto;
        max-height: 500px;
        overflow-y: auto;
        width: 100%;
        background: white;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .table th {
        white-space: nowrap;
        font-size: 12px;
        background-color: #083CAE !important;
        color: white !important;
        font-weight: 600;
        padding: 12px 8px;
        border: 1px solid #dee2e6;
        position: sticky;
        top: 0;
        z-index: 20;
        text-align: left;
    }

    .table td {
        white-space: nowrap;
        font-size: 12px;
        padding: 12px 8px;
        color: #000000 !important;
        border: 1px solid #dee2e6;
        text-align: left;
    }

    .table td.text-right {
        text-align: right;
    }

    /* Estilo para las filas */
    #tablaBody tr {
        transition: all 0.3s ease;
        animation: fadeInRow 0.3s ease;
    }

    @keyframes fadeInRow {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    #tablaBody tr:nth-child(odd) {
        background-color: #ffffff;
    }

    #tablaBody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #tablaBody tr:hover {
        background-color: #e0e0e0;
        transform: scale(1.002);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    /* Badges de rentabilidad */
    .badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 8px;
        border-radius: 3px;
        display: inline-block;
    }

    .badge-excelente {
        background-color: #28a745;
        color: white;
    }

    .badge-buena {
        background-color: #17a2b8;
        color: white;
    }

    .badge-regular {
        background-color: #ffc107;
        color: black;
    }

    .badge-baja {
        background-color: #fd7e14;
        color: white;
    }

    .badge-negativa {
        background-color: #dc3545;
        color: white;
    }

    /* Filtros */
    .filters-container {
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
        padding: 15px 20px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }

    .search-box {
        position: relative;
        flex: 1;
        min-width: 250px;
    }

    .search-box i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        font-size: 14px;
    }

    .search-box input {
        width: 100%;
        padding: 8px 12px 8px 35px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 13px;
        color: #000000;
        transition: all 0.3s ease;
    }

    .search-box input:focus {
        border-color: #083CAE;
        box-shadow: 0 0 0 3px rgba(8,60,174,0.1);
        outline: none;
    }

    .filter-select {
        padding: 8px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 13px;
        min-width: 150px;
        color: #000000;
        transition: all 0.3s ease;
    }

    .filter-select:focus {
        border-color: #083CAE;
        outline: none;
        box-shadow: 0 0 0 3px rgba(8,60,174,0.1);
    }

    .filter-badge {
        background-color: #083CAE;
        color: white;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(8,60,174,0.7); }
        70% { box-shadow: 0 0 0 10px rgba(8,60,174,0); }
        100% { box-shadow: 0 0 0 0 rgba(8,60,174,0); }
    }

    /* Paginación */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background-color: transparent;
        border-top: 1px solid #e5e7eb;
    }

    .pagination-info {
        color: #000000;
        font-size: 13px;
    }

    .pagination-controls {
        display: flex;
        gap: 5px;
        align-items: center;
    }

    .page-btn {
        background: transparent;
        border: 1px solid #dee2e6;
        color: #083CAE;
        cursor: pointer;
        padding: 5px 10px;
        font-size: 13px;
        border-radius: 4px;
        transition: all 0.3s ease;
        min-width: 35px;
    }

    .page-btn:hover:not(:disabled) {
        background-color: #083CAE;
        color: white;
        border-color: #083CAE;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(8,60,174,0.2);
    }

    .page-btn.active {
        background-color: #083CAE;
        color: white;
        border-color: #083CAE;
    }

    .page-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Proyectos */
    .project-tag {
        display: flex;
        align-items: center;
        gap: 7px;
    }
    
    .project-dot {
        width: 9px;
        height: 9px;
        border-radius: 2px;
        flex-shrink: 0;
    }
    
    .project-code {
        font-weight: 700;
        font-size: 12px;
        line-height: 1.2;
        color: #000000;
    }
    
    .project-name {
        font-size: 10.5px;
        color: #6b7280;
    }

    /* Monospace para números */
    .mono {
        font-family: 'SFMono-Regular', Consolas, monospace;
        font-size: 12px;
        color: #000000;
    }

    /* Texto a la derecha */
    .text-right {
        text-align: right;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .kpi-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .filters-container {
            flex-direction: column;
        }

        .search-box {
            width: 100%;
        }

        .filter-select {
            width: 100%;
        }

        .periodo-selector {
            flex-direction: column;
            align-items: flex-start;
        }

        .date-range {
            margin-left: 0;
            width: 100%;
            flex-wrap: wrap;
        }

        .date-input {
            flex: 1;
        }

        .barra-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .barra-label {
            width: 100%;
        }

        .barra-rentabilidad {
            width: 100%;
            text-align: left;
        }

        #tablaBody td:last-child {
            position: static;
            box-shadow: none;
        }
    }
</style>

<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Rentabilidad por Hora -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header">
                <h2>
                    <i class="fas fa-chart-line mr-2"></i>
                    Rentabilidad por Hora
                </h2>
            </div>
            
            <!-- Selector de período -->
            <div class="periodo-selector">
                <button class="periodo-btn active">Hoy</button>
                <button class="periodo-btn">Esta semana</button>
                <button class="periodo-btn">Este mes</button>
                <button class="periodo-btn">Este trimestre</button>
                <button class="periodo-btn">Este año</button>
                <div class="date-range">
                    <i class="fas fa-calendar-alt" style="color: #6b7280;"></i>
                    <input type="date" class="date-input" id="fechaInicio" value="2025-06-01">
                    <span style="color: #6b7280;">a</span>
                    <input type="date" class="date-input" id="fechaFin" value="2025-06-30">
                    <button class="btn-icon" onclick="actualizarRango()">
                        <i class="fas fa-sync-alt"></i> Actualizar
                    </button>
                </div>
            </div>
            
            <!-- KPIs de rentabilidad -->
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="label">Rentabilidad Promedio</div>
                    <div class="value" id="kpiRentabilidadPromedio">$245/hr</div>
                    <div class="trend up">
                        <i class="fas fa-arrow-up"></i> +12% vs mes anterior
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="label">Horas Facturadas</div>
                    <div class="value" id="kpiHorasFacturadas">1,847 hrs</div>
                    <div class="sub">92% de capacidad</div>
                </div>
                <div class="kpi-card">
                    <div class="label">Ingreso por Hora</div>
                    <div class="value" id="kpiIngresoHora">$580/hr</div>
                    <div class="trend up">
                        <i class="fas fa-arrow-up"></i> +5% vs mes anterior
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="label">Costo por Hora</div>
                    <div class="value" id="kpiCostoHora">$335/hr</div>
                    <div class="trend down">
                        <i class="fas fa-arrow-down"></i> -3% vs mes anterior
                    </div>
                </div>
            </div>
            
            <!-- Gráfico de rentabilidad -->
            <div class="chart-container">
                <div class="chart-header">
                    <span class="chart-title">Rentabilidad por Proyecto - Junio 2025</span>
                    <div class="chart-legend">
                        <div class="legend-item">
                            <div class="legend-color ingresos"></div>
                            <span>Ingresos</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color costos"></div>
                            <span>Costos</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color rentabilidad"></div>
                            <span>Rentabilidad</span>
                        </div>
                    </div>
                </div>
                
                <!-- Barras de rentabilidad por proyecto -->
                <div class="barras-container" id="barrasRentabilidad"></div>
            </div>
            
            <!-- Tabs -->
            <div class="tabs-container">
                <div class="tab-item active" onclick="setTab(this, 'todos')">
                    <i class="fas fa-list mr-1"></i> Todos los Proyectos
                </div>
                <div class="tab-item" onclick="setTab(this, 'altarentabilidad')">
                    <i class="fas fa-star mr-1"></i> Alta Rentabilidad
                </div>
                <div class="tab-item" onclick="setTab(this, 'bajarentabilidad')">
                    <i class="fas fa-exclamation-triangle mr-1"></i> Baja Rentabilidad
                </div>
                <div class="tab-item" onclick="setTab(this, 'negativos')">
                    <i class="fas fa-times-circle mr-1"></i> Negativos
                </div>
            </div>
            
            <!-- Filtros -->
            <div class="filters-container">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Buscar por proyecto, código..." oninput="filtrar()">
                </div>
                
                <select class="filter-select" id="filterResponsable" onchange="filtrar()">
                    <option value="">Todos los responsables</option>
                    <option value="Ing. Carlos Ruiz">Ing. Carlos Ruiz</option>
                    <option value="Arq. Laura Martínez">Arq. Laura Martínez</option>
                    <option value="Ing. Pedro Sánchez">Ing. Pedro Sánchez</option>
                    <option value="Lic. Ana Torres">Lic. Ana Torres</option>
                </select>
                
                <select class="filter-select" id="filterEstatus" onchange="filtrar()">
                    <option value="">Todos los estatus</option>
                    <option value="En ejecución">En ejecución</option>
                    <option value="En revisión">En revisión</option>
                    <option value="Completado">Completado</option>
                    <option value="En pausa">En pausa</option>
                </select>
                
                <span class="filter-badge" id="filterCount">0</span>
            </div>
            
            <!-- Tabla de rentabilidad por hora -->
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th draggable="true" ondragstart="drag(event)" data-columna="proyecto">Proyecto <i class="fas fa-filter"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="responsable">Responsable <i class="fas fa-filter"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="horas">Horas <i class="fas fa-sort" onclick="ordenar('horas')"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="ingresoHora">Ingreso/Hora <i class="fas fa-sort" onclick="ordenar('ingresoHora')"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="costoHora">Costo/Hora <i class="fas fa-sort" onclick="ordenar('costoHora')"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="rentabilidadHora">Rentabilidad/Hora <i class="fas fa-sort" onclick="ordenar('rentabilidadHora')"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="margen">Margen <i class="fas fa-sort" onclick="ordenar('margen')"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="estatus">Estatus <i class="fas fa-filter"></i></th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaBody"></tbody>
                    <tfoot id="tablaFoot"></tfoot>
                </table>
            </div>
            
            <!-- Paginación -->
            <div class="pagination-container">
                <div class="pagination-info">
                    Mostrando <span id="footerInfo">0 registros</span>
                </div>
                <div class="pagination-controls">
                    <button class="page-btn" onclick="cambiarPagina(-1)" id="btnAnterior" disabled>
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <span class="page-btn active" id="pageNum">1</span>
                    <button class="page-btn" onclick="cambiarPagina(1)" id="btnSiguiente">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<script>
// Datos de proyectos
const proyectoColors = {
    'TRC001': '#083CAE', 'PAC002': '#1A4F8C',
    'CIA003': '#1A6644', 'RHR004': '#8C6A0A', 'VPS005': '#6B1A8C',
    'PGA006': '#9C27B0', 'CCM007': '#FF9800', 'UAN008': '#00BCD4',
    'PIR009': '#4CAF50', 'EST010': '#E91E63'
};

const proyectoNames = {
    'TRC001': 'Torre Residencial Cumbres',
    'PAC002': 'Puente Av. Constitución',
    'CIA003': 'Complejo Industrial Apodaca',
    'RHR004': 'Hospital Regional',
    'VPS005': 'Vialidad Periférico Sur',
    'PGA006': 'Plaza Galerías Monterrey',
    'CCM007': 'Centro Comercial Metropolitano',
    'UAN008': 'Unidad Habitacional Anáhuac',
    'PIR009': 'Parque Industrial Roble',
    'EST010': 'Estadio Universitario'
};

const responsables = [
    'Ing. Carlos Ruiz', 'Arq. Laura Martínez', 'Ing. Pedro Sánchez', 
    'Lic. Ana Torres', 'Ing. Miguel Hernández', 'Arq. Sofía Ramírez',
    'Ing. Roberto Flores', 'Lic. Carmen García'
];

const estatuses = ['En ejecución', 'En revisión', 'Completado', 'En pausa'];

// Generar 50 proyectos con datos de rentabilidad
let proyectos = [];
let nextId = 1;

for (let i = 0; i < 50; i++) {
    const proyectoKeys = Object.keys(proyectoNames);
    const proyecto = proyectoKeys[Math.floor(Math.random() * proyectoKeys.length)];
    const responsable = responsables[Math.floor(Math.random() * responsables.length)];
    const estatus = estatuses[Math.floor(Math.random() * estatuses.length)];
    
    const horas = Math.floor(Math.random() * 500) + 50;
    const ingresoHora = Math.floor(Math.random() * 400) + 300; // $300 - $700
    const costoHora = Math.floor(Math.random() * 300) + 200;   // $200 - $500
    const rentabilidadHora = ingresoHora - costoHora;
    const margen = ((rentabilidadHora / ingresoHora) * 100).toFixed(1);
    
    const ingresoTotal = horas * ingresoHora;
    const costoTotal = horas * costoHora;
    const rentabilidadTotal = ingresoTotal - costoTotal;
    
    proyectos.push({
        id: nextId++,
        proyecto: proyecto,
        responsable: responsable,
        horas: horas,
        ingresoHora: ingresoHora,
        costoHora: costoHora,
        rentabilidadHora: rentabilidadHora,
        margen: parseFloat(margen),
        estatus: estatus,
        ingresoTotal: ingresoTotal,
        costoTotal: costoTotal,
        rentabilidadTotal: rentabilidadTotal
    });
}

// Ordenar por rentabilidad (mejores primero)
proyectos.sort((a, b) => b.rentabilidadHora - a.rentabilidadHora);

// Variables globales
let proyectosFiltrados = [...proyectos];
let currentTab = 'todos';
let currentPage = 1;
const PER_PAGE = 10;
let sortKey = 'rentabilidadHora';
let sortDir = -1;

// Funciones helper
const fmt = n => '$' + n.toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
const fmtNum = n => n.toLocaleString('es-MX');

function getBadgeClass(rentabilidad) {
    if (rentabilidad >= 250) return 'badge-excelente';
    if (rentabilidad >= 150) return 'badge-buena';
    if (rentabilidad >= 80) return 'badge-regular';
    if (rentabilidad >= 0) return 'badge-baja';
    return 'badge-negativa';
}

function getMargenClass(margen) {
    if (margen >= 40) return 'rentabilidad-positiva';
    if (margen >= 20) return 'rentabilidad-positiva';
    if (margen >= 0) return '';
    return 'rentabilidad-negativa';
}

// Actualizar KPIs
function actualizarKPIs() {
    const totalProyectos = proyectos.length;
    const horasTotales = proyectos.reduce((a, b) => a + b.horas, 0);
    const ingresosTotales = proyectos.reduce((a, b) => a + b.ingresoTotal, 0);
    const costosTotales = proyectos.reduce((a, b) => a + b.costoTotal, 0);
    const rentabilidadTotal = ingresosTotales - costosTotales;
    
    const ingresoHoraPromedio = ingresosTotales / horasTotales;
    const costoHoraPromedio = costosTotales / horasTotales;
    const rentabilidadHoraPromedio = rentabilidadTotal / horasTotales;
    
    document.getElementById('kpiRentabilidadPromedio').textContent = fmt(Math.round(rentabilidadHoraPromedio)) + '/hr';
    document.getElementById('kpiHorasFacturadas').textContent = fmtNum(horasTotales) + ' hrs';
    document.getElementById('kpiIngresoHora').textContent = fmt(Math.round(ingresoHoraPromedio)) + '/hr';
    document.getElementById('kpiCostoHora').textContent = fmt(Math.round(costoHoraPromedio)) + '/hr';
}

// Renderizar barras de rentabilidad
function renderBarras() {
    const container = document.getElementById('barrasRentabilidad');
    const topProyectos = proyectos.slice(0, 8); // Top 8 proyectos
    
    container.innerHTML = topProyectos.map(p => {
        const color = proyectoColors[p.proyecto] || '#888';
        const maxValor = Math.max(...proyectos.map(x => x.ingresoTotal));
        const anchoIngresos = (p.ingresoTotal / maxValor) * 100;
        const anchoCostos = (p.costoTotal / maxValor) * 100;
        const rentClass = p.rentabilidadHora >= 0 ? 'rentabilidad-positiva' : 'rentabilidad-negativa';
        
        return `
            <div class="barra-item">
                <div class="barra-label">
                    <div class="barra-proyecto">
                        <div class="proyecto-dot" style="background:${color}"></div>
                        <span>${p.proyecto}</span>
                    </div>
                </div>
                <div class="barra-contenedor">
                    <div class="barra-ingresos" style="width: ${anchoIngresos}%">
                        ${fmt(p.ingresoTotal)}
                    </div>
                    <div class="barra-costos" style="width: ${anchoCostos}%">
                        ${fmt(p.costoTotal)}
                    </div>
                </div>
                <div class="barra-rentabilidad ${rentClass}">
                    ${fmt(p.rentabilidadTotal)}
                </div>
            </div>
        `;
    }).join('');
}

// Filtrar
function getFiltered() {
    const q = (document.getElementById('searchInput')?.value || '').toLowerCase();
    const fR = document.getElementById('filterResponsable')?.value || '';
    const fE = document.getElementById('filterEstatus')?.value || '';
    
    return proyectos.filter(p => {
        let tabMatch = true;
        if (currentTab === 'altarentabilidad') {
            tabMatch = p.rentabilidadHora >= 200;
        } else if (currentTab === 'bajarentabilidad') {
            tabMatch = p.rentabilidadHora > 0 && p.rentabilidadHora < 100;
        } else if (currentTab === 'negativos') {
            tabMatch = p.rentabilidadHora <= 0;
        }
        
        const searchStr = [p.proyecto, proyectoNames[p.proyecto], p.responsable].join(' ').toLowerCase();
        const mSrch = !q || searchStr.includes(q);
        const mR = !fR || p.responsable === fR;
        const mE = !fE || p.estatus === fE;
        
        return tabMatch && mSrch && mR && mE;
    }).sort((a, b) => {
        let av = a[sortKey], bv = b[sortKey];
        if (sortKey === 'ingresoHora' || sortKey === 'costoHora' || sortKey === 'rentabilidadHora' || sortKey === 'margen' || sortKey === 'horas') {
            av = +av;
            bv = +bv;
        }
        return av < bv ? -sortDir : av > bv ? sortDir : 0;
    });
}

// Renderizar tabla
function renderTabla() {
    proyectosFiltrados = getFiltered();
    const total = proyectosFiltrados.length;
    const pages = Math.ceil(total / PER_PAGE) || 1;
    
    if (currentPage > pages) currentPage = pages;
    if (currentPage < 1) currentPage = 1;
    
    const start = (currentPage - 1) * PER_PAGE;
    const slice = proyectosFiltrados.slice(start, start + PER_PAGE);

    document.getElementById('filterCount').textContent = total;
    document.getElementById('footerInfo').textContent = `${slice.length} de ${total} registros`;
    document.getElementById('pageNum').textContent = currentPage;
    
    document.getElementById('btnAnterior').disabled = currentPage === 1;
    document.getElementById('btnSiguiente').disabled = currentPage === pages;

    const body = document.getElementById('tablaBody');
    
    if (!slice.length) {
        body.innerHTML = `<tr><td colspan="9" style="text-align: center; padding: 40px;">
            <div style="padding: 40px 20px; text-align: center;">
                <i class="fas fa-folder-open" style="font-size: 2rem; color: #dee2e6;"></i>
                <p style="font-size: 13px; color: #868e96; margin-top: 10px;">No se encontraron proyectos</p>
            </div>
        </td></tr>`;
    } else {
        body.innerHTML = slice.map(p => {
            const color = proyectoColors[p.proyecto] || '#888';
            const badgeClass = getBadgeClass(p.rentabilidadHora);
            const margenClass = getMargenClass(p.margen);
            
            return `<tr>
                <td>
                    <div class="project-tag">
                        <div class="project-dot" style="background:${color}"></div>
                        <div>
                            <div class="project-code">${p.proyecto}</div>
                            <div class="project-name">${proyectoNames[p.proyecto] || ''}</div>
                        </div>
                    </div>
                </td>
                <td>${p.responsable}</td>
                <td class="text-right"><span class="mono">${fmtNum(p.horas)}</span></td>
                <td class="text-right"><span class="mono">${fmt(p.ingresoHora)}</span></td>
                <td class="text-right"><span class="mono">${fmt(p.costoHora)}</span></td>
                <td class="text-right"><span class="mono" style="font-weight:700">${fmt(p.rentabilidadHora)}</span></td>
                <td class="text-right"><span class="mono ${margenClass}">${p.margen}%</span></td>
                <td><span class="badge ${badgeClass}">${p.estatus}</span></td>
                <td>
                    <i class="fas fa-eye" title="Ver detalle" onclick="verDetalle(${p.id})"></i>
                    <i class="fas fa-chart-bar" title="Ver gráfico" onclick="verGrafico(${p.id})"></i>
                    <i class="fas fa-file-pdf" title="Exportar PDF" onclick="exportarPDF(${p.id})" style="color:#dc3545;"></i>
                </td>
            </tr>`;
        }).join('');
    }

    // Totales
    const totalHoras = proyectosFiltrados.reduce((a, b) => a + b.horas, 0);
    const totalIngresos = proyectosFiltrados.reduce((a, b) => a + b.ingresoTotal, 0);
    const totalCostos = proyectosFiltrados.reduce((a, b) => a + b.costoTotal, 0);
    const totalRentabilidad = totalIngresos - totalCostos;
    
    document.getElementById('tablaFoot').innerHTML = `<tr>
        <td colspan="2" style="text-align: right; font-weight:600;">Totales filtrados:</td>
        <td class="text-right"><span class="mono" style="font-weight:700">${fmtNum(totalHoras)} hrs</span></td>
        <td class="text-right" colspan="2"></td>
        <td class="text-right"><span class="mono" style="font-weight:700">${fmt(totalRentabilidad)}</span></td>
        <td colspan="3"></td>
    </tr>`;
    
    actualizarKPIs();
    renderBarras();
}

// Funciones de acción
function filtrar() { 
    currentPage = 1; 
    renderTabla(); 
}

function setTab(el, tab) {
    document.querySelectorAll('.tab-item').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    currentTab = tab;
    currentPage = 1;
    renderTabla();
}

function ordenar(key) { 
    if (sortKey === key) {
        sortDir *= -1;
    } else {
        sortKey = key;
        sortDir = 1;
    }
    renderTabla(); 
}

function cambiarPagina(dir) { 
    const pages = Math.ceil(getFiltered().length / PER_PAGE) || 1; 
    currentPage = Math.max(1, Math.min(pages, currentPage + dir)); 
    renderTabla(); 
}

function actualizarRango() {
    const inicio = document.getElementById('fechaInicio').value;
    const fin = document.getElementById('fechaFin').value;
    mostrarToast(`Período actualizado: ${inicio} a ${fin}`, 'info');
    renderTabla();
}

function verDetalle(id) {
    const p = proyectos.find(x => x.id === id);
    if (p) {
        mostrarToast(`${p.proyecto} - ${proyectoNames[p.proyecto]} - Rentabilidad: ${fmt(p.rentabilidadHora)}/hr`, 'info');
    }
}

function verGrafico(id) {
    const p = proyectos.find(x => x.id === id);
    if (p) {
        mostrarToast(`Mostrando gráfico de rentabilidad para ${p.proyecto}`, 'info');
    }
}

function exportarPDF(id) {
    const p = proyectos.find(x => x.id === id);
    if (p) {
        mostrarToast(`Exportando reporte de ${p.proyecto} a PDF`, 'success');
    }
}

// Mostrar toast
function mostrarToast(msg, tipo = 'success') {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = `toast ${tipo}`;
    const icon = tipo === 'success' ? 'fa-check-circle' : tipo === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle';
    toast.innerHTML = `<i class="fas ${icon}"></i> ${msg}`;
    container.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideInRight 0.3s reverse';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Drag and drop
function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.getAttribute('data-columna'));
}

// Inicializar
document.addEventListener('DOMContentLoaded', function() {
    renderTabla();
    
    // Agregar event listeners para los botones de período
    document.querySelectorAll('.periodo-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.periodo-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            mostrarToast(`Período cambiado a: ${this.textContent}`, 'info');
        });
    });
});
</script>

@endsection