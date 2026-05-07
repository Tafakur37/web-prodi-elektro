<?php

namespace App\Services;

/**
 * GarjasCalculatorService
 * 
 * Sistem penilaian Garjas menggunakan Linear Interpolation.
 * Setiap komponen dinilai 0-100, berbeda parameter untuk Putra (L) dan Putri (P).
 *
 * RUMUS DASAR:
 *   Higher-is-better: nilai = ((input - min) / (max - min)) * 99 + 1
 *   Lower-is-better:  nilai = ((worst - input) / (worst - best)) * 99 + 1
 *   Input = 0 → nilai = 0 (tidak mengikuti tes)
 *   Clamp: min=0, max=100
 */
class GarjasCalculatorService
{
    // ═══════════════════════════════════════════════════════════════
    //  PARAMETER TABLES (config per gender)
    // ═══════════════════════════════════════════════════════════════

    private const PARAMS = [
        'lari' => [
            'L' => ['max' => 3240, 'min' => 1664],  // meter
            'P' => ['max' => 2435, 'min' => 1326],
        ],
        'pull_up' => [
            'L' => ['max' => 15, 'min' => 1],  // reps (khusus Putra)
        ],
        'chinning' => [
            'P' => ['max' => 60, 'min' => 11],  // detik (khusus Putri)
        ],
        'sit_up' => [
            'L' => ['max' => 39, 'threshold' => 7],  // reps
            'P' => ['max' => 40, 'threshold' => 8],
        ],
        'push_up' => [
            'L' => ['max' => 37, 'threshold' => 5],  // reps
            'P' => ['max' => 27, 'min' => 1],
        ],
        'shuttle_run' => [
            'L' => ['best' => 16.9, 'worst' => 26.8],  // detik (lower is better)
            'P' => ['best' => 17.2, 'worst' => 27.1],
        ],
        'renang' => [
            'best' => 60,   // detik (≤60 = 100)
            'worst' => 300, // detik (5 menit = worst case)
        ],
    ];

    // ═══════════════════════════════════════════════════════════════
    //  HELPER: Linear Interpolation
    // ═══════════════════════════════════════════════════════════════

    /**
     * Linear interpolation: Higher input = higher score
     */
    private function linear(float $input, float $min, float $max): float
    {
        if ($max == $min) return 100;
        return (($input - $min) / ($max - $min)) * 99 + 1;
    }

    /**
     * Inverse linear interpolation: Lower input = higher score
     */
    private function inverseLinear(float $input, float $best, float $worst): float
    {
        if ($worst == $best) return 100;
        return (($worst - $input) / ($worst - $best)) * 99 + 1;
    }

    /**
     * Clamp value between 0 and 100
     */
    private function clamp(float $value): float
    {
        return round(max(0, min(100, $value)), 2);
    }

    // ═══════════════════════════════════════════════════════════════
    //  KOMPONEN A: LARI (Higher = Better)
    // ═══════════════════════════════════════════════════════════════

    public function calculateLari(?float $meters, string $gender): float
    {
        if ($meters === null || $meters <= 0) return 0;

        $p = self::PARAMS['lari'][$gender] ?? self::PARAMS['lari']['L'];

        if ($meters >= $p['max']) return 100;

        return $this->clamp($this->linear($meters, $p['min'], $p['max']));
    }

    // ═══════════════════════════════════════════════════════════════
    //  KOMPONEN B1: PULL UP — Khusus Putra (Higher = Better)
    // ═══════════════════════════════════════════════════════════════

    public function calculatePullUp(?int $reps): float
    {
        if ($reps === null || $reps <= 0) return 0;

        $p = self::PARAMS['pull_up']['L'];

        if ($reps >= $p['max']) return 100;

        return $this->clamp($this->linear($reps, $p['min'], $p['max']));
    }

    // ═══════════════════════════════════════════════════════════════
    //  KOMPONEN B1: CHINNING — Khusus Putri (Higher = Better)
    // ═══════════════════════════════════════════════════════════════

    public function calculateChinning(?int $seconds): float
    {
        if ($seconds === null || $seconds <= 0) return 0;

        $p = self::PARAMS['chinning']['P'];

        if ($seconds >= $p['max']) return 100;

        return $this->clamp($this->linear($seconds, $p['min'], $p['max']));
    }

    // ═══════════════════════════════════════════════════════════════
    //  KOMPONEN B2: SIT UP (Higher = Better, with threshold)
    // ═══════════════════════════════════════════════════════════════

    /**
     * Sit Up scoring:
     *   0         → 0
     *   1..(<thr) → 1
     *   thr       → 2
     *   thr..max  → linear interpolation 2..100
     *   ≥max      → 100
     */
    public function calculateSitUp(?int $reps, string $gender): float
    {
        if ($reps === null || $reps <= 0) return 0;

        $p = self::PARAMS['sit_up'][$gender] ?? self::PARAMS['sit_up']['L'];

        if ($reps >= $p['max']) return 100;

        if ($reps < $p['threshold']) return 1;

        if ($reps == $p['threshold']) return 2;

        // Linear from threshold(=2) to max(=100)
        $score = (($reps - $p['threshold']) / ($p['max'] - $p['threshold'])) * 98 + 2;
        return $this->clamp($score);
    }

    // ═══════════════════════════════════════════════════════════════
    //  KOMPONEN B3: PUSH UP (Higher = Better, with threshold)
    // ═══════════════════════════════════════════════════════════════

    /**
     * Push Up scoring:
     *   PUTRA: 0→0, <5→1, 5→2, 5..37→linear(2..100), ≥37→100
     *   PUTRI: 0→0, 1→10, 1..27→linear(10..100), ≥27→100
     */
    public function calculatePushUp(?int $reps, string $gender): float
    {
        if ($reps === null || $reps <= 0) return 0;

        if ($gender === 'P') {
            $p = self::PARAMS['push_up']['P'];
            if ($reps >= $p['max']) return 100;
            // Linear from 1(=10) to 27(=100)
            $score = (($reps - $p['min']) / ($p['max'] - $p['min'])) * 90 + 10;
            return $this->clamp($score);
        }

        // Putra
        $p = self::PARAMS['push_up']['L'];
        if ($reps >= $p['max']) return 100;
        if ($reps < $p['threshold']) return 1;
        if ($reps == $p['threshold']) return 2;

        // Linear from 5(=2) to 37(=100)
        $score = (($reps - $p['threshold']) / ($p['max'] - $p['threshold'])) * 98 + 2;
        return $this->clamp($score);
    }

    // ═══════════════════════════════════════════════════════════════
    //  KOMPONEN B4: SHUTTLE RUN (Lower = Better)
    // ═══════════════════════════════════════════════════════════════

    public function calculateShuttleRun(?float $seconds, string $gender): float
    {
        if ($seconds === null || $seconds <= 0) return 0;

        $p = self::PARAMS['shuttle_run'][$gender] ?? self::PARAMS['shuttle_run']['L'];

        if ($seconds <= $p['best']) return 100;
        if ($seconds >= $p['worst']) return 1;

        return $this->clamp($this->inverseLinear($seconds, $p['best'], $p['worst']));
    }

    // ═══════════════════════════════════════════════════════════════
    //  KOMPONEN C: RENANG (Lower = Better)
    // ═══════════════════════════════════════════════════════════════

    /**
     * Renang: ≤60 detik = 100, di atas 60 turun linear sampai 300 detik
     */
    public function calculateRenang(?float $seconds): float
    {
        if ($seconds === null || $seconds <= 0) return 0;

        if ($seconds <= self::PARAMS['renang']['best']) return 100;

        return $this->clamp(
            $this->inverseLinear($seconds, self::PARAMS['renang']['best'], self::PARAMS['renang']['worst'])
        );
    }

    // ═══════════════════════════════════════════════════════════════
    //  MASTER: Calculate All Components
    // ═══════════════════════════════════════════════════════════════

    /**
     * Hitung semua komponen sekaligus.
     *
     * @param array  $raw    Data mentah: lari, pull_up/chinning, sit_up, push_up, shuttle_run, renang
     * @param string $gender 'L' atau 'P'
     * @return array Semua nilai konversi + total + status
     */
    public function calculateAll(array $raw, string $gender): array
    {
        $nilaiLari       = $this->calculateLari($raw['lari'] ?? null, $gender);
        $nilaiSitUp      = $this->calculateSitUp($raw['sit_up'] ?? null, $gender);
        $nilaiPushUp     = $this->calculatePushUp($raw['push_up'] ?? null, $gender);
        $nilaiShuttleRun = $this->calculateShuttleRun($raw['shuttle_run'] ?? null, $gender);
        $nilaiRenang     = $this->calculateRenang($raw['renang'] ?? null);

        // Komponen B1: Pull Up (Putra) atau Chinning (Putri)
        $nilaiPullUp  = null;
        $nilaiChinning = null;

        if ($gender === 'P') {
            $nilaiChinning = $this->calculateChinning(isset($raw['chinning']) ? (int)$raw['chinning'] : null);
        } else {
            $nilaiPullUp = $this->calculatePullUp(isset($raw['pull_up']) ? (int)$raw['pull_up'] : null);
        }

        // Kumpulkan semua nilai yang valid (bukan null) untuk rata-rata
        $components = array_filter([
            $nilaiLari,
            $nilaiPullUp ?? $nilaiChinning,
            $nilaiSitUp,
            $nilaiPushUp,
            $nilaiShuttleRun,
            $nilaiRenang,
        ], fn($v) => $v !== null);

        $total = count($components) > 0
            ? round(array_sum($components) / count($components), 2)
            : 0;

        // Status otomatis
        $status = $total >= 60 ? 'Lulus' : 'Tidak Lulus';

        return [
            // Nilai konversi
            'nilai_lari'        => $nilaiLari,
            'nilai_pull_up'     => $nilaiPullUp,
            'nilai_chinning'    => $nilaiChinning,
            'nilai_sit_up'      => $nilaiSitUp,
            'nilai_push_up'     => $nilaiPushUp,
            'nilai_shuttle_run' => $nilaiShuttleRun,
            'nilai_renang'      => $nilaiRenang,
            'total_score'       => $total,
            'status'            => $status,
            // Also store score for backward compat
            'score'             => (int) round($total),
        ];
    }
}
