<?php

namespace App\Services;

use App\Models\FitnessTest;
use App\Models\Subject;
use App\Models\User;

class FitnessTestService
{
    /**
     * Ambil data untuk halaman index fitness test.
     */
    public function getIndexData(?int $semester = null, ?string $cohort = null): array
    {
        $semesters = Subject::distinct()->orderBy('semester', 'asc')->pluck('semester');
        $availableCohorts = User::where('role', 'mahasiswa')
            ->whereNotNull('cohort')
            ->distinct()
            ->pluck('cohort')
            ->filter();

        $students = collect();

        if ($semester && $cohort) {
            $students = User::where('role', 'mahasiswa')
                ->where('cohort', $cohort)
                ->with(['fitnessTests' => function ($q) use ($semester) {
                    $q->where('semester', $semester);
                }])
                ->orderBy('name', 'asc')
                ->get();
        }

        return compact('semesters', 'availableCohorts', 'semester', 'cohort', 'students');
    }

    /**
     * Simpan/update data fitness test (Garjas) dengan kalkulasi otomatis.
     */
    public function store(array $data, GarjasCalculatorService $calculator): array
    {
        $student = User::findOrFail($data['user_id']);
        $gender = $student->gender ?? 'L';

        $rawData = [
            'lari'        => $data['raw_lari'] ?? null,
            'pull_up'     => $data['raw_pull_up'] ?? null,
            'chinning'    => $data['raw_chinning'] ?? null,
            'sit_up'      => $data['raw_sit_up'] ?? null,
            'push_up'     => $data['raw_push_up'] ?? null,
            'shuttle_run' => $data['raw_shuttle_run'] ?? null,
            'renang'      => $data['raw_renang'] ?? null,
        ];

        $calculated = $calculator->calculateAll($rawData, $gender);

        FitnessTest::updateOrCreate(
            [
                'user_id'  => $data['user_id'],
                'semester' => $data['semester'],
            ],
            array_merge([
                'test_date'        => $data['test_date'],
                'raw_lari'         => $data['raw_lari'] ?? null,
                'raw_pull_up'      => $data['raw_pull_up'] ?? null,
                'raw_chinning'     => $data['raw_chinning'] ?? null,
                'raw_sit_up'       => $data['raw_sit_up'] ?? null,
                'raw_push_up'      => $data['raw_push_up'] ?? null,
                'raw_shuttle_run'  => $data['raw_shuttle_run'] ?? null,
                'raw_renang'       => $data['raw_renang'] ?? null,
                // Legacy compat
                'score_a'          => (int) round($calculated['nilai_lari']),
                'score_b'          => (int) round(
                    ($calculated['nilai_pull_up'] ?? $calculated['nilai_chinning'] ?? 0) +
                    $calculated['nilai_sit_up'] +
                    $calculated['nilai_push_up'] +
                    $calculated['nilai_shuttle_run']
                ) / 4,
                'score_c'          => (int) round($calculated['nilai_renang']),
            ], $calculated)
        );

        return $calculated;
    }

    /**
     * Hapus data fitness test.
     */
    public function destroy(FitnessTest $fitnessTest): void
    {
        $fitnessTest->delete();
    }
}
