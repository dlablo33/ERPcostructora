<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('workflow_tasks', function (Blueprint $table) {
            if (!Schema::hasColumn('workflow_tasks', 'taskable_id')) {
                $table->nullableMorphs('taskable');
            }
        });
    }

    public function down()
    {
        Schema::table('workflow_tasks', function (Blueprint $table) {
            if (Schema::hasColumn('workflow_tasks', 'taskable_id')) {
                $table->dropMorphs('taskable');
            }
        });
    }
};