<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('test_results', function (Blueprint $table) {
            $table->foreignId('group_id')
                ->nullable() // Поле может быть NULL
                ->constrained('groups') // Связь с таблицей groups
                ->nullOnDelete(); // Если группу удалят, group_id станет NULL
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('test_results', function (Blueprint $table) {
            $table->dropForeign(['group_id']); // Удаляем внешний ключ
            $table->dropColumn('group_id'); // Удаляем колонку
        });
    }
};
