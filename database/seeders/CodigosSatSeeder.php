<?php
// database/seeders/CodigosSatSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CodigoSat;
use Illuminate\Support\Facades\DB;

class CodigosSatSeeder extends Seeder
{
    public function run()
    {
        // En PostgreSQL no necesitas desactivar foreign key checks
        // Solo usamos una transacción para mejor rendimiento
        
        DB::beginTransaction();
        
        try {
            // ========================================
            // TODOS LOS CÓDIGOS (igual que antes pero sin SET FOREIGN_KEY_CHECKS)
            // ========================================
            
            $todosLosCodigos = [
                // ACTIVO (1-249)
                ['id' => 1, 'codigo_agrupador' => '100', 'nivel' => 1, 'nombre_cuenta' => 'Activo', 'tipo' => 'A'],
                ['id' => 2, 'codigo_agrupador' => '100.01', 'nivel' => 1, 'nombre_cuenta' => 'Activo a corto plazo', 'tipo' => 'A'],
                ['id' => 3, 'codigo_agrupador' => '101', 'nivel' => 1, 'nombre_cuenta' => 'Caja', 'tipo' => 'A'],
                ['id' => 4, 'codigo_agrupador' => '101.01', 'nivel' => 2, 'nombre_cuenta' => 'Caja y efectivo', 'tipo' => 'A'],
                ['id' => 5, 'codigo_agrupador' => '102', 'nivel' => 1, 'nombre_cuenta' => 'Bancos', 'tipo' => 'A'],
                ['id' => 6, 'codigo_agrupador' => '102.01', 'nivel' => 2, 'nombre_cuenta' => 'Bancos nacionales', 'tipo' => 'A'],
                ['id' => 7, 'codigo_agrupador' => '102.02', 'nivel' => 2, 'nombre_cuenta' => 'Bancos extranjeros', 'tipo' => 'A'],
                ['id' => 8, 'codigo_agrupador' => '103', 'nivel' => 1, 'nombre_cuenta' => 'Inversiones', 'tipo' => 'A'],
                ['id' => 9, 'codigo_agrupador' => '103.01', 'nivel' => 2, 'nombre_cuenta' => 'Inversiones temporales', 'tipo' => 'A'],
                ['id' => 10, 'codigo_agrupador' => '103.02', 'nivel' => 2, 'nombre_cuenta' => 'Inversiones en fideicomisos', 'tipo' => 'A'],
                ['id' => 11, 'codigo_agrupador' => '103.03', 'nivel' => 2, 'nombre_cuenta' => 'Otras inversiones', 'tipo' => 'A'],
                ['id' => 12, 'codigo_agrupador' => '104', 'nivel' => 1, 'nombre_cuenta' => 'Otros instrumentos financieros', 'tipo' => 'A'],
                ['id' => 13, 'codigo_agrupador' => '104.01', 'nivel' => 2, 'nombre_cuenta' => 'Otros instrumentos financieros', 'tipo' => 'A'],
                ['id' => 14, 'codigo_agrupador' => '105', 'nivel' => 1, 'nombre_cuenta' => 'Clientes', 'tipo' => 'A'],
                ['id' => 15, 'codigo_agrupador' => '105.01', 'nivel' => 2, 'nombre_cuenta' => 'Clientes nacionales', 'tipo' => 'A'],
                ['id' => 16, 'codigo_agrupador' => '105.02', 'nivel' => 2, 'nombre_cuenta' => 'Clientes extranjeros', 'tipo' => 'A'],
                ['id' => 17, 'codigo_agrupador' => '105.03', 'nivel' => 2, 'nombre_cuenta' => 'Clientes nacionales parte relacionada', 'tipo' => 'A'],
                ['id' => 18, 'codigo_agrupador' => '105.04', 'nivel' => 2, 'nombre_cuenta' => 'Clientes extranjeros parte relacionada', 'tipo' => 'A'],
                ['id' => 19, 'codigo_agrupador' => '106', 'nivel' => 1, 'nombre_cuenta' => 'Cuentas y documentos por cobrar a corto plazo', 'tipo' => 'A'],
                ['id' => 20, 'codigo_agrupador' => '106.01', 'nivel' => 2, 'nombre_cuenta' => 'Cuentas y documentos por cobrar a corto plazo nacional', 'tipo' => 'A'],
                ['id' => 21, 'codigo_agrupador' => '106.02', 'nivel' => 2, 'nombre_cuenta' => 'Cuentas y documentos por cobrar a corto plazo extranjero', 'tipo' => 'A'],
                ['id' => 22, 'codigo_agrupador' => '106.03', 'nivel' => 2, 'nombre_cuenta' => 'Cuentas y documentos por cobrar a corto plazo nacional parte relacionada', 'tipo' => 'A'],
                ['id' => 23, 'codigo_agrupador' => '106.04', 'nivel' => 2, 'nombre_cuenta' => 'Cuentas y documentos por cobrar a corto plazo extranjero parte relacionada', 'tipo' => 'A'],
                ['id' => 24, 'codigo_agrupador' => '106.05', 'nivel' => 2, 'nombre_cuenta' => 'Intereses por cobrar a corto plazo nacional', 'tipo' => 'A'],
                ['id' => 25, 'codigo_agrupador' => '106.06', 'nivel' => 2, 'nombre_cuenta' => 'Intereses por cobrar a corto plazo extranjero', 'tipo' => 'A'],
                ['id' => 26, 'codigo_agrupador' => '106.07', 'nivel' => 2, 'nombre_cuenta' => 'Intereses por cobrar a corto plazo nacional parte relacionada', 'tipo' => 'A'],
                ['id' => 27, 'codigo_agrupador' => '106.08', 'nivel' => 2, 'nombre_cuenta' => 'Intereses por cobrar a corto plazo extranjero parte relacionada', 'tipo' => 'A'],
                ['id' => 28, 'codigo_agrupador' => '106.09', 'nivel' => 2, 'nombre_cuenta' => 'Otras cuentas y documentos por cobrar a corto plazo', 'tipo' => 'A'],
                ['id' => 29, 'codigo_agrupador' => '106.10', 'nivel' => 2, 'nombre_cuenta' => 'Otras cuentas y documentos por cobrar a corto plazo parte relacionada', 'tipo' => 'A'],
                ['id' => 30, 'codigo_agrupador' => '107', 'nivel' => 1, 'nombre_cuenta' => 'Deudores diversos', 'tipo' => 'A'],
                ['id' => 31, 'codigo_agrupador' => '107.01', 'nivel' => 2, 'nombre_cuenta' => 'Funcionarios y empleados', 'tipo' => 'A'],
                ['id' => 32, 'codigo_agrupador' => '107.02', 'nivel' => 2, 'nombre_cuenta' => 'Socios y accionistas', 'tipo' => 'A'],
                ['id' => 33, 'codigo_agrupador' => '107.03', 'nivel' => 2, 'nombre_cuenta' => 'Partes relacionadas nacionales', 'tipo' => 'A'],
                ['id' => 34, 'codigo_agrupador' => '107.04', 'nivel' => 2, 'nombre_cuenta' => 'Partes relacionadas extranjeros', 'tipo' => 'A'],
                ['id' => 35, 'codigo_agrupador' => '107.05', 'nivel' => 2, 'nombre_cuenta' => 'Otros deudores diversos', 'tipo' => 'A'],
                ['id' => 36, 'codigo_agrupador' => '108', 'nivel' => 1, 'nombre_cuenta' => 'Estimación de cuentas incobrables', 'tipo' => 'A'],
                ['id' => 37, 'codigo_agrupador' => '108.01', 'nivel' => 2, 'nombre_cuenta' => 'Estimación de cuentas incobrables nacional', 'tipo' => 'A'],
                ['id' => 38, 'codigo_agrupador' => '108.02', 'nivel' => 2, 'nombre_cuenta' => 'Estimación de cuentas incobrables extranjero', 'tipo' => 'A'],
                ['id' => 39, 'codigo_agrupador' => '108.03', 'nivel' => 2, 'nombre_cuenta' => 'Estimación de cuentas incobrables nacional parte relacionada', 'tipo' => 'A'],
                ['id' => 40, 'codigo_agrupador' => '108.04', 'nivel' => 2, 'nombre_cuenta' => 'Estimación de cuentas incobrables extranjero parte relacionada', 'tipo' => 'A'],
                ['id' => 41, 'codigo_agrupador' => '109', 'nivel' => 1, 'nombre_cuenta' => 'Pagos anticipados', 'tipo' => 'A'],
                ['id' => 42, 'codigo_agrupador' => '109.01', 'nivel' => 2, 'nombre_cuenta' => 'Seguros y fianzas pagados por anticipado nacional', 'tipo' => 'A'],
                ['id' => 43, 'codigo_agrupador' => '109.02', 'nivel' => 2, 'nombre_cuenta' => 'Seguros y fianzas pagados por anticipado extranjero', 'tipo' => 'A'],
                ['id' => 44, 'codigo_agrupador' => '109.03', 'nivel' => 2, 'nombre_cuenta' => 'Seguros y fianzas pagados por anticipado nacional parte relacionada', 'tipo' => 'A'],
                ['id' => 45, 'codigo_agrupador' => '109.04', 'nivel' => 2, 'nombre_cuenta' => 'Seguros y fianzas pagados por anticipado extranjero parte relacionada', 'tipo' => 'A'],
                ['id' => 46, 'codigo_agrupador' => '109.05', 'nivel' => 2, 'nombre_cuenta' => 'Rentas pagados por anticipado nacional', 'tipo' => 'A'],
                ['id' => 47, 'codigo_agrupador' => '109.06', 'nivel' => 2, 'nombre_cuenta' => 'Rentas pagados por anticipado extranjero', 'tipo' => 'A'],
                ['id' => 48, 'codigo_agrupador' => '109.07', 'nivel' => 2, 'nombre_cuenta' => 'Rentas pagados por anticipado nacional parte relacionada', 'tipo' => 'A'],
                ['id' => 49, 'codigo_agrupador' => '109.08', 'nivel' => 2, 'nombre_cuenta' => 'Rentas pagados por anticipado extranjero parte relacionada', 'tipo' => 'A'],
                ['id' => 50, 'codigo_agrupador' => '109.09', 'nivel' => 2, 'nombre_cuenta' => 'Intereses pagados por anticipado nacional', 'tipo' => 'A'],
                ['id' => 51, 'codigo_agrupador' => '109.10', 'nivel' => 2, 'nombre_cuenta' => 'Intereses pagados por anticipado extranjero', 'tipo' => 'A'],
                ['id' => 52, 'codigo_agrupador' => '109.11', 'nivel' => 2, 'nombre_cuenta' => 'Intereses pagados por anticipado nacional parte relacionada', 'tipo' => 'A'],
                ['id' => 53, 'codigo_agrupador' => '109.12', 'nivel' => 2, 'nombre_cuenta' => 'Intereses pagados por anticipado extranjero parte relacionada', 'tipo' => 'A'],
                ['id' => 54, 'codigo_agrupador' => '109.13', 'nivel' => 2, 'nombre_cuenta' => 'Factoraje financiero pagados por anticipado nacional', 'tipo' => 'A'],
                ['id' => 55, 'codigo_agrupador' => '109.14', 'nivel' => 2, 'nombre_cuenta' => 'Factoraje financiero pagados por anticipado extranjero', 'tipo' => 'A'],
                ['id' => 56, 'codigo_agrupador' => '109.15', 'nivel' => 2, 'nombre_cuenta' => 'Factoraje financiero pagados por anticipado nacional parte relacionada', 'tipo' => 'A'],
                ['id' => 57, 'codigo_agrupador' => '109.16', 'nivel' => 2, 'nombre_cuenta' => 'Factoraje financiero pagados por anticipado extranjero parte relacionada', 'tipo' => 'A'],
                ['id' => 58, 'codigo_agrupador' => '109.17', 'nivel' => 2, 'nombre_cuenta' => 'Arrendamiento financiero pagados por anticipado nacional', 'tipo' => 'A'],
                ['id' => 59, 'codigo_agrupador' => '109.18', 'nivel' => 2, 'nombre_cuenta' => 'Arrendamiento financiero pagados por anticipado extranjero', 'tipo' => 'A'],
                ['id' => 60, 'codigo_agrupador' => '109.19', 'nivel' => 2, 'nombre_cuenta' => 'Arrendamiento financiero pagados por anticipado nacional parte relacionada', 'tipo' => 'A'],
                ['id' => 61, 'codigo_agrupador' => '109.20', 'nivel' => 2, 'nombre_cuenta' => 'Arrendamiento financiero pagados por anticipado extranjero parte relacionada', 'tipo' => 'A'],
                ['id' => 62, 'codigo_agrupador' => '109.21', 'nivel' => 2, 'nombre_cuenta' => 'Pérdida por deterioro de pagos anticipados', 'tipo' => 'A'],
                ['id' => 63, 'codigo_agrupador' => '109.22', 'nivel' => 2, 'nombre_cuenta' => 'Derechos fiduciarios', 'tipo' => 'A'],
                ['id' => 64, 'codigo_agrupador' => '109.23', 'nivel' => 2, 'nombre_cuenta' => 'Otros pagos anticipados', 'tipo' => 'A'],
                ['id' => 65, 'codigo_agrupador' => '110', 'nivel' => 1, 'nombre_cuenta' => 'Subsidio al empleo por aplicar', 'tipo' => 'A'],
                ['id' => 66, 'codigo_agrupador' => '110.01', 'nivel' => 2, 'nombre_cuenta' => 'Subsidio al empleo por aplicar', 'tipo' => 'A'],
                ['id' => 67, 'codigo_agrupador' => '111', 'nivel' => 1, 'nombre_cuenta' => 'Crédito al diesel por acreditar', 'tipo' => 'A'],
                ['id' => 68, 'codigo_agrupador' => '111.01', 'nivel' => 2, 'nombre_cuenta' => 'Crédito al diesel por acreditar', 'tipo' => 'A'],
                ['id' => 69, 'codigo_agrupador' => '112', 'nivel' => 1, 'nombre_cuenta' => 'Otros estímulos', 'tipo' => 'A'],
                ['id' => 70, 'codigo_agrupador' => '112.01', 'nivel' => 2, 'nombre_cuenta' => 'Otros estímulos', 'tipo' => 'A'],
                ['id' => 71, 'codigo_agrupador' => '113', 'nivel' => 1, 'nombre_cuenta' => 'Impuestos a favor', 'tipo' => 'A'],
                ['id' => 72, 'codigo_agrupador' => '113.01', 'nivel' => 2, 'nombre_cuenta' => 'IVA a favor', 'tipo' => 'A'],
                ['id' => 73, 'codigo_agrupador' => '113.02', 'nivel' => 2, 'nombre_cuenta' => 'ISR a favor', 'tipo' => 'A'],
                ['id' => 74, 'codigo_agrupador' => '113.03', 'nivel' => 2, 'nombre_cuenta' => 'IETU a favor', 'tipo' => 'A'],
                ['id' => 75, 'codigo_agrupador' => '113.04', 'nivel' => 2, 'nombre_cuenta' => 'IDE a favor', 'tipo' => 'A'],
                ['id' => 76, 'codigo_agrupador' => '113.05', 'nivel' => 2, 'nombre_cuenta' => 'IA a favor', 'tipo' => 'A'],
                ['id' => 77, 'codigo_agrupador' => '113.06', 'nivel' => 2, 'nombre_cuenta' => 'Subsidio al empleo', 'tipo' => 'A'],
                ['id' => 78, 'codigo_agrupador' => '113.07', 'nivel' => 2, 'nombre_cuenta' => 'Pago de lo indebido', 'tipo' => 'A'],
                ['id' => 79, 'codigo_agrupador' => '113.08', 'nivel' => 2, 'nombre_cuenta' => 'Otros impuestos a favor', 'tipo' => 'A'],
                ['id' => 80, 'codigo_agrupador' => '114', 'nivel' => 1, 'nombre_cuenta' => 'Pagos provisionales', 'tipo' => 'A'],
                ['id' => 81, 'codigo_agrupador' => '114.01', 'nivel' => 2, 'nombre_cuenta' => 'Pagos provisionales de ISR', 'tipo' => 'A'],
                ['id' => 82, 'codigo_agrupador' => '115', 'nivel' => 1, 'nombre_cuenta' => 'Inventario', 'tipo' => 'A'],
                ['id' => 83, 'codigo_agrupador' => '115.01', 'nivel' => 2, 'nombre_cuenta' => 'Inventario', 'tipo' => 'A'],
                ['id' => 84, 'codigo_agrupador' => '115.02', 'nivel' => 2, 'nombre_cuenta' => 'Materia prima y materiales', 'tipo' => 'A'],
                ['id' => 85, 'codigo_agrupador' => '115.03', 'nivel' => 2, 'nombre_cuenta' => 'Producción en proceso', 'tipo' => 'A'],
                ['id' => 86, 'codigo_agrupador' => '115.04', 'nivel' => 2, 'nombre_cuenta' => 'Productos terminados', 'tipo' => 'A'],
                ['id' => 87, 'codigo_agrupador' => '115.05', 'nivel' => 2, 'nombre_cuenta' => 'Mercancías en tránsito', 'tipo' => 'A'],
                ['id' => 88, 'codigo_agrupador' => '115.06', 'nivel' => 2, 'nombre_cuenta' => 'Mercancías en poder de terceros', 'tipo' => 'A'],
                ['id' => 89, 'codigo_agrupador' => '115.07', 'nivel' => 2, 'nombre_cuenta' => 'Otros', 'tipo' => 'A'],
                ['id' => 90, 'codigo_agrupador' => '116', 'nivel' => 1, 'nombre_cuenta' => 'Estimación de inventarios obsoletos y de lento movimiento', 'tipo' => 'A'],
                ['id' => 91, 'codigo_agrupador' => '116.01', 'nivel' => 2, 'nombre_cuenta' => 'Estimación de inventarios obsoletos y de lento movimiento', 'tipo' => 'A'],
                ['id' => 92, 'codigo_agrupador' => '117', 'nivel' => 1, 'nombre_cuenta' => 'Obras en proceso de inmuebles', 'tipo' => 'A'],
                ['id' => 93, 'codigo_agrupador' => '117.01', 'nivel' => 2, 'nombre_cuenta' => 'Obras en proceso de inmuebles', 'tipo' => 'A'],
                ['id' => 94, 'codigo_agrupador' => '118', 'nivel' => 1, 'nombre_cuenta' => 'Impuestos acreditables pagados', 'tipo' => 'A'],
                ['id' => 95, 'codigo_agrupador' => '118.01', 'nivel' => 2, 'nombre_cuenta' => 'IVA acreditable pagado', 'tipo' => 'A'],
                ['id' => 96, 'codigo_agrupador' => '118.02', 'nivel' => 2, 'nombre_cuenta' => 'IVA acreditable de importación pagado', 'tipo' => 'A'],
                ['id' => 97, 'codigo_agrupador' => '118.03', 'nivel' => 2, 'nombre_cuenta' => 'IEPS acreditable pagado', 'tipo' => 'A'],
                ['id' => 98, 'codigo_agrupador' => '118.04', 'nivel' => 2, 'nombre_cuenta' => 'IEPS pagado en importación', 'tipo' => 'A'],
                ['id' => 99, 'codigo_agrupador' => '119', 'nivel' => 1, 'nombre_cuenta' => 'Impuestos acreditables por pagar', 'tipo' => 'A'],
                ['id' => 100, 'codigo_agrupador' => '119.01', 'nivel' => 2, 'nombre_cuenta' => 'IVA pendiente de pago', 'tipo' => 'A'],
                ['id' => 101, 'codigo_agrupador' => '119.02', 'nivel' => 2, 'nombre_cuenta' => 'IVA de importación pendiente de pago', 'tipo' => 'A'],
                ['id' => 102, 'codigo_agrupador' => '119.03', 'nivel' => 2, 'nombre_cuenta' => 'IEPS pendiente de pago', 'tipo' => 'A'],
                ['id' => 103, 'codigo_agrupador' => '119.04', 'nivel' => 2, 'nombre_cuenta' => 'IEPS pendiente de pago en importación', 'tipo' => 'A'],
                ['id' => 104, 'codigo_agrupador' => '120', 'nivel' => 1, 'nombre_cuenta' => 'Anticipo a proveedores', 'tipo' => 'A'],
                ['id' => 105, 'codigo_agrupador' => '120.01', 'nivel' => 2, 'nombre_cuenta' => 'Anticipo a proveedores nacional', 'tipo' => 'A'],
                ['id' => 106, 'codigo_agrupador' => '120.02', 'nivel' => 2, 'nombre_cuenta' => 'Anticipo a proveedores extranjero', 'tipo' => 'A'],
                ['id' => 107, 'codigo_agrupador' => '120.03', 'nivel' => 2, 'nombre_cuenta' => 'Anticipo a proveedores nacional parte relacionada', 'tipo' => 'A'],
                ['id' => 108, 'codigo_agrupador' => '120.04', 'nivel' => 2, 'nombre_cuenta' => 'Anticipo a proveedores extranjero parte relacionada', 'tipo' => 'A'],
                ['id' => 109, 'codigo_agrupador' => '121', 'nivel' => 1, 'nombre_cuenta' => 'Otros activos a corto plazo', 'tipo' => 'A'],
                ['id' => 110, 'codigo_agrupador' => '121.01', 'nivel' => 2, 'nombre_cuenta' => 'Otros activos a corto plazo', 'tipo' => 'A'],
                ['id' => 111, 'codigo_agrupador' => '100.02', 'nivel' => 1, 'nombre_cuenta' => 'Activo a largo plazo', 'tipo' => 'A'],
                ['id' => 112, 'codigo_agrupador' => '151', 'nivel' => 1, 'nombre_cuenta' => 'Terrenos', 'tipo' => 'A'],
                ['id' => 113, 'codigo_agrupador' => '151.01', 'nivel' => 2, 'nombre_cuenta' => 'Terrenos', 'tipo' => 'A'],
                ['id' => 114, 'codigo_agrupador' => '152', 'nivel' => 1, 'nombre_cuenta' => 'Edificios', 'tipo' => 'A'],
                ['id' => 115, 'codigo_agrupador' => '152.01', 'nivel' => 2, 'nombre_cuenta' => 'Edificios', 'tipo' => 'A'],
                ['id' => 116, 'codigo_agrupador' => '153', 'nivel' => 1, 'nombre_cuenta' => 'Maquinaria y equipo', 'tipo' => 'A'],
                ['id' => 117, 'codigo_agrupador' => '153.01', 'nivel' => 2, 'nombre_cuenta' => 'Maquinaria y equipo', 'tipo' => 'A'],
                ['id' => 118, 'codigo_agrupador' => '154', 'nivel' => 1, 'nombre_cuenta' => 'Automóviles, autobuses, camiones de carga, tractocamiones, montacargas y remolques', 'tipo' => 'A'],
                ['id' => 119, 'codigo_agrupador' => '154.01', 'nivel' => 2, 'nombre_cuenta' => 'Automóviles, autobuses, camiones de carga, tractocamiones, montacargas y remolques', 'tipo' => 'A'],
                ['id' => 120, 'codigo_agrupador' => '155', 'nivel' => 1, 'nombre_cuenta' => 'Mobiliario y equipo de oficina', 'tipo' => 'A'],
                ['id' => 121, 'codigo_agrupador' => '155.01', 'nivel' => 2, 'nombre_cuenta' => 'Mobiliario y equipo de oficina', 'tipo' => 'A'],
                ['id' => 122, 'codigo_agrupador' => '156', 'nivel' => 1, 'nombre_cuenta' => 'Equipo de cómputo', 'tipo' => 'A'],
                ['id' => 123, 'codigo_agrupador' => '156.01', 'nivel' => 2, 'nombre_cuenta' => 'Equipo de cómputo', 'tipo' => 'A'],
                ['id' => 124, 'codigo_agrupador' => '157', 'nivel' => 1, 'nombre_cuenta' => 'Equipo de comunicación', 'tipo' => 'A'],
                ['id' => 125, 'codigo_agrupador' => '157.01', 'nivel' => 2, 'nombre_cuenta' => 'Equipo de comunicación', 'tipo' => 'A'],
                ['id' => 126, 'codigo_agrupador' => '158', 'nivel' => 1, 'nombre_cuenta' => 'Activos biológicos, vegetales y semovientes', 'tipo' => 'A'],
                ['id' => 127, 'codigo_agrupador' => '158.01', 'nivel' => 2, 'nombre_cuenta' => 'Activos biológicos, vegetales y semovientes', 'tipo' => 'A'],
                ['id' => 128, 'codigo_agrupador' => '159', 'nivel' => 1, 'nombre_cuenta' => 'Obras en proceso de activos fijos', 'tipo' => 'A'],
                ['id' => 129, 'codigo_agrupador' => '159.01', 'nivel' => 2, 'nombre_cuenta' => 'Obras en proceso de activos fijos', 'tipo' => 'A'],
                ['id' => 130, 'codigo_agrupador' => '160', 'nivel' => 1, 'nombre_cuenta' => 'Otros activos fijos', 'tipo' => 'A'],
                ['id' => 131, 'codigo_agrupador' => '160.01', 'nivel' => 2, 'nombre_cuenta' => 'Otros activos fijos', 'tipo' => 'A'],
                ['id' => 132, 'codigo_agrupador' => '161', 'nivel' => 1, 'nombre_cuenta' => 'Ferrocarriles', 'tipo' => 'A'],
                ['id' => 133, 'codigo_agrupador' => '161.01', 'nivel' => 2, 'nombre_cuenta' => 'Ferrocarriles', 'tipo' => 'A'],
                ['id' => 134, 'codigo_agrupador' => '162', 'nivel' => 1, 'nombre_cuenta' => 'Embarcaciones', 'tipo' => 'A'],
                ['id' => 135, 'codigo_agrupador' => '162.01', 'nivel' => 2, 'nombre_cuenta' => 'Embarcaciones', 'tipo' => 'A'],
                ['id' => 136, 'codigo_agrupador' => '163', 'nivel' => 1, 'nombre_cuenta' => 'Aviones', 'tipo' => 'A'],
                ['id' => 137, 'codigo_agrupador' => '163.01', 'nivel' => 2, 'nombre_cuenta' => 'Aviones', 'tipo' => 'A'],
                ['id' => 138, 'codigo_agrupador' => '164', 'nivel' => 1, 'nombre_cuenta' => 'Troqueles, moldes, matrices y herramental', 'tipo' => 'A'],
                ['id' => 139, 'codigo_agrupador' => '164.01', 'nivel' => 2, 'nombre_cuenta' => 'Troqueles, moldes, matrices y herramental', 'tipo' => 'A'],
                ['id' => 140, 'codigo_agrupador' => '165', 'nivel' => 1, 'nombre_cuenta' => 'Equipo de comunicaciones telefónicas', 'tipo' => 'A'],
                ['id' => 141, 'codigo_agrupador' => '165.01', 'nivel' => 2, 'nombre_cuenta' => 'Equipo de comunicaciones telefónicas', 'tipo' => 'A'],
                ['id' => 142, 'codigo_agrupador' => '166', 'nivel' => 1, 'nombre_cuenta' => 'Equipo de comunicación satelital', 'tipo' => 'A'],
                ['id' => 143, 'codigo_agrupador' => '166.01', 'nivel' => 2, 'nombre_cuenta' => 'Equipo de comunicación satelital', 'tipo' => 'A'],
                ['id' => 144, 'codigo_agrupador' => '167', 'nivel' => 1, 'nombre_cuenta' => 'Equipo de adaptaciones para personas con capacidades diferentes', 'tipo' => 'A'],
                ['id' => 145, 'codigo_agrupador' => '167.01', 'nivel' => 2, 'nombre_cuenta' => 'Equipo de adaptaciones para personas con capacidades diferentes', 'tipo' => 'A'],
                ['id' => 146, 'codigo_agrupador' => '168', 'nivel' => 1, 'nombre_cuenta' => 'Maquinaria y equipo de generación de energía de fuentes renovables o de sistemas de cogeneración de electricidad eficiente', 'tipo' => 'A'],
                ['id' => 147, 'codigo_agrupador' => '168.01', 'nivel' => 2, 'nombre_cuenta' => 'Maquinaria y equipo de generación de energía de fuentes renovables o de sistemas de cogeneración de electricidad eficiente', 'tipo' => 'A'],
                ['id' => 148, 'codigo_agrupador' => '169', 'nivel' => 1, 'nombre_cuenta' => 'Otra maquinaria y equipo', 'tipo' => 'A'],
                ['id' => 149, 'codigo_agrupador' => '169.01', 'nivel' => 2, 'nombre_cuenta' => 'Otra maquinaria y equipo', 'tipo' => 'A'],
                ['id' => 150, 'codigo_agrupador' => '170', 'nivel' => 1, 'nombre_cuenta' => 'Adaptaciones y mejoras', 'tipo' => 'A'],
                ['id' => 151, 'codigo_agrupador' => '170.01', 'nivel' => 2, 'nombre_cuenta' => 'Adaptaciones y mejoras', 'tipo' => 'A'],
                ['id' => 152, 'codigo_agrupador' => '171', 'nivel' => 1, 'nombre_cuenta' => 'Depreciación acumulada de activos fijos', 'tipo' => 'A'],
                ['id' => 153, 'codigo_agrupador' => '171.01', 'nivel' => 2, 'nombre_cuenta' => 'Depreciación acumulada de edificios', 'tipo' => 'A'],
                ['id' => 154, 'codigo_agrupador' => '171.02', 'nivel' => 2, 'nombre_cuenta' => 'Depreciación acumulada de maquinaria y equipo', 'tipo' => 'A'],
                ['id' => 155, 'codigo_agrupador' => '171.03', 'nivel' => 2, 'nombre_cuenta' => 'Depreciación acumulada de automóviles, autobuses, camiones de carga, tractocamiones, montacargas y remolques', 'tipo' => 'A'],
                ['id' => 156, 'codigo_agrupador' => '171.04', 'nivel' => 2, 'nombre_cuenta' => 'Depreciación acumulada de mobiliario y equipo de oficina', 'tipo' => 'A'],
                ['id' => 157, 'codigo_agrupador' => '171.05', 'nivel' => 2, 'nombre_cuenta' => 'Depreciación acumulada de equipo de cómputo', 'tipo' => 'A'],
                ['id' => 158, 'codigo_agrupador' => '171.06', 'nivel' => 2, 'nombre_cuenta' => 'Depreciación acumulada de equipo de comunicación', 'tipo' => 'A'],
                ['id' => 159, 'codigo_agrupador' => '171.07', 'nivel' => 2, 'nombre_cuenta' => 'Depreciación acumulada de activos biológicos, vegetales y semovientes', 'tipo' => 'A'],
                ['id' => 160, 'codigo_agrupador' => '171.08', 'nivel' => 2, 'nombre_cuenta' => 'Depreciación acumulada de otros activos fijos', 'tipo' => 'A'],
                ['id' => 161, 'codigo_agrupador' => '171.09', 'nivel' => 2, 'nombre_cuenta' => 'Depreciación acumulada de ferrocarriles', 'tipo' => 'A'],
                ['id' => 162, 'codigo_agrupador' => '171.10', 'nivel' => 2, 'nombre_cuenta' => 'Depreciación acumulada de embarcaciones', 'tipo' => 'A'],
                ['id' => 163, 'codigo_agrupador' => '171.11', 'nivel' => 2, 'nombre_cuenta' => 'Depreciación acumulada de aviones', 'tipo' => 'A'],
                ['id' => 164, 'codigo_agrupador' => '171.12', 'nivel' => 2, 'nombre_cuenta' => 'Depreciación acumulada de troqueles, moldes, matrices y herramental', 'tipo' => 'A'],
                ['id' => 165, 'codigo_agrupador' => '171.13', 'nivel' => 2, 'nombre_cuenta' => 'Depreciación acumulada de equipo de comunicaciones telefónicas', 'tipo' => 'A'],
                ['id' => 166, 'codigo_agrupador' => '171.14', 'nivel' => 2, 'nombre_cuenta' => 'Depreciación acumulada de equipo de comunicación satelital', 'tipo' => 'A'],
                ['id' => 167, 'codigo_agrupador' => '171.15', 'nivel' => 2, 'nombre_cuenta' => 'Depreciación acumulada de equipo de adaptaciones para personas con capacidades diferentes', 'tipo' => 'A'],
                ['id' => 168, 'codigo_agrupador' => '171.16', 'nivel' => 2, 'nombre_cuenta' => 'Depreciación acumulada de maquinaria y equipo de generación de energía de fuentes renovables o de sistemas de cogeneración de electricidad eficiente', 'tipo' => 'A'],
                ['id' => 169, 'codigo_agrupador' => '171.17', 'nivel' => 2, 'nombre_cuenta' => 'Depreciación acumulada de adaptaciones y mejoras', 'tipo' => 'A'],
                ['id' => 170, 'codigo_agrupador' => '171.18', 'nivel' => 2, 'nombre_cuenta' => 'Depreciación acumulada de otra maquinaria y equipo', 'tipo' => 'A'],
                ['id' => 171, 'codigo_agrupador' => '172', 'nivel' => 1, 'nombre_cuenta' => 'Pérdida por deterioro acumulado de activos fijos', 'tipo' => 'A'],
                ['id' => 172, 'codigo_agrupador' => '172.01', 'nivel' => 2, 'nombre_cuenta' => 'Pérdida por deterioro acumulado de edificios', 'tipo' => 'A'],
                ['id' => 173, 'codigo_agrupador' => '172.02', 'nivel' => 2, 'nombre_cuenta' => 'Pérdida por deterioro acumulado de maquinaria y equipo', 'tipo' => 'A'],
                ['id' => 174, 'codigo_agrupador' => '172.03', 'nivel' => 2, 'nombre_cuenta' => 'Pérdida por deterioro acumulado de automóviles, autobuses, camiones de carga, tractocamiones, montacargas y remolques', 'tipo' => 'A'],
                ['id' => 175, 'codigo_agrupador' => '172.04', 'nivel' => 2, 'nombre_cuenta' => 'Pérdida por deterioro acumulado de mobiliario y equipo de oficina', 'tipo' => 'A'],
                ['id' => 176, 'codigo_agrupador' => '172.05', 'nivel' => 2, 'nombre_cuenta' => 'Pérdida por deterioro acumulado de equipo de cómputo', 'tipo' => 'A'],
                ['id' => 177, 'codigo_agrupador' => '172.06', 'nivel' => 2, 'nombre_cuenta' => 'Pérdida por deterioro acumulado de equipo de comunicación', 'tipo' => 'A'],
                ['id' => 178, 'codigo_agrupador' => '172.07', 'nivel' => 2, 'nombre_cuenta' => 'Pérdida por deterioro acumulado de activos biológicos, vegetales y semovientes', 'tipo' => 'A'],
                ['id' => 179, 'codigo_agrupador' => '172.08', 'nivel' => 2, 'nombre_cuenta' => 'Pérdida por deterioro acumulado de otros activos fijos', 'tipo' => 'A'],
                ['id' => 180, 'codigo_agrupador' => '172.09', 'nivel' => 2, 'nombre_cuenta' => 'Pérdida por deterioro acumulado de ferrocarriles', 'tipo' => 'A'],
                ['id' => 181, 'codigo_agrupador' => '172.10', 'nivel' => 2, 'nombre_cuenta' => 'Pérdida por deterioro acumulado de embarcaciones', 'tipo' => 'A'],
                ['id' => 182, 'codigo_agrupador' => '172.11', 'nivel' => 2, 'nombre_cuenta' => 'Pérdida por deterioro acumulado de aviones', 'tipo' => 'A'],
                ['id' => 183, 'codigo_agrupador' => '172.12', 'nivel' => 2, 'nombre_cuenta' => 'Pérdida por deterioro acumulado de troqueles, moldes, matrices y herramental', 'tipo' => 'A'],
                ['id' => 184, 'codigo_agrupador' => '172.13', 'nivel' => 2, 'nombre_cuenta' => 'Pérdida por deterioro acumulado de equipo de comunicaciones telefónicas', 'tipo' => 'A'],
                ['id' => 185, 'codigo_agrupador' => '172.14', 'nivel' => 2, 'nombre_cuenta' => 'Pérdida por deterioro acumulado de equipo de comunicación satelital', 'tipo' => 'A'],
                ['id' => 186, 'codigo_agrupador' => '172.15', 'nivel' => 2, 'nombre_cuenta' => 'Pérdida por deterioro acumulado de equipo de adaptaciones para personas con capacidades diferentes', 'tipo' => 'A'],
                ['id' => 187, 'codigo_agrupador' => '172.16', 'nivel' => 2, 'nombre_cuenta' => 'Pérdida por deterioro acumulado de maquinaria y equipo de generación de energía de fuentes renovables o de sistemas de cogeneración de electricidad eficiente', 'tipo' => 'A'],
                ['id' => 188, 'codigo_agrupador' => '172.17', 'nivel' => 2, 'nombre_cuenta' => 'Pérdida por deterioro acumulado de adaptaciones y mejoras', 'tipo' => 'A'],
                ['id' => 189, 'codigo_agrupador' => '172.18', 'nivel' => 2, 'nombre_cuenta' => 'Pérdida por deterioro acumulado de otra maquinaria y equipo', 'tipo' => 'A'],
                ['id' => 190, 'codigo_agrupador' => '173', 'nivel' => 1, 'nombre_cuenta' => 'Gastos diferidos', 'tipo' => 'A'],
                ['id' => 191, 'codigo_agrupador' => '173.01', 'nivel' => 2, 'nombre_cuenta' => 'Gastos diferidos', 'tipo' => 'A'],
                ['id' => 192, 'codigo_agrupador' => '174', 'nivel' => 1, 'nombre_cuenta' => 'Gastos pre operativos', 'tipo' => 'A'],
                ['id' => 193, 'codigo_agrupador' => '174.01', 'nivel' => 2, 'nombre_cuenta' => 'Gastos pre operativos', 'tipo' => 'A'],
                ['id' => 194, 'codigo_agrupador' => '175', 'nivel' => 1, 'nombre_cuenta' => 'Regalías, asistencia técnica y otros gastos diferidos', 'tipo' => 'A'],
                ['id' => 195, 'codigo_agrupador' => '175.01', 'nivel' => 2, 'nombre_cuenta' => 'Regalías, asistencia técnica y otros gastos diferidos', 'tipo' => 'A'],
                ['id' => 196, 'codigo_agrupador' => '176', 'nivel' => 1, 'nombre_cuenta' => 'Activos intangibles', 'tipo' => 'A'],
                ['id' => 197, 'codigo_agrupador' => '176.01', 'nivel' => 2, 'nombre_cuenta' => 'Activos intangibles', 'tipo' => 'A'],
                ['id' => 198, 'codigo_agrupador' => '177', 'nivel' => 1, 'nombre_cuenta' => 'Gastos de organización', 'tipo' => 'A'],
                ['id' => 199, 'codigo_agrupador' => '177.01', 'nivel' => 2, 'nombre_cuenta' => 'Gastos de organización', 'tipo' => 'A'],
                ['id' => 200, 'codigo_agrupador' => '178', 'nivel' => 1, 'nombre_cuenta' => 'Investigación y desarrollo de mercado', 'tipo' => 'A'],
                ['id' => 201, 'codigo_agrupador' => '178.01', 'nivel' => 2, 'nombre_cuenta' => 'Investigación y desarrollo de mercado', 'tipo' => 'A'],
                ['id' => 202, 'codigo_agrupador' => '179', 'nivel' => 1, 'nombre_cuenta' => 'Marcas y patentes', 'tipo' => 'A'],
                ['id' => 203, 'codigo_agrupador' => '179.01', 'nivel' => 2, 'nombre_cuenta' => 'Marcas y patentes', 'tipo' => 'A'],
                ['id' => 204, 'codigo_agrupador' => '180', 'nivel' => 1, 'nombre_cuenta' => 'Crédito mercantil', 'tipo' => 'A'],
                ['id' => 205, 'codigo_agrupador' => '180.01', 'nivel' => 2, 'nombre_cuenta' => 'Crédito mercantil', 'tipo' => 'A'],
                ['id' => 206, 'codigo_agrupador' => '181', 'nivel' => 1, 'nombre_cuenta' => 'Gastos de instalación', 'tipo' => 'A'],
                ['id' => 207, 'codigo_agrupador' => '181.01', 'nivel' => 2, 'nombre_cuenta' => 'Gastos de instalación', 'tipo' => 'A'],
                ['id' => 208, 'codigo_agrupador' => '182', 'nivel' => 1, 'nombre_cuenta' => 'Otros activos diferidos', 'tipo' => 'A'],
                ['id' => 209, 'codigo_agrupador' => '182.01', 'nivel' => 2, 'nombre_cuenta' => 'Otros activos diferidos', 'tipo' => 'A'],
                ['id' => 210, 'codigo_agrupador' => '183', 'nivel' => 1, 'nombre_cuenta' => 'Amortización acumulada de activos diferidos', 'tipo' => 'A'],
                ['id' => 211, 'codigo_agrupador' => '183.01', 'nivel' => 2, 'nombre_cuenta' => 'Amortización acumulada de gastos diferidos', 'tipo' => 'A'],
                ['id' => 212, 'codigo_agrupador' => '183.02', 'nivel' => 2, 'nombre_cuenta' => 'Amortización acumulada de gastos pre operativos', 'tipo' => 'A'],
                ['id' => 213, 'codigo_agrupador' => '183.03', 'nivel' => 2, 'nombre_cuenta' => 'Amortización acumulada de regalías, asistencia técnica y otros gastos diferidos', 'tipo' => 'A'],
                ['id' => 214, 'codigo_agrupador' => '183.04', 'nivel' => 2, 'nombre_cuenta' => 'Amortización acumulada de activos intangibles', 'tipo' => 'A'],
                ['id' => 215, 'codigo_agrupador' => '183.05', 'nivel' => 2, 'nombre_cuenta' => 'Amortización acumulada de gastos de organización', 'tipo' => 'A'],
                ['id' => 216, 'codigo_agrupador' => '183.06', 'nivel' => 2, 'nombre_cuenta' => 'Amortización acumulada de investigación y desarrollo de mercado', 'tipo' => 'A'],
                ['id' => 217, 'codigo_agrupador' => '183.07', 'nivel' => 2, 'nombre_cuenta' => 'Amortización acumulada de marcas y patentes', 'tipo' => 'A'],
                ['id' => 218, 'codigo_agrupador' => '183.08', 'nivel' => 2, 'nombre_cuenta' => 'Amortización acumulada de crédito mercantil', 'tipo' => 'A'],
                ['id' => 219, 'codigo_agrupador' => '183.09', 'nivel' => 2, 'nombre_cuenta' => 'Amortización acumulada de gastos de instalación', 'tipo' => 'A'],
                ['id' => 220, 'codigo_agrupador' => '183.10', 'nivel' => 2, 'nombre_cuenta' => 'Amortización acumulada de otros activos diferidos', 'tipo' => 'A'],
                ['id' => 221, 'codigo_agrupador' => '184', 'nivel' => 1, 'nombre_cuenta' => 'Depósitos en garantía', 'tipo' => 'A'],
                ['id' => 222, 'codigo_agrupador' => '184.01', 'nivel' => 2, 'nombre_cuenta' => 'Depósitos de fianzas', 'tipo' => 'A'],
                ['id' => 223, 'codigo_agrupador' => '184.02', 'nivel' => 2, 'nombre_cuenta' => 'Depósitos de arrendamiento de bienes inmuebles', 'tipo' => 'A'],
                ['id' => 224, 'codigo_agrupador' => '184.03', 'nivel' => 2, 'nombre_cuenta' => 'Otros depósitos en garantía', 'tipo' => 'A'],
                ['id' => 225, 'codigo_agrupador' => '185', 'nivel' => 1, 'nombre_cuenta' => 'Impuestos diferidos', 'tipo' => 'A'],
                ['id' => 226, 'codigo_agrupador' => '185.01', 'nivel' => 2, 'nombre_cuenta' => 'Impuestos diferidos ISR', 'tipo' => 'A'],
                ['id' => 227, 'codigo_agrupador' => '186', 'nivel' => 1, 'nombre_cuenta' => 'Cuentas y documentos por cobrar a largo plazo', 'tipo' => 'A'],
                ['id' => 228, 'codigo_agrupador' => '186.01', 'nivel' => 2, 'nombre_cuenta' => 'Cuentas y documentos por cobrar a largo plazo nacional', 'tipo' => 'A'],
                ['id' => 229, 'codigo_agrupador' => '186.02', 'nivel' => 2, 'nombre_cuenta' => 'Cuentas y documentos por cobrar a largo plazo extranjero', 'tipo' => 'A'],
                ['id' => 230, 'codigo_agrupador' => '186.03', 'nivel' => 2, 'nombre_cuenta' => 'Cuentas y documentos por cobrar a largo plazo nacional parte relacionada', 'tipo' => 'A'],
                ['id' => 231, 'codigo_agrupador' => '186.04', 'nivel' => 2, 'nombre_cuenta' => 'Cuentas y documentos por cobrar a largo plazo extranjero parte relacionada', 'tipo' => 'A'],
                ['id' => 232, 'codigo_agrupador' => '186.05', 'nivel' => 2, 'nombre_cuenta' => 'Intereses por cobrar a largo plazo nacional', 'tipo' => 'A'],
                ['id' => 233, 'codigo_agrupador' => '186.06', 'nivel' => 2, 'nombre_cuenta' => 'Intereses por cobrar a largo plazo extranjero', 'tipo' => 'A'],
                ['id' => 234, 'codigo_agrupador' => '186.07', 'nivel' => 2, 'nombre_cuenta' => 'Intereses por cobrar a largo plazo nacional parte relacionada', 'tipo' => 'A'],
                ['id' => 235, 'codigo_agrupador' => '186.08', 'nivel' => 2, 'nombre_cuenta' => 'Intereses por cobrar a largo plazo extranjero parte relacionada', 'tipo' => 'A'],
                ['id' => 236, 'codigo_agrupador' => '186.09', 'nivel' => 2, 'nombre_cuenta' => 'Otras cuentas y documentos por cobrar a largo plazo', 'tipo' => 'A'],
                ['id' => 237, 'codigo_agrupador' => '186.10', 'nivel' => 2, 'nombre_cuenta' => 'Otras cuentas y documentos por cobrar a largo plazo parte relacionada', 'tipo' => 'A'],
                ['id' => 238, 'codigo_agrupador' => '187', 'nivel' => 1, 'nombre_cuenta' => 'Participación de los trabajadores en las utilidades diferidas', 'tipo' => 'A'],
                ['id' => 239, 'codigo_agrupador' => '187.01', 'nivel' => 2, 'nombre_cuenta' => 'Participación de los trabajadores en las utilidades diferidas', 'tipo' => 'A'],
                ['id' => 240, 'codigo_agrupador' => '188', 'nivel' => 1, 'nombre_cuenta' => 'Inversiones permanentes en acciones', 'tipo' => 'A'],
                ['id' => 241, 'codigo_agrupador' => '188.01', 'nivel' => 2, 'nombre_cuenta' => 'Inversiones a largo plazo en subsidiarias', 'tipo' => 'A'],
                ['id' => 242, 'codigo_agrupador' => '188.02', 'nivel' => 2, 'nombre_cuenta' => 'Inversiones a largo plazo en asociadas', 'tipo' => 'A'],
                ['id' => 243, 'codigo_agrupador' => '188.03', 'nivel' => 2, 'nombre_cuenta' => 'Otras inversiones permanentes en acciones', 'tipo' => 'A'],
                ['id' => 244, 'codigo_agrupador' => '189', 'nivel' => 1, 'nombre_cuenta' => 'Estimación por deterioro de inversiones permanentes en acciones', 'tipo' => 'A'],
                ['id' => 245, 'codigo_agrupador' => '189.01', 'nivel' => 2, 'nombre_cuenta' => 'Estimación por deterioro de inversiones permanentes en acciones', 'tipo' => 'A'],
                ['id' => 246, 'codigo_agrupador' => '190', 'nivel' => 1, 'nombre_cuenta' => 'Otros instrumentos financieros', 'tipo' => 'A'],
                ['id' => 247, 'codigo_agrupador' => '190.01', 'nivel' => 2, 'nombre_cuenta' => 'Otros instrumentos financieros', 'tipo' => 'A'],
                ['id' => 248, 'codigo_agrupador' => '191', 'nivel' => 1, 'nombre_cuenta' => 'Otros activos a largo plazo', 'tipo' => 'A'],
                ['id' => 249, 'codigo_agrupador' => '191.01', 'nivel' => 2, 'nombre_cuenta' => 'Otros activos a largo plazo', 'tipo' => 'A'],
                
                // PASIVO (250-418) - Continúa con el resto de tus códigos
                // Por brevedad, aquí van el resto... pero mantendré la estructura completa
            ];
            
            // NOTA: Por la longitud del mensaje, no puedo incluir todos los 592 registros aquí
            // Pero el seeder original que te di en el mensaje anterior ya los tiene todos
            // Solo cambia las líneas 12-15 por estas:
            
            // En lugar de:
            // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            // CodigoSat::truncate();
            
            // Usa esto:
            DB::beginTransaction();
            
            try {
                foreach ($todosLosCodigos as $codigo) {
                    CodigoSat::updateOrCreate(
                        ['id' => $codigo['id']],
                        [
                            'codigo_agrupador' => $codigo['codigo_agrupador'],
                            'nivel' => $codigo['nivel'],
                            'nombre_cuenta' => $codigo['nombre_cuenta'],
                            'tipo' => $codigo['tipo']
                        ]
                    );
                }
                
                DB::commit();
                
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}