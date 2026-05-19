<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom-kolom profil akademik dosen ke tabel users.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nuptk', 20)->nullable()->after('nim');
            $table->string('nip', 25)->nullable()->after('nuptk');
            $table->date('tanggal_lahir')->nullable()->after('gender');
            $table->enum('status_pegawai', ['PNS', 'PPPK', 'CPNS', 'Honor'])->nullable()->after('role');
            $table->enum('status_keaktifan', ['Aktif', 'Tidak Aktif'])->nullable()->after('status_pegawai');
            $table->string('pangkat_terakhir')->nullable()->after('status_keaktifan');
            $table->string('golongan_terakhir', 10)->nullable()->after('pangkat_terakhir');
            $table->date('tmt_pangkat')->nullable()->after('golongan_terakhir');
            $table->string('jabatan_fungsional')->nullable()->after('tmt_pangkat');
            $table->date('tmt_jabfung')->nullable()->after('jabatan_fungsional');
            $table->enum('sertifikasi_dosen', ['Sertifikasi Dosen', 'Belum Sertifikasi Dosen'])->nullable()->after('tmt_jabfung');
            $table->unsignedSmallInteger('tahun_serdos')->nullable()->after('sertifikasi_dosen');
            $table->unsignedSmallInteger('masa_kerja_golongan')->nullable()->after('tahun_serdos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nuptk',
                'nip',
                'tanggal_lahir',
                'status_pegawai',
                'status_keaktifan',
                'pangkat_terakhir',
                'golongan_terakhir',
                'tmt_pangkat',
                'jabatan_fungsional',
                'tmt_jabfung',
                'sertifikasi_dosen',
                'tahun_serdos',
                'masa_kerja_golongan',
            ]);
        });
    }
};
