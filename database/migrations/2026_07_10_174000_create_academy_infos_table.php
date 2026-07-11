<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academy_infos', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->default('+20 10 1234 5678');
            $table->string('email')->default('info@aplusacademy.com');
            $table->string('address')->default('القاهرة، مدينة نصر، شارع عباس العقاد');
            $table->string('video_url')->default('https://www.youtube.com/embed/tgbNymZ7vqY');
            $table->text('about_text')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academy_infos');
    }
};
