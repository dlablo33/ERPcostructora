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
                <!-- BOTONES DE NAVEGACIÓN -->
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

                    <div style="border: 1px solid #dee2e6; border-radius: 8px; padding: 15px; background: white; margin-bottom: 20px;">
                        <h4 style="color: #083CAE; margin-bottom: 15px;"><i class="fas fa-trophy"></i> Top Contratistas por Gasto</h4>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="padding: 10px; text-align: left; border-bottom: 2px solid #dee2e6;">Contratista</th>
                                        <th style="padding: 10px; text-align: left; border-bottom: 2px solid #dee2e6;">Especialidad</th>
                                        <th style="padding: 10px; text-align: right; border-bottom: 2px solid #dee2e6;">Gasto Total</th>
                                    </tr>
                                </thead>
                                <tbody id="topContratistasBody">
                                    <tr><td colspan="3" style="text-align:center; padding: 20px; color: #6c757d;"><i class="fas fa-spinner fa-spin"></i> Cargando datos...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

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
                                    <th style="padding: 12px 6px; text-align: right;">Saldo</th>
                                    <th style="padding: 12px 6px; text-align: center;">Avance</th>
                                    <th style="padding: 12px 6px; text-align: center;">Status</th>
                                    <th style="padding: 12px 6px; text-align: center;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaAsignacionesBody">
                                <tr><td colspan="9" style="text-align:center; padding:40px; color:#6c757d;"><i class="fas fa-spinner fa-spin"></i> Cargando datos...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- SECCIÓN: GASTOS -->
                <!-- ========================================== -->
                <div id="seccion-gastos" class="seccion-contenido" style="display: none;">
                    <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                        <button onclick="abrirModalGastoNuevo()" style="background-color: #28a745; color: white; border: none; border-radius: 6px; padding: 8px 20px; cursor: pointer; display: flex; align-items: center; gap: 6px;">
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
                                    <th style="padding: 12px 6px; text-align: left;">Proyecto</th>
                                    <th style="padding: 12px 6px; text-align: left;">Concepto</th>
                                    <th style="padding: 12px 6px; text-align: left;">Tipo</th>
                                    <th style="padding: 12px 6px; text-align: right;">Monto</th>
                                    <th style="padding: 12px 6px; text-align: center;">Status</th>
                                    <th style="padding: 12px 6px; text-align: center;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaGastosBody">
                                <tr><td colspan="8" style="text-align:center; padding:40px; color:#6c757d;"><i class="fas fa-spinner fa-spin"></i> Cargando datos...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- SECCIÓN: PAGOS -->
                <!-- ========================================== -->
                <div id="seccion-pagos" class="seccion-contenido" style="display: none;">
                    <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                        <button onclick="abrirModalPagoNuevo()" style="background-color: #083CAE; color: white; border: none; border-radius: 6px; padding: 8px 20px; cursor: pointer; display: flex; align-items: center; gap: 6px;">
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
                                    <th style="padding: 12px 6px; text-align: center;">Cuenta</th>
                                    <th style="padding: 12px 6px; text-align: center;">Referencia</th>
                                    <th style="padding: 12px 6px; text-align: center;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaPagosBody">
                                <tr><td colspan="8" style="text-align:center; padding:40px; color:#6c757d;"><i class="fas fa-spinner fa-spin"></i> Cargando datos...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- ========================================== -->
<!-- MODAL: Nuevo Contratista -->
<!-- ========================================== -->
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
<!-- MODAL: ASIGNACIÓN -->
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
                    <div style="grid-column: span 2;">
                        <label style="display:block; font-weight:600; margin-bottom:5px; color: #dc3545;">
                            <i class="fas fa-building"></i> Proyecto *
                        </label>
                        <select id="asignacion_proyecto" name="proyecto_id" class="form-control" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
                            <option value="">Seleccionar proyecto...</option>
                        </select>
                    </div>
                    
                    <div style="grid-column: span 2;">
                        <label style="display:block; font-weight:600; margin-bottom:5px;">
                            <i class="fas fa-list"></i> Partida
                        </label>
                        <select id="asignacion_partida" name="partida_id" class="form-control" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
                            <option value="">Seleccionar partida...</option>
                        </select>
                    </div>
                    
                    <div style="grid-column: span 2;">
                        <label style="display:block; font-weight:600; margin-bottom:5px;">
                            <i class="fas fa-layer-group"></i> Sección
                        </label>
                        <input type="text" name="seccion" class="form-control" placeholder="Ej: Cimentación, Estructura, Instalaciones..." style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
                    </div>
                    
                    <div style="grid-column: span 2;">
                        <label style="display:block; font-weight:600; margin-bottom:5px; color: #dc3545;">
                            <i class="fas fa-money-bill-wave"></i> Presupuesto Asignado *
                        </label>
                        <div style="position: relative;">
                            <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-weight: bold; color: #6c757d;">$</span>
                            <input type="number" name="presupuesto_asignado" class="form-control" step="0.01" min="0" required placeholder="0.00" style="width:100%; padding:10px 10px 10px 30px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
                        </div>
                    </div>
                    
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px; color: #dc3545;">
                            <i class="fas fa-calendar-plus"></i> Fecha Asignación *
                        </label>
                        <input type="date" name="fecha_asignacion" class="form-control" value="{{ date('Y-m-d') }}" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
                    </div>
                    
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px;">
                            <i class="fas fa-play"></i> Fecha Inicio
                        </label>
                        <input type="date" name="fecha_inicio" class="form-control" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
                    </div>
                    
                    <div style="grid-column: span 2;">
                        <label style="display:block; font-weight:600; margin-bottom:5px;">
                            <i class="fas fa-stop"></i> Fecha Fin
                        </label>
                        <input type="date" name="fecha_fin" class="form-control" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
                    </div>
                    
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

<!-- ========================================== -->
<!-- MODAL: GASTO -->
<!-- ========================================== -->
<div id="modalGasto" style="display: none; position: fixed; z-index: 10001; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); overflow-y: auto;">
    <div style="background-color: white; margin: 2% auto; width: 95%; max-width: 700px; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
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
                <!-- ⚠️ IMPORTANTE: NO poner name="asignacion_id" aquí, se controla desde JS -->
                <input type="hidden" id="gasto_asignacion_id">
                
                <div style="margin-bottom: 20px; padding: 15px; background: linear-gradient(135deg, #e8f7ed 0%, #d4edda 100%); border-radius: 8px; border-left: 5px solid #28a745;">
                    <div style="font-size: 13px; color: #155724; font-weight: 700; margin-bottom: 12px;">
                        <i class="fas fa-link"></i> RELACIÓN DEL GASTO
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 10px;">
                        <div>
                            <label style="display:block; font-weight:600; margin-bottom:5px; font-size: 12px; color: #155724;">Contratista *</label>
                            <select id="gasto_contratista_select" class="form-control" style="width:100%; padding:8px; border:1px solid #ddd; border-radius:6px; font-size:13px;">
                                <option value="">Seleccionar contratista...</option>
                            </select>
                        </div>
                        <div>
                            <label style="display:block; font-weight:600; margin-bottom:5px; font-size: 12px; color: #155724;">Proyecto *</label>
                            <select id="gasto_proyecto_select" class="form-control" style="width:100%; padding:8px; border:1px solid #ddd; border-radius:6px; font-size:13px;" disabled>
                                <option value="">Primero selecciona contratista</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px; font-size: 12px; color: #155724;">Asignación (Presupuesto) *</label>
                        <select id="gasto_asignacion_select" class="form-control" style="width:100%; padding:8px; border:1px solid #ddd; border-radius:6px; font-size:13px;" disabled>
                            <option value="">Primero selecciona proyecto</option>
                        </select>
                    </div>
                    
                    <div id="gasto_presupuesto_info" style="margin-top: 10px; padding: 10px; background: white; border-radius: 6px; font-size: 12px; display: none;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                            <span><strong>Presupuesto:</strong></span>
                            <span id="gasto_presupuesto_asignado" style="color: #083CAE; font-weight: 700;">$0.00</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                            <span><strong>Gasto acumulado:</strong></span>
                            <span id="gasto_presupuesto_gastado" style="color: #dc3545; font-weight: 700;">$0.00</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; border-top: 1px solid #dee2e6; padding-top: 4px;">
                            <span><strong>Saldo disponible:</strong></span>
                            <span id="gasto_presupuesto_disponible" style="color: #28a745; font-weight: 700;">$0.00</span>
                        </div>
                    </div>
                </div>
                
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
                        <input type="number" id="gasto_monto" name="monto" class="form-control" step="0.01" min="0.01" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
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
                
                <div id="gasto_validacion_monto" style="margin-top:15px; padding:12px; border-radius:6px; font-size:13px; display:none;">
                    <i class="fas fa-info-circle"></i> <span id="gasto_validacion_texto"></span>
                </div>
            </form>
        </div>
        <div style="padding: 20px 25px; background-color: #f8f9fa; border-radius: 0 0 12px 12px; display: flex; justify-content: flex-end; gap: 12px;">
            <button onclick="cerrarModal('modalGasto')" style="background-color: #6c757d; color: white; border: none; padding: 10px 25px; border-radius: 6px; cursor: pointer;">Cancelar</button>
            <button id="btnGuardarGasto" onclick="guardarGasto()" style="background-color: #28a745; color: white; border: none; padding: 10px 25px; border-radius: 6px; cursor: pointer;">
                <i class="fas fa-save"></i> Registrar Gasto
            </button>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: PAGO -->
<!-- ========================================== -->
<div id="modalPago" style="display: none; position: fixed; z-index: 10001; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); overflow-y: auto;">
    <div style="background-color: white; margin: 2% auto; width: 95%; max-width: 650px; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
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
                
                <div id="infoContratistaPago" style="margin-bottom:15px; padding:12px; background-color: #e8f0fe; border-radius:6px; font-size:13px;">
                    <i class="fas fa-info-circle"></i> <span id="infoContratistaTexto">Selecciona una asignación para cargar la información...</span>
                </div>
                
                <div id="pago_asignacion_container" style="margin-bottom:15px;">
                    <label style="display:block; font-weight:600; margin-bottom:5px; color: #dc3545;">Asignación *</label>
                    <select id="pago_asignacion_select" class="form-control" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                        <option value="">Cargando asignaciones...</option>
                    </select>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px; color: #dc3545;">Fecha de Pago *</label>
                        <input type="date" name="fecha_pago" class="form-control" value="{{ date('Y-m-d') }}" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                    </div>
                    <div>
                        <label style="display:block; font-weight:600; margin-bottom:5px; color: #dc3545;">Monto *</label>
                        <input type="number" id="pago_monto" name="monto" class="form-control" step="0.01" min="0.01" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
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
                        <label style="display:block; font-weight:600; margin-bottom:5px; color: #dc3545;">
                            <i class="fas fa-university"></i> Cuenta Bancaria *
                        </label>
                        <input type="text" name="cuenta_bancaria" class="form-control" placeholder="Ej: BBVA ****1234" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                    </div>
                    <div style="grid-column: span 2;">
                        <label style="display:block; font-weight:600; margin-bottom:5px;">Referencia</label>
                        <input type="text" name="referencia" class="form-control" placeholder="Número de referencia / folio" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                    </div>
                    <div style="grid-column: span 2;">
                        <label style="display:block; font-weight:600; margin-bottom:5px;">Observaciones</label>
                        <textarea name="observaciones" class="form-control" rows="2" placeholder="Detalles adicionales" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;"></textarea>
                    </div>
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
    .badge-info { background-color: #d1ecf1; color: #0c5460; }
    .badge-success { background-color: #d4edda; color: #155724; }
    .badge-primary { background-color: #cce5ff; color: #004085; }
    .badge-warning { background-color: #fff3cd; color: #856404; }
    .badge-secondary { background-color: #e2e3e5; color: #383d41; }
    
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

// ⚠️ CRÍTICO: Variable global para guardar la asignación actual del modal de gastos
window.currentAsignacionGasto = null;

// ============================================
// UTILIDADES
// ============================================
function formatCurrency(amount) {
    if (amount === null || amount === undefined || isNaN(amount)) amount = 0;
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
    Swal.fire({ icon: 'success', title: 'Éxito', text: msg, confirmButtonColor: '#083CAE', timer: 2500, showConfirmButton: false }); 
}

function showWarning(msg) {
    Swal.fire({ icon: 'warning', title: 'Atención', text: msg, confirmButtonColor: '#083CAE' });
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
// NAVEGACIÓN
// ============================================
function cambiarSeccion(seccion) {
    document.querySelectorAll('.seccion-contenido').forEach(el => {
        el.style.display = 'none';
    });
    
    const elemento = document.getElementById('seccion-' + seccion);
    if (elemento) elemento.style.display = 'block';
    
    document.querySelectorAll('.btn-seccion').forEach(btn => {
        btn.classList.remove('active');
        btn.style.backgroundColor = '#6c757d';
    });
    
    const btn = document.getElementById('btn-' + seccion);
    if (btn) {
        btn.classList.add('active');
        btn.style.backgroundColor = '#083CAE';
    }
    
    if (seccion === 'listado') cargarContratistas();
    if (seccion === 'dashboard') cargarDashboard();
    if (seccion === 'asignaciones') cargarAsignaciones();
    if (seccion === 'gastos') cargarGastos();
    if (seccion === 'pagos') cargarPagos();
}

// ============================================
// MODALES
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
// CONTRATISTAS
// ============================================
function cargarContratistas() {
    const tbody = document.getElementById('tablaContratistasBody');
    if (!tbody) return;
    
    showLoading(true);
    
    fetch('/proyectos/api/contratistas', {
        headers: { 'Accept': 'application/json' }
    })
        .then(response => {
            if (!response.ok) throw new Error('HTTP error ' + response.status);
            return response.json();
        })
        .then(data => {
            datosContratistas = data.data || [];
            renderizarTablaContratistas();
            showLoading(false);
        })
        .catch(error => {
            showLoading(false);
            tbody.innerHTML = `<tr><td colspan="10" style="text-align:center; padding:40px; color:#dc3545;">
                <i class="fas fa-exclamation-triangle"></i> Error al cargar datos: ${error.message}
            </td></tr>`;
        });
}

function renderizarTablaContratistas() {
    const tbody = document.getElementById('tablaContratistasBody');
    if (!tbody) return;
    
    if (datosContratistas.length === 0) {
        tbody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding:40px; color:#6c757d;"><i class="fas fa-info-circle"></i> No hay contratistas registrados</td></tr>';
        actualizarPaginacionContratistas(0);
        return;
    }
    
    const start = (currentPageContratistas - 1) * rowsPerPageContratistas;
    const end = start + rowsPerPageContratistas;
    const pageData = datosContratistas.slice(start, end);
    
    let html = '';
    pageData.forEach((c) => {
        const riesgoBadge = 'badge-riesgo-' + c.nivel_riesgo;
        const statusBadge = c.activo ? 'badge-activo' : 'badge-inactivo';
        const statusText = c.activo ? 'Activo' : 'Inactivo';
        
        let calificacionHtml = '';
        if (c.calificacion > 0) {
            const color = c.calificacion >= 8 ? '#28a745' : (c.calificacion >= 6 ? '#ffc107' : '#dc3545');
            calificacionHtml = `<div style="background:#e9ecef; border-radius:4px; height:20px; overflow:hidden; position:relative; width:100%;">
                <div style="background:${color}; width:${c.calificacion * 10}%; height:100%; display:flex; align-items:center; justify-content:center; font-size:11px; color:white; font-weight:bold;">${c.calificacion}/10</div>
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
                        <button onclick="abrirModalAsignacion(${c.id})" style="background:#17a2b8; color:white; border:none; border-radius:4px; padding:4px 8px; cursor:pointer;" title="Asignar"><i class="fas fa-project-diagram"></i></button>
                        <button onclick="eliminarContratista(${c.id})" style="background:#dc3545; color:white; border:none; border-radius:4px; padding:4px 8px; cursor:pointer;" title="Eliminar"><i class="fas fa-trash"></i></button>
                    </div>
                </td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
    actualizarPaginacionContratistas(datosContratistas.length);
}

function actualizarPaginacionContratistas(total) {
    const totalPages = Math.ceil(total / rowsPerPageContratistas);
    const start = total === 0 ? 0 : (currentPageContratistas - 1) * rowsPerPageContratistas + 1;
    const end = Math.min(currentPageContratistas * rowsPerPageContratistas, total);
    
    const paginaActual = document.getElementById('paginaActualContratistas');
    const paginacionInfo = document.getElementById('paginacionInfoContratistas');
    const btnPrev = document.getElementById('btnPrevContratistas');
    const btnNext = document.getElementById('btnNextContratistas');
    
    if (paginaActual) paginaActual.textContent = currentPageContratistas;
    if (paginacionInfo) paginacionInfo.textContent = `Mostrando ${start}-${end} de ${total} registros`;
    if (btnPrev) btnPrev.disabled = currentPageContratistas <= 1;
    if (btnNext) btnNext.disabled = currentPageContratistas >= totalPages;
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

function guardarContratista() {
    const form = document.getElementById('formNuevoContratista');
    const formData = new FormData(form);
    
    const activoCheckbox = document.getElementById('nuevo_activo');
    formData.set('activo', activoCheckbox && activoCheckbox.checked ? '1' : '0');
    
    showLoading(true);
    document.getElementById('btnGuardarContratista').disabled = true;
    clearValidationErrors();
    
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    fetch('/proyectos/api/contratistas', {
        method: 'POST',
        body: formData,
        headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }
    })
    .then(response => response.json().then(data => ({ ok: response.ok, data })))
    .then(({ ok, data }) => {
        showLoading(false);
        document.getElementById('btnGuardarContratista').disabled = false;
        
        if (ok && data.message) {
            showSuccess(data.message);
            cerrarModal('modalNuevoContratista');
            form.reset();
            cargarContratistas();
        } else if (data.errors) {
            showValidationErrors(data.errors);
            showError('Errores de validación:\n' + Object.values(data.errors).flat().join('\n'));
        } else {
            showError(data.message || 'Error al guardar');
        }
    })
    .catch(error => {
        showLoading(false);
        document.getElementById('btnGuardarContratista').disabled = false;
        showError('Error al guardar: ' + error.message);
    });
}

function guardarContratistaEdit() {
    const form = document.getElementById('formEditarContratista');
    const formData = new FormData(form);
    const id = document.getElementById('edit_id').value;
    
    const activoCheckbox = document.getElementById('edit_activo');
    formData.set('activo', activoCheckbox && activoCheckbox.checked ? '1' : '0');
    
    showLoading(true);
    
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    fetch('/proyectos/api/contratistas/' + id, {
        method: 'POST',
        body: formData,
        headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }
    })
    .then(response => response.json().then(data => ({ ok: response.ok, data })))
    .then(({ ok, data }) => {
        showLoading(false);
        if (ok && data.message) {
            showSuccess(data.message);
            cerrarModal('modalEditarContratista');
            cargarContratistas();
        } else if (data.errors) {
            showError('Errores:\n' + Object.values(data.errors).flat().join('\n'));
        } else {
            showError(data.message || 'Error al actualizar');
        }
    })
    .catch(error => {
        showLoading(false);
        showError('Error: ' + error.message);
    });
}

function verContratista(id) {
    showLoading(true);
    fetch('/proyectos/api/contratistas/' + id, {
        headers: { 'Accept': 'application/json' }
    })
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
                        <p><strong>Proyectos Activos:</strong> ${data.estadisticas.proyectos_activos}</p>
                        <p><strong>Presupuesto:</strong> ${formatCurrency(data.estadisticas.presupuesto_total)}</p>
                        <p><strong>Gasto:</strong> ${formatCurrency(data.estadisticas.gasto_total)}</p>
                        <p><strong>Saldo:</strong> ${formatCurrency(data.estadisticas.saldo_disponible)}</p>
                    </div>`,
                icon: 'info',
                confirmButtonColor: '#083CAE',
                width: 600
            });
        })
        .catch(() => { showLoading(false); showError('No se pudo cargar'); });
}

function editarContratista(id) {
    showLoading(true);
    fetch('/proyectos/api/contratistas/' + id, {
        headers: { 'Accept': 'application/json' }
    })
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
        .catch(() => { showLoading(false); showError('No se pudo cargar'); });
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
                headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }
            })
            .then(response => response.json())
            .then(data => {
                showLoading(false);
                showSuccess(data.message);
                cargarContratistas();
            })
            .catch(() => { showLoading(false); showError('No se pudo eliminar'); });
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
// DASHBOARD
// ============================================
function cargarDashboard() {
    fetch('/proyectos/api/contratistas/dashboard', {
        headers: { 'Accept': 'application/json' }
    })
        .then(response => {
            if (!response.ok) throw new Error('Dashboard no disponible');
            return response.json();
        })
        .then(data => {
            const kpis = data.kpis || {};
            document.getElementById('dashTotalContratistas').textContent = kpis.total_contratistas || 0;
            document.getElementById('dashActivos').textContent = kpis.activos || 0;
            document.getElementById('dashTotalProyectos').textContent = kpis.total_proyectos || 0;
            document.getElementById('dashPresupuestoTotal').textContent = formatCurrency(kpis.presupuesto_total || 0);
            document.getElementById('alertasNoLeidas').textContent = data.alertas_no_leidas || 0;
            
            if (data.top_contratistas && data.top_contratistas.length > 0) {
                let html = '';
                data.top_contratistas.forEach(item => {
                    html += `
                        <tr>
                            <td style="padding:8px 10px; border-bottom:1px solid #dee2e6;"><strong>${item.nombre_comercial}</strong></td>
                            <td style="padding:8px 10px; border-bottom:1px solid #dee2e6;">${item.especialidad || 'N/A'}</td>
                            <td style="padding:8px 10px; border-bottom:1px solid #dee2e6; text-align:right; color:#dc3545;">${formatCurrency(item.total_gasto || 0)}</td>
                        </tr>
                    `;
                });
                document.getElementById('topContratistasBody').innerHTML = html;
            } else {
                document.getElementById('topContratistasBody').innerHTML = '<tr><td colspan="3" style="text-align:center;padding:20px;color:#6c757d;">Sin datos</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error dashboard:', error);
            document.getElementById('topContratistasBody').innerHTML = '<tr><td colspan="3" style="text-align:center;padding:20px;color:#dc3545;">Error al cargar</td></tr>';
        });
    
    fetch('/proyectos/api/alertas?leida=0&per_page=5', {
        headers: { 'Accept': 'application/json' }
    })
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
        headers: { 'X-CSRF-TOKEN': token, 'Content-Type': 'application/json', 'Accept': 'application/json' }
    })
    .then(() => cargarDashboard())
    .catch(error => console.error('Error:', error));
}

// ============================================
// ASIGNACIONES
// ============================================
function cargarContratistasAsignacion() {
    const select = document.getElementById('asignacion_contratista_select');
    if (!select) return;
    
    select.innerHTML = '<option value="">⏳ Cargando contratistas...</option>';
    
    fetch('/proyectos/api/contratistas?per_page=999', {
        headers: { 'Accept': 'application/json' }
    })
        .then(response => response.json())
        .then(data => {
            select.innerHTML = '<option value="">Seleccionar contratista...</option>';
            if (data.data && data.data.length > 0) {
                data.data.forEach(c => {
                    select.innerHTML += `<option value="${c.id}">${c.codigo} - ${c.nombre_comercial} (${c.especialidad})</option>`;
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            select.innerHTML = '<option value="">Error al cargar</option>';
        });
}

function cargarProyectosAsignacion() {
    const select = document.getElementById('asignacion_proyecto');
    if (!select) return;
    
    select.innerHTML = '<option value="">⏳ Cargando proyectos...</option>';
    
    fetch('/api/proyectos', {
        headers: { 'Accept': 'application/json' }
    })
        .then(response => response.json())
        .then(response => {
            select.innerHTML = '<option value="">Seleccionar proyecto...</option>';
            if (response.success && Array.isArray(response.data)) {
                response.data.forEach(p => {
                    select.innerHTML += `<option value="${p.id}">${p.codigo} - ${p.nombre}</option>`;
                });
            } else if (Array.isArray(response)) {
                response.forEach(p => {
                    select.innerHTML += `<option value="${p.id}">${p.codigo} - ${p.nombre}</option>`;
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            select.innerHTML = '<option value="">Error al cargar</option>';
        });
}

function cargarPartidasAsignacion(proyectoId) {
    const select = document.getElementById('asignacion_partida');
    if (!select) return;
    
    if (!proyectoId) {
        select.innerHTML = '<option value="">Seleccionar partida...</option>';
        return;
    }
    
    select.innerHTML = '<option value="">⏳ Cargando...</option>';
    
    fetch('/api/proyectos/' + proyectoId + '/partidas', {
        headers: { 'Accept': 'application/json' }
    })
        .then(response => response.json())
        .then(data => {
            select.innerHTML = '<option value="">Seleccionar partida...</option>';
            const partidas = data.data || data || [];
            if (Array.isArray(partidas) && partidas.length > 0) {
                partidas.forEach(p => {
                    select.innerHTML += `<option value="${p.id}">${p.codigo || ''} ${p.nombre} ${p.unidad ? '(' + p.unidad + ')' : ''}</option>`;
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            select.innerHTML = '<option value="">Error al cargar</option>';
        });
}

function abrirModalAsignacion(contratistaId = null) {
    const form = document.getElementById('formAsignacion');
    if (form) form.reset();
    
    abrirModal('modalAsignacion');
    
    setTimeout(function() {
        cargarContratistasAsignacion();
        cargarProyectosAsignacion();
        
        if (contratistaId) {
            setTimeout(function() {
                const select = document.getElementById('asignacion_contratista_select');
                if (select) select.value = contratistaId;
            }, 800);
        }
    }, 200);
}

document.addEventListener('change', function(e) {
    if (e.target && e.target.id === 'asignacion_proyecto') {
        cargarPartidasAsignacion(e.target.value);
    }
});

function guardarAsignacion() {
    const form = document.getElementById('formAsignacion');
    const formData = new FormData(form);
    
    const contratistaId = document.getElementById('asignacion_contratista_select').value;
    const proyectoId = document.getElementById('asignacion_proyecto').value;
    const presupuesto = document.querySelector('input[name="presupuesto_asignado"]')?.value;
    
    if (!contratistaId) { showError('Selecciona un contratista'); return; }
    if (!proyectoId) { showError('Selecciona un proyecto'); return; }
    if (!presupuesto || parseFloat(presupuesto) <= 0) { showError('Ingresa un presupuesto válido'); return; }
    
    showLoading(true);
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    fetch('/proyectos/api/asignaciones', {
        method: 'POST',
        body: formData,
        headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }
    })
    .then(response => response.json().then(data => ({ ok: response.ok, data })))
    .then(({ ok, data }) => {
        showLoading(false);
        if (ok && data.message) {
            showSuccess(data.message);
            cerrarModal('modalAsignacion');
            form.reset();
            cargarAsignaciones();
        } else if (data.errors) {
            showError('Errores:\n' + Object.values(data.errors).flat().join('\n'));
        } else {
            showError(data.message || 'Error al guardar');
        }
    })
    .catch(error => {
        showLoading(false);
        showError('Error: ' + error.message);
    });
}

function cargarAsignaciones() {
    showLoading(true);
    fetch('/proyectos/api/asignaciones', {
        headers: { 'Accept': 'application/json' }
    })
        .then(response => response.json())
        .then(data => {
            renderizarTablaAsignaciones(data.data || []);
            showLoading(false);
        })
        .catch(error => {
            console.error('Error:', error);
            showLoading(false);
        });
}

function renderizarTablaAsignaciones(data) {
    const tbody = document.getElementById('tablaAsignacionesBody');
    if (!tbody) return;
    
    if (data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="9" style="text-align:center; padding:40px; color:#6c757d;"><i class="fas fa-info-circle"></i> No hay asignaciones registradas</td></tr>';
        return;
    }
    
    let html = '';
    data.forEach(a => {
        const statusBadge = a.status === 'finalizado' ? 'success' : 
                           (a.status === 'en_progreso' ? 'primary' : 
                           (a.status === 'pausado' ? 'warning' : 'secondary'));
        const avanceColor = a.avance_porcentaje >= 90 ? '#28a745' : 
                           (a.avance_porcentaje >= 50 ? '#ffc107' : '#17a2b8');
        
        html += `
            <tr>
                <td style="padding:10px 6px;">${a.contratista?.nombre_comercial || 'N/A'}</td>
                <td style="padding:10px 6px;">${a.proyecto?.nombre || 'N/A'}</td>
                <td style="padding:10px 6px;">${a.seccion || 'N/A'}</td>
                <td style="padding:10px 6px; text-align:right; color:#083CAE; font-weight:600;">${formatCurrency(a.presupuesto_asignado)}</td>
                <td style="padding:10px 6px; text-align:right; color:#dc3545;">${formatCurrency(a.gasto_acumulado)}</td>
                <td style="padding:10px 6px; text-align:right; color:#28a745;">${formatCurrency(a.saldo_disponible)}</td>
                <td style="padding:10px 6px; text-align:center;">
                    <div style="background:#e9ecef; border-radius:4px; height:20px; overflow:hidden;">
                        <div style="background:${avanceColor}; width:${a.avance_porcentaje}%; height:100%; display:flex; align-items:center; justify-content:center; font-size:11px; color:white; font-weight:bold;">${a.avance_porcentaje}%</div>
                    </div>
                </td>
                <td style="padding:10px 6px; text-align:center;"><span class="badge badge-${statusBadge}">${a.status.replace('_', ' ').toUpperCase()}</span></td>
                <td style="padding:10px 6px; text-align:center;">
                    <div style="display:flex; gap:5px; justify-content:center;">
                        <button onclick="abrirModalGastoConAsignacion(${a.id})" style="background:#28a745; color:white; border:none; border-radius:4px; padding:4px 8px; cursor:pointer;" title="Registrar Gasto"><i class="fas fa-plus-circle"></i></button>
                        <button onclick="verAsignacion(${a.id})" style="background:#083CAE; color:white; border:none; border-radius:4px; padding:4px 8px; cursor:pointer;" title="Ver"><i class="fas fa-eye"></i></button>
                    </div>
                </td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
}

function verAsignacion(id) {
    fetch('/proyectos/api/asignaciones/' + id, {
        headers: { 'Accept': 'application/json' }
    })
        .then(response => response.json())
        .then(data => {
            const a = data.asignacion;
            Swal.fire({
                title: 'Detalle de Asignación',
                html: `
                    <div style="text-align:left;">
                        <p><strong>Contratista:</strong> ${a.contratista?.nombre_comercial || 'N/A'}</p>
                        <p><strong>Proyecto:</strong> ${a.proyecto?.nombre || 'N/A'}</p>
                        <p><strong>Sección:</strong> ${a.seccion || 'N/A'}</p>
                        <p><strong>Presupuesto:</strong> ${formatCurrency(a.presupuesto_asignado)}</p>
                        <p><strong>Gasto:</strong> ${formatCurrency(a.gasto_acumulado)}</p>
                        <p><strong>Saldo:</strong> ${formatCurrency(a.saldo_disponible)}</p>
                        <p><strong>Avance:</strong> ${a.avance_porcentaje}%</p>
                    </div>`,
                icon: 'info',
                confirmButtonColor: '#083CAE'
            });
        })
        .catch(() => showError('No se pudo cargar'));
}

// ============================================
// GASTOS
// ============================================
function cargarGastos() {
    showLoading(true);
    fetch('/proyectos/api/gastos', {
        headers: { 'Accept': 'application/json' }
    })
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
        tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:40px; color:#6c757d;"><i class="fas fa-info-circle"></i> No hay gastos registrados</td></tr>';
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
                <td style="padding:10px 6px;">${g.asignacion?.proyecto?.nombre || 'N/A'}</td>
                <td style="padding:10px 6px;">${g.concepto}</td>
                <td style="padding:10px 6px;">${g.tipo_gasto}</td>
                <td style="padding:10px 6px; text-align:right; color:#dc3545; font-weight:600;">${formatCurrency(g.monto)}</td>
                <td style="padding:10px 6px; text-align:center;"><span class="badge ${statusBadge}">${statusText}</span></td>
                <td style="padding:10px 6px; text-align:center;">
                    <div style="display:flex; gap:5px; justify-content:center;">
                        <button onclick="verGasto(${g.id})" style="background:#083CAE; color:white; border:none; border-radius:4px; padding:4px 8px; cursor:pointer;" title="Ver"><i class="fas fa-eye"></i></button>
                        ${g.status_pago !== 'pagado' ? `
                            <button onclick="abrirModalPagoGasto(${g.id})" style="background:#28a745; color:white; border:none; border-radius:4px; padding:4px 8px; cursor:pointer;" title="Marcar Pagado"><i class="fas fa-money-bill-wave"></i></button>
                        ` : ''}
                    </div>
                </td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
}

function verGasto(id) {
    fetch('/proyectos/api/gastos/' + id, {
        headers: { 'Accept': 'application/json' }
    })
        .then(response => response.json())
        .then(data => {
            const g = data.gasto || data;
            Swal.fire({
                title: 'Detalle del Gasto',
                html: `
                    <div style="text-align:left;">
                        <p><strong>Concepto:</strong> ${g.concepto}</p>
                        <p><strong>Descripción:</strong> ${g.descripcion || 'N/A'}</p>
                        <p><strong>Tipo:</strong> ${g.tipo_gasto}</p>
                        <p><strong>Monto:</strong> ${formatCurrency(g.monto)}</p>
                        <p><strong>Fecha:</strong> ${new Date(g.fecha_gasto).toLocaleDateString()}</p>
                        <p><strong>Status:</strong> ${g.status_pago.toUpperCase()}</p>
                    </div>`,
                icon: 'info',
                confirmButtonColor: '#083CAE'
            });
        })
        .catch(() => showError('No se pudo cargar'));
}

// 🔥 FUNCIÓN CLAVE: Abrir modal de gasto NUEVO (desde botón "Nuevo Gasto")
function abrirModalGastoNuevo() {
    console.log('🔵 [abrirModalGastoNuevo] Abriendo modal...');
    
    const form = document.getElementById('formGasto');
    if (form) form.reset();
    
    // ⚠️ Resetear GLOBAL
    window.currentAsignacionGasto = null;
    
    // Resetear selects
    document.getElementById('gasto_contratista_select').innerHTML = '<option value="">Cargando contratistas...</option>';
    document.getElementById('gasto_proyecto_select').innerHTML = '<option value="">Primero selecciona contratista</option>';
    document.getElementById('gasto_proyecto_select').disabled = true;
    document.getElementById('gasto_asignacion_select').innerHTML = '<option value="">Primero selecciona proyecto</option>';
    document.getElementById('gasto_asignacion_select').disabled = true;
    document.getElementById('gasto_presupuesto_info').style.display = 'none';
    document.getElementById('gasto_validacion_monto').style.display = 'none';
    document.getElementById('gasto_asignacion_id').value = '';
    
    abrirModal('modalGasto');
    
    // Cargar contratistas
    fetch('/proyectos/api/contratistas?per_page=999', {
        headers: { 'Accept': 'application/json' }
    })
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('gasto_contratista_select');
            select.innerHTML = '<option value="">Seleccionar contratista...</option>';
            if (data.data) {
                data.data.forEach(c => {
                    select.innerHTML += `<option value="${c.id}">${c.codigo} - ${c.nombre_comercial}</option>`;
                });
            }
            console.log('✅ Contratistas cargados en modal de gasto');
        })
        .catch(error => console.error('❌ Error:', error));
}

// 🔥 FUNCIÓN CLAVE: Abrir modal de gasto con asignación PREDEFINIDA
function abrirModalGastoConAsignacion(asignacionId) {
    console.log('🔵 [abrirModalGastoConAsignacion] Asignación:', asignacionId);
    
    // Primero abrir el modal
    abrirModalGastoNuevo();
    
    // Esperar a que se carguen los contratistas y luego precargar
    setTimeout(() => {
        // Cargar info de la asignación
        fetch('/proyectos/api/asignaciones/' + asignacionId, {
            headers: { 'Accept': 'application/json' }
        })
            .then(response => response.json())
            .then(data => {
                console.log('📥 [abrirModalGastoConAsignacion] Datos:', data);
                
                if (!data.asignacion) {
                    console.error('❌ No se recibió asignación');
                    return;
                }
                
                const a = data.asignacion;
                
                // Seleccionar contratista
                const cSelect = document.getElementById('gasto_contratista_select');
                cSelect.value = a.contratista_id;
                console.log('✅ Contratista seleccionado:', a.contratista_id);
                
                // Cargar proyectos
                cargarProyectosGasto(a.contratista_id);
                
                setTimeout(() => {
                    // Seleccionar proyecto
                    const pSelect = document.getElementById('gasto_proyecto_select');
                    pSelect.value = a.proyecto_id;
                    console.log('✅ Proyecto seleccionado:', a.proyecto_id);
                    
                    // Cargar asignaciones
                    cargarAsignacionesGasto(a.contratista_id, a.proyecto_id);
                    
                    setTimeout(() => {
                        // Seleccionar asignación
                        const aSelect = document.getElementById('gasto_asignacion_select');
                        aSelect.value = asignacionId;
                        console.log('✅ Asignación seleccionada:', asignacionId);
                        
                        // 🔥 CRÍTICO: Disparar manualmente el change para que se cargue la info
                        aSelect.dispatchEvent(new Event('change', { bubbles: true }));
                    }, 500);
                }, 500);
            })
            .catch(error => console.error('❌ Error:', error));
    }, 800);
}

function cargarProyectosGasto(contratistaId) {
    const select = document.getElementById('gasto_proyecto_select');
    select.innerHTML = '<option value="">Cargando proyectos...</option>';
    select.disabled = false;
    
    if (!contratistaId) {
        select.innerHTML = '<option value="">Primero selecciona contratista</option>';
        select.disabled = true;
        return;
    }
    
    fetch('/proyectos/api/asignaciones?contratista_id=' + contratistaId, {
        headers: { 'Accept': 'application/json' }
    })
        .then(response => response.json())
        .then(data => {
            const proyectos = {};
            if (data.data) {
                data.data.forEach(a => {
                    if (a.proyecto && !proyectos[a.proyecto.id]) {
                        proyectos[a.proyecto.id] = a.proyecto;
                    }
                });
            }
            
            select.innerHTML = '<option value="">Seleccionar proyecto...</option>';
            Object.values(proyectos).forEach(p => {
                select.innerHTML += `<option value="${p.id}">${p.codigo || ''} - ${p.nombre}</option>`;
            });
            console.log('✅ Proyectos cargados:', Object.keys(proyectos).length);
        })
        .catch(error => console.error('❌ Error:', error));
}

function cargarAsignacionesGasto(contratistaId, proyectoId) {
    const select = document.getElementById('gasto_asignacion_select');
    select.innerHTML = '<option value="">Cargando asignaciones...</option>';
    select.disabled = false;
    
    if (!contratistaId || !proyectoId) {
        select.innerHTML = '<option value="">Primero selecciona proyecto</option>';
        select.disabled = true;
        return;
    }
    
    fetch(`/proyectos/api/asignaciones?contratista_id=${contratistaId}&proyecto_id=${proyectoId}`, {
        headers: { 'Accept': 'application/json' }
    })
        .then(response => response.json())
        .then(data => {
            select.innerHTML = '<option value="">Seleccionar asignación...</option>';
            if (data.data && data.data.length > 0) {
                data.data.forEach(a => {
                    select.innerHTML += `<option value="${a.id}">${a.seccion || 'General'} - Presupuesto: ${formatCurrency(a.presupuesto_asignado)} - Saldo: ${formatCurrency(a.saldo_disponible)}</option>`;
                });
                console.log('✅ Asignaciones cargadas:', data.data.length);
            } else {
                select.innerHTML = '<option value="">No hay asignaciones para esta combinación</option>';
            }
        })
        .catch(error => console.error('❌ Error:', error));
}

// Eventos de cascada para gasto
document.addEventListener('change', function(e) {
    // Cuando se selecciona CONTRATISTA
    if (e.target && e.target.id === 'gasto_contratista_select') {
        console.log('🔄 Contratista cambiado:', e.target.value);
        document.getElementById('gasto_proyecto_select').innerHTML = '<option value="">Cargando...</option>';
        document.getElementById('gasto_asignacion_select').innerHTML = '<option value="">Primero selecciona proyecto</option>';
        document.getElementById('gasto_asignacion_select').disabled = true;
        document.getElementById('gasto_presupuesto_info').style.display = 'none';
        window.currentAsignacionGasto = null;
        cargarProyectosGasto(e.target.value);
    }
    
    // Cuando se selecciona PROYECTO
    if (e.target && e.target.id === 'gasto_proyecto_select') {
        console.log('🔄 Proyecto cambiado:', e.target.value);
        const contratistaId = document.getElementById('gasto_contratista_select').value;
        document.getElementById('gasto_asignacion_select').innerHTML = '<option value="">Cargando...</option>';
        document.getElementById('gasto_presupuesto_info').style.display = 'none';
        window.currentAsignacionGasto = null;
        cargarAsignacionesGasto(contratistaId, e.target.value);
    }
    
    // Cuando se selecciona ASIGNACIÓN - 🔥 CRÍTICO
    if (e.target && e.target.id === 'gasto_asignacion_select') {
        const asignacionId = e.target.value;
        console.log('🔄 [change] Asignación seleccionada:', asignacionId);
        
        document.getElementById('gasto_asignacion_id').value = asignacionId;
        
        if (asignacionId) {
            fetch('/proyectos/api/asignaciones/' + asignacionId, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => {
                    if (!response.ok) throw new Error('HTTP ' + response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('📥 [change] Datos asignación:', data);
                    
                    if (!data.asignacion) {
                        console.warn('⚠️ Respuesta sin asignación:', data);
                        document.getElementById('gasto_presupuesto_info').style.display = 'none';
                        window.currentAsignacionGasto = null;
                        return;
                    }
                    
                    const a = data.asignacion;
                    document.getElementById('gasto_presupuesto_asignado').textContent = formatCurrency(a.presupuesto_asignado);
                    document.getElementById('gasto_presupuesto_gastado').textContent = formatCurrency(a.gasto_acumulado);
                    document.getElementById('gasto_presupuesto_disponible').textContent = formatCurrency(a.saldo_disponible);
                    document.getElementById('gasto_presupuesto_info').style.display = 'block';
                    
                    // 🔥 GUARDAR GLOBAL
                    window.currentAsignacionGasto = a;
                    console.log('✅ [change] currentAsignacionGasto GUARDADA:', a.id);
                    
                    validarMontoGasto();
                })
                .catch(error => {
                    console.error('❌ [change] Error:', error);
                    document.getElementById('gasto_presupuesto_info').style.display = 'none';
                    window.currentAsignacionGasto = null;
                });
        } else {
            document.getElementById('gasto_presupuesto_info').style.display = 'none';
            window.currentAsignacionGasto = null;
        }
    }
});

// Validar monto en vivo
function validarMontoGasto() {
    const montoInput = document.getElementById('gasto_monto');
    const monto = parseFloat(montoInput.value) || 0;
    const asignacion = window.currentAsignacionGasto;
    
    const div = document.getElementById('gasto_validacion_monto');
    const texto = document.getElementById('gasto_validacion_texto');
    const btnGuardar = document.getElementById('btnGuardarGasto');
    
    if (!asignacion || monto <= 0) {
        div.style.display = 'none';
        if (btnGuardar) {
            btnGuardar.disabled = false;
            btnGuardar.style.opacity = '1';
            btnGuardar.style.cursor = 'pointer';
        }
        return;
    }
    
    const disponible = parseFloat(asignacion.saldo_disponible) || 0;
    
    if (monto > disponible) {
        div.style.display = 'block';
        div.style.background = '#f8d7da';
        div.style.color = '#721c24';
        div.style.border = '1px solid #f5c6cb';
        texto.innerHTML = `<strong>⚠️ El monto excede el presupuesto disponible.</strong><br>Disponible: ${formatCurrency(disponible)} | Solicitado: ${formatCurrency(monto)}`;
        if (btnGuardar) {
            btnGuardar.disabled = true;
            btnGuardar.style.opacity = '0.5';
            btnGuardar.style.cursor = 'not-allowed';
        }
    } else {
        div.style.display = 'block';
        div.style.background = '#d4edda';
        div.style.color = '#155724';
        div.style.border = '1px solid #c3e6cb';
        const nuevoSaldo = disponible - monto;
        texto.innerHTML = `<strong>✓ Monto válido.</strong> Saldo después del gasto: ${formatCurrency(nuevoSaldo)}`;
        if (btnGuardar) {
            btnGuardar.disabled = false;
            btnGuardar.style.opacity = '1';
            btnGuardar.style.cursor = 'pointer';
        }
    }
}

document.addEventListener('input', function(e) {
    if (e.target && e.target.id === 'gasto_monto') {
        validarMontoGasto();
    }
});

// 🔥 GUARDAR GASTO - LEER DEL SELECT DIRECTAMENTE
function guardarGasto() {
    console.log('🔍 [guardarGasto] Iniciando...');
    
    const form = document.getElementById('formGasto');
    
    // ⚠️ CLAVE: Leer del SELECT directamente, NO del hidden
    const asignacionSelect = document.getElementById('gasto_asignacion_select');
    const asignacionId = asignacionSelect ? asignacionSelect.value : '';
    
    const monto = parseFloat(document.getElementById('gasto_monto').value) || 0;
    const asignacion = window.currentAsignacionGasto;
    
    console.log('🔍 [guardarGasto] Datos:', {
        asignacionId,
        monto,
        asignacionCache: asignacion ? 'sí (id=' + asignacion.id + ')' : 'no',
        tipoGasto: form.querySelector('select[name="tipo_gasto"]').value,
        concepto: form.querySelector('input[name="concepto"]').value
    });
    
    // Validaciones
    if (!asignacionId) {
        showError('Selecciona una asignación');
        return;
    }
    
    if (!asignacion) {
        showError('Espera a que se cargue la información de la asignación');
        return;
    }
    
    if (monto <= 0) {
        showError('Ingresa un monto válido');
        return;
    }
    
    if (monto > parseFloat(asignacion.saldo_disponible || 0)) {
        Swal.fire({
            icon: 'error',
            title: 'Presupuesto insuficiente',
            html: `
                <p>El monto ingresado excede el presupuesto disponible.</p>
                <p><strong>Disponible:</strong> ${formatCurrency(asignacion.saldo_disponible)}</p>
                <p><strong>Solicitado:</strong> ${formatCurrency(monto)}</p>
            `,
            confirmButtonColor: '#083CAE'
        });
        return;
    }
    
    // 🔥 CRÍTICO: Construir FormData y FORZAR asignacion_id
    const formData = new FormData(form);
    formData.set('asignacion_id', asignacionId);
    formData.set('monto', monto);
    
    console.log('📤 [guardarGasto] FormData a enviar:');
    for (let [key, value] of formData.entries()) {
        console.log(`  ${key}: ${value}`);
    }
    
    showLoading(true);
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    fetch('/proyectos/api/gastos', {
        method: 'POST',
        body: formData,
        headers: { 
            'X-CSRF-TOKEN': token, 
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        console.log('📥 [guardarGasto] Response status:', response.status);
        return response.json().then(data => ({ ok: response.ok, status: response.status, data }));
    })
    .then(({ ok, status, data }) => {
        showLoading(false);
        console.log('📥 [guardarGasto] Response data:', data);
        
        if (ok && data.success && data.message) {
            showSuccess(data.message);
            cerrarModal('modalGasto');
            form.reset();
            document.getElementById('gasto_presupuesto_info').style.display = 'none';
            document.getElementById('gasto_validacion_monto').style.display = 'none';
            window.currentAsignacionGasto = null;
            cargarGastos();
            cargarAsignaciones();
            cargarDashboard();
        } else if (data.errors) {
            console.error('❌ [guardarGasto] Errores de validación:', data.errors);
            const errores = Object.entries(data.errors)
                .map(([campo, msgs]) => `• ${campo}: ${msgs.join(', ')}`)
                .join('\n');
            showError('Errores de validación:\n' + errores);
        } else {
            showError(data.message || 'Error al registrar el gasto');
        }
    })
    .catch(error => {
        showLoading(false);
        console.error('❌ [guardarGasto] Error:', error);
        showError('Error: ' + error.message);
    });
}

// ============================================
// PAGOS
// ============================================
function cargarPagos() {
    showLoading(true);
    fetch('/proyectos/api/pagos', {
        headers: { 'Accept': 'application/json' }
    })
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
        tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:40px; color:#6c757d;"><i class="fas fa-info-circle"></i> No hay pagos registrados</td></tr>';
        return;
    }
    
    const formaLabels = { 'transferencia': 'Transferencia', 'cheque': 'Cheque', 'efectivo': 'Efectivo' };
    
    let html = '';
    data.forEach(p => {
        html += `
            <tr>
                <td style="padding:10px 6px; text-align:center; font-weight:bold;">${p.folio}</td>
                <td style="padding:10px 6px; text-align:center;">${new Date(p.fecha_pago).toLocaleDateString()}</td>
                <td style="padding:10px 6px;">${p.contratista?.nombre_comercial || 'N/A'}</td>
                <td style="padding:10px 6px; text-align:right; color:#28a745; font-weight:600;">${formatCurrency(p.monto)}</td>
                <td style="padding:10px 6px; text-align:center;"><span class="badge badge-info">${formaLabels[p.forma_pago] || p.forma_pago}</span></td>
                <td style="padding:10px 6px; text-align:center;">${p.cuenta_bancaria || 'N/A'}</td>
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
    fetch('/proyectos/api/pagos/' + id, {
        headers: { 'Accept': 'application/json' }
    })
        .then(response => response.json())
        .then(data => {
            Swal.fire({
                title: 'Detalle del Pago',
                html: `
                    <div style="text-align:left;">
                        <p><strong>Folio:</strong> ${data.folio}</p>
                        <p><strong>Fecha:</strong> ${new Date(data.fecha_pago).toLocaleDateString()}</p>
                        <p><strong>Contratista:</strong> ${data.contratista?.nombre_comercial || 'N/A'}</p>
                        <p><strong>Monto:</strong> ${formatCurrency(data.monto)}</p>
                        <p><strong>Forma:</strong> ${data.forma_pago}</p>
                        <p><strong>Cuenta:</strong> ${data.cuenta_bancaria || 'N/A'}</p>
                        <p><strong>Referencia:</strong> ${data.referencia || 'N/A'}</p>
                    </div>`,
                icon: 'info',
                confirmButtonColor: '#083CAE'
            });
        })
        .catch(() => showError('No se pudo cargar'));
}

function abrirModalPagoNuevo() {
    const form = document.getElementById('formPago');
    if (form) form.reset();
    
    document.getElementById('pago_asignacion_container').style.display = 'block';
    document.getElementById('infoContratistaTexto').innerHTML = 'Selecciona una asignación para cargar la información...';
    
    const select = document.getElementById('pago_asignacion_select');
    select.innerHTML = '<option value="">Cargando asignaciones...</option>';
    
    fetch('/proyectos/api/asignaciones', {
        headers: { 'Accept': 'application/json' }
    })
        .then(response => response.json())
        .then(data => {
            select.innerHTML = '<option value="">Seleccionar asignación...</option>';
            if (data.data) {
                data.data.forEach(a => {
                    select.innerHTML += `<option value="${a.id}">${a.contratista?.nombre_comercial || 'N/A'} - ${a.proyecto?.nombre || 'N/A'} - Saldo: ${formatCurrency(a.saldo_disponible)}</option>`;
                });
            }
        })
        .catch(error => console.error('Error:', error));
    
    abrirModal('modalPago');
}

// Abrir modal de pago para un GASTO específico
function abrirModalPagoGasto(gastoId) {
    fetch('/proyectos/api/gastos/' + gastoId, {
        headers: { 'Accept': 'application/json' }
    })
        .then(response => response.json())
        .then(response => {
            // Manejar ambas estructuras de respuesta
            const gasto = response.gasto || response;
            
            if (!gasto || !gasto.id) {
                throw new Error('Gasto no encontrado');
            }
            
            document.getElementById('pago_gasto_id').value = gasto.id;
            document.getElementById('pago_contratista_id').value = gasto.contratista_id || '';
            document.getElementById('pago_asignacion_id').value = gasto.asignacion_id || '';
            document.getElementById('pago_monto').value = gasto.monto || 0;
            
            const contratistaNombre = gasto.contratista?.nombre_comercial || 'N/A';
            const proyectoNombre = gasto.asignacion?.proyecto?.nombre || 'N/A';
            
            document.getElementById('infoContratistaTexto').innerHTML = `
                <strong>Contratista:</strong> ${contratistaNombre} | 
                <strong>Proyecto:</strong> ${proyectoNombre} |
                <strong>Concepto:</strong> ${gasto.concepto || 'N/A'} |
                <strong>Monto:</strong> ${formatCurrency(gasto.monto || 0)}
            `;
            
            document.getElementById('pago_asignacion_container').style.display = 'none';
            abrirModal('modalPago');
        })
        .catch(error => {
            console.error('Error:', error);
            showError('No se pudo cargar el gasto: ' + error.message);
        });
}

// Evento para select de asignación en modal de pago nuevo
document.addEventListener('change', function(e) {
    if (e.target && e.target.id === 'pago_asignacion_select') {
        const asignacionId = e.target.value;
        if (asignacionId) {
            fetch('/proyectos/api/asignaciones/' + asignacionId, {
                headers: { 'Accept': 'application/json' }
            })
                .then(response => response.json())
                .then(data => {
                    const a = data.asignacion;
                    document.getElementById('pago_contratista_id').value = a.contratista_id;
                    document.getElementById('pago_asignacion_id').value = a.id;
                    
                    document.getElementById('infoContratistaTexto').innerHTML = `
                        <strong>Contratista:</strong> ${a.contratista?.nombre_comercial || 'N/A'} | 
                        <strong>Proyecto:</strong> ${a.proyecto?.nombre || 'N/A'} |
                        <strong>Presupuesto:</strong> ${formatCurrency(a.presupuesto_asignado)} |
                        <strong>Gasto:</strong> ${formatCurrency(a.gasto_acumulado)} |
                        <strong>Saldo:</strong> ${formatCurrency(a.saldo_disponible)}
                    `;
                })
                .catch(error => console.error('Error:', error));
        }
    }
});

function guardarPago() {
    const form = document.getElementById('formPago');
    
    // Validaciones cliente
    const contratistaId = document.getElementById('pago_contratista_id').value;
    const asignacionId = document.getElementById('pago_asignacion_id').value;
    const monto = document.getElementById('pago_monto').value;
    const formaPago = form.querySelector('select[name="forma_pago"]').value;
    const cuentaBancaria = form.querySelector('input[name="cuenta_bancaria"]').value.trim();
    
    if (!contratistaId) { showError('Falta el contratista'); return; }
    if (!asignacionId) { showError('Selecciona una asignación'); return; }
    if (!monto || parseFloat(monto) <= 0) { showError('Ingresa un monto válido'); return; }
    if (!formaPago) { showError('Selecciona la forma de pago'); return; }
    if (!cuentaBancaria) { showError('Ingresa la cuenta bancaria'); return; }
    
    const formData = new FormData(form);
    formData.set('contratista_id', contratistaId);
    formData.set('asignacion_id', asignacionId);
    formData.set('monto', monto);
    formData.set('forma_pago', formaPago);
    formData.set('cuenta_bancaria', cuentaBancaria);
    
    showLoading(true);
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    fetch('/proyectos/api/pagos', {
        method: 'POST',
        body: formData,
        headers: { 
            'X-CSRF-TOKEN': token, 
            'Accept': 'application/json'
        }
    })
    .then(response => response.json().then(data => ({ ok: response.ok, data })))
    .then(({ ok, data }) => {
        showLoading(false);
        
        if (ok && data.success && data.message) {
            showSuccess(data.message);
            cerrarModal('modalPago');
            form.reset();
            document.getElementById('pago_asignacion_container').style.display = 'block';
            cargarPagos();
            cargarGastos();
            cargarAsignaciones();
            cargarDashboard();
        } else if (data.errors) {
            const errores = Object.values(data.errors).flat().join('\n');
            showError('Errores de validación:\n' + errores);
        } else {
            showError(data.message || 'Error al registrar el pago');
        }
    })
    .catch(error => {
        showLoading(false);
        showError('Error: ' + error.message);
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
                headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }
            })
            .then(response => response.json())
            .then(data => {
                showLoading(false);
                showSuccess(data.message);
                cargarPagos();
                cargarGastos();
            })
            .catch(() => { showLoading(false); showError('No se pudo eliminar'); });
        }
    });
}

// ============================================
// INICIALIZACIÓN
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 [DOMContentLoaded] Módulo Contratistas iniciado');
    console.log('🔧 currentAsignacionGasto inicializado:', window.currentAsignacionGasto);
    
    cambiarSeccion('listado');
    
    // Filtros de contratistas
    document.getElementById('searchContratista')?.addEventListener('input', cargarContratistas);
    document.getElementById('filtroEspecialidad')?.addEventListener('change', cargarContratistas);
    document.getElementById('filtroRiesgo')?.addEventListener('change', cargarContratistas);
    document.getElementById('filtroStatus')?.addEventListener('change', cargarContratistas);
    
    // Filtros de asignaciones
    document.getElementById('filtroStatusAsignacion')?.addEventListener('change', cargarAsignaciones);
    document.getElementById('searchAsignacion')?.addEventListener('input', cargarAsignaciones);
    
    // Filtros de gastos
    document.getElementById('filtroTipoGasto')?.addEventListener('change', cargarGastos);
    document.getElementById('filtroStatusPagoGasto')?.addEventListener('change', cargarGastos);
    document.getElementById('searchGasto')?.addEventListener('input', cargarGastos);
    
    // Filtros de pagos
    document.getElementById('filtroFormaPago')?.addEventListener('change', cargarPagos);
    document.getElementById('filtroFechaPago')?.addEventListener('change', cargarPagos);
    document.getElementById('searchPago')?.addEventListener('input', cargarPagos);
});
</script>
@endsection