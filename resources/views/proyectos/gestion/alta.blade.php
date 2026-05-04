@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Alta de Proyecto -->
        <div class="card mt-2" style="border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1);">
            <div class="card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px; border-radius: 10px 10px 0 0;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-project-diagram"></i> Alta de Nuevo Proyecto
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Barra de progreso del alta -->
                <div style="margin-bottom: 30px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <div style="display: flex; gap: 5px; flex: 1;">
                            <div class="progress-step" style="flex: 1; text-align: center;">
                                <div class="step-circle" style="width: 35px; height: 35px; background-color: #083CAE; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; font-weight: bold;">1</div>
                                <div class="step-label" style="font-size: 12px; font-weight: 600; color: #083CAE;">Datos Generales</div>
                            </div>
                            <div class="progress-step" style="flex: 1; text-align: center;">
                                <div class="step-circle" style="width: 35px; height: 35px; background-color: #e9ecef; color: #6c757d; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; font-weight: bold;">2</div>
                                <div class="step-label" style="font-size: 12px; color: #6c757d;">Cliente y Contrato</div>
                            </div>
                            <div class="progress-step" style="flex: 1; text-align: center;">
                                <div class="step-circle" style="width: 35px; height: 35px; background-color: #e9ecef; color: #6c757d; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; font-weight: bold;">3</div>
                                <div class="step-label" style="font-size: 12px; color: #6c757d;">Responsable y Equipo</div>
                            </div>
                            <div class="progress-step" style="flex: 1; text-align: center;">
                                <div class="step-circle" style="width: 35px; height: 35px; background-color: #e9ecef; color: #6c757d; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; font-weight: bold;">4</div>
                                <div class="step-label" style="font-size: 12px; color: #6c757d;">Financiero</div>
                            </div>
                            <div class="progress-step" style="flex: 1; text-align: center;">
                                <div class="step-circle" style="width: 35px; height: 35px; background-color: #e9ecef; color: #6c757d; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; font-weight: bold;">5</div>
                                <div class="step-label" style="font-size: 12px; color: #6c757d;">Documentos</div>
                            </div>
                        </div>
                    </div>
                    <div class="progress-bar-container" style="height: 6px; background-color: #e9ecef; border-radius: 3px; overflow: hidden;">
                        <div class="progress-bar-fill" style="width: 20%; height: 100%; background-color: #083CAE; transition: width 0.3s ease;"></div>
                    </div>
                </div>

                <!-- Pestañas de secciones -->
                <div style="display: flex; gap: 5px; margin-bottom: 25px; border-bottom: 2px solid #083CAE; flex-wrap: wrap;">
                    <button type="button" class="tab-btn active" data-tab="generales" style="padding: 12px 25px; background-color: #083CAE; color: white; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s;">
                        <i class="fas fa-info-circle"></i> Datos Generales
                    </button>
                    <button type="button" class="tab-btn" data-tab="cliente" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s;">
                        <i class="fas fa-building"></i> Cliente y Contrato
                    </button>
                    <button type="button" class="tab-btn" data-tab="responsable" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s;">
                        <i class="fas fa-users"></i> Responsable y Equipo
                    </button>
                    <button type="button" class="tab-btn" data-tab="financiero" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s;">
                        <i class="fas fa-dollar-sign"></i> Financiero
                    </button>
                    <button type="button" class="tab-btn" data-tab="documentos" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s;">
                        <i class="fas fa-file-alt"></i> Documentos
                    </button>
                </div>

                <form id="formProyecto" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- SECCIÓN 1: DATOS GENERALES -->
                    <div id="tab-generales" class="tab-content active">
                        <h3 style="color: #083CAE; font-size: 18px; margin-bottom: 20px; font-weight: 600;">
                            <i class="fas fa-info-circle"></i> Información General del Proyecto
                        </h3>
                        
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px;">
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">
                                    Código del Proyecto <span style="color: #dc3545;">*</span>
                                </label>
                                <div style="display: flex;">
                                    <span style="background-color: #e9ecef; padding: 8px 12px; border: 1px solid #ced4da; border-right: none; border-radius: 4px 0 0 4px;">PRO-</span>
                                    <input type="text" class="form-control" id="codigo" name="codigo" value="{{ $codigo ?? '' }}" placeholder="2025-001" style="flex: 1; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 0 4px 4px 0; font-size: 14px;">
                                </div>
                                <small style="color: #6c757d;">Formato automático: PRO-AÑO-NÚMERO</small>
                            </div>
                            <div style="grid-column: span 2;">
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">
                                    Nombre del Proyecto <span style="color: #dc3545;">*</span>
                                </label>
                                <input type="text" class="form-control" id="nombre_proyecto" name="nombre_proyecto" placeholder="Ej: Torre Norte Corporativa" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px;">
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">
                                    Tipo de Proyecto <span style="color: #dc3545;">*</span>
                                </label>
                                <select class="form-control" id="tipo_proyecto" name="tipo_proyecto" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                                    <option value="">Seleccionar tipo...</option>
                                    <option value="construccion">Construcción</option>
                                    <option value="infraestructura">Infraestructura</option>
                                    <option value="industrial">Industrial</option>
                                    <option value="comercial">Comercial</option>
                                    <option value="residencial">Residencial</option>
                                    <option value="vialidad">Vialidad</option>
                                    <option value="hidraulico">Hidráulico</option>
                                    <option value="energia">Energía</option>
                                </select>
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Categoría</label>
                                <select class="form-control" id="categoria" name="categoria" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                                    <option value="">Seleccionar categoría...</option>
                                    <option value="obra_nueva">Obra Nueva</option>
                                    <option value="remodelacion">Remodelación</option>
                                    <option value="ampliacion">Ampliación</option>
                                    <option value="mantenimiento">Mantenimiento</option>
                                </select>
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">
                                    Prioridad <span style="color: #dc3545;">*</span>
                                </label>
                                <select class="form-control" id="prioridad" name="prioridad" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                                    <option value="">Seleccionar prioridad...</option>
                                    <option value="alta">Alta</option>
                                    <option value="media">Media</option>
                                    <option value="baja">Baja</option>
                                </select>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">
                                    Ubicación <span style="color: #dc3545;">*</span>
                                </label>
                                <input type="text" class="form-control" id="ubicacion" name="ubicacion" placeholder="Ej: Monterrey, NL" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Dirección completa</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Calle, número, colonia, código postal" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">
                                    Fecha de Inicio Estimada <span style="color: #dc3545;">*</span>
                                </label>
                                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">
                                    Fecha de Fin Estimada <span style="color: #dc3545;">*</span>
                                </label>
                                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            </div>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Descripción del Proyecto</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" placeholder="Describa el alcance del proyecto, objetivos principales, etc." style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Estado Inicial</label>
                                <select class="form-control" id="estado_inicial" name="estado_inicial" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                                    <option value="pendiente" selected>Pendiente</option>
                                    <option value="activo">Activo</option>
                                    <option value="en_curso">En Curso</option>
                                    <option value="en_espera">En Espera</option>
                                </select>
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Moneda</label>
                                <select class="form-control" id="moneda" name="moneda" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                                    <option value="MXN">MXN - Peso Mexicano</option>
                                    <option value="USD">USD - Dólar Americano</option>
                                    <option value="EUR">EUR - Euro</option>
                                </select>
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Tipo de Cambio</label>
                                <input type="number" class="form-control" id="tipo_cambio" name="tipo_cambio" placeholder="1.00" step="0.01" value="1.00" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            </div>
                        </div>
                    </div>

                    <!-- SECCIÓN 2: CLIENTE Y CONTRATO -->
                    <div id="tab-cliente" class="tab-content" style="display: none;">
                        <h3 style="color: #083CAE; font-size: 18px; margin-bottom: 20px; font-weight: 600;">
                            <i class="fas fa-building"></i> Información del Cliente y Contrato
                        </h3>

                        <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 25px;">
                            <div style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
                                <div style="flex: 1; min-width: 200px;">
                                    <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Buscar cliente existente</label>
                                    <div style="display: flex;">
                                        <input type="text" class="form-control" id="buscar_cliente" placeholder="Nombre, RFC o ID del cliente" style="flex: 1; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px 0 0 4px; font-size: 14px;">
                                        <button type="button" id="btnBuscarCliente" style="padding: 8px 15px; background-color: #6c757d; color: white; border: none; border-radius: 0 4px 4px 0; cursor: pointer;">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div style="color: #6c757d;">o</div>
                                <div>
                                    <button type="button" id="btnNuevoCliente" style="padding: 8px 15px; background-color: white; border: 2px solid #083CAE; color: #083CAE; border-radius: 4px; cursor: pointer; font-weight: 600;">
                                        <i class="fas fa-user-plus"></i> Nuevo Cliente
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px;">
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">
                                    Nombre/Razón Social <span style="color: #dc3545;">*</span>
                                </label>
                                <input type="text" class="form-control" id="cliente_nombre" name="cliente_nombre" placeholder="Nombre del cliente" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">
                                    RFC <span style="color: #dc3545;">*</span>
                                </label>
                                <input type="text" class="form-control" id="cliente_rfc" name="cliente_rfc" placeholder="XXX000000XXX" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Email</label>
                                <input type="email" class="form-control" id="cliente_email" name="cliente_email" placeholder="cliente@ejemplo.com" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px;">
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Teléfono</label>
                                <input type="text" class="form-control" id="cliente_telefono" name="cliente_telefono" placeholder="(81) 1234-5678" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Contacto</label>
                                <input type="text" class="form-control" id="cliente_contacto" name="cliente_contacto" placeholder="Nombre del contacto" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Cargo del contacto</label>
                                <input type="text" class="form-control" id="cliente_cargo" name="cliente_cargo" placeholder="Ej: Gerente de Proyectos" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
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
                                <input type="text" class="form-control" id="numero_contrato" name="numero_contrato" placeholder="CON-2025-001" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Fecha de Firma</label>
                                <input type="date" class="form-control" id="fecha_firma" name="fecha_firma" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Tipo de Contrato</label>
                                <select class="form-control" id="tipo_contrato" name="tipo_contrato" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
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
                                <select class="form-control" id="forma_pago" name="forma_pago" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                                    <option value="">Seleccionar...</option>
                                    <option value="anticipo">Anticipo + Estimaciones</option>
                                    <option value="estimaciones">Solo Estimaciones</option>
                                    <option value="porcentaje_avance">Porcentaje de Avance</option>
                                    <option value="hito">Por Hitos</option>
                                </select>
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Plazo de Pago (días)</label>
                                <input type="number" class="form-control" id="plazo_pago" name="plazo_pago" placeholder="30" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            </div>
                        </div>
                    </div>

                    <!-- SECCIÓN 3: RESPONSABLE Y EQUIPO - CORREGIDO -->
                    <div id="tab-responsable" class="tab-content" style="display: none;">
                        <h3 style="color: #083CAE; font-size: 18px; margin-bottom: 20px; font-weight: 600;">
                            <i class="fas fa-user-tie"></i> Responsable del Proyecto
                        </h3>

                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">
                                    Responsable <span style="color: #dc3545;">*</span>
                                </label>
                                <select class="form-control" id="responsable" name="responsable" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                                    <option value="">Seleccionar responsable...</option>
                                    @if(isset($usuarios) && $usuarios->count() > 0)
                                        @foreach($usuarios as $usuario)
                                            <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>No hay usuarios disponibles</option>
                                    @endif
                                </select>
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Cargo</label>
                                <input type="text" class="form-control" id="cargo_responsable" name="cargo_responsable" readonly style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; background-color: #e9ecef;">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Email</label>
                                <input type="email" class="form-control" id="email_responsable" name="email_responsable" readonly style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; background-color: #e9ecef;">
                            </div>
                        </div>

                        <h3 style="color: #083CAE; font-size: 18px; margin: 30px 0 20px; font-weight: 600;">
                            <i class="fas fa-users"></i> Equipo del Proyecto
                        </h3>

                        <div style="margin-bottom: 20px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">
                                <h4 style="font-size: 15px; font-weight: 600; color: #495057; margin: 0;">Miembros del Equipo</h4>
                                <button type="button" id="btnAgregarMiembro" style="padding: 8px 15px; background-color: white; border: 2px solid #083CAE; color: #083CAE; border-radius: 4px; cursor: pointer; font-weight: 600;">
                                    <i class="fas fa-user-plus"></i> Agregar Miembro
                                </button>
                            </div>

                            <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;">
                                <table class="table" style="width: 100%; font-size: 13px; min-width: 500px;">
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
                                    </tbody>
                                </table>
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
                                    <input type="number" class="form-control" id="presupuesto_total" name="presupuesto_total" placeholder="0.00" step="0.01" style="flex: 1; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 0 4px 4px 0; font-size: 14px;">
                                </div>
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Anticipo (%)</label>
                                <div style="display: flex;">
                                    <input type="number" class="form-control" id="anticipo" name="anticipo" placeholder="0" step="1" min="0" max="100" style="flex: 1; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px 0 0 4px; font-size: 14px;">
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
                                    <input type="number" class="form-control" id="margen" name="margen" placeholder="25" step="0.1" min="0" max="100" style="flex: 1; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px 0 0 4px; font-size: 14px;">
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
                                    <input type="number" class="form-control" id="fondo_reserva" name="fondo_reserva" placeholder="0.00" step="0.01" style="flex: 1; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 0 4px 4px 0; font-size: 14px;">
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
                                    <input type="number" class="form-control costo-input" data-costo="materiales" placeholder="0.00" style="flex: 1; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 0 4px 4px 0; font-size: 14px;">
                                </div>
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Costo de Mano de Obra</label>
                                <div style="display: flex;">
                                    <span style="background-color: #e9ecef; padding: 8px 12px; border: 1px solid #ced4da; border-right: none; border-radius: 4px 0 0 4px;">$</span>
                                    <input type="number" class="form-control costo-input" data-costo="mano_obra" placeholder="0.00" style="flex: 1; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 0 4px 4px 0; font-size: 14px;">
                                </div>
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Costo de Maquinaria</label>
                                <div style="display: flex;">
                                    <span style="background-color: #e9ecef; padding: 8px 12px; border: 1px solid #ced4da; border-right: none; border-radius: 4px 0 0 4px;">$</span>
                                    <input type="number" class="form-control costo-input" data-costo="maquinaria" placeholder="0.00" style="flex: 1; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 0 4px 4px 0; font-size: 14px;">
                                </div>
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #495057; font-size: 13px;">Gastos Indirectos</label>
                                <div style="display: flex;">
                                    <span style="background-color: #e9ecef; padding: 8px 12px; border: 1px solid #ced4da; border-right: none; border-radius: 4px 0 0 4px;">$</span>
                                    <input type="number" class="form-control costo-input" data-costo="gastos_indirectos" placeholder="0.00" style="flex: 1; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 0 4px 4px 0; font-size: 14px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SECCIÓN 5: DOCUMENTOS -->
                    <div id="tab-documentos" class="tab-content" style="display: none;">
                        <h3 style="color: #083CAE; font-size: 18px; margin-bottom: 20px; font-weight: 600;">
                            <i class="fas fa-upload"></i> Carga de Documentos
                        </h3>

                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px;">
                            <div class="upload-area" data-tipo="contrato" style="border: 2px dashed #ced4da; border-radius: 8px; padding: 30px; text-align: center; background-color: #f8f9fa; cursor: pointer; transition: all 0.3s;">
                                <i class="fas fa-file-contract" style="font-size: 48px; color: #083CAE; margin-bottom: 15px;"></i>
                                <h4 style="font-size: 16px; margin-bottom: 10px;">Contrato</h4>
                                <p style="font-size: 12px; color: #6c757d; margin-bottom: 15px;">Arrastra o haz clic para seleccionar</p>
                                <input type="file" class="file-input" data-tipo="contrato" accept=".pdf,.doc,.docx" style="display: none;">
                                <p style="font-size: 11px; color: #6c757d;">PDF, DOC, DOCX (Max. 10MB)</p>
                            </div>

                            <div class="upload-area" data-tipo="anexos" style="border: 2px dashed #ced4da; border-radius: 8px; padding: 30px; text-align: center; background-color: #f8f9fa; cursor: pointer; transition: all 0.3s;">
                                <i class="fas fa-file-pdf" style="font-size: 48px; color: #083CAE; margin-bottom: 15px;"></i>
                                <h4 style="font-size: 16px; margin-bottom: 10px;">Anexos Técnicos</h4>
                                <p style="font-size: 12px; color: #6c757d; margin-bottom: 15px;">Arrastra o haz clic para seleccionar</p>
                                <input type="file" class="file-input" data-tipo="anexos" multiple accept=".pdf,.dwg,.dxf" style="display: none;">
                                <p style="font-size: 11px; color: #6c757d;">PDF, DWG, DXF (Max. 50MB)</p>
                            </div>
                        </div>

                        <div id="listaDocumentos" style="margin-top: 30px;">
                            <h3 style="color: #083CAE; font-size: 16px; margin-bottom: 20px; font-weight: 600;">
                                <i class="fas fa-list"></i> Documentos Cargados
                            </h3>
                            <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;">
                                <table class="table" style="width: 100%; font-size: 13px; min-width: 500px;">
                                    <thead style="background-color: #f8f9fa;">
                                        <tr>
                                            <th style="padding: 10px;">Tipo</th>
                                            <th style="padding: 10px;">Nombre</th>
                                            <th style="padding: 10px;">Tamaño</th>
                                            <th style="padding: 10px;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="documentosBody">
                                        <tr>
                                            <td colspan="4" style="text-align: center; padding: 20px;">No hay documentos cargados</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div style="display: flex; justify-content: space-between; margin-top: 30px; padding-top: 20px; border-top: 1px solid #dee2e6; flex-wrap: wrap; gap: 10px;">
                        <div>
                            <button type="button" id="btnGuardarBorrador" style="padding: 12px 25px; background-color: white; border: 2px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer; font-weight: 600;">
                                <i class="fas fa-save"></i> Guardar Borrador
                            </button>
                            <button type="button" id="btnCancelar" style="padding: 12px 25px; background-color: white; border: 2px solid #dc3545; color: #dc3545; border-radius: 4px; cursor: pointer; font-weight: 600;">
                                <i class="fas fa-times"></i> Cancelar
                            </button>
                        </div>
                        <div>
                            <button type="button" id="btnAnterior" style="padding: 12px 25px; background-color: white; border: 2px solid #083CAE; color: #083CAE; border-radius: 4px; cursor: pointer; font-weight: 600; display: none;">
                                <i class="fas fa-arrow-left"></i> Anterior
                            </button>
                            <button type="button" id="btnSiguiente" style="padding: 12px 30px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">
                                Siguiente <i class="fas fa-arrow-right"></i>
                            </button>
                            <button type="button" id="btnGuardar" style="padding: 12px 30px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 600; display: none;">
                                <i class="fas fa-check"></i> Guardar Proyecto
                            </button>
                        </div>
                    </div>
                </form>
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
    .upload-area:hover {
        border-color: #083CAE !important;
        background-color: #e8f0fe !important;
    }
    @media (max-width: 768px) {
        div[style*="grid-template-columns"] {
            grid-template-columns: 1fr !important;
        }
        .tab-btn {
            padding: 10px 15px !important;
            font-size: 12px !important;
        }
        .progress-step .step-label {
            font-size: 10px !important;
        }
        .progress-step .step-circle {
            width: 28px !important;
            height: 28px !important;
            font-size: 12px !important;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentTab = 1;
    const totalTabs = 5;
    let equipoMiembros = [];
    let documentosCargados = [];
    
    const tabs = document.querySelectorAll('.tab-content');
    const tabButtons = document.querySelectorAll('.tab-btn');
    const btnAnterior = document.getElementById('btnAnterior');
    const btnSiguiente = document.getElementById('btnSiguiente');
    const btnGuardar = document.getElementById('btnGuardar');
    const btnGuardarBorrador = document.getElementById('btnGuardarBorrador');
    const btnCancelar = document.getElementById('btnCancelar');
    const progressBar = document.querySelector('.progress-bar-fill');
    const progressSteps = document.querySelectorAll('.progress-step');
    const presupuestoTotal = document.getElementById('presupuesto_total');
    const anticipo = document.getElementById('anticipo');
    const montoAnticipo = document.getElementById('monto_anticipo');
    const margen = document.getElementById('margen');
    const utilidad = document.getElementById('utilidad');
    
    function cambiarTab(tabIndex) {
        tabs.forEach(tab => tab.style.display = 'none');
        
        const tabId = tabIndex === 1 ? 'tab-generales' : 
                      tabIndex === 2 ? 'tab-cliente' : 
                      tabIndex === 3 ? 'tab-responsable' : 
                      tabIndex === 4 ? 'tab-financiero' : 'tab-documentos';
        document.getElementById(tabId).style.display = 'block';
        
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
        
        if (progressBar) {
            progressBar.style.width = `${(tabIndex / totalTabs) * 100}%`;
        }
        
        progressSteps.forEach((step, index) => {
            const circle = step.querySelector('.step-circle');
            const label = step.querySelector('.step-label');
            if (index + 1 <= tabIndex) {
                circle.style.backgroundColor = '#083CAE';
                circle.style.color = 'white';
                if (label) label.style.color = '#083CAE';
            } else {
                circle.style.backgroundColor = '#e9ecef';
                circle.style.color = '#6c757d';
                if (label) label.style.color = '#6c757d';
            }
        });
        
        btnAnterior.style.display = tabIndex === 1 ? 'none' : 'inline-block';
        
        if (tabIndex === totalTabs) {
            btnSiguiente.style.display = 'none';
            btnGuardar.style.display = 'inline-block';
        } else {
            btnSiguiente.style.display = 'inline-block';
            btnGuardar.style.display = 'none';
        }
        
        currentTab = tabIndex;
    }
    
    tabButtons.forEach((btn, index) => {
        btn.addEventListener('click', () => cambiarTab(index + 1));
    });
    
    btnSiguiente.addEventListener('click', () => {
        if (validarPestanaActual() && currentTab < totalTabs) {
            cambiarTab(currentTab + 1);
        }
    });
    
    btnAnterior.addEventListener('click', () => {
        if (currentTab > 1) cambiarTab(currentTab - 1);
    });
    
    function validarPestanaActual() {
        if (currentTab === 1) {
            const requeridos = ['codigo', 'nombre_proyecto', 'tipo_proyecto', 'prioridad', 'ubicacion', 'fecha_inicio', 'fecha_fin'];
            for (let campo of requeridos) {
                const input = document.getElementById(campo);
                if (input && !input.value.trim()) {
                    mostrarNotificacion(`El campo ${campo.replace(/_/g, ' ')} es requerido`, 'error');
                    input.focus();
                    return false;
                }
            }
            const fechaInicio = document.getElementById('fecha_inicio').value;
            const fechaFin = document.getElementById('fecha_fin').value;
            if (fechaInicio && fechaFin && fechaInicio > fechaFin) {
                mostrarNotificacion('La fecha de inicio no puede ser mayor a la fecha de fin', 'error');
                return false;
            }
        }
        if (currentTab === 2) {
            const requeridos = ['cliente_nombre', 'cliente_rfc', 'numero_contrato'];
            for (let campo of requeridos) {
                const input = document.getElementById(campo);
                if (input && !input.value.trim()) {
                    mostrarNotificacion(`El campo ${campo.replace(/_/g, ' ')} es requerido`, 'error');
                    input.focus();
                    return false;
                }
            }
        }
        if (currentTab === 3) {
            if (!document.getElementById('responsable').value) {
                mostrarNotificacion('Debe seleccionar un responsable para el proyecto', 'error');
                return false;
            }
        }
        if (currentTab === 4) {
            const presupuesto = document.getElementById('presupuesto_total').value;
            if (!presupuesto || parseFloat(presupuesto) <= 0) {
                mostrarNotificacion('El presupuesto total es requerido y debe ser mayor a 0', 'error');
                document.getElementById('presupuesto_total').focus();
                return false;
            }
        }
        return true;
    }
    
    function calcularMontoAnticipo() {
        const presupuesto = parseFloat(presupuestoTotal?.value) || 0;
        const porcentaje = parseFloat(anticipo?.value) || 0;
        const monto = (presupuesto * porcentaje) / 100;
        if (montoAnticipo) {
            montoAnticipo.value = '$' + monto.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }
    }
    
    function calcularUtilidad() {
        const presupuesto = parseFloat(presupuestoTotal?.value) || 0;
        const porcentajeMargen = parseFloat(margen?.value) || 0;
        const monto = (presupuesto * porcentajeMargen) / 100;
        if (utilidad) {
            utilidad.value = '$' + monto.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }
    }
    
    if (presupuestoTotal) presupuestoTotal.addEventListener('input', () => { calcularMontoAnticipo(); calcularUtilidad(); });
    if (anticipo) anticipo.addEventListener('input', calcularMontoAnticipo);
    if (margen) margen.addEventListener('input', calcularUtilidad);
    
    // Buscar cliente
    document.getElementById('btnBuscarCliente')?.addEventListener('click', function() {
        const termino = document.getElementById('buscar_cliente').value;
        if (termino.length < 3) {
            mostrarNotificacion('Ingrese al menos 3 caracteres para buscar', 'warning');
            return;
        }
        fetch(`/proyectos/buscar-cliente?q=${encodeURIComponent(termino)}`, {
            headers: { 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.length > 0) {
                const cliente = data[0];
                document.getElementById('cliente_nombre').value = cliente.cliente_nombre || '';
                document.getElementById('cliente_rfc').value = cliente.cliente_rfc || '';
                document.getElementById('cliente_email').value = cliente.cliente_email || '';
                document.getElementById('cliente_telefono').value = cliente.cliente_telefono || '';
                document.getElementById('cliente_contacto').value = cliente.cliente_contacto || '';
                document.getElementById('cliente_cargo').value = cliente.cliente_cargo || '';
                mostrarNotificacion('Cliente encontrado', 'success');
            } else {
                mostrarNotificacion('No se encontraron clientes', 'warning');
            }
        });
    });
    
    // Nuevo cliente
    document.getElementById('btnNuevoCliente')?.addEventListener('click', function() {
        ['cliente_nombre', 'cliente_rfc', 'cliente_email', 'cliente_telefono', 'cliente_contacto', 'cliente_cargo'].forEach(id => {
            document.getElementById(id).value = '';
        });
        document.getElementById('buscar_cliente').value = '';
        document.getElementById('cliente_nombre').focus();
        mostrarNotificacion('Campos de cliente limpiados', 'success');
    });
    
    // Agregar miembro
    document.getElementById('btnAgregarMiembro')?.addEventListener('click', function() {
        const nombre = prompt('Nombre del miembro:');
        if (!nombre) return;
        const rol = prompt('Rol:');
        if (!rol) return;
        const departamento = prompt('Departamento:');
        if (!departamento) return;
        const dedicacion = prompt('Porcentaje de dedicación (1-100):', '100');
        if (!dedicacion || isNaN(dedicacion) || dedicacion < 1 || dedicacion > 100) {
            mostrarNotificacion('La dedicación debe ser un número entre 1 y 100', 'error');
            return;
        }
        equipoMiembros.push({ nombre, rol, departamento, dedicacion });
        actualizarTablaEquipo();
    });
    
    function actualizarTablaEquipo() {
        const tbody = document.getElementById('equipoBody');
        if (!tbody) return;
        tbody.innerHTML = '';
        equipoMiembros.forEach((miembro, index) => {
            const row = tbody.insertRow();
            row.innerHTML = `
                <td style="padding: 10px;">${escapeHtml(miembro.nombre)}</td>
                <td style="padding: 10px;">${escapeHtml(miembro.rol)}</td>
                <td style="padding: 10px;">${escapeHtml(miembro.departamento)}</td>
                <td style="padding: 10px;">${miembro.dedicacion}%</td>
                <td style="padding: 10px;">
                    <button type="button" class="btn-eliminar-miembro" data-index="${index}" style="background: none; border: none; color: #dc3545; cursor: pointer;">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            `;
        });
        document.querySelectorAll('.btn-eliminar-miembro').forEach(btn => {
            btn.addEventListener('click', function() {
                equipoMiembros.splice(parseInt(this.dataset.index), 1);
                actualizarTablaEquipo();
            });
        });
    }
    
    // Documentos
    document.querySelectorAll('.upload-area').forEach(area => {
        area.addEventListener('click', function() {
            this.querySelector('.file-input')?.click();
        });
        area.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.borderColor = '#083CAE';
            this.style.backgroundColor = '#e8f0fe';
        });
        area.addEventListener('dragleave', function(e) {
            this.style.borderColor = '#ced4da';
            this.style.backgroundColor = '#f8f9fa';
        });
        area.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.borderColor = '#ced4da';
            this.style.backgroundColor = '#f8f9fa';
            procesarArchivos(e.dataTransfer.files, this.dataset.tipo);
        });
    });
    
    document.querySelectorAll('.file-input').forEach(input => {
        input.addEventListener('change', function() {
            procesarArchivos(this.files, this.dataset.tipo);
        });
    });
    
    function procesarArchivos(files, tipo) {
        const maxSize = tipo === 'contrato' ? 10 * 1024 * 1024 : 50 * 1024 * 1024;
        for (let file of files) {
            if (file.size > maxSize) {
                mostrarNotificacion(`El archivo ${file.name} excede el tamaño máximo`, 'error');
                continue;
            }
            documentosCargados.push({ tipo, nombre: file.name, tamaño: file.size, archivo: file });
        }
        actualizarListaDocumentos();
    }
    
    function actualizarListaDocumentos() {
        const tbody = document.getElementById('documentosBody');
        if (!tbody) return;
        if (documentosCargados.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" style="text-align: center; padding: 20px;">No hay documentos cargados</td></tr>';
            return;
        }
        tbody.innerHTML = '';
        documentosCargados.forEach((doc, index) => {
            const row = tbody.insertRow();
            row.innerHTML = `
                <td style="padding: 10px;"><i class="fas fa-file"></i> ${doc.tipo}</td>
                <td style="padding: 10px;">${escapeHtml(doc.nombre)}</td>
                <td style="padding: 10px;">${formatBytes(doc.tamaño)}</td>
                <td style="padding: 10px;">
                    <button type="button" class="btn-eliminar-documento" data-index="${index}" style="background: none; border: none; color: #dc3545; cursor: pointer;">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            `;
        });
        document.querySelectorAll('.btn-eliminar-documento').forEach(btn => {
            btn.addEventListener('click', function() {
                documentosCargados.splice(parseInt(this.dataset.index), 1);
                actualizarListaDocumentos();
            });
        });
    }
    
    // Guardar proyecto
    async function guardarProyecto(status = 'activo') {
        if (status === 'activo' && !validarFormularioCompleto()) return;
        
        const formData = new FormData();
        const campos = ['codigo', 'nombre_proyecto', 'tipo_proyecto', 'categoria', 'prioridad', 
                        'ubicacion', 'direccion', 'fecha_inicio', 'fecha_fin', 'descripcion', 
                        'estado_inicial', 'moneda', 'tipo_cambio', 'cliente_nombre', 'cliente_rfc', 
                        'cliente_email', 'cliente_telefono', 'cliente_contacto', 'cliente_cargo', 
                        'numero_contrato', 'fecha_firma', 'tipo_contrato', 'forma_pago', 'plazo_pago', 
                        'responsable', 'cargo_responsable', 'email_responsable', 'presupuesto_total', 
                        'anticipo', 'margen', 'fondo_reserva'];
        
        campos.forEach(campo => {
            const input = document.getElementById(campo);
            if (input && input.value) formData.append(campo, input.value);
        });
        
        formData.append('equipo', JSON.stringify(equipoMiembros));
        
        const costos = {
            materiales: document.querySelector('.costo-input[data-costo="materiales"]')?.value || 0,
            mano_obra: document.querySelector('.costo-input[data-costo="mano_obra"]')?.value || 0,
            maquinaria: document.querySelector('.costo-input[data-costo="maquinaria"]')?.value || 0,
            gastos_indirectos: document.querySelector('.costo-input[data-costo="gastos_indirectos"]')?.value || 0
        };
        formData.append('costos', JSON.stringify(costos));
        
        documentosCargados.forEach(doc => {
            formData.append(`documentos[${doc.tipo}][]`, doc.archivo);
        });
        
        formData.append('status', status);
        
        const btn = status === 'activo' ? btnGuardar : btnGuardarBorrador;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
        btn.disabled = true;
        
        try {
            const response = await fetch('{{ route("proyectos.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            });
            const data = await response.json();
            if (data.success) {
                mostrarNotificacion(data.message, 'success');
                setTimeout(() => { window.location.href = '/proyectos/cartera'; }, 1500);
            } else {
                mostrarNotificacion(data.message || 'Error al guardar', 'error');
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        } catch (error) {
            mostrarNotificacion('Error de conexión', 'error');
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    }
    
    function validarFormularioCompleto() {
        for (let campo of ['codigo', 'nombre_proyecto', 'tipo_proyecto', 'prioridad', 'ubicacion', 'fecha_inicio', 'fecha_fin']) {
            if (!document.getElementById(campo)?.value?.trim()) {
                mostrarNotificacion('Complete todos los campos en Datos Generales', 'error');
                cambiarTab(1);
                return false;
            }
        }
        for (let campo of ['cliente_nombre', 'cliente_rfc', 'numero_contrato']) {
            if (!document.getElementById(campo)?.value?.trim()) {
                mostrarNotificacion('Complete todos los campos en Cliente y Contrato', 'error');
                cambiarTab(2);
                return false;
            }
        }
        if (!document.getElementById('responsable').value) {
            mostrarNotificacion('Seleccione un responsable', 'error');
            cambiarTab(3);
            return false;
        }
        if (!document.getElementById('presupuesto_total').value || parseFloat(document.getElementById('presupuesto_total').value) <= 0) {
            mostrarNotificacion('Ingrese un presupuesto válido', 'error');
            cambiarTab(4);
            return false;
        }
        return true;
    }
    
    btnGuardar?.addEventListener('click', () => guardarProyecto('activo'));
    btnGuardarBorrador?.addEventListener('click', () => guardarProyecto('borrador'));
    btnCancelar?.addEventListener('click', () => {
        if (confirm('¿Cancelar el alta del proyecto?')) window.location.href = '/proyectos';
    });
    
    // Autocompletar responsable
    document.getElementById('responsable')?.addEventListener('change', function() {
        const data = responsableData[this.value];
        document.getElementById('cargo_responsable').value = data ? data.cargo : '';
        document.getElementById('email_responsable').value = data ? data.email : '';
    });
    
    // Helpers
    function mostrarNotificacion(mensaje, tipo) {
        const el = document.createElement('div');
        el.style.cssText = `position:fixed;top:20px;right:20px;padding:12px 20px;border-radius:4px;z-index:9999;font-size:14px;max-width:300px;background-color:${tipo==='success'?'#28a745':tipo==='error'?'#dc3545':tipo==='warning'?'#ffc107':'#17a2b8'};color:${tipo==='warning'?'#000':'white'}`;
        el.textContent = mensaje;
        document.body.appendChild(el);
        setTimeout(() => el.remove(), 3000);
    }
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    function formatBytes(bytes) {
        if (!bytes) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        return parseFloat((bytes / Math.pow(k, sizes.length - 1)).toFixed(2)) + ' ' + sizes[sizes.length - 1];
    }
    
    // Iniciar
    cambiarTab(1);
});
</script>
@endsection