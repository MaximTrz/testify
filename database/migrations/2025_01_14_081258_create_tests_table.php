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
        Schema::create('tests', function (Blueprint $table) {
            $table->id(); // автоинкрементное поле id
            $table->string('title'); // заголовок теста
            $table->integer('time_limit'); // лимит времени на выполнение теста в минутах
            $table->foreignId('teacher_id')->constrained('moonshine_users');
            $table->timestamp('available_from')->nullable(); // доступно с
            $table->timestamp('available_until')->nullable(); // доступно до
            $table->enum('status', ['available', 'not_available', 'completed'])->default('not_available'); // статус теста
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
