<?php
// database/migrations/xxxx_create_push_subscriptions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('push_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('endpoint');
            $table->json('keys');
            $table->timestamp('expiration_time')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'endpoint']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('push_subscriptions');
    }
};