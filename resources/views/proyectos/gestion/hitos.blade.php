@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="card mt-2" style="border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1);">
            <div class="card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-project-diagram"></i> Cronogramas y Hitos de Proyectos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Filtros -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <select id="selectorProyecto" style="padding: 10px 15px; border: 1px solid #ced4da; border-radius: 8px; font-size: 14px; min-width: 250px;">
                            <option value="">Todos los proyectos</option>
                            @foreach($proyectos as $proyecto)
                                <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                            @endforeach
                        </select>
                        <div style="display: flex; gap: 5px; background-color: #e9ecef; padding: 4px; border-radius: 8px;">
                            <button class="vista-btn active" data-vista="calendario" style="padding: 8px 15px; background-color: #083CAE; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 13px;">
                                <i class="fas fa-calendar"></i> Calendario
                            </button>
                            <button class="vista-btn" data-vista="gantt" style="padding: 8px 15px; background-color: transparent; color: #495057; border: none; border-radius: 6px; cursor: pointer; font-size: 13px;">
                                <i class="fas fa-chart-bar"></i> Gantt
                            </button>
                            <button class="vista-btn" data-vista="lista" style="padding: 8px 15px; background-color: transparent; color: #495057; border: none; border-radius: 6px; cursor: pointer; font-size: 13px;">
                                <i class="fas fa-list"></i> Lista
                            </button>
                        </div>
                    </div>
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <div style="display: flex; align-items: center; gap: 5px;">
                            <input type="date" id="fechaInicio" value="{{ date('Y-01-01') }}" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <span style="color: #6c757d;">a</span>
                            <input type="date" id="fechaFin" value="{{ date('Y-12-31') }}" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                        </div>
                        <button id="btnNuevoHito" style="padding: 8px 15px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 13px;">
                            <i class="fas fa-plus"></i> Nuevo Hito
                        </button>
                    </div>
                </div>

                <!-- Resumen -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px;">
                    <div class="resumen-card" style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 40px; height: 40px; background-color: #e8f0fe; border-radius: 8px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-flag-checkered" style="color: #083CAE;"></i></div>
                            <div><div style="font-size: 12px; color: #6c757d;">Total Hitos</div><div style="font-size: 24px; font-weight: bold; color: #083CAE;" id="totalHitos">{{ $stats['total'] ?? 0 }}</div></div>
                        </div>
                    </div>
                    <div class="resumen-card" style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 40px; height: 40px; background-color: #d4edda; border-radius: 8px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-check-circle" style="color: #28a745;"></i></div>
                            <div><div style="font-size: 12px; color: #6c757d;">Completados</div><div style="font-size: 24px; font-weight: bold; color: #28a745;" id="completadosHitos">{{ $stats['completados'] ?? 0 }}</div></div>
                        </div>
                    </div>
                    <div class="resumen-card" style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 40px; height: 40px; background-color: #fff3cd; border-radius: 8px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-clock" style="color: #ffc107;"></i></div>
                            <div><div style="font-size: 12px; color: #6c757d;">En Proceso</div><div style="font-size: 24px; font-weight: bold; color: #ffc107;" id="procesoHitos">{{ $stats['en_proceso'] ?? 0 }}</div></div>
                        </div>
                    </div>
                    <div class="resumen-card" style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 40px; height: 40px; background-color: #f8d7da; border-radius: 8px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-exclamation-triangle" style="color: #dc3545;"></i></div>
                            <div><div style="font-size: 12px; color: #6c757d;">Retrasados</div><div style="font-size: 24px; font-weight: bold; color: #dc3545;" id="retrasadosHitos">{{ $stats['retrasados'] ?? 0 }}</div></div>
                        </div>
                    </div>
                </div>

                <!-- VISTA CALENDARIO -->
                <div id="vista-calendario" class="vista-content active">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div style="display: flex; gap: 10px;">
                            <button id="btnMesAnterior" style="padding: 8px 15px; background: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;"><i class="fas fa-chevron-left"></i></button>
                            <h3 style="font-size: 18px; font-weight: 600; color: #083CAE; margin: 0;" id="mesActual"></h3>
                            <button id="btnMesSiguiente" style="padding: 8px 15px; background: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;"><i class="fas fa-chevron-right"></i></button>
                        </div>
                        <button id="btnHoy" style="padding: 8px 15px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">Hoy</button>
                    </div>
                    <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 5px; margin-bottom: 5px;">
                        <div style="text-align: center; font-weight: 600; color: #083CAE; padding: 10px;">Lun</div><div style="text-align: center; font-weight: 600; color: #083CAE; padding: 10px;">Mar</div><div style="text-align: center; font-weight: 600; color: #083CAE; padding: 10px;">Mié</div><div style="text-align: center; font-weight: 600; color: #083CAE; padding: 10px;">Jue</div><div style="text-align: center; font-weight: 600; color: #083CAE; padding: 10px;">Vie</div><div style="text-align: center; font-weight: 600; color: #6c757d; padding: 10px;">Sáb</div><div style="text-align: center; font-weight: 600; color: #6c757d; padding: 10px;">Dom</div>
                    </div>
                    <div id="calendarioGrid" style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 5px; min-height: 600px;"></div>
                    <div style="display: flex; gap: 20px; margin-top: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 8px; flex-wrap: wrap;">
                        <div style="display: flex; align-items: center; gap: 8px;"><div style="width: 16px; height: 16px; background-color: #dc3545; border-radius: 3px;"></div><span style="font-size: 12px;">Retrasados</span></div>
                        <div style="display: flex; align-items: center; gap: 8px;"><div style="width: 16px; height: 16px; background-color: #28a745; border-radius: 3px;"></div><span style="font-size: 12px;">Completados</span></div>
                        <div style="display: flex; align-items: center; gap: 8px;"><div style="width: 16px; height: 16px; background-color: #ffc107; border-radius: 3px;"></div><span style="font-size: 12px;">En Proceso</span></div>
                        <div style="display: flex; align-items: center; gap: 8px;"><div style="width: 16px; height: 16px; background-color: #6c757d; border-radius: 3px;"></div><span style="font-size: 12px;">Programados</span></div>
                    </div>
                </div>

                <!-- VISTA GANTT (ESTILO ORIGINAL CON DATOS REALES) -->
                <div id="vista-gantt" class="vista-content" style="display: none;">
                    <div id="ganttContainer" style="overflow-x: auto; margin-top: 20px;">
                        <p style="text-align: center; color: #6c757d; padding: 40px;">Cargando diagrama Gantt...</p>
                    </div>
                </div>

                <!-- VISTA LISTA -->
                <div id="vista-lista" class="vista-content" style="display: none;">
                    <div style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
                        <button class="filtro-hito active" data-filtro="todos" style="padding: 8px 15px; background-color: #083CAE; color: white; border: none; border-radius: 20px; cursor: pointer; font-size: 12px;">Todos</button>
                        <button class="filtro-hito" data-filtro="completados" style="padding: 8px 15px; background-color: white; border: 1px solid #dee2e6; border-radius: 20px; cursor: pointer; font-size: 12px;">Completados</button>
                        <button class="filtro-hito" data-filtro="en_proceso" style="padding: 8px 15px; background-color: white; border: 1px solid #dee2e6; border-radius: 20px; cursor: pointer; font-size: 12px;">En Proceso</button>
                        <button class="filtro-hito" data-filtro="retrasados" style="padding: 8px 15px; background-color: white; border: 1px solid #dee2e6; border-radius: 20px; cursor: pointer; font-size: 12px;">Retrasados</button>
                    </div>
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse; min-width: 1200px;">
                            <thead style="background-color: #f8f9fa; border-bottom: 2px solid #083CAE;">
                                <tr>
                                    <th style="padding: 12px;">Proyecto</th><th style="padding: 12px;">Hito</th><th style="padding: 12px;">Responsable</th>
                                    <th style="padding: 12px;">Inicio</th><th style="padding: 12px;">Fin</th><th style="padding: 12px;">Duración</th>
                                    <th style="padding: 12px;">Estado</th><th style="padding: 12px;">Avance</th><th style="padding: 12px; text-align: center;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaHitosBody">
                                <tr><td colspan="9" style="text-align: center; padding: 40px;">Cargando hitos...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- MODAL -->
                <div id="modalHito" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
                    <div style="background: white; border-radius: 8px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
                        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
                            <h3 style="margin: 0; color: #083CAE;" id="modalTitulo"><i class="fas fa-flag"></i> Nuevo Hito</h3>
                            <button id="btnCerrarModal" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
                        </div>
                        <form id="formHito">
                            <input type="hidden" id="modalHitoId">
                            <div style="padding: 20px;">
                                <div style="margin-bottom: 15px;">
                                    <label style="font-weight: 600;">Proyecto <span style="color: #dc3545;">*</span></label>
                                    <select id="modalProyecto" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                                        <option value="">Seleccionar...</option>
                                        @foreach($proyectos as $p)<option value="{{ $p->id }}">{{ $p->codigo }} - {{ $p->nombre }}</option>@endforeach
                                    </select>
                                </div>
                                <div style="margin-bottom: 15px;">
                                    <label style="font-weight: 600;">Nombre <span style="color: #dc3545;">*</span></label>
                                    <input type="text" id="modalNombre" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                                </div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                                    <div><label style="font-weight: 600;">Fecha Inicio <span style="color: #dc3545;">*</span></label><input type="date" id="modalFecha" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;"></div>
                                    <div><label style="font-weight: 600;">Fecha Fin</label><input type="date" id="modalFechaFin" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;"></div>
                                </div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                                    <div><label style="font-weight: 600;">Estado</label><select id="modalEstado" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;"><option value="programado">Programado</option><option value="en_proceso">En Proceso</option><option value="completado">Completado</option><option value="retrasado">Retrasado</option></select></div>
                                    <div><label style="font-weight: 600;">Responsable</label><select id="modalResponsable" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;"><option value="">Sin asignar</option>@foreach($usuarios as $u)<option value="{{ $u->id }}">{{ $u->name }}</option>@endforeach</select></div>
                                </div>
                                <div style="margin-bottom: 15px;"><label style="font-weight: 600;">Prioridad</label><select id="modalPrioridad" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;"><option value="media">Media</option><option value="alta">Alta</option><option value="baja">Baja</option></select></div>
                                <div style="margin-bottom: 15px;">
                                    <label style="font-weight: 600;">Avance (%)</label>
                                    <input type="range" id="modalAvanceSlider" min="0" max="100" value="0" style="width: 100%;" oninput="document.getElementById('avanceValor').textContent=this.value+'%';document.getElementById('modalAvance').value=this.value;">
                                    <span id="avanceValor" style="font-weight: 600; color: #083CAE;">0%</span><input type="hidden" id="modalAvance" value="0">
                                </div>
                                <div style="margin-bottom: 15px;"><label style="display: flex; align-items: center; gap: 8px; cursor: pointer;"><input type="checkbox" id="modalCritico"> Marcar como hito crítico</label></div>
                                <div style="margin-bottom: 15px;"><label style="font-weight: 600;">Descripción</label><textarea id="modalDescripcion" rows="2" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;"></textarea></div>
                            </div>
                            <div style="padding: 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
                                <button type="button" id="btnCancelarHito" style="padding: 10px 20px; background: white; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer;">Cancelar</button>
                                <button type="submit" style="padding: 10px 20px; background: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">Guardar Hito</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .vista-btn { transition: all 0.3s ease; }
    .vista-btn.active { background-color: #083CAE !important; color: white !important; }
    .filtro-hito { transition: all 0.3s ease; }
    .filtro-hito.active { background-color: #083CAE !important; color: white !important; border-color: #083CAE !important; }
    .resumen-card { transition: transform 0.2s; }
    .resumen-card:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    .vista-content { animation: fadeIn 0.3s ease; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .calendario-dia { background: white; border: 1px solid #dee2e6; border-radius: 4px; padding: 5px; min-height: 100px; }
    .calendario-dia.otro-mes { background: #f8f9fa; color: #adb5bd; }
    .calendario-dia.hoy { border: 2px solid #083CAE; }
    .evento-hito { padding: 3px 5px; margin-bottom: 2px; font-size: 10px; border-radius: 2px; cursor: pointer; border-left: 3px solid #6c757d; background: #e9ecef; }
    .evento-hito.completado { background: #d4edda; border-left-color: #28a745; }
    .evento-hito.en_proceso { background: #fff3cd; border-left-color: #ffc107; }
    .evento-hito.retrasado { background: #f8d7da; border-left-color: #dc3545; }
    .evento-hito.continuacion { opacity: 0.6; font-style: italic; }
    .gantt-proyecto-header { cursor: pointer; user-select: none; }
    .gantt-proyecto-header:hover { opacity: 0.9; }
    @media (max-width: 768px) { .calendario-dia { min-height: 70px; font-size: 11px; } .evento-hito { font-size: 8px; } }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentMonth = new Date().getMonth(), currentYear = new Date().getFullYear(), hitosData = [];
    const monthNames = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

    // Vistas
    document.querySelectorAll('.vista-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.vista-btn').forEach(b => { b.classList.remove('active'); b.style.background='transparent'; b.style.color='#495057'; });
            this.classList.add('active'); this.style.background='#083CAE'; this.style.color='white';
            document.querySelectorAll('.vista-content').forEach(v => v.style.display = 'none');
            document.getElementById('vista-' + this.dataset.vista).style.display = 'block';
            if (this.dataset.vista === 'calendario') generarCalendario();
            if (this.dataset.vista === 'gantt') cargarGantt();
        });
    });

    // Cargar hitos
    async function cargarHitos() {
        const p = new URLSearchParams();
        if (document.getElementById('selectorProyecto').value) p.append('proyecto_id', document.getElementById('selectorProyecto').value);
        if (document.getElementById('fechaInicio').value) p.append('fecha_inicio', document.getElementById('fechaInicio').value);
        if (document.getElementById('fechaFin').value) p.append('fecha_fin', document.getElementById('fechaFin').value);
        const res = await fetch('/proyectos/hitos/data?' + p);
        const data = await res.json();
        if (data.success) {
            hitosData = data.hitos;
            document.getElementById('totalHitos').textContent = data.stats.total;
            document.getElementById('completadosHitos').textContent = data.stats.completados;
            document.getElementById('procesoHitos').textContent = data.stats.en_proceso;
            document.getElementById('retrasadosHitos').textContent = data.stats.retrasados;
            generarCalendario(); cargarLista(); cargarGantt();
        }
    }

    function generarCalendario() {
        const grid = document.getElementById('calendarioGrid');
        document.getElementById('mesActual').textContent = monthNames[currentMonth] + ' ' + currentYear;
        const firstDay = new Date(currentYear, currentMonth, 1), lastDay = new Date(currentYear, currentMonth+1, 0);
        const startDay = firstDay.getDay(), daysInMonth = lastDay.getDate();
        let startOffset = startDay === 0 ? 6 : startDay - 1;
        const prevLast = new Date(currentYear, currentMonth, 0).getDate(), today = new Date();
        grid.innerHTML = '';

        for (let i = 0; i < 42; i++) {
            const dia = document.createElement('div'); dia.className = 'calendario-dia';
            let num, curMonth = true, dateStr;
            if (i < startOffset) { num = prevLast - startOffset + i + 1; curMonth = false; const m = currentMonth===0?11:currentMonth-1; dateStr = (currentMonth===0?currentYear-1:currentYear)+'-'+String(m+1).padStart(2,'0')+'-'+String(num).padStart(2,'0'); }
            else if (i >= startOffset + daysInMonth) { num = i - (startOffset+daysInMonth) + 1; curMonth = false; const m = currentMonth===11?0:currentMonth+1; dateStr = (currentMonth===11?currentYear+1:currentYear)+'-'+String(m+1).padStart(2,'0')+'-'+String(num).padStart(2,'0'); }
            else { num = i - startOffset + 1; dateStr = currentYear+'-'+String(currentMonth+1).padStart(2,'0')+'-'+String(num).padStart(2,'0'); }
            if (!curMonth) dia.classList.add('otro-mes');
            if (currentYear===today.getFullYear() && currentMonth===today.getMonth() && num===today.getDate() && curMonth) dia.classList.add('hoy');

            const header = document.createElement('div');
            header.style.cssText = 'display:flex;justify-content:space-between;margin-bottom:3px;font-weight:'+(curMonth?'bold':'normal')+';color:'+(curMonth?'#083CAE':'#adb5bd')+';';
            header.innerHTML = '<span>'+num+'</span>';
            dia.appendChild(header);

            const hitosDelDia = hitosData.filter(h => {
                if (!h.fecha_programada) return false;
                const inicio = h.fecha_programada.substring(0,10);
                const fin = h.fecha_fin ? h.fecha_fin.substring(0,10) : inicio;
                return dateStr >= inicio && dateStr <= fin;
            });

            if (hitosDelDia.length > 0) {
                const badge = document.createElement('span');
                badge.style.cssText = 'background:#083CAE;color:white;padding:1px 5px;border-radius:8px;font-size:9px;';
                badge.textContent = hitosDelDia.length;
                header.appendChild(badge);
            }

            hitosDelDia.forEach(h => {
                const ev = document.createElement('div');
                const esInicio = h.fecha_programada?.substring(0,10) === dateStr;
                const esFin = h.fecha_fin?.substring(0,10) === dateStr;
                const esIntermedio = !esInicio && !esFin && (h.fecha_fin && h.fecha_fin !== h.fecha_programada);
                ev.className = 'evento-hito ' + (h.estado || 'programado');
                if (esIntermedio) ev.classList.add('continuacion');
                if (esInicio && h.fecha_fin && h.fecha_fin !== h.fecha_programada) ev.innerHTML = '<b>▶ '+(h.proyecto?.codigo||'')+'</b> '+h.nombre;
                else if (esFin && h.fecha_fin !== h.fecha_programada) ev.innerHTML = '<b>■ '+(h.proyecto?.codigo||'')+'</b> '+h.nombre;
                else if (esIntermedio) ev.innerHTML = '<b>— '+(h.proyecto?.codigo||'')+'</b>';
                else ev.innerHTML = '<b>'+(h.proyecto?.codigo||'')+'</b> '+h.nombre;
                ev.title = h.nombre+' | '+(h.nombre_responsable||'')+' | '+(h.avance||0)+'% | '+(h.rango_fechas||'');
                ev.onclick = (e) => { e.stopPropagation(); editarHito(h); };
                dia.appendChild(ev);
            });
            grid.appendChild(dia);
        }
    }

    // ============================================
    // GANTT ESTILO ORIGINAL CON DATOS REALES
    // ============================================
    function cargarGantt() {
        const container = document.getElementById('ganttContainer');
        if (!container) return;
        if (hitosData.length === 0) { container.innerHTML = '<p style="text-align:center;color:#6c757d;padding:40px;">No hay hitos para mostrar</p>'; return; }

        // Determinar rango de fechas
        let fechaMin = null, fechaMax = null;
        hitosData.forEach(h => {
            if (h.fecha_programada) { const d = new Date(h.fecha_programada); if (!fechaMin || d < fechaMin) fechaMin = d; }
            const finRef = h.fecha_fin || h.fecha_programada;
            if (finRef) { const d = new Date(finRef); if (!fechaMax || d > fechaMax) fechaMax = d; }
        });
        if (!fechaMin) fechaMin = new Date();
        if (!fechaMax) fechaMax = new Date();
        fechaMax.setMonth(fechaMax.getMonth() + 2); // Extender 2 meses

        const diasTotales = Math.ceil((fechaMax - fechaMin) / (1000*60*60*24)) + 1;

        // Generar meses para el timeline
        const meses = [];
        let cursor = new Date(fechaMin.getFullYear(), fechaMin.getMonth(), 1);
        while (cursor <= fechaMax) {
            const diasEnMes = new Date(cursor.getFullYear(), cursor.getMonth()+1, 0).getDate();
            const left = ((cursor - fechaMin) / (1000*60*60*24)) / diasTotales * 100;
            const width = (diasEnMes / diasTotales) * 100;
            meses.push({
                label: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'][cursor.getMonth()],
                left: left,
                width: width
            });
            cursor.setMonth(cursor.getMonth() + 1);
        }

        // Agrupar por proyecto
        const grupos = {};
        hitosData.forEach(h => {
            const k = h.proyecto_id || 'sin';
            if (!grupos[k]) grupos[k] = { nombre: h.nombre_proyecto || 'Sin proyecto', codigo: h.proyecto?.codigo || '', hitos: [] };
            grupos[k].hitos.push(h);
        });

        let html = '<div style="min-width: 1200px;">';
        
        // Timeline de meses
        html += '<div style="display: flex; margin-bottom: 20px; border-bottom: 2px solid #083CAE; position: sticky; top: 0; background-color: white; z-index: 10;">';
        html += '<div style="width: 300px; min-width: 300px; padding: 10px; font-weight: 600; color: #083CAE;">Proyecto / Hito</div>';
        html += '<div style="flex: 1; display: flex; position: relative;">';
        meses.forEach(m => {
            html += '<div style="position: absolute; left: '+m.left+'%; width: '+m.width+'%; text-align: center; font-weight: 600; color: #083CAE; padding: 10px 0; border-left: 1px solid #dee2e6; font-size: 12px;">'+m.label+'</div>';
        });
        html += '</div></div>';

        // Proyectos e hitos
        for (const [id, grupo] of Object.entries(grupos)) {
            // Barra de progreso del proyecto completo
            const proyectoInicio = new Date(Math.min(...grupo.hitos.map(h => new Date(h.fecha_programada))));
            const proyectoFin = new Date(Math.max(...grupo.hitos.map(h => new Date(h.fecha_fin || h.fecha_programada))));
            const proyectoLeft = ((proyectoInicio - fechaMin) / (1000*60*60*24)) / diasTotales * 100;
            const proyectoWidth = ((proyectoFin - proyectoInicio) / (1000*60*60*24) + 1) / diasTotales * 100;
            const proyectoAvance = grupo.hitos.reduce((sum, h) => sum + (h.avance||0), 0) / grupo.hitos.length;

            // Color del proyecto basado en sus hitos
            const tieneRetrasados = grupo.hitos.some(h => h.estado === 'retrasado');
            const todosCompletados = grupo.hitos.every(h => h.estado === 'completado');
            const proyectoColor = todosCompletados ? '#28a745' : tieneRetrasados ? '#dc3545' : '#083CAE';
            const proyectoBg = todosCompletados ? '#d4edda' : tieneRetrasados ? '#f8d7da' : '#e8f0fe';

            html += '<div style="margin-bottom: 20px;">';
            
            // Encabezado del proyecto (clickeable para expandir/colapsar)
            html += '<div class="gantt-proyecto-header" onclick="toggleGanttProyecto(\'proy-'+id+'\')" style="display: flex; align-items: center; background-color: '+proyectoBg+'; padding: 12px; border-radius: 4px; margin-bottom: 5px;">';
            html += '<div style="width: 300px; font-weight: 600; color: '+proyectoColor+';">';
            html += '<i class="fas fa-chevron-down" id="icono-proy-'+id+'" style="margin-right: 10px;"></i>';
            html += grupo.codigo+' - '+grupo.nombre;
            html += '</div>';
            html += '<div style="flex: 1; display: flex; align-items: center; position: relative; height: 30px;">';
            html += '<div style="position: absolute; left: '+proyectoLeft+'%; width: '+Math.max(proyectoWidth,2)+'%; height: 20px; background-color: '+proyectoColor+'; border-radius: 4px; opacity: 0.2;"></div>';
            html += '<div style="position: absolute; left: '+proyectoLeft+'%; width: '+(proyectoWidth*proyectoAvance/100)+'%; height: 20px; background-color: '+proyectoColor+'; border-radius: 4px;"></div>';
            html += '<span style="position: absolute; left: '+(proyectoLeft+0.5)+'%; color: white; font-size: 11px; line-height: 20px; z-index: 1;">'+Math.round(proyectoAvance)+'%</span>';
            html += '</div></div>';

            // Hitos del proyecto
            html += '<div id="hitos-proy-'+id+'" style="margin-left: 30px;">';
            grupo.hitos.forEach(h => {
                const col = h.color_estado || '#6c757d';
                const ini = new Date(h.fecha_programada);
                const fin = new Date(h.fecha_fin || h.fecha_programada);
                const left = ((ini - fechaMin) / (1000*60*60*24)) / diasTotales * 100;
                const width = Math.max(((fin - ini) / (1000*60*60*24) + 1) / diasTotales * 100, 0.5);

                html += '<div style="display: flex; align-items: center; padding: 8px; border-bottom: 1px dashed #dee2e6;">';
                html += '<div style="width: 300px; font-size: 13px;">';
                html += '<i class="fas fa-circle" style="color: '+col+'; font-size: 8px; margin-right: 10px;"></i>'+h.nombre;
                html += '</div>';
                html += '<div style="flex: 1; display: flex; align-items: center; position: relative; height: 25px;">';
                html += '<div style="position: absolute; left: '+left+'%; width: '+width+'%; height: 15px; background-color: '+col+'; border-radius: 2px; opacity: 0.3;"></div>';
                html += '<div style="position: absolute; left: '+left+'%; width: '+(width*(h.avance||0)/100)+'%; height: 15px; background-color: '+col+'; border-radius: 2px;"></div>';
                if ((h.avance||0) > 10) {
                    html += '<span style="position: absolute; left: '+(left+0.3)+'%; color: white; font-size: 9px; line-height: 15px; text-shadow: 0 1px 1px rgba(0,0,0,0.3);">'+(h.avance||0)+'%</span>';
                }
                html += '</div></div>';
            });
            html += '</div></div>';
        }

        html += '</div>';

        // Leyenda
        html += '<div style="display: flex; gap: 20px; margin-top: 20px; padding: 10px; background-color: #f8f9fa; border-radius: 8px; flex-wrap: wrap;">';
        html += '<span style="font-size: 12px;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #083CAE; border-radius: 2px; margin-right: 5px; opacity: 0.2;"></span> Progreso planeado</span>';
        html += '<span style="font-size: 12px;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #083CAE; border-radius: 2px; margin-right: 5px;"></span> Progreso real</span>';
        html += '<span style="font-size: 12px;"><span style="display: inline-block; width: 8px; height: 8px; background-color: #ffc107; border-radius: 50%; margin-right: 5px;"></span> Hito</span>';
        html += '</div>';

        container.innerHTML = html;
    }

    // Toggle para Gantt
    window.toggleGanttProyecto = function(id) {
        const hitosDiv = document.getElementById('hitos-'+id);
        const icono = document.getElementById('icono-'+id);
        if (hitosDiv && icono) {
            if (hitosDiv.style.display === 'none') { hitosDiv.style.display = 'block'; icono.className = 'fas fa-chevron-down'; }
            else { hitosDiv.style.display = 'none'; icono.className = 'fas fa-chevron-right'; }
        }
    };

    function cargarLista() {
        const tbody = document.getElementById('tablaHitosBody');
        if (!hitosData.length) { tbody.innerHTML = '<tr><td colspan="9" style="text-align:center;padding:40px;">No hay hitos</td></tr>'; return; }
        tbody.innerHTML = hitosData.map(h => `<tr style="border-bottom:1px solid #dee2e6;">
            <td style="padding:10px;"><b>${h.proyecto?.codigo||''}</b><br><small>${h.proyecto?.nombre||''}</small></td>
            <td style="padding:10px;">${h.nombre}</td><td style="padding:10px;">${h.nombre_responsable||'Sin asignar'}</td>
            <td style="padding:10px;">${h.fecha_programada||'-'}</td><td style="padding:10px;">${h.fecha_fin||h.fecha_programada||'-'}</td>
            <td style="padding:10px;">${h.dias_duracion||1} día(s)</td>
            <td style="padding:10px;"><span style="padding:3px 8px;border-radius:4px;font-size:11px;background:${h.color_estado};color:white;">${h.estado}</span></td>
            <td style="padding:10px;">${h.avance||0}%</td>
            <td style="padding:10px;text-align:center;">
                <i class="fas fa-edit" style="color:#083CAE;cursor:pointer;" onclick='editarHito(${JSON.stringify(h)})'></i>
                <i class="fas fa-trash" style="color:#dc3545;cursor:pointer;margin-left:8px;" onclick='eliminarHito(${h.id})'></i>
            </td></tr>`).join('');
    }

    // Modal
    document.getElementById('btnNuevoHito').addEventListener('click', () => {
        document.getElementById('modalTitulo').textContent = 'Nuevo Hito';
        document.getElementById('modalHitoId').value = '';
        document.getElementById('formHito').reset();
        document.getElementById('modalAvance').value = 0; document.getElementById('modalAvanceSlider').value = 0;
        document.getElementById('avanceValor').textContent = '0%';
        document.getElementById('modalEstado').value = 'programado';
        document.getElementById('modalPrioridad').value = 'media';
        document.getElementById('modalCritico').checked = false;
        document.getElementById('modalHito').style.display = 'flex';
    });

    document.getElementById('btnCerrarModal').addEventListener('click', () => document.getElementById('modalHito').style.display = 'none');
    document.getElementById('btnCancelarHito').addEventListener('click', () => document.getElementById('modalHito').style.display = 'none');
    window.addEventListener('click', (e) => { if (e.target === document.getElementById('modalHito')) document.getElementById('modalHito').style.display = 'none'; });

    window.editarHito = function(h) {
        document.getElementById('modalTitulo').textContent = 'Editar Hito';
        document.getElementById('modalHitoId').value = h.id;
        document.getElementById('modalProyecto').value = h.proyecto_id;
        document.getElementById('modalNombre').value = h.nombre;
        document.getElementById('modalFecha').value = h.fecha_programada?.substring(0,10) || '';
        document.getElementById('modalFechaFin').value = h.fecha_fin?.substring(0,10) || '';
        document.getElementById('modalEstado').value = h.estado;
        document.getElementById('modalResponsable').value = h.responsable_id || '';
        document.getElementById('modalPrioridad').value = h.prioridad || 'media';
        document.getElementById('modalAvance').value = h.avance||0; document.getElementById('modalAvanceSlider').value = h.avance||0;
        document.getElementById('avanceValor').textContent = (h.avance||0)+'%';
        document.getElementById('modalCritico').checked = h.es_critico||false;
        document.getElementById('modalDescripcion').value = h.descripcion||'';
        document.getElementById('modalHito').style.display = 'flex';
    };

    window.eliminarHito = async function(id) {
        if (!confirm('¿Está seguro de eliminar este hito?')) return;
        await fetch('/proyectos/hitos/'+id, {method:'DELETE', headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content}});
        cargarHitos();
    };

    document.getElementById('formHito').addEventListener('submit', async function(e) {
        e.preventDefault();
        const id = document.getElementById('modalHitoId').value;
        const payload = {
            proyecto_id: document.getElementById('modalProyecto').value,
            nombre: document.getElementById('modalNombre').value,
            fecha_programada: document.getElementById('modalFecha').value,
            fecha_fin: document.getElementById('modalFechaFin').value || null,
            estado: document.getElementById('modalEstado').value,
            responsable_id: document.getElementById('modalResponsable').value || null,
            prioridad: document.getElementById('modalPrioridad').value,
            avance: parseInt(document.getElementById('modalAvance').value)||0,
            es_critico: document.getElementById('modalCritico').checked,
            descripcion: document.getElementById('modalDescripcion').value
        };
        if (!payload.proyecto_id || !payload.nombre || !payload.fecha_programada) { alert('Complete los campos requeridos'); return; }
        const res = await fetch(id?'/proyectos/hitos/'+id:'/proyectos/hitos', {
            method: id?'PUT':'POST',
            headers: {'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content,'Accept':'application/json'},
            body: JSON.stringify(payload)
        });
        const data = await res.json();
        if (data.success) { document.getElementById('modalHito').style.display = 'none'; cargarHitos(); }
        else { alert(data.message||'Error al guardar'); }
    });

    document.getElementById('btnMesAnterior').addEventListener('click', () => { currentMonth--; if(currentMonth<0){currentMonth=11;currentYear--;} generarCalendario(); });
    document.getElementById('btnMesSiguiente').addEventListener('click', () => { currentMonth++; if(currentMonth>11){currentMonth=0;currentYear++;} generarCalendario(); });
    document.getElementById('btnHoy').addEventListener('click', () => { currentMonth=new Date().getMonth(); currentYear=new Date().getFullYear(); generarCalendario(); });

    document.getElementById('selectorProyecto').addEventListener('change', cargarHitos);
    document.getElementById('fechaInicio').addEventListener('change', cargarHitos);
    document.getElementById('fechaFin').addEventListener('change', cargarHitos);

    document.querySelectorAll('.filtro-hito').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filtro-hito').forEach(b => { b.classList.remove('active'); b.style.background='white'; b.style.color='#495057'; });
            this.classList.add('active'); this.style.background='#083CAE'; this.style.color='white';
            const f = this.dataset.filtro;
            document.querySelectorAll('#tablaHitosBody tr').forEach(row => {
                const e = row.querySelector('td:nth-child(7) span')?.textContent?.toLowerCase()||'';
                row.style.display = f==='todos' ? '' : (e.includes(f.replace('_',' '))?'':'none');
            });
        });
    });

    cargarHitos();
});
</script>
@endsection