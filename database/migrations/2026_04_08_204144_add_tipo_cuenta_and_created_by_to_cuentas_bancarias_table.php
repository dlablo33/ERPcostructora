<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_tipo_cuenta_and_created_by_to_cuentas_bancarias_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cuentas_bancarias', function (Blueprint $table) {
            $table->enum('tipo_cuenta', ['cheques', 'ahorros', 'inversion', 'credito'])->default('cheques')->after('titular');
            $table->foreignId('created_by')->nullable()->after('activa')->constrained('users');
            $table->softDeletes()->after('created_by');
        });
    }

    public function down()
    {
        Schema::table('cuentas_bancarias', function (Blueprint $table) {
            $table->dropColumn('tipo_cuenta');
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
            $table->dropSoftDeletes();
        });
    }
};