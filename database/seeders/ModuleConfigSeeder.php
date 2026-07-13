<?php
// database/seeders/ModuleConfigSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ModuleConfig;

class ModuleConfigSeeder extends Seeder
{
    public function run()
    {
        // Limpiar la tabla antes de insertar (opcional)
        ModuleConfig::truncate();

        $modules = [
            // ============================================================
            // BUSINESS INTELLIGENCE (BI)
            // ============================================================
            [
                'name' => 'bi_dashboard',
                'display_name' => 'Dashboard Directivo',
                'icon' => 'fa-user-tie',
                'section' => 'bi',
                'route' => 'bi.dashboard',
                'order' => 1
            ],
            [
                'name' => 'bi_finanzas',
                'display_name' => 'Finanzas',
                'icon' => 'fa-chart-pie',
                'section' => 'bi',
                'route' => 'bi.finanzas',
                'order' => 2
            ],
            [
                'name' => 'bi_licitaciones',
                'display_name' => 'Licitaciones',
                'icon' => 'fa-gavel',
                'section' => 'bi',
                'route' => 'bi.licitaciones',
                'order' => 3
            ],
            [
                'name' => 'bi_propuestas',
                'display_name' => 'Propuestas y Cotizaciones',
                'icon' => 'fa-file-contract',
                'section' => 'bi',
                'route' => 'ventas.propuestas',
                'order' => 4
            ],
            [
                'name' => 'bi_analisis_ventas',
                'display_name' => 'Análisis de Ventas',
                'icon' => 'fa-chart-line',
                'section' => 'bi',
                'route' => 'ventas.analisis',
                'order' => 5
            ],
            [
                'name' => 'bi_pendiente',
                'display_name' => 'Pendiente de Facturación',
                'icon' => 'fa-clock',
                'section' => 'bi',
                'route' => 'facturacion.pendiente',
                'order' => 6
            ],
            [
                'name' => 'bi_facturado',
                'display_name' => 'Facturado',
                'icon' => 'fa-check-circle',
                'section' => 'bi',
                'route' => 'facturacion.facturacion',
                'order' => 7
            ],
            [
                'name' => 'bi_proyecciones',
                'display_name' => 'Proyecciones de Flujo',
                'icon' => 'fa-chart-line',
                'section' => 'bi',
                'route' => 'cobranza.proyecciones',
                'order' => 8
            ],
            [
                'name' => 'bi_historial',
                'display_name' => 'Historial de Pagos',
                'icon' => 'fa-history',
                'section' => 'bi',
                'route' => 'cobranza.historial',
                'order' => 9
            ],

            // ============================================================
            // ADMINISTRACIÓN
            // ============================================================
            [
                'name' => 'admin_facturacion',
                'display_name' => 'Facturación',
                'icon' => 'fa-file-invoice',
                'section' => 'administracion',
                'route' => 'admin.facturacion',
                'order' => 10
            ],
            [
                'name' => 'admin_cfdi',
                'display_name' => 'CFDI',
                'icon' => 'fa-file-contract',
                'section' => 'administracion',
                'route' => 'admin.cfdi',
                'order' => 11
            ],
            [
                'name' => 'admin_notas_credito',
                'display_name' => 'Notas de Crédito',
                'icon' => 'fa-undo-alt',
                'section' => 'administracion',
                'route' => 'admin.nota',
                'order' => 12
            ],
            [
                'name' => 'admin_ventas',
                'display_name' => 'Notas de Ventas',
                'icon' => 'fa-sticky-note',
                'section' => 'administracion',
                'route' => 'admin.ventas',
                'order' => 13
            ],
            [
                'name' => 'admin_contrarecibo',
                'display_name' => 'Contrarecibos',
                'icon' => 'fa-receipt',
                'section' => 'administracion',
                'route' => 'admin.contrarecibo',
                'order' => 14
            ],
            [
                'name' => 'admin_factoraje',
                'display_name' => 'Factoraje',
                'icon' => 'fa-handshake',
                'section' => 'administracion',
                'route' => 'admin.factoraje',
                'order' => 15
            ],
            [
                'name' => 'admin_cxc',
                'display_name' => 'Cuentas por Cobrar',
                'icon' => 'fa-money-bill-trend-up',
                'section' => 'administracion',
                'route' => 'admin.saldos',
                'order' => 16
            ],
            [
                'name' => 'admin_cxp',
                'display_name' => 'Cuentas por Pagar',
                'icon' => 'fa-file-invoice-dollar',
                'section' => 'administracion',
                'route' => 'admin.pagos',
                'order' => 17
            ],
            [
                'name' => 'admin_depositos',
                'display_name' => 'Depósitos',
                'icon' => 'fa-money-check-alt',
                'section' => 'administracion',
                'route' => 'depositos.index',
                'order' => 18
            ],
            [
                'name' => 'admin_trasferencia',
                'display_name' => 'Transferencia',
                'icon' => 'fa-money-bill-trend-up',
                'section' => 'administracion',
                'route' => 'tesoreria.trasferencia',
                'order' => 19
            ],
            [
                'name' => 'admin_pagos',
                'display_name' => 'Pagos',
                'icon' => 'fa-file-invoice-dollar',
                'section' => 'administracion',
                'route' => 'pagos.index',
                'order' => 20
            ],
            [
                'name' => 'admin_traspasos',
                'display_name' => 'Traspasos',
                'icon' => 'fa-exchange-alt',
                'section' => 'administracion',
                'route' => 'traspasos.index',
                'order' => 21
            ],
            [
                'name' => 'admin_estados_cuenta',
                'display_name' => 'Estados de Cuenta Bancarios',
                'icon' => 'fa-file-alt',
                'section' => 'administracion',
                'route' => 'tesoreria.estadosdecuenta',
                'order' => 22
            ],
            [
                'name' => 'admin_conciliacion',
                'display_name' => 'Conciliación Bancaria',
                'icon' => 'fa-balance-scale',
                'section' => 'administracion',
                'route' => 'tesoreria.conciliacion',
                'order' => 23
            ],
            [
                'name' => 'admin_flujo',
                'display_name' => 'Flujo de Dinero',
                'icon' => 'fa-wave-square',
                'section' => 'administracion',
                'route' => 'tesoreria.flujos',
                'order' => 24
            ],
            [
                'name' => 'admin_flujo_mensual',
                'display_name' => 'Flujo Mensual',
                'icon' => 'fa-calendar-alt',
                'section' => 'administracion',
                'route' => 'tesoreria.flujomensual',
                'order' => 25
            ],
            [
                'name' => 'admin_programacion',
                'display_name' => 'Programación de Pagos',
                'icon' => 'fa-calendar-check',
                'section' => 'administracion',
                'route' => 'tesoreria.programacion',
                'order' => 26
            ],
            [
                'name' => 'admin_facturacion_proveedores',
                'display_name' => 'Facturación Proveedores',
                'icon' => 'fa-chart-pie',
                'section' => 'administracion',
                'route' => 'presupuestos.facturacion',
                'order' => 27
            ],
            [
                'name' => 'admin_presupuesto_mensual',
                'display_name' => 'Presupuesto Mensual',
                'icon' => 'fa-calendar',
                'section' => 'administracion',
                'route' => 'presupuestos.mensual',
                'order' => 28
            ],
            [
                'name' => 'admin_reasignacion',
                'display_name' => 'Reasignación de Gastos',
                'icon' => 'fa-random',
                'section' => 'administracion',
                'route' => 'presupuestos.reasignacion',
                'order' => 29
            ],
            [
                'name' => 'admin_gastos_fijos',
                'display_name' => 'Gastos Fijos',
                'icon' => 'fa-home',
                'section' => 'administracion',
                'route' => 'presupuestos.gastos',
                'order' => 30
            ],
            [
                'name' => 'admin_prepago',
                'display_name' => 'Prepago',
                'icon' => 'fa-forward',
                'section' => 'administracion',
                'route' => 'operaciones.prepago',
                'order' => 31
            ],
            [
                'name' => 'admin_anticipos',
                'display_name' => 'Anticipos',
                'icon' => 'fa-hand-holding-usd',
                'section' => 'administracion',
                'route' => 'operaciones.anticipo',
                'order' => 32
            ],
            [
                'name' => 'admin_credito',
                'display_name' => 'Crédito',
                'icon' => 'fa-credit-card',
                'section' => 'administracion',
                'route' => 'operaciones.credito',
                'order' => 33
            ],
            [
                'name' => 'admin_cuentas_avanzadas',
                'display_name' => 'Cuentas Avanzadas',
                'icon' => 'fa-cogs',
                'section' => 'administracion',
                'route' => 'cuentasavanzadas.cuentasavanzadas',
                'order' => 34
            ],
            [
                'name' => 'admin_registro_cuentas',
                'display_name' => 'Registro de Cuentas Contables',
                'icon' => 'fa-cogs',
                'section' => 'administracion',
                'route' => 'registro.cuentas',
                'order' => 35
            ],
            [
                'name' => 'admin_cuentas_bancarias',
                'display_name' => 'Registro de Cuentas Bancarias',
                'icon' => 'fa-university',
                'section' => 'administracion',
                'route' => 'cuentas.bancarias',
                'order' => 36
            ],

            // ============================================================
            // CONTABILIDAD
            // ============================================================
            [
                'name' => 'conta_estados',
                'display_name' => 'Estado de Resultados',
                'icon' => 'fa-chart-pie',
                'section' => 'contabilidad',
                'route' => 'conta.estados',
                'order' => 40
            ],
            [
                'name' => 'conta_balance',
                'display_name' => 'Balance General',
                'icon' => 'fa-balance-scale',
                'section' => 'contabilidad',
                'route' => 'conta.balance',
                'order' => 41
            ],
            [
                'name' => 'conta_comprobacion',
                'display_name' => 'Balance de Comprobación',
                'icon' => 'fa-check-double',
                'section' => 'contabilidad',
                'route' => 'conta.comprobacion',
                'order' => 42
            ],
            [
                'name' => 'conta_flujo',
                'display_name' => 'Estado de Flujo de Efectivo',
                'icon' => 'fa-money-bill-wave',
                'section' => 'contabilidad',
                'route' => 'conta.flujo',
                'order' => 43
            ],
            [
                'name' => 'conta_presupuesto',
                'display_name' => 'Presupuesto',
                'icon' => 'fa-exchange-alt',
                'section' => 'contabilidad',
                'route' => 'conta.capital',
                'order' => 44
            ],
            [
                'name' => 'conta_unidad',
                'display_name' => 'Estado de Resultado Unidad de Negocio',
                'icon' => 'fa-chart-column',
                'section' => 'contabilidad',
                'route' => 'conta.unidad',
                'order' => 45
            ],
            [
                'name' => 'conta_polizas',
                'display_name' => 'Pólizas Contables',
                'icon' => 'fa-file-alt',
                'section' => 'contabilidad',
                'route' => 'conta.polizas',
                'order' => 46
            ],
            [
                'name' => 'conta_diario',
                'display_name' => 'Diario General',
                'icon' => 'fa-book',
                'section' => 'contabilidad',
                'route' => 'conta.diario',
                'order' => 47
            ],
            [
                'name' => 'conta_cobranza',
                'display_name' => 'Cobranza',
                'icon' => 'fa-columns',
                'section' => 'contabilidad',
                'route' => 'conta.cobranza',
                'order' => 48
            ],
            [
                'name' => 'conta_auxiliar',
                'display_name' => 'Auxiliar de Cuentas',
                'icon' => 'fa-indent',
                'section' => 'contabilidad',
                'route' => 'conta.auxiliar',
                'order' => 49
            ],
            [
                'name' => 'conta_centros',
                'display_name' => 'Centros de Costos',
                'icon' => 'fa-sitemap',
                'section' => 'contabilidad',
                'route' => 'conta.centros',
                'order' => 50
            ],
            [
                'name' => 'conta_costo',
                'display_name' => 'Costos por Obra',
                'icon' => 'fa-hard-hat',
                'section' => 'contabilidad',
                'route' => 'conta.costo',
                'order' => 51
            ],
            [
                'name' => 'conta_gastos',
                'display_name' => 'Gastos Indirectos de Obra',
                'icon' => 'fa-tools',
                'section' => 'contabilidad',
                'route' => 'conta.gastos',
                'order' => 52
            ],
            [
                'name' => 'conta_asignacion',
                'display_name' => 'Asignación de Gastos por Proyecto',
                'icon' => 'fa-project-diagram',
                'section' => 'contabilidad',
                'route' => 'conta.asignacion',
                'order' => 53
            ],
            [
                'name' => 'conta_diot',
                'display_name' => 'DIOT',
                'icon' => 'fa-file-export',
                'section' => 'contabilidad',
                'route' => 'conta.diot',
                'order' => 54
            ],
            [
                'name' => 'conta_retenciones',
                'display_name' => 'Retenciones (ISR, IVA)',
                'icon' => 'fa-percentage',
                'section' => 'contabilidad',
                'route' => 'conta.retenciones',
                'order' => 55
            ],
            [
                'name' => 'conta_complemento',
                'display_name' => 'Complemento de Pagos',
                'icon' => 'fa-money-check-alt',
                'section' => 'contabilidad',
                'route' => 'conta.complemento',
                'order' => 56
            ],

            // ============================================================
            // PROYECTOS
            // ============================================================
            [
                'name' => 'proyectos_cartera',
                'display_name' => 'Cartera de Proyectos',
                'icon' => 'fa-briefcase',
                'section' => 'proyectos',
                'route' => 'proyectos.cartera',
                'order' => 60
            ],
            [
                'name' => 'proyectos_alta',
                'display_name' => 'Alta de Proyecto',
                'icon' => 'fa-plus-circle',
                'section' => 'proyectos',
                'route' => 'proyectos.alta',
                'order' => 61
            ],
            [
                'name' => 'proyectos_hitos',
                'display_name' => 'Cronograma y Hitos',
                'icon' => 'fa-calendar-alt',
                'section' => 'proyectos',
                'route' => 'proyectos.hitos',
                'order' => 62
            ],
            [
                'name' => 'proyectos_bitacora',
                'display_name' => 'Bitácora de Obra',
                'icon' => 'fa-book',
                'section' => 'proyectos',
                'route' => 'proyectos.bitacora',
                'order' => 63
            ],
            [
                'name' => 'proyectos_activas',
                'display_name' => 'Licitaciones Activas',
                'icon' => 'fa-gavel',
                'section' => 'proyectos',
                'route' => 'proyectos.activas',
                'order' => 64
            ],
            [
                'name' => 'proyectos_analisis',
                'display_name' => 'Análisis de Precios Unitarios',
                'icon' => 'fa-calculator',
                'section' => 'proyectos',
                'route' => 'proyectos.analisis',
                'order' => 65
            ],
            [
                'name' => 'proyectos_presupuesto_proyecto',
                'display_name' => 'Presupuesto por Proyecto',
                'icon' => 'fa-file-invoice-dollar',
                'section' => 'proyectos',
                'route' => 'proyectos.presupuesto_proyecto',
                'order' => 66
            ],
            [
                'name' => 'proyectos_directos',
                'display_name' => 'Costos Directos',
                'icon' => 'fa-money-bill-wave',
                'section' => 'proyectos',
                'route' => 'proyectos.directos',
                'order' => 67
            ],
            [
                'name' => 'proyectos_indirectos',
                'display_name' => 'Costos Indirectos',
                'icon' => 'fa-tools',
                'section' => 'proyectos',
                'route' => 'proyectos.indirectos',
                'order' => 68
            ],
            [
                'name' => 'proyectos_estimaciones',
                'display_name' => 'Estimaciones',
                'icon' => 'fa-calculator',
                'section' => 'proyectos',
                'route' => 'proyectos.estimaciones',
                'order' => 69
            ],
            [
                'name' => 'proyectos_reportes',
                'display_name' => 'Reporte Fotográfico',
                'icon' => 'fa-camera',
                'section' => 'proyectos',
                'route' => 'proyectos.reportes',
                'order' => 70
            ],
            [
                'name' => 'proyectos_asignada',
                'display_name' => 'Asignación a Proyectos',
                'icon' => 'fa-user-check',
                'section' => 'proyectos',
                'route' => 'proyectos.asignada',
                'order' => 71
            ],
            [
                'name' => 'proyectos_flotillas',
                'display_name' => 'Asistencia y Cuadrillas',
                'icon' => 'fa-users',
                'section' => 'proyectos',
                'route' => 'proyectos.flotillas',
                'order' => 72
            ],
            [
                'name' => 'proyectos_contratistas',
                'display_name' => 'Contratistas',
                'icon' => 'fa-users',
                'section' => 'proyectos',
                'route' => 'proyectos.contratistas.index',
                'order' => 73
            ],
            [
                'name' => 'proyectos_asignacion_equipo',
                'display_name' => 'Asignación de Equipo',
                'icon' => 'fa-tractor',
                'section' => 'proyectos',
                'route' => 'proyectos.asignacion',
                'order' => 74
            ],
            [
                'name' => 'proyectos_mantenimiento',
                'display_name' => 'Mantenimiento de Equipo',
                'icon' => 'fa-tools',
                'section' => 'proyectos',
                'route' => 'proyectos.mantenimiento',
                'order' => 75
            ],
            [
                'name' => 'proyectos_desviaciones',
                'display_name' => 'Desviaciones (Costo y Tiempo)',
                'icon' => 'fa-exclamation-triangle',
                'section' => 'proyectos',
                'route' => 'proyectos.desviaciones',
                'order' => 76
            ],
            [
                'name' => 'proyectos_control',
                'display_name' => 'Control de Calidad',
                'icon' => 'fa-clipboard-check',
                'section' => 'proyectos',
                'route' => 'proyectos.control',
                'order' => 77
            ],
            [
                'name' => 'proyectos_planos',
                'display_name' => 'Contratos y Planos',
                'icon' => 'fa-file-contract',
                'section' => 'proyectos',
                'route' => 'proyectos.planos',
                'order' => 78
            ],
            [
                'name' => 'proyectos_evidencia',
                'display_name' => 'Evidencias (Fotos, Actas)',
                'icon' => 'fa-camera',
                'section' => 'proyectos',
                'route' => 'proyectos.evidencia',
                'order' => 79
            ],

            // ============================================================
            // RECURSOS HUMANOS (RRHH)
            // ============================================================
            [
                'name' => 'rrhh_plantilla',
                'display_name' => 'Plantilla de Empleados',
                'icon' => 'fa-users',
                'section' => 'rrhh',
                'route' => 'rh.plantilla',
                'order' => 80
            ],
            [
                'name' => 'rrhh_incidencias',
                'display_name' => 'Incidencias',
                'icon' => 'fa-folder',
                'section' => 'rrhh',
                'route' => 'rh.expediente',
                'order' => 81
            ],
            [
                'name' => 'rrhh_asistencia',
                'display_name' => 'Asistencia',
                'icon' => 'fa-user-clock',
                'section' => 'rrhh',
                'route' => 'rh.asistencia',
                'order' => 82
            ],
            [
                'name' => 'rrhh_lista',
                'display_name' => 'Lista de Asistencia',
                'icon' => 'fa-list',
                'section' => 'rrhh',
                'route' => 'rh.lista',
                'order' => 83
            ],
            [
                'name' => 'rrhh_justificantes',
                'display_name' => 'Justificantes y Permisos',
                'icon' => 'fa-file-alt',
                'section' => 'rrhh',
                'route' => 'rh.justificantes',
                'order' => 84
            ],
            [
                'name' => 'rrhh_control_horarios',
                'display_name' => 'Control de Horarios',
                'icon' => 'fa-clock',
                'section' => 'rrhh',
                'route' => 'rh.control',
                'order' => 85
            ],
            [
                'name' => 'rrhh_calculo',
                'display_name' => 'Cálculo de Nómina',
                'icon' => 'fa-calculator',
                'section' => 'rrhh',
                'route' => 'rh.calculo',
                'order' => 86
            ],
            [
                'name' => 'rrhh_pagos',
                'display_name' => 'Pagos de Nómina',
                'icon' => 'fa-money-check-alt',
                'section' => 'rrhh',
                'route' => 'rh.pagos',
                'order' => 87
            ],
            [
                'name' => 'rrhh_recibos',
                'display_name' => 'Recibos de Nómina (Timbrado)',
                'icon' => 'fa-file-invoice-dollar',
                'section' => 'rrhh',
                'route' => 'rh.recibos',
                'order' => 88
            ],
            [
                'name' => 'rrhh_prestamos',
                'display_name' => 'Préstamos y Descuentos',
                'icon' => 'fa-hand-holding-usd',
                'section' => 'rrhh',
                'route' => 'rh.prestamos.index',
                'order' => 89
            ],
            [
                'name' => 'rrhh_vacaciones',
                'display_name' => 'Vacaciones',
                'icon' => 'fa-umbrella-beach',
                'section' => 'rrhh',
                'route' => 'rh.vacaciones.index',
                'order' => 90
            ],
            [
                'name' => 'rrhh_finiquitos',
                'display_name' => 'Finiquitos y Liquidaciones',
                'icon' => 'fa-file-contract',
                'section' => 'rrhh',
                'route' => 'rh.finiquito.index',
                'order' => 91
            ],
            [
                'name' => 'rrhh_roles',
                'display_name' => 'Roles y Puestos',
                'icon' => 'fa-user-tag',
                'section' => 'rrhh',
                'route' => 'rh.roles',
                'order' => 92
            ],
            [
                'name' => 'rrhh_areas',
                'display_name' => 'Áreas y Departamentos',
                'icon' => 'fa-sitemap',
                'section' => 'rrhh',
                'route' => 'rh.areas',
                'order' => 93
            ],
            [
                'name' => 'rrhh_usuarios',
                'display_name' => 'Usuarios',
                'icon' => 'fa-clock',
                'section' => 'rrhh',
                'route' => 'rh.turnos',
                'order' => 94
            ],

            // ============================================================
            // INVENTARIOS / ALMACÉN
            // ============================================================
            [
                'name' => 'inv_almacenes',
                'display_name' => 'Catálogo de Almacenes',
                'icon' => 'fa-warehouse',
                'section' => 'inventarios',
                'route' => 'almacen.almacen',
                'order' => 100
            ],
            [
                'name' => 'inv_materiales',
                'display_name' => 'Catálogo de Materiales',
                'icon' => 'fa-box',
                'section' => 'inventarios',
                'route' => 'almacen.articulo',
                'order' => 101
            ],
            [
                'name' => 'inv_activos',
                'display_name' => 'Catálogo de Activos',
                'icon' => 'fa-tools',
                'section' => 'inventarios',
                'route' => 'almacen.activos',
                'order' => 102
            ],
            [
                'name' => 'inv_familias',
                'display_name' => 'Catálogo de Familias',
                'icon' => 'fa-book-open-reader',
                'section' => 'inventarios',
                'route' => 'almacen.familias',
                'order' => 103
            ],
            [
                'name' => 'inv_existencias',
                'display_name' => 'Existencias por Almacén',
                'icon' => 'fa-clipboard-list',
                'section' => 'inventarios',
                'route' => 'almacen.inventario',
                'order' => 104
            ],
            [
                'name' => 'inv_requisicion',
                'display_name' => 'Requisición',
                'icon' => 'fa-truck-fast',
                'section' => 'inventarios',
                'route' => 'almacen.requisicion',
                'order' => 105
            ],
            [
                'name' => 'inv_entradas',
                'display_name' => 'Entradas y Salidas',
                'icon' => 'fa-exchange-alt',
                'section' => 'inventarios',
                'route' => 'almacen.entrada',
                'order' => 106
            ],
            [
                'name' => 'inv_traspasos',
                'display_name' => 'Traspasos entre Almacenes',
                'icon' => 'fa-truck-moving',
                'section' => 'inventarios',
                'route' => 'almacen.traspasos',
                'order' => 107
            ],
            [
                'name' => 'inv_devoluciones',
                'display_name' => 'Requisiciones y Devoluciones',
                'icon' => 'fa-adjust',
                'section' => 'inventarios',
                'route' => 'almacen.requisiciones_devoluciones_equipo',
                'order' => 108
            ],

            // ============================================================
            // COMPRAS
            // ============================================================
            [
                'name' => 'compras_requisiciones',
                'display_name' => 'Requisiciones',
                'icon' => 'fa-clipboard-check',
                'section' => 'compras',
                'route' => 'compras.requisicion',
                'order' => 110
            ],
            [
                'name' => 'compras_autorizacion',
                'display_name' => 'Autorización de Requisiciones',
                'icon' => 'fa-square-check',
                'section' => 'compras',
                'route' => 'compras.autorizacion',
                'order' => 111
            ],
            [
                'name' => 'compras_ordenes',
                'display_name' => 'Órdenes de Compra',
                'icon' => 'fa-shopping-cart',
                'section' => 'compras',
                'route' => 'compras.ordenes',
                'order' => 112
            ],
            [
                'name' => 'compras_autorizacion_ordenes',
                'display_name' => 'Autorización de Órdenes de Compra',
                'icon' => 'fa-circle-check',
                'section' => 'compras',
                'route' => 'compras.autorizacion-cotizaciones',
                'order' => 113
            ],
            [
                'name' => 'compras_proveedores',
                'display_name' => 'Proveedores',
                'icon' => 'fa-handshake',
                'section' => 'compras',
                'route' => 'compras.gestion',
                'order' => 114
            ],
            [
                'name' => 'compras_almacen',
                'display_name' => 'Almacén por Obra',
                'icon' => 'fa-warehouse',
                'section' => 'compras',
                'route' => 'compras.almacen',
                'order' => 115
            ],
        ];

        foreach ($modules as $module) {
            ModuleConfig::updateOrCreate(
                ['name' => $module['name']],
                $module
            );
        }
    }
}