<?php

namespace Tests\Browser\Proyectos;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProyectoAltaBrowserTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $user;
    protected $responsable;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create(['estatus' => 'activo']);
        $this->responsable = User::factory()->create([
            'name' => 'Carlos Rodríguez',
            'estatus' => 'activo'
        ]);
    }

    /** @test */
    public function flujo_completo_de_alta()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/proyectos/alta')
                    ->waitFor('.card-header')
                    ->assertSee('Alta de Nuevo Proyecto')
                    
                    // Paso 1: Datos Generales
                    ->type('codigo', 'PRO-2025-DUSK')
                    ->type('nombre_proyecto', 'Torre Dusk Test')
                    ->select('tipo_proyecto', 'construccion')
                    ->select('prioridad', 'alta')
                    ->type('ubicacion', 'Monterrey, NL')
                    ->keys('#fecha_inicio', '2025-03-01')
                    ->keys('#fecha_fin', '2025-09-01')
                    
                    ->click('#btnSiguiente')
                    ->pause(500)
                    ->assertSeeIn('.tab-btn.active', 'Cliente y Contrato')
                    
                    // Paso 2: Cliente
                    ->type('cliente_nombre', 'Cliente Dusk SA')
                    ->type('cliente_rfc', 'CDU900101XYZ')
                    ->type('numero_contrato', 'CON-2025-DUSK')
                    
                    ->click('#btnSiguiente')
                    ->pause(500)
                    ->assertSeeIn('.tab-btn.active', 'Responsable y Equipo')
                    
                    // Paso 3: Responsable
                    ->select('responsable', $this->responsable->id)
                    
                    ->click('#btnSiguiente')
                    ->pause(500)
                    ->assertSeeIn('.tab-btn.active', 'Financiero')
                    
                    // Paso 4: Financiero
                    ->type('presupuesto_total', '10000000')
                    ->type('anticipo', '30')
                    ->type('margen', '20')
                    
                    ->click('#btnSiguiente')
                    ->pause(500)
                    ->assertSeeIn('.tab-btn.active', 'Documentos')
                    
                    // Paso 5: Guardar
                    ->click('#btnGuardar')
                    ->waitForText('Proyecto creado exitosamente', 10);
        });
    }
}