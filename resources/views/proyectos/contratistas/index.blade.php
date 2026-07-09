{{-- resources/views/proyectos/contratistas/index.blade.php --}}
@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-users"></i> Gestión de Contratistas
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- BOTONES DE NAVEGACIÓN ENTRE SECCIONES -->
                <div style="display: flex; gap: 8px; margin-bottom: 20px; flex-wrap: wrap; justify-content: center;">
                    <button onclick="cambiarSeccion('listado')" id="btn-listado" class="btn-seccion active" style="background-color: #083CAE; color: white; border: none; border-radius: 6px; padding: 10px 25px; font-size: 14px; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-list"></i> Listado
                    </button>
                    <button onclick="cambiarSeccion('dashboard')" id="btn-dashboard" class="btn-seccion" style="background-color: #6c757d; color: white; border: none; border-radius: 6px; padding: 10px 25px; font-size: 14px; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-chart-pie"></i> Dashboard
                    </button>
                    <button onclick="cambiarSeccion('asignaciones')" id="btn-asignaciones" class="btn-seccion" style="background-color: #6c757d; color: white; border: none; border-radius: 6px; padding: 10px 25px; font-size: 14px; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-project-diagram"></i> Asignaciones
                    </button>
                    <button onclick="cambiarSeccion('gastos')" id="btn-gastos" class="btn-seccion" style="background-color: #6c757d; color: white; border: none; border-radius: 6px; padding: 10px 25px; font-size: 14px; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-receipt"></i> Gastos
                    </button>
                    <button onclick="cambiarSeccion('pagos')" id="btn-pagos" class="btn-seccion" style="background-color: #6c757d; color: white; border: none; border-radius: 6px; padding: 10px 25px; font-size: 14px; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-money-bill-wave"></i> Pagos
                    </button>
                </div>

                <!-- ========================================== -->
                <!-- SECCIÓN: DASHBOARD -->
                <!-- ========================================== -->
                <div id="seccion-dashboard" class="seccion-contenido" style="display: none;">
                    <!-- 4 CUADROS DE KPIs -->
                    <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                        <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                            <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                                <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">
                                    <i class="fas fa-users"></i> Total
                                </div>
                                <div style="color: #083CAE; font-size: 36px; font-weight: bold;" id="dashTotalContratistas">0</div>
                            </div>
                        </div>
                        <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                            <div class="custom-card" style="border: 2px solid #28a745; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                                <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">
                                    <i class="fas fa-check-circle"></i> Activos
                                </div>
                                <div style="color: #28a745; font-size: 36px; font-weight: bold;" id="dashActivos">0</div>
                            </div>
                        </div>
                        <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                            <div class="custom-card" style="border: 2px solid #ffc107; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                                <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">
                                    <i class="fas fa-project-diagram"></i> Proyectos
                                </div>
                                <div style="color: #ffc107; font-size: 36px; font-weight: bold;" id="dashTotalProyectos">0</div>
                            </div>
                        </div>
                        <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                            <div class="custom-card" style="border: 2px solid #17a2b8; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                                <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">
                                    <i class="fas fa-money-bill-wave"></i> Presupuesto
                                </div>
                                <div style="color: #17a2b8; font-size: 28px; font-weight: bold;" id="dashPresupuestoTotal">$0</div>
                            </div>
                        </div>
                    </div>

                    <!-- GRÁFICAS -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div style="border: 1px solid #dee2e6; border-radius: 8px; padding: 15px; background: white;">
                            <h4 style="color: #083CAE; margin-bottom: 15px;"><i class="fas fa-chart-bar"></i> Distribución por Especialidad</h4>
                            <canvas id="graficaEspecialidades" height="200"></canvas>
                        </div>
                        <div style="border: 1px solid #dee2e6; border-radius: 8px; padding: 15px; background: white;">
                            <h4 style="color: #083CAE; margin-bottom: 15px;"><i class="fas fa-chart-pie"></i> Gastos por Tipo</h4>
                            <canvas id="graficaGastosTipo" height="200"></canvas>
                        </div>
                    </div>

                    <!-- TOP CONTRATISTAS -->
                    <div style="border: 1px solid #dee2e6; border-radius: 8px; padding: 15px; background: white; margin-bottom: 20px;">
                        <h4 style="color: #083CAE; margin-bottom: 15px;"><i class="fas fa-trophy"></i> Top Contratistas por Gasto</h4>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="padding: 10px; text-align: left; border-bottom: 2px solid #dee2e6;">Contratista</th>
                                        <th style="padding: 10px; text-align: left; border-bottom: 2px solid #dee2e6;">Especialidad</th>
                                        <th style="padding: 10px; text-align: right; border-bottom: 2px solid #dee2e6;">Gasto Total</th>
                                        <th style="padding: 10px; text-align: center; border-bottom: 2px solid #dee2e6;">Proyectos</th>
                                    </tr>
                                </thead>
                                <tbody id="topContratistasBody">
                                    <tr><td colspan="4" style="text-align:center; padding: 20px; color: #6c757d;"><i class="fas fa-spinner fa-spin"></i> Cargando datos...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ALERTAS -->
                    <div style="border: 1px solid #dee2e6; border-radius: 8px; padding: 15px; background: white;">
                        <h4 style="color: #083CAE; margin-bottom: 15px;">
                            <i class="fas fa-bell"></i> Alertas Recientes
                            <span id="alertasNoLeidas" style="background: #dc3545; color: white; padding: 2px 12px; border-radius: 10px; font-size: 12px; margin-left: 10px;">0</span>
                        </h4>
                        <div id="listaAlertas" style="max-height: 200px; overflow-y: auto;">
                            <p style="text-align:center; color: #6c757d; padding: 20px;"><i class="fas fa-spinner fa-spin"></i> Cargando alertas...</p>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- SECCIÓN: LISTADO DE CONTRATISTAS -->
                <!-- ========================================== -->
                <div id="seccion-listado" class="seccion-contenido">
                    <!-- Botones de acción -->
                    <div style="display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                        <button onclick="abrirModal('modalNuevoContratista')" style="background-color: #083CAE; color: white; border: none; border-radius: 6px; padding: 8px 20px; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-plus"></i> Nuevo Contratista
                        </button>
                        <button onclick="cambiarSeccion('dashboard')" style="background-color: #17a2b8; color: white; border: none; border-radius: 6px; padding: 8px 20px; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-chart-pie"></i> Dashboard
                        </button>
                        <button onclick="cambiarSeccion('asignaciones')" style="background-color: #ffc107; color: #212529; border: none; border-radius: 6px; padding: 8px 20px; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-project-diagram"></i> Asignaciones
                        </button>
                    </div>

                    <!-- Filtros -->
                    <div style="display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap; align-items: center;">
                        <div style="flex: 1; min-width: 200px; position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                            <input type="text" id="searchContratista" placeholder="Buscar contratista..." style="width: 100%; padding: 8px 8px 8px 35px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                        </div>
                        <select id="filtroEspecialidad" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px;">
                            <option value="">Todas las especialidades</option>
                            <option value="construccion">Construcción</option>
                            <option value="electricidad">Electricidad</option>
                            <option value="plomeria">Plomería</option>
                            <option value="acabados">Acabados</option>
                            <option value="estructuras">Estructuras</option>
                            <option value="instalaciones">Instalaciones</option>
                            <option value="pintura">Pintura</option>
                        </select>
                        <select id="filtroRiesgo" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px;">
                            <option value="">Todos los riesgos</option>
                            <option value="bajo">Bajo</option>
                            <option value="medio">Medio</option>
                            <option value="alto">Alto</option>
                        </select>
                        <select id="filtroStatus" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px;">
                            <option value="">Todos los status</option>
                            <option value="1">Activos</option>
                            <option value="0">Inactivos</option>
                        </select>
                        <button onclick="limpiarFiltros()" style="background-color: #6c757d; color: white; border: none; border-radius: 4px; padding: 8px 20px; cursor: pointer;">
                            <i class="fas fa-undo"></i> Limpiar
                        </button>
                    </div>

                    <!-- Tabla -->
                    <div style="border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto; background: white; margin-top: 10px;">
                        <table class="table table-bordered" id="tablaContratistas" style="width: 100%; font-size: 12px; margin: 0;">
                            <thead style="background-color: #083CAE; color: white; position: sticky; top: 0; z-index: 10;">
                                <tr>
                                    <th style="padding: 12px 6px; text-align: center;">Código</th>
                                    <th style="padding: 12px 6px; text-align: left;">Nombre</th>
                                    <th style="padding: 12px 6px; text-align: left;">Especialidad</th>
                                    <th style="padding: 12px 6px; text-align: center;">Riesgo</th>
                                    <th style="padding: 12px 6px; text-align: center;">Calificación</th>
                                    <th style="padding: 12px 6px; text-align: center;">Proyectos</th>
                                    <th style="padding: 12px 6px; text-align: right;">Presupuesto</th>
                                    <th style="padding: 12px 6px; text-align: right;">Gasto</th>
                                    <th style="padding: 12px 6px; text-align: center;">Status</th>
                                    <th style="padding: 12px 6px; text-align: center; min-width: 180px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaContratistasBody">
                                <tr><td colspan="10" style="text-align:center; padding:40px; color:#6c757d;"><i class="fas fa-spinner fa-spin"></i> Cargando datos...</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                        <span style="color: #6c757d; font-size: 12px;" id="paginacionInfoContratistas">Mostrando 0-0 de 0 registros</span>
                        <div style="display: flex; gap: 5px;">
                            <button id="btnPrevContratistas" style="padding: 5px 12px; border: 1px solid #ddd; border-radius: 4px; background: white; cursor: pointer;">Anterior</button>
                            <span id="paginaActualContratistas" style="padding: 5px 12px; background-color: #083CAE; color: white; border-radius: 4px;">1</span>
                            <button id="btnNextContratistas" style="padding: 5px 12px; border: 1px solid #ddd; border-radius: 4px; background: white; cursor: pointer;">Siguiente</button>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- SECCIÓN: ASIGNACIONES -->
                <!-- ========================================== -->
                <div id="seccion-asignaciones" class="seccion-contenido" style="display: none;">
                    <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                        <button onclick="abrirModalAsignacion()" style="background-color: #083CAE; color: white; border: none; border-radius: 6px; padding: 8px 20px; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-plus"></i> Nueva Asignación
                        </button>
                    </div>

                    <div style="display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap; align-items: center;">
                        <select id="filtroProyectoAsignacion" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px;">
                            <option value="">Todos los proyectos</option>
                        </select>
                        <select id="filtroStatusAsignacion" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px;">
                            <option value="">Todos los status</option>
                            <option value="asignado">Asignado</option>
                            <option value="en_progreso">En Progreso</option>
                            <option value="pausado">Pausado</option>
                            <option value="finalizado">Finalizado</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                        <div style="flex: 1; min-width: 200px; position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                            <input type="text" id="searchAsignacion" placeholder="Buscar..." style="width: 100%; padding: 8px 8px 8px 35px; border: 1px solid #ddd; border-radius: 4px;">
                        </div>
                    </div>

                    <div style="border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto; background: white;">
                        <table class="table table-bordered" id="tablaAsignaciones" style="width: 100%; font-size: 12px; margin: 0;">
                            <thead style="background-color: #083CAE; color: white;">
                                <tr>
                                    <th style="padding: 12px 6px; text-align: left;">Contratista</th>
                                    <th style="padding: 12px 6px; text-align: left;">Proyecto</th>
                                    <th style="padding: 12px 6px; text-align: left;">Sección</th>
                                    <th style="padding: 12px 6px; text-align: right;">Presupuesto</th>
                                    <th style="padding: 12px 6px; text-align: right;">Gasto</th>
                                    <th style="padding: 12px 6px; text-align: center;">Avance</th>
                                    <th style="padding: 12px 6px; text-align: center;">Status</th>
                                    <th style="padding: 12px 6px; text-align: center;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaAsignacionesBody">
                                <tr><td colspan="8" style="text-align:center; padding:40px; color:#6c757d;"><i class="fas fa-spinner fa-spin"></i> Cargando datos...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- SECCIÓN: GASTOS -->
                <!-- ========================================== -->
                <div id="seccion-gastos" class="seccion-contenido" style="display: none;">
                    <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                        <button onclick="abrirModal('modalGasto')" style="background-color: #28a745; color: white; border: none; border-radius: 6px; padding: 8px 20px; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-plus-circle"></i> Nuevo Gasto
                        </button>
                    </div>

                    <div style="display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap; align-items: center;">
                        <select id="filtroTipoGasto" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px;">
                            <option value="">Todos los tipos</option>
                            <option value="material">Materiales</option>
                            <option value="mano_obra">Mano de Obra</option>
                            <option value="maquinaria">Maquinaria</option>
                            <option value="subcontrato">Subcontrato</option>
                            <option value="otros">Otros</option>
                        </select>
                        <select id="filtroStatusPagoGasto" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px;">
                            <option value="">Todos los status</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="pagado">Pagado</option>
                        </select>
                        <div style="flex: 1; min-width: 200px; position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                            <input type="text" id="searchGasto" placeholder="Buscar gasto..." style="width: 100%; padding: 8px 8px 8px 35px; border: 1px solid #ddd; border-radius: 4px;">
                        </div>
                    </div>

                    <div style="border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto; background: white;">
                        <table class="table table-bordered" id="tablaGastos" style="width: 100%; font-size: 12px; margin: 0;">
                            <thead style="background-color: #083CAE; color: white;">
                                <tr>
                                    <th style="padding: 12px 6px; text-align: center;">Fecha</th>
                                    <th style="padding: 12px 6px; text-align: left;">Contratista</th>
                                    <th style="padding: 12px 6px; text-align: left;">Concepto</th>
                                    <th style="padding: 12px 6px; text-align: left;">Tipo</th>
                                    <th style="padding: 12px 6px; text-align: right;">Monto</th>
                                    <th style="padding: 12px 6px; text-align: center;">Status</th>
                                    <th style="padding: 12px 6px; text-align: center;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaGastosBody">
                                <tr><td colspan="7" style="text-align:center; padding:40px; color:#6c757d;"><i class="fas fa-spinner fa-spin"></i> Cargando datos...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- SECCIÓN: PAGOS -->
                <!-- ========================================== -->
                <div id="seccion-pagos" class="seccion-contenido" style="display: none;">
                    <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                        <button onclick="abrirModal('modalPago')" style="background-color: #083CAE; color: white; border: none; border-radius: 6px; padding: 8px 20px; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-plus"></i> Nuevo Pago
                        </button>
                    </div>

                    <div style="display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap; align-items: center;">
                        <select id="filtroFormaPago" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px;">
                            <option value="">Todas las formas</option>
                            <option value="transferencia">Transferencia</option>
                            <option value="cheque">Cheque</option>
                            <option value="efectivo">Efectivo</option>
                        </select>
                        <input type="date" id="filtroFechaPago" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px;">
                        <div style="flex: 1; min-width: 200px; position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                            <input type="text" id="searchPago" placeholder="Buscar pago..." style="width: 100%; padding: 8px 8px 8px 35px; border: 1px solid #ddd; border-radius: 4px;">
                        </div>
                    </div>

                    <div style="border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto; background: white;">
                        <table class="table table-bordered" id="tablaPagos" style="width: 100%; font-size: 12px; margin: 0;">
                            <thead style="background-color: #083CAE; color: white;">
                                <tr>
                                    <th style="padding: 12px 6px; text-align: center;">Folio</th>
                                    <th style="padding: 12px 6px; text-align: center;">Fecha</th>
                                    <th style="padding: 12px 6px; text-align: left;">Contratista</th>
                                    <th style="padding: 12px 6px; text-align: right;">Monto</th>
                                    <th style="padding: 12px 6px; text-align: center;">Forma</th>
                                    <th style="padding: 12px 6px; text-align: center;">Referencia</th>
                                    <th style="padding: 12px 6px; text-align: center;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaPagosBody">
                                <tr><td colspan="7" style="text-align:center; padding:40px; color:#6c757d;"><i class="fas fa-spinner fa-spin"></i> Cargando datos...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- ========================================== -->
<!-- MODALES -->
<!-- ========================================== -->

<!-- MODAL: Nuevo Contratista -->
<div id="modalNuevoContratista" style="display: none; position: fixed; z-index: 10001; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); overflow-y: auto;">
    <div style="background-color: white; margin: 2% auto; width: 95%; max-width: 700px; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="background: linear-gradient(135deg, #083CAE 0%, #0a4bc9 100%); color: white; padding: 20px 25px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <i class="fas fa-user-plus" style="font-size: 24px; margin-right: 10px;"></i>
                <span style="font-size: 20px; font-weight: bold;">Nuevo Contratista</span>
            </div>
            <button onclick="cerrarModal('modalNuevoContratista')" style="background: none; border: none; color: white; font-size: 32px; cursor: pointer;">&times;</button>
        </div>
        <div style="padding: 25px;">
            <form id="formNuevoContratista">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px; color: #dc3545;">Código *</label>
                        <input type="text" id="nuevo_codigo" name="codigo" class="form-control" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                    </div>
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px; color: #dc3545;">Nombre Comercial *</label>
                        <input type="text" id="nuevo_nombre_comercial" name="nombre_comercial" class="form-control" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                    </div>
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px; color: #dc3545;">Especialidad *</label>
                        <select id="nuevo_especialidad" name="especialidad" class="form-control" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                            <option value="">Seleccionar...</option>
                            <option value="construccion">Construcción</option>
                            <option value="electricidad">Electricidad</option>
                            <option value="plomeria">Plomería</option>
                            <option value="acabados">Acabados</option>
                            <option value="estructuras">Estructuras</option>
                            <option value="instalaciones">Instalaciones</option>
                            <option value="pintura">Pintura</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px; color: #dc3545;">Nivel de Riesgo *</label>
                        <select id="nuevo_nivel_riesgo" name="nivel_riesgo" class="form-control" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                            <option value="bajo">Bajo</option>
                            <option value="medio">Medio</option>
                            <option value="alto">Alto</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px;">Registro IMSS</label>
                        <input type="text" id="nuevo_registro_imss" name="registro_imss" class="form-control" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                    </div>
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px;">Licencia de Obra</label>
                        <input type="text" id="nuevo_licencia_obra" name="licencia_obra" class="form-control" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                    </div>
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px;">RFC</label>
                        <input type="text" id="nuevo_rfc" name="rfc" class="form-control" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                    </div>
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px;">Email</label>
                        <input type="email" id="nuevo_email" name="email" class="form-control" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                    </div>
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px;">Teléfono</label>
                        <input type="text" id="nuevo_telefono" name="telefono" class="form-control" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                    </div>
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px;">Fecha Registro</label>
                        <input type="date" id="nuevo_fecha_registro" name="fecha_registro" class="form-control" value="{{ date('Y-m-d') }}" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                    </div>
                </div>
                <div style="margin-top:15px;">
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                        <input type="hidden" name="activo" value="0">
                        <input type="checkbox" id="nuevo_activo" name="activo" value="1" checked> Activo
                    </label>
                </div>
                <div id="erroresValidacion" style="margin-top:15px; padding:12px; background:#f8d7da; border:1px solid #f5c6cb; border-radius:6px; color:#721c24; display:none;">
                    <strong><i class="fas fa-exclamation-triangle"></i> Errores de validación:</strong>
                    <ul id="listaErrores" style="margin:5px 0 0 15px; font-size:13px;"></ul>
                </div>
            </form>
        </div>
        <div style="padding: 20px 25px; background-color: #f8f9fa; border-radius: 0 0 12px 12px; display: flex; justify-content: flex-end; gap: 12px;">
            <button onclick="cerrarModal('modalNuevoContratista')" style="background-color: #6c757d; color: white; border: none; padding: 10px 25px; border-radius: 6px; cursor: pointer;">Cancelar</button>
            <button onclick="guardarContratista()" id="btnGuardarContratista" style="background-color: #28a745; color: white; border: none; padding: 10px 25px; border-radius: 6px; cursor: pointer;">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </div>
</div>

<!-- MODAL: Editar Contratista -->
<div id="modalEditarContratista" style="display: none; position: fixed; z-index: 10001; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); overflow-y: auto;">
    <div style="background-color: white; margin: 2% auto; width: 95%; max-width: 700px; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="background: linear-gradient(135deg, #083CAE 0%, #0a4bc9 100%); color: white; padding: 20px 25px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <i class="fas fa-edit" style="font-size: 24px; margin-right: 10px;"></i>
                <span style="font-size: 20px; font-weight: bold;">Editar Contratista</span>
            </div>
            <button onclick="cerrarModal('modalEditarContratista')" style="background: none; border: none; color: white; font-size: 32px; cursor: pointer;">&times;</button>
        </div>
        <div style="padding: 25px;">
            <form id="formEditarContratista">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_id" name="id">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px;">Código</label>
                        <input type="text" id="edit_codigo" class="form-control" disabled style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; background:#f5f5f5;">
                    </div>
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px; color: #dc3545;">Nombre Comercial *</label>
                        <input type="text" id="edit_nombre_comercial" name="nombre_comercial" class="form-control" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                    </div>
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px; color: #dc3545;">Especialidad *</label>
                        <select id="edit_especialidad" name="especialidad" class="form-control" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                            <option value="construccion">Construcción</option>
                            <option value="electricidad">Electricidad</option>
                            <option value="plomeria">Plomería</option>
                            <option value="acabados">Acabados</option>
                            <option value="estructuras">Estructuras</option>
                            <option value="instalaciones">Instalaciones</option>
                            <option value="pintura">Pintura</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px; color: #dc3545;">Nivel de Riesgo *</label>
                        <select id="edit_nivel_riesgo" name="nivel_riesgo" class="form-control" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                            <option value="bajo">Bajo</option>
                            <option value="medio">Medio</option>
                            <option value="alto">Alto</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px;">Registro IMSS</label>
                        <input type="text" id="edit_registro_imss" name="registro_imss" class="form-control" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                    </div>
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px;">Licencia de Obra</label>
                        <input type="text" id="edit_licencia_obra" name="licencia_obra" class="form-control" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                    </div>
                </div>
                <div style="margin-top:15px;">
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                        <input type="hidden" name="activo" value="0">
                        <input type="checkbox" id="edit_activo" name="activo" value="1"> Activo
                    </label>
                </div>
                <div id="erroresValidacionEdit" style="margin-top:15px; padding:12px; background:#f8d7da; border:1px solid #f5c6cb; border-radius:6px; color:#721c24; display:none;">
                    <strong><i class="fas fa-exclamation-triangle"></i> Errores de validación:</strong>
                    <ul id="listaErroresEdit" style="margin:5px 0 0 15px; font-size:13px;"></ul>
                </div>
            </form>
        </div>
        <div style="padding: 20px 25px; background-color: #f8f9fa; border-radius: 0 0 12px 12px; display: flex; justify-content: flex-end; gap: 12px;">
            <button onclick="cerrarModal('modalEditarContratista')" style="background-color: #6c757d; color: white; border: none; padding: 10px 25px; border-radius: 6px; cursor: pointer;">Cancelar</button>
            <button onclick="guardarContratistaEdit()" style="background-color: #ffc107; color: #212529; border: none; padding: 10px 25px; border-radius: 6px; cursor: pointer;">
                <i class="fas fa-save"></i> Actualizar
            </button>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: ASIGNACIÓN - CON SELECTOR DE CONTRATISTA -->
<!-- ========================================== -->
<div id="modalAsignacion" style="display: none; position: fixed; z-index: 10001; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); overflow-y: auto;">
    <div style="background-color: white; margin: 2% auto; width: 95%; max-width: 700px; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="background: linear-gradient(135deg, #083CAE 0%, #0a4bc9 100%); color: white; padding: 20px 25px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <i class="fas fa-project-diagram" style="font-size: 24px; margin-right: 10px;"></i>
                <span style="font-size: 20px; font-weight: bold;">Asignar Contratista a Proyecto</span>
            </div>
            <button onclick="cerrarModal('modalAsignacion')" style="background: none; border: none; color: white; font-size: 32px; cursor: pointer;">&times;</button>
        </div>
        <div style="padding: 25px;">
            <form id="formAsignacion">
                @csrf
                <input type="hidden" id="asignacion_contratista_id" name="contratista_id">
                
                <!-- CONTRATISTA - SELECTOR -->
                <div style="margin-bottom: 20px; padding: 15px; background: linear-gradient(135deg, #e8f0fe 0%, #d4e0f7 100%); border-radius: 8px; border-left: 5px solid #083CAE;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-user-tie" style="font-size: 24px; color: #083CAE;"></i>
                        <div style="flex: 1;">
                            <div style="font-size: 12px; color: #6c757d; text-transform: uppercase; font-weight: 600;">Seleccionar Contratista *</div>
                            <select id="asignacion_contratista_select" name="contratista_id" class="form-control" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px; background:white;">
                                <option value="">Seleccionar contratista...</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <!-- Proyecto -->
                    <div style="grid-column: span 2;">
                        <label style="display:block; font-weight:600; margin-bottom:5px; color: #dc3545;">
                            <i class="fas fa-building"></i> Proyecto *
                        </label>
                        <select id="asignacion_proyecto" name="proyecto_id" class="form-control" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
                            <option value="">Cargando proyectos...</option>
                        </select>
                        <small style="color:#6c757d; font-size:11px;">Selecciona el proyecto donde se asignará el contratista</small>
                    </div>
                    
                    <!-- Partida -->
                    <div style="grid-column: span 2;">
                        <label style="display:block; font-weight:600; margin-bottom:5px;">
                            <i class="fas fa-list"></i> Partida
                        </label>
                        <select id="asignacion_partida" name="partida_id" class="form-control" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
                            <option value="">Seleccionar partida...</option>
                        </select>
                        <small style="color:#6c757d; font-size:11px;">Opcional - Selecciona una partida específica del proyecto</small>
                    </div>
                    
                    <!-- Sección -->
                    <div style="grid-column: span 2;">
                        <label style="display:block; font-weight:600; margin-bottom:5px;">
                            <i class="fas fa-layer-group"></i> Sección
                        </label>
                        <input type="text" name="seccion" class="form-control" placeholder="Ej: Cimentación, Estructura, Instalaciones..." style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
                        <small style="color:#6c757d; font-size:11px;">Opcional - Especifica la sección del proyecto</small>
                    </div>
                    
                    <!-- Presupuesto Asignado -->
                    <div style="grid-column: span 2;">
                        <label style="display:block; font-weight:600; margin-bottom:5px; color: #dc3545;">
                            <i class="fas fa-money-bill-wave"></i> Presupuesto Asignado *
                        </label>
                        <div style="position: relative;">
                            <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-weight: bold; color: #6c757d;">$</span>
                            <input type="number" name="presupuesto_asignado" class="form-control" step="0.01" min="0" required placeholder="0.00" style="width:100%; padding:10px 10px 10px 30px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
                        </div>
                        <small style="color:#6c757d; font-size:11px;">Monto total asignado al contratista para este proyecto</small>
                    </div>
                    
                    <!-- Fecha Asignación -->
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px; color: #dc3545;">
                            <i class="fas fa-calendar-plus"></i> Fecha Asignación *
                        </label>
                        <input type="date" name="fecha_asignacion" class="form-control" value="{{ date('Y-m-d') }}" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
                    </div>
                    
                    <!-- Fecha Inicio -->
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px;">
                            <i class="fas fa-play"></i> Fecha Inicio
                        </label>
                        <input type="date" name="fecha_inicio" class="form-control" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
                        <small style="color:#6c757d; font-size:11px;">Fecha en que inicia el trabajo</small>
                    </div>
                    
                    <!-- Fecha Fin -->
                    <div style="grid-column: span 2;">
                        <label style="display:block; font-weight:600; margin-bottom:5px;">
                            <i class="fas fa-stop"></i> Fecha Fin
                        </label>
                        <input type="date" name="fecha_fin" class="form-control" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
                        <small style="color:#6c757d; font-size:11px;">Fecha estimada de finalización</small>
                    </div>
                    
                    <!-- Condiciones de Pago -->
                    <div style="grid-column: span 2;">
                        <label style="display:block; font-weight:600; margin-bottom:5px;">
                            <i class="fas fa-file-contract"></i> Condiciones de Pago
                        </label>
                        <textarea name="condiciones_pago" class="form-control" rows="2" placeholder="Ej: 30% anticipo, 40% al 50% de avance, 30% al finalizar" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px;"></textarea>
                    </div>
                </div>
            </form>
        </div>
        <div style="padding: 20px 25px; background-color: #f8f9fa; border-radius: 0 0 12px 12px; display: flex; justify-content: flex-end; gap: 12px;">
            <button onclick="cerrarModal('modalAsignacion')" style="background-color: #6c757d; color: white; border: none; padding: 10px 25px; border-radius: 6px; cursor: pointer;">
                <i class="fas fa-times"></i> Cancelar
            </button>
            <button onclick="guardarAsignacion()" style="background-color: #083CAE; color: white; border: none; padding: 10px 25px; border-radius: 6px; cursor: pointer;">
                <i class="fas fa-save"></i> Asignar Contratista
            </button>
        </div>
    </div>
</div>

<!-- MODAL: Gasto -->
<div id="modalGasto" style="display: none; position: fixed; z-index: 10001; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); overflow-y: auto;">
    <div style="background-color: white; margin: 2% auto; width: 95%; max-width: 600px; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="background: linear-gradient(135deg, #28a745 0%, #218838 100%); color: white; padding: 20px 25px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <i class="fas fa-plus-circle" style="font-size: 24px; margin-right: 10px;"></i>
                <span style="font-size: 20px; font-weight: bold;">Registrar Gasto</span>
            </div>
            <button onclick="cerrarModal('modalGasto')" style="background: none; border: none; color: white; font-size: 32px; cursor: pointer;">&times;</button>
        </div>
        <div style="padding: 25px;">
            <form id="formGasto">
                @csrf
                <input type="hidden" id="gasto_asignacion_id" name="asignacion_id">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div style="grid-column: span 2;">
                        <label style="display:block; font-weight:600; margin-bottom:5px; color: #dc3545;">Tipo de Gasto *</label>
                        <select name="tipo_gasto" class="form-control" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                            <option value="">Seleccionar...</option>
                            <option value="material">Materiales</option>
                            <option value="mano_obra">Mano de Obra</option>
                            <option value="maquinaria">Maquinaria</option>
                            <option value="subcontrato">Subcontrato</option>
                            <option value="otros">Otros</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px; color: #dc3545;">Fecha del Gasto *</label>
                        <input type="date" name="fecha_gasto" class="form-control" value="{{ date('Y-m-d') }}" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                    </div>
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px; color: #dc3545;">Monto *</label>
                        <input type="number" name="monto" class="form-control" step="0.01" min="0.01" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                    </div>
                    <div style="grid-column: span 2;">
                        <label style="display:block; font-weight:600; margin-bottom:5px; color: #dc3545;">Concepto *</label>
                        <input type="text" name="concepto" class="form-control" required placeholder="Descripción breve" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                    </div>
                    <div style="grid-column: span 2;">
                        <label style="display:block; font-weight:600; margin-bottom:5px;">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="2" placeholder="Detalles adicionales" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;"></textarea>
                    </div>
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px;">Factura</label>
                        <input type="text" name="factura" class="form-control" placeholder="Número de factura" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                    </div>
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px;">Proveedor Externo</label>
                        <input type="text" name="proveedor_externo" class="form-control" placeholder="Nombre del proveedor" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                    </div>
                </div>
                <div id="infoAsignacionGasto" style="margin-top:15px; padding:12px; background-color: #e8f0fe; border-radius:6px; font-size:13px;">
                    <i class="fas fa-info-circle"></i> <span id="infoAsignacionTexto">Cargando información de la asignación...</span>
                </div>
            </form>
        </div>
        <div style="padding: 20px 25px; background-color: #f8f9fa; border-radius: 0 0 12px 12px; display: flex; justify-content: flex-end; gap: 12px;">
            <button onclick="cerrarModal('modalGasto')" style="background-color: #6c757d; color: white; border: none; padding: 10px 25px; border-radius: 6px; cursor: pointer;">Cancelar</button>
            <button onclick="guardarGasto()" style="background-color: #28a745; color: white; border: none; padding: 10px 25px; border-radius: 6px; cursor: pointer;">
                <i class="fas fa-save"></i> Registrar Gasto
            </button>
        </div>
    </div>
</div>

<!-- MODAL: Pago -->
<div id="modalPago" style="display: none; position: fixed; z-index: 10001; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); overflow-y: auto;">
    <div style="background-color: white; margin: 2% auto; width: 95%; max-width: 600px; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="background: linear-gradient(135deg, #083CAE 0%, #0a4bc9 100%); color: white; padding: 20px 25px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <i class="fas fa-money-bill-wave" style="font-size: 24px; margin-right: 10px;"></i>
                <span style="font-size: 20px; font-weight: bold;">Registrar Pago</span>
            </div>
            <button onclick="cerrarModal('modalPago')" style="background: none; border: none; color: white; font-size: 32px; cursor: pointer;">&times;</button>
        </div>
        <div style="padding: 25px;">
            <form id="formPago">
                @csrf
                <input type="hidden" id="pago_contratista_id" name="contratista_id">
                <input type="hidden" id="pago_asignacion_id" name="asignacion_id">
                <input type="hidden" id="pago_gasto_id" name="gasto_id">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px; color: #dc3545;">Fecha de Pago *</label>
                        <input type="date" name="fecha_pago" class="form-control" value="{{ date('Y-m-d') }}" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                    </div>
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px; color: #dc3545;">Monto *</label>
                        <input type="number" name="monto" class="form-control" step="0.01" min="0.01" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                    </div>
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px; color: #dc3545;">Forma de Pago *</label>
                        <select name="forma_pago" class="form-control" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                            <option value="">Seleccionar...</option>
                            <option value="transferencia">Transferencia</option>
                            <option value="cheque">Cheque</option>
                            <option value="efectivo">Efectivo</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px;">Referencia</label>
                        <input type="text" name="referencia" class="form-control" placeholder="Número de referencia" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                    </div>
                    <div style="grid-column: span 2;">
                        <label style="display:block; font-weight:600; margin-bottom:5px;">Observaciones</label>
                        <textarea name="observaciones" class="form-control" rows="2" placeholder="Detalles adicionales" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;"></textarea>
                    </div>
                </div>
                <div id="infoContratistaPago" style="margin-top:15px; padding:12px; background-color: #e8f0fe; border-radius:6px; font-size:13px;">
                    <i class="fas fa-info-circle"></i> <span id="infoContratistaTexto">Cargando información del contratista...</span>
                </div>
            </form>
        </div>
        <div style="padding: 20px 25px; background-color: #f8f9fa; border-radius: 0 0 12px 12px; display: flex; justify-content: flex-end; gap: 12px;">
            <button onclick="cerrarModal('modalPago')" style="background-color: #6c757d; color: white; border: none; padding: 10px 25px; border-radius: 6px; cursor: pointer;">Cancelar</button>
            <button onclick="guardarPago()" style="background-color: #083CAE; color: white; border: none; padding: 10px 25px; border-radius: 6px; cursor: pointer;">
                <i class="fas fa-save"></i> Registrar Pago
            </button>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 20000; justify-content: center; align-items: center;">
    <div style="background: white; padding: 30px; border-radius: 12px; text-align: center;">
        <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #083CAE;"></i>
        <p style="margin-top: 15px;">Procesando...</p>
    </div>
</div>

<style>
    .custom-card { transition: transform 0.2s, box-shadow 0.2s; }
    .custom-card:hover { transform: translateY(-3px); box-shadow: 0 8px 16px rgba(0,0,0,0.1); }
    
    .badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block; }
    .badge-riesgo-bajo { background-color: #d4edda; color: #155724; }
    .badge-riesgo-medio { background-color: #fff3cd; color: #856404; }
    .badge-riesgo-alto { background-color: #f8d7da; color: #721c24; }
    .badge-activo { background-color: #d4edda; color: #155724; }
    .badge-inactivo { background-color: #f8d7da; color: #721c24; }
    .badge-pagado { background-color: #d4edda; color: #155724; }
    .badge-pendiente { background-color: #fff3cd; color: #856404; }
    
    .table td { padding: 10px 6px; vertical-align: middle; }
    #tablaContratistasBody tr:nth-child(even),
    #tablaAsignacionesBody tr:nth-child(even),
    #tablaGastosBody tr:nth-child(even),
    #tablaPagosBody tr:nth-child(even) { background-color: #f8f9fa; }
    #tablaContratistasBody tr:hover,
    #tablaAsignacionesBody tr:hover,
    #tablaGastosBody tr:hover,
    #tablaPagosBody tr:hover { background-color: #e3f2fd; }
    
    .btn-seccion { transition: all 0.3s ease; }
    .btn-seccion:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
    .btn-seccion.active { background-color: #083CAE !important; color: white !important; }
    
    @media (max-width: 768px) {
        div[style*="grid-template-columns: 1fr 1fr"] { grid-template-columns: 1fr !important; }
        .custom-card { flex: 0 1 calc(50% - 15px) !important; }
        .btn-seccion { padding: 6px 12px !important; font-size: 12px !important; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// ============================================
// VARIABLES GLOBALES
// ============================================
let currentPageContratistas = 1;
const rowsPerPageContratistas = 10;
let datosContratistas = [];

// ============================================
// FUNCIONES DE UTILIDAD
// ============================================
function formatCurrency(amount) {
    if (amount === null || amount === undefined) amount = 0;
    return '$' + parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

function showLoading(show) {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) overlay.style.display = show ? 'flex' : 'none';
}

function showError(msg) { 
    Swal.fire({ icon: 'error', title: 'Error', text: msg, confirmButtonColor: '#083CAE' }); 
}

function showSuccess(msg) { 
    Swal.fire({ icon: 'success', title: 'Éxito', text: msg, confirmButtonColor: '#083CAE', timer: 3000, showConfirmButton: false }); 
}

function showValidationErrors(errors) {
    const container = document.getElementById('erroresValidacion');
    const list = document.getElementById('listaErrores');
    if (container && list) {
        container.style.display = 'block';
        list.innerHTML = '';
        for (const [field, messages] of Object.entries(errors)) {
            messages.forEach(msg => {
                const li = document.createElement('li');
                li.textContent = `${field}: ${msg}`;
                list.appendChild(li);
            });
        }
    }
}

function clearValidationErrors() {
    const container = document.getElementById('erroresValidacion');
    if (container) container.style.display = 'none';
}

// ============================================
// NAVEGACIÓN ENTRE SECCIONES
// ============================================
function cambiarSeccion(seccion) {
    console.log('🔄 [cambiarSeccion] Cambiando a:', seccion);
    
    document.querySelectorAll('.seccion-contenido').forEach(el => {
        el.style.display = 'none';
    });
    
    const elemento = document.getElementById('seccion-' + seccion);
    if (elemento) {
        elemento.style.display = 'block';
        console.log('✅ [cambiarSeccion] Sección mostrada:', seccion);
    } else {
        console.error('❌ [cambiarSeccion] Sección no encontrada:', seccion);
    }
    
    document.querySelectorAll('.btn-seccion').forEach(btn => {
        btn.classList.remove('active');
        btn.style.backgroundColor = '#6c757d';
    });
    
    const btn = document.getElementById('btn-' + seccion);
    if (btn) {
        btn.classList.add('active');
        btn.style.backgroundColor = '#083CAE';
    }
    
    // Cargar datos según la sección
    if (seccion === 'listado') {
        console.log('🔄 [cambiarSeccion] Cargando contratistas...');
        cargarContratistas();
    }
    if (seccion === 'dashboard') cargarDashboard();
    if (seccion === 'asignaciones') cargarAsignaciones();
    if (seccion === 'gastos') cargarGastos();
    if (seccion === 'pagos') cargarPagos();
}

// ============================================
// FUNCIONES DE MODALES
// ============================================
function abrirModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
        clearValidationErrors();
    }
}

function cerrarModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        clearValidationErrors();
    }
}

// Cerrar modales con Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('[id^="modal"]').forEach(m => {
            if (m.style.display === 'block') {
                m.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
    }
});

document.querySelectorAll('[id^="modal"]').forEach(m => {
    m.addEventListener('click', function(e) {
        if (e.target === this) {
            this.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });
});

// ============================================
// FUNCIONES DE CONTRATISTAS
// ============================================
function cargarContratistas() {
    console.log('🔄 [cargarContratistas] Iniciando...');
    
    const tbody = document.getElementById('tablaContratistasBody');
    if (!tbody) {
        console.error('❌ [cargarContratistas] tbody no encontrado!');
        return;
    }
    console.log('✅ [cargarContratistas] tbody encontrado');
    
    showLoading(true);
    
    fetch('/proyectos/api/contratistas')
        .then(response => {
            console.log('📡 [cargarContratistas] Status:', response.status);
            if (!response.ok) {
                throw new Error('HTTP error ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('✅ [cargarContratistas] Datos recibidos:', data);
            datosContratistas = data.data || [];
            renderizarTablaContratistas();
            showLoading(false);
        })
        .catch(error => {
            console.error('❌ [cargarContratistas] Error:', error);
            showLoading(false);
            const tbody = document.getElementById('tablaContratistasBody');
            if (tbody) {
                tbody.innerHTML = `<tr><td colspan="10" style="text-align:center; padding:40px; color:#dc3545;">
                    <i class="fas fa-exclamation-triangle"></i> Error al cargar datos: ${error.message}
                </td></tr>`;
            }
            showError('Error al cargar los contratistas');
        });
}

function renderizarTablaContratistas() {
    console.log('🔄 [renderizarTablaContratistas] Iniciando...');
    const tbody = document.getElementById('tablaContratistasBody');
    if (!tbody) {
        console.error('❌ [renderizarTablaContratistas] tbody no encontrado!');
        return;
    }
    
    console.log('📊 [renderizarTablaContratistas] Datos a renderizar:', datosContratistas);
    
    if (datosContratistas.length === 0) {
        console.warn('⚠️ [renderizarTablaContratistas] No hay contratistas');
        tbody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding:40px; color:#6c757d;"><i class="fas fa-info-circle"></i> No hay contratistas registrados</td></tr>';
        actualizarPaginacionContratistas(0);
        return;
    }
    
    const start = (currentPageContratistas - 1) * rowsPerPageContratistas;
    const end = start + rowsPerPageContratistas;
    const pageData = datosContratistas.slice(start, end);
    
    console.log(`📊 [renderizarTablaContratistas] Mostrando ${pageData.length} de ${datosContratistas.length} contratistas`);
    
    let html = '';
    pageData.forEach((c, index) => {
        console.log(`🔍 [renderizarTablaContratistas] Contratista ${index + 1}:`, c.id, c.nombre_comercial);
        
        const riesgoBadge = 'badge-riesgo-' + c.nivel_riesgo;
        const statusBadge = c.activo ? 'badge-activo' : 'badge-inactivo';
        const statusText = c.activo ? 'Activo' : 'Inactivo';
        
        let calificacionHtml = '';
        if (c.calificacion > 0) {
            const color = c.calificacion >= 8 ? 'success' : (c.calificacion >= 6 ? 'warning' : 'danger');
            calificacionHtml = `<div style="background:#e9ecef; border-radius:4px; height:20px; overflow:hidden; position:relative; width:100%;">
                <div style="background:${color === 'success' ? '#28a745' : (color === 'warning' ? '#ffc107' : '#dc3545')}; width:${c.calificacion * 10}%; height:100%; display:flex; align-items:center; justify-content:center; font-size:11px; color:white; font-weight:bold;">${c.calificacion}/10</div>
            </div>`;
        } else {
            calificacionHtml = '<span style="color:#6c757d; font-size:11px;">Sin calificar</span>';
        }
        
        html += `
            <tr>
                <td style="padding:10px 6px; text-align:center; font-weight:bold;">${c.codigo}</td>
                <td style="padding:10px 6px;">${c.nombre_comercial}</td>
                <td style="padding:10px 6px;">${c.especialidad}</td>
                <td style="padding:10px 6px; text-align:center;"><span class="badge ${riesgoBadge}">${c.nivel_riesgo.charAt(0).toUpperCase() + c.nivel_riesgo.slice(1)}</span></td>
                <td style="padding:10px 6px; text-align:center;">${calificacionHtml}</td>
                <td style="padding:10px 6px; text-align:center;"><span style="background:#17a2b8; color:white; padding:2px 12px; border-radius:10px;">${c.proyectos_activos || 0}</span></td>
                <td style="padding:10px 6px; text-align:right; color:#083CAE; font-weight:600;">${formatCurrency(c.presupuesto_total || 0)}</td>
                <td style="padding:10px 6px; text-align:right; color:#dc3545; font-weight:600;">${formatCurrency(c.gasto_total || 0)}</td>
                <td style="padding:10px 6px; text-align:center;"><span class="badge ${statusBadge}"><i class="fas ${c.activo ? 'fa-check-circle' : 'fa-times-circle'}"></i> ${statusText}</span></td>
                <td style="padding:10px 6px; text-align:center;">
                    <div style="display:flex; gap:5px; justify-content:center; flex-wrap:wrap;">
                        <button onclick="verContratista(${c.id})" style="background:#083CAE; color:white; border:none; border-radius:4px; padding:4px 8px; cursor:pointer;" title="Ver"><i class="fas fa-eye"></i></button>
                        <button onclick="editarContratista(${c.id})" style="background:#ffc107; color:#212529; border:none; border-radius:4px; padding:4px 8px; cursor:pointer;" title="Editar"><i class="fas fa-edit"></i></button>
                        <button onclick="abrirModalAsignacion(${c.id})" 
                                style="background:#17a2b8; color:white; border:none; border-radius:4px; padding:4px 8px; cursor:pointer;" 
                                title="Asignar a proyecto">
                            <i class="fas fa-project-diagram"></i>
                        </button>
                        <button onclick="eliminarContratista(${c.id})" style="background:#dc3545; color:white; border:none; border-radius:4px; padding:4px 8px; cursor:pointer;" title="Eliminar"><i class="fas fa-trash"></i></button>
                    </div>
                </td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
    console.log('✅ [renderizarTablaContratistas] Tabla renderizada con éxito');
    actualizarPaginacionContratistas(datosContratistas.length);
}

function actualizarPaginacionContratistas(total) {
    const totalPages = Math.ceil(total / rowsPerPageContratistas);
    const start = (currentPageContratistas - 1) * rowsPerPageContratistas + 1;
    const end = Math.min(currentPageContratistas * rowsPerPageContratistas, total);
    
    document.getElementById('paginaActualContratistas').textContent = currentPageContratistas;
    document.getElementById('paginacionInfoContratistas').textContent = `Mostrando ${total === 0 ? 0 : start}-${end} de ${total} registros`;
    
    document.getElementById('btnPrevContratistas').disabled = currentPageContratistas <= 1;
    document.getElementById('btnNextContratistas').disabled = currentPageContratistas >= totalPages;
}

document.getElementById('btnPrevContratistas')?.addEventListener('click', function() {
    if (currentPageContratistas > 1) {
        currentPageContratistas--;
        renderizarTablaContratistas();
    }
});

document.getElementById('btnNextContratistas')?.addEventListener('click', function() {
    const totalPages = Math.ceil(datosContratistas.length / rowsPerPageContratistas);
    if (currentPageContratistas < totalPages) {
        currentPageContratistas++;
        renderizarTablaContratistas();
    }
});

// ============================================
// FUNCIÓN GUARDAR CONTRATISTA
// ============================================
function guardarContratista() {
    const form = document.getElementById('formNuevoContratista');
    const formData = new FormData(form);
    
    const activoCheckbox = document.getElementById('nuevo_activo');
    if (activoCheckbox) {
        formData.set('activo', activoCheckbox.checked ? '1' : '0');
    }
    
    showLoading(true);
    document.getElementById('btnGuardarContratista').disabled = true;
    clearValidationErrors();
    
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    fetch('/proyectos/api/contratistas', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                throw err;
            });
        }
        return response.json();
    })
    .then(data => {
        showLoading(false);
        document.getElementById('btnGuardarContratista').disabled = false;
        
        if (data.message) {
            showSuccess(data.message);
            cerrarModal('modalNuevoContratista');
            form.reset();
            cargarContratistas();
            cargarDashboard();
        } else if (data.errors) {
            showValidationErrors(data.errors);
            const errorMessages = Object.values(data.errors).flat().join('\n');
            showError('Errores de validación:\n' + errorMessages);
        } else {
            showError('Error al guardar el contratista');
        }
    })
    .catch(error => {
        showLoading(false);
        document.getElementById('btnGuardarContratista').disabled = false;
        console.error('Error completo:', error);
        
        if (error.errors) {
            showValidationErrors(error.errors);
            const errorMessages = Object.values(error.errors).flat().join('\n');
            showError('Errores de validación:\n' + errorMessages);
        } else {
            showError('Error al guardar: ' + (error.message || 'Error desconocido'));
        }
    });
}

function guardarContratistaEdit() {
    const form = document.getElementById('formEditarContratista');
    const formData = new FormData(form);
    const id = document.getElementById('edit_id').value;
    
    const activoCheckbox = document.getElementById('edit_activo');
    if (activoCheckbox) {
        formData.set('activo', activoCheckbox.checked ? '1' : '0');
    }
    
    showLoading(true);
    clearValidationErrors();
    
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    fetch('/proyectos/api/contratistas/' + id, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                throw err;
            });
        }
        return response.json();
    })
    .then(data => {
        showLoading(false);
        if (data.message) {
            showSuccess(data.message);
            cerrarModal('modalEditarContratista');
            cargarContratistas();
            cargarDashboard();
        } else if (data.errors) {
            showValidationErrors(data.errors);
            showError('Errores de validación:\n' + Object.values(data.errors).flat().join('\n'));
        } else {
            showError('Error al actualizar el contratista');
        }
    })
    .catch(error => {
        showLoading(false);
        console.error('Error:', error);
        if (error.errors) {
            showValidationErrors(error.errors);
            showError('Errores de validación:\n' + Object.values(error.errors).flat().join('\n'));
        } else {
            showError('Error al actualizar: ' + (error.message || 'Error desconocido'));
        }
    });
}

function verContratista(id) {
    showLoading(true);
    fetch('/proyectos/api/contratistas/' + id)
        .then(response => response.json())
        .then(data => {
            showLoading(false);
            const c = data.contratista;
            Swal.fire({
                title: c.nombre_comercial,
                html: `
                    <div style="text-align:left;">
                        <p><strong>Código:</strong> ${c.codigo}</p>
                        <p><strong>Especialidad:</strong> ${c.especialidad}</p>
                        <p><strong>Riesgo:</strong> ${c.nivel_riesgo}</p>
                        <p><strong>Calificación:</strong> ${c.calificacion > 0 ? c.calificacion + '/10' : 'Sin calificar'}</p>
                        <p><strong>Proyectos Activos:</strong> ${data.estadisticas.proyectos_activos}</p>
                        <p><strong>Presupuesto:</strong> ${formatCurrency(data.estadisticas.presupuesto_total)}</p>
                        <p><strong>Gasto:</strong> ${formatCurrency(data.estadisticas.gasto_total)}</p>
                        <p><strong>Saldo:</strong> ${formatCurrency(data.estadisticas.saldo_disponible)}</p>
                        <p><strong>Status:</strong> ${c.activo ? 'Activo' : 'Inactivo'}</p>
                    </div>
                `,
                icon: 'info',
                confirmButtonColor: '#083CAE',
                width: 600
            });
        })
        .catch(() => {
            showLoading(false);
            showError('No se pudo cargar la información');
        });
}

function editarContratista(id) {
    showLoading(true);
    fetch('/proyectos/api/contratistas/' + id)
        .then(response => response.json())
        .then(data => {
            showLoading(false);
            const c = data.contratista;
            document.getElementById('edit_id').value = c.id;
            document.getElementById('edit_codigo').value = c.codigo;
            document.getElementById('edit_nombre_comercial').value = c.nombre_comercial;
            document.getElementById('edit_especialidad').value = c.especialidad;
            document.getElementById('edit_nivel_riesgo').value = c.nivel_riesgo;
            document.getElementById('edit_registro_imss').value = c.registro_imss || '';
            document.getElementById('edit_licencia_obra').value = c.licencia_obra || '';
            document.getElementById('edit_activo').checked = c.activo;
            abrirModal('modalEditarContratista');
        })
        .catch(() => {
            showLoading(false);
            showError('No se pudo cargar la información');
        });
}

function eliminarContratista(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Deseas eliminar este contratista?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            showLoading(true);
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            fetch('/proyectos/api/contratistas/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token
                }
            })
            .then(response => response.json())
            .then(data => {
                showLoading(false);
                showSuccess(data.message);
                cargarContratistas();
                cargarDashboard();
            })
            .catch(() => {
                showLoading(false);
                showError('No se pudo eliminar el contratista');
            });
        }
    });
}

function limpiarFiltros() {
    document.getElementById('searchContratista').value = '';
    document.getElementById('filtroEspecialidad').value = '';
    document.getElementById('filtroRiesgo').value = '';
    document.getElementById('filtroStatus').value = '';
    cargarContratistas();
}

// ============================================
// FUNCIONES DE DASHBOARD
// ============================================
function cargarDashboard() {
    fetch('/proyectos/api/contratistas/dashboard')
        .then(response => {
            if (!response.ok) throw new Error('Dashboard no disponible');
            return response.json();
        })
        .then(data => {
            document.getElementById('dashTotalContratistas').textContent = data.kpis?.total_contratistas || 0;
            document.getElementById('dashActivos').textContent = data.kpis?.activos || 0;
            document.getElementById('dashTotalProyectos').textContent = data.kpis?.total_proyectos || 0;
            document.getElementById('dashPresupuestoTotal').textContent = formatCurrency(data.kpis?.presupuesto_total || 0);
            document.getElementById('alertasNoLeidas').textContent = data.alertas_no_leidas || 0;
            
            if (data.top_contratistas && data.top_contratistas.length > 0) {
                let html = '';
                data.top_contratistas.forEach(item => {
                    html += `
                        <tr>
                            <td style="padding:8px 10px; border-bottom:1px solid #dee2e6;"><strong>${item.nombre_comercial}</strong></td>
                            <td style="padding:8px 10px; border-bottom:1px solid #dee2e6;">${item.especialidad || 'N/A'}</td>
                            <td style="padding:8px 10px; border-bottom:1px solid #dee2e6; text-align:right; color:#dc3545;">${formatCurrency(item.total_gasto || 0)}</td>
                            <td style="padding:8px 10px; border-bottom:1px solid #dee2e6; text-align:center;">${item.proyectos || 0}</td>
                        </tr>
                    `;
                });
                document.getElementById('topContratistasBody').innerHTML = html;
            }
        })
        .catch(() => {
            document.getElementById('topContratistasBody').innerHTML = '<tr><td colspan="4" style="text-align:center;padding:20px;color:#6c757d;">Dashboard no disponible</td></tr>';
        });
    
    // Cargar alertas
    fetch('/proyectos/api/alertas?leida=0&per_page=5')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('listaAlertas');
            if (data.data && data.data.length > 0) {
                let html = '';
                data.data.forEach(alerta => {
                    const tipo = alerta.nivel === 'danger' ? '#f8d7da' : (alerta.nivel === 'warning' ? '#fff3cd' : '#d1ecf1');
                    const color = alerta.nivel === 'danger' ? '#721c24' : (alerta.nivel === 'warning' ? '#856404' : '#0c5460');
                    html += `
                        <div style="padding:10px; margin-bottom:8px; background:${tipo}; border-left:4px solid ${color}; border-radius:4px; display:flex; justify-content:space-between; align-items:center;">
                            <div>
                                <strong style="color:${color};">${alerta.titulo}</strong>
                                <p style="margin:2px 0 0; font-size:12px; color:${color};">${alerta.descripcion}</p>
                            </div>
                            <button onclick="marcarAlertaLeida(${alerta.id})" style="background:none; border:none; color:${color}; cursor:pointer;">
                                <i class="fas fa-check"></i>
                            </button>
                        </div>
                    `;
                });
                container.innerHTML = html;
            } else {
                container.innerHTML = '<p style="text-align:center;color:#6c757d;padding:20px;"><i class="fas fa-check-circle" style="color:#28a745;"></i> No hay alertas pendientes</p>';
            }
        })
        .catch(() => {
            document.getElementById('listaAlertas').innerHTML = '<p style="text-align:center;color:#dc3545;padding:20px;">Error al cargar alertas</p>';
        });
}

function marcarAlertaLeida(id) {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    fetch('/proyectos/api/alertas/' + id + '/leer', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json'
        }
    })
    .then(() => cargarDashboard())
    .catch(error => console.error('Error:', error));
}

// ============================================
// FUNCIONES DE ASIGNACIONES - CORREGIDAS
// ============================================

function cargarContratistasAsignacion() {
    const select = document.getElementById('asignacion_contratista_select');
    if (!select) {
        console.error('❌ [cargarContratistasAsignacion] No se encontró el select de contratistas');
        return;
    }
    
    console.log('🔄 [cargarContratistasAsignacion] Cargando contratistas...');
    select.innerHTML = '<option value="">⏳ Cargando contratistas...</option>';
    
    fetch('/proyectos/api/contratistas?per_page=999')
        .then(response => {
            console.log('📡 [cargarContratistasAsignacion] Response status:', response.status);
            if (!response.ok) {
                throw new Error('Error al cargar contratistas: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('✅ [cargarContratistasAsignacion] Datos recibidos:', data);
            select.innerHTML = '<option value="">Seleccionar contratista...</option>';
            if (data.data && data.data.length > 0) {
                data.data.forEach(c => {
                    select.innerHTML += `<option value="${c.id}">${c.codigo} - ${c.nombre_comercial} (${c.especialidad})</option>`;
                });
                console.log(`✅ ${data.data.length} contratistas cargados en el select`);
            } else {
                select.innerHTML = '<option value="">No hay contratistas disponibles</option>';
                console.warn('⚠️ No hay contratistas disponibles');
            }
        })
        .catch(error => {
            console.error('❌ Error al cargar contratistas:', error);
            select.innerHTML = '<option value="">Error al cargar contratistas</option>';
            showError('No se pudieron cargar los contratistas. Por favor, recarga la página.');
        });
}

function cargarProyectosAsignacion() {
    console.log('🔍 [cargarProyectosAsignacion] Iniciando...');
    const select = document.getElementById('asignacion_proyecto');
    
    if (!select) {
        console.error('❌ [cargarProyectosAsignacion] No se encontró el select asignacion_proyecto');
        return;
    }
    
    console.log('🔄 [cargarProyectosAsignacion] Cargando proyectos...');
    select.innerHTML = '<option value="">⏳ Cargando proyectos...</option>';
    
    // Probar con ambas rutas
    const urls = ['/api/proyectos', '/proyectos/api/proyectos'];
    let urlIndex = 0;
    
    function intentarCargarProyectos() {
        if (urlIndex >= urls.length) {
            console.error('❌ [cargarProyectosAsignacion] Todas las rutas fallaron');
            select.innerHTML = '<option value="">Error al cargar proyectos</option>';
            showError('No se pudieron cargar los proyectos. Por favor, recarga la página.');
            return;
        }
        
        const url = urls[urlIndex];
        console.log(`📡 [cargarProyectosAsignacion] Intentando ruta ${urlIndex + 1}/${urls.length}: ${url}`);
        
        fetch(url)
            .then(response => {
                console.log(`📡 [cargarProyectosAsignacion] Response status para ${url}:`, response.status);
                if (!response.ok) {
                    throw new Error('Error al cargar proyectos: ' + response.status);
                }
                return response.json();
            })
            .then(response => {
                console.log('✅ [cargarProyectosAsignacion] Datos recibidos:', response);
                if (select) {
                    select.innerHTML = '<option value="">Seleccionar proyecto...</option>';
                    if (response.success && Array.isArray(response.data) && response.data.length > 0) {
                        response.data.forEach(p => {
                            select.innerHTML += `<option value="${p.id}">${p.codigo} - ${p.nombre}</option>`;
                        });
                        console.log(`✅ [cargarProyectosAsignacion] ${response.data.length} proyectos cargados`);
                    } else {
                        select.innerHTML = '<option value="">No hay proyectos disponibles</option>';
                        console.warn('⚠️ [cargarProyectosAsignacion] No hay proyectos disponibles');
                    }
                }
            })
            .catch(error => {
                console.warn(`⚠️ [cargarProyectosAsignacion] Error con ruta ${url}:`, error);
                urlIndex++;
                intentarCargarProyectos();
            });
    }
    
    intentarCargarProyectos();
}

function cargarPartidasAsignacion(proyectoId) {
    const select = document.getElementById('asignacion_partida');
    if (!select) {
        console.error('❌ [cargarPartidasAsignacion] No se encontró el select de partidas');
        return;
    }
    
    console.log('🔄 [cargarPartidasAsignacion] Cargando partidas para proyecto:', proyectoId);
    select.innerHTML = '<option value="">⏳ Cargando partidas...</option>';
    
    if (!proyectoId) {
        select.innerHTML = '<option value="">Seleccionar partida...</option>';
        return;
    }
    
    const url = '/api/proyectos/' + proyectoId + '/partidas';
    console.log('📡 [cargarPartidasAsignacion] Fetching:', url);
    
    fetch(url)
        .then(response => {
            console.log('📡 [cargarPartidasAsignacion] Response status:', response.status);
            console.log('📡 [cargarPartidasAsignacion] Response headers:', response.headers);
            
            // Verificar si la respuesta es JSON
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                // Si no es JSON, intentar leer como texto para ver el error
                return response.text().then(text => {
                    console.error('❌ Respuesta no es JSON:', text.substring(0, 500));
                    throw new Error('El servidor devolvió un error HTML. Revisa el log del servidor.');
                });
            }
            
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Error al cargar partidas: ' + response.status);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('✅ [cargarPartidasAsignacion] Datos recibidos:', data);
            select.innerHTML = '<option value="">Seleccionar partida...</option>';
            
            if (!data.success) {
                console.warn('⚠️ [cargarPartidasAsignacion] Error en respuesta:', data.message);
                select.innerHTML = '<option value="">' + (data.message || 'Error al cargar partidas') + '</option>';
                return;
            }
            
            const partidas = data.data || [];
            
            if (Array.isArray(partidas) && partidas.length > 0) {
                partidas.forEach(p => {
                    const texto = p.codigo ? p.codigo + ' - ' : '';
                    const unidad = p.unidad ? ' (' + p.unidad + ')' : '';
                    const importe = p.importe ? ' $' + parseFloat(p.importe).toFixed(2) : '';
                    const categoria = p.categoria ? ' [' + p.categoria + ']' : '';
                    
                    select.innerHTML += `<option value="${p.id}">${texto}${p.nombre}${unidad}${categoria}${importe}</option>`;
                });
                console.log(`✅ ${partidas.length} partidas cargadas`);
            } else {
                select.innerHTML = '<option value="">No hay partidas disponibles para este proyecto</option>';
                console.warn('⚠️ No hay partidas disponibles para este proyecto');
            }
        })
        .catch(error => {
            console.error('❌ Error al cargar partidas:', error);
            select.innerHTML = '<option value="">Error: ' + (error.message || 'Error al cargar partidas') + '</option>';
            
            Swal.fire({
                icon: 'error',
                title: 'Error al cargar partidas',
                text: error.message || 'No se pudieron cargar las partidas del proyecto.',
                confirmButtonColor: '#083CAE'
            });
        });
}

function abrirModalAsignacion(contratistaId = null) {
    console.log('📋 [abrirModalAsignacion] FUNCIÓN EJECUTADA');
    console.log('📋 [abrirModalAsignacion] ID recibido:', contratistaId);
    
    // Resetear el formulario
    const form = document.getElementById('formAsignacion');
    if (form) form.reset();
    
    // Limpiar campos
    const partidaSelect = document.getElementById('asignacion_partida');
    if (partidaSelect) {
        partidaSelect.innerHTML = '<option value="">Seleccionar partida...</option>';
    }
    
    const proyectoSelect = document.getElementById('asignacion_proyecto');
    if (proyectoSelect) {
        proyectoSelect.innerHTML = '<option value="">Cargando proyectos...</option>';
    }
    
    const contratistaSelect = document.getElementById('asignacion_contratista_select');
    if (contratistaSelect) {
        contratistaSelect.innerHTML = '<option value="">Cargando contratistas...</option>';
    }
    
    // Abrir el modal primero
    abrirModal('modalAsignacion');
    
    // Cargar datos después de abrir el modal
    setTimeout(function() {
        cargarContratistasAsignacion();
        cargarProyectosAsignacion();
        
        // Si se pasó un ID de contratista, seleccionarlo
        if (contratistaId) {
            setTimeout(function() {
                const select = document.getElementById('asignacion_contratista_select');
                if (select) {
                    select.value = contratistaId;
                    console.log('📋 [abrirModalAsignacion] Contratista seleccionado:', select.value);
                }
            }, 800);
        }
    }, 200);
}

// Evento para cargar partidas al seleccionar proyecto
document.addEventListener('change', function(e) {
    if (e.target && e.target.id === 'asignacion_proyecto') {
        const proyectoId = e.target.value;
        console.log('🔄 [change] Proyecto seleccionado:', proyectoId);
        cargarPartidasAsignacion(proyectoId);
    }
});

function guardarAsignacion() {
    console.log('📋 [guardarAsignacion] INICIANDO...');
    const form = document.getElementById('formAsignacion');
    const formData = new FormData(form);
    
    // Obtener el contratista del select
    const contratistaSelect = document.getElementById('asignacion_contratista_select');
    const contratistaId = contratistaSelect ? contratistaSelect.value : '';
    
    const proyectoId = document.getElementById('asignacion_proyecto').value;
    const presupuesto = document.querySelector('input[name="presupuesto_asignado"]')?.value;
    
    console.log('📋 [guardarAsignacion] Datos:', {
        contratistaId: contratistaId,
        proyectoId: proyectoId,
        presupuesto: presupuesto
    });
    
    // Validar
    if (!contratistaId || contratistaId === '') {
        console.error('❌ [guardarAsignacion] No hay contratista seleccionado');
        showError('Por favor selecciona un contratista');
        return;
    }
    
    if (!proyectoId || proyectoId === '') {
        console.error('❌ [guardarAsignacion] No hay proyecto seleccionado');
        showError('Por favor selecciona un proyecto');
        return;
    }
    
    if (!presupuesto || parseFloat(presupuesto) <= 0) {
        console.error('❌ [guardarAsignacion] Presupuesto inválido:', presupuesto);
        showError('Por favor ingresa un presupuesto válido');
        return;
    }
    
    showLoading(true);
    
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    fetch('/proyectos/api/asignaciones', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        }
    })
    .then(response => {
        console.log('📡 [guardarAsignacion] Response status:', response.status);
        if (!response.ok) {
            return response.json().then(err => {
                console.error('❌ [guardarAsignacion] Error response:', err);
                throw err;
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('✅ [guardarAsignacion] Response data:', data);
        showLoading(false);
        if (data.message) {
            showSuccess(data.message);
            cerrarModal('modalAsignacion');
            form.reset();
            cargarAsignaciones();
            cargarContratistas();
            cargarDashboard();
        } else if (data.errors) {
            const errorMessages = Object.values(data.errors).flat().join('\n');
            console.error('❌ [guardarAsignacion] Errores de validación:', errorMessages);
            showError('Errores de validación:\n' + errorMessages);
        } else {
            showError('Error al guardar la asignación');
        }
    })
    .catch(error => {
        console.error('❌ [guardarAsignacion] Error:', error);
        showLoading(false);
        if (error.errors) {
            const errorMessages = Object.values(error.errors).flat().join('\n');
            showError('Errores de validación:\n' + errorMessages);
        } else {
            showError('Error al guardar: ' + (error.message || 'Error desconocido'));
        }
    });
}

// ============================================
// FUNCIONES DE ASIGNACIONES - CARGAR LISTADO
// ============================================
function cargarAsignaciones() {
    console.log('🔄 [cargarAsignaciones] Cargando asignaciones...');
    showLoading(true);
    
    fetch('/proyectos/api/asignaciones')
        .then(response => response.json())
        .then(data => {
            console.log('✅ [cargarAsignaciones] Datos recibidos:', data);
            renderizarTablaAsignaciones(data.data || []);
            showLoading(false);
        })
        .catch(error => {
            console.error('❌ [cargarAsignaciones] Error:', error);
            showLoading(false);
        });
    
    fetch('/api/proyectos')
        .then(response => response.json())
        .then(response => {
            const select = document.getElementById('filtroProyectoAsignacion');
            if (select && response.success && Array.isArray(response.data)) {
                select.innerHTML = '<option value="">Todos los proyectos</option>';
                response.data.forEach(p => {
                    select.innerHTML += `<option value="${p.id}">${p.nombre}</option>`;
                });
                console.log('✅ [cargarAsignaciones] Proyectos cargados en filtro');
            }
        })
        .catch(error => console.error('Error:', error));
}

function renderizarTablaAsignaciones(data) {
    const tbody = document.getElementById('tablaAsignacionesBody');
    if (!tbody) return;
    
    if (data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:40px; color:#6c757d;"><i class="fas fa-info-circle"></i> No hay asignaciones registradas</td></tr>';
        return;
    }
    
    let html = '';
    data.forEach(a => {
        const statusBadge = a.status === 'finalizado' ? 'success' : 
                           (a.status === 'en_progreso' ? 'primary' : 
                           (a.status === 'pausado' ? 'warning' : 'secondary'));
        const avanceColor = a.avance_porcentaje >= 90 ? 'success' : 
                           (a.avance_porcentaje >= 50 ? 'warning' : 'info');
        
        html += `
            <tr>
                <td style="padding:10px 6px;">${a.contratista?.nombre_comercial || 'N/A'}</td>
                <td style="padding:10px 6px;">${a.proyecto?.nombre || 'N/A'}</td>
                <td style="padding:10px 6px;">${a.seccion || 'N/A'}</td>
                <td style="padding:10px 6px; text-align:right; color:#083CAE; font-weight:600;">${formatCurrency(a.presupuesto_asignado)}</td>
                <td style="padding:10px 6px; text-align:right; color:#dc3545;">${formatCurrency(a.gasto_acumulado)}</td>
                <td style="padding:10px 6px; text-align:center;">
                    <div style="background:#e9ecef; border-radius:4px; height:20px; overflow:hidden; position:relative;">
                        <div style="background:${avanceColor === 'success' ? '#28a745' : (avanceColor === 'warning' ? '#ffc107' : '#17a2b8')}; width:${a.avance_porcentaje}%; height:100%; display:flex; align-items:center; justify-content:center; font-size:11px; color:white; font-weight:bold;">${a.avance_porcentaje}%</div>
                    </div>
                </td>
                <td style="padding:10px 6px; text-align:center;"><span class="badge badge-${statusBadge}">${a.status.replace('_', ' ').toUpperCase()}</span></td>
                <td style="padding:10px 6px; text-align:center;">
                    <div style="display:flex; gap:5px; justify-content:center;">
                        <button onclick="abrirModalGasto(${a.id})" style="background:#28a745; color:white; border:none; border-radius:4px; padding:4px 8px; cursor:pointer;" title="Registrar Gasto"><i class="fas fa-plus-circle"></i></button>
                        <button onclick="verAsignacion(${a.id})" style="background:#083CAE; color:white; border:none; border-radius:4px; padding:4px 8px; cursor:pointer;" title="Ver"><i class="fas fa-eye"></i></button>
                    </div>
                </td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
}

function verAsignacion(id) {
    fetch('/proyectos/api/asignaciones/' + id)
        .then(response => response.json())
        .then(data => {
            const a = data.asignacion;
            Swal.fire({
                title: 'Detalle de Asignación',
                html: `
                    <div style="text-align:left;">
                        <p><strong>Contratista:</strong> ${a.contratista.nombre_comercial}</p>
                        <p><strong>Proyecto:</strong> ${a.proyecto.nombre}</p>
                        <p><strong>Sección:</strong> ${a.seccion || 'N/A'}</p>
                        <p><strong>Presupuesto:</strong> ${formatCurrency(a.presupuesto_asignado)}</p>
                        <p><strong>Gasto:</strong> ${formatCurrency(a.gasto_acumulado)}</p>
                        <p><strong>Saldo:</strong> ${formatCurrency(a.saldo_disponible)}</p>
                        <p><strong>Avance:</strong> ${a.avance_porcentaje}%</p>
                        <p><strong>Status:</strong> ${a.status.toUpperCase()}</p>
                    </div>
                `,
                icon: 'info',
                confirmButtonColor: '#083CAE'
            });
        })
        .catch(() => showError('No se pudo cargar la información'));
}

// ============================================
// FUNCIONES DE GASTOS
// ============================================
function cargarGastos() {
    showLoading(true);
    
    fetch('/proyectos/api/gastos')
        .then(response => response.json())
        .then(data => {
            renderizarTablaGastos(data.data || []);
            showLoading(false);
        })
        .catch(error => {
            console.error('Error:', error);
            showLoading(false);
        });
}

function renderizarTablaGastos(data) {
    const tbody = document.getElementById('tablaGastosBody');
    if (!tbody) return;
    
    if (data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding:40px; color:#6c757d;"><i class="fas fa-info-circle"></i> No hay gastos registrados</td></tr>';
        return;
    }
    
    let html = '';
    data.forEach(g => {
        const statusBadge = g.status_pago === 'pagado' ? 'badge-pagado' : 'badge-pendiente';
        const statusText = g.status_pago === 'pagado' ? 'Pagado' : 'Pendiente';
        
        html += `
            <tr>
                <td style="padding:10px 6px; text-align:center;">${new Date(g.fecha_gasto).toLocaleDateString()}</td>
                <td style="padding:10px 6px;">${g.contratista?.nombre_comercial || 'N/A'}</td>
                <td style="padding:10px 6px;">${g.concepto}</td>
                <td style="padding:10px 6px;">${g.tipo_gasto}</td>
                <td style="padding:10px 6px; text-align:right; color:#dc3545; font-weight:600;">${formatCurrency(g.monto)}</td>
                <td style="padding:10px 6px; text-align:center;"><span class="badge ${statusBadge}">${statusText}</span></td>
                <td style="padding:10px 6px; text-align:center;">
                    <div style="display:flex; gap:5px; justify-content:center;">
                        <button onclick="verGasto(${g.id})" style="background:#083CAE; color:white; border:none; border-radius:4px; padding:4px 8px; cursor:pointer;" title="Ver"><i class="fas fa-eye"></i></button>
                        <button onclick="marcarGastoPagado(${g.id})" style="background:#28a745; color:white; border:none; border-radius:4px; padding:4px 8px; cursor:pointer;" title="Marcar Pagado"><i class="fas fa-money-bill-wave"></i></button>
                    </div>
                </td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
}

function verGasto(id) {
    fetch('/proyectos/api/gastos/' + id)
        .then(response => response.json())
        .then(data => {
            Swal.fire({
                title: 'Detalle del Gasto',
                html: `
                    <div style="text-align:left;">
                        <p><strong>Concepto:</strong> ${data.concepto}</p>
                        <p><strong>Descripción:</strong> ${data.descripcion || 'N/A'}</p>
                        <p><strong>Tipo:</strong> ${data.tipo_gasto}</p>
                        <p><strong>Monto:</strong> ${formatCurrency(data.monto)}</p>
                        <p><strong>Fecha:</strong> ${new Date(data.fecha_gasto).toLocaleDateString()}</p>
                        <p><strong>Status:</strong> ${data.status_pago.toUpperCase()}</p>
                    </div>
                `,
                icon: 'info',
                confirmButtonColor: '#083CAE'
            });
        })
        .catch(() => showError('No se pudo cargar la información'));
}

function guardarGasto() {
    const form = document.getElementById('formGasto');
    const formData = new FormData(form);
    
    showLoading(true);
    
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    fetch('/proyectos/api/gastos', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': token
        }
    })
    .then(response => response.json())
    .then(data => {
        showLoading(false);
        if (data.message) {
            showSuccess(data.message);
            cerrarModal('modalGasto');
            form.reset();
            cargarGastos();
            cargarAsignaciones();
            cargarDashboard();
        } else {
            showError('Error al guardar el gasto');
        }
    })
    .catch(() => {
        showLoading(false);
        showError('No se pudo guardar el gasto');
    });
}

function abrirModalGasto(asignacionId = null) {
    if (asignacionId) {
        document.getElementById('gasto_asignacion_id').value = asignacionId;
        cargarInfoAsignacion(asignacionId);
    }
    abrirModal('modalGasto');
}

function cargarInfoAsignacion(asignacionId) {
    fetch('/proyectos/api/asignaciones/' + asignacionId)
        .then(response => response.json())
        .then(data => {
            const a = data.asignacion;
            document.getElementById('infoAsignacionTexto').innerHTML = `
                <strong>Contratista:</strong> ${a.contratista.nombre_comercial} | 
                <strong>Proyecto:</strong> ${a.proyecto.nombre} |
                <strong>Presupuesto:</strong> ${formatCurrency(a.presupuesto_asignado)} |
                <strong>Gasto:</strong> ${formatCurrency(a.gasto_acumulado)} |
                <strong>Saldo:</strong> ${formatCurrency(a.saldo_disponible)}
            `;
        })
        .catch(() => {
            document.getElementById('infoAsignacionTexto').innerHTML = 'No se pudo cargar la información';
        });
}

function marcarGastoPagado(id) {
    Swal.fire({
        title: 'Marcar como pagado',
        html: `
            <div style="text-align:left;">
                <div style="margin-bottom:10px;">
                    <label>Fecha de Pago</label>
                    <input type="date" id="fechaPagoGasto" class="form-control" value="${new Date().toISOString().split('T')[0]}" style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;">
                </div>
                <div>
                    <label>Forma de Pago</label>
                    <select id="formaPagoGasto" class="form-control" style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;">
                        <option value="transferencia">Transferencia</option>
                        <option value="cheque">Cheque</option>
                        <option value="efectivo">Efectivo</option>
                    </select>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        confirmButtonText: 'Marcar Pagado',
        cancelButtonText: 'Cancelar',
        preConfirm: function() {
            return {
                fecha_pago: document.getElementById('fechaPagoGasto').value,
                forma_pago: document.getElementById('formaPagoGasto').value
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            showLoading(true);
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            fetch('/proyectos/api/gastos/' + id + '/pagar', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(result.value)
            })
            .then(response => response.json())
            .then(data => {
                showLoading(false);
                showSuccess(data.message);
                cargarGastos();
                cargarPagos();
                cargarDashboard();
            })
            .catch(() => {
                showLoading(false);
                showError('No se pudo marcar como pagado');
            });
        }
    });
}

// ============================================
// FUNCIONES DE PAGOS
// ============================================
function cargarPagos() {
    showLoading(true);
    
    fetch('/proyectos/api/pagos')
        .then(response => response.json())
        .then(data => {
            renderizarTablaPagos(data.data || []);
            showLoading(false);
        })
        .catch(error => {
            console.error('Error:', error);
            showLoading(false);
        });
}

function renderizarTablaPagos(data) {
    const tbody = document.getElementById('tablaPagosBody');
    if (!tbody) return;
    
    if (data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding:40px; color:#6c757d;"><i class="fas fa-info-circle"></i> No hay pagos registrados</td></tr>';
        return;
    }
    
    let html = '';
    data.forEach(p => {
        const formaLabels = { 'transferencia': 'Transferencia', 'cheque': 'Cheque', 'efectivo': 'Efectivo' };
        
        html += `
            <tr>
                <td style="padding:10px 6px; text-align:center; font-weight:bold;">${p.folio}</td>
                <td style="padding:10px 6px; text-align:center;">${new Date(p.fecha_pago).toLocaleDateString()}</td>
                <td style="padding:10px 6px;">${p.contratista?.nombre_comercial || 'N/A'}</td>
                <td style="padding:10px 6px; text-align:right; color:#28a745; font-weight:600;">${formatCurrency(p.monto)}</td>
                <td style="padding:10px 6px; text-align:center;"><span class="badge badge-info">${formaLabels[p.forma_pago] || p.forma_pago}</span></td>
                <td style="padding:10px 6px; text-align:center;">${p.referencia || 'N/A'}</td>
                <td style="padding:10px 6px; text-align:center;">
                    <div style="display:flex; gap:5px; justify-content:center;">
                        <button onclick="verPago(${p.id})" style="background:#083CAE; color:white; border:none; border-radius:4px; padding:4px 8px; cursor:pointer;" title="Ver"><i class="fas fa-eye"></i></button>
                        <button onclick="eliminarPago(${p.id})" style="background:#dc3545; color:white; border:none; border-radius:4px; padding:4px 8px; cursor:pointer;" title="Eliminar"><i class="fas fa-trash"></i></button>
                    </div>
                </td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
}

function verPago(id) {
    fetch('/proyectos/api/pagos/' + id)
        .then(response => response.json())
        .then(data => {
            Swal.fire({
                title: 'Detalle del Pago',
                html: `
                    <div style="text-align:left;">
                        <p><strong>Folio:</strong> ${data.folio}</p>
                        <p><strong>Fecha:</strong> ${new Date(data.fecha_pago).toLocaleDateString()}</p>
                        <p><strong>Contratista:</strong> ${data.contratista.nombre_comercial}</p>
                        <p><strong>Monto:</strong> ${formatCurrency(data.monto)}</p>
                        <p><strong>Forma:</strong> ${data.forma_pago}</p>
                        <p><strong>Referencia:</strong> ${data.referencia || 'N/A'}</p>
                    </div>
                `,
                icon: 'info',
                confirmButtonColor: '#083CAE'
            });
        })
        .catch(() => showError('No se pudo cargar la información'));
}

function guardarPago() {
    const form = document.getElementById('formPago');
    const formData = new FormData(form);
    
    showLoading(true);
    
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    fetch('/proyectos/api/pagos', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': token
        }
    })
    .then(response => response.json())
    .then(data => {
        showLoading(false);
        if (data.message) {
            showSuccess(data.message);
            cerrarModal('modalPago');
            form.reset();
            cargarPagos();
            cargarGastos();
            cargarDashboard();
        } else {
            showError('Error al guardar el pago');
        }
    })
    .catch(() => {
        showLoading(false);
        showError('No se pudo guardar el pago');
    });
}

function abrirModalPago(contratistaId = null, asignacionId = null, gastoId = null) {
    if (contratistaId) document.getElementById('pago_contratista_id').value = contratistaId;
    if (asignacionId) document.getElementById('pago_asignacion_id').value = asignacionId;
    if (gastoId) document.getElementById('pago_gasto_id').value = gastoId;
    
    if (contratistaId) {
        cargarInfoContratistaPago(contratistaId);
    }
    abrirModal('modalPago');
}

function cargarInfoContratistaPago(contratistaId) {
    fetch('/proyectos/api/contratistas/' + contratistaId)
        .then(response => response.json())
        .then(data => {
            const c = data.contratista;
            document.getElementById('infoContratistaTexto').innerHTML = `
                <strong>Contratista:</strong> ${c.nombre_comercial} |
                <strong>Especialidad:</strong> ${c.especialidad} |
                <strong>Calificación:</strong> ${c.calificacion > 0 ? c.calificacion + '/10' : 'Sin calificar'}
            `;
        })
        .catch(() => {
            document.getElementById('infoContratistaTexto').innerHTML = 'No se pudo cargar la información';
        });
}

function eliminarPago(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Deseas eliminar este pago?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            showLoading(true);
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            fetch('/proyectos/api/pagos/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token
                }
            })
            .then(response => response.json())
            .then(data => {
                showLoading(false);
                showSuccess(data.message);
                cargarPagos();
                cargarGastos();
            })
            .catch(() => {
                showLoading(false);
                showError('No se pudo eliminar el pago');
            });
        }
    });
}

// ============================================
// INICIALIZACIÓN
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 [DOMContentLoaded] Inicializando módulo de Contratistas');
    
    cambiarSeccion('listado');
    
    document.getElementById('searchContratista')?.addEventListener('input', cargarContratistas);
    document.getElementById('filtroEspecialidad')?.addEventListener('change', cargarContratistas);
    document.getElementById('filtroRiesgo')?.addEventListener('change', cargarContratistas);
    document.getElementById('filtroStatus')?.addEventListener('change', cargarContratistas);
    
    document.getElementById('filtroProyectoAsignacion')?.addEventListener('change', cargarAsignaciones);
    document.getElementById('filtroStatusAsignacion')?.addEventListener('change', cargarAsignaciones);
    document.getElementById('searchAsignacion')?.addEventListener('input', cargarAsignaciones);
    
    document.getElementById('filtroTipoGasto')?.addEventListener('change', cargarGastos);
    document.getElementById('filtroStatusPagoGasto')?.addEventListener('change', cargarGastos);
    document.getElementById('searchGasto')?.addEventListener('input', cargarGastos);
    
    document.getElementById('filtroFormaPago')?.addEventListener('change', cargarPagos);
    document.getElementById('filtroFechaPago')?.addEventListener('change', cargarPagos);
    document.getElementById('searchPago')?.addEventListener('input', cargarPagos);
    
    console.log('🚀 [DOMContentLoaded] Inicialización completada');
});

</script>
@endsection