<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_info', function (Blueprint $table) {
            $table->id();
            
            // Datos fiscales
            $table->string('razon_social', 255);
            $table->string('nombre_comercial', 255)->nullable();
            $table->string('rfc', 13)->unique();
            $table->string('regimen_fiscal', 100)->nullable();
            
            // Contacto
            $table->string('telefono', 20)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('email_facturacion', 255)->nullable();
            $table->string('website', 255)->nullable();
            
            // Dirección
            $table->string('calle', 255)->nullable();
            $table->string('num_exterior', 50)->nullable();
            $table->string('num_interior', 50)->nullable();
            $table->string('colonia', 255)->nullable();
            $table->string('codigo_postal', 10)->nullable();
            $table->string('municipio', 100)->nullable();
            $table->string('estado', 100)->nullable();
            $table->string('pais', 100)->default('México');
            
            // Satelital
            $table->string('satcat_regimen_fiscal_clave', 50)->nullable();
            $table->string('satcat_uso_cfdi_clave', 50)->nullable();
            
            // Certificados SAT
            $table->string('certificado_cer', 255)->nullable();
            $table->string('certificado_key', 255)->nullable();
            $table->string('certificado_password', 255)->nullable();
            $table->string('certificado_no_serie', 255)->nullable();
            $table->timestamp('certificado_vigencia_desde')->nullable();
            $table->timestamp('certificado_vigencia_hasta')->nullable();
            
            // Logo
            $table->string('logo_path', 255)->nullable();
            $table->string('logo_small_path', 255)->nullable();
            $table->string('favicon_path', 255)->nullable();
            
            // Facturación
            $table->string('serie_default', 10)->nullable();
            $table->integer('folio_actual')->default(0);
            $table->integer('folio_siguiente')->default(1);
            $table->boolean('autotimbrado')->default(false);
            
            // Otros
            $table->text('mensaje_factura')->nullable();
            $table->text('terminos_condiciones')->nullable();
            $table->text('politica_privacidad')->nullable();
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('rfc');
            $table->index('razon_social');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_info');
    }
};