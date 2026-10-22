@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="card">
            <div class="card-header" style="background-color:#f4f6f9; border-bottom:2px solid #083CAE; padding:15px 20px;">
                <h2 style="color:#083CAE; font-weight:bold; margin:0; font-size:24px; text-align:center;">
                    Detalle del Movimiento #{{ $movimiento->id }}
                </h2>
            </div>
            <div class="card-body p-4">
                <table class="table table-bordered">
                    <tr><th style="width:220px;">Fecha</th><td>{{ $movimiento->fecha }}</td></tr>
                    <tr><th>Folio</th><td>{{ $movimiento->folio ?? '-' }}</td></tr>
                    <tr><th>Referencia</th><td>{{ $movimiento->referencia ?? '-' }}</td></tr>
                    <tr><th>Ref. Bancaria</th><td>{{ $movimiento->ref_bancaria ?? '-' }}</td></tr>
                    <tr><th>Origen</th><td>{{ $movimiento->origen ?? '-' }}</td></tr>
                    <tr><th>Descripción</th><td>{{ $movimiento->descripcion ?? '-' }}</td></tr>
                    <tr><th>Cuenta</th><td>{{ $movimiento->cuentaBancaria->banco->nombre ?? '-' }} - {{ $movimiento->cuentaBancaria->numero_cuenta ?? '-' }}</td></tr>
                    <tr><th>Moneda</th><td>{{ $movimiento->cuentaBancaria->moneda->nombre ?? '-' }}</td></tr>
                    <tr><th>Proyecto</th><td>{{ $movimiento->proyecto->nombre ?? '-' }}</td></tr>
                    <tr><th>Tipo Ingreso</th><td>{{ $movimiento->tipoIngreso->nombre ?? '-' }}</td></tr>
                    <tr><th>Tipo Egreso</th><td>{{ $movimiento->tipoEgreso->nombre ?? '-' }}</td></tr>
                    <tr><th>Categoría Gasto</th><td>{{ $movimiento->categoriaGasto->nombre ?? '-' }}</td></tr>
                    <tr><th>Método Pago</th><td>{{ $movimiento->metodoPago->nombre ?? '-' }}</td></tr>
                    <tr><th>Cargos</th><td style="text-align:right;">${{ number_format($movimiento->cargos ?? 0, 2) }}</td></tr>
                    <tr><th>Abonos</th><td style="text-align:right;">${{ number_format($movimiento->abonos ?? 0, 2) }}</td></tr>
                    <tr><th>Saldo Final</th><td style="text-align:right;">${{ number_format($movimiento->saldo_final ?? 0, 2) }}</td></tr>
                </table>

                <div style="display:flex; gap:10px; margin-top:15px;">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Regresar</a>
                    <a href="{{ route('movimientos.pdf', $movimiento->id) }}" class="btn btn-danger" target="_blank">
                        <i class="fas fa-file-pdf"></i> Descargar PDF
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection