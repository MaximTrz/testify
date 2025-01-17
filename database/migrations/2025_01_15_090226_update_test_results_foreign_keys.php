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
        Schema::table('test_results', function (Blueprint $table) {
            $table->dropForeign(['student_id']); // Удаляем старый внешний ключ
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade'); // Добавляем новый внешний ключ
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_results', function (Blueprint $table) {
            $table->dropForeign(['student_id']); // Удаляем новый внешний ключ
            $table->foreign('student_id')->references('id')->on('moonshine_users')->onDelete('cascade'); // Восстанавливаем старый
        });
    }
};
