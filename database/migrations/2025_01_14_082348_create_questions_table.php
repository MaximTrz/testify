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
        Schema::create('questions', function (Blueprint $table) {
            $table->id(); // автоинкрементное поле id
            $table->foreignId('test_id')->constrained()->onDelete('cascade'); // связь с таблицей tests
            $table->text('question_text'); // текст вопроса
            $table->enum('question_type', ['single', 'multiple']); // тип вопроса
            $table->integer('time_limit')->default(30); // лимит времени на ответ в секундах
            $table->timestamps(); // created_at и updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
