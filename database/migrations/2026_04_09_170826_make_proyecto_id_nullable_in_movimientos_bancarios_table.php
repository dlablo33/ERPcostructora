<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('movimientos_bancarios', function (Blueprint $table) {
            // 1. Eliminar la foreign key existente
            $table->dropForeign(['proyecto_id']);
            
            // 2. Eliminar el índice si existe
            $table->dropIndex(['proyecto_id', 'fecha']);
            
            // 3. Modificar la columna a nullable
            $table->foreignId('proyecto_id')->nullable()->change();
            
            // 4. Volver a crear la foreign key con onDelete set null
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onDelete('set null');
            
            // 5. Volver a crear el índice
            $table->index(['proyecto_id', 'fecha']);
        });
    }

    public function down()
    {
        Schema::table('movimientos_bancarios', function (Blueprint $table) {
            // 1. Eliminar la foreign key
            $table->dropForeign(['proyecto_id']);
            
            // 2. Eliminar el índice
            $table->dropIndex(['proyecto_id', 'fecha']);
            
            // 3. Revertir a no nullable
            $table->foreignId('proyecto_id')->nullable(false)->change();
            
            // 4. Volver a crear la foreign key
            $table->foreign('proyecto_id')->references('id')->on('proyectos');
            
            // 5. Volver a crear el índice
            $table->index(['proyecto_id', 'fecha']);
        });
    }
};