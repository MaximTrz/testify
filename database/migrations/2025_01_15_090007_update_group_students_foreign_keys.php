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
        Schema::table('group_students', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Удаляем старый внешний ключ
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Добавляем новый внешний ключ
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('group_students', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Удаляем новый внешний ключ
            $table->foreign('user_id')->references('id')->on('moonshine_users')->onDelete('cascade'); // Восстанавливаем старый
        });
    }
};
