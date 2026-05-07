<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fitness_tests', function (Blueprint $table) {
            $table->integer('semester')->nullable()->after('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('fitness_tests', function (Blueprint $table) {
            $table->dropColumn('semester');
        });
    }
};
