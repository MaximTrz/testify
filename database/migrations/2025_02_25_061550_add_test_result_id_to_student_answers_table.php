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
        Schema::table('student_answers', function (Blueprint $table) {
            // Добавляем колонку test_result_id
            $table->foreignId('test_result_id')
                ->nullable() // поле может быть NULL
                ->constrained('test_results') // связываем с таблицей test_results
                ->onDelete('cascade'); // при удалении записи из test_results удаляем связанные записи
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_answers', function (Blueprint $table) {
            // Удаляем внешний ключ и колонку test_result_id
            $table->dropConstrainedForeignId('test_result_id');
        });
    }
};
