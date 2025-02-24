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
            // Добавляем столбец teacher_id
            $table->foreignId('teacher_id')
                ->nullable()
                ->constrained('moonshine_users')  // Связь с таблицей MoonShine users
                ->onDelete('set null');            // При удалении пользователя обнуляем поле
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_results', function (Blueprint $table) {
            // Удаляем связь и столбец
            $table->dropForeign(['teacher_id']);
            $table->dropColumn('teacher_id');
        });
    }
};
