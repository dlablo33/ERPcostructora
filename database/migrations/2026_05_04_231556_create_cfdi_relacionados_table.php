<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cfdi_relacionados', function (Blueprint $table) {
            $table->id('cfdi_relacionado_id');
            $table->unsignedBigInteger('cfdi_id');
            $table->string('timbrefiscaldigitalUUID', 36);
            $table->string('UUID', 36);
            $table->string('satcat_tipo_relacion_clave', 5);
            $table->timestamps();
            
            $table->foreign('cfdi_id')->references('cfdi_id')->on('cfdi')->onDelete('cascade');
            $table->index('UUID');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cfdi_relacionados');
    }
};