<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('workflow_tasks', function (Blueprint $table) {

    $table->id();

    // Módulo que originó la tarea
    $table->string('module'); // compras, requisiciones, vacaciones

    // Registro relacionado
    $table->unsignedBigInteger('record_id');

    // Información
    $table->string('title');
    $table->text('description')->nullable();

    // Usuarios
    $table->foreignId('created_by')->constrained('users');
    $table->foreignId('assigned_to')->constrained('users');

    // Estado
    $table->enum('status',[
        'pending',
        'approved',
        'rejected',
        'completed'
    ])->default('pending');

    // Prioridad
    $table->enum('priority',[
        'low',
        'medium',
        'high',
        'urgent'
    ])->default('medium');

    // Fecha límite
    $table->dateTime('due_date')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflow_tasks');
    }
};
