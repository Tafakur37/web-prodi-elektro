<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Core Controllers
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
use App\Http\Controllers\FileExplorerController;
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

// Shared Controllers (Admin-Centric Architecture)
use App\Http\Controllers\Shared\DocumentController as SharedDocumentController;
use App\Http\Controllers\Shared\MaterialController as SharedMaterialController;

// =============================================================================
// ROUTE MACRO: Berkas (File Manager Modern)
// Satu definisi untuk semua role — menghindari duplikasi x4
// =============================================================================
Route::macro('registerBerkasRoutes', function () {
    Route::get('/berkas/shared',         [\App\Http\Controllers\Shared\BerkasController::class, 'shared'])->name('berkas.shared');
    Route::get('/berkas/recent',         [\App\Http\Controllers\Shared\BerkasController::class, 'recent'])->name('berkas.recent');
    Route::get('/berkas/starred',        [\App\Http\Controllers\Shared\BerkasController::class, 'starred'])->name('berkas.starred');
    Route::get('/berkas/trash',          [\App\Http\Controllers\Shared\BerkasController::class, 'trash'])->name('berkas.trash');
    
    // Core actions
    Route::post('/berkas/folder',        [\App\Http\Controllers\Shared\BerkasFolderController::class, 'store'])->name('berkas.folder.store');
    Route::put('/berkas/folder/{id}',    [\App\Http\Controllers\Shared\BerkasFolderController::class, 'update'])->name('berkas.folder.update');
    Route::delete('/berkas/folder/{id}', [\App\Http\Controllers\Shared\BerkasFolderController::class, 'destroy'])->name('berkas.folder.destroy');
    Route::post('/berkas/folder/{id}/restore', [\App\Http\Controllers\Shared\BerkasFolderController::class, 'restore'])->name('berkas.folder.restore');
    Route::delete('/berkas/folder/{id}/force', [\App\Http\Controllers\Shared\BerkasFolderController::class, 'forceDelete'])->name('berkas.folder.forceDelete');
    
    Route::post('/berkas/file',          [\App\Http\Controllers\Shared\BerkasFileController::class, 'upload'])->name('berkas.file.upload');
    Route::put('/berkas/file/{id}',      [\App\Http\Controllers\Shared\BerkasFileController::class, 'update'])->name('berkas.file.update');
    Route::delete('/berkas/file/{id}',   [\App\Http\Controllers\Shared\BerkasFileController::class, 'destroy'])->name('berkas.file.destroy');
    Route::post('/berkas/file/{id}/restore', [\App\Http\Controllers\Shared\BerkasFileController::class, 'restore'])->name('berkas.file.restore');
    Route::delete('/berkas/file/{id}/force', [\App\Http\Controllers\Shared\BerkasFileController::class, 'forceDelete'])->name('berkas.file.forceDelete');
    Route::get('/berkas/file/{id}/download', [\App\Http\Controllers\Shared\BerkasFileController::class, 'download'])->name('berkas.file.download');
    Route::get('/berkas/file/{id}/preview',  [\App\Http\Controllers\Shared\BerkasFileController::class, 'preview'])->name('berkas.file.preview');

    // Star
    Route::post('/berkas/star/toggle',   [\App\Http\Controllers\Shared\BerkasStarController::class, 'toggleStar'])->name('berkas.star.toggle');
    
    // Index fallback (must be at the bottom of the macro)
    Route::get('/berkas/{folder_id?}',   [\App\Http\Controllers\Shared\BerkasController::class, 'index'])->name('berkas.index');
});

// =============================================================================
// PUBLIC ROUTES
// =============================================================================
Route::get('/', [BerandaController::class, 'index'])->name('beranda');

Route::get('/home', function () {
    if (Auth::check()) {
        return match (Auth::user()->role) {
            'admin'     => redirect()->route('admin.dashboard'),
            'staff'     => redirect()->route('staff.dashboard'),
            'dosen'     => redirect()->route('dosen.dashboard'),
            'mahasiswa' => redirect()->route('mahasiswa.dashboard'),
            'sesprodi'  => redirect()->route('sesprodi.dashboard'),
            'kaprodi'   => redirect()->route('kaprodi.dashboard'),
            default     => redirect('/'),
        };
    }
    return redirect()->route('beranda');
})->name('home');

// AUTH
Route::get('/login',          [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login',         [LoginController::class, 'login']);
Route::post('/logout',        [LoginController::class, 'logout'])->name('logout');
Route::get('/register',       [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register',      [RegisterController::class, 'register']);
Route::get('password/reset',  [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// =============================================================================
// PROTECTED ROUTES (auth required)
// =============================================================================
Route::middleware(['auth'])->group(function () {

    // Global API & Utilities
    Route::get('/api/users-suggestions',    [UserController::class, 'suggestions'])->name('global.users.suggestions');
    Route::get('/notifications/fetch',      [\App\Http\Controllers\NotificationController::class, 'fetch'])->name('notifications.fetch');
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/session/keep-alive',      fn() => response()->json(['status' => 'alive']))->name('session.keep-alive');

    Route::post('/suggestions/{suggestion}/dismiss', function (\App\Models\Suggestion $suggestion) {
        $suggestion->dismissedBy()->syncWithoutDetaching([auth()->id()]);
        return back()->with('success', 'Saran berhasil dihapus dari daftar Anda.');
    })->name('suggestions.dismiss');

    // =========================================================================
    // 1. ADMIN (Super Role — akses semua fitur)
    // =========================================================================
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Pengaturan & Manajemen
        Route::get('/logs',                 [AdminLogController::class, 'index'])->name('logs.index');
        Route::get('/settings',             [\App\Http\Controllers\Admin\AdminSettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings/profile',     [\App\Http\Controllers\Admin\AdminSettingsController::class, 'updateProfile'])->name('settings.profile');
        Route::put('/settings/password',    [\App\Http\Controllers\Admin\AdminSettingsController::class, 'updatePassword'])->name('settings.password');
        Route::put('/settings/preferences', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'updatePreferences'])->name('settings.preferences');

        // Users
        Route::put('users/{user}/reset-password', [UserController::class, 'updatePassword'])->name('users.update_password');
        Route::get('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset_password');
        Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'destroy']);

        // Akademik
        Route::get('/input-nilai',  [GradeController::class, 'inputNilai'])->name('nilai.index');
        Route::get('/get-subjects', [GradeController::class, 'getSubjects'])->name('getSubjects');
        Route::get('/get-students', [GradeController::class, 'getStudents'])->name('getStudents');
        Route::post('/store-nilai', [GradeController::class, 'storeNilai'])->name('nilai.store');
        Route::resource('subjects',  SubjectController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('schedules', ScheduleController::class)->only(['index', 'store', 'destroy']);
        Route::post('/schedules/{schedule}/overrides',  [\App\Http\Controllers\Staff\ScheduleOverrideController::class, 'store'])->name('schedules.overrides.store');
        Route::delete('/schedule-overrides/{override}', [\App\Http\Controllers\Staff\ScheduleOverrideController::class, 'destroy'])->name('schedules.overrides.destroy');

        // Dokumen (Shared Controller)
        Route::get('documents/{document}/download', [SharedDocumentController::class, 'download'])->name('documents.download');
        Route::put('documents/{document}/status',   [SharedDocumentController::class, 'updateStatus'])->name('documents.status');
        Route::resource('documents', SharedDocumentController::class)->only(['index', 'store', 'destroy']);

        // Material (Shared Controller)
        Route::resource('materials', SharedMaterialController::class)->only(['index', 'create', 'store', 'destroy']);

        // Berkas (File Explorer — deduplicated macro)
        Route::registerBerkasRoutes();
    });

    // =========================================================================
    // 2. STAFF PRODI
    // =========================================================================
    Route::middleware(['role:staff'])->prefix('staff')->name('staff.')->group(function () {

        Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile',   [StaffController::class, 'profile'])->name('profile');
        Route::put('/profile',   [StaffController::class, 'updateProfile'])->name('profile.update');

        // Akademik
        Route::get('/attendances',       [\App\Http\Controllers\Staff\AttendanceController::class, 'index'])->name('attendances.index');
        Route::get('/grades/recap',      [\App\Http\Controllers\Staff\GradeController::class, 'recap'])->name('grades.recap');
        Route::get('/grades/recap-data', [\App\Http\Controllers\Staff\GradeController::class, 'getRecapData'])->name('grades.recapData');
        Route::resource('schedules', \App\Http\Controllers\Staff\ScheduleController::class);
        Route::post('/schedules/{schedule}/overrides',  [\App\Http\Controllers\Staff\ScheduleOverrideController::class, 'store'])->name('schedules.overrides.store');
        Route::delete('/schedule-overrides/{override}', [\App\Http\Controllers\Staff\ScheduleOverrideController::class, 'destroy'])->name('schedules.overrides.destroy');
        Route::resource('exams',    \App\Http\Controllers\Staff\ExamController::class);
        Route::resource('subjects', SubjectController::class);

        // Kesiswaan
        Route::resource('students',     \App\Http\Controllers\Staff\StudentController::class);
        Route::put('students/{student}/reset-password', [\App\Http\Controllers\Staff\StudentController::class, 'resetPassword'])->name('students.reset_password');
        Route::resource('violations',    \App\Http\Controllers\Staff\ViolationController::class)->except(['show']);
        Route::resource('achievements',  \App\Http\Controllers\Staff\AchievementController::class);
        Route::resource('fitness-tests', \App\Http\Controllers\Staff\FitnessTestController::class);

        // Komunikasi
        Route::get('chats',              [\App\Http\Controllers\Staff\ChatController::class, 'index'])->name('chats.index');
        Route::get('chats/get-students', [\App\Http\Controllers\Staff\ChatController::class, 'getStudents'])->name('chats.getStudents');
        Route::get('chats/{id}',         [\App\Http\Controllers\Staff\ChatController::class, 'show'])->name('chats.show');
        Route::post('chats/{id}',        [\App\Http\Controllers\Staff\ChatController::class, 'store'])->name('chats.store');
        Route::resource('announcements', AnnouncementController::class);

        // Dokumen (Shared Controller)
        Route::get('documents/{document}/download', [SharedDocumentController::class, 'download'])->name('documents.download');
        Route::put('documents/{document}/status',   [SharedDocumentController::class, 'updateStatus'])->name('documents.status');
        Route::resource('documents', SharedDocumentController::class);

        // Verifikasi Submissions (mahasiswa pengajuan surat)
        Route::get('/submissions',                     [\App\Http\Controllers\Staff\SubmissionController::class, 'index'])->name('submissions.index');
        Route::get('/submissions/{submission}/show',   [\App\Http\Controllers\Staff\SubmissionController::class, 'show'])->name('submissions.show');
        Route::put('/submissions/{submission}/status', [\App\Http\Controllers\Staff\SubmissionController::class, 'updateStatus'])->name('submissions.updateStatus');

        // Berkas
        Route::registerBerkasRoutes();
    });

    // =========================================================================
    // 3. DOSEN
    // =========================================================================
    Route::middleware(['role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {

        Route::get('/dashboard', [DosenDashboardController::class, 'index'])->name('dashboard');

        // Nilai
        Route::get('/input-nilai',  [GradeController::class, 'inputNilai'])->name('nilai.index');
        Route::get('/get-subjects', [GradeController::class, 'getSubjects'])->name('getSubjects');
        Route::get('/get-students', [GradeController::class, 'getStudents'])->name('getStudents');
        Route::post('/store-nilai', [GradeController::class, 'storeNilai'])->name('nilai.store');

        // Material (Shared Controller)
        Route::get('/materials',              [SharedMaterialController::class, 'index'])->name('materials.index');
        Route::get('/materials/create',       [SharedMaterialController::class, 'create'])->name('materials.create');
        Route::post('/materials',             [SharedMaterialController::class, 'store'])->name('materials.store');
        Route::delete('/materials/{material}',[SharedMaterialController::class, 'destroy'])->name('materials.destroy');

        // Absensi & Pertemuan
        Route::resource('attendances', \App\Http\Controllers\Dosen\AttendanceController::class);
        Route::get('meetings/get-students',  [\App\Http\Controllers\Dosen\MeetingController::class, 'getStudents'])->name('meetings.getStudents');
        Route::resource('meetings', \App\Http\Controllers\Dosen\MeetingController::class);

        // Chat
        Route::get('chats',              [\App\Http\Controllers\Dosen\ChatController::class, 'index'])->name('chats.index');
        Route::get('chats/get-students', [\App\Http\Controllers\Dosen\ChatController::class, 'getStudents'])->name('chats.getStudents');
        Route::get('chats/{id}',         [\App\Http\Controllers\Dosen\ChatController::class, 'show'])->name('chats.show');
        Route::post('chats/{id}',        [\App\Http\Controllers\Dosen\ChatController::class, 'store'])->name('chats.store');

        // Profil & Akun
        Route::get('profile',  [\App\Http\Controllers\Dosen\ProfileController::class, 'index'])->name('profile.index');
        Route::get('accounts', [\App\Http\Controllers\Dosen\AccountsController::class, 'index'])->name('accounts.index');

        // Berkas
        Route::registerBerkasRoutes();
    });

    // =========================================================================
    // 4. MAHASISWA
    // =========================================================================
    Route::middleware(['role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {

        Route::get('/dashboard',            [MahasiswaDashboardController::class, 'index'])->name('dashboard');
        Route::post('/dashboard/meeting',   [MahasiswaDashboardController::class, 'storeMeeting'])->name('dashboard.meeting.store');
        Route::post('/dashboard/suggestion',[MahasiswaDashboardController::class, 'storeSuggestion'])->name('dashboard.suggestion.store');

        // Akademik
        Route::get('/nilai',       [MahasiswaDashboardController::class, 'nilai'])->name('nilai.index');
        Route::get('/nilai/data',  [MahasiswaDashboardController::class, 'getNilaiData'])->name('nilai.data');
        Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');

        // Material (Shared Controller)
        Route::get('/materials',                     [SharedMaterialController::class, 'index'])->name('materials.index');
        Route::get('/materials/{material}/show',     [SharedMaterialController::class, 'show'])->name('materials.show');
        Route::get('/materials/{material}/download', [SharedMaterialController::class, 'download'])->name('materials.download');

        // Surat (Submissions)
        Route::get('/submissions',                   [\App\Http\Controllers\Mahasiswa\SubmissionController::class, 'index'])->name('submissions.index');
        Route::get('/submissions/create',            [\App\Http\Controllers\Mahasiswa\SubmissionController::class, 'create'])->name('submissions.create');
        Route::post('/submissions',                  [\App\Http\Controllers\Mahasiswa\SubmissionController::class, 'store'])->name('submissions.store');
        Route::get('/submissions/{submission}/show', [\App\Http\Controllers\Mahasiswa\SubmissionController::class, 'show'])->name('submissions.show');
        Route::get('/submissions/{submission}/edit', [\App\Http\Controllers\Mahasiswa\SubmissionController::class, 'edit'])->name('submissions.edit');
        Route::put('/submissions/{submission}',      [\App\Http\Controllers\Mahasiswa\SubmissionController::class, 'update'])->name('submissions.update');
        Route::delete('/submissions/{submission}',   [\App\Http\Controllers\Mahasiswa\SubmissionController::class, 'destroy'])->name('submissions.destroy');

        // Aktivitas
        Route::get('violations',   [\App\Http\Controllers\Mahasiswa\ViolationController::class, 'index'])->name('violations.index');

        // Chat, UKM, Profil
        Route::get('/chats',       [ChatController::class, 'index'])->name('chats.index');
        Route::get('/chats/{id}',  [ChatController::class, 'show'])->name('chats.show');
        Route::post('/chats/{id}', [ChatController::class, 'store'])->name('chats.store');
        Route::get('/ukms',        [UkmController::class, 'index'])->name('ukms.index');
        Route::get('/profile',     [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile',    [ProfileController::class, 'update'])->name('profile.update');

        // Berkas
        Route::registerBerkasRoutes();
    });

    // =========================================================================
    // 5. SESPRODI
    // =========================================================================
    Route::middleware(['role:sesprodi'])->prefix('sesprodi')->name('sesprodi.')->group(function () {
        Route::get('/dashboard', [SesprodiDashboardController::class, 'index'])->name('dashboard');
        
        // Dokumen (Surat & Berkas Masuk)
        Route::get('documents/{document}/download', [SharedDocumentController::class, 'download'])->name('documents.download');
        Route::put('documents/{document}/status',   [SharedDocumentController::class, 'updateStatus'])->name('documents.status');
        Route::resource('documents', SharedDocumentController::class)->only(['index']);
    });

    // =========================================================================
    // 6. KAPRODI
    // =========================================================================
    Route::middleware(['role:kaprodi'])->prefix('kaprodi')->name('kaprodi.')->group(function () {
        Route::get('/dashboard', [KaprodiDashboardController::class, 'index'])->name('dashboard');

        // Dokumen (Surat & Berkas Masuk)
        Route::get('documents/{document}/download', [SharedDocumentController::class, 'download'])->name('documents.download');
        Route::put('documents/{document}/status',   [SharedDocumentController::class, 'updateStatus'])->name('documents.status');
        Route::resource('documents', SharedDocumentController::class)->only(['index']);
    });
});
