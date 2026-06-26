<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ticket_archivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('client_tickets')->onDelete('cascade');
            $table->string('nombre_original', 255);
            $table->string('nombre_unico', 255);
            $table->string('ruta', 500);
            $table->bigInteger('tamaño');
            $table->string('mime_type', 100);
            $table->timestamps();
            
            $table->index('ticket_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_archivos');
    }
};