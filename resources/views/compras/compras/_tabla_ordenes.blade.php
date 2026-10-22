{{-- resources/views/compras/compras/_tabla_ordenes.blade.php --}}
{{-- Contiene: barra de filtros activos + contador + tabla --}}

{{-- Barra de filtros activos --}}
<div data-filtros-activos>
    @if(request()->hasAny(['folio', 'proyecto', 'estatus_cotizacion']))
        <div style="margin-bottom: 15px; padding: 8px 12px; background-color: #e7f1ff; border-left: 3px solid var(--color-primary); border-radius: 4px; font-size: 12px; display: flex; align-items: center; justify-content: space-between;">
            <span>
                <i class="fas fa-filter"></i>
                <strong>Filtros activos:</strong>
                @if(request('folio'))
                    <span class="badge" style="background:var(--color-primary);color:#fff;">Folio: {{ request('folio') }}</span>
                @endif
                @if(request('proyecto'))
                    <span class="badge" style="background:var(--color-primary);color:#fff;">Proyecto</span>
                @endif
                @if(request('estatus_cotizacion'))
                    <span class="badge" style="background:var(--color-primary);color:#fff;">Estatus: {{ request('estatus_cotizacion') }}</span>
                @endif
            </span>
            <span><strong>{{ $requisiciones->count() }}</strong> resultado(s)</span>
        </div>
    @endif
</div>

{{-- Tabla --}}
<div class="table-responsive" data-tabla-ordenes style="overflow-x: auto; border: 1px solid #dee2e6; border-radius: 4px;">
    <table class="table table-bordered" style="width: 100%; font-size: 12px; margin-bottom: 0;">
        <thead style="background-color: var(--color-primary); color: white;">
            <tr>
                <th style="padding: 10px;">Folio</th>
                <th style="padding: 10px;">Fecha</th>
                <th style="padding: 10px;">Proyecto</th>
                <th style="padding: 10px;">Solicitante</th>
                <th style="padding: 10px;">Artículos</th>
                <th style="padding: 10px;">Cotizados</th>
                <th style="padding: 10px;">Estatus</th>
                <th style="padding: 10px; text-align: center;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requisiciones as $req)
            @php
                $totalArticulos = $req->articulos->count();
                $cotizados = $req->articulos->where('cotizada', true)->count();
                $porcentaje = $totalArticulos > 0 ? round(($cotizados / $totalArticulos) * 100) : 0;
            @endphp
            <tr>
                <td style="padding: 10px;"><strong>{{ $req->folio }}</strong></td>
                <td style="padding: 10px;">{{ $req->fecha_requerimiento ? date('d/m/Y', strtotime($req->fecha_requerimiento)) : '-' }}</td>
                <td style="padding: 10px;">{{ $req->proyecto->nombre ?? '-' }}</td>
                <td style="padding: 10px;">{{ $req->solicitante }}</td>
                <td style="padding: 10px; text-align: center;">{{ $totalArticulos }}</td>
                <td style="padding: 10px;">
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <span>{{ $cotizados }}/{{ $totalArticulos }}</span>
                        <div style="flex: 1; background-color: #e9ecef; border-radius: 4px; height: 6px;">
                            <div style="width: {{ $porcentaje }}%; background-color: #28a745; border-radius: 4px; height: 6px;"></div>
                        </div>
                    </div>
                </td>
                <td style="padding: 10px;">
                    @if($req->estatus_cotizacion == 'Pendiente' || !$req->estatus_cotizacion)
                        <span class="badge" style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 4px;">Pendiente</span>
                    @elseif($req->estatus_cotizacion == 'En_Cotizacion')
                        <span class="badge" style="background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 4px;">En Cotización</span>
                    @endif
                </td>
                <td style="padding: 10px; text-align: center;">
                    <div style="display: flex; flex-direction: column; gap: 5px;">
                        <button class="btn-ver-articulos btn-sm"
                                data-id="{{ $req->id }}"
                                data-folio="{{ $req->folio }}"
                                style="background-color: var(--color-primary); color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 11px;">
                            <i class="fas fa-list"></i> Ver Artículos
                        </button>
                    </div>
                </td>
             </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 40px;">
                    <i class="fas fa-inbox" style="font-size: 48px; color: #ccc;"></i>
                    <p style="margin-top: 10px;">No hay requisiciones autorizadas pendientes de cotizar</p>
                    @if(request()->hasAny(['folio', 'proyecto', 'estatus_cotizacion']))
                        <button type="button"
                                class="btn-limpiar-empty btn btn-primary btn-sm"
                                style="background-color: var(--color-primary); color: white; border: none; padding: 8px 16px; border-radius: 4px; margin-top: 10px; cursor: pointer;">
                            <i class="fas fa-eraser"></i> Limpiar filtros
                        </button>
                    @endif
                </td>
             </tr>
            @endforelse
        </tbody>
    </table>
</div>