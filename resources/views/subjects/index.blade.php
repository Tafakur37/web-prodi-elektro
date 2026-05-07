@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0 text-dark">Manajemen Mata Kuliah</h3>
        <button class="btn btn-primary px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="bi bi-plus-lg me-2"></i> Tambah Matkul
        </button>
    </div>

    @if($errors->any())
        <div class="alert alert-danger shadow-sm">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Kode</th>
                            <th>Mata Kuliah</th>
                            <th class="text-center">SKS</th>
                            <th class="text-center">Semester</th>
                            <th class="text-center">KKM (UTS/UAS)</th>
                            <th class="text-center">Bobot (TGS/UTS/UAS)</th>
                            <th class="text-center">Pertemuan</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subjects as $subj)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $subj->code }}</td>
                            <td>
                                {{ $subj->name }}
                                @if($subj->lecturers->count() > 0)
                                    <div class="mt-1">
                                        @foreach($subj->lecturers as $dosen)
                                            <span class="badge bg-secondary" style="font-size: 0.7rem;">{{ $dosen->name }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="mt-1"><span class="badge bg-light text-muted border" style="font-size: 0.7rem;">Belum ada dosen</span></div>
                                @endif
                            </td>
                            <td class="text-center">{{ $subj->sks }}</td>
                            <td class="text-center">Sem {{ $subj->semester }}</td>
                            <td class="text-center">
                                <span class="badge bg-info text-dark">UTS: {{ $subj->kkm_uts }}</span>
                                <span class="badge bg-warning text-dark">UAS: {{ $subj->kkm_uas }}</span>
                            </td>
                            <td class="text-center">
                                <small class="text-muted">{{ $subj->weight_task }}% / {{ $subj->weight_uts }}% / {{ $subj->weight_uas }}%</small>
                            </td>
                            <td class="text-center">{{ $subj->meetings }} Kali</td>
                            <td class="text-center pe-4">
                                <button class="btn btn-sm btn-outline-secondary me-1" 
                                    data-bs-toggle="modal" data-bs-target="#editModal{{ $subj->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route($prefix.'.subjects.destroy', $subj->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus matkul ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $subj->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header border-bottom-0">
                                        <h5 class="modal-title fw-bold">Edit Mata Kuliah</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route($prefix.'.subjects.update', $subj->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <label class="form-label small text-muted">Kode</label>
                                                    <input type="text" name="code" class="form-control" value="{{ $subj->code }}" required>
                                                </div>
                                                <div class="col-md-8">
                                                    <label class="form-label small text-muted">Nama Mata Kuliah</label>
                                                    <input type="text" name="name" class="form-control" value="{{ $subj->name }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small text-muted">SKS</label>
                                                    <input type="number" name="sks" class="form-control" value="{{ $subj->sks }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small text-muted">Semester</label>
                                                    <input type="number" name="semester" class="form-control" value="{{ $subj->semester }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small text-muted">KKM UTS</label>
                                                    <input type="number" name="kkm_uts" class="form-control" value="{{ $subj->kkm_uts }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small text-muted">KKM UAS</label>
                                                    <input type="number" name="kkm_uas" class="form-control" value="{{ $subj->kkm_uas }}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label small text-muted">Bobot Tugas (%)</label>
                                                    <input type="number" name="weight_task" class="form-control" value="{{ $subj->weight_task }}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label small text-muted">Bobot UTS (%)</label>
                                                    <input type="number" name="weight_uts" class="form-control" value="{{ $subj->weight_uts }}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label small text-muted">Bobot UAS (%)</label>
                                                    <input type="number" name="weight_uas" class="form-control" value="{{ $subj->weight_uas }}" required>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label small text-muted">Total Pertemuan (Maks Presensi)</label>
                                                    <input type="number" name="meetings" class="form-control" value="{{ $subj->meetings }}" required>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label small text-muted">Dosen Pengampu (Bisa pilih lebih dari satu)</label>
                                                    <select name="lecturers[]" class="form-select" multiple size="3">
                                                        @foreach($dosens as $dosen)
                                                            <option value="{{ $dosen->id }}" {{ $subj->lecturers->contains($dosen->id) ? 'selected' : '' }}>
                                                                {{ $dosen->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Belum ada mata kuliah terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold">Tambah Mata Kuliah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route($prefix.'.subjects.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small text-muted">Kode</label>
                            <input type="text" name="code" class="form-control" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small text-muted">Nama Mata Kuliah</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">SKS</label>
                            <input type="number" name="sks" class="form-control" value="3" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Semester</label>
                            <input type="number" name="semester" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">KKM UTS</label>
                            <input type="number" name="kkm_uts" class="form-control" value="60" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">KKM UAS</label>
                            <input type="number" name="kkm_uas" class="form-control" value="60" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted">Bobot Tugas (%)</label>
                            <input type="number" name="weight_task" class="form-control" value="30" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted">Bobot UTS (%)</label>
                            <input type="number" name="weight_uts" class="form-control" value="30" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted">Bobot UAS (%)</label>
                            <input type="number" name="weight_uas" class="form-control" value="40" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small text-muted">Total Pertemuan (Maks Presensi)</label>
                            <input type="number" name="meetings" class="form-control" value="14" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small text-muted">Dosen Pengampu (Bisa pilih lebih dari satu)</label>
                            <select name="lecturers[]" class="form-select" multiple size="3">
                                @foreach($dosens as $dosen)
                                    <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
