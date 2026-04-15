<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Modify scheduled_time column in tasks table
 * Change from timestamp to time (only hours and minutes)
 *
 * Purpose:
 * - Store only the time (HH:MM:SS) instead of full datetime
 * - Align with study_schedules which also uses time type
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // PostgreSQL: ALTER with USING to convert timestamp → time in one step
        DB::statement("
            ALTER TABLE tasks
            ALTER COLUMN scheduled_time TYPE time
            USING scheduled_time::time
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->timestamp('scheduled_time')->nullable()->change();
        });
    }
};
