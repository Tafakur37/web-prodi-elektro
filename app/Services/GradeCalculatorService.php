<?php

namespace App\Services;

class GradeCalculatorService
{
    /**
     * Menghitung nilai akhir, remedial tertinggi, dan mengkonversi ke huruf mutu.
     *
     * @param array $data Input nilai mentah dari request
     * @return array Data yang sudah diproses siap disimpan
     */
    public function calculate(array $data, \App\Models\Subject $subject): array
    {
        // Ambil nilai dasar (default 0 jika kosong)
        $tugas = $data['tugas'] ?? 0;
        $utsVal = $data['uts'] ?? 0;
        $uasVal = $data['uas'] ?? 0;
        $attendance = $data['attendance'] ?? 0;
        
        // Ambil nilai remedial (bisa null)
        $remedUts = isset($data['remedial_uts']) && $data['remedial_uts'] !== "" ? $data['remedial_uts'] : null;
        $remedUas = isset($data['remedial_uas']) && $data['remedial_uas'] !== "" ? $data['remedial_uas'] : null;

        // Backend Validation: Remedial hanya berlaku jika nilai asli < KKM
        if ($utsVal >= $subject->kkm_uts) {
            $remedUts = null;
        }
        
        if ($uasVal >= $subject->kkm_uas) {
            $remedUas = null;
        }

        // Logika Nilai Final: Jika remedial diisi, ambil yang tertinggi
        $utsFinal = ($remedUts !== null) ? max((float)$utsVal, (float)$remedUts) : (float)$utsVal;
        $uasFinal = ($remedUas !== null) ? max((float)$uasVal, (float)$remedUas) : (float)$uasVal;

        // Perhitungan Bobot Dinamis dari Subject
        $akhir = ($tugas * ($subject->weight_task / 100)) + 
                 ($utsFinal * ($subject->weight_uts / 100)) + 
                 ($uasFinal * ($subject->weight_uas / 100));

        // Penentuan Huruf Mutu (Grade) dan Grade Point
        if ($akhir >= 80) {
            $grade = 'A';
            $gradePoint = 4.0;
        } elseif ($akhir >= 70) {
            $grade = 'B';
            $gradePoint = 3.0;
        } elseif ($akhir >= 60) {
            $grade = 'C';
            $gradePoint = 2.0;
        } elseif ($akhir >= 50) {
            $grade = 'D';
            $gradePoint = 1.0;
        } else {
            $grade = 'E';
            $gradePoint = 0.0;
        }

        return [
            'attendance'   => $attendance,
            'tugas'        => $tugas,
            'uts'          => $utsVal,
            'remedial_uts' => $remedUts,
            'uas'          => $uasVal,
            'remedial_uas' => $remedUas,
            'grade'        => $grade,
            'final_score'  => round($akhir, 2),
            'grade_point'  => $gradePoint,
        ];
    }
}
