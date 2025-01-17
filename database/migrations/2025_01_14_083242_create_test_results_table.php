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
        Schema::create('test_results', function (Blueprint $table) {
            $table->id(); // автоинкрементное поле id
            $table->foreignId('test_id')->constrained()->onDelete('cascade'); // связь с таблицей tests
            $table->foreignId('student_id')->constrained('moonshine_users')->onDelete('cascade'); // связь с таблицей moonshine_users
            $table->integer('score')->nullable(); // Оценка за тест (можно сделать null для случаев, когда оценка ещё не выставлена)
            $table->timestamp('completed_at')->default(DB::raw('CURRENT_TIMESTAMP')); // Время завершения теста
            $table->timestamps(); // created_at и updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_results');
    }
};
