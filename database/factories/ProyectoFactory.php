<?php

namespace Database\Factories;

use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProyectoFactory extends Factory
{
    protected $model = Proyecto::class;

    public function definition(): array
    {
        return [
            'codigo' => 'PRO-' . date('Y') . '-' . str_pad(fake()->unique()->numberBetween(1, 999), 3, '0', STR_PAD_LEFT),
            'nombre' => fake()->sentence(3),
            'tipo_proyecto' => fake()->randomElement(['construccion', 'infraestructura', 'industrial', 'comercial']),
            'categoria' => fake()->randomElement(['obra_nueva', 'remodelacion', 'ampliacion']),
            'prioridad' => fake()->randomElement(['alta', 'media', 'baja']),
            'ubicacion' => fake()->city(),
            'direccion' => fake()->address(),
            'fecha_inicio' => fake()->date(),
            'fecha_fin' => fake()->dateTimeBetween('+1 month', '+1 year')->format('Y-m-d'),
            'descripcion' => fake()->paragraph(),
            'estado' => fake()->randomElement(['pendiente', 'en_curso', 'activo']),
            'moneda' => 'MXN',
            'tipo_cambio' => 1.00,
            'cliente_nombre' => fake()->company(),
            'cliente_rfc' => strtoupper(fake()->bothify('???######??')),
            'cliente_email' => fake()->companyEmail(),
            'numero_contrato' => 'CON-' . date('Y') . '-' . fake()->unique()->numberBetween(1, 999),
            'responsable_id' => User::factory(),
            'presupuesto_total' => fake()->randomFloat(2, 100000, 10000000),
            'status' => 'activo',
            'created_by' => User::factory(),
        ];
    }
}