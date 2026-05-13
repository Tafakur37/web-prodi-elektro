<?php

/**
 * =============================================================================
 * CENTRALIZED PERMISSION MATRIX — SIMelek
 * =============================================================================
 *
 * Ini adalah pusat kontrol izin seluruh fitur sistem.
 * Admin memiliki akses ke semua fitur tanpa perlu didaftarkan di sini.
 *
 * Format:
 *   'nama_fitur' => [
 *       'aksi' => ['role1', 'role2', ...]
 *   ]
 *
 * Aksi standar:
 *   - view_own    : Hanya bisa lihat data milik sendiri
 *   - view_all    : Bisa lihat semua data
 *   - create      : Bisa membuat/submit data baru
 *   - edit        : Bisa mengubah data
 *   - delete      : Bisa menghapus data
 *   - approve     : Bisa approve/reject
 *   - export      : Bisa export data
 *   - monitoring  : Akses halaman monitoring/statistik
 *
 * CATATAN: 'admin' SELALU punya akses ke semua fitur (handled by RoleManager).
 * Daftarkan di sini hanya role non-admin.
 * =============================================================================
 */

return [

    // -------------------------------------------------------------------------
    // SIDEBAR — kontrol kategori menu mana yang muncul per role
    // -------------------------------------------------------------------------
    'sidebar' => [
        'akademik'   => ['mahasiswa', 'dosen', 'staff', 'sesprodi', 'kaprodi'],
        'komunikasi' => ['mahasiswa', 'dosen', 'staff', 'sesprodi', 'kaprodi'],
        'mahasiswa'  => ['staff', 'sesprodi', 'kaprodi'],
        'manajemen'  => ['mahasiswa', 'dosen', 'staff', 'sesprodi', 'kaprodi'],
        'pengaturan' => ['mahasiswa', 'dosen', 'staff', 'sesprodi', 'kaprodi'],
    ],

    // -------------------------------------------------------------------------
    // SURAT & DOKUMEN (submissions/documents)
    // -------------------------------------------------------------------------
    'documents' => [
        'view_own'   => ['mahasiswa'],
        'view_all'   => ['staff', 'sesprodi', 'kaprodi'],
        'create'     => ['mahasiswa', 'staff'],
        'edit'       => ['staff', 'sesprodi'],
        'delete'     => [],           // admin only
        'approve'    => ['staff', 'sesprodi', 'kaprodi'],
        'export'     => ['staff', 'sesprodi', 'kaprodi'],
        'monitoring' => ['staff', 'sesprodi', 'kaprodi'],
    ],

    // -------------------------------------------------------------------------
    // BERKAS (File Explorer)
    // -------------------------------------------------------------------------
    'berkas' => [
        'view_own'   => ['mahasiswa', 'dosen'],
        'view_all'   => ['staff', 'sesprodi', 'kaprodi'],
        'create'     => ['mahasiswa', 'dosen', 'staff'],
        'edit'       => ['staff'],
        'delete'     => [],           // admin only
        'upload'     => ['mahasiswa', 'dosen', 'staff'],
    ],

    // -------------------------------------------------------------------------
    // ABSENSI
    // -------------------------------------------------------------------------
    'attendances' => [
        'view_own'   => ['mahasiswa'],
        'view_all'   => ['dosen', 'staff', 'sesprodi', 'kaprodi'],
        'create'     => ['dosen'],          // dosen input absensi
        'edit'       => ['dosen', 'staff'],
        'delete'     => [],
        'export'     => ['staff', 'sesprodi', 'kaprodi'],
        'monitoring' => ['staff', 'sesprodi', 'kaprodi'],
    ],

    // -------------------------------------------------------------------------
    // NILAI (Grades)
    // -------------------------------------------------------------------------
    'grades' => [
        'view_own'   => ['mahasiswa'],
        'view_all'   => ['staff', 'sesprodi', 'kaprodi'],
        'create'     => ['dosen'],          // input nilai
        'edit'       => ['dosen'],
        'delete'     => [],
        'export'     => ['staff', 'sesprodi', 'kaprodi'],
        'monitoring' => ['staff', 'sesprodi', 'kaprodi'],
        'recap'      => ['staff', 'sesprodi', 'kaprodi'],
    ],

    // -------------------------------------------------------------------------
    // BAHAN AJAR (Materials)
    // -------------------------------------------------------------------------
    'materials' => [
        'view_own'   => [],
        'view_all'   => ['mahasiswa', 'dosen', 'staff'],
        'create'     => ['dosen', 'staff'],
        'edit'       => ['dosen', 'staff'],
        'delete'     => ['dosen'],          // dosen hapus miliknya sendiri
        'download'   => ['mahasiswa', 'dosen', 'staff'],
    ],

    // -------------------------------------------------------------------------
    // JADWAL KULIAH (Schedules)
    // -------------------------------------------------------------------------
    'schedules' => [
        'view_own'   => [],
        'view_all'   => ['mahasiswa', 'dosen', 'staff', 'sesprodi', 'kaprodi'],
        'create'     => ['staff'],
        'edit'       => ['staff'],
        'delete'     => [],
    ],

    // -------------------------------------------------------------------------
    // JADWAL UJIAN (Exams)
    // -------------------------------------------------------------------------
    'exams' => [
        'view_own'   => [],
        'view_all'   => ['mahasiswa', 'dosen', 'staff', 'sesprodi', 'kaprodi'],
        'create'     => ['staff'],
        'edit'       => ['staff'],
        'delete'     => [],
    ],

    // -------------------------------------------------------------------------
    // MATA KULIAH (Subjects)
    // -------------------------------------------------------------------------
    'subjects' => [
        'view_all'   => ['dosen', 'staff', 'sesprodi', 'kaprodi'],
        'create'     => ['staff'],
        'edit'       => ['staff'],
        'delete'     => [],
    ],

    // -------------------------------------------------------------------------
    // PELANGGARAN (Violations)
    // -------------------------------------------------------------------------
    'violations' => [
        'view_own'   => ['mahasiswa'],
        'view_all'   => ['staff', 'sesprodi', 'kaprodi'],
        'create'     => ['staff'],
        'edit'       => ['staff'],
        'delete'     => [],
        'export'     => ['staff', 'sesprodi', 'kaprodi'],
        'monitoring' => ['staff', 'sesprodi', 'kaprodi'],
    ],

    // -------------------------------------------------------------------------
    // GARJAS / KESEMAPTAAN (Fitness Tests)
    // -------------------------------------------------------------------------
    'fitness_tests' => [
        'view_own'   => ['mahasiswa'],
        'view_all'   => ['staff', 'sesprodi', 'kaprodi'],
        'create'     => ['staff'],
        'edit'       => ['staff'],
        'delete'     => [],
    ],

    // -------------------------------------------------------------------------
    // PRESTASI (Achievements)
    // -------------------------------------------------------------------------
    'achievements' => [
        'view_own'   => ['mahasiswa'],
        'view_all'   => ['staff', 'sesprodi', 'kaprodi'],
        'create'     => ['staff'],
        'edit'       => ['staff'],
        'delete'     => [],
    ],

    // -------------------------------------------------------------------------
    // CHAT
    // -------------------------------------------------------------------------
    'chats' => [
        'view_own'   => ['mahasiswa', 'dosen', 'staff'],
        'view_all'   => ['staff'],
        'create'     => ['mahasiswa', 'dosen', 'staff'],
    ],

    // -------------------------------------------------------------------------
    // PENGUMUMAN (Announcements)
    // -------------------------------------------------------------------------
    'announcements' => [
        'view_all'   => ['mahasiswa', 'dosen', 'staff', 'sesprodi', 'kaprodi'],
        'create'     => ['staff'],
        'edit'       => ['staff'],
        'delete'     => [],
    ],

    // -------------------------------------------------------------------------
    // MANAJEMEN USER
    // -------------------------------------------------------------------------
    'users' => [
        'view_all'   => ['staff'],
        'create'     => ['staff'],
        'edit'       => ['staff'],
        'delete'     => [],
        'reset_password' => ['staff'],
    ],

    // -------------------------------------------------------------------------
    // LOGS & AKTIVITAS
    // -------------------------------------------------------------------------
    'logs' => [
        'view_all'   => ['sesprodi', 'kaprodi'],
        'export'     => [],
    ],

    // -------------------------------------------------------------------------
    // PENGATURAN / PROFIL
    // -------------------------------------------------------------------------
    'settings' => [
        'view_own'   => ['mahasiswa', 'dosen', 'staff', 'sesprodi', 'kaprodi'],
        'edit'       => ['mahasiswa', 'dosen', 'staff', 'sesprodi', 'kaprodi'],
    ],

    // -------------------------------------------------------------------------
    // MEETING (Konsultasi Dosen)
    // -------------------------------------------------------------------------
    'meetings' => [
        'view_own'   => ['mahasiswa', 'dosen'],
        'create'     => ['mahasiswa'],
        'approve'    => ['dosen'],
    ],

    // -------------------------------------------------------------------------
    // UKM
    // -------------------------------------------------------------------------
    'ukm' => [
        'view_all'   => ['mahasiswa'],
    ],

];
