<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grade;
use Illuminate\Support\Facades\Auth;

class MahasiswaDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil jadwal utama + overrides untuk cohort mahasiswa ini
        $baseSchedules = \App\Models\Schedule::with(['dosen', 'subject', 'overrides'])
            ->where('cohort', $user->cohort) 
            ->get();

        // 2. Buat rentang 7 Hari (Senin - Minggu minggu ini)
        $startOfWeek = \Carbon\Carbon::now()->startOfWeek(); // Senin
        $weeklySchedules = [];

        $indonesianDays = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];

        for ($i = 0; $i < 7; $i++) {
            $currentDate = $startOfWeek->copy()->addDays($i);
            $dayNameEnglish = $currentDate->format('l');
            $dayNameIndo = $indonesianDays[$dayNameEnglish];

            // Filter jadwal dasar yang harinya sesuai
            $schedulesToday = $baseSchedules->filter(function($schedule) use ($dayNameIndo) {
                return $schedule->day === $dayNameIndo;
            })->map(function($schedule) use ($currentDate) {
                $item = clone $schedule;
                // Cek apakah ada override untuk tanggal ini
                $activeOverride = $schedule->overrides->firstWhere('override_date', $currentDate->format('Y-m-d'));
                
                if ($activeOverride) {
                    $item->is_overridden = true;
                    $item->override_status = $activeOverride->status;
                    if ($activeOverride->status === 'changed') {
                        $item->start_time = \Carbon\Carbon::parse($activeOverride->new_start_time)->format('H:i');
                        $item->end_time = \Carbon\Carbon::parse($activeOverride->new_end_time)->format('H:i');
                        $item->room = $activeOverride->new_room;
                    }
                    $item->override_note = $activeOverride->note;
                } else {
                    $item->is_overridden = false;
                }
                
                return $item;
            });

            $weeklySchedules[] = [
                'date'      => $currentDate,
                'day_name'  => $dayNameIndo,
                'schedules' => $schedulesToday->sortBy('start_time')->values()
            ];
        }

        // 3. Ambil pengumuman terbaru
        $announcements = \App\Models\Announcement::whereIn('target_role', ['all', 'mahasiswa'])
            ->orderBy('created_at', 'desc')->take(5)->get();

        $exams = \App\Models\Exam::with('subject')
            ->where('cohort', $user->cohort)
            ->where('date', '>=', \Carbon\Carbon::today())
            ->orderBy('date', 'asc')
            ->get();

        // 5. Ambil data prestasi
        $achievements = $user->achievements()->orderBy('date', 'desc')->get();

        // 6. Ambil data pelanggaran
        $violations = $user->violations()->orderBy('date', 'desc')->get();

        // 7. Ambil data kesemaptaan jasmani
        $fitnessTests = $user->fitnessTests()->orderBy('test_date', 'desc')->get();

        // 8. Ambil jadwal wali dosen (Meetings)
        $meetings = $user->meetingsAsStudent()->with('dosen')->orderBy('requested_date', 'desc')->get();
        
        // 9. Ambil semua dosen untuk form request
        $dosens = \App\Models\User::where('role', 'dosen')->get();

        return view('mahasiswa.dashboard', compact(
            'weeklySchedules', 'announcements', 'exams', 
            'achievements', 'violations', 'fitnessTests', 
            'meetings', 'dosens'
        ));
    }

    public function storeMeeting(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required|exists:users,id',
            'requested_date' => 'required|date|after_or_equal:today',
            'topic' => 'required|string|max:255'
        ]);

        \App\Models\Meeting::create([
            'student_id' => Auth::id(),
            'dosen_id' => $request->dosen_id,
            'requested_date' => $request->requested_date,
            'topic' => $request->topic,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Permintaan jadwal bimbingan berhasil dikirim!');
    }

    public function storeSuggestion(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'content' => 'required|string'
        ]);

        \App\Models\Suggestion::create([
            'user_id' => Auth::id(),
            'category' => $request->category,
            'content' => $request->content,
            'status' => 'unread'
        ]);

        return redirect()->back()->with('success', 'Saran Anda berhasil dikirim, terima kasih!');
    }

    public function nilai()
    {
        $userId = Auth::id();
        
        // Ambil daftar semester unik dari tabel subjects (mata kuliah)
        $semesters = \App\Models\Subject::distinct()
            ->orderBy('semester', 'asc')
            ->pluck('semester');

        return view('mahasiswa.nilai.index', compact('semesters'));
    }

    public function getNilaiData(Request $request)
    {
        $userId = Auth::id();
        $semester = $request->semester;

        if (!$semester) {
            return "Silakan pilih semester terlebih dahulu.";
        }

        // Ambil semua mata kuliah untuk semester tersebut
        // Beserta nilai milik mahasiswa yang login (jika ada)
        $subjects = \App\Models\Subject::where('semester', $semester)
            ->with(['grades' => function($q) use ($userId) {
                $q->where('user_id', $userId);
            }])
            ->orderBy('name', 'asc')
            ->get();

        $allSubjectsCount = $subjects->count();
        $gradedSubjectsCount = $subjects->filter(fn($s) => $s->grades->isNotEmpty())->count();
        
        $isSemesterComplete = ($allSubjectsCount > 0 && $allSubjectsCount === $gradedSubjectsCount);

        $ips = 0;
        $ipk = 0;
        $totalSksSemester = 0;
        $totalSksKumulatif = 0;

        if ($isSemesterComplete) {
            // Hitung IPS (Semester Ini)
            $totalMutuSemester = 0;
            foreach ($subjects as $subject) {
                $grade = $subject->grades->first();
                $totalSksSemester += $subject->sks;
                $totalMutuSemester += ($grade->grade_point * $subject->sks);
            }
            $ips = $totalSksSemester > 0 ? ($totalMutuSemester / $totalSksSemester) : 0;

            // Hitung IPK (Semua Semester 1 s/d Semester Ini)
            $allSubjectsUpToNow = \App\Models\Subject::where('semester', '<=', $semester)
                ->with(['grades' => function($q) use ($userId) {
                    $q->where('user_id', $userId);
                }])->get();
            
            $isAllComplete = $allSubjectsUpToNow->every(fn($s) => $s->grades->isNotEmpty());
            
            if ($isAllComplete) {
                $totalMutuKumulatif = 0;
                foreach ($allSubjectsUpToNow as $sub) {
                    $grade = $sub->grades->first();
                    $totalSksKumulatif += $sub->sks;
                    $totalMutuKumulatif += ($grade->grade_point * $sub->sks);
                }
                $ipk = $totalSksKumulatif > 0 ? ($totalMutuKumulatif / $totalSksKumulatif) : 0;
            } else {
                // Jika ada matkul semester sebelumnya yang belum masuk, batal tampilkan IPK
                $isSemesterComplete = false; 
            }
        }

        return view('mahasiswa.nilai.partial_table', compact(
            'subjects', 'semester', 'isSemesterComplete', 'ips', 'ipk', 'totalSksSemester', 'totalSksKumulatif'
        ));
    }
}
