@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Personal Asignado a Proyectos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Personal Asignado a Proyectos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE PERSONAL -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Personal</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalPersonal">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">En Obra</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalEnObra">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Administrativos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalAdmin">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Costo Mensual</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="costoMensual">$0</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Selectores a la izquierda -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <!-- Filtro de Proyectos - Dropdown con checkboxes -->
                        <div style="position: relative; min-width: 200px;" id="proyectoFilterContainer">
                            <button type="button" id="btnFiltroProyectos" style="width: 100%; padding: 6px 12px; border: 1px solid #ced4da; border-radius: 4px; background-color: white; cursor: pointer; font-size: 14px; display: flex; justify-content: space-between; align-items: center; min-height: 38px;">
                                <span id="filtroProyectosLabel">Todos los proyectos</span>
                                <i class="fas fa-chevron-down" style="color: #6c757d; font-size: 12px;"></i>
                            </button>
                            
                            <div id="filtroProyectosDropdown" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ced4da; border-radius: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 1000; max-height: 280px; overflow: hidden; padding: 8px 0; margin-top: 2px;">
                                <div style="padding: 0 12px 8px 12px; border-bottom: 1px solid #e9ecef;">
                                    <input type="text" id="filtroProyectosBuscar" placeholder="Buscar proyecto..." style="width: 100%; padding: 6px 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                                </div>
                                <div id="filtroProyectosLista" style="max-height: 180px; overflow-y: auto; padding: 8px 0;">
                                    <!-- Los checkboxes se cargarán dinámicamente -->
                                </div>
                                <div style="padding: 8px 12px; border-top: 1px solid #e9ecef; display: flex; gap: 10px; flex-wrap: wrap;">
                                    <button id="btnSeleccionarTodos" style="background: none; border: none; color: #083CAE; cursor: pointer; font-size: 12px; font-weight: 600;">Seleccionar todos</button>
                                    <button id="btnDeseleccionarTodos" style="background: none; border: none; color: #6c757d; cursor: pointer; font-size: 12px;">Deseleccionar todos</button>
                                    <button id="btnCerrarFiltro" style="background: none; border: none; color: #dc3545; cursor: pointer; font-size: 12px; margin-left: auto;">Cerrar</button>
                                </div>
                            </div>
                        </div>

                        <select id="selectorTipo" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 150px;">
                            <option value="">Todos los tipos</option>
                            <option value="obrero">👷 Obreros</option>
                            <option value="operador">🚜 Operadores</option>
                            <option value="supervisor">📋 Supervisores</option>
                            <option value="ingeniero">🎓 Ingenieros</option>
                            <option value="administrativo">💼 Administrativos</option>
                        </select>

                        <select id="selectorStatus" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 150px;">
                            <option value="">Todos los status</option>
                            <option value="activo">✅ Activo</option>
                            <option value="inactivo">❌ Inactivo</option>
                            <option value="vacaciones">🏖️ Vacaciones</option>
                            <option value="permiso">📋 Permiso</option>
                        </select>
                    </div>
                    
                    <!-- Grupo de botones derecho -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <button id="btnAgregar" style="background-color: #28a745; border: none; border-radius: 4px; padding: 8px 16px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: white;" title="Agregar Personal">
                                <i class="fas fa-plus-circle"></i> Agregar
                            </button>
                        </div>
                        <div>
                            <button id="btnExcel" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;" title="Exportar a Excel">
                                <i class="fas fa-file-excel" style="color: #083CAE;"></i>
                                Exportar
                            </button>
                        </div>
                        <div>
                            <button id="btnReporte" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;" title="Generar reporte">
                                <i class="fas fa-file-pdf" style="color: #083CAE;"></i>
                            </button>
                        </div>
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar personal..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Loading -->
                <div id="loadingSpinner" style="text-align: center; padding: 40px; display: none;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #083CAE;"></i>
                    <p style="margin-top: 10px; color: #6c757d;">Cargando personal...</p>
                </div>

                <!-- Mensaje "Sin datos" -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-users" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay personal asignado para mostrar</p>
                </div>

                <!-- Tabla de Personal Asignado -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaPersonal" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">No. Empleado</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Nombre</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Tipo</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Proyecto</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Rol</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Fecha Ingreso</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Salario Diario</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Status</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <!-- Las filas se insertarán dinámicamente -->
                        </tbody>
                        <tfoot id="tablaFoot" style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold; display: table-footer-group;">
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="6">Totales:</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumSalarios">$0/día</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; gap: 5px;">
                    <div style="visibility: hidden;"></div>
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <button id="btnPrimera" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-double-left"></i></button>
                        <button id="btnAnterior" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-left"></i></button>
                        <span id="paginaActual" style="padding: 5px 12px; background-color: #2378e1; color: white; border-radius: 4px;">1</span>
                        <span id="totalPaginas" style="margin-left: 5px; color: #6c757d;">de 1</span>
                        <button id="btnSiguiente" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-right"></i></button>
                        <button id="btnUltima" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-double-right"></i></button>
                        <span id="paginacionInfo" style="margin-left: 10px; color: #2378e1;"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Agregar Asignación -->
<div id="modalAgregar" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 700px; max-height: 90vh; overflow-y: auto; position: relative; z-index: 100000; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white;"><i class="fas fa-user-plus"></i> Asignar Personal</h3>
            <button id="btnCerrarModal" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
            <form id="formAgregar">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Empleado <span style="color: #dc3545;">*</span></label>
                        <select id="campoEmpleado" name="empleado_id" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Seleccionar empleado...</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Proyecto <span style="color: #dc3545;">*</span></label>
                        <select id="campoProyecto" name="proyecto_id" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Seleccionar proyecto...</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Tipo <span style="color: #dc3545;">*</span></label>
                        <select id="campoTipo" name="tipo_personal" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Seleccionar tipo...</option>
                            <option value="obrero">👷 Obrero</option>
                            <option value="operador">🚜 Operador</option>
                            <option value="supervisor">📋 Supervisor</option>
                            <option value="ingeniero">🎓 Ingeniero</option>
                            <option value="administrativo">💼 Administrativo</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Rol <span style="color: #dc3545;">*</span></label>
                        <input type="text" id="campoRol" name="rol" required placeholder="Ej. Albañil, Supervisor, etc." style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Fecha Asignación</label>
                        <input type="date" id="campoFechaAsignacion" name="fecha_asignacion" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Salario Diario <span style="color: #dc3545;">*</span></label>
                        <input type="number" id="campoSalario" name="salario_diario" required step="0.01" min="0" placeholder="0.00" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Status</label>
                        <select id="campoStatus" name="status" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="activo">✅ Activo</option>
                            <option value="inactivo">❌ Inactivo</option>
                            <option value="vacaciones">🏖️ Vacaciones</option>
                            <option value="permiso">📋 Permiso</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Fecha Fin</label>
                        <input type="date" id="campoFechaFin" name="fecha_fin" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Observaciones</label>
                    <textarea id="campoObservaciones" name="observaciones" rows="2" placeholder="Observaciones adicionales" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #dee2e6; padding-top: 20px;">
                    <button type="button" id="btnCancelar" style="padding: 8px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">Cancelar</button>
                    <button type="submit" style="padding: 8px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                        <i class="fas fa-save"></i> Asignar Personal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Editar Asignación -->
<div id="modalEditar" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 700px; max-height: 90vh; overflow-y: auto; position: relative; z-index: 100000; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #ffc107 0%, #d39e00 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white;"><i class="fas fa-edit"></i> Editar Asignación</h3>
            <button id="btnCerrarModalEditar" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
            <form id="formEditar">
                <input type="hidden" id="editId">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Empleado <span style="color: #dc3545;">*</span></label>
                        <select id="editEmpleado" name="empleado_id" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Seleccionar empleado...</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Proyecto <span style="color: #dc3545;">*</span></label>
                        <select id="editProyecto" name="proyecto_id" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Seleccionar proyecto...</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Tipo <span style="color: #dc3545;">*</span></label>
                        <select id="editTipo" name="tipo_personal" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Seleccionar tipo...</option>
                            <option value="obrero">👷 Obrero</option>
                            <option value="operador">🚜 Operador</option>
                            <option value="supervisor">📋 Supervisor</option>
                            <option value="ingeniero">🎓 Ingeniero</option>
                            <option value="administrativo">💼 Administrativo</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Rol <span style="color: #dc3545;">*</span></label>
                        <input type="text" id="editRol" name="rol" required placeholder="Ej. Albañil, Supervisor, etc." style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Fecha Asignación</label>
                        <input type="date" id="editFechaAsignacion" name="fecha_asignacion" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Salario Diario <span style="color: #dc3545;">*</span></label>
                        <input type="number" id="editSalario" name="salario_diario" required step="0.01" min="0" placeholder="0.00" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Status</label>
                        <select id="editStatus" name="status" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="activo">✅ Activo</option>
                            <option value="inactivo">❌ Inactivo</option>
                            <option value="vacaciones">🏖️ Vacaciones</option>
                            <option value="permiso">📋 Permiso</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Fecha Fin</label>
                        <input type="date" id="editFechaFin" name="fecha_fin" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">Observaciones</label>
                    <textarea id="editObservaciones" name="observaciones" rows="2" placeholder="Observaciones adicionales" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #dee2e6; padding-top: 20px;">
                    <button type="button" id="btnCancelarEditar" style="padding: 8px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">Cancelar</button>
                    <button type="submit" style="padding: 8px 20px; background-color: #ffc107; color: #856404; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                        <i class="fas fa-save"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Ver Detalle -->
<div id="modalVerDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 600px; max-height: 80vh; overflow-y: auto; position: relative; z-index: 100000; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #2378e1 0%, #1a5cb0 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white;"><i class="fas fa-user"></i> Detalle de Asignación</h3>
            <button id="btnCerrarModalDetalle" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div style="padding: 20px;" id="modalContenidoDetalle"></div>
    </div>
</div>

<style>
    .semaforo .card-header { background-color: #f4f6f9; border-bottom: 2px solid #083CAE; }
    .semaforo .card-header h2 { color: #083CAE !important; }
    .custom-card { transition: transform 0.2s, box-shadow 0.2s; height: 100%; }
    .custom-card:hover { transform: translateY(-3px); box-shadow: 0 8px 16px rgba(8, 60, 174, 0.15) !important; border-color: #083CAE !important; }
    
    .badge { font-size: 11px; font-weight: 600; padding: 4px 8px; display: inline-block; border-radius: 3px; }
    .badge-obrero { background-color: #cce5ff; color: #0d6efd; }
    .badge-operador { background-color: #d4edda; color: #28a745; }
    .badge-supervisor { background-color: #fff3cd; color: #856404; }
    .badge-ingeniero { background-color: #cce5ff; color: #0d6efd; }
    .badge-administrativo { background-color: #e2e3e5; color: #6c757d; }
    
    .badge-activo { background-color: #d4edda; color: #28a745; }
    .badge-inactivo { background-color: #f8d7da; color: #dc3545; }
    .badge-vacaciones { background-color: #fff3cd; color: #856404; }
    .badge-permiso { background-color: #e2e3e5; color: #6c757d; }
    
    tfoot td { font-weight: bold; background-color: #e9ecef !important; border-top: 2px solid #083CAE; color: #000000 !important; }
    
    .toast-notification { position: fixed; bottom: 20px; right: 20px; z-index: 100000; animation: slideIn 0.3s ease; padding: 12px 20px; border-radius: 8px; margin-bottom: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); font-size: 14px; }
    .toast-notification.success { background-color: #28a745; color: white; }
    .toast-notification.error { background-color: #dc3545; color: white; }
    .toast-notification.warning { background-color: #ffc107; color: #333; }
    
    @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    
    #filtroProyectosDropdown { min-width: 250px; }
    #filtroProyectosLista label { display: flex; align-items: center; padding: 4px 12px; cursor: pointer; font-size: 13px; transition: background 0.2s; }
    #filtroProyectosLista label:hover { background-color: #f0f4ff; }
    #filtroProyectosLista input[type="checkbox"] { margin-right: 8px; cursor: pointer; }
    
    @media (max-width: 768px) {
        input#buscador { width: 100% !important; }
        #proyectoFilterContainer { min-width: 100% !important; }
        #filtroProyectosDropdown { min-width: 100% !important; }
        #paginacionContainer { flex-direction: column; align-items: flex-start; }
        #modalAgregar > div, #modalEditar > div, #modalVerDetalle > div { width: 95%; margin: 10px; }
        select { width: 100% !important; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // ============================================
    // CONFIGURACIÓN
    // ============================================
    const API_BASE = '/proyectos/personal-asignado';
    let currentPage = 1;
    let totalPages = 1;
    let proyectosLista = [];
    
    let currentFilters = {
        busqueda: '',
        proyecto_id: [],
        tipo_personal: '',
        status: '',
        page: 1,
        per_page: 10
    };

    // ============================================
    // FUNCIONES PRINCIPALES
    // ============================================

    async function cargarAsignaciones() {
        mostrarLoading(true);
        
        try {
            const proyectosSeleccionados = getProyectosSeleccionados();
            currentFilters.proyecto_id = proyectosSeleccionados;
            
            const params = new URLSearchParams();
            params.append('busqueda', currentFilters.busqueda || '');
            params.append('tipo_personal', currentFilters.tipo_personal || '');
            params.append('status', currentFilters.status || '');
            params.append('page', currentFilters.page || 1);
            params.append('per_page', currentFilters.per_page || 10);
            
            if (proyectosSeleccionados.length > 0) {
                proyectosSeleccionados.forEach(id => {
                    params.append('proyecto_id[]', id);
                });
            }
            
            const url = `${API_BASE}?${params.toString()}`;
            console.log('Cargando desde:', url);
            
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            });
            
            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`HTTP ${response.status}: ${errorText.substring(0, 200)}`);
            }
            
            const result = await response.json();
            console.log('Resultado:', result);
            
            if (result.success) {
                const data = result.data.data || [];
                const pagination = result.data;
                
                actualizarEstadisticas(result.estadisticas);
                renderizarTabla(data);
                actualizarPaginacion(pagination);
                
                currentPage = pagination.current_page || 1;
                totalPages = pagination.last_page || 1;
            } else {
                mostrarNotificacion(result.message || 'Error al cargar datos', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            mostrarNotificacion('Error al cargar las asignaciones: ' + error.message, 'error');
        } finally {
            mostrarLoading(false);
        }
    }

    // ============================================
    // FILTRO DE PROYECTOS
    // ============================================

    function getProyectosSeleccionados() {
        const checkboxes = document.querySelectorAll('#filtroProyectosLista input[type="checkbox"]:checked');
        const selected = [];
        checkboxes.forEach(cb => {
            if (cb.value) {
                selected.push(cb.value);
            }
        });
        return selected;
    }

    function actualizarLabelProyectos() {
        const total = document.querySelectorAll('#filtroProyectosLista input[type="checkbox"]').length;
        const selected = getProyectosSeleccionados().length;
        const label = document.getElementById('filtroProyectosLabel');
        
        if (selected === 0 || selected === total) {
            label.textContent = 'Todos los proyectos';
        } else {
            label.textContent = `${selected} proyecto${selected > 1 ? 's' : ''} seleccionado${selected > 1 ? 's' : ''}`;
        }
    }

    function toggleDropdown() {
        const dropdown = document.getElementById('filtroProyectosDropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    function cerrarDropdown() {
        document.getElementById('filtroProyectosDropdown').style.display = 'none';
    }

    function renderizarCheckboxesProyectos(proyectos) {
        const lista = document.getElementById('filtroProyectosLista');
        lista.innerHTML = '';
        
        if (!proyectos || proyectos.length === 0) {
            lista.innerHTML = '<div style="padding: 8px 12px; color: #6c757d; font-size: 13px;">No hay proyectos disponibles</div>';
            return;
        }
        
        const selected = getProyectosSeleccionados();
        
        proyectos.forEach(proyecto => {
            const checked = selected.includes(String(proyecto.id)) ? 'checked' : '';
            const label = document.createElement('label');
            label.innerHTML = `
                <input type="checkbox" value="${proyecto.id}" ${checked}>
                <span>${proyecto.nombre}</span>
            `;
            lista.appendChild(label);
        });
        
        actualizarLabelProyectos();
    }

    function filtrarProyectosLista(busqueda) {
        const labels = document.querySelectorAll('#filtroProyectosLista label');
        const term = busqueda.toLowerCase().trim();
        
        labels.forEach(label => {
            const text = label.textContent.toLowerCase();
            label.style.display = text.includes(term) ? 'flex' : 'none';
        });
    }

    function seleccionarTodosProyectos() {
        const todosVisibles = document.querySelectorAll('#filtroProyectosLista label:not([style*="display: none"])');
        todosVisibles.forEach(label => {
            const cb = label.querySelector('input[type="checkbox"]');
            if (cb) cb.checked = true;
        });
        actualizarLabelProyectos();
        aplicarFiltroProyectos();
    }

    function deseleccionarTodosProyectos() {
        const checkboxes = document.querySelectorAll('#filtroProyectosLista input[type="checkbox"]');
        checkboxes.forEach(cb => cb.checked = false);
        actualizarLabelProyectos();
        aplicarFiltroProyectos();
    }

    function aplicarFiltroProyectos() {
        currentFilters.page = 1;
        cargarAsignaciones();
    }

    // ============================================
    // CATÁLOGOS
    // ============================================

    async function cargarCatalogos() {
        try {
            // Cargar empleados
            const empleadosResp = await fetch(`${API_BASE}/catalogos/empleados`, {
                headers: { 'Accept': 'application/json' }
            });
            const empleadosResult = await empleadosResp.json();
            
            if (empleadosResult.success) {
                const selectAgregar = document.getElementById('campoEmpleado');
                const selectEditar = document.getElementById('editEmpleado');
                const options = empleadosResult.data.map(e => 
                    `<option value="${e.id}">${e.numero_empleado} - ${e.nombre_completo}</option>`
                ).join('');
                selectAgregar.innerHTML = `<option value="">Seleccionar empleado...</option>${options}`;
                selectEditar.innerHTML = `<option value="">Seleccionar empleado...</option>${options}`;
            }
            
            // Cargar proyectos
            const proyectosResp = await fetch(`${API_BASE}/catalogos/proyectos`, {
                headers: { 'Accept': 'application/json' }
            });
            const proyectosResult = await proyectosResp.json();
            
            if (proyectosResult.success) {
                const selectAgregar = document.getElementById('campoProyecto');
                const selectEditar = document.getElementById('editProyecto');
                const options = proyectosResult.data.map(p => 
                    `<option value="${p.id}">${p.nombre}</option>`
                ).join('');
                selectAgregar.innerHTML = `<option value="">Seleccionar proyecto...</option>${options}`;
                selectEditar.innerHTML = `<option value="">Seleccionar proyecto...</option>${options}`;
                
                proyectosLista = proyectosResult.data;
                renderizarCheckboxesProyectos(proyectosLista);
            }
        } catch (error) {
            console.error('Error cargando catálogos:', error);
        }
    }

    // ============================================
    // RENDERIZADO
    // ============================================

    function renderizarTabla(asignaciones) {
        const tbody = document.getElementById('tablaBody');
        const sinDatos = document.getElementById('sinDatosMensaje');
        const tablaContainer = document.getElementById('tablaContainer');
        
        if (!tbody) return;
        
        tbody.innerHTML = '';
        
        if (!asignaciones || asignaciones.length === 0) {
            sinDatos.style.display = 'block';
            tablaContainer.style.display = 'none';
            document.getElementById('tablaFoot').style.display = 'none';
            return;
        }
        
        sinDatos.style.display = 'none';
        tablaContainer.style.display = 'block';
        document.getElementById('tablaFoot').style.display = 'table-footer-group';
        
        let totalSalarios = 0;
        
        asignaciones.forEach(item => {
            const row = document.createElement('tr');
            const tipoBadge = getTipoBadge(item.tipo_personal);
            const statusBadge = getStatusBadge(item.status);
            
            if (item.status === 'activo') {
                totalSalarios += parseFloat(item.salario_diario || 0);
            }
            
            row.innerHTML = `
                <td style="padding: 10px 4px;">${item.empleado?.numero_empleado_interno || item.empleado_id}</td>
                <td style="padding: 10px 4px;">${item.nombre_completo || '-'}</td>
                <td style="padding: 10px 4px;"><span class="badge ${tipoBadge}">${item.tipo_nombre || '-'}</span></td>
                <td style="padding: 10px 4px;">${item.proyecto?.nombre || '-'}</td>
                <td style="padding: 10px 4px;">${item.rol || '-'}</td>
                <td style="padding: 10px 4px;">${formatDate(item.fecha_asignacion)}</td>
                <td style="padding: 10px 4px; text-align: right;">${formatCurrency(item.salario_diario)}</td>
                <td style="padding: 10px 4px;"><span class="badge ${statusBadge}">${item.status_nombre || '-'}</span></td>
                <td style="padding: 10px 4px; background-color: white; position: sticky; right: 0;">
                    <div style="display: flex; gap: 8px; justify-content: center;">
                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalle" onclick="verDetalle(${item.id})"></i>
                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar" onclick="editarAsignacion(${item.id})"></i>
                        <i class="fas fa-exchange-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Reasignar" onclick="reasignar(${item.id})"></i>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
        
        document.getElementById('sumSalarios').textContent = formatCurrency(totalSalarios) + '/día';
    }

    function actualizarEstadisticas(stats) {
        if (!stats) return;
        document.getElementById('totalPersonal').textContent = stats.total_personal || 0;
        document.getElementById('totalEnObra').textContent = stats.en_obra || 0;
        document.getElementById('totalAdmin').textContent = stats.administrativos || 0;
        document.getElementById('costoMensual').textContent = stats.costo_mensual_formateado || '$0K';
    }

    function actualizarPaginacion(pagination) {
        if (!pagination) return;
        document.getElementById('paginaActual').textContent = pagination.current_page || 1;
        document.getElementById('totalPaginas').textContent = `de ${pagination.last_page || 1}`;
        document.getElementById('paginacionInfo').textContent = 
            `Mostrando ${pagination.from || 0}-${pagination.to || 0} de ${pagination.total || 0} registros`;
    }

    // ============================================
    // FUNCIONES AUXILIARES
    // ============================================

    function formatCurrency(amount) {
        return '$' + parseFloat(amount || 0).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    function formatDate(dateString) {
        if (!dateString) return '-';
        try {
            const date = new Date(dateString);
            return date.toLocaleDateString('es-MX');
        } catch {
            return '-';
        }
    }

    function getTipoBadge(tipo) {
        const badges = {
            'obrero': 'badge-obrero',
            'operador': 'badge-operador',
            'supervisor': 'badge-supervisor',
            'ingeniero': 'badge-ingeniero',
            'administrativo': 'badge-administrativo'
        };
        return badges[tipo] || 'badge-tipo';
    }

    function getStatusBadge(status) {
        const badges = {
            'activo': 'badge-activo',
            'inactivo': 'badge-inactivo',
            'vacaciones': 'badge-vacaciones',
            'permiso': 'badge-permiso'
        };
        return badges[status] || 'badge-status';
    }

    function mostrarLoading(show) {
        document.getElementById('loadingSpinner').style.display = show ? 'flex' : 'none';
    }

    function mostrarNotificacion(mensaje, tipo = 'success') {
        const notificacion = document.createElement('div');
        notificacion.className = `toast-notification ${tipo}`;
        const icono = tipo === 'success' ? 'fa-check-circle' : tipo === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
        notificacion.innerHTML = `<i class="fas ${icono}"></i> ${mensaje}`;
        document.body.appendChild(notificacion);
        setTimeout(() => notificacion.remove(), 3000);
    }

    // ============================================
    // ACCIONES
    // ============================================

    window.verDetalle = async function(id) {
        try {
            const response = await fetch(`${API_BASE}/${id}`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();
            
            if (result.success) {
                const item = result.data;
                const tipoBadge = getTipoBadge(item.tipo_personal);
                const statusBadge = getStatusBadge(item.status);
                
                const contenido = `
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Empleado</div>
                            <div style="font-size: 16px; font-weight: 600;">${item.nombre_completo}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">No. Empleado</div>
                            <div style="font-size: 16px;">${item.empleado?.numero_empleado_interno || '-'}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Proyecto</div>
                            <div style="font-size: 16px;">${item.proyecto?.nombre || '-'}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Tipo</div>
                            <div style="font-size: 16px;"><span class="badge ${tipoBadge}">${item.tipo_nombre}</span></div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Rol</div>
                            <div style="font-size: 16px;">${item.rol || '-'}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Status</div>
                            <div style="font-size: 16px;"><span class="badge ${statusBadge}">${item.status_nombre}</span></div>
                        </div>
                    </div>
                    <div style="background-color: #f8f9fa; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                            <div>
                                <div style="color: #6c757d; font-size: 11px;">Salario Diario</div>
                                <div style="font-size: 18px; font-weight: 700;">${formatCurrency(item.salario_diario)}</div>
                            </div>
                            <div>
                                <div style="color: #6c757d; font-size: 11px;">Salario Mensual</div>
                                <div style="font-size: 18px; font-weight: 700;">${formatCurrency(item.salario_diario * 24)}</div>
                            </div>
                            <div>
                                <div style="color: #6c757d; font-size: 11px;">Días Activo</div>
                                <div style="font-size: 18px; font-weight: 700;">${item.dias_activo || 0} días</div>
                            </div>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Fecha Asignación</div>
                            <div style="font-size: 14px;">${formatDate(item.fecha_asignacion)}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Fecha Fin</div>
                            <div style="font-size: 14px;">${item.fecha_fin ? formatDate(item.fecha_fin) : 'Activo'}</div>
                        </div>
                    </div>
                    ${item.observaciones ? `
                    <div style="margin-bottom: 15px;">
                        <div style="color: #6c757d; font-size: 12px;">Observaciones</div>
                        <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px; font-size: 14px;">${item.observaciones}</div>
                    </div>` : ''}
                    <div style="border-top: 1px solid #dee2e6; padding-top: 15px; margin-top: 15px; display: flex; justify-content: flex-end; gap: 10px;">
                        <button onclick="cerrarModalDetalle()" style="padding: 8px 15px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Cerrar</button>
                    </div>
                `;
                
                document.getElementById('modalContenidoDetalle').innerHTML = contenido;
                document.getElementById('modalVerDetalle').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        } catch (error) {
            mostrarNotificacion('Error al cargar el detalle', 'error');
        }
    };

    window.editarAsignacion = async function(id) {
        try {
            const response = await fetch(`${API_BASE}/${id}`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();
            
            if (result.success) {
                const item = result.data;
                
                document.getElementById('editId').value = item.id;
                document.getElementById('editEmpleado').value = item.empleado_id || '';
                document.getElementById('editProyecto').value = item.proyecto_id || '';
                document.getElementById('editTipo').value = item.tipo_personal || '';
                document.getElementById('editRol').value = item.rol || '';
                document.getElementById('editFechaAsignacion').value = item.fecha_asignacion || '';
                document.getElementById('editSalario').value = item.salario_diario || 0;
                document.getElementById('editStatus').value = item.status || 'activo';
                document.getElementById('editFechaFin').value = item.fecha_fin || '';
                document.getElementById('editObservaciones').value = item.observaciones || '';
                
                document.getElementById('modalEditar').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        } catch (error) {
            mostrarNotificacion('Error al cargar la asignación', 'error');
        }
    };

    window.reasignar = function(id) {
        mostrarNotificacion('Funcionalidad de reasignación en desarrollo', 'warning');
    };

    function cerrarModalDetalle() {
        document.getElementById('modalVerDetalle').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    async function exportarExcel() {
        try {
            const params = new URLSearchParams();
            params.append('busqueda', currentFilters.busqueda || '');
            params.append('tipo_personal', currentFilters.tipo_personal || '');
            params.append('status', currentFilters.status || '');
            
            const proyectos = getProyectosSeleccionados();
            if (proyectos.length > 0) {
                proyectos.forEach(id => params.append('proyecto_id[]', id));
            }
            
            const response = await fetch(`${API_BASE}/exportar?${params.toString()}`);
            const result = await response.json();
            
            if (result.success && result.data) {
                const headers = result.data.headers || [];
                const rows = result.data.rows || [];
                
                if (headers.length === 0 || rows.length === 0) {
                    mostrarNotificacion('No hay datos para exportar', 'warning');
                    return;
                }
                
                const csvContent = [headers.join(','), ...rows.map(row => row.join(','))].join('\n');
                const blob = new Blob(['\uFEFF' + csvContent], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = `PersonalAsignado_${new Date().toISOString().split('T')[0]}.csv`;
                link.click();
                URL.revokeObjectURL(link.href);
                mostrarNotificacion('Exportación completada', 'success');
            }
        } catch (error) {
            mostrarNotificacion('Error al exportar', 'error');
        }
    }

    // ============================================
    // FORMULARIO - CREAR/EDITAR
    // ============================================

    function abrirModalAgregar() {
        document.getElementById('modalAgregar').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        document.getElementById('formAgregar').reset();
        
        const hoy = new Date();
        document.getElementById('campoFechaAsignacion').value = hoy.toISOString().split('T')[0];
    }

    function cerrarModalAgregar() {
        document.getElementById('modalAgregar').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function cerrarModalEditar() {
        document.getElementById('modalEditar').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // ============================================
    // EVENTOS E INICIALIZACIÓN
    // ============================================

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM cargado - API_BASE:', API_BASE);
        
        cargarCatalogos();
        cargarAsignaciones();
        
        // Eventos del dropdown de proyectos
        document.getElementById('btnFiltroProyectos')?.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleDropdown();
        });
        
        document.getElementById('btnCerrarFiltro')?.addEventListener('click', function(e) {
            e.stopPropagation();
            cerrarDropdown();
        });
        
        document.getElementById('btnSeleccionarTodos')?.addEventListener('click', function(e) {
            e.stopPropagation();
            seleccionarTodosProyectos();
        });
        
        document.getElementById('btnDeseleccionarTodos')?.addEventListener('click', function(e) {
            e.stopPropagation();
            deseleccionarTodosProyectos();
        });
        
        document.getElementById('filtroProyectosBuscar')?.addEventListener('input', function(e) {
            e.stopPropagation();
            filtrarProyectosLista(this.value);
        });
        
        document.getElementById('filtroProyectosLista')?.addEventListener('change', function(e) {
            if (e.target.type === 'checkbox') {
                actualizarLabelProyectos();
                aplicarFiltroProyectos();
            }
        });
        
        document.addEventListener('click', function(e) {
            const container = document.getElementById('proyectoFilterContainer');
            if (container && !container.contains(e.target)) {
                cerrarDropdown();
            }
        });
        
        // Filtros
        document.getElementById('selectorTipo')?.addEventListener('change', function() {
            currentFilters.tipo_personal = this.value;
            currentFilters.page = 1;
            cargarAsignaciones();
        });
        
        document.getElementById('selectorStatus')?.addEventListener('change', function() {
            currentFilters.status = this.value;
            currentFilters.page = 1;
            cargarAsignaciones();
        });
        
        document.getElementById('buscador')?.addEventListener('input', function() {
            currentFilters.busqueda = this.value;
            currentFilters.page = 1;
            cargarAsignaciones();
        });
        
        // Botones principales
        document.getElementById('btnAgregar')?.addEventListener('click', abrirModalAgregar);
        document.getElementById('btnExcel')?.addEventListener('click', exportarExcel);
        document.getElementById('btnReporte')?.addEventListener('click', function() {
            mostrarNotificacion('Generando reporte PDF...', 'warning');
        });
        
        // Paginación
        document.getElementById('btnPrimera')?.addEventListener('click', () => {
            if (currentPage > 1) { currentFilters.page = 1; cargarAsignaciones(); }
        });
        document.getElementById('btnAnterior')?.addEventListener('click', () => {
            if (currentPage > 1) { currentFilters.page = currentPage - 1; cargarAsignaciones(); }
        });
        document.getElementById('btnSiguiente')?.addEventListener('click', () => {
            if (currentPage < totalPages) { currentFilters.page = currentPage + 1; cargarAsignaciones(); }
        });
        document.getElementById('btnUltima')?.addEventListener('click', () => {
            if (currentPage < totalPages) { currentFilters.page = totalPages; cargarAsignaciones(); }
        });
        
        // Modales
        document.getElementById('btnCerrarModal')?.addEventListener('click', cerrarModalAgregar);
        document.getElementById('btnCancelar')?.addEventListener('click', cerrarModalAgregar);
        document.getElementById('btnCerrarModalEditar')?.addEventListener('click', cerrarModalEditar);
        document.getElementById('btnCancelarEditar')?.addEventListener('click', cerrarModalEditar);
        document.getElementById('btnCerrarModalDetalle')?.addEventListener('click', cerrarModalDetalle);
        
        // Submit forms
        document.getElementById('formAgregar')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch(API_BASE, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    mostrarNotificacion(result.message, 'success');
                    cerrarModalAgregar();
                    cargarAsignaciones();
                } else {
                    mostrarNotificacion(result.message || 'Error al guardar', 'error');
                }
            })
            .catch(error => {
                mostrarNotificacion('Error al guardar la asignación', 'error');
            });
        });
        
        document.getElementById('formEditar')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const id = document.getElementById('editId').value;
            const formData = new FormData(this);
            
            fetch(`${API_BASE}/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json',
                    'X-HTTP-Method-Override': 'PUT'
                },
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    mostrarNotificacion(result.message, 'success');
                    cerrarModalEditar();
                    cargarAsignaciones();
                } else {
                    mostrarNotificacion(result.message || 'Error al actualizar', 'error');
                }
            })
            .catch(error => {
                mostrarNotificacion('Error al actualizar la asignación', 'error');
            });
        });
        
        // Cerrar modales al hacer clic fuera
        window.addEventListener('click', function(e) {
            const modalAgregar = document.getElementById('modalAgregar');
            const modalEditar = document.getElementById('modalEditar');
            const modalVer = document.getElementById('modalVerDetalle');
            
            if (e.target === modalAgregar) cerrarModalAgregar();
            if (e.target === modalEditar) cerrarModalEditar();
            if (e.target === modalVer) cerrarModalDetalle();
        });
    });
</script>
@endsection