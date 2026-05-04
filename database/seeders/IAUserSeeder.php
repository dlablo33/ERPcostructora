<?php
// database/seeders/IAUserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class IAUserSeeder extends Seeder
{
    public function run()
    {
        // Crear usuario IA con los campos REALES de tu tabla
        $user = User::updateOrCreate(
            ['email' => 'ia@mejorasoft.com'],
            [
                'name' => 'Asistente IA',
                'password' => Hash::make('no_needed_' . uniqid()),
                'estatus' => 'Activo',  // ← es 'estatus', no 'estado'
                'rol' => 'asistente',   // Opcional: asignar un rol
                // No incluyas is_ai, ai_model, ni estado
            ]
        );
        
        $this->command->info("✅ Usuario IA creado/actualizado correctamente");
        $this->command->info("📧 Email: {$user->email}");
        $this->command->info("👤 Nombre: {$user->name}");
        $this->command->info("🆔 ID: {$user->id}");
        $this->command->info("📊 Estatus: {$user->estatus}");
    }
}