@extends('layouts.superadmin')

@section('title', 'Detail Kelas ' . $class->name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Detail Kelas {{ $class->name }}</h1>
            <p class="text-muted">Informasi lengkap kelas {{ $class->name }} - {{ $class->academic_year }}</p>
        </div>
        <div>
            <a href="{{ route('superadmin.classes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Data Kelas
            </a>
            <a href="{{ route('superadmin.rombel.edit', $class) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Kelas
            </a>
        </div>
    </div>

    <!-- Class Information -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Kelas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Nama Kelas:</strong></td>
                                    <td>{{ $class->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tingkat:</strong></td>
                                    <td>Kelas {{ substr($class->name, 0, 1) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tahun Ajaran:</strong></td>
                                    <td>{{ $class->academic_year }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <span class="badge badge-{{ $class->status === 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($class->status) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Kapasitas:</strong></td>
                                    <td>{{ $class->capacity }} siswa</td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah Siswa:</strong></td>
                                    <td>{{ $class->current_students }} siswa</td>
                                </tr>
                                <tr>
                                    <td><strong>Sisa Slot:</strong></td>
                                    <td>{{ $class->capacity - $class->current_students }} siswa</td>
                                </tr>
                                <tr>
                                    <td><strong>Wali Kelas:</strong></td>
                                    <td>{{ $class->teacher ? $class->teacher->name : 'Belum ditentukan' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Statistik</h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-{{ $class->current_students >= $class->capacity ? 'danger' : 'success' }}"
                                 style="width: {{ $class->capacity > 0 ? ($class->current_students / $class->capacity) * 100 : 0 }}%">
                                {{ $class->capacity > 0 ? round(($class->current_students / $class->capacity) * 100, 1) : 0 }}%
                            </div>
                        </div>
                        <small class="text-muted">Tingkat Okupansi</small>
                    </div>

                    @if($class->current_students >= $class->capacity)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            Kelas sudah penuh!
                        </div>
                    @elseif($class->current_students == 0)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            Kelas masih kosong
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Students List -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-users"></i> Daftar Siswa ({{ $class->students->count() }})</h5>
            @if($class->status === 'active' && $class->current_students < $class->capacity)
                <a href="{{ route('superadmin.students.create') }}?class={{ $class->id }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Tambah Siswa
                </a>
            @endif
        </div>
        <div class="card-body">
            @if($class->students->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Jenis Kelamin</th>
                                <th>Status</th>
                                <th>Tanggal Masuk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($class->students as $index => $student)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $student->name }}</strong>
                                        @if($student->student_id)
                                            <br><small class="text-muted">ID: {{ $student->student_id }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $student->gender === 'L' ? 'primary' : 'pink' }}">
                                            {{ $student->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $student->status === 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($student->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $student->created_at ? $student->created_at->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        <a href="{{ route('superadmin.students.show', $student) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('superadmin.students.edit', $student) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada siswa di kelas ini</p>
                    @if($class->status === 'active')
                        <a href="{{ route('superadmin.students.create') }}?class={{ $class->id }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Siswa Pertama
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
