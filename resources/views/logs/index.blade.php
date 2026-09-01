{{-- resources/views/logs/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3>Logs del Sistema</h3>
            <div class="float-right">
                <a href="{{ route('logs.clear') }}" class="btn btn-danger btn-sm" onclick="return confirm('¿Limpiar logs?')">
                    Limpiar Logs
                </a>
                <a href="{{ route('logs.download') }}" class="btn btn-primary btn-sm">
                    Descargar
                </a>
            </div>
        </div>
        <div class="card-body" style="max-height: 600px; overflow-y: auto; background: #1e1e1e; color: #d4d4d4; padding: 15px; font-family: monospace; font-size: 12px;">
            {!! $logs !!}
        </div>
    </div>
</div>
@endsection