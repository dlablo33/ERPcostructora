<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aplicacion_anticipos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('anticipo_id')
                  ->constrained('anticipos')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            $table->decimal('monto', 15, 2);
            $table->date('fecha');
            $table->string('observaciones', 500)->nullable();

            $table->timestamps();

            $table->index('anticipo_id');
            $table->index('fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aplicacion_anticipos');
    }
};