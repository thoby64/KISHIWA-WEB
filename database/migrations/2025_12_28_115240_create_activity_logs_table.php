<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Nullable for system actions
            $table->string('action'); // e.g., 'created_event', 'updated_announcement', 'confirmed_appointment'
            $table->string('model_type'); // e.g., 'App\Models\Event', 'App\Models\Announcement'
            $table->integer('model_id'); // ID of the model affected
            $table->json('old_values')->nullable(); // Previous values before update
            $table->json('new_values')->nullable(); // New values after update
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index(['model_type', 'model_id']);
            $table->index(['action', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
};