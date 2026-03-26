<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Verificar si la columna folio existe antes de crearla
            if (!Schema::hasColumn('users', 'folio')) {
                $table->string('folio', 50)->nullable()->after('id');
            }
            
            // Verificar si la columna empleado existe
            if (!Schema::hasColumn('users', 'empleado')) {
                $table->string('empleado', 255)->nullable()->after('name');
            }
            
            // Verificar si la columna rol existe
            if (!Schema::hasColumn('users', 'rol')) {
                $table->string('rol', 100)->default('Usuario')->after('empleado');
            }
            
            // Verificar si la columna estatus existe
            if (!Schema::hasColumn('users', 'estatus')) {
                $table->string('estatus', 20)->default('Activo')->after('rol');
            }
            
            // Índices - verificar si existen antes de crearlos
            $indexes = $this->getIndexes('users');
            
            if (!in_array('users_folio_index', $indexes)) {
                $table->index('folio');
            }
            
            if (!in_array('users_rol_index', $indexes)) {
                $table->index('rol');
            }
            
            if (!in_array('users_estatus_index', $indexes)) {
                $table->index('estatus');
            }
        });
    }
    
    private function getIndexes($table)
    {
        $conn = Schema::getConnection();
        
        $results = $conn->select("
            SELECT indexname 
            FROM pg_indexes 
            WHERE tablename = '$table'
        ");
        
        return array_column($results, 'indexname');
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['folio']);
            $table->dropIndex(['rol']);
            $table->dropIndex(['estatus']);
            $table->dropColumn(['folio', 'empleado', 'rol', 'estatus']);
        });
    }
};