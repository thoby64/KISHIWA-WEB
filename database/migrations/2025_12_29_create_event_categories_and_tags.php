<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Create event_categories table
        Schema::create('event_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('color')->default('#007bff');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Add category_id to events table
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('status');
            $table->foreign('category_id')->references('id')->on('event_categories')->onDelete('set null');
        });

        // Create event_tags table for many-to-many relationship
        Schema::create('event_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Create pivot table for event-tag relationship
        Schema::create('event_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('event_tag_id');
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('event_tag_id')->references('id')->on('event_tags')->onDelete('cascade');
            $table->unique(['event_id', 'event_tag_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_tag');
        Schema::dropIfExists('event_tags');
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
        Schema::dropIfExists('event_categories');
    }
};
