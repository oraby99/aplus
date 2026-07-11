<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Clean up partial runs
        Schema::dropIfExists('competitions');
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('evaluations');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('trial_sessions');

        // 1. Trial Sessions
        Schema::create('trial_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            $table->integer('age');
            $table->string('parent_phone');
            $table->date('session_date');
            $table->string('status')->default('pending'); // pending, attended, subscribed, absent
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 2. Teacher Schedules
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('group_id')->constrained('groups')->cascadeOnDelete();
            $table->string('day_of_week'); // Saturday, Sunday, etc.
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });

        // 3. Projects
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('course_id')->nullable()->constrained('courses')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('project_url')->nullable();
            $table->string('image_path')->nullable();
            $table->timestamps();
        });

        // 4. Evaluations
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->integer('score'); // e.g. out of 100
            $table->text('feedback')->nullable();
            $table->date('evaluation_date');
            $table->timestamps();
        });

        // 5. Certificates
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->date('issue_date');
            $table->string('file_path')->nullable();
            $table->string('serial_number')->unique();
            $table->timestamps();
        });

        // 6. Competitions
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->default('upcoming'); // upcoming, ongoing, completed
            $table->timestamps();
        });

        // 7. Modifying Payments and Installments
        // The user wanted monthly and 3-months systems.
        // We will add 'payment_plan' to payments table (monthly, quarterly, full)
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'payment_plan')) {
                $table->string('payment_plan')->default('full')->after('status'); // full, monthly, quarterly
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('payment_plan');
        });
        Schema::dropIfExists('competitions');
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('evaluations');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('trial_sessions');
    }
};
