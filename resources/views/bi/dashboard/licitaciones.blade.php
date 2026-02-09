@extends('layouts.navigation')

@section('content')
<style>
    :root {
        /* Colores profesionales y formales */
        --primary-green: #28a745;
        --primary-red: #dc3545;
        --primary-amber: #f39c12;
        --primary-blue: #0056b3;
        --primary-purple: #6f42c1;
        --primary-teal: #17a2b8;
        --secondary-blue: #007bff;
        --dark-bg: #1a2a3a;
        --light-bg: #f8f9fa;
        --text-dark: #212529;
        --text-light: #ffffff;
        --gray-light: #e9ecef;
        --gray-medium: #6c757d;
        --success-light: #d4edda;
        --warning-light: #fff3cd;
        --danger-light: #f8d7da;
        --info-light: #d1ecf1;
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    body {
        background-color: var(--light-bg);
        color: var(--text-dark);
    }
    
    /* Contenido principal */
    .main-content {
        padding: 2rem;
        max-width: 1400px;
        margin: 0 auto;
    }
    
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .page-title {
        font-size: 2.2rem;
        color: var(--dark-bg);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .page-title i {
        color: var(--primary-blue);
    }
    
    .actions {
        display: flex;
        gap: 1rem;
    }
    
    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .btn-primary {
        background-color: var(--primary-green);
        color: var(--text-light);
    }
    
    .btn-primary:hover {
        background-color: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
    }
    
    .btn-secondary {
        background-color: var(--primary-blue);
        color: var(--text-light);
    }
    
    .btn-secondary:hover {
        background-color: #004494;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 86, 179, 0.3);
    }
    
    /* Filtros y estadísticas */
    .filters-section {
        background-color: white;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    
    .filters-row {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .filter-group {
        flex: 1;
        min-width: 200px;
    }
    
    .filter-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--gray-medium);
    }
    
    .filter-select, .filter-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--gray-light);
        border-radius: 6px;
        font-size: 1rem;
    }
    
    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background-color: white;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
    }
    
    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .stat-title {
        font-size: 0.9rem;
        color: var(--gray-medium);
        font-weight: 600;
    }
    
    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    
    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .stat-change {
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .positive {
        color: var(--primary-green);
    }
    
    .negative {
        color: var(--primary-red);
    }
    
    /* Tabla de licitaciones */
    .licitaciones-section {
        background-color: white;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .section-title {
        font-size: 1.5rem;
        color: var(--dark-bg);
    }
    
    .table-container {
        overflow-x: auto;
    }
    
    .licitaciones-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .licitaciones-table th {
        background-color: var(--gray-light);
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: var(--gray-medium);
        border-bottom: 2px solid var(--gray-light);
    }
    
    .licitaciones-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--gray-light);
    }
    
    .licitaciones-table tr:hover {
        background-color: rgba(23, 162, 184, 0.05);
    }
    
    .badge {
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
    }
    
    .badge-proceso {
        background-color: var(--warning-light);
        color: #856404;
        border: 1px solid #ffeeba;
    }
    
    .badge-adjudicada {
        background-color: var(--success-light);
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .badge-desierta {
        background-color: var(--danger-light);
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .badge-finalizada {
        background-color: var(--info-light);
        color: #004085;
        border: 1px solid #bee5eb;
    }
    
    .badge-pendiente {
        background-color: #e2d9f3;
        color: #4a148c;
        border: 1px solid #c5b3e6;
    }
    
    .monto {
        font-weight: 600;
        color: var(--dark-bg);
    }
    
    .actions-cell {
        display: flex;
        gap: 0.5rem;
    }
    
    .action-btn {
        padding: 0.4rem 0.8rem;
        border-radius: 4px;
        border: none;
        background-color: transparent;
        cursor: pointer;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    
    .view-btn {
        color: var(--primary-teal);
        border: 1px solid var(--primary-teal);
    }
    
    .view-btn:hover {
        background-color: rgba(23, 162, 184, 0.1);
    }
    
    .edit-btn {
        color: var(--primary-amber);
        border: 1px solid var(--primary-amber);
    }
    
    .edit-btn:hover {
        background-color: rgba(243, 156, 18, 0.1);
    }
    
    .delete-btn {
        color: var(--primary-red);
        border: 1px solid var(--primary-red);
    }
    
    .delete-btn:hover {
        background-color: rgba(220, 53, 69, 0.1);
    }
    
    /* Paginación */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        margin-top: 2rem;
    }
    
    .pagination-btn {
        width: 40px;
        height: 40px;
        border-radius: 6px;
        border: 1px solid var(--gray-light);
        background-color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .pagination-btn:hover {
        background-color: var(--primary-teal);
        color: white;
        border-color: var(--primary-teal);
    }
    
    .pagination-btn.active {
        background-color: var(--primary-blue);
        color: white;
        border-color: var(--primary-blue);
    }
    
    /* Modal de nueva licitación */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        display: none;
    }
    
    .modal {
        background-color: white;
        border-radius: 10px;
        width: 90%;
        max-width: 700px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }
    
    .modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--gray-light);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: var(--light-bg);
    }
    
    .modal-title {
        font-size: 1.5rem;
        color: var(--dark-bg);
    }
    
    .modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: var(--gray-medium);
    }
    
    .modal-body {
        padding: 1.5rem;
    }
    
    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .form-group {
        flex: 1;
        min-width: 250px;
    }
    
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--gray-medium);
    }
    
    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--gray-light);
        border-radius: 6px;
        font-size: 1rem;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 0.2rem rgba(0, 86, 179, 0.25);
    }
    
    .modal-footer {
        padding: 1.5rem;
        border-top: 1px solid var(--gray-light);
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        background-color: var(--light-bg);
    }
    
    .btn-cancel {
        background-color: var(--gray-light);
        color: var(--gray-medium);
    }
    
    .btn-cancel:hover {
        background-color: #d8dde2;
    }
    
    /* Responsive */
    @media (max-width: 992px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
    }
    
    @media (max-width: 768px) {
        .main-content {
            padding: 1rem;
        }
        
        .stats-cards {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }
        
        .actions-cell {
            flex-direction: column;
            gap: 0.25rem;
        }
        
        .action-btn {
            width: 100%;
        }
    }
</style>

<div class="main-content">
    <!-- Encabezado de página -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-gavel"></i> Licitaciones Públicas
        </h1>
        <div class="actions">
            <button class="btn btn-secondary" id="filter-btn">
                <i class="fas fa-filter"></i> Filtrar
            </button>
            <button class="btn btn-primary" id="new-licitacion-btn">
                <i class="fas fa-plus"></i> Nueva Licitación
            </button>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="stats-cards">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">En Proceso</span>
                <div class="stat-icon" style="background-color: var(--warning-light); color: #856404;">
                    <i class="fas fa-spinner"></i>
                </div>
            </div>
            <span class="stat-value">12</span>
            <span class="stat-change positive"><i class="fas fa-arrow-up"></i> 2 nuevas esta semana</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Adjudicadas</span>
                <div class="stat-icon" style="background-color: var(--success-light); color: #155724;">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <span class="stat-value">8</span>
            <span class="stat-change positive"><i class="fas fa-arrow-up"></i> 15% vs mes anterior</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Valor Total</span>
                <div class="stat-icon" style="background-color: var(--info-light); color: #004085;">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
            <span class="stat-value">$4.2M</span>
            <span class="stat-change positive"><i class="fas fa-arrow-up"></i> 8% vs mes anterior</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Desiertas</span>
                <div class="stat-icon" style="background-color: var(--danger-light); color: #721c24;">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
            <span class="stat-value">3</span>
            <span class="stat-change negative"><i class="fas fa-arrow-down"></i> 1 menos que mes anterior</span>
        </div>
    </div>

    <!-- Filtros -->
    <div class="filters-section" id="filters-section" style="display: none;">
        <h3 style="margin-bottom: 1.5rem;">Filtrar Licitaciones</h3>
        <form id="filters-form">
            <div class="filters-row">
                <div class="filter-group">
                    <label class="filter-label">Estado</label>
                    <select class="filter-select" name="estado">
                        <option value="">Todos los estados</option>
                        <option value="proceso">En Proceso</option>
                        <option value="adjudicada">Adjudicada</option>
                        <option value="desierta">Desierta</option>
                        <option value="finalizada">Finalizada</option>
                        <option value="pendiente">Pendiente</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">Fecha de Cierre</label>
                    <select class="filter-select" name="fecha_cierre">
                        <option value="">Cualquier fecha</option>
                        <option value="7">Próximos 7 días</option>
                        <option value="30">Próximos 30 días</option>
                        <option value="90">Próximos 90 días</option>
                        <option value="past">Ya finalizadas</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">Monto</label>
                    <select class="filter-select" name="monto">
                        <option value="">Cualquier monto</option>
                        <option value="0-50000">Menos de $50,000</option>
                        <option value="50000-200000">$50,000 - $200,000</option>
                        <option value="200000-500000">$200,000 - $500,000</option>
                        <option value="500000+">Más de $500,000</option>
                    </select>
                </div>
            </div>
            
            <div class="filters-row">
                <div class="filter-group">
                    <label class="filter-label">Entidad Contratante</label>
                    <input type="text" class="filter-input" name="entidad" placeholder="Ej: Municipalidad de...">
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">Tipo de Obra</label>
                    <select class="filter-select" name="tipo_obra">
                        <option value="">Todos los tipos</option>
                        <option value="vial">Vial</option>
                        <option value="edificacion">Edificación</option>
                        <option value="hidraulica">Hidráulica</option>
                        <option value="sanitaria">Sanitaria</option>
                        <option value="electrica">Eléctrica</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">Ubicación</label>
                    <input type="text" class="filter-input" name="ubicacion" placeholder="Ej: Región Metropolitana">
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                <button type="button" class="btn btn-cancel" id="clear-filters-btn">Limpiar Filtros</button>
                <button type="submit" class="btn btn-secondary" id="apply-filters-btn">Aplicar Filtros</button>
            </div>
        </form>
    </div>

    <!-- Tabla de licitaciones -->
    <div class="licitaciones-section">
        <div class="section-header">
            <h2 class="section-title">Licitaciones Activas</h2>
            <div>
                <span style="color: var(--gray-medium);">Mostrando 8 de 32 licitaciones</span>
            </div>
        </div>
        
        <div class="table-container">
            <table class="licitaciones-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Entidad</th>
                        <th>Monto</th>
                        <th>Fecha Cierre</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Licitación 1 -->
                    <tr>
                        <td>#LIC-2023-045</td>
                        <td>Construcción Piscina Municipal</td>
                        <td>Municipalidad de Santiago</td>
                        <td class="monto">$245,000</td>
                        <td>15/10/2023</td>
                        <td><span class="badge badge-proceso">En Proceso</span></td>
                        <td class="actions-cell">
                            <button class="action-btn view-btn" data-id="LIC-2023-045">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="action-btn edit-btn" data-id="LIC-2023-045">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn delete-btn" data-id="LIC-2023-045">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    
                    <!-- Licitación 2 -->
                    <tr>
                        <td>#LIC-2023-044</td>
                        <td>Reposición Red Vial Comunal</td>
                        <td>Gobierno Regional</td>
                        <td class="monto">$1,250,000</td>
                        <td>10/10/2023</td>
                        <td><span class="badge badge-adjudicada">Adjudicada</span></td>
                        <td class="actions-cell">
                            <button class="action-btn view-btn" data-id="LIC-2023-044">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="action-btn edit-btn" data-id="LIC-2023-044">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn delete-btn" data-id="LIC-2023-044">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    
                    <!-- Licitación 3 -->
                    <tr>
                        <td>#LIC-2023-043</td>
                        <td>Construcción Edificio Administrativo</td>
                        <td>Servicio de Salud</td>
                        <td class="monto">$3,500,000</td>
                        <td>05/10/2023</td>
                        <td><span class="badge badge-proceso">En Proceso</span></td>
                        <td class="actions-cell">
                            <button class="action-btn view-btn" data-id="LIC-2023-043">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="action-btn edit-btn" data-id="LIC-2023-043">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn delete-btn" data-id="LIC-2023-043">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    
                    <!-- Licitación 4 -->
                    <tr>
                        <td>#LIC-2023-042</td>
                        <td>Mejoramiento Sistema de Riego</td>
                        <td>Ministerio de Obras Públicas</td>
                        <td class="monto">$850,000</td>
                        <td>28/09/2023</td>
                        <td><span class="badge badge-finalizada">Finalizada</span></td>
                        <td class="actions-cell">
                            <button class="action-btn view-btn" data-id="LIC-2023-042">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="action-btn edit-btn" data-id="LIC-2023-042">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn delete-btn" data-id="LIC-2023-042">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    
                    <!-- Licitación 5 -->
                    <tr>
                        <td>#LIC-2023-041</td>
                        <td>Instalación Alumbrado Público</td>
                        <td>Municipalidad de Providencia</td>
                        <td class="monto">$320,000</td>
                        <td>25/09/2023</td>
                        <td><span class="badge badge-desierta">Desierta</span></td>
                        <td class="actions-cell">
                            <button class="action-btn view-btn" data-id="LIC-2023-041">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="action-btn edit-btn" data-id="LIC-2023-041">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn delete-btn" data-id="LIC-2023-041">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    
                    <!-- Licitación 6 -->
                    <tr>
                        <td>#LIC-2023-040</td>
                        <td>Reparación Puente Vehicular</td>
                        <td>Dirección de Vialidad</td>
                        <td class="monto">$680,000</td>
                        <td>20/09/2023</td>
                        <td><span class="badge badge-pendiente">Pendiente</span></td>
                        <td class="actions-cell">
                            <button class="action-btn view-btn" data-id="LIC-2023-040">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="action-btn edit-btn" data-id="LIC-2023-040">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn delete-btn" data-id="LIC-2023-040">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    
                    <!-- Licitación 7 -->
                    <tr>
                        <td>#LIC-2023-039</td>
                        <td>Construcción Centro Deportivo</td>
                        <td>IND</td>
                        <td class="monto">$2,100,000</td>
                        <td>15/09/2023</td>
                        <td><span class="badge badge-adjudicada">Adjudicada</span></td>
                        <td class="actions-cell">
                            <button class="action-btn view-btn" data-id="LIC-2023-039">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="action-btn edit-btn" data-id="LIC-2023-039">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn delete-btn" data-id="LIC-2023-039">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    
                    <!-- Licitación 8 -->
                    <tr>
                        <td>#LIC-2023-038</td>
                        <td>Mejoramiento Accesos Aeropuerto</td>
                        <td>DGAC</td>
                        <td class="monto">$4,500,000</td>
                        <td>10/09/2023</td>
                        <td><span class="badge badge-proceso">En Proceso</span></td>
                        <td class="actions-cell">
                            <button class="action-btn view-btn" data-id="LIC-2023-038">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="action-btn edit-btn" data-id="LIC-2023-038">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn delete-btn" data-id="LIC-2023-038">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Paginación -->
        <div class="pagination">
            <button class="pagination-btn"><i class="fas fa-chevron-left"></i></button>
            <button class="pagination-btn active">1</button>
            <button class="pagination-btn">2</button>
            <button class="pagination-btn">3</button>
            <button class="pagination-btn">4</button>
            <button class="pagination-btn"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>
</div>

<!-- Modal para nueva licitación -->
<div class="modal-overlay" id="new-licitacion-modal">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title">Nueva Licitación</h3>
            <button class="modal-close" id="close-modal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="licitacion-form">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nombre de la Licitación *</label>
                        <input type="text" class="form-control" name="nombre" placeholder="Ej: Construcción de..." required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Entidad Contratante *</label>
                        <input type="text" class="form-control" name="entidad" placeholder="Ej: Municipalidad de..." required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Número de Licitación *</label>
                        <input type="text" class="form-control" name="numero_licitacion" placeholder="Ej: LIC-2023-XXX" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Tipo de Obra *</label>
                        <select class="form-control" name="tipo_obra" required>
                            <option value="">Seleccionar tipo</option>
                            <option value="vial">Vial</option>
                            <option value="edificacion">Edificación</option>
                            <option value="hidraulica">Hidráulica</option>
                            <option value="sanitaria">Sanitaria</option>
                            <option value="electrica">Eléctrica</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Monto Estimado (CLP) *</label>
                        <input type="number" class="form-control" name="monto" placeholder="Ej: 1000000" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Fecha de Cierre *</label>
                        <input type="date" class="form-control" name="fecha_cierre" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Ubicación *</label>
                        <input type="text" class="form-control" name="ubicacion" placeholder="Ej: Región, Comuna, Dirección" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Estado</label>
                        <select class="form-control" name="estado">
                            <option value="proceso">En Proceso</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="adjudicada">Adjudicada</option>
                            <option value="desierta">Desierta</option>
                            <option value="finalizada">Finalizada</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group" style="flex: 2;">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" name="descripcion" rows="4" placeholder="Descripción detallada de la licitación..."></textarea>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Plazo de Ejecución (días)</label>
                        <input type="number" class="form-control" name="plazo_ejecucion" placeholder="Ej: 180">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Garantía Requerida (%)</label>
                        <input type="number" class="form-control" name="garantia" placeholder="Ej: 10" min="0" max="100" step="0.5">
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-cancel" id="cancel-modal">Cancelar</button>
            <button type="button" class="btn btn-primary" id="save-licitacion">Guardar Licitación</button>
        </div>
    </div>
</div>

<!-- Modal para detalles -->
<div class="modal-overlay" id="detail-licitacion-modal">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title">Detalles de Licitación</h3>
            <button class="modal-close" id="close-detail-modal">&times;</button>
        </div>
        <div class="modal-body" id="detail-modal-content">
            <!-- Contenido cargado dinámicamente -->
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-cancel" id="cancel-detail-modal">Cerrar</button>
        </div>
    </div>
</div>

<script>
    // Datos ficticios de licitaciones
    const licitacionesData = [
        {
            id: 'LIC-2023-045',
            nombre: 'Construcción Piscina Municipal',
            entidad: 'Municipalidad de Santiago',
            monto: 245000,
            fecha_cierre: '15/10/2023',
            estado: 'proceso',
            descripcion: 'Construcción de piscina municipal semi-olímpica con sistema de filtrado moderno y áreas de vestuario.',
            ubicacion: 'Santiago Centro',
            tipo_obra: 'edificacion',
            plazo_ejecucion: 180,
            garantia: 10
        },
        {
            id: 'LIC-2023-044',
            nombre: 'Reposición Red Vial Comunal',
            entidad: 'Gobierno Regional',
            monto: 1250000,
            fecha_cierre: '10/10/2023',
            estado: 'adjudicada',
            descripcion: 'Reposición completa de 5 km de red vial comunal con asfalto de última generación.',
            ubicacion: 'Región Metropolitana',
            tipo_obra: 'vial',
            plazo_ejecucion: 240,
            garantia: 15
        },
        {
            id: 'LIC-2023-043',
            nombre: 'Construcción Edificio Administrativo',
            entidad: 'Servicio de Salud',
            monto: 3500000,
            fecha_cierre: '05/10/2023',
            estado: 'proceso',
            descripcion: 'Edificio de 8 pisos para oficinas administrativas del servicio de salud regional.',
            ubicacion: 'Providencia',
            tipo_obra: 'edificacion',
            plazo_ejecucion: 360,
            garantia: 20
        },
        {
            id: 'LIC-2023-042',
            nombre: 'Mejoramiento Sistema de Riego',
            entidad: 'Ministerio de Obras Públicas',
            monto: 850000,
            fecha_cierre: '28/09/2023',
            estado: 'finalizada',
            descripcion: 'Mejoramiento del sistema de riego para 500 hectáreas de cultivo en valle central.',
            ubicacion: 'Valparaíso',
            tipo_obra: 'hidraulica',
            plazo_ejecucion: 150,
            garantia: 12
        },
        {
            id: 'LIC-2023-041',
            nombre: 'Instalación Alumbrado Público',
            entidad: 'Municipalidad de Providencia',
            monto: 320000,
            fecha_cierre: '25/09/2023',
            estado: 'desierta',
            descripcion: 'Instalación de 200 puntos de alumbrado público LED en sector residencial.',
            ubicacion: 'Providencia',
            tipo_obra: 'electrica',
            plazo_ejecucion: 90,
            garantia: 8
        },
        {
            id: 'LIC-2023-040',
            nombre: 'Reparación Puente Vehicular',
            entidad: 'Dirección de Vialidad',
            monto: 680000,
            fecha_cierre: '20/09/2023',
            estado: 'pendiente',
            descripcion: 'Reparación estructural de puente vehicular afectado por sismo de 2022.',
            ubicacion: 'Maule',
            tipo_obra: 'vial',
            plazo_ejecucion: 120,
            garantia: 10
        },
        {
            id: 'LIC-2023-039',
            nombre: 'Construcción Centro Deportivo',
            entidad: 'IND',
            monto: 2100000,
            fecha_cierre: '15/09/2023',
            estado: 'adjudicada',
            descripcion: 'Centro deportivo con canchas multiuso, gimnasio y piscina temperada.',
            ubicacion: 'La Serena',
            tipo_obra: 'edificacion',
            plazo_ejecucion: 300,
            garantia: 18
        },
        {
            id: 'LIC-2023-038',
            nombre: 'Mejoramiento Accesos Aeropuerto',
            entidad: 'DGAC',
            monto: 4500000,
            fecha_cierre: '10/09/2023',
            estado: 'proceso',
            descripcion: 'Mejoramiento de accesos viales y señalética del aeropuerto internacional.',
            ubicacion: 'Pudahuel',
            tipo_obra: 'vial',
            plazo_ejecucion: 270,
            garantia: 25
        }
    ];

    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar/ocultar filtros
        document.getElementById('filter-btn').addEventListener('click', function() {
            const filtersSection = document.getElementById('filters-section');
            if (filtersSection.style.display === 'none' || filtersSection.style.display === '') {
                filtersSection.style.display = 'block';
                this.innerHTML = '<i class="fas fa-times"></i> Ocultar Filtros';
            } else {
                filtersSection.style.display = 'none';
                this.innerHTML = '<i class="fas fa-filter"></i> Filtrar';
            }
        });
        
        // Limpiar filtros
        document.getElementById('clear-filters-btn').addEventListener('click', function() {
            const filters = document.querySelectorAll('#filters-form input, #filters-form select');
            filters.forEach(filter => {
                if (filter.tagName === 'SELECT') {
                    filter.selectedIndex = 0;
                } else {
                    filter.value = '';
                }
            });
        });
        
        // Aplicar filtros
        document.getElementById('filters-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const estado = this.estado.value;
            const fechaCierre = this.fecha_cierre.value;
            const monto = this.monto.value;
            const entidad = this.entidad.value.toLowerCase();
            const tipoObra = this.tipo_obra.value;
            const ubicacion = this.ubicacion.value.toLowerCase();
            
            // Filtrar licitaciones
            const resultados = licitacionesData.filter(licitacion => {
                // Filtrar por estado
                if (estado && licitacion.estado !== estado) return false;
                
                // Filtrar por entidad
                if (entidad && !licitacion.entidad.toLowerCase().includes(entidad)) return false;
                
                // Filtrar por tipo de obra
                if (tipoObra && licitacion.tipo_obra !== tipoObra) return false;
                
                // Filtrar por ubicación
                if (ubicacion && !licitacion.ubicacion.toLowerCase().includes(ubicacion)) return false;
                
                // Filtrar por monto
                if (monto) {
                    const [min, max] = monto.split('-');
                    if (max) {
                        // Rango específico
                        const minVal = parseInt(min);
                        const maxVal = max === '+' ? Infinity : parseInt(max);
                        if (licitacion.monto < minVal || licitacion.monto > maxVal) return false;
                    }
                }
                
                return true;
            });
            
            // Actualizar la tabla con resultados
            actualizarTabla(resultados);
            
            document.getElementById('filters-section').style.display = 'none';
            document.getElementById('filter-btn').innerHTML = '<i class="fas fa-filter"></i> Filtrar';
            
            // Actualizar contador
            document.querySelector('.section-header span').textContent = 
                `Mostrando ${resultados.length} de ${resultados.length} licitaciones`;
        });
        
        // Mostrar modal de nueva licitación
        document.getElementById('new-licitacion-btn').addEventListener('click', function() {
            document.getElementById('new-licitacion-modal').style.display = 'flex';
        });
        
        // Guardar nueva licitación
        document.getElementById('save-licitacion').addEventListener('click', function() {
            const form = document.getElementById('licitacion-form');
            const formData = new FormData(form);
            
            // Validar formulario
            let valid = true;
            form.querySelectorAll('[required]').forEach(input => {
                if (!input.value.trim()) {
                    valid = false;
                    input.style.borderColor = 'var(--primary-red)';
                } else {
                    input.style.borderColor = '';
                }
            });
            
            if (!valid) {
                alert('Por favor complete todos los campos obligatorios (*)');
                return;
            }
            
            // Crear nueva licitación
            const nuevaLicitacion = {
                id: `LIC-2023-0${licitacionesData.length + 30}`,
                nombre: formData.get('nombre'),
                entidad: formData.get('entidad'),
                monto: parseInt(formData.get('monto')),
                fecha_cierre: new Date(formData.get('fecha_cierre')).toLocaleDateString('es-CL'),
                estado: formData.get('estado'),
                tipo_obra: formData.get('tipo_obra'),
                ubicacion: formData.get('ubicacion'),
                descripcion: formData.get('descripcion') || 'Sin descripción',
                plazo_ejecucion: parseInt(formData.get('plazo_ejecucion')) || 0,
                garantia: parseFloat(formData.get('garantia')) || 0
            };
            
            // Agregar a los datos
            licitacionesData.unshift(nuevaLicitacion);
            
            // Actualizar tabla
            actualizarTabla(licitacionesData);
            
            // Cerrar modal y limpiar formulario
            document.getElementById('new-licitacion-modal').style.display = 'none';
            form.reset();
            
            // Actualizar estadísticas
            actualizarEstadisticas();
            
            alert('Licitación creada exitosamente');
        });
        
        // Cerrar modales
        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('new-licitacion-modal').style.display = 'none';
        });
        
        document.getElementById('cancel-modal').addEventListener('click', function() {
            document.getElementById('new-licitacion-modal').style.display = 'none';
        });
        
        document.getElementById('close-detail-modal').addEventListener('click', function() {
            document.getElementById('detail-licitacion-modal').style.display = 'none';
        });
        
        document.getElementById('cancel-detail-modal').addEventListener('click', function() {
            document.getElementById('detail-licitacion-modal').style.display = 'none';
        });
        
        // Cerrar modales al hacer clic fuera de ellos
        document.querySelectorAll('.modal-overlay').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.style.display = 'none';
                }
            });
        });
        
        // Detalles de licitación
        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const licitacionId = this.getAttribute('data-id');
                mostrarDetallesLicitacion(licitacionId);
            });
        });
        
        // Editar licitación
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const licitacionId = this.getAttribute('data-id');
                alert(`Funcionalidad de edición para licitación ${licitacionId} - En desarrollo`);
            });
        });
        
        // Eliminar licitación
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const licitacionId = this.getAttribute('data-id');
                if (confirm(`¿Está seguro de eliminar la licitación ${licitacionId}?`)) {
                    const index = licitacionesData.findIndex(l => l.id === licitacionId);
                    if (index !== -1) {
                        licitacionesData.splice(index, 1);
                        this.closest('tr').remove();
                        actualizarEstadisticas();
                        alert(`Licitación ${licitacionId} eliminada`);
                    }
                }
            });
        });
        
        // Función para mostrar detalles de licitación
        function mostrarDetallesLicitacion(id) {
            const licitacion = licitacionesData.find(l => l.id === id);
            
            if (!licitacion) {
                alert('Licitación no encontrada');
                return;
            }
            
            const contenido = `
                <div class="detail-info">
                    <div class="detail-row">
                        <strong>ID:</strong> ${licitacion.id}
                    </div>
                    <div class="detail-row">
                        <strong>Nombre:</strong> ${licitacion.nombre}
                    </div>
                    <div class="detail-row">
                        <strong>Entidad Contratante:</strong> ${licitacion.entidad}
                    </div>
                    <div class="detail-row">
                        <strong>Monto Estimado:</strong> $${licitacion.monto.toLocaleString('es-CL')}
                    </div>
                    <div class="detail-row">
                        <strong>Fecha de Cierre:</strong> ${licitacion.fecha_cierre}
                    </div>
                    <div class="detail-row">
                        <strong>Estado:</strong> ${obtenerEstadoTexto(licitacion.estado)}
                    </div>
                    <div class="detail-row">
                        <strong>Tipo de Obra:</strong> ${obtenerTipoObraTexto(licitacion.tipo_obra)}
                    </div>
                    <div class="detail-row">
                        <strong>Ubicación:</strong> ${licitacion.ubicacion}
                    </div>
                    <div class="detail-row">
                        <strong>Plazo de Ejecución:</strong> ${licitacion.plazo_ejecucion} días
                    </div>
                    <div class="detail-row">
                        <strong>Garantía Requerida:</strong> ${licitacion.garantia}%
                    </div>
                    <div class="detail-row">
                        <strong>Descripción:</strong> ${licitacion.descripcion}
                    </div>
                </div>
                
                <style>
                    .detail-info {
                        display: flex;
                        flex-direction: column;
                        gap: 0.8rem;
                    }
                    
                    .detail-row {
                        padding: 0.8rem 0;
                        border-bottom: 1px solid var(--gray-light);
                    }
                    
                    .detail-row:last-child {
                        border-bottom: none;
                    }
                    
                    .detail-row strong {
                        display: inline-block;
                        width: 180px;
                        color: var(--gray-medium);
                    }
                </style>
            `;
            
            document.getElementById('detail-modal-content').innerHTML = contenido;
            document.getElementById('detail-licitacion-modal').style.display = 'flex';
        }
        
        function obtenerEstadoTexto(estado) {
            const estados = {
                'proceso': 'En Proceso',
                'adjudicada': 'Adjudicada',
                'desierta': 'Desierta',
                'finalizada': 'Finalizada',
                'pendiente': 'Pendiente'
            };
            return estados[estado] || estado;
        }
        
        function obtenerTipoObraTexto(tipo) {
            const tipos = {
                'vial': 'Vial',
                'edificacion': 'Edificación',
                'hidraulica': 'Hidráulica',
                'sanitaria': 'Sanitaria',
                'electrica': 'Eléctrica'
            };
            return tipos[tipo] || tipo;
        }
        
        function actualizarTabla(licitaciones) {
            const tbody = document.querySelector('.licitaciones-table tbody');
            tbody.innerHTML = '';
            
            if (licitaciones.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 2rem;">
                            <p style="color: var(--gray-medium);">No se encontraron licitaciones</p>
                            <button class="btn btn-primary" id="new-licitacion-btn-empty">
                                <i class="fas fa-plus"></i> Crear nueva licitación
                            </button>
                        </td>
                    </tr>
                `;
                
                document.getElementById('new-licitacion-btn-empty').addEventListener('click', function() {
                    document.getElementById('new-licitacion-modal').style.display = 'flex';
                });
                
                return;
            }
            
            licitaciones.forEach(licitacion => {
                const estadoBadge = obtenerBadgeEstado(licitacion.estado);
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>#${licitacion.id}</td>
                    <td>${licitacion.nombre}</td>
                    <td>${licitacion.entidad}</td>
                    <td class="monto">$${licitacion.monto.toLocaleString('es-CL')}</td>
                    <td>${licitacion.fecha_cierre}</td>
                    <td>${estadoBadge}</td>
                    <td class="actions-cell">
                        <button class="action-btn view-btn" data-id="${licitacion.id}">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="action-btn edit-btn" data-id="${licitacion.id}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="action-btn delete-btn" data-id="${licitacion.id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            });
            
            agregarEventosBotones();
        }
        
        function obtenerBadgeEstado(estado) {
            const badges = {
                'proceso': '<span class="badge badge-proceso">En Proceso</span>',
                'adjudicada': '<span class="badge badge-adjudicada">Adjudicada</span>',
                'desierta': '<span class="badge badge-desierta">Desierta</span>',
                'finalizada': '<span class="badge badge-finalizada">Finalizada</span>',
                'pendiente': '<span class="badge badge-pendiente">Pendiente</span>'
            };
            return badges[estado] || `<span class="badge">${estado}</span>`;
        }
        
        function agregarEventosBotones() {
            document.querySelectorAll('.view-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const licitacionId = this.getAttribute('data-id');
                    mostrarDetallesLicitacion(licitacionId);
                });
            });
            
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const licitacionId = this.getAttribute('data-id');
                    alert(`Funcionalidad de edición para licitación ${licitacionId} - En desarrollo`);
                });
            });
            
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const licitacionId = this.getAttribute('data-id');
                    if (confirm(`¿Está seguro de eliminar la licitación ${licitacionId}?`)) {
                        const index = licitacionesData.findIndex(l => l.id === licitacionId);
                        if (index !== -1) {
                            licitacionesData.splice(index, 1);
                            this.closest('tr').remove();
                            actualizarEstadisticas();
                            alert(`Licitación ${licitacionId} eliminada`);
                        }
                    }
                });
            });
            
            document.querySelectorAll('.licitaciones-table tbody tr').forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = 'rgba(23, 162, 184, 0.05)';
                });
                
                row.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                });
            });
        }
        
        function actualizarEstadisticas() {
            const enProceso = licitacionesData.filter(l => l.estado === 'proceso').length;
            const adjudicadas = licitacionesData.filter(l => l.estado === 'adjudicada').length;
            const desiertas = licitacionesData.filter(l => l.estado === 'desierta').length;
            const valorTotal = licitacionesData.reduce((sum, l) => sum + l.monto, 0);
            
            document.querySelectorAll('.stat-value')[0].textContent = enProceso;
            document.querySelectorAll('.stat-value')[1].textContent = adjudicadas;
            document.querySelectorAll('.stat-value')[2].textContent = `$${(valorTotal / 1000000).toFixed(1)}M`;
            document.querySelectorAll('.stat-value')[3].textContent = desiertas;
        }
        
        document.querySelectorAll('.licitaciones-table tbody tr').forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = 'rgba(23, 162, 184, 0.05)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });
        
        document.querySelectorAll('.pagination-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (this.classList.contains('active')) return;
                
                document.querySelectorAll('.pagination-btn').forEach(b => {
                    b.classList.remove('active');
                });
                
                this.classList.add('active');
                
                if (!this.querySelector('i')) {
                    alert(`Página ${this.textContent} - Funcionalidad de paginación en desarrollo`);
                }
            });
        });
    });
</script>

@endsection