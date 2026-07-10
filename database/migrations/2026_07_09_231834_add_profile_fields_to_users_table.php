<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar_path')->nullable()->after('email');
            $table->string('phone', 20)->nullable()->after('avatar_path');
            $table->string('position', 100)->nullable()->after('phone');
            $table->string('department', 100)->nullable()->after('position');
            $table->timestamp('password_changed_at')->nullable()->after('remember_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['avatar_path', 'phone', 'position', 'department', 'password_changed_at']);
        });
    }
};