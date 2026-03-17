@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Alta de Proyecto -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Alta de Nuevo Proyecto
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Barra de progreso del alta -->
                <div style="margin-bottom: 30px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <div style="display: flex; gap: 5px; flex: 1;">
                            <div style="flex: 1; text-align: center; position: relative;">
                                <div style="width: 30px; height: 30px; background-color: #083CAE; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 5px; font-weight: bold;">1</div>
                                <div style="font-size: 12px; font-weight: 600; color: #083CAE;">Datos Generales</div>
                            </div>
                            <div style="flex: 1; text-align: center; position: relative;">
                                <div style="width: 30px; height: 30px; background-color: #e9ecef; color: #6c757d; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 5px; font-weight: bold;">2</div>
                                <div style="font-size: 12px; color: #6c757d;">Cliente y Contrato</div>
                            </div>
                            <div style="flex: 1; text-align: center; position: relative;">
                                <div style="width: 30px; height: 30px; background-color: #e9ecef; color: #6c757d; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 5px; font-weight: bold;">3</div>
                                <div style="font-size: 12px; color: #6c757d;">Responsable y Equipo</div>
                            </div>
                            <div style="flex: 1; text-align: center; position: relative;">
                                <div style="width: 30px; height: 30px; background-color: #e9ecef; color: #6c757d; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 5px; font-weight: bold;">4</div>
                                <div style="font-size: 12px; color: #6c757d;">Financiero</div>
                            </div>
                            <div style="flex: 1; text-align: center; position: relative;">
                                <div style="width: 30px; height: 30px; background-color: #e9ecef; color: #6c757d; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 5px; font-weight: bold;">5</div>
                                <div style="font-size: 12px; color: #6c757d;">Documentos</div>
                            </div>
                        </div>
                    </div>
                    <div style="height: 4px; background-color: #e9ecef; border-radius: 2px; position: relative;">
                        <div style="width: 20%; height: 100%; background-color: #083CAE; border-radius: 2px;"></div>
                    </div>
                </div>

                <!-- Pestañas de secciones -->
                <div style="display: flex; gap: 2px; margin-bottom: 25px; border-bottom: 2px solid #083CAE;">
                    <button class="tab-btn active" data-tab="generales" style="padding: 12px 25px; background-color: #083CAE; color: white; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-info-circle"></i> Datos Generales
                    </button>
                    <button class="tab-btn" data-tab="cliente" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-building"></i> Cliente y Contrato
                    </button>
                    <button class="tab-btn" data-tab="responsable" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-users"></i> Responsable y Equipo
                    </button>
                    <button class="tab-btn" data-tab="financiero" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-dollar-sign"></i> Financiero
                    </button>
                    <button class="tab-btn" data-tab="documentos" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-file-alt"></i> Documentos
                    </button>
                </div>

                <!-- SECCIÓN 1: DATOS GENERALES -->
                <div id="tab-generales" class="tab-content active">
                    <h3 style="color: #083CAE; font-size: 18px; margin-bottom: 20px; font-weight: 600;">
                        <i class="fas fa-info-circle"></i> Información General del Proyecto
                    </h3>
                    
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px;">
                        <!-- Código del Proyecto -->
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">
                                Código del Proyecto <span style="color: #dc3545;">*</span>
                            </label>
                            <div style="display: flex;">
                                <span style="background-color: #e9ecef; padding: 8px 12px; border: 1px solid #ced4da; border-right: none; border-radius: 4px 0 0 4px; color: #495057;">PRO-</span>
                                <input type="text" class="form-control" id="codigo" placeholder="2025-001" style="flex: 1; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 0 4px 4px 0; font-size: 14px;">
                            </div>
                            <small style="color: #6c757d;">Formato: PRO-2025-001</small>
                        </div>

                        <!-- Nombre del Proyecto -->
                        <div style="grid-column: span 2;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">
                                Nombre del Proyecto <span style="color: #dc3545;">*</span>
                            </label>
                            <input type="text" class="form-control" id="nombre_proyecto" placeholder="Ej: Torre Norte Corporativa" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px;">
                        <!-- Tipo de Proyecto -->
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">
                                Tipo de Proyecto <span style="color: #dc3545;">*</span>
                            </label>
                            <select class="form-control" id="tipo_proyecto" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                                <option value="">Seleccionar tipo...</option>
                                <option value="construccion">Construcción</option>
                                <option value="infraestructura">Infraestructura</option>
                                <option value="industrial">Industrial</option>
                                <option value="comercial">Comercial</option>
                                <option value="residencial">Residencial</option>
                                <option value="vialidad">Vialidad</option>
                                <option value="hidraulico">Hidráulico</option>
                                <option value="energia">Energía</option>
                                <option value="turismo">Turismo</option>
                                <option value="educacion">Educación</option>
                                <option value="salud">Salud</option>
                            </select>
                        </div>

                        <!-- Categoría -->
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Categoría</label>
                            <select class="form-control" id="categoria" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                                <option value="">Seleccionar categoría...</option>
                                <option value="obra_nueva">Obra Nueva</option>
                                <option value="remodelacion">Remodelación</option>
                                <option value="ampliacion">Ampliación</option>
                                <option value="mantenimiento">Mantenimiento</option>
                                <option value="restauracion">Restauración</option>
                            </select>
                        </div>

                        <!-- Prioridad -->
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">
                                Prioridad <span style="color: #dc3545;">*</span>
                            </label>
                            <select class="form-control" id="prioridad" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                                <option value="">Seleccionar prioridad...</option>
                                <option value="alta">Alta</option>
                                <option value="media">Media</option>
                                <option value="baja">Baja</option>
                            </select>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                        <!-- Ubicación -->
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">
                                Ubicación <span style="color: #dc3545;">*</span>
                            </label>
                            <input type="text" class="form-control" id="ubicacion" placeholder="Ej: Monterrey, NL" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        </div>

                        <!-- Dirección completa -->
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Dirección completa</label>
                            <input type="text" class="form-control" id="direccion" placeholder="Calle, número, colonia, código postal" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                        <!-- Fecha de inicio -->
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">
                                Fecha de Inicio Estimada <span style="color: #dc3545;">*</span>
                            </label>
                            <input type="date" class="form-control" id="fecha_inicio" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        </div>

                        <!-- Fecha de fin -->
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">
                                Fecha de Fin Estimada <span style="color: #dc3545;">*</span>
                            </label>
                            <input type="date" class="form-control" id="fecha_fin" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <!-- Descripción del proyecto -->
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Descripción del Proyecto</label>
                            <textarea class="form-control" id="descripcion" rows="4" placeholder="Describa el alcance del proyecto, objetivos principales, etc." style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                        <!-- Estado del proyecto -->
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Estado Inicial</label>
                            <select class="form-control" id="estado_inicial" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                                <option value="activo">Activo</option>
                                <option value="en_curso">En Curso</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="en_espera">En Espera</option>
                            </select>
                        </div>

                        <!-- Moneda -->
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Moneda</label>
                            <select class="form-control" id="moneda" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                                <option value="MXN">MXN - Peso Mexicano</option>
                                <option value="USD">USD - Dólar Americano</option>
                                <option value="EUR">EUR - Euro</option>
                            </select>
                        </div>

                        <!-- Tipo de cambio (si aplica) -->
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Tipo de Cambio</label>
                            <input type="number" class="form-control" id="tipo_cambio" placeholder="1.00" step="0.01" value="1.00" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 2: CLIENTE Y CONTRATO -->
                <div id="tab-cliente" class="tab-content" style="display: none;">
                    <h3 style="color: #083CAE; font-size: 18px; margin-bottom: 20px; font-weight: 600;">
                        <i class="fas fa-building"></i> Información del Cliente y Contrato
                    </h3>

                    <!-- Buscar cliente existente o nuevo -->
                    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 25px;">
                        <div style="display: flex; gap: 15px; align-items: center; margin-bottom: 15px;">
                            <div style="flex: 1;">
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Buscar cliente existente</label>
                                <div style="display: flex;">
                                    <input type="text" class="form-control" id="buscar_cliente" placeholder="Nombre, RFC o ID del cliente" style="flex: 1; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px 0 0 4px; font-size: 14px;">
                                    <button style="padding: 8px 15px; background-color: #6c757d; color: white; border: none; border-radius: 0 4px 4px 0; cursor: pointer;">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div style="width: 50px; text-align: center; color: #6c757d;">o</div>
                            <div>
                                <button id="btnNuevoCliente" style="padding: 8px 15px; background-color: white; border: 2px solid #083CAE; color: #083CAE; border-radius: 4px; cursor: pointer; font-weight: 600;">
                                    <i class="fas fa-user-plus"></i> Nuevo Cliente
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Datos del Cliente -->
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">
                                Nombre/Razón Social <span style="color: #dc3545;">*</span>
                            </label>
                            <input type="text" class="form-control" id="cliente_nombre" placeholder="Nombre del cliente" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">
                                RFC <span style="color: #dc3545;">*</span>
                            </label>
                            <input type="text" class="form-control" id="cliente_rfc" placeholder="XXX000000XXX" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Email</label>
                            <input type="email" class="form-control" id="cliente_email" placeholder="cliente@ejemplo.com" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Teléfono</label>
                            <input type="text" class="form-control" id="cliente_telefono" placeholder="(81) 1234-5678" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Contacto</label>
                            <input type="text" class="form-control" id="cliente_contacto" placeholder="Nombre del contacto" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Cargo del contacto</label>
                            <input type="text" class="form-control" id="cliente_cargo" placeholder="Ej: Gerente de Proyectos" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        </div>
                    </div>

                    <h3 style="color: #083CAE; font-size: 16px; margin: 30px 0 20px; font-weight: 600;">
                        <i class="fas fa-file-signature"></i> Datos del Contrato
                    </h3>

                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">
                                Número de Contrato <span style="color: #dc3545;">*</span>
                            </label>
                            <input type="text" class="form-control" id="numero_contrato" placeholder="CON-2025-001" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Fecha de Firma</label>
                            <input type="date" class="form-control" id="fecha_firma" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Tipo de Contrato</label>
                            <select class="form-control" id="tipo_contrato" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                                <option value="">Seleccionar...</option>
                                <option value="obra_determinada">Obra Determinada</option>
                                <option value="precios_unitarios">Precios Unitarios</option>
                                <option value="administracion">Administración</option>
                                <option value="mixto">Mixto</option>
                            </select>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Forma de Pago</label>
                            <select class="form-control" id="forma_pago" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                                <option value="">Seleccionar...</option>
                                <option value="anticipo">Anticipo + Estimaciones</option>
                                <option value="estimaciones">Solo Estimaciones</option>
                                <option value="porcentaje_avance">Porcentaje de Avance</option>
                                <option value="hito">Por Hitos</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Plazo de Pago (días)</label>
                            <input type="number" class="form-control" id="plazo_pago" placeholder="30" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 3: RESPONSABLE Y EQUIPO -->
                <div id="tab-responsable" class="tab-content" style="display: none;">
                    <h3 style="color: #083CAE; font-size: 18px; margin-bottom: 20px; font-weight: 600;">
                        <i class="fas fa-user-tie"></i> Responsable del Proyecto
                    </h3>

                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">
                                Responsable <span style="color: #dc3545;">*</span>
                            </label>
                            <select class="form-control" id="responsable" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                                <option value="">Seleccionar responsable...</option>
                                <option value="juan_perez">Juan Pérez</option>
                                <option value="maria_garcia">María García</option>
                                <option value="carlos_rodriguez">Carlos Rodríguez</option>
                                <option value="ana_martinez">Ana Martínez</option>
                                <option value="luis_ramirez">Luis Ramírez</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Cargo</label>
                            <input type="text" class="form-control" id="cargo_responsable" value="Director de Proyectos" readonly style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; background-color: #e9ecef;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Email</label>
                            <input type="email" class="form-control" id="email_responsable" value="juan.perez@empresa.com" readonly style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; background-color: #e9ecef;">
                        </div>
                    </div>

                    <h3 style="color: #083CAE; font-size: 18px; margin: 30px 0 20px; font-weight: 600;">
                        <i class="fas fa-users"></i> Equipo del Proyecto
                    </h3>

                    <!-- Tabla de equipo asignado -->
                    <div style="margin-bottom: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <h4 style="font-size: 15px; font-weight: 600; color: #495057; margin: 0;">Miembros del Equipo</h4>
                            <button id="btnAgregarMiembro" style="padding: 8px 15px; background-color: white; border: 2px solid #083CAE; color: #083CAE; border-radius: 4px; cursor: pointer; font-weight: 600;">
                                <i class="fas fa-user-plus"></i> Agregar Miembro
                            </button>
                        </div>

                        <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px;">
                            <table class="table" style="width: 100%; font-size: 13px;">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="padding: 10px;">Nombre</th>
                                        <th style="padding: 10px;">Rol</th>
                                        <th style="padding: 10px;">Departamento</th>
                                        <th style="padding: 10px;">Dedicación</th>
                                        <th style="padding: 10px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="equipoBody">
                                    <tr>
                                        <td style="padding: 10px;">Carlos Rodríguez</td>
                                        <td style="padding: 10px;">Residente de Obra</td>
                                        <td style="padding: 10px;">Construcción</td>
                                        <td style="padding: 10px;">100%</td>
                                        <td style="padding: 10px;">
                                            <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; margin-right: 10px;"></i>
                                            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer;"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px;">Laura Gómez</td>
                                        <td style="padding: 10px;">Supervisor de Seguridad</td>
                                        <td style="padding: 10px;">Seguridad</td>
                                        <td style="padding: 10px;">50%</td>
                                        <td style="padding: 10px;">
                                            <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; margin-right: 10px;"></i>
                                            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer;"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px;">Roberto Sánchez</td>
                                        <td style="padding: 10px;">Ingeniero de Costos</td>
                                        <td style="padding: 10px;">Finanzas</td>
                                        <td style="padding: 10px;">75%</td>
                                        <td style="padding: 10px;">
                                            <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; margin-right: 10px;"></i>
                                            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer;"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Asignación de recursos -->
                    <h3 style="color: #083CAE; font-size: 18px; margin: 30px 0 20px; font-weight: 600;">
                        <i class="fas fa-tools"></i> Asignación de Recursos
                    </h3>

                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Maquinaria Requerida</label>
                            <textarea class="form-control" rows="3" placeholder="Lista de maquinaria necesaria..." style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;"></textarea>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Materiales Principales</label>
                            <textarea class="form-control" rows="3" placeholder="Lista de materiales principales..." style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;"></textarea>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 4: FINANCIERO -->
                <div id="tab-financiero" class="tab-content" style="display: none;">
                    <h3 style="color: #083CAE; font-size: 18px; margin-bottom: 20px; font-weight: 600;">
                        <i class="fas fa-calculator"></i> Datos Financieros del Proyecto
                    </h3>

                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">
                                Presupuesto Total <span style="color: #dc3545;">*</span>
                            </label>
                            <div style="display: flex;">
                                <span style="background-color: #e9ecef; padding: 8px 12px; border: 1px solid #ced4da; border-right: none; border-radius: 4px 0 0 4px;">$</span>
                                <input type="number" class="form-control" id="presupuesto_total" placeholder="0.00" step="0.01" style="flex: 1; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 0 4px 4px 0; font-size: 14px;">
                            </div>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Anticipo (%)</label>
                            <div style="display: flex;">
                                <input type="number" class="form-control" id="anticipo" placeholder="0" step="1" min="0" max="100" style="flex: 1; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px 0 0 4px; font-size: 14px;">
                                <span style="background-color: #e9ecef; padding: 8px 12px; border: 1px solid #ced4da; border-left: none; border-radius: 0 4px 4px 0;">%</span>
                            </div>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Monto Anticipo</label>
                            <div style="display: flex;">
                                <span style="background-color: #e9ecef; padding: 8px 12px; border: 1px solid #ced4da; border-right: none; border-radius: 4px 0 0 4px;">$</span>
                                <input type="text" class="form-control" id="monto_anticipo" readonly value="$0.00" style="flex: 1; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 0 4px 4px 0; font-size: 14px; background-color: #e9ecef;">
                            </div>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Margen Estimado (%)</label>
                            <div style="display: flex;">
                                <input type="number" class="form-control" id="margen" placeholder="25" step="0.1" min="0" max="100" style="flex: 1; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px 0 0 4px; font-size: 14px;">
                                <span style="background-color: #e9ecef; padding: 8px 12px; border: 1px solid #ced4da; border-left: none; border-radius: 0 4px 4px 0;">%</span>
                            </div>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Utilidad Estimada</label>
                            <div style="display: flex;">
                                <span style="background-color: #e9ecef; padding: 8px 12px; border: 1px solid #ced4da; border-right: none; border-radius: 4px 0 0 4px;">$</span>
                                <input type="text" class="form-control" id="utilidad" readonly value="$0.00" style="flex: 1; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 0 4px 4px 0; font-size: 14px; background-color: #e9ecef;">
                            </div>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Fondo de Reserva</label>
                            <div style="display: flex;">
                                <span style="background-color: #e9ecef; padding: 8px 12px; border: 1px solid #ced4da; border-right: none; border-radius: 4px 0 0 4px;">$</span>
                                <input type="number" class="form-control" id="fondo_reserva" placeholder="0.00" step="0.01" style="flex: 1; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 0 4px 4px 0; font-size: 14px;">
                            </div>
                        </div>
                    </div>

                    <h3 style="color: #083CAE; font-size: 16px; margin: 30px 0 20px; font-weight: 600;">
                        <i class="fas fa-chart-line"></i> Estimación de Costos
                    </h3>

                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Costo de Materiales</label>
                            <div style="display: flex;">
                                <span style="background-color: #e9ecef; padding: 8px 12px; border: 1px solid #ced4da; border-right: none; border-radius: 4px 0 0 4px;">$</span>
                                <input type="number" class="form-control" placeholder="0.00" style="flex: 1; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 0 4px 4px 0; font-size: 14px;">
                            </div>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Costo de Mano de Obra</label>
                            <div style="display: flex;">
                                <span style="background-color: #e9ecef; padding: 8px 12px; border: 1px solid #ced4da; border-right: none; border-radius: 4px 0 0 4px;">$</span>
                                <input type="number" class="form-control" placeholder="0.00" style="flex: 1; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 0 4px 4px 0; font-size: 14px;">
                            </div>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Costo de Maquinaria</label>
                            <div style="display: flex;">
                                <span style="background-color: #e9ecef; padding: 8px 12px; border: 1px solid #ced4da; border-right: none; border-radius: 4px 0 0 4px;">$</span>
                                <input type="number" class="form-control" placeholder="0.00" style="flex: 1; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 0 4px 4px 0; font-size: 14px;">
                            </div>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Gastos Indirectos</label>
                            <div style="display: flex;">
                                <span style="background-color: #e9ecef; padding: 8px 12px; border: 1px solid #ced4da; border-right: none; border-radius: 4px 0 0 4px;">$</span>
                                <input type="number" class="form-control" placeholder="0.00" style="flex: 1; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 0 4px 4px 0; font-size: 14px;">
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de flujo de efectivo -->
                    <h3 style="color: #083CAE; font-size: 16px; margin: 30px 0 20px; font-weight: 600;">
                        <i class="fas fa-calendar-alt"></i> Programación de Flujo de Efectivo
                    </h3>

                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; margin-bottom: 20px;">
                        <table class="table" style="width: 100%; font-size: 13px;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="padding: 10px;">Mes</th>
                                    <th style="padding: 10px;">Ingreso Estimado</th>
                                    <th style="padding: 10px;">Gasto Estimado</th>
                                    <th style="padding: 10px;">Flujo Neto</th>
                                    <th style="padding: 10px;">Saldo Acumulado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 10px;">Mes 1</td>
                                    <td style="padding: 10px;">$500,000</td>
                                    <td style="padding: 10px;">$350,000</td>
                                    <td style="padding: 10px; color: #28a745;">$150,000</td>
                                    <td style="padding: 10px;">$150,000</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px;">Mes 2</td>
                                    <td style="padding: 10px;">$750,000</td>
                                    <td style="padding: 10px;">$600,000</td>
                                    <td style="padding: 10px; color: #28a745;">$150,000</td>
                                    <td style="padding: 10px;">$300,000</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px;">Mes 3</td>
                                    <td style="padding: 10px;">$800,000</td>
                                    <td style="padding: 10px;">$720,000</td>
                                    <td style="padding: 10px; color: #28a745;">$80,000</td>
                                    <td style="padding: 10px;">$380,000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SECCIÓN 5: DOCUMENTOS -->
                <div id="tab-documentos" class="tab-content" style="display: none;">
                    <h3 style="color: #083CAE; font-size: 18px; margin-bottom: 20px; font-weight: 600;">
                        <i class="fas fa-upload"></i> Carga de Documentos
                    </h3>

                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px;">
                        <!-- Contrato -->
                        <div style="border: 2px dashed #ced4da; border-radius: 8px; padding: 30px; text-align: center; background-color: #f8f9fa;">
                            <i class="fas fa-file-contract" style="font-size: 48px; color: #083CAE; margin-bottom: 15px;"></i>
                            <h4 style="font-size: 16px; margin-bottom: 10px;">Contrato</h4>
                            <p style="font-size: 12px; color: #6c757d; margin-bottom: 15px;">Arrastra el archivo aquí o haz clic para seleccionar</p>
                            <input type="file" id="archivo_contrato" style="display: none;">
                            <button onclick="document.getElementById('archivo_contrato').click()" style="padding: 8px 20px; background-color: white; border: 2px solid #083CAE; color: #083CAE; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-upload"></i> Seleccionar archivo
                            </button>
                            <p style="font-size: 11px; color: #6c757d; margin-top: 10px;">PDF, DOC, DOCX (Max. 10MB)</p>
                        </div>

                        <!-- Anexos técnicos -->
                        <div style="border: 2px dashed #ced4da; border-radius: 8px; padding: 30px; text-align: center; background-color: #f8f9fa;">
                            <i class="fas fa-file-pdf" style="font-size: 48px; color: #083CAE; margin-bottom: 15px;"></i>
                            <h4 style="font-size: 16px; margin-bottom: 10px;">Anexos Técnicos</h4>
                            <p style="font-size: 12px; color: #6c757d; margin-bottom: 15px;">Arrastra los archivos aquí o haz clic para seleccionar</p>
                            <input type="file" id="archivo_anexos" multiple style="display: none;">
                            <button onclick="document.getElementById('archivo_anexos').click()" style="padding: 8px 20px; background-color: white; border: 2px solid #083CAE; color: #083CAE; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-upload"></i> Seleccionar archivos
                            </button>
                            <p style="font-size: 11px; color: #6c757d; margin-top: 10px;">PDF, DWG, DXF (Max. 50MB)</p>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px;">
                        <!-- Planos -->
                        <div style="border: 2px dashed #ced4da; border-radius: 8px; padding: 20px; text-align: center;">
                            <i class="fas fa-draw-polygon" style="font-size: 32px; color: #6c757d; margin-bottom: 10px;"></i>
                            <h5 style="font-size: 14px; margin-bottom: 5px;">Planos</h5>
                            <p style="font-size: 11px; color: #6c757d;">0 archivos</p>
                        </div>
                        <!-- Presupuesto -->
                        <div style="border: 2px dashed #ced4da; border-radius: 8px; padding: 20px; text-align: center;">
                            <i class="fas fa-file-excel" style="font-size: 32px; color: #6c757d; margin-bottom: 10px;"></i>
                            <h5 style="font-size: 14px; margin-bottom: 5px;">Presupuesto</h5>
                            <p style="font-size: 11px; color: #6c757d;">0 archivos</p>
                        </div>
                        <!-- Programas -->
                        <div style="border: 2px dashed #ced4da; border-radius: 8px; padding: 20px; text-align: center;">
                            <i class="fas fa-calendar-alt" style="font-size: 32px; color: #6c757d; margin-bottom: 10px;"></i>
                            <h5 style="font-size: 14px; margin-bottom: 5px;">Programa de Obra</h5>
                            <p style="font-size: 11px; color: #6c757d;">0 archivos</p>
                        </div>
                    </div>

                    <!-- Lista de documentos cargados -->
                    <h3 style="color: #083CAE; font-size: 16px; margin: 30px 0 20px; font-weight: 600;">
                        <i class="fas fa-list"></i> Documentos Cargados
                    </h3>

                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px;">
                        <table class="table" style="width: 100%; font-size: 13px;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="padding: 10px;">Tipo</th>
                                    <th style="padding: 10px;">Nombre</th>
                                    <th style="padding: 10px;">Fecha</th>
                                    <th style="padding: 10px;">Tamaño</th>
                                    <th style="padding: 10px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 10px;"><i class="fas fa-file-pdf" style="color: #dc3545;"></i> Contrato</td>
                                    <td style="padding: 10px;">Contrato_PRO-2024-001.pdf</td>
                                    <td style="padding: 10px;">2024-01-15</td>
                                    <td style="padding: 10px;">2.4 MB</td>
                                    <td style="padding: 10px;">
                                        <i class="fas fa-download" style="color: #083CAE; cursor: pointer; margin-right: 10px;"></i>
                                        <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer;"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px;"><i class="fas fa-file-excel" style="color: #28a745;"></i> Presupuesto</td>
                                    <td style="padding: 10px;">Presupuesto_PRO-2024-001.xlsx</td>
                                    <td style="padding: 10px;">2024-01-15</td>
                                    <td style="padding: 10px;">1.8 MB</td>
                                    <td style="padding: 10px;">
                                        <i class="fas fa-download" style="color: #083CAE; cursor: pointer; margin-right: 10px;"></i>
                                        <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer;"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px;"><i class="fas fa-draw-polygon" style="color: #ffc107;"></i> Planos</td>
                                    <td style="padding: 10px;">Planos_PRO-2024-001.dwg</td>
                                    <td style="padding: 10px;">2024-01-16</td>
                                    <td style="padding: 10px;">15.2 MB</td>
                                    <td style="padding: 10px;">
                                        <i class="fas fa-download" style="color: #083CAE; cursor: pointer; margin-right: 10px;"></i>
                                        <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer;"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div style="display: flex; justify-content: space-between; margin-top: 30px; padding-top: 20px; border-top: 1px solid #dee2e6;">
                    <div>
                        <button id="btnGuardarBorrador" style="padding: 12px 25px; background-color: white; border: 2px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer; font-weight: 600; margin-right: 10px;">
                            <i class="fas fa-save"></i> Guardar Borrador
                        </button>
                        <button id="btnCancelar" style="padding: 12px 25px; background-color: white; border: 2px solid #dc3545; color: #dc3545; border-radius: 4px; cursor: pointer; font-weight: 600;">
                            <i class="fas fa-times"></i> Cancelar
                        </button>
                    </div>
                    <div>
                        <button id="btnAnterior" style="padding: 12px 25px; background-color: white; border: 2px solid #083CAE; color: #083CAE; border-radius: 4px; cursor: pointer; font-weight: 600; margin-right: 10px; display: none;">
                            <i class="fas fa-arrow-left"></i> Anterior
                        </button>
                        <button id="btnSiguiente" style="padding: 12px 30px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">
                            Siguiente <i class="fas fa-arrow-right"></i>
                        </button>
                        <button id="btnGuardar" style="padding: 12px 30px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 600; display: none;">
                            <i class="fas fa-check"></i> Guardar Proyecto
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .tab-content {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .tab-btn {
        transition: all 0.3s ease;
    }
    
    .tab-btn:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }
    
    .tab-btn.active {
        background-color: #083CAE !important;
        color: white !important;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #083CAE;
        box-shadow: 0 0 0 3px rgba(8, 60, 174, 0.1);
    }
    
    .custom-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .custom-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(8, 60, 174, 0.15) !important;
        border-color: #083CAE !important;
    }
    
    /* Estilos para inputs */
    input[type="text"]:focus,
    input[type="number"]:focus,
    input[type="date"]:focus,
    select:focus,
    textarea:focus {
        outline: none;
        border-color: #083CAE;
        box-shadow: 0 0 0 3px rgba(8, 60, 174, 0.1);
    }
    
    /* Estilo para campos requeridos */
    label span {
        font-size: 14px;
        font-weight: bold;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        div[style*="grid-template-columns"] {
            grid-template-columns: 1fr !important;
        }
        
        .tab-btn {
            padding: 10px !important;
            font-size: 12px !important;
        }
        
        div[style*="display: flex"] {
            flex-direction: column;
            gap: 10px;
        }
        
        #btnGuardarBorrador, #btnCancelar, #btnAnterior, #btnSiguiente, #btnGuardar {
            width: 100%;
            margin: 5px 0 !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM cargado - Alta de Proyecto');
        
        // Variables para control de pestañas
        let currentTab = 1;
        const totalTabs = 5;
        
        // Elementos del DOM
        const tabs = document.querySelectorAll('.tab-content');
        const tabButtons = document.querySelectorAll('.tab-btn');
        const btnAnterior = document.getElementById('btnAnterior');
        const btnSiguiente = document.getElementById('btnSiguiente');
        const btnGuardar = document.getElementById('btnGuardar');
        const progressBar = document.querySelector('.progress-bar');
        const progressSteps = document.querySelectorAll('.progress-step');
        
        // Elementos financieros para cálculo automático
        const presupuestoTotal = document.getElementById('presupuesto_total');
        const anticipo = document.getElementById('anticipo');
        const montoAnticipo = document.getElementById('monto_anticipo');
        const margen = document.getElementById('margen');
        const utilidad = document.getElementById('utilidad');
        
        // Función para cambiar de pestaña
        function cambiarTab(tabIndex) {
            // Actualizar pestañas
            tabs.forEach(tab => tab.style.display = 'none');
            document.getElementById(`tab-${tabIndex === 1 ? 'generales' : tabIndex === 2 ? 'cliente' : tabIndex === 3 ? 'responsable' : tabIndex === 4 ? 'financiero' : 'documentos'}`).style.display = 'block';
            
            // Actualizar botones
            tabButtons.forEach((btn, index) => {
                if (index + 1 === tabIndex) {
                    btn.classList.add('active');
                    btn.style.backgroundColor = '#083CAE';
                    btn.style.color = 'white';
                } else {
                    btn.classList.remove('active');
                    btn.style.backgroundColor = '#e9ecef';
                    btn.style.color = '#495057';
                }
            });
            
            // Actualizar barra de progreso
            document.querySelector('.progress-bar div').style.width = `${(tabIndex / totalTabs) * 100}%`;
            
            // Actualizar números del progreso
            document.querySelectorAll('.progress-step div').forEach((step, index) => {
                if (index + 1 <= tabIndex) {
                    step.style.backgroundColor = '#083CAE';
                    step.style.color = 'white';
                } else {
                    step.style.backgroundColor = '#e9ecef';
                    step.style.color = '#6c757d';
                }
            });
            
            // Mostrar/ocultar botones de navegación
            if (tabIndex === 1) {
                btnAnterior.style.display = 'none';
            } else {
                btnAnterior.style.display = 'inline-block';
            }
            
            if (tabIndex === totalTabs) {
                btnSiguiente.style.display = 'none';
                btnGuardar.style.display = 'inline-block';
            } else {
                btnSiguiente.style.display = 'inline-block';
                btnGuardar.style.display = 'none';
            }
            
            currentTab = tabIndex;
        }
        
        // Event listeners para pestañas
        tabButtons.forEach((btn, index) => {
            btn.addEventListener('click', () => cambiarTab(index + 1));
        });
        
        // Botón siguiente
        btnSiguiente.addEventListener('click', () => {
            if (currentTab < totalTabs) {
                cambiarTab(currentTab + 1);
            }
        });
        
        // Botón anterior
        btnAnterior.addEventListener('click', () => {
            if (currentTab > 1) {
                cambiarTab(currentTab - 1);
            }
        });
        
        // Cálculos financieros
        function calcularMontoAnticipo() {
            const presupuesto = parseFloat(presupuestoTotal?.value) || 0;
            const porcentaje = parseFloat(anticipo?.value) || 0;
            const monto = (presupuesto * porcentaje) / 100;
            if (montoAnticipo) {
                montoAnticipo.value = '$' + monto.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            }
        }
        
        function calcularUtilidad() {
            const presupuesto = parseFloat(presupuestoTotal?.value) || 0;
            const porcentajeMargen = parseFloat(margen?.value) || 0;
            const monto = (presupuesto * porcentajeMargen) / 100;
            if (utilidad) {
                utilidad.value = '$' + monto.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            }
        }
        
        if (presupuestoTotal) {
            presupuestoTotal.addEventListener('input', () => {
                calcularMontoAnticipo();
                calcularUtilidad();
            });
        }
        
        if (anticipo) {
            anticipo.addEventListener('input', calcularMontoAnticipo);
        }
        
        if (margen) {
            margen.addEventListener('input', calcularUtilidad);
        }
        
        // Buscar cliente
        document.getElementById('buscar_cliente')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                alert('Buscando cliente: ' + this.value);
                // Simular búsqueda y autocompletado
                document.getElementById('cliente_nombre').value = 'Cliente Encontrado SA de CV';
                document.getElementById('cliente_rfc').value = 'CES890101ABC';
                document.getElementById('cliente_email').value = 'contacto@cliente.com';
                document.getElementById('cliente_telefono').value = '(81) 1234-5678';
                document.getElementById('cliente_contacto').value = 'Juan Carlos López';
            }
        });
        
        // Nuevo cliente
        document.getElementById('btnNuevoCliente')?.addEventListener('click', function() {
            // Limpiar campos de cliente
            document.getElementById('cliente_nombre').value = '';
            document.getElementById('cliente_rfc').value = '';
            document.getElementById('cliente_email').value = '';
            document.getElementById('cliente_telefono').value = '';
            document.getElementById('cliente_contacto').value = '';
            document.getElementById('cliente_cargo').value = '';
            
            // Enfocar primer campo
            document.getElementById('cliente_nombre').focus();
        });
        
        // Agregar miembro al equipo
        document.getElementById('btnAgregarMiembro')?.addEventListener('click', function() {
            alert('Funcionalidad para agregar miembro al equipo - En desarrollo');
        });
        
        // Guardar borrador
        document.getElementById('btnGuardarBorrador')?.addEventListener('click', function() {
            alert('Borrador guardado correctamente');
        });
        
        // Cancelar
        document.getElementById('btnCancelar')?.addEventListener('click', function() {
            if (confirm('¿Está seguro de cancelar el alta del proyecto? Se perderán los datos no guardados.')) {
                window.location.href = '/proyectos'; // Redirigir a la lista de proyectos
            }
        });
        
        // Guardar proyecto
        document.getElementById('btnGuardar')?.addEventListener('click', function() {
            // Validar campos requeridos
            const camposRequeridos = [
                'codigo', 'nombre_proyecto', 'tipo_proyecto', 'prioridad',
                'ubicacion', 'fecha_inicio', 'fecha_fin', 'cliente_nombre',
                'cliente_rfc', 'numero_contrato', 'responsable', 'presupuesto_total'
            ];
            
            let camposFaltantes = [];
            camposRequeridos.forEach(campo => {
                const input = document.getElementById(campo);
                if (input && !input.value) {
                    camposFaltantes.push(campo);
                }
            });
            
            if (camposFaltantes.length > 0) {
                alert('Por favor complete todos los campos requeridos');
                return;
            }
            
            alert('Proyecto guardado exitosamente');
            // Aquí iría la redirección a la lista de proyectos
        });
        
        // Simular autocompletado de responsable
        document.getElementById('responsable')?.addEventListener('change', function() {
            const selected = this.value;
            if (selected === 'juan_perez') {
                document.getElementById('cargo_responsable').value = 'Director de Proyectos';
                document.getElementById('email_responsable').value = 'juan.perez@empresa.com';
            } else if (selected === 'maria_garcia') {
                document.getElementById('cargo_responsable').value = 'Gerente de Proyectos';
                document.getElementById('email_responsable').value = 'maria.garcia@empresa.com';
            } else if (selected === 'carlos_rodriguez') {
                document.getElementById('cargo_responsable').value = 'Residente de Obra';
                document.getElementById('email_responsable').value = 'carlos.rodriguez@empresa.com';
            }
        });
        
        // Inicializar
        cambiarTab(1);
        
        // Validar fechas
        document.getElementById('fecha_inicio')?.addEventListener('change', function() {
            const fechaFin = document.getElementById('fecha_fin');
            if (fechaFin && fechaFin.value && this.value > fechaFin.value) {
                alert('La fecha de inicio no puede ser mayor a la fecha de fin');
                this.value = '';
            }
        });
        
        document.getElementById('fecha_fin')?.addEventListener('change', function() {
            const fechaInicio = document.getElementById('fecha_inicio');
            if (fechaInicio && fechaInicio.value && this.value < fechaInicio.value) {
                alert('La fecha de fin no puede ser menor a la fecha de inicio');
                this.value = '';
            }
        });
        
        // Mostrar notificación
        function mostrarNotificacion(mensaje, tipo) {
            const notificacion = document.createElement('div');
            notificacion.style.position = 'fixed';
            notificacion.style.top = '20px';
            notificacion.style.right = '20px';
            notificacion.style.padding = '12px 20px';
            notificacion.style.backgroundColor = tipo === 'success' ? '#28a745' : tipo === 'error' ? '#dc3545' : '#17a2b8';
            notificacion.style.color = 'white';
            notificacion.style.borderRadius = '4px';
            notificacion.style.boxShadow = '0 2px 10px rgba(0,0,0,0.2)';
            notificacion.style.zIndex = '9999';
            notificacion.style.fontSize = '14px';
            notificacion.style.animation = 'fadeIn 0.3s';
            notificacion.textContent = mensaje;
            
            document.body.appendChild(notificacion);
            
            setTimeout(() => {
                notificacion.remove();
            }, 3000);
        }
    });
</script>
@endsection