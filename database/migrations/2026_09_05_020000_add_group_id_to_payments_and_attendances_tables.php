<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'group_id')) {
                $table->foreignId('group_id')
                    ->nullable()
                    ->after('student_id')
                    ->constrained('groups')
                    ->nullOnDelete();
            }
        });

        Schema::table('attendances', function (Blueprint $table) {
            if (!Schema::hasColumn('attendances', 'group_id')) {
                $table->foreignId('group_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('groups')
                    ->cascadeOnDelete();
            }
        });

        // Backfill attendances.group_id from class_sessions if available
        if (Schema::hasTable('attendances') && Schema::hasTable('class_sessions')) {
            try {
                DB::statement('
                    UPDATE attendances a 
                    INNER JOIN class_sessions cs ON a.class_session_id = cs.id 
                    SET a.group_id = cs.group_id 
                    WHERE a.group_id IS NULL
                ');
            } catch (\Throwable $e) {
                // Ignore if any database engine constraint fails on backfill
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'group_id')) {
                $table->dropConstrainedForeignId('group_id');
            }
        });

        Schema::table('attendances', function (Blueprint $table) {
            if (Schema::hasColumn('attendances', 'group_id')) {
                $table->dropConstrainedForeignId('group_id');
            }
        });
    }
};
