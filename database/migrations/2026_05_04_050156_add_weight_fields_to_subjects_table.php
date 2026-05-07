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
            $table->integer('weight_task')->default(30)->after('meetings');
            $table->integer('weight_uts')->default(30)->after('weight_task');
            $table->integer('weight_uas')->default(40)->after('weight_uts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn(['weight_task', 'weight_uts', 'weight_uas']);
        });
    }
};
