@extends('layouts.app')

@section('title', 'Chat')

@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="row g-4">

        <!-- Kolom Kiri: Pilih Kontak -->
        <div class="col-lg-4 d-none d-lg-block">
            <div class="card border-0 shadow-sm rounded-4 h-100 mb-4">
                <div class="card-header bg-white border-bottom border-light pt-4 pb-3 px-4">
                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-search text-primary me-2"></i> Cari Mahasiswa</h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Pilih Cohort</label>
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
        </div>

        <!-- Kolom Kanan: Ruang Chat -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100 d-flex flex-column">
                <div class="card-header bg-white border-bottom border-light p-3 d-flex align-items-center">
                    <a href="{{ route('dosen.chats.index') }}" class="btn btn-sm btn-light me-3 d-lg-none"><i class="bi bi-arrow-left"></i></a>
                    @if($mahasiswa->profile_photo)
                        <img src="{{ asset('storage/profiles/' . $mahasiswa->profile_photo) }}" class="rounded-circle me-3 border" width="45" height="45" style="object-fit: cover;">
                    @else
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="bi bi-person-fill fs-5"></i>
                        </div>
                    @endif
                    <div>
                        <h6 class="mb-0 fw-bold">{{ $mahasiswa->name }}</h6>
                        <small class="text-success"><i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i> Mahasiswa ({{ $mahasiswa->nim ?? '-' }})</small>
                    </div>
                </div>

                <div class="card-body p-4 overflow-auto" style="height: 50vh; background-color: #f8f9fa;">
                    @if($chats->isEmpty())
                        <div class="text-center py-5 text-muted small">Mulai percakapan dengan mengirimkan pesan kepada Mahasiswa.</div>
                    @else
                        @foreach($chats as $chat)
                            @if($chat->sender_id === auth()->id())
                                <!-- Pesan Saya (Kanan) -->
                                <div class="d-flex justify-content-end mb-3">
                                    <div class="bg-primary text-white p-3 rounded-4 shadow-sm" style="max-width: 75%; border-bottom-right-radius: 4px !important;">
                                        <p class="mb-1">{{ $chat->message }}</p>
                                        <div class="text-end small opacity-75" style="font-size: 0.7rem;">
                                            {{ $chat->created_at->format('H:i') }}
                                            @if($chat->is_read) <i class="bi bi-check-all ms-1"></i> @else <i class="bi bi-check ms-1"></i> @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Pesan Mahasiswa (Kiri) -->
                                <div class="d-flex justify-content-start mb-3">
                                    <div class="bg-white p-3 rounded-4 shadow-sm border border-light" style="max-width: 75%; border-bottom-left-radius: 4px !important;">
                                        <p class="mb-1 text-dark">{{ $chat->message }}</p>
                                        <div class="text-start small text-muted" style="font-size: 0.7rem;">{{ $chat->created_at->format('H:i') }}</div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>

                <div class="card-footer bg-white border-top border-light p-3">
                    <form action="{{ route('dosen.chats.store', $mahasiswa->id) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="message" class="form-control rounded-pill rounded-end ps-4" placeholder="Ketik pesan..." required autofocus>
                            <button class="btn btn-primary rounded-pill rounded-start px-4 fw-bold" type="submit"><i class="bi bi-send-fill me-1"></i> Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const chatBody = document.querySelector('.card-body.overflow-auto');
        if(chatBody) {
            chatBody.scrollTop = chatBody.scrollHeight;
        }

        const cohortSelect = document.getElementById('cohort-select');
        const studentSelect = document.getElementById('student-select');
        const startChatBtn = document.getElementById('start-chat-btn');

        if(cohortSelect) {
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
        }
    });
</script>
@endpush
