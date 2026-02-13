@extends('layouts.navigation')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Cabecera -->
        <div class="mb-6 flex justify-between items-center border-b border-gray-200 pb-4">
            <div class="flex items-center space-x-3">
                <i class="fas fa-file-invoice text-2xl text-gray-600"></i>
                <h1 class="text-2xl font-light tracking-wide text-gray-800">Notas de Crédito</h1>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm bg-gray-100 px-4 py-2 rounded-full flex items-center text-gray-700">
                    <i class="fas fa-calendar mr-2 text-gray-500"></i>Diciembre 2025
                </span>
                <button class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow flex items-center">
                    <i class="fas fa-plus-circle mr-2"></i>Nueva nota de crédito
                </button>
            </div>
        </div>

        <!-- Tarjetas KPI -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-5 mb-8">
            <div class="bg-white p-5 rounded border border-gray-200 flex justify-between items-center hover:border-gray-300 transition">
                <div>
                    <p class="text-xs uppercase tracking-wider text-gray-500 font-medium">Notas de Crédito</p>
                    <p class="text-3xl font-bold text-gray-800">1</p>
                </div>
                <div class="bg-gray-100 p-3 rounded">
                    <i class="fas fa-file-invoice text-gray-600 text-xl"></i>
                </div>
            </div>
            <div class="bg-white p-5 rounded border border-gray-200 flex justify-between items-center hover:border-gray-300 transition">
                <div>
                    <p class="text-xs uppercase tracking-wider text-gray-500 font-medium">Activas</p>
                    <p class="text-3xl font-bold text-gray-800">0</p>
                </div>
                <div class="bg-gray-100 p-3 rounded">
                    <i class="fas fa-clock text-gray-600 text-xl"></i>
                </div>
            </div>
            <div class="bg-white p-5 rounded border border-gray-200 flex justify-between items-center hover:border-gray-300 transition">
                <div>
                    <p class="text-xs uppercase tracking-wider text-gray-500 font-medium">Pagadas</p>
                    <p class="text-3xl font-bold text-gray-800">0</p>
                </div>
                <div class="bg-gray-100 p-3 rounded">
                    <i class="fas fa-check-circle text-gray-600 text-xl"></i>
                </div>
            </div>
            <div class="bg-white p-5 rounded border border-gray-200 flex justify-between items-center hover:border-gray-300 transition">
                <div>
                    <p class="text-xs uppercase tracking-wider text-gray-500 font-medium">Timbrado</p>
                    <p class="text-3xl font-bold text-gray-800">0</p>
                </div>
                <div class="bg-gray-100 p-3 rounded">
                    <i class="fas fa-stamp text-gray-600 text-xl"></i>
                </div>
            </div>
            <div class="bg-white p-5 rounded border border-gray-200 flex justify-between items-center hover:border-gray-300 transition">
                <div>
                    <p class="text-xs uppercase tracking-wider text-gray-500 font-medium">Importe total</p>
                    <p class="text-xl font-bold text-gray-800">$5,000</p>
                </div>
                <div class="bg-gray-100 p-3 rounded">
                    <i class="fas fa-dollar-sign text-gray-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Barra de herramientas estilo Excel -->
        <div class="bg-white border border-gray-200 rounded-t-md mb-0 p-2 flex flex-wrap items-center justify-between">
            <div class="flex items-center space-x-2">
                <span class="text-xs text-gray-600 bg-gray-50 px-3 py-1.5 border border-gray-200 rounded">
                    <i class="fas fa-layer-group mr-1"></i>Arrastra columna para agrupar
                </span>
                <span class="text-xs text-gray-500 px-2">|</span>
                <button class="text-xs text-gray-600 hover:bg-gray-100 px-3 py-1.5 rounded flex items-center">
                    <i class="fas fa-table mr-1"></i>Vista
                </button>
            </div>
            <div class="flex items-center space-x-2">
                <div class="relative">
                    <i class="fas fa-search absolute left-2.5 top-2 text-gray-400 text-xs"></i>
                    <input type="text" placeholder="Buscar..." class="pl-7 pr-3 py-1.5 border border-gray-200 rounded text-xs focus:ring-1 focus:ring-blue-200 focus:border-blue-400 outline-none">
                </div>
                <button class="border border-gray-200 px-3 py-1.5 rounded text-xs hover:bg-gray-50 flex items-center">
                    <i class="fas fa-download mr-1"></i>Exportar
                </button>
                <button class="border border-gray-200 px-3 py-1.5 rounded text-xs hover:bg-gray-50 flex items-center">
                    <i class="fas fa-filter mr-1"></i>Filtros
                </button>
            </div>
        </div>

        <!-- Tabla estilo Excel -->
        <div class="bg-white border border-gray-200 border-t-0 rounded-b-md overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-xs">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-200">Estatus</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-200">Fecha</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-200">Folio</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-200">Serie</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-200">Cliente</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-200">RFC</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-200">Moneda</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-200">Subtotal</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-200">IVA</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-200">IEPS</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-200">Descto</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-200">Total</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-200">Relación</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-200">UUID</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-200">Método</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Nota de Crédito - Activo -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 border-r border-gray-200">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Activo</span>
                        </td>
                        <td class="px-3 py-2 border-r border-gray-200">12/8/2025</td>
                        <td class="px-3 py-2 border-r border-gray-200 font-medium">99</td>
                        <td class="px-3 py-2 border-r border-gray-200">
                            <span class="bg-gray-100 text-gray-700 px-1.5 py-0.5 rounded text-xs border border-gray-200">E</span>
                        </td>
                        <td class="px-3 py-2 border-r border-gray-200">Cartones del Norte Demo</td>
                        <td class="px-3 py-2 border-r border-gray-200 text-gray-500">XAXX010101000</td>
                        <td class="px-3 py-2 border-r border-gray-200">MXN</td>
                        <td class="px-3 py-2 border-r border-gray-200">$5,000</td>
                        <td class="px-3 py-2 border-r border-gray-200">$0</td>
                        <td class="px-3 py-2 border-r border-gray-200">$0</td>
                        <td class="px-3 py-2 border-r border-gray-200">$0</td>
                        <td class="px-3 py-2 border-r border-gray-200 font-medium">$5,000</td>
                        <td class="px-3 py-2 border-r border-gray-200">
                            <span class="bg-blue-50 text-blue-700 px-1.5 py-0.5 rounded text-xs border border-blue-200">G02</span>
                        </td>
                        <td class="px-3 py-2 border-r border-gray-200 font-mono text-gray-600">99</td>
                        <td class="px-3 py-2 border-r border-gray-200">
                            <span class="bg-purple-50 text-purple-700 px-1.5 py-0.5 rounded text-xs border border-purple-200">PUE</span>
                        </td>
                        <td class="px-3 py-2">
                            <div class="flex items-center justify-center space-x-1.5">
                                <button class="text-blue-600 hover:text-blue-800 p-1" title="Editar">
                                    <i class="fas fa-edit text-sm"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-800 p-1" title="Eliminar">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                                <button class="text-gray-600 hover:text-gray-800 p-1" title="Documentar">
                                    <i class="fas fa-file-alt text-sm"></i>
                                </button>
                                <button class="text-green-600 hover:text-green-800 p-1" title="PDF">
                                    <i class="fas fa-file-pdf text-sm"></i>
                                </button>
                                <button class="text-indigo-600 hover:text-indigo-800 p-1" title="XML">
                                    <i class="fas fa-file-code text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <!-- Fila vacía para mensaje cuando no hay más registros -->
                    <tr class="bg-gray-50/50">
                        <td colspan="16" class="px-3 py-8 text-center text-gray-500 text-sm">
                            <i class="fas fa-inbox text-gray-300 text-3xl mb-2 block"></i>
                            No hay más notas de crédito
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <!-- Barra inferior estilo Excel -->
            <div class="bg-gray-50 px-4 py-2 border-t border-gray-200 flex flex-wrap items-center justify-between text-xs">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="text-gray-700"><span class="font-semibold">Cantidad:</span> 1 nota de crédito</span>
                    <span class="text-gray-700"><span class="font-semibold">Subtotal:</span> $5,000</span>
                    <span class="text-gray-700"><span class="font-semibold">IVA:</span> $0</span>
                    <span class="text-gray-700"><span class="font-semibold">IEPS:</span> $0</span>
                    <span class="text-gray-700"><span class="font-semibold">Descuento:</span> $0</span>
                    <span class="text-gray-900 font-bold"><span class="font-semibold">Total:</span> $5,000</span>
                </div>
                <div class="flex items-center space-x-2 mt-1 sm:mt-0">
                    <span class="text-gray-600">1-1 de 1</span>
                    <button class="border border-gray-300 px-2 py-1 rounded text-gray-600 hover:bg-white disabled:opacity-50" disabled>
                        <i class="fas fa-chevron-left text-xs"></i>
                    </button>
                    <button class="border border-gray-300 px-2 py-1 rounded text-gray-600 hover:bg-white disabled:opacity-50" disabled>
                        <i class="fas fa-chevron-right text-xs"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sección de detalles rápidos -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <div class="bg-white rounded border border-gray-200 p-4">
                <h3 class="font-medium text-gray-700 mb-2 flex items-center text-sm">
                    <i class="fas fa-info-circle mr-2 text-gray-500"></i>Notas de crédito por cliente
                </h3>
                <div class="space-y-1.5 text-xs">
                    <div class="flex justify-between items-center py-1 border-b border-gray-100">
                        <span class="text-gray-700">Cartones del Norte Demo</span>
                        <span class="font-semibold text-gray-900">$5,000</span>
                    </div>
                    <div class="flex justify-between items-center py-1 text-gray-500">
                        <span>Total emitido</span>
                        <span class="font-semibold">$5,000</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded border border-gray-200 p-4">
                <h3 class="font-medium text-gray-700 mb-2 flex items-center text-sm">
                    <i class="fas fa-chart-pie mr-2 text-gray-500"></i>Resumen
                </h3>
                <div class="text-xs text-gray-600">
                    <div class="flex justify-between py-1">
                        <span>Notas de crédito emitidas:</span>
                        <span class="font-semibold">1</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span>Monto total:</span>
                        <span class="font-semibold">$5,000</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span>Porcentaje de facturación:</span>
                        <span class="font-semibold">0.8%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection