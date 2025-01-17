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
        Schema::create('test_group', function (Blueprint $table) {
            $table->id(); // автоинкрементное поле id
            $table->foreignId('test_id')->constrained('tests')->onDelete('cascade'); // связь с таблицей tests
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade'); // связь с таблицей groups
            $table->unique(['test_id', 'group_id']); // уникальность по полям test_id и group_id
            $table->timestamps(); // created_at и updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_group');
    }
};
