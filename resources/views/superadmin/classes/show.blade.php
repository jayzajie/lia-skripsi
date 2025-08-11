@extends('layouts.superadmin')

@section('title', 'Detail Kelas ' . $class->name . ' - Super Admin')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                <div class="card-body py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h2 mb-1 fw-bold">
                                <i class="fas fa-school me-2"></i>
                                Detail Kelas {{ $class->name }}
                            </h1>
                            <p class="mb-0 opacity-75">
                                <i class="fas fa-calendar-alt me-1"></i>
                                Tahun Ajaran {{ $class->academic_year }}
                            </p>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('superadmin.classes.index') }}" class="btn btn-light me-2">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                            <a href="{{ route('superadmin.classes.edit', $class) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-1"></i>Edit Kelas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Students -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-gradient rounded-3 p-3">
                                <i class="fas fa-users text-white fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small fw-bold text-uppercase">Total Siswa</div>
                            <div class="fs-2 fw-bold text-primary">{{ $class->current_students }}</div>
                            <div class="small text-muted">dari {{ $class->capacity }} kapasitas</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Capacity -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-gradient rounded-3 p-3">
                                <i class="fas fa-user-plus text-white fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small fw-bold text-uppercase">Kapasitas Tersisa</div>
                            <div class="fs-2 fw-bold text-success">{{ $class->available_capacity }}</div>
                            <div class="small text-muted">tempat tersedia</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Class Status -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-{{ $class->status == 'active' ? 'success' : 'secondary' }} bg-gradient rounded-3 p-3">
                                <i class="fas fa-{{ $class->status == 'active' ? 'check-circle' : 'pause-circle' }} text-white fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small fw-bold text-uppercase">Status Kelas</div>
                            <div class="fs-4 fw-bold text-{{ $class->status == 'active' ? 'success' : 'secondary' }}">
                                {{ $class->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                            </div>
                            <div class="small text-muted">{{ $class->status == 'active' ? 'Menerima siswa' : 'Tidak menerima siswa' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Capacity Percentage -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-{{ $class->is_full ? 'danger' : 'warning' }} bg-gradient rounded-3 p-3">
                                <i class="fas fa-chart-pie text-white fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small fw-bold text-uppercase">Persentase Terisi</div>
                            <div class="fs-2 fw-bold text-{{ $class->is_full ? 'danger' : 'warning' }}">
                                {{ $class->capacity > 0 ? round(($class->current_students / $class->capacity) * 100) : 0 }}%
                            </div>
                            <div class="small text-muted">{{ $class->is_full ? 'Kelas penuh' : 'Masih tersedia' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Class Information -->
    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Informasi Kelas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">NAMA KELAS</label>
                        <div class="fs-4 fw-bold text-primary">{{ $class->name }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">TINGKAT</label>
                        <div class="fs-5">Kelas {{ $class->grade_level }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">BAGIAN</label>
                        <div class="fs-5">{{ $class->section }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">TAHUN AJARAN</label>
                        <div class="fs-5">{{ $class->academic_year }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small">WALI KELAS</label>
                        <div class="fs-5">
                            @if($class->homeroom_teacher)
                                <i class="fas fa-user-tie text-warning me-2"></i>
                                {{ $class->homeroom_teacher }}
                            @else
                                <span class="text-muted">Belum ditentukan</span>
                            @endif
                        </div>
                    </div>
                    @if($class->description)
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small">DESKRIPSI</label>
                            <div class="text-muted">{{ $class->description }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-users text-success me-2"></i>
                            Daftar Siswa ({{ $students->total() }})
                        </h5>
                        <a href="{{ route('superadmin.students.index', ['class' => $class->name]) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-external-link-alt me-1"></i>Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($students->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $index => $student)
                                        <tr>
                                            <td>{{ $students->firstItem() + $index }}</td>
                                            <td>
                                                <span class="badge bg-primary-subtle text-primary">{{ $student->nis }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-light rounded-circle p-2 me-3">
                                                        <i class="fas fa-user text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $student->name }}</div>
                                                        <small class="text-muted">{{ $student->birth_date ? \Carbon\Carbon::parse($student->birth_date)->format('d M Y') : '-' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $student->gender == 'male' ? 'info' : 'pink' }}-subtle text-{{ $student->gender == 'male' ? 'info' : 'pink' }}">
                                                    {{ $student->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($student->status == 'active')
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('superadmin.students.show', $student) }}" 
                                                   class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($students->hasPages())
                            <div class="d-flex justify-content-center mt-3">
                                {{ $students->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-user-plus text-muted" style="font-size: 3rem;"></i>
                            </div>
                            <h6 class="text-muted">Belum ada siswa di kelas ini</h6>
                            <p class="text-muted small">Siswa akan muncul di sini setelah didaftarkan ke kelas {{ $class->name }}</p>
                            <a href="{{ route('superadmin.students.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>Tambah Siswa
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .bg-pink-subtle {
        background-color: rgba(255, 20, 147, 0.1) !important;
    }
    
    .text-pink {
        color: #ff1493 !important;
    }
    
    .bg-primary-subtle {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }
</style>
@endsection
