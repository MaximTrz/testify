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
        // Добавляем поле group_id в таблицу users
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('group_id')->nullable()->after('remember_token'); // Используем unsignedBigInteger
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('set null'); // Создаем внешний ключ
        });

        // Удаляем таблицу group_students, если она существует
        Schema::dropIfExists('group_students');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Удаляем внешний ключ и поле group_id из таблицы users
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['group_id']); // Удаляем внешний ключ
            $table->dropColumn('group_id'); // Удаляем поле group_id
        });

        // Восстанавливаем таблицу group_students, если необходимо
        Schema::create('group_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }
};
