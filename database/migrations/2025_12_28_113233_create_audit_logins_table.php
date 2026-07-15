<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('audit_logins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Nullable for failed attempts
            $table->string('ip_address');
            $table->string('user_agent')->nullable();
            $table->string('login_type'); // 'login', 'logout', 'failed'
            $table->timestamp('login_time');
            $table->timestamp('logout_time')->nullable();
            $table->boolean('is_successful')->default(false);
            $table->text('additional_info')->nullable(); // For storing error messages, etc.
            $table->timestamps();

            $table->index(['user_id', 'login_time']);
            $table->index(['ip_address', 'login_time']);
            $table->index(['login_type', 'login_time']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('audit_logins');
    }
};