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
            if (!Schema::hasColumn('grades', 'tugas')) {
                $table->integer('tugas')->default(0)->after('subject_id');
            }
            if (!Schema::hasColumn('grades', 'uts')) {
                $table->integer('uts')->default(0)->after('tugas');
            }
            if (!Schema::hasColumn('grades', 'remedial_uts')) {
                $table->integer('remedial_uts')->nullable()->after('uts');
            }
            if (!Schema::hasColumn('grades', 'uas')) {
                $table->integer('uas')->default(0)->after('remedial_uts');
            }
            if (!Schema::hasColumn('grades', 'remedial_uas')) {
                $table->integer('remedial_uas')->nullable()->after('uas');
            }
            if (!Schema::hasColumn('grades', 'attendance')) {
                $table->integer('attendance')->default(0)->after('remedial_uas');
            }
            if (!Schema::hasColumn('grades', 'grade')) {
                $table->string('grade', 2)->default('E')->after('attendance');
            }
            if (!Schema::hasColumn('grades', 'cohort')) {
                $table->string('cohort', 10)->nullable()->after('grade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropColumn(['attendance', 'tugas', 'remedial_uts', 'remedial_uas', 'cohort']);
        });
    }
};