@extends('layouts.superadmin')

@section('title', 'Detail Siswa - Super Admin')

@section('content')
    <div class="position-relative">
        <h1 class="welcome-header">Detail Siswa</h1>
        <div class="notification-icon">
            <i class="fa-regular fa-bell">🔔</i>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Informasi Siswa</span>
            <div>
                <a href="{{ route('superadmin.students.edit', $student->id) }}" class="btn btn-sm btn-warning">
                    <i class="ti ti-pencil"></i> Edit
                </a>
                <a href="{{ route('superadmin.students.index') }}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">NIS</th>
                            <td>: {{ $student->nis ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Nama Lengkap</th>
                            <td>: {{ $student->name }}</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>: {{ $student->class_level }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>: {{ $student->gender }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td>: {{ $student->birth_date ? $student->birth_date->format('d F Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>: {{ $student->address ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>: 
                                @if($student->status == 'active')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Tidak Aktif</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4 text-center">
                    <div class="mb-3">
                        <img src="{{ $student->photo ? asset('storage/' . $student->photo) : asset('images/default-student.png') }}" 
                            alt="Foto {{ $student->name }}" 
                            class="img-thumbnail" style="max-width: 200px;">
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <h5>Riwayat Akademik</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-light">
                                <th>Tahun Ajaran</th>
                                <th>Semester</th>
                                <th>Kelas</th>
                                <th>Wali Kelas</th>
                                <th>Rata-rata Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($student->evaluations && count($student->evaluations) > 0)
                                @foreach($student->evaluations->groupBy(['academic_year', 'semester']) as $academicYear => $yearGroup)
                                    @foreach($yearGroup as $semester => $evaluations)
                                        <tr>
                                            <td>{{ $academicYear }}</td>
                                            <td>{{ $semester }}</td>
                                            <td>{{ $student->class_level }}</td>
                                            <td>-</td>
                                            <td>{{ $evaluations->avg('final_score') ? number_format($evaluations->avg('final_score'), 2) : '-' }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data akademik</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Hapus di bagian bawah -->
    <div class="mt-3 text-end">
        <form action="{{ route('superadmin.students.destroy', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="ti ti-trash"></i> Hapus Siswa
            </button>
        </form>
    </div>
@endsection 