<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fitness_tests', function (Blueprint $table) {
            // Raw input data (data mentah dari lapangan)
            $table->decimal('raw_lari', 8, 2)->nullable()->after('test_date');
            $table->integer('raw_pull_up')->nullable()->after('raw_lari');
            $table->integer('raw_chinning')->nullable()->after('raw_pull_up');
            $table->integer('raw_sit_up')->nullable()->after('raw_chinning');
            $table->integer('raw_push_up')->nullable()->after('raw_sit_up');
            $table->decimal('raw_shuttle_run', 5, 2)->nullable()->after('raw_push_up');
            $table->decimal('raw_renang', 8, 2)->nullable()->after('raw_shuttle_run');

            // Nilai konversi (0-100) hasil kalkulasi otomatis
            $table->decimal('nilai_lari', 5, 2)->nullable()->after('raw_renang');
            $table->decimal('nilai_pull_up', 5, 2)->nullable()->after('nilai_lari');
            $table->decimal('nilai_chinning', 5, 2)->nullable()->after('nilai_pull_up');
            $table->decimal('nilai_sit_up', 5, 2)->nullable()->after('nilai_chinning');
            $table->decimal('nilai_push_up', 5, 2)->nullable()->after('nilai_sit_up');
            $table->decimal('nilai_shuttle_run', 5, 2)->nullable()->after('nilai_push_up');
            $table->decimal('nilai_renang', 5, 2)->nullable()->after('nilai_shuttle_run');

            // Total score (rata-rata semua komponen)
            $table->decimal('total_score', 5, 2)->nullable()->after('nilai_renang');
        });
    }

    public function down(): void
    {
        Schema::table('fitness_tests', function (Blueprint $table) {
            $table->dropColumn([
                'raw_lari', 'raw_pull_up', 'raw_chinning', 'raw_sit_up',
                'raw_push_up', 'raw_shuttle_run', 'raw_renang',
                'nilai_lari', 'nilai_pull_up', 'nilai_chinning', 'nilai_sit_up',
                'nilai_push_up', 'nilai_shuttle_run', 'nilai_renang',
                'total_score',
            ]);
        });
    }
};
