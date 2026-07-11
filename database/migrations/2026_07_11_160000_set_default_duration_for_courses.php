<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Set default duration for courses that have no duration
        $courses = DB::table('courses')->get();

        foreach ($courses as $course) {
            if (empty($course->duration)) {
                $title = $course->title ?? '';

                if (str_contains($title, 'سكراتش')) {
                    $duration = '3 أشهر';
                } elseif (str_contains($title, 'بايثون')) {
                    $duration = '4 أشهر';
                } elseif (str_contains($title, 'ذكاء') || str_contains($title, 'AI')) {
                    $duration = '3 أشهر';
                } else {
                    $duration = '3 أشهر';
                }

                DB::table('courses')->where('id', $course->id)->update(['duration' => $duration]);
            }
        }
    }

    public function down(): void
    {
        // No rollback needed
    }
};
