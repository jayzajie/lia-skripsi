@extends('layouts.superadmin')

@section('title', 'Detail Mata Pelajaran - Super Admin')

@section('content')
    <div class="position-relative">
        <h1 class="welcome-header">Detail Mata Pelajaran</h1>
        <div class="notification-icon">
            <i class="fa-regular fa-bell">🔔</i>
        </div>
    </div>

    <div class="dashboard-card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Informasi Mata Pelajaran</span>
            <div>
                <a href="{{ route('superadmin.subjects.edit', $subject) }}" class="btn btn-sm btn-warning">
                    <i class="ti ti-edit me-1"></i> Edit
                </a>
                <a href="{{ route('superadmin.subjects.index') }}" class="btn btn-sm btn-secondary">
                    <i class="ti ti-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 35%">Nama Mata Pelajaran</th>
                            <td>: {{ $subject->name }}</td>
                        </tr>
                        <tr>
                            <th>Kode</th>
                            <td>: {{ $subject->code ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>: {{ $subject->class_level ? 'Kelas '.$subject->class_level : 'Semua Kelas' }}</td>
                        </tr>
                        <tr>
                            <th>Jam Kredit</th>
                            <td>: {{ $subject->credit_hours ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 35%">Guru Pengajar</th>
                            <td>: {{ $subject->teacher->name ?? 'Belum ditentukan' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>: 
                                <span class="badge bg-{{ $subject->status == 'active' ? 'success' : 'danger' }}">
                                    {{ $subject->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Dibuat</th>
                            <td>: {{ $subject->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diperbarui</th>
                            <td>: {{ $subject->updated_at->format('d M Y, H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="mt-3">
                <h5>Deskripsi</h5>
                <p>{{ $subject->description ?? 'Tidak ada deskripsi' }}</p>
            </div>
        </div>
    </div>
    
    @if(count($subject->schedules) > 0)
    <div class="dashboard-card mb-4">
        <div class="card-header">
            <span>Jadwal Kelas</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Hari</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Kelas</th>
                            <th>Ruangan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subject->schedules as $index => $schedule)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $schedule->day }}</td>
                            <td>{{ $schedule->start_time }}</td>
                            <td>{{ $schedule->end_time }}</td>
                            <td>{{ $schedule->class_level }}</td>
                            <td>{{ $schedule->room }}</td>
                            <td>
                                <span class="badge bg-{{ $schedule->status == 'active' ? 'success' : 'danger' }}">
                                    {{ $schedule->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
    
    @if(count($subject->evaluations) > 0)
    <div class="dashboard-card">
        <div class="card-header">
            <span>Penilaian Siswa</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Semester</th>
                            <th>Tahun Ajaran</th>
                            <th>Nilai Akhir</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subject->evaluations as $index => $evaluation)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $evaluation->student->name }}</td>
                            <td>{{ $evaluation->student->class_level }}</td>
                            <td>{{ $evaluation->semester }}</td>
                            <td>{{ $evaluation->academic_year }}</td>
                            <td class="text-center">
                                <strong>{{ $evaluation->final_score ?? 'Belum ada' }}</strong>
                            </td>
                            <td class="text-center">
                                @if($evaluation->grade)
                                    <span class="badge bg-{{ 
                                        $evaluation->grade == 'A' ? 'success' : 
                                        ($evaluation->grade == 'B' ? 'primary' : 
                                        ($evaluation->grade == 'C' ? 'warning' : 
                                        ($evaluation->grade == 'D' ? 'danger' : 'danger'))) 
                                    }}">{{ $evaluation->grade }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
@endsection 