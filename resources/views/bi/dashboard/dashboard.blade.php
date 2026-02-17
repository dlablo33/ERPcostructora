@extends('layouts.navigation')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-primary fw-bold m-0">Tendencia de Ventas</h2>

        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-success btn-sm">
                <i class="bi bi-arrow-clockwise"></i>
            </button>

            <input type="month" class="form-control form-control-sm" value="2026-02" style="width:140px;">
        </div>
    </div>

    <hr class="border-primary">

    {{-- Tarjetas --}}
    <div class="row g-3">

        {{-- FILA 1 --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-primary text-center h-100">
                <div class="card-body">
                    <h6 class="text-muted">Venta al día</h6>
                    <h5 class="fw-bold text-primary">$248,602.00</h5>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-primary text-center h-100">
                <div class="card-body">
                    <h6 class="text-muted">Presupuesto al día</h6>
                    <h5 class="fw-bold text-primary">$0.00</h5>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-primary text-center h-100">
                <div class="card-body">
                    <h6 class="text-muted">Diferencia</h6>
                    <h5 class="fw-bold text-primary">$248,602.00</h5>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-primary text-center h-100">
                <div class="card-body">
                    <h6 class="text-muted">Porcentaje de alcance</h6>
                    <h5 class="fw-bold text-primary">100.00%</h5>
                </div>
            </div>
        </div>

        {{-- FILA 2 --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-primary text-center h-100">
                <div class="card-body">
                    <h6 class="text-muted">Tendencia mensual</h6>
                    <h5 class="fw-bold text-primary">$464,057.07</h5>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-primary text-center h-100">
                <div class="card-body">
                    <h6 class="text-muted">Presupuesto mensual</h6>
                    <h5 class="fw-bold text-primary">$0.00</h5>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-primary text-center h-100">
                <div class="card-body">
                    <h6 class="text-muted">Diferencia</h6>
                    <h5 class="fw-bold text-primary">$0.00</h5>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-primary text-center h-100">
                <div class="card-body">
                    <h6 class="text-muted">Porcentaje de alcance</h6>
                    <h5 class="fw-bold text-primary">0.00%</h5>
                </div>
            </div>
        </div>

        {{-- FILA 3 --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-primary text-center h-100">
                <div class="card-body">
                    <h6 class="text-muted">Venta al día FORANEO</h6>
                    <h5 class="fw-bold text-primary">$248,602.00</h5>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-primary text-center h-100">
                <div class="card-body">
                    <h6 class="text-muted">Presupuesto al día FORANEO</h6>
                    <h5 class="fw-bold text-primary">$0.00</h5>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-primary text-center h-100">
                <div class="card-body">
                    <h6 class="text-muted">Diferencia</h6>
                    <h5 class="fw-bold text-primary">$0.00</h5>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-primary text-center h-100">
                <div class="card-body">
                    <h6 class="text-muted">Porcentaje de alcance</h6>
                    <h5 class="fw-bold text-primary">0.00%</h5>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
