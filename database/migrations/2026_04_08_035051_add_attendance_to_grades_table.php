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
    Schema::table('grades', function (Blueprint $table) {
        // Menambahkan kolom attendance setelah subject_id (atau posisi lain)
        $table->integer('attendance')->default(0)->after('subject_id');
    });
}

public function down(): void
{
    Schema::table('grades', function (Blueprint $table) {
        $table->dropColumn('attendance');
    });
}
};
