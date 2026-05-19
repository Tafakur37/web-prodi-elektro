@extends('layouts.app')

@section('title', 'Data Dosen')

@push('styles')
<style>
    .dosen-table-wrap { overflow-x: auto; }
    .dosen-table-wrap table { min-width: 1450px; }

    /* Status Badges */
    .badge-aktif    { background: #dcfce7; color: #166534; }
    .badge-nonaktif { background: #fee2e2; color: #991b1b; }
    .badge-pns      { background: #dbeafe; color: #1e40af; }
    .badge-pppk     { background: #ede9fe; color: #5b21b6; }
    .badge-cpns     { background: #fef3c7; color: #92400e; }
    .badge-honor    { background: #f1f5f9; color: #475569; }
    .badge-serdos   { background: #d1fae5; color: #065f46; }
    .badge-noserdos { background: #fee2e2; color: #991b1b; }

    /* Row hover */
    .table tbody tr { transition: background 0.15s ease; }
    .table tbody tr:hover { background: #f8faff !important; }

    /* Search card */
    .filter-card { background:#fff; border:1px solid #e2e8f0; border-radius:14px; box-shadow:0 1px 3px rgba(0,0,0,0.04); }

    /* Sticky action column */
    .col-aksi { position: sticky; right: 0; background: #fff; box-shadow: -3px 0 6px rgba(0,0,0,0.05); z-index: 1; }
    tr:hover .col-aksi { background: #f8faff; }

    /* Avatar circle */
    .av-circle {
        width: 36px; height: 36px; border-radius: 50%;
        background: linear-gradient(135deg,#6366f1,#818cf8);
        color:#fff; font-weight:700; font-size:.85rem;
        display:flex; align-items:center; justify-content:center; flex-shrink:0;
    }

    /* Modal */
    .modal-header-custom { background: linear-gradient(135deg,#1e3a5f,#2563eb); color:#fff; }
    .modal-header-custom .btn-close { filter: invert(1); }
    .form-label { font-size:.8rem; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:.4px; }
    .form-control, .form-select { border-radius:8px; font-size:.9rem; }
    .form-control:focus, .form-select:focus {
        border-color:#6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.15);
    }
    .modal-section-label {
        font-size:.7rem; font-weight:700; letter-spacing:1.5px; text-transform:uppercase;
        color:#94a3b8; padding: 8px 0 4px; border-bottom:1px solid #f1f5f9; margin-bottom:12px;
    }

    /* Empty state */
    .val-dash { color: #cbd5e1; }
</style>
@endpush

@section('content')
@php
    $userRole  = auth()->user()->role;
    $isAdmin   = $userRole === 'admin';
    $routeBase = $isAdmin ? 'admin' : 'staff';
    $indexRoute  = "{$routeBase}.dosen.index";
    $updateRoute = "{$routeBase}.dosen.update";
@endphp

<div class="container-fluid px-0">

    {{-- ── Header ── --}}
    <div class="d-flex align-items-start justify-content-between mb-4 gap-3 flex-wrap">
        <div>
            <h4 class="fw-bold mb-1"><i class="bi bi-person-badge me-2 text-primary"></i>Data Dosen</h4>
            <p class="text-muted mb-0 small">Daftar lengkap dan pengelolaan data akademik seluruh dosen program studi.</p>
        </div>
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2 fs-6">
            <i class="bi bi-person-badge me-1"></i>{{ $dosen->total() }} Dosen
        </span>
    </div>

    {{-- ── Filter / Search ── --}}
    <div class="filter-card p-3 mb-4">
        <form action="{{ route($indexRoute) }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label mb-1">Cari Dosen</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Nama, NIP, atau NUPTK..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label mb-1">Status Pegawai</label>
                <select name="status_pegawai" class="form-select">
                    <option value="">Semua Status Pegawai</option>
                    @foreach(['PNS','PPPK','CPNS','Honor'] as $sp)
                        <option value="{{ $sp }}" {{ request('status_pegawai') == $sp ? 'selected':'' }}>{{ $sp }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label mb-1">Jabatan Fungsional</label>
                <select name="jabatan_fungsional" class="form-select">
                    <option value="">Semua Jabatan</option>
                    @foreach($jabatanOptions as $jab)
                        <option value="{{ $jab }}" {{ request('jabatan_fungsional') == $jab ? 'selected':'' }}>{{ $jab }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill fw-bold">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
                @if(request('search') || request('status_pegawai') || request('jabatan_fungsional'))
                    <a href="{{ route($indexRoute) }}" class="btn btn-outline-secondary" title="Reset Filter">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- ── Tabel Dosen ── --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="dosen-table-wrap">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted" style="font-size:.72rem; font-weight:700; letter-spacing:.5px; text-transform:uppercase;">
                        <tr>
                            <th class="ps-4" style="min-width:210px">Nama Dosen</th>
                            <th style="min-width:155px">NUPTK</th>
                            <th style="min-width:170px">NIP</th>
                            <th style="min-width:100px">Jenis Kelamin</th>
                            <th style="min-width:70px">Umur</th>
                            <th style="min-width:115px">Status Pegawai</th>
                            <th style="min-width:120px">Status Keaktifan</th>
                            <th style="min-width:165px">Pangkat Terakhir</th>
                            <th style="min-width:90px">Golongan</th>
                            <th style="min-width:130px">TMT Pangkat</th>
                            <th style="min-width:155px">Jabatan Fungsional</th>
                            <th style="min-width:120px">TMT Jabfung</th>
                            <th style="min-width:165px">Sertifikasi Dosen</th>
                            <th style="min-width:100px">Tahun Serdos</th>
                            <th style="min-width:120px">Masa Kerja Gol.</th>
                            <th class="col-aksi text-center" style="min-width:95px">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dosen as $d)
                        <tr>
                            {{-- Nama Dosen --}}
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="av-circle">{{ strtoupper(substr($d->name, 0, 1)) }}</div>
                                    <div>
                                        <div class="fw-bold text-dark small">{{ $d->name }}</div>
                                        <div class="text-muted" style="font-size:.75rem">{{ $d->email }}</div>
                                    </div>
                                </div>
                            </td>
                            {{-- NUPTK --}}
                            <td>
                                @if($d->nuptk)
                                    <span class="font-monospace small">{{ $d->nuptk }}</span>
                                @else
                                    <span class="val-dash">—</span>
                                @endif
                            </td>
                            {{-- NIP --}}
                            <td>
                                @if($d->nip)
                                    <span class="font-monospace small">{{ $d->nip }}</span>
                                @else
                                    <span class="val-dash">—</span>
                                @endif
                            </td>
                            {{-- Jenis Kelamin --}}
                            <td>
                                @if($d->gender === 'L')
                                    <span class="badge rounded-pill" style="background:#dbeafe;color:#1e40af"><i class="bi bi-gender-male me-1"></i>L</span>
                                @elseif($d->gender === 'P')
                                    <span class="badge rounded-pill" style="background:#fce7f3;color:#9d174d"><i class="bi bi-gender-female me-1"></i>P</span>
                                @else
                                    <span class="val-dash">—</span>
                                @endif
                            </td>
                            {{-- Umur --}}
                            <td class="text-center small">
                                @if($d->tanggal_lahir)
                                    {{ \Carbon\Carbon::parse($d->tanggal_lahir)->age }}
                                @else
                                    <span class="val-dash">—</span>
                                @endif
                            </td>
                            {{-- Status Pegawai --}}
                            <td>
                                @if($d->status_pegawai === 'PNS')
                                    <span class="badge badge-pns rounded-pill">PNS</span>
                                @elseif($d->status_pegawai === 'PPPK')
                                    <span class="badge badge-pppk rounded-pill">PPPK</span>
                                @elseif($d->status_pegawai === 'CPNS')
                                    <span class="badge badge-cpns rounded-pill">CPNS</span>
                                @elseif($d->status_pegawai === 'Honor')
                                    <span class="badge badge-honor rounded-pill">Honor</span>
                                @else
                                    <span class="val-dash">—</span>
                                @endif
                            </td>
                            {{-- Status Keaktifan --}}
                            <td>
                                @if($d->status_keaktifan === 'Aktif')
                                    <span class="badge badge-aktif rounded-pill">Aktif</span>
                                @elseif($d->status_keaktifan === 'Tidak Aktif')
                                    <span class="badge badge-nonaktif rounded-pill">Tidak Aktif</span>
                                @else
                                    <span class="val-dash">—</span>
                                @endif
                            </td>
                            {{-- Pangkat Terakhir --}}
                            <td class="small">{{ $d->pangkat_terakhir ?: '—' }}</td>
                            {{-- Golongan --}}
                            <td class="text-center">
                                @if($d->golongan_terakhir)
                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill fw-bold">{{ $d->golongan_terakhir }}</span>
                                @else
                                    <span class="val-dash">—</span>
                                @endif
                            </td>
                            {{-- TMT Pangkat --}}
                            <td class="small">
                                @if($d->tmt_pangkat)
                                    {{ \Carbon\Carbon::parse($d->tmt_pangkat)->translatedFormat('d M Y') }}
                                @else
                                    <span class="val-dash">—</span>
                                @endif
                            </td>
                            {{-- Jabatan Fungsional --}}
                            <td class="small fw-semibold">{{ $d->jabatan_fungsional ?: '—' }}</td>
                            {{-- TMT Jabfung --}}
                            <td class="small">
                                @if($d->tmt_jabfung)
                                    {{ \Carbon\Carbon::parse($d->tmt_jabfung)->translatedFormat('d M Y') }}
                                @else
                                    <span class="val-dash">—</span>
                                @endif
                            </td>
                            {{-- Sertifikasi Dosen --}}
                            <td>
                                @if($d->sertifikasi_dosen === 'Sertifikasi Dosen')
                                    <span class="badge badge-serdos rounded-pill" style="font-size:.72rem">Sertifikasi Dosen</span>
                                @elseif($d->sertifikasi_dosen === 'Belum Sertifikasi Dosen')
                                    <span class="badge badge-noserdos rounded-pill" style="font-size:.72rem">Belum Sertifikasi</span>
                                @else
                                    <span class="val-dash">—</span>
                                @endif
                            </td>
                            {{-- Tahun Serdos --}}
                            <td class="text-center small">{{ $d->tahun_serdos ?: '—' }}</td>
                            {{-- Masa Kerja Golongan --}}
                            <td class="text-center small">
                                {{ $d->masa_kerja_golongan !== null ? $d->masa_kerja_golongan . ' thn' : '—' }}
                            </td>
                            {{-- Aksi --}}
                            <td class="col-aksi text-center pe-3">
                                <button class="btn btn-sm btn-outline-primary shadow-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEditDosen{{ $d->id }}"
                                    title="Edit Data Dosen">
                                    <i class="bi bi-pencil-square me-1"></i>Edit
                                </button>
                            </td>
                        </tr>

                        {{-- ═══════════════════════════════════
                             MODAL EDIT DOSEN
                        ═══════════════════════════════════ --}}
                        <div class="modal fade" id="modalEditDosen{{ $d->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                    <form action="{{ route($updateRoute, $d->id) }}" method="POST">
                                        @csrf @method('PUT')

                                        {{-- Header --}}
                                        <div class="modal-header modal-header-custom py-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="av-circle">{{ strtoupper(substr($d->name, 0, 1)) }}</div>
                                                <div>
                                                    <h5 class="modal-title fw-bold mb-0">Edit Data Dosen</h5>
                                                    <small class="opacity-75">{{ $d->name }}</small>
                                                </div>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>

                                        {{-- Body --}}
                                        <div class="modal-body p-4">

                                            <div class="modal-section-label"><i class="bi bi-person-fill me-1"></i>Identitas Dosen</div>
                                            <div class="row g-3 mb-3">
                                                <div class="col-12">
                                                    <label class="form-label">Nama Lengkap</label>
                                                    <input type="text" name="name" class="form-control" value="{{ old('name', $d->name) }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">NUPTK</label>
                                                    <input type="text" name="nuptk" class="form-control font-monospace" value="{{ old('nuptk', $d->nuptk) }}" placeholder="16 digit NUPTK">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">NIP</label>
                                                    <input type="text" name="nip" class="form-control font-monospace" value="{{ old('nip', $d->nip) }}" placeholder="18 digit NIP">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Jenis Kelamin</label>
                                                    <select name="gender" class="form-select">
                                                        <option value="">— Pilih —</option>
                                                        <option value="L" {{ old('gender', $d->gender) == 'L' ? 'selected':'' }}>Laki-laki (L)</option>
                                                        <option value="P" {{ old('gender', $d->gender) == 'P' ? 'selected':'' }}>Perempuan (P)</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Tanggal Lahir</label>
                                                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $d->tanggal_lahir ? \Carbon\Carbon::parse($d->tanggal_lahir)->format('Y-m-d') : '') }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Status Keaktifan</label>
                                                    <select name="status_keaktifan" class="form-select">
                                                        <option value="">— Pilih —</option>
                                                        <option value="Aktif"       {{ old('status_keaktifan', $d->status_keaktifan) == 'Aktif'       ? 'selected':'' }}>Aktif</option>
                                                        <option value="Tidak Aktif" {{ old('status_keaktifan', $d->status_keaktifan) == 'Tidak Aktif' ? 'selected':'' }}>Tidak Aktif</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="modal-section-label"><i class="bi bi-briefcase me-1"></i>Status Kepegawaian</div>
                                            <div class="row g-3 mb-3">
                                                <div class="col-md-4">
                                                    <label class="form-label">Status Pegawai</label>
                                                    <select name="status_pegawai" class="form-select">
                                                        <option value="">— Pilih —</option>
                                                        @foreach(['PNS','PPPK','CPNS','Honor'] as $sp)
                                                            <option value="{{ $sp }}" {{ old('status_pegawai', $d->status_pegawai) == $sp ? 'selected':'' }}>{{ $sp }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Pangkat Terakhir</label>
                                                    <input type="text" name="pangkat_terakhir" class="form-control" value="{{ old('pangkat_terakhir', $d->pangkat_terakhir) }}" placeholder="Contoh: Penata Muda Tk. I">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Kode Golongan Terakhir</label>
                                                    <select name="golongan_terakhir" class="form-select">
                                                        <option value="">— Pilih —</option>
                                                        @foreach(['I/a','I/b','I/c','I/d','II/a','II/b','II/c','II/d','III/a','III/b','III/c','III/d','IV/a','IV/b','IV/c','IV/d','IV/e'] as $gol)
                                                            <option value="{{ $gol }}" {{ old('golongan_terakhir', $d->golongan_terakhir) == $gol ? 'selected':'' }}>{{ $gol }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">TMT Pangkat Golongan Terakhir</label>
                                                    <input type="date" name="tmt_pangkat" class="form-control" value="{{ old('tmt_pangkat', $d->tmt_pangkat ? \Carbon\Carbon::parse($d->tmt_pangkat)->format('Y-m-d') : '') }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Masa Kerja Golongan (tahun)</label>
                                                    <input type="number" name="masa_kerja_golongan" class="form-control" min="0" max="99" value="{{ old('masa_kerja_golongan', $d->masa_kerja_golongan) }}" placeholder="Contoh: 10">
                                                </div>
                                            </div>

                                            <div class="modal-section-label"><i class="bi bi-award me-1"></i>Jabatan Fungsional & Sertifikasi</div>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Jabatan Fungsional</label>
                                                    <select name="jabatan_fungsional" class="form-select">
                                                        <option value="">— Pilih —</option>
                                                        @foreach(['Asisten Ahli','Lektor','Lektor Kepala','Profesor','Guru Besar'] as $jab)
                                                            <option value="{{ $jab }}" {{ old('jabatan_fungsional', $d->jabatan_fungsional) == $jab ? 'selected':'' }}>{{ $jab }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">TMT Jabatan Fungsional</label>
                                                    <input type="date" name="tmt_jabfung" class="form-control" value="{{ old('tmt_jabfung', $d->tmt_jabfung ? \Carbon\Carbon::parse($d->tmt_jabfung)->format('Y-m-d') : '') }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Sertifikasi Dosen</label>
                                                    <select name="sertifikasi_dosen" class="form-select">
                                                        <option value="">— Pilih —</option>
                                                        <option value="Sertifikasi Dosen"       {{ old('sertifikasi_dosen', $d->sertifikasi_dosen) == 'Sertifikasi Dosen'       ? 'selected':'' }}>Sertifikasi Dosen</option>
                                                        <option value="Belum Sertifikasi Dosen" {{ old('sertifikasi_dosen', $d->sertifikasi_dosen) == 'Belum Sertifikasi Dosen' ? 'selected':'' }}>Belum Sertifikasi Dosen</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Tahun Sertifikasi Dosen</label>
                                                    <input type="number" name="tahun_serdos" class="form-control" min="1990" max="2099" value="{{ old('tahun_serdos', $d->tahun_serdos) }}" placeholder="Contoh: 2022">
                                                </div>
                                            </div>

                                        </div>{{-- /modal-body --}}

                                        {{-- Footer --}}
                                        <div class="modal-footer border-top-0 pt-0 pb-4 px-4 gap-2">
                                            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary px-5 fw-bold">
                                                <i class="bi bi-floppy me-1"></i>Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- /modal edit dosen --}}

                        @empty
                        <tr>
                            <td colspan="16" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                <strong>Tidak ada data dosen</strong><br>
                                <small>Coba ubah filter pencarian Anda.</small>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($dosen->hasPages())
        <div class="card-footer bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span class="text-muted small">
                Menampilkan {{ $dosen->firstItem() }}–{{ $dosen->lastItem() }} dari {{ $dosen->total() }} dosen
            </span>
            {{ $dosen->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
