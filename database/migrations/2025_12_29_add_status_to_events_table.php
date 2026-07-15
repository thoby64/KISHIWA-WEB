<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            // Add status column after is_published
            $table->enum('status', ['draft', 'published', 'cancelled', 'completed'])->default('draft')->after('is_published');
            
            // Add search-friendly columns
            $table->fullText(['title', 'description', 'location'])->after('status');
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropFullText(['title', 'description', 'location']);
        });
    }
};
