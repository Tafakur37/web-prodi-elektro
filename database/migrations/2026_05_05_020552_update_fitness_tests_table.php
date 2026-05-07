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
        Schema::table('fitness_tests', function (Blueprint $table) {
            $table->integer('score_a')->nullable()->after('test_date');
            $table->integer('score_b')->nullable()->after('score_a');
            $table->integer('score_c')->nullable()->after('score_b');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fitness_tests', function (Blueprint $table) {
            $table->dropColumn(['score_a', 'score_b', 'score_c']);
        });
    }
};
