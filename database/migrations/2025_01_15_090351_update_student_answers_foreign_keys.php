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
            // Удаляем старый внешний ключ
            $table->dropForeign(['test_result_id']);
            // Добавляем новый внешний ключ
            $table->foreign('test_result_id')->references('id')->on('test_results')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_answers', function (Blueprint $table) {
            // Удаляем новый внешний ключ
            $table->dropForeign(['test_result_id']);
            // Восстанавливаем старый
            $table->foreign('test_result_id')->references('id')->on('old_test_results_table')->onDelete('cascade'); // Замените 'old_test_results_table' на фактическое имя старой таблицы если это необходимо
        });
    }
};
