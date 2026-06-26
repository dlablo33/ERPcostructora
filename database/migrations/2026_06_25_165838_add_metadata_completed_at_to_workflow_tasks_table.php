<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('workflow_tasks', function (Blueprint $table) {
            // Agregar campos nuevos
            if (!Schema::hasColumn('workflow_tasks', 'metadata')) {
                $table->json('metadata')->nullable()->after('due_date');
            }
            
            if (!Schema::hasColumn('workflow_tasks', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('metadata');
            }

            // Agregar SoftDeletes si no existe
            if (!Schema::hasColumn('workflow_tasks', 'deleted_at')) {
                $table->softDeletes()->after('updated_at');
            }

            // Agregar índices para mejorar rendimiento
            $table->index(['module', 'record_id']);
            $table->index('status');
            $table->index('priority');
        });
    }

    public function down()
    {
        Schema::table('workflow_tasks', function (Blueprint $table) {
            if (Schema::hasColumn('workflow_tasks', 'metadata')) {
                $table->dropColumn('metadata');
            }
            
            if (Schema::hasColumn('workflow_tasks', 'completed_at')) {
                $table->dropColumn('completed_at');
            }

            if (Schema::hasColumn('workflow_tasks', 'deleted_at')) {
                $table->dropSoftDeletes();
            }

            $table->dropIndex(['module', 'record_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['priority']);
        });
    }
};