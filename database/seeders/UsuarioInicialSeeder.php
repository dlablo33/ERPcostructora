<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UsuarioInicialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar si el usuario ya existe para no duplicarlo
        $usuarioExistente = User::where('email', 'admin@admin.com')->first();
        
        if (!$usuarioExistente) {
            User::create([
                'name' => 'César Saucedo',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
                'email_verified_at' => Carbon::now(), // Email verificado
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            
            $this->command->info('✅ Usuario César Saucedo creado exitosamente!');
        } else {
            $this->command->info('⚠️ El usuario ya existe en la base de datos.');
        }
    }
}