@extends('layouts.app')

@section('title', 'Chat Mahasiswa')

@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="row g-4">

        <!-- Kolom Kiri: Form Cari Mahasiswa & Daftar Kontak Terbaru -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom border-light pt-4 pb-3 px-4">
                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-search text-primary me-2"></i> Cari Mahasiswa</h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Pilih Cohort (Angkatan/Kelas)</label>
                        <select id="cohort-select" class="form-select">
                            <option value="">-- Pilih Cohort --</option>
                            @foreach($cohorts as $c)
                                <option value="{{ $c }}">{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Pilih Mahasiswa</label>
                        <select id="student-select" class="form-select" disabled>
                            <option value="">-- Pilih Mahasiswa --</option>
                        </select>
                    </div>
                    <button id="start-chat-btn" class="btn btn-primary w-100 fw-bold rounded-pill shadow-sm" disabled>
                        <i class="bi bi-chat-dots me-2"></i> Mulai Chat
                    </button>
                </div>
            </div>

            @if(count($recentContacts) > 0)
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom border-light pt-4 pb-3 px-4">
                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-clock-history text-primary me-2"></i> Obrolan Terakhir</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush border-0">
                        @foreach($recentContacts as $contact)
                        <a href="{{ route('dosen.chats.show', $contact->id) }}" class="list-group-item list-group-item-action px-4 py-3 border-light d-flex align-items-center">
                            @if($contact->profile_photo)
                                <img src="{{ asset('storage/profiles/' . $contact->profile_photo) }}" class="rounded-circle me-3 border" width="45" height="45" style="object-fit: cover;">
                            @else
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="bi bi-person-fill fs-5"></i>
                                </div>
                            @endif
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $contact->name }}</h6>
                                <small class="text-secondary">{{ $contact->nim ?? 'Mahasiswa' }}</small>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Kolom Kanan: Chat Kosong -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100 d-flex align-items-center justify-content-center bg-light" style="min-height: 400px;">
                <div class="text-center py-5">
                    <i class="bi bi-chat-square-text text-muted" style="font-size: 4rem;"></i>
                    <h5 class="mt-3 text-secondary">Pilih mahasiswa untuk memulai chat</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cohortSelect = document.getElementById('cohort-select');
    const studentSelect = document.getElementById('student-select');
    const startChatBtn = document.getElementById('start-chat-btn');

    cohortSelect.addEventListener('change', function() {
        const cohort = this.value;
        if (!cohort) {
            studentSelect.innerHTML = '<option value="">-- Pilih Mahasiswa --</option>';
            studentSelect.disabled = true;
            startChatBtn.disabled = true;
            return;
        }

        fetch(`{{ route('dosen.chats.getStudents') }}?cohort=${cohort}`)
            .then(response => response.json())
            .then(data => {
                studentSelect.innerHTML = '<option value="">-- Pilih Mahasiswa --</option>';
                data.students.forEach(student => {
                    studentSelect.innerHTML += `<option value="${student.id}">${student.nim} - ${student.name}</option>`;
                });
                studentSelect.disabled = false;
            })
            .catch(error => console.error('Error fetching students:', error));
    });

    studentSelect.addEventListener('change', function() {
        startChatBtn.disabled = !this.value;
    });

    startChatBtn.addEventListener('click', function() {
        const studentId = studentSelect.value;
        if (studentId) {
            window.location.href = `{{ url('dosen/chats') }}/${studentId}`;
        }
    });
});
</script>
@endpush