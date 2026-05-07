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
        Schema::table('subjects', function (Blueprint $table) {
            $table->integer('sks')->default(3)->after('name');
            $table->integer('kkm_uts')->default(60)->after('semester');
            $table->integer('kkm_uas')->default(60)->after('kkm_uts');
            $table->integer('meetings')->default(14)->after('kkm_uas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn(['sks', 'kkm_uts', 'kkm_uas', 'meetings']);
        });
    }
};
