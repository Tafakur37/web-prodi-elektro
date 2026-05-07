<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('violations', function (Blueprint $table) {
            // Rename columns to match spec
            $table->renameColumn('type', 'title');
            $table->renameColumn('points', 'point');

            // Add new fields
            $table->foreignId('reported_by')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', ['aktif', 'selesai'])->default('aktif');

            // Update date column if needed
            $table->date('date')->change();
        });

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE violations MODIFY COLUMN status ENUM('aktif', 'selesai') NOT NULL DEFAULT 'aktif'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('violations', function (Blueprint $table) {
            // Reverse new fields
            $table->dropForeign(['reported_by']);
            $table->dropColumn(['reported_by', 'status']);

            // Reverse renames
            $table->renameColumn('title', 'type');
            $table->renameColumn('point', 'points');
        });
    }
};
