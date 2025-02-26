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
            $table->foreignId('test_group_id')
                ->nullable()
                ->constrained('test_group')
                ->onDelete('cascade')
                ->after('student_id'); // Добавляем после student_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_results', function (Blueprint $table) {
            $table->dropForeign(['test_group_id']);
            $table->dropColumn('test_group_id');
        });
    }
};
