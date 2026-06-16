@extends('layouts.mahasiswa')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="mhs-card">
    <div class="mhs-card-header">
        <h6 class="mhs-card-title">
            <span class="mhs-card-icon" style="background:var(--primary-light);color:var(--primary);">
                <i class="bi bi-calendar-check"></i>
            </span>
            Riwayat Absensi Perkuliahan
        </h6>
    </div>
    <div style="overflow-x:auto;">
        @if($attendances->isNotEmpty())
        <table class="mhs-table">
            <thead>
                <tr>
                    <th style="padding-left:20px;">Tanggal</th>
                    <th>Mata Kuliah</th>
                    <th>Dosen Pengampu</th>
                    <th style="text-align:center;">Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendances as $att)
                <tr>
                    <td style="padding-left:20px;font-weight:600;">{{ \Carbon\Carbon::parse($att->date)->format('d M Y') }}</td>
                    <td style="font-weight:600;">{{ $att->subject->name ?? '-' }}</td>
                    <td style="color:var(--text-2);"><i class="bi bi-person me-1"></i>{{ $att->lecturer->name ?? '-' }}</td>
                    <td style="text-align:center;">
                        @if($att->status === 'hadir')
                            <span class="mhs-badge success">Hadir</span>
                        @elseif($att->status === 'izin')
                            <span class="mhs-badge cyan">Izin</span>
                        @elseif($att->status === 'sakit')
                            <span class="mhs-badge warning">Sakit</span>
                        @else
                            <span class="mhs-badge danger">Alpa</span>
                        @endif
                    </td>
                    <td style="font-size:0.78rem;color:var(--text-2);">{{ $att->notes ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="mhs-empty" style="padding:40px 20px;">
            <i class="bi bi-calendar-x"></i>
            <p>Belum ada riwayat absensi tercatat.</p>
        </div>
        @endif
    </div>
</div>
@endsection
