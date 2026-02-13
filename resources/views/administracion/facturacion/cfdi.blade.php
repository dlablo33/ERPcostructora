@extends('layouts.navigation')

@section('content')
<div class="py-6">
    <div class="max-w-[98%] mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Cabecera -->
        <div class="mb-6 flex justify-between items-center border-b border-gray-200 pb-4">
            <div class="flex items-center space-x-3">
                <i class="fas fa-file-invoice-dollar text-2xl text-gray-600"></i>
                <h1 class="text-2xl font-light tracking-wide text-gray-800">Facturación Electrónica (CFDI 4.0)</h1>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm bg-gray-100 px-4 py-2 rounded-full flex items-center text-gray-700">
                    <i class="fas fa-calendar mr-2 text-gray-500"></i>Febrero 2026
                </span>
                <button class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow flex items-center">
                    <i class="fas fa-plus-circle mr-2"></i>Nueva Factura CFDI
                </button>
                <button class="bg-purple-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-purple-700 transition shadow flex items-center">
                    <i class="fas fa-file-import mr-2"></i>Importar XML
                </button>
            </div>
        </div>

        <!-- Tarjetas KPI -->
        <div class="grid grid-cols-1 md:grid-cols-7 gap-4 mb-8">
            <div class="bg-white p-5 rounded border border-gray-200 flex justify-between items-center hover:border-gray-300 transition">
                <div>
                    <p class="text-xs uppercase tracking-wider text-gray-500 font-medium">Total Facturas</p>
                    <p class="text-3xl font-bold text-gray-800">12</p>
                </div>
                <div class="bg-gray-100 p-3 rounded">
                    <i class="fas fa-file-invoice text-gray-600 text-xl"></i>
                </div>
            </div>
            <div class="bg-white p-5 rounded border border-gray-200 flex justify-between items-center hover:border-gray-300 transition">
                <div>
                    <p class="text-xs uppercase tracking-wider text-gray-500 font-medium">Activas</p>
                    <p class="text-3xl font-bold text-yellow-600">10</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
            <div class="bg-white p-5 rounded border border-gray-200 flex justify-between items-center hover:border-gray-300 transition">
                <div>
                    <p class="text-xs uppercase tracking-wider text-gray-500 font-medium">Pagadas</p>
                    <p class="text-3xl font-bold text-green-600">1</p>
                </div>
                <div class="bg-green-100 p-3 rounded">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="bg-white p-5 rounded border border-gray-200 flex justify-between items-center hover:border-gray-300 transition">
                <div>
                    <p class="text-xs uppercase tracking-wider text-gray-500 font-medium">Timbradas</p>
                    <p class="text-3xl font-bold text-blue-600">8</p>
                </div>
                <div class="bg-blue-100 p-3 rounded">
                    <i class="fas fa-stamp text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="bg-white p-5 rounded border border-gray-200 flex justify-between items-center hover:border-gray-300 transition">
                <div>
                    <p class="text-xs uppercase tracking-wider text-gray-500 font-medium">Canceladas</p>
                    <p class="text-3xl font-bold text-red-600">1</p>
                </div>
                <div class="bg-red-100 p-3 rounded">
                    <i class="fas fa-ban text-red-600 text-xl"></i>
                </div>
            </div>
            <div class="bg-white p-5 rounded border border-gray-200 flex justify-between items-center hover:border-gray-300 transition">
                <div>
                    <p class="text-xs uppercase tracking-wider text-gray-500 font-medium">Por Vencer</p>
                    <p class="text-3xl font-bold text-orange-600">3</p>
                </div>
                <div class="bg-orange-100 p-3 rounded">
                    <i class="fas fa-exclamation-triangle text-orange-600 text-xl"></i>
                </div>
            </div>
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-5 rounded border border-blue-200 flex justify-between items-center">
                <div>
                    <p class="text-xs uppercase tracking-wider text-blue-700 font-medium">Importe Total</p>
                    <p class="text-2xl font-bold text-blue-900">$570,058.00</p>
                </div>
                <div class="bg-blue-200 p-3 rounded">
                    <i class="fas fa-dollar-sign text-blue-700 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Barra de herramientas -->
        <div class="bg-white border border-gray-200 rounded-t-md mb-0 p-3 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center space-x-3 flex-wrap gap-2">
                <span class="text-xs text-gray-600 bg-gray-50 px-3 py-2 border border-gray-200 rounded flex items-center">
                    <i class="fas fa-layer-group mr-2"></i>Arrastra columna para agrupar
                </span>
                <button class="text-xs text-gray-600 hover:bg-gray-100 px-3 py-2 rounded flex items-center border border-gray-200">
                    <i class="fas fa-columns mr-2"></i>Columnas
                </button>
                <button class="text-xs text-gray-600 hover:bg-gray-100 px-3 py-2 rounded flex items-center border border-gray-200">
                    <i class="fas fa-cog mr-2"></i>Vista
                </button>
            </div>
            <div class="flex items-center space-x-2 flex-wrap gap-2">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-xs"></i>
                    <input type="text" placeholder="Buscar por folio, cliente, UUID..." class="pl-8 pr-3 py-2 border border-gray-300 rounded text-xs focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none w-64">
                </div>
                <select class="border border-gray-300 px-3 py-2 rounded text-xs focus:ring-2 focus:ring-blue-200">
                    <option>Todos los estatus</option>
                    <option>Activo</option>
                    <option>Pagado</option>
                    <option>Timbrado</option>
                    <option>Cancelado</option>
                </select>
                <select class="border border-gray-300 px-3 py-2 rounded text-xs focus:ring-2 focus:ring-blue-200">
                    <option>Todos los tipos</option>
                    <option>Ingreso</option>
                    <option>Egreso</option>
                    <option>Traslado</option>
                    <option>Pago</option>
                    <option>Nómina</option>
                </select>
                <button class="border border-gray-300 px-3 py-2 rounded text-xs hover:bg-gray-50 flex items-center">
                    <i class="fas fa-file-excel mr-2 text-green-600"></i>Excel
                </button>
                <button class="border border-gray-300 px-3 py-2 rounded text-xs hover:bg-gray-50 flex items-center">
                    <i class="fas fa-file-pdf mr-2 text-red-600"></i>PDF
                </button>
                <button class="border border-gray-300 px-3 py-2 rounded text-xs hover:bg-gray-50 flex items-center">
                    <i class="fas fa-filter mr-2"></i>Filtros Avanzados
                </button>
            </div>
        </div>

        <!-- Tabla completa de facturación -->
        <div class="bg-white border border-gray-200 border-t-0 rounded-b-md overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-xs">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <!-- Checkbox -->
                        <th class="px-2 py-3 border-r border-gray-200 w-8">
                            <input type="checkbox" class="rounded border-gray-300">
                        </th>
                        <!-- Estatus -->
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">
                            Estatus
                        </th>
                        <!-- Estatus SAT -->
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">
                            Estatus SAT
                        </th>
                        <!-- Fecha Emisión -->
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">
                            Fecha Emisión
                        </th>
                        <!-- Fecha Vencimiento -->
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">
                            Vencimiento
                        </th>
                        <!-- Tipo CFDI -->
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">
                            Tipo CFDI
                        </th>
                        <!-- Serie -->
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">
                            Serie
                        </th>
                        <!-- Folio -->
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">
                            Folio
                        </th>
                        <!-- UUID -->
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">
                            UUID / Folio Fiscal
                        </th>
                        <!-- Cliente -->
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">
                            Cliente
                        </th>
                        <!-- RFC Cliente -->
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">
                            RFC Cliente
                        </th>
                        <!-- Uso CFDI -->
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">
                            Uso CFDI
                        </th>
                        <!-- Método Pago -->
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">
                            Método Pago
                        </th>
                        <!-- Forma Pago -->
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">
                            Forma Pago
                        </th>
                        <!-- Moneda -->
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">
                            Moneda
                        </th>
                        <!-- Tipo Cambio -->
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">
                            T.C.
                        </th>
                        <!-- OC/Referencia -->
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">
                            O.C. / Ref
                        </th>
                        <!-- Condiciones Pago -->
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">
                            Condiciones
                        </th>
                        <!-- Subtotal -->
                        <th class="px-3 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">
                            Subtotal
                        </th>
                        <!-- IVA 16% -->
                        <th class="px-3 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">
                            IVA 16%
                        </th>
                        <!-- IVA Ret -->
                        <th class="px-3 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">
                            IVA Ret
                        </th>
                        <!-- ISR Ret -->
                        <th class="px-3 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">
                            ISR Ret
                        </th>
                        <!-- IEPS -->
                        <th class="px-3 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">
                            IEPS
                        </th>
                        <!-- Descuento -->
                        <th class="px-3 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">
                            Descuento
                        </th>
                        <!-- Total -->
                        <th class="px-3 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200 bg-blue-50">
                            Total
                        </th>
                        <!-- Saldo -->
                        <th class="px-3 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">
                            Saldo
                        </th>
                        <!-- Observaciones -->
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">
                            Observaciones
                        </th>
                        <!-- Acciones -->
                        <th class="px-3 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider sticky right-0 bg-gray-50">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Factura 1 - Timbrada y Activa -->
                    <tr class="hover:bg-blue-50/30 transition">
                        <td class="px-2 py-3 border-r border-gray-200">
                            <input type="checkbox" class="rounded border-gray-300">
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 flex items-center w-fit">
                                <i class="fas fa-clock mr-1"></i>Activo
                            </span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 flex items-center w-fit">
                                <i class="fas fa-check-circle mr-1"></i>Vigente
                            </span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200 whitespace-nowrap">10/02/2026 14:23</td>
                        <td class="px-3 py-3 border-r border-gray-200 whitespace-nowrap">
                            <span class="text-orange-600 font-medium">25/02/2026</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs border border-blue-200 font-medium">
                                I - Ingreso
                            </span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200 font-medium">CCP</td>
                        <td class="px-3 py-3 border-r border-gray-200 font-bold text-blue-600">21-539</td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <div class="flex items-center space-x-1">
                                <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded border border-gray-200">
                                    A1B2C3D4-E5F6...
                                </span>
                                <button class="text-gray-500 hover:text-blue-600" title="Copiar UUID">
                                    <i class="fas fa-copy text-xs"></i>
                                </button>
                            </div>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200 font-medium">Cliente Mty Demo</td>
                        <td class="px-3 py-3 border-r border-gray-200 font-mono text-xs">XEXX010101000</td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs bg-purple-50 text-purple-700 px-2 py-1 rounded border border-purple-200">
                                G03 - Gastos en general
                            </span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs bg-green-50 text-green-700 px-2 py-1 rounded">PPD</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs bg-indigo-50 text-indigo-700 px-2 py-1 rounded">99 - Por definir</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">MXN</td>
                        <td class="px-3 py-3 border-r border-gray-200">1.00</td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs bg-gray-100 px-2 py-1 rounded border border-gray-200">OC-2931381</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs text-gray-600">15 días</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono">$22,000.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono">$3,520.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono text-red-600">$0.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono text-red-600">$0.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono">$880.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono text-red-600">$0.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-bold text-blue-900 bg-blue-50">$26,400.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-bold text-orange-600">$26,400.00</td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs text-gray-600 italic">Factura CCP Cartones del Norte</span>
                        </td>
                        <td class="px-3 py-3 sticky right-0 bg-white">
                            <div class="flex items-center justify-center space-x-1">
                                <button class="text-blue-600 hover:text-blue-800 p-1.5 hover:bg-blue-50 rounded" title="Ver/Editar">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                                <button class="text-purple-600 hover:text-purple-800 p-1.5 hover:bg-purple-50 rounded" title="Timbrar">
                                    <i class="fas fa-stamp text-sm"></i>
                                </button>
                                <button class="text-green-600 hover:text-green-800 p-1.5 hover:bg-green-50 rounded" title="PDF">
                                    <i class="fas fa-file-pdf text-sm"></i>
                                </button>
                                <button class="text-indigo-600 hover:text-indigo-800 p-1.5 hover:bg-indigo-50 rounded" title="XML">
                                    <i class="fas fa-file-code text-sm"></i>
                                </button>
                                <button class="text-orange-600 hover:text-orange-800 p-1.5 hover:bg-orange-50 rounded" title="Enviar">
                                    <i class="fas fa-paper-plane text-sm"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-800 p-1.5 hover:bg-red-50 rounded" title="Cancelar">
                                    <i class="fas fa-ban text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Factura 2 - Pagada y Timbrada -->
                    <tr class="hover:bg-green-50/30 transition bg-green-50/10">
                        <td class="px-2 py-3 border-r border-gray-200">
                            <input type="checkbox" class="rounded border-gray-300">
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 flex items-center w-fit">
                                <i class="fas fa-check-double mr-1"></i>Pagado
                            </span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 flex items-center w-fit">
                                <i class="fas fa-check-circle mr-1"></i>Vigente
                            </span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200 whitespace-nowrap">10/02/2026 11:15</td>
                        <td class="px-3 py-3 border-r border-gray-200 whitespace-nowrap">
                            <span class="text-green-600 font-medium">25/02/2026</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs border border-blue-200 font-medium">
                                I - Ingreso
                            </span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200 font-medium">A</td>
                        <td class="px-3 py-3 border-r border-gray-200 font-bold text-blue-600">79-538</td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <div class="flex items-center space-x-1">
                                <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded border border-gray-200">
                                    F7G8H9I0-J1K2...
                                </span>
                                <button class="text-gray-500 hover:text-blue-600" title="Copiar UUID">
                                    <i class="fas fa-copy text-xs"></i>
                                </button>
                            </div>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200 font-medium">Cliente Mty Demo</td>
                        <td class="px-3 py-3 border-r border-gray-200 font-mono text-xs">XEXX010101000</td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs bg-purple-50 text-purple-700 px-2 py-1 rounded border border-purple-200">
                                G03 - Gastos en general
                            </span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs bg-green-50 text-green-700 px-2 py-1 rounded">PUE</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs bg-indigo-50 text-indigo-700 px-2 py-1 rounded">03 - Transferencia</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">MXN</td>
                        <td class="px-3 py-3 border-r border-gray-200">1.00</td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs bg-gray-100 px-2 py-1 rounded border border-gray-200">OC-39191</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs text-green-600 font-medium">Contado</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono">$22,000.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono">$3,520.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono text-red-600">$0.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono text-red-600">$0.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono">$880.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono text-red-600">$0.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-bold text-blue-900 bg-blue-50">$26,400.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-bold text-green-600">$0.00</td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs text-gray-600 italic">Pagado el 12/02/2026</span>
                        </td>
                        <td class="px-3 py-3 sticky right-0 bg-green-50/10">
                            <div class="flex items-center justify-center space-x-1">
                                <button class="text-blue-600 hover:text-blue-800 p-1.5 hover:bg-blue-50 rounded" title="Ver">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                                <button class="text-green-600 hover:text-green-800 p-1.5 hover:bg-green-50 rounded" title="PDF">
                                    <i class="fas fa-file-pdf text-sm"></i>
                                </button>
                                <button class="text-indigo-600 hover:text-indigo-800 p-1.5 hover:bg-indigo-50 rounded" title="XML">
                                    <i class="fas fa-file-code text-sm"></i>
                                </button>
                                <button class="text-orange-600 hover:text-orange-800 p-1.5 hover:bg-orange-50 rounded" title="Enviar">
                                    <i class="fas fa-paper-plane text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Factura 3 - Con retenciones -->
                    <tr class="hover:bg-blue-50/30 transition">
                        <td class="px-2 py-3 border-r border-gray-200">
                            <input type="checkbox" class="rounded border-gray-300">
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 flex items-center w-fit">
                                <i class="fas fa-clock mr-1"></i>Activo
                            </span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 flex items-center w-fit">
                                <i class="fas fa-check-circle mr-1"></i>Vigente
                            </span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200 whitespace-nowrap">06/02/2026 09:45</td>
                        <td class="px-3 py-3 border-r border-gray-200 whitespace-nowrap">
                            <span class="text-red-600 font-medium">21/02/2026</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="bg-purple-50 text-purple-700 px-2 py-1 rounded text-xs border border-purple-200 font-medium">
                                I - Ingreso
                            </span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200 font-medium">EKT</td>
                        <td class="px-3 py-3 border-r border-gray-200 font-bold text-blue-600">21-536</td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <div class="flex items-center space-x-1">
                                <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded border border-gray-200">
                                    M3N4O5P6-Q7R8...
                                </span>
                                <button class="text-gray-500 hover:text-blue-600" title="Copiar UUID">
                                    <i class="fas fa-copy text-xs"></i>
                                </button>
                            </div>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200 font-medium">Cartones del Norte Demo</td>
                        <td class="px-3 py-3 border-r border-gray-200 font-mono text-xs">XAXX010101000</td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs bg-purple-50 text-purple-700 px-2 py-1 rounded border border-purple-200">
                                G03 - Gastos en general
                            </span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs bg-green-50 text-green-700 px-2 py-1 rounded">PPD</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs bg-indigo-50 text-indigo-700 px-2 py-1 rounded">99 - Por definir</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">MXN</td>
                        <td class="px-3 py-3 border-r border-gray-200">1.00</td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs bg-gray-100 px-2 py-1 rounded border border-gray-200">S-84381282879</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs text-gray-600">30 días</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono">$45,000.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono">$7,200.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono text-red-600">$720.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono text-red-600">$450.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono">$1,800.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono text-red-600">$0.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-bold text-blue-900 bg-blue-50">$51,830.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-bold text-orange-600">$51,830.00</td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs text-gray-600 italic">Con retenciones IVA 10% e ISR 1%</span>
                        </td>
                        <td class="px-3 py-3 sticky right-0 bg-white">
                            <div class="flex items-center justify-center space-x-1">
                                <button class="text-blue-600 hover:text-blue-800 p-1.5 hover:bg-blue-50 rounded" title="Ver/Editar">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                                <button class="text-purple-600 hover:text-purple-800 p-1.5 hover:bg-purple-50 rounded" title="Timbrar">
                                    <i class="fas fa-stamp text-sm"></i>
                                </button>
                                <button class="text-green-600 hover:text-green-800 p-1.5 hover:bg-green-50 rounded" title="PDF">
                                    <i class="fas fa-file-pdf text-sm"></i>
                                </button>
                                <button class="text-indigo-600 hover:text-indigo-800 p-1.5 hover:bg-indigo-50 rounded" title="XML">
                                    <i class="fas fa-file-code text-sm"></i>
                                </button>
                                <button class="text-orange-600 hover:text-orange-800 p-1.5 hover:bg-orange-50 rounded" title="Enviar">
                                    <i class="fas fa-paper-plane text-sm"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-800 p-1.5 hover:bg-red-50 rounded" title="Cancelar">
                                    <i class="fas fa-ban text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Factura 4 - En USD -->
                    <tr class="hover:bg-blue-50/30 transition">
                        <td class="px-2 py-3 border-r border-gray-200">
                            <input type="checkbox" class="rounded border-gray-300">
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 flex items-center w-fit">
                                <i class="fas fa-clock mr-1"></i>Activo
                            </span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 flex items-center w-fit">
                                <i class="fas fa-check-circle mr-1"></i>Vigente
                            </span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200 whitespace-nowrap">04/02/2026 16:30</td>
                        <td class="px-3 py-3 border-r border-gray-200 whitespace-nowrap">
                            <span class="text-orange-600 font-medium">19/02/2026</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs border border-blue-200 font-medium">
                                I - Ingreso
                            </span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200 font-medium">CCP</td>
                        <td class="px-3 py-3 border-r border-gray-200 font-bold text-blue-600">20-534</td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <div class="flex items-center space-x-1">
                                <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded border border-gray-200">
                                    S9T0U1V2-W3X4...
                                </span>
                                <button class="text-gray-500 hover:text-blue-600" title="Copiar UUID">
                                    <i class="fas fa-copy text-xs"></i>
                                </button>
                            </div>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200 font-medium">Cartones del Norte Demo</td>
                        <td class="px-3 py-3 border-r border-gray-200 font-mono text-xs">XAXX010101000</td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs bg-purple-50 text-purple-700 px-2 py-1 rounded border border-purple-200">
                                G03 - Gastos en general
                            </span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs bg-green-50 text-green-700 px-2 py-1 rounded">PPD</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs bg-indigo-50 text-indigo-700 px-2 py-1 rounded">99 - Por definir</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="font-semibold text-green-600">USD</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="font-semibold text-blue-600">20.50</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs bg-gray-100 px-2 py-1 rounded border border-gray-200">S-847902381029</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs text-gray-600">15 días</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono">
                            <div class="text-green-700 font-semibold">$1,000.00 USD</div>
                            <div class="text-xs text-gray-500">$20,500.00 MXN</div>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono">$3,280.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono text-red-600">$0.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono text-red-600">$0.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono">$820.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono text-red-600">$0.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-bold text-blue-900 bg-blue-50">$24,600.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-bold text-orange-600">$24,600.00</td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs text-gray-600 italic">Factura en dólares, T.C. 20.50</span>
                        </td>
                        <td class="px-3 py-3 sticky right-0 bg-white">
                            <div class="flex items-center justify-center space-x-1">
                                <button class="text-blue-600 hover:text-blue-800 p-1.5 hover:bg-blue-50 rounded" title="Ver/Editar">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                                <button class="text-purple-600 hover:text-purple-800 p-1.5 hover:bg-purple-50 rounded" title="Timbrar">
                                    <i class="fas fa-stamp text-sm"></i>
                                </button>
                                <button class="text-green-600 hover:text-green-800 p-1.5 hover:bg-green-50 rounded" title="PDF">
                                    <i class="fas fa-file-pdf text-sm"></i>
                                </button>
                                <button class="text-indigo-600 hover:text-indigo-800 p-1.5 hover:bg-indigo-50 rounded" title="XML">
                                    <i class="fas fa-file-code text-sm"></i>
                                </button>
                                <button class="text-orange-600 hover:text-orange-800 p-1.5 hover:bg-orange-50 rounded" title="Enviar">
                                    <i class="fas fa-paper-plane text-sm"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-800 p-1.5 hover:bg-red-50 rounded" title="Cancelar">
                                    <i class="fas fa-ban text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Factura 5 - Cancelada -->
                    <tr class="hover:bg-red-50/30 transition bg-red-50/20 opacity-70">
                        <td class="px-2 py-3 border-r border-gray-200">
                            <input type="checkbox" class="rounded border-gray-300" disabled>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 flex items-center w-fit">
                                <i class="fas fa-ban mr-1"></i>Cancelado
                            </span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 flex items-center w-fit">
                                <i class="fas fa-times-circle mr-1"></i>Cancelado
                            </span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200 whitespace-nowrap line-through text-gray-400">29/01/2026 10:20</td>
                        <td class="px-3 py-3 border-r border-gray-200 whitespace-nowrap">
                            <span class="text-gray-400 line-through">13/02/2026</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="bg-gray-100 text-gray-500 px-2 py-1 rounded text-xs border border-gray-200 font-medium">
                                I - Ingreso
                            </span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200 font-medium text-gray-400">A</td>
                        <td class="px-3 py-3 border-r border-gray-200 font-bold text-gray-400 line-through">78-532</td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <div class="flex items-center space-x-1">
                                <span class="font-mono text-xs bg-red-100 px-2 py-1 rounded border border-red-200 text-gray-500 line-through">
                                    Y5Z6A7B8-C9D0...
                                </span>
                            </div>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200 text-gray-400">Cartones del Norte Demo</td>
                        <td class="px-3 py-3 border-r border-gray-200 font-mono text-xs text-gray-400">XAXX010101000</td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded border border-gray-200">
                                G03 - Gastos en general
                            </span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded">PPD</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded">99 - Por definir</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200 text-gray-400">MXN</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-gray-400">1.00</td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs bg-gray-100 px-2 py-1 rounded border border-gray-200 text-gray-400">S-847909000897</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs text-gray-400">30 días</span>
                        </td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono text-gray-400 line-through">$45,000.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono text-gray-400 line-through">$7,200.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono text-gray-400">$0.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono text-gray-400">$0.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono text-gray-400 line-through">$1,800.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-mono text-gray-400">$0.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-bold text-gray-400 line-through bg-red-50">$54,000.00</td>
                        <td class="px-3 py-3 border-r border-gray-200 text-right font-bold text-gray-400">$0.00</td>
                        <td class="px-3 py-3 border-r border-gray-200">
                            <span class="text-xs text-red-600 font-medium">Cancelada el 30/01/2026 - Duplicada</span>
                        </td>
                        <td class="px-3 py-3 sticky right-0 bg-red-50/20">
                            <div class="flex items-center justify-center space-x-1">
                                <button class="text-blue-600 hover:text-blue-800 p-1.5 hover:bg-blue-50 rounded" title="Ver">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                                <button class="text-gray-400 p-1.5 cursor-not-allowed" title="No disponible" disabled>
                                    <i class="fas fa-file-pdf text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <!-- Barra inferior de totales -->
            <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-4 py-3 border-t-2 border-blue-200">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-6">
                        <div class="flex items-center">
                            <span class="text-xs text-gray-600 mr-2">Facturas:</span>
                            <span class="text-sm font-bold text-gray-900">12</span>
                        </div>
                        <div class="h-6 w-px bg-gray-300"></div>
                        <div class="flex items-center">
                            <span class="text-xs text-gray-600 mr-2">Subtotal:</span>
                            <span class="text-sm font-bold text-gray-900">$500,350.00</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-xs text-gray-600 mr-2">IVA Tras:</span>
                            <span class="text-sm font-bold text-green-700">$80,056.00</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-xs text-gray-600 mr-2">IVA Ret:</span>
                            <span class="text-sm font-bold text-red-700">-$720.00</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-xs text-gray-600 mr-2">ISR Ret:</span>
                            <span class="text-sm font-bold text-red-700">-$450.00</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-xs text-gray-600 mr-2">IEPS:</span>
                            <span class="text-sm font-bold text-gray-900">$10,348.00</span>
                        </div>
                        <div class="h-6 w-px bg-gray-300"></div>
                        <div class="flex items-center bg-blue-100 px-3 py-1.5 rounded-lg border border-blue-300">
                            <span class="text-xs text-blue-700 mr-2 font-semibold">TOTAL:</span>
                            <span class="text-lg font-bold text-blue-900">$589,584.00</span>
                        </div>
                        <div class="flex items-center bg-orange-100 px-3 py-1.5 rounded-lg border border-orange-300">
                            <span class="text-xs text-orange-700 mr-2 font-semibold">SALDO:</span>
                            <span class="text-lg font-bold text-orange-900">$128,230.00</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-xs text-gray-600">Página 1-5 de 12</span>
                        <button class="border border-gray-300 px-2.5 py-1.5 rounded text-gray-600 hover:bg-white disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            <i class="fas fa-chevron-left text-xs"></i>
                        </button>
                        <button class="border border-gray-300 px-2.5 py-1.5 rounded text-gray-600 hover:bg-white">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Información adicional -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <!-- Observaciones recientes -->
            <div class="bg-white rounded-lg border border-gray-200 p-5 shadow-sm">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center text-sm">
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                    Observaciones Recientes
                </h3>
                <div class="space-y-3 text-xs">
                    <div class="border-l-3 border-blue-500 pl-3 py-1 bg-blue-50/30">
                        <div class="flex justify-between items-start mb-1">
                            <span class="font-semibold text-gray-700">Folio CCP-21-539</span>
                            <span class="text-gray-500 text-xs">10/02</span>
                        </div>
                        <p class="text-gray-600">Factura CCP Cartones del Norte - Servicio de transporte nacional</p>
                    </div>
                    <div class="border-l-3 border-green-500 pl-3 py-1 bg-green-50/30">
                        <div class="flex justify-between items-start mb-1">
                            <span class="font-semibold text-gray-700">Folio A-79-538</span>
                            <span class="text-gray-500 text-xs">10/02</span>
                        </div>
                        <p class="text-gray-600">Pagado por transferencia - Comprobante adjunto</p>
                    </div>
                    <div class="border-l-3 border-red-500 pl-3 py-1 bg-red-50/30">
                        <div class="flex justify-between items-start mb-1">
                            <span class="font-semibold text-gray-700">Folio A-78-532</span>
                            <span class="text-gray-500 text-xs">30/01</span>
                        </div>
                        <p class="text-gray-600">Cancelada - Factura duplicada, sustituir por EKT-21-536</p>
                    </div>
                </div>
            </div>

            <!-- Clientes Top -->
            <div class="bg-white rounded-lg border border-gray-200 p-5 shadow-sm">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center text-sm">
                    <i class="fas fa-chart-pie mr-2 text-purple-600"></i>
                    Top Clientes del Mes
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                        <div>
                            <p class="font-medium text-gray-800 text-xs">Cartones del Norte</p>
                            <p class="text-xs text-gray-500">8 facturas</p>
                        </div>
                        <span class="font-bold text-blue-900 text-sm">$285,430</span>
                    </div>
                    <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                        <div>
                            <p class="font-medium text-gray-800 text-xs">Cliente Mty Demo</p>
                            <p class="text-xs text-gray-500">3 facturas</p>
                        </div>
                        <span class="font-bold text-blue-900 text-sm">$77,400</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-800 text-xs">Otros clientes</p>
                            <p class="text-xs text-gray-500">1 factura</p>
                        </div>
                        <span class="font-bold text-blue-900 text-sm">$16,754</span>
                    </div>
                </div>
            </div>

            <!-- Alertas y pendientes -->
            <div class="bg-white rounded-lg border border-gray-200 p-5 shadow-sm">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center text-sm">
                    <i class="fas fa-exclamation-triangle mr-2 text-orange-600"></i>
                    Alertas y Pendientes
                </h3>
                <div class="space-y-3">
                    <div class="bg-red-50 border-l-4 border-red-500 p-3 rounded">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-circle text-red-600 mt-0.5 mr-2"></i>
                            <div>
                                <p class="font-semibold text-red-800 text-xs">1 factura vencida</p>
                                <p class="text-xs text-red-700 mt-1">EKT-21-536 - Vencimiento: 21/02/2026</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-orange-50 border-l-4 border-orange-500 p-3 rounded">
                        <div class="flex items-start">
                            <i class="fas fa-clock text-orange-600 mt-0.5 mr-2"></i>
                            <div>
                                <p class="font-semibold text-orange-800 text-xs">2 facturas por vencer</p>
                                <p class="text-xs text-orange-700 mt-1">Próximos 5 días</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-3 rounded">
                        <div class="flex items-start">
                            <i class="fas fa-stamp text-blue-600 mt-0.5 mr-2"></i>
                            <div>
                                <p class="font-semibold text-blue-800 text-xs">4 facturas sin timbrar</p>
                                <p class="text-xs text-blue-700 mt-1">Pendiente de envío al PAC</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection