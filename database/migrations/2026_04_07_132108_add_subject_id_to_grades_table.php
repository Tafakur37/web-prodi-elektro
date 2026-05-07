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
    if (!Schema::hasColumn('grades', 'subject_id')) {
        Schema::table('grades', function (Blueprint $table) {
            // Menambahkan kolom subject_id sebagai foreign key
            $table->unsignedBigInteger('subject_id')->after('user_id')->nullable();

            // Opsional: Tambahkan foreign key constraint agar data konsisten
            // $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }
}

public function down(): void
{
    if (Schema::hasColumn('grades', 'subject_id')) {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropColumn('subject_id');
        });
    }
}
};
