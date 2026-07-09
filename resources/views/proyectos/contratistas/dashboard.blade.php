{{-- resources/views/proyectos/contratistas/dashboard.blade.php --}}
@extends('layouts.navigation')

@section('title', 'Dashboard de Contratistas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2><i class="fas fa-chart-pie text-primary"></i> Dashboard de Contratistas</h2>
                <a href="{{ route('proyectos.contratistas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>

    <!-- KPIs -->
    <div class="row" id="kpisContainer">
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="totalContratistas">0</h3>
                    <p>Total Contratistas</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3 id="contratistasActivos">0</h3>
                    <p>Activos</p>
                </div>
                <div class="icon"><i class="fas fa-check-circle"></i></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3 id="totalProyectos">0</h3>
                    <p>Proyectos Activos</p>
                </div>
                <div class="icon"><i class="fas fa-project-diagram"></i></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3 id="presupuestoTotal">$0</h3>
                    <p>Presupuesto Total</p>
                </div>
                <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
            </div>
        </div>
    </div>

    <!-- Gráficas -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Distribución por Especialidad</h3>
                </div>
                <div class="card-body">
                    <canvas id="graficaEspecialidades" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gastos por Tipo</h3>
                </div>
                <div class="card-body">
                    <canvas id="graficaGastosTipo" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Top Contratistas</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tablaTopContratistas">
                            <thead>
                                <tr>
                                    <th>Contratista</th>
                                    <th>Especialidad</th>
                                    <th>Gasto Total</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Alertas Recientes</h3>
                </div>
                <div class="card-body">
                    <div id="listaAlertas">
                        <p class="text-muted text-center">Cargando alertas...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .small-box { border-radius: 10px; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    cargarDashboard();
});

function cargarDashboard() {
    $.get('/api/contratistas/dashboard', function(data) {
        // Actualizar KPIs
        $('#totalContratistas').text(data.kpis.total_contratistas);
        $('#contratistasActivos').text(data.kpis.activos);
        $('#totalProyectos').text(data.kpis.total_proyectos);
        $('#presupuestoTotal').text('$' + Number(data.kpis.presupuesto_total).toLocaleString());

        // Gráfica de especialidades
        var ctx1 = document.getElementById('graficaEspecialidades').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: data.especialidades.map(item => item.especialidad),
                datasets: [{
                    label: 'Contratistas',
                    data: data.especialidades.map(item => item.total),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Gráfica de gastos por tipo
        var ctx2 = document.getElementById('graficaGastosTipo').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: data.gastos_tipo.map(item => item.tipo_gasto),
                datasets: [{
                    data: data.gastos_tipo.map(item => item.total),
                    backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6c757d']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Top contratistas
        var html = '';
        data.top_contratistas.forEach(function(item) {
            html += `
                <tr>
                    <td><strong>${item.nombre_comercial}</strong></td>
                    <td><span class="badge badge-info">${item.especialidad || 'N/A'}</span></td>
                    <td>$${Number(item.total_gasto || 0).toLocaleString()}</td>
                </tr>
            `;
        });
        $('#tablaTopContratistas tbody').html(html || '<tr><td colspan="3" class="text-center">No hay datos</td></tr>');

        // Alertas
        cargarAlertas();
    });
}

function cargarAlertas() {
    $.get('/api/alertas?leida=0&per_page=5', function(data) {
        var html = '';
        if (data.data.length === 0) {
            html = '<p class="text-muted text-center">No hay alertas pendientes</p>';
        } else {
            data.data.forEach(function(alerta) {
                var badge = alerta.nivel === 'danger' ? 'danger' : (alerta.nivel === 'warning' ? 'warning' : 'info');
                html += `
                    <div class="alert alert-${badge} alert-dismissible fade show" role="alert">
                        <h6><i class="fas fa-bell"></i> ${alerta.titulo}</h6>
                        <p class="mb-0 small">${alerta.descripcion}</p>
                        <button type="button" class="close" onclick="marcarAlertaLeida(${alerta.id})">
                            <span>&times;</span>
                        </button>
                    </div>
                `;
            });
        }
        $('#listaAlertas').html(html);
    });
}

function marcarAlertaLeida(id) {
    $.post('/api/alertas/' + id + '/leer', {
        _token: $('meta[name="csrf-token"]').attr('content')
    }, function() {
        cargarAlertas();
    });
}
</script>
@endpush