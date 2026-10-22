<?php

namespace App\Console\Commands;

use App\Models\Facturacion\Factura;
use App\Http\Controllers\Facturacion\TimbradoController;
use Illuminate\Console\Command;

class SincronizarEstatusFacturas extends Command
{
    protected $signature = 'facturas:sincronizar-estatus {--dias=30}';
    protected $description = 'Consulta el estatus SAT de facturas recientes y actualiza la BD';

    public function handle()
    {
        $dias = (int) $this->option('dias');
        $facturas = Factura::whereIn('estatus', [19, 21])
            ->where('updated_at', '>=', now()->subDays($dias))
            ->limit(100)
            ->get();

        $this->info("Revisando {$facturas->count()} facturas...");

        $timbrado = app(TimbradoController::class);
        $actualizados = 0;
        $errores = 0;

        foreach ($facturas as $factura) {
            $r = $timbrado->consultarEstatusFactura($factura);
            if ($r['success'] && $r['actualizado']) {
                $actualizados++;
                $this->line("  #{$factura->factura_id} → {$r['estatus_nuevo']}");
            } elseif (!$r['success']) {
                $errores++;
                $this->error("  #{$factura->factura_id}: {$r['error']}");
            }
        }

        $this->info("Listo. Actualizadas: {$actualizados}. Errores: {$errores}.");
        return 0;
    }
}