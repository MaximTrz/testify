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
        // Добавляем новые колонки в таблицу test_group
        Schema::table('test_group', function (Blueprint $table) {
            $table->timestamp('available_from')->nullable()->after('group_id');
            $table->timestamp('available_until')->nullable()->after('available_from');
        });

        // Переносим данные из таблицы tests
        DB::table('test_group')
            ->join('tests', 'test_group.test_id', '=', 'tests.id')
            ->update([
                'test_group.available_from' => DB::raw('COALESCE(tests.available_from, NOW())'),
                'test_group.available_until' => DB::raw('COALESCE(tests.available_until, DATE_ADD(NOW(), INTERVAL 3 DAY))'),
            ]);

        // Удаляем старые колонки из таблицы tests
        Schema::table('tests', function (Blueprint $table) {
            $table->dropColumn(['available_from', 'available_until']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Восстанавливаем таблицу tests
        Schema::table('tests', function (Blueprint $table) {
            $table->timestamp('available_from')->nullable();
            $table->timestamp('available_until')->nullable();
        });

        // Переносим данные обратно в таблицу tests
        DB::table('tests')
            ->join('test_group', 'test_group.test_id', '=', 'tests.id')
            ->update([
                'tests.available_from' => DB::raw('test_group.available_from'),
                'tests.available_until' => DB::raw('test_group.available_until'),
            ]);

        // Удаляем колонки из таблицы test_group
        Schema::table('test_group', function (Blueprint $table) {
            $table->dropColumn(['available_from', 'available_until']);
        });
    }
};
