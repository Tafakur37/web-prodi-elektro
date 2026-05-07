<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Import Controller
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminLogController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Mahasiswa\MahasiswaDashboardController;
use App\Http\Controllers\Mahasiswa\AttendanceController;
use App\Http\Controllers\Mahasiswa\ChatController;
use App\Http\Controllers\Mahasiswa\UkmController;
use App\Http\Controllers\Mahasiswa\ProfileController;
use App\Http\Controllers\Dosen\DosenDashboardController;
use App\Http\Controllers\Staff\StaffDashboardController;
use App\Http\Controllers\Sesprodi\SesprodiDashboardController;
use App\Http\Controllers\Kaprodi\KaprodiDashboardController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\Staff\AnnouncementController;

Route::get('/', [BerandaController::class, 'index'])->name('beranda');

Route::get('/home', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        return match ($role) {
            'admin'               => redirect()->route('admin.dashboard'),
            'staff'               => redirect()->route('staff.dashboard'),
            'dosen'               => redirect()->route('dosen.dashboard'),
            'mahasiswa'           => redirect()->route('mahasiswa.dashboard'),
            'sesprodi'            => redirect()->route('sesprodi.dashboard'),
            'kaprodi'             => redirect()->route('kaprodi.dashboard'),
            default               => redirect('/'),
        };
    }
    return redirect()->route('login');
})->name('home');

// AUTH ROUTES
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
// PROTECTED ROUTES
Route::middleware(['auth'])->group(function () {

    Route::get('/api/users-suggestions', [UserController::class, 'suggestions'])->name('global.users.suggestions');

    // Global Notifications
    Route::get('/notifications/fetch', [\App\Http\Controllers\NotificationController::class, 'fetch'])->name('notifications.fetch');
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Keep Alive Session
    Route::post('/session/keep-alive', function () {
        return response()->json(['status' => 'alive']);
    })->name('session.keep-alive');

    // Dismiss Suggestion (per-user, for staff/sesprodi/kaprodi)
    Route::post('/suggestions/{suggestion}/dismiss', function (\App\Models\Suggestion $suggestion) {
        $suggestion->dismissedBy()->syncWithoutDetaching([auth()->id()]);
        return back()->with('success', 'Saran berhasil dihapus dari daftar Anda.');
    })->name('suggestions.dismiss');

    // 1. ROLE: ADMIN
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::put('users/{user}/reset-password', [UserController::class, 'updatePassword'])->name('users.update_password');
        Route::get('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset_password');
        Route::get('documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/logs', [AdminLogController::class, 'index'])->name('logs.index');
        Route::get('/settings', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings/profile', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'updateProfile'])->name('settings.profile');
        Route::put('/settings/password', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'updatePassword'])->name('settings.password');
        Route::put('/settings/preferences', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'updatePreferences'])->name('settings.preferences');
        Route::get('/input-nilai', [GradeController::class, 'inputNilai'])->name('nilai.index');
        Route::get('/get-subjects', [GradeController::class, 'getSubjects'])->name('getSubjects');
        Route::get('/get-students', [GradeController::class, 'getStudents'])->name('getStudents');
        Route::post('/store-nilai', [GradeController::class, 'storeNilai'])->name('nilai.store');
        Route::resource('documents', DocumentController::class)->only(['index', 'store', 'destroy']);
        Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'destroy']);
        Route::resource('materials', MaterialController::class)->only(['index', 'create', 'store', 'destroy']);
        Route::resource('schedules', ScheduleController::class)->only(['index', 'store', 'destroy']);
        Route::post('/schedules/{schedule}/overrides', [\App\Http\Controllers\Staff\ScheduleOverrideController::class, 'store'])->name('schedules.overrides.store');
        Route::delete('/schedule-overrides/{override}', [\App\Http\Controllers\Staff\ScheduleOverrideController::class, 'destroy'])->name('schedules.overrides.destroy');
        Route::resource('subjects', SubjectController::class)->only(['index', 'store', 'update', 'destroy']);
    });

    // 2. ROLE: STAFF PRODI (Admin also accesses these)
    Route::middleware(['role:staff'])->prefix('staff')->name('staff.')->group(function () {
        Route::resource('violations', \App\Http\Controllers\Staff\ViolationController::class)->except(['show']);
        Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [\App\Http\Controllers\Staff\StaffController::class, 'profile'])->name('profile');
        Route::put('/profile', [\App\Http\Controllers\Staff\StaffController::class, 'updateProfile'])->name('profile.update');

        // Akademik
        Route::get('/attendances', [\App\Http\Controllers\Staff\AttendanceController::class, 'index'])->name('attendances.index');
        Route::get('/grades/recap', [\App\Http\Controllers\Staff\GradeController::class, 'recap'])->name('grades.recap');
        Route::get('/grades/recap-data', [\App\Http\Controllers\Staff\GradeController::class, 'getRecapData'])->name('grades.recapData');
        Route::resource('schedules', \App\Http\Controllers\Staff\ScheduleController::class);
        Route::post('/schedules/{schedule}/overrides', [\App\Http\Controllers\Staff\ScheduleOverrideController::class, 'store'])->name('schedules.overrides.store');
        Route::delete('/schedule-overrides/{override}', [\App\Http\Controllers\Staff\ScheduleOverrideController::class, 'destroy'])->name('schedules.overrides.destroy');
        Route::resource('exams', \App\Http\Controllers\Staff\ExamController::class);

        // Kesiswaan
        Route::resource('students', \App\Http\Controllers\Staff\StudentController::class);
        Route::put('students/{student}/reset-password', [\App\Http\Controllers\Staff\StudentController::class, 'resetPassword'])->name('students.reset_password');

        Route::get('chats', [\App\Http\Controllers\Staff\ChatController::class, 'index'])->name('chats.index');
        Route::get('chats/get-students', [\App\Http\Controllers\Staff\ChatController::class, 'getStudents'])->name('chats.getStudents');
        Route::get('chats/{id}', [\App\Http\Controllers\Staff\ChatController::class, 'show'])->name('chats.show');
        Route::post('chats/{id}', [\App\Http\Controllers\Staff\ChatController::class, 'store'])->name('chats.store');

        Route::resource('achievements', \App\Http\Controllers\Staff\AchievementController::class);
        Route::resource('fitness-tests', \App\Http\Controllers\Staff\FitnessTestController::class);

        // Komunikasi & Administrasi
        Route::resource('announcements', \App\Http\Controllers\Staff\AnnouncementController::class);

        // Verifikasi Submissions
        Route::get('/submissions', [\App\Http\Controllers\Staff\SubmissionController::class, 'index'])->name('submissions.index');
        Route::get('/submissions/{submission}/show', [\App\Http\Controllers\Staff\SubmissionController::class, 'show'])->name('submissions.show');
        Route::put('/submissions/{submission}/status', [\App\Http\Controllers\Staff\SubmissionController::class, 'updateStatus'])->name('submissions.updateStatus');

        Route::resource('documents', \App\Http\Controllers\Staff\DocumentController::class);
        Route::resource('subjects', SubjectController::class);
    });

    // 3. ROLE: DOSEN
    Route::middleware(['role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
        Route::get('/dashboard', [DosenDashboardController::class, 'index'])->name('dashboard');
        Route::get('/input-nilai', [GradeController::class, 'inputNilai'])->name('nilai.index');
        Route::get('/get-subjects', [GradeController::class, 'getSubjects'])->name('getSubjects');
        Route::get('/get-students', [GradeController::class, 'getStudents'])->name('getStudents');
        Route::post('/store-nilai', [GradeController::class, 'storeNilai'])->name('nilai.store');

        // Materials
        Route::get('/materials', [\App\Http\Controllers\Dosen\MaterialController::class, 'index'])->name('materials.index');
        Route::get('/materials/create', [\App\Http\Controllers\Dosen\MaterialController::class, 'create'])->name('materials.create');
        Route::post('/materials', [\App\Http\Controllers\Dosen\MaterialController::class, 'store'])->name('materials.store');
        Route::delete('/materials/{material}', [\App\Http\Controllers\Dosen\MaterialController::class, 'destroy'])->name('materials.destroy');

        // New DOSEN features
        Route::resource('attendances', \App\Http\Controllers\Dosen\AttendanceController::class);
        Route::get('meetings/get-students', [\App\Http\Controllers\Dosen\MeetingController::class, 'getStudents'])->name('meetings.getStudents');
        Route::resource('meetings', \App\Http\Controllers\Dosen\MeetingController::class);
        Route::get('chats', [\App\Http\Controllers\Dosen\ChatController::class, 'index'])->name('chats.index');
        Route::get('chats/get-students', [\App\Http\Controllers\Dosen\ChatController::class, 'getStudents'])->name('chats.getStudents');
        Route::get('chats/{id}', [\App\Http\Controllers\Dosen\ChatController::class, 'show'])->name('chats.show');
        Route::post('chats/{id}', [\App\Http\Controllers\Dosen\ChatController::class, 'store'])->name('chats.store');
        Route::get('profile', [\App\Http\Controllers\Dosen\ProfileController::class, 'index'])->name('profile.index');
        Route::get('accounts', [\App\Http\Controllers\Dosen\AccountsController::class, 'index'])->name('accounts.index');
    });


    // 4. ROLE: MAHASISWA
    Route::middleware(['role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('violations', [\App\Http\Controllers\Mahasiswa\ViolationController::class, 'index'])->name('violations.index');
        Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('dashboard');
        Route::post('/dashboard/meeting', [MahasiswaDashboardController::class, 'storeMeeting'])->name('dashboard.meeting.store');
        Route::post('/dashboard/suggestion', [MahasiswaDashboardController::class, 'storeSuggestion'])->name('dashboard.suggestion.store');
        Route::get('/nilai', [MahasiswaDashboardController::class, 'nilai'])->name('nilai.index');
        Route::get('/nilai/data', [MahasiswaDashboardController::class, 'getNilaiData'])->name('nilai.data');

        // Materials
        Route::get('/materials', [\App\Http\Controllers\Mahasiswa\MaterialController::class, 'index'])->name('materials.index');
        Route::get('/materials/{material}/show', [\App\Http\Controllers\Mahasiswa\MaterialController::class, 'show'])->name('materials.show');
        Route::get('/materials/{material}/download', [\App\Http\Controllers\Mahasiswa\MaterialController::class, 'download'])->name('materials.download');

        // Submissions
        Route::get('/submissions', [\App\Http\Controllers\Mahasiswa\SubmissionController::class, 'index'])->name('submissions.index');
        Route::get('/submissions/create', [\App\Http\Controllers\Mahasiswa\SubmissionController::class, 'create'])->name('submissions.create');
        Route::post('/submissions', [\App\Http\Controllers\Mahasiswa\SubmissionController::class, 'store'])->name('submissions.store');
        Route::get('/submissions/{submission}/show', [\App\Http\Controllers\Mahasiswa\SubmissionController::class, 'show'])->name('submissions.show');
        Route::get('/submissions/{submission}/edit', [\App\Http\Controllers\Mahasiswa\SubmissionController::class, 'edit'])->name('submissions.edit');
        Route::put('/submissions/{submission}', [\App\Http\Controllers\Mahasiswa\SubmissionController::class, 'update'])->name('submissions.update');
        Route::delete('/submissions/{submission}', [\App\Http\Controllers\Mahasiswa\SubmissionController::class, 'destroy'])->name('submissions.destroy');

        // Attendances
        Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');

        // Chats
        Route::get('/chats', [ChatController::class, 'index'])->name('chats.index');
        Route::get('/chats/{id}', [ChatController::class, 'show'])->name('chats.show');
        Route::post('/chats/{id}', [ChatController::class, 'store'])->name('chats.store');

        // UKMs
        Route::get('/ukms', [UkmController::class, 'index'])->name('ukms.index');

        // Profile
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });

    // 5. ROLE: SESPRODI
    Route::middleware(['role:sesprodi'])->prefix('sesprodi')->name('sesprodi.')->group(function () {
        Route::get('/dashboard', [SesprodiDashboardController::class, 'index'])->name('dashboard');
    });

    // 6. ROLE: KAPRODI
    Route::middleware(['role:kaprodi'])->prefix('kaprodi')->name('kaprodi.')->group(function () {
        Route::get('/dashboard', [KaprodiDashboardController::class, 'index'])->name('dashboard');
    });
});
