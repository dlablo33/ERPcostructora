<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_cuenta_contable_id_to_cuentas_bancarias_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cuentas_bancarias', function (Blueprint $table) {
            $table->foreignId('cuenta_contable_id')->nullable()->after('proyecto_id')->constrained('cuentas_contables')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('cuentas_bancarias', function (Blueprint $table) {
            $table->dropForeign(['cuenta_contable_id']);
            $table->dropColumn('cuenta_contable_id');
        });
    }
};