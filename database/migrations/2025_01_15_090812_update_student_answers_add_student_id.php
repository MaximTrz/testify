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
            // Добавляем новое поле student_id
            $table->unsignedBigInteger('student_id')->after('id'); // Ссылаясь на id в users

            // Добавляем внешний ключ для student_id
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_answers', function (Blueprint $table) {
            // Удаляем внешний ключ
            $table->dropForeign(['student_id']);

            // Удаляем поле student_id
            $table->dropColumn('student_id');
        });
    }
};
