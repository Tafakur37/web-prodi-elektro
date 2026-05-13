@extends('layouts.app')
@section('title', 'Jadwal Kuliah')

@section('content')

{{-- Page Header --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h2 style="font-size:1.4rem;font-weight:800;color:#1e293b;margin:0;">
            <i class="bi bi-calendar3 me-2" style="color:#6366f1;"></i>Jadwal Kuliah
        </h2>
        <p style="color:#94a3b8;font-size:.82rem;margin:4px 0 0;">
            Kelola waktu perkuliahan, dosen, dan ruangan kelas.
        </p>
    </div>
    <button type="button" class="btn fw-semibold"
            data-bs-toggle="modal" data-bs-target="#addScheduleModal"
            style="background:linear-gradient(135deg,#6366f1,#818cf8);color:#fff;
                   border:none;border-radius:10px;padding:9px 20px;font-size:.82rem;">
        <i class="bi bi-calendar-plus me-2"></i>Tambah Jadwal
    </button>
</div>

@if(session('success'))
<div class="alert alert-dismissible fade show border-0 mb-4"
     style="background:#f0fdf4;color:#15803d;border-radius:12px;" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Schedule Table --}}
<div style="background:#fff;border:1px solid #e2e8f0;border-radius:16px;
            box-shadow:0 1px 3px rgba(0,0,0,.04);overflow:hidden;">
    <div class="table-responsive">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#f8fafc;border-bottom:1.5px solid #e2e8f0;">
                    <th style="padding:12px 16px 12px 20px;font-size:.68rem;font-weight:800;
                               text-transform:uppercase;letter-spacing:.8px;color:#94a3b8;">Hari</th>
                    <th style="padding:12px 16px;font-size:.68rem;font-weight:800;
                               text-transform:uppercase;letter-spacing:.8px;color:#94a3b8;">Waktu</th>
                    <th style="padding:12px 16px;font-size:.68rem;font-weight:800;
                               text-transform:uppercase;letter-spacing:.8px;color:#94a3b8;">Mata Kuliah</th>
                    <th style="padding:12px 16px;font-size:.68rem;font-weight:800;
                               text-transform:uppercase;letter-spacing:.8px;color:#94a3b8;">Dosen</th>
                    <th style="padding:12px 16px;font-size:.68rem;font-weight:800;
                               text-transform:uppercase;letter-spacing:.8px;color:#94a3b8;">Ruangan</th>
                    <th style="padding:12px 16px;font-size:.68rem;font-weight:800;
                               text-transform:uppercase;letter-spacing:.8px;color:#94a3b8;text-align:center;">Angkatan</th>
                    <th style="padding:12px 16px;font-size:.68rem;font-weight:800;
                               text-transform:uppercase;letter-spacing:.8px;color:#94a3b8;text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $schedule)
                <tr style="border-bottom:1px solid #f1f5f9;transition:background .12s;"
                    onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                    <td style="padding:13px 16px 13px 20px;font-weight:700;color:#6366f1;">
                        {{ $schedule->day }}
                    </td>
                    <td style="padding:13px 16px;">
                        <span style="background:#e0e7ff;color:#4338ca;font-size:.75rem;
                                     font-weight:600;padding:3px 10px;border-radius:6px;">
                            {{ date('H:i', strtotime($schedule->start_time)) }} –
                            {{ date('H:i', strtotime($schedule->end_time)) }}
                        </span>
                    </td>
                    <td style="padding:13px 16px;font-weight:600;color:#1e293b;">
                        {{ $schedule->subject->name ?? 'N/A' }}
                    </td>
                    <td style="padding:13px 16px;color:#64748b;">
                        <i class="bi bi-person-circle me-1" style="color:#94a3b8;"></i>
                        {{ $schedule->dosen->name ?? 'N/A' }}
                    </td>
                    <td style="padding:13px 16px;color:#64748b;">
                        <i class="bi bi-geo-alt me-1" style="color:#f87171;"></i>
                        {{ $schedule->room }}
                    </td>
                    <td style="padding:13px 16px;text-align:center;">
                        <span style="background:#f1f5f9;color:#475569;font-size:.72rem;
                                     font-weight:600;padding:3px 12px;border-radius:20px;">
                            Angkatan {{ $schedule->cohort }}
                        </span>
                    </td>
                    <td style="padding:13px 16px;text-align:center;">
                        <form action="{{ route('admin.schedules.destroy', $schedule->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus jadwal ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm"
                                    style="background:#fee2e2;color:#dc2626;border:none;
                                           border-radius:8px;padding:5px 10px;">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:60px 24px;color:#94a3b8;">
                        <i class="bi bi-calendar-x d-block fs-2 mb-2 opacity-40"></i>
                        Belum ada jadwal yang dibuat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Add Schedule Modal --}}
<div class="modal fade" id="addScheduleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px;border:1px solid #e2e8f0;">
            <div class="modal-header" style="background:#f8fafc;border-bottom:1.5px solid #e2e8f0;
                                             border-radius:16px 16px 0 0;padding:16px 20px;">
                <h5 class="modal-title" style="font-size:.875rem;font-weight:700;color:#1e293b;">
                    <i class="bi bi-calendar-plus me-2" style="color:#6366f1;"></i>Tambah Jadwal Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.schedules.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:.7rem;font-weight:700;
                                   text-transform:uppercase;color:#94a3b8;">Hari</label>
                            <select name="day" class="form-select" style="border-radius:10px;
                                    border:1.5px solid #e2e8f0;background:#f8fafc;color:#1e293b;" required>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:.7rem;font-weight:700;
                                   text-transform:uppercase;color:#94a3b8;">Angkatan</label>
                            <input type="number" name="cohort" class="form-control"
                                   placeholder="Contoh: 2023"
                                   style="border-radius:10px;border:1.5px solid #e2e8f0;background:#f8fafc;color:#1e293b;" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.7rem;font-weight:700;
                               text-transform:uppercase;color:#94a3b8;">Dosen Pengampu</label>
                        <select name="user_id" class="form-select" style="border-radius:10px;
                                border:1.5px solid #e2e8f0;background:#f8fafc;color:#1e293b;" required>
                            <option value="">-- Pilih Dosen --</option>
                            @foreach($dosens as $dosen)
                            <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:.7rem;font-weight:700;
                               text-transform:uppercase;color:#94a3b8;">Mata Kuliah</label>
                        <select name="subject_id" class="form-select" style="border-radius:10px;
                                border:1.5px solid #e2e8f0;background:#f8fafc;color:#1e293b;" required>
                            <option value="">Pilih Mata Kuliah...</option>
                            @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:.7rem;font-weight:700;
                                   text-transform:uppercase;color:#94a3b8;">Jam Mulai</label>
                            <input type="time" name="start_time" class="form-control"
                                   style="border-radius:10px;border:1.5px solid #e2e8f0;background:#f8fafc;color:#1e293b;" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:.7rem;font-weight:700;
                                   text-transform:uppercase;color:#94a3b8;">Jam Selesai</label>
                            <input type="time" name="end_time" class="form-control"
                                   style="border-radius:10px;border:1.5px solid #e2e8f0;background:#f8fafc;color:#1e293b;" required>
                        </div>
                    </div>

                    <div>
                        <label class="form-label" style="font-size:.7rem;font-weight:700;
                               text-transform:uppercase;color:#94a3b8;">Ruangan Kelas</label>
                        <input type="text" name="room" class="form-control"
                               placeholder="Contoh: R.301 atau Lab Dasar"
                               style="border-radius:10px;border:1.5px solid #e2e8f0;background:#f8fafc;color:#1e293b;" required>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0 gap-2">
                    <button type="button" class="btn btn-light border px-4"
                            data-bs-dismiss="modal" style="border-radius:10px;">Batal</button>
                    <button type="submit" class="btn px-4 fw-semibold"
                            style="background:linear-gradient(135deg,#6366f1,#818cf8);
                                   color:#fff;border:none;border-radius:10px;">
                        <i class="bi bi-check-lg me-1"></i>Simpan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
