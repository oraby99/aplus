<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('age')->nullable()->after('phone');
            $table->string('parent_name')->nullable()->after('age');
            $table->string('parent_phone')->nullable()->after('parent_name');
            $table->date('birth_date')->nullable()->after('parent_phone');
            $table->string('school')->nullable()->after('birth_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['age', 'parent_name', 'parent_phone', 'birth_date', 'school']);
        });
    }
};
