@extends('layouts.app')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-bottom border-light pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-calendar-check text-primary me-2"></i> Riwayat Absensi Perkuliahan</h6>
        </div>
        <div class="card-body p-0">
            @if($attendances->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light text-uppercase small fw-bold text-secondary">
                        <tr>
                            <th class="ps-4 py-3">Tanggal</th>
                            <th>Mata Kuliah</th>
                            <th>Dosen Pengampu</th>
                            <th class="text-center">Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $att)
                        <tr>
                            <td class="ps-4 fw-bold">{{ \Carbon\Carbon::parse($att->date)->format('d M Y') }}</td>
                            <td class="fw-bold text-dark">{{ $att->subject->name ?? '-' }}</td>
                            <td class="text-secondary"><i class="bi bi-person"></i> {{ $att->lecturer->name ?? '-' }}</td>
                            <td class="text-center">
                                @if($att->status === 'hadir') <span class="badge bg-success rounded-pill px-3">Hadir</span>
                                @elseif($att->status === 'izin') <span class="badge bg-info text-white rounded-pill px-3">Izin</span>
                                @elseif($att->status === 'sakit') <span class="badge bg-warning text-dark rounded-pill px-3">Sakit</span>
                                @else <span class="badge bg-danger rounded-pill px-3">Alpa</span>
                                @endif
                            </td>
                            <td class="small text-muted">{{ $att->notes ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-calendar-x text-muted fs-1 mb-3 d-block"></i>
                <p class="text-muted mb-0">Belum ada riwayat absensi tercatat.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
