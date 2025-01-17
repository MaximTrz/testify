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
        Schema::create('grading_criteria', function (Blueprint $table) {
            $table->id(); // автоинкрементное поле id
            $table->foreignId('test_id')->constrained()->onDelete('cascade'); // связь с таблицей tests
            $table->integer('min_correct_answers'); // Минимальное количество правильных ответов
            $table->integer('max_correct_answers'); // Максимальное количество правильных ответов
            $table->integer('grade'); // Оценка за данный диапазон

            // Задаем уникальный индекс с коротким именем
            $table->unique(['test_id', 'min_correct_answers', 'max_correct_answers'], 'unique_grading_criteria');

            $table->timestamps(); // created_at и updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grading_criteria');
    }
};
