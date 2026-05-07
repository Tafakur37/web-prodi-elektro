@extends('layouts.app')

@push('styles')
<style>
    .chat-sidebar { border-right: 1px solid #dee2e6; height: calc(100vh - 150px); overflow-y: auto; }
    .chat-user-item { transition: all 0.2s; cursor: pointer; border-radius: 8px; margin-bottom: 5px; }
    .chat-user-item:hover { background-color: #f8f9fa; }
    .chat-user-item.active { background-color: #e9ecef; }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="row g-0 bg-white shadow-sm rounded-4 overflow-hidden border">
        <!-- Sidebar -->
        <div class="col-md-4 chat-sidebar p-3">
            <h5 class="fw-bold mb-3"><i class="bi bi-chat-dots text-primary me-2"></i>Pesan Mahasiswa</h5>
            
            <div class="mb-4">
                <label class="form-label small fw-bold text-muted">Mulai Obrolan Baru (Berdasarkan Angkatan)</label>
                <select id="cohortSelect" class="form-select mb-2">
                    <option value="">Pilih Angkatan...</option>
                    @foreach($cohorts as $cohort)
                        <option value="{{ $cohort }}">{{ $cohort }}</option>
                    @endforeach
                </select>
                <select id="studentSelect" class="form-select" disabled>
                    <option value="">Pilih Mahasiswa...</option>
                </select>
            </div>

            <h6 class="fw-bold text-muted small text-uppercase mt-4 mb-2">Riwayat Obrolan</h6>
            <div class="list-group list-group-flush">
                @forelse($recentChatUsers as $user)
                    <a href="{{ route('staff.chats.show', $user->id) }}" class="list-group-item list-group-item-action border-0 chat-user-item">
                        <div class="d-flex align-items-center">
                            <div class="avatar-circle bg-primary text-white d-flex justify-content-center align-items-center rounded-circle me-3" style="width: 45px; height: 45px; font-weight: bold;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 fw-bold text-truncate">{{ $user->name }}</h6>
                                </div>
                                <small class="text-muted d-block text-truncate">{{ $user->nim }} | Cohort {{ $user->cohort }}</small>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-4 text-muted small">
                        Belum ada riwayat pesan.
                    </div>
                @endforelse
            </div>
        </div>
        
        <!-- Main Chat Area -->
        <div class="col-md-8 d-flex flex-column align-items-center justify-content-center bg-light" style="height: calc(100vh - 150px);">
            <i class="bi bi-chat-square-text fs-1 text-muted opacity-25 mb-3"></i>
            <h5 class="text-muted fw-bold">Pilih Obrolan</h5>
            <p class="text-muted small">Pilih mahasiswa dari daftar atau mulai obrolan baru untuk mengirim pesan.</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('cohortSelect').addEventListener('change', function() {
        const cohort = this.value;
        const studentSelect = document.getElementById('studentSelect');
        
        if (!cohort) {
            studentSelect.innerHTML = '<option value="">Pilih Mahasiswa...</option>';
            studentSelect.disabled = true;
            return;
        }

        fetch(`{{ route('staff.chats.getStudents') }}?cohort=${cohort}`)
            .then(response => response.json())
            .then(data => {
                studentSelect.innerHTML = '<option value="">Pilih Mahasiswa...</option>';
                data.forEach(student => {
                    studentSelect.innerHTML += `<option value="${student.id}">${student.nim} - ${student.name}</option>`;
                });
                studentSelect.disabled = false;
            });
    });

    document.getElementById('studentSelect').addEventListener('change', function() {
        if (this.value) {
            window.location.href = `/staff/chats/${this.value}`;
        }
    });
</script>
@endpush
