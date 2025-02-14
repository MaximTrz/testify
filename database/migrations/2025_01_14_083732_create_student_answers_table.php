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
        Schema::create('student_answers', function (Blueprint $table) {
            $table->id(); // автоинкрементное поле id
            $table->foreignId('test_id')->constrained('tests')->onDelete('cascade'); // связь с таблицей test_results
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade'); // связь с таблицей questions
            $table->foreignId('answer_id')->nullable()->constrained('answers')->onDelete('set null'); // связь с таблицей answers, может быть NULL
            $table->text('given_answer_text')->nullable(); // текст ответа для открытых вопросов
            $table->boolean('is_correct')->default(false); // правильный ответ или нет
            $table->timestamps(); // created_at и updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_answers');
    }
};
