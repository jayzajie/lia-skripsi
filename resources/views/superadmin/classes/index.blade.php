@extends('layouts.superadmin')

@section('title', 'Data Kelas - Super Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1 fw-bold">
                                <i class="fas fa-school text-primary me-2"></i>
                                Data Kelas
                            </h5>
                            <p class="text-muted small mb-0">Kelola dan manajemen kelas sekolah</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Section -->
                    <form action="{{ route('superadmin.classes.index') }}" method="GET" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <select class="form-select" name="grade_level">
                                    <option value="">Semua Tingkat</option>
                                    @for($i = 1; $i <= 6; $i++)
                                        <option value="{{ $i }}" {{ request('grade_level') == $i ? 'selected' : '' }}>
                                            Kelas {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" name="academic_year">
                                    <option value="">Semua Tahun Ajaran</option>
                                    @foreach($academicYears as $year)
                                        <option value="{{ $year }}" {{ request('academic_year') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search"
                                           placeholder="Cari kelas atau wali kelas..."
                                           value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 text-end">
                                <a href="{{ route('superadmin.classes.create') }}" class="btn btn-success me-2">
                                    <i class="fas fa-plus me-1"></i>Tambah Kelas
                                </a>
                                <a href="{{ route('superadmin.classes.index') }}" class="btn btn-outline-secondary">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            @foreach($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Classes Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kelas</th>
                                    <th>Tingkat</th>
                                    <th>Kapasitas</th>
                                    <th>Siswa Saat Ini</th>
                                    <th>Wali Kelas</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($classes as $index => $class)
                                    <tr>
                                        <td>{{ $classes->firstItem() + $index }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-gradient rounded-circle p-2 me-3">
                                                    <i class="fas fa-users text-white"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $class->name }}</div>
                                                    <small class="text-muted">{{ $class->description ?? 'Tidak ada deskripsi' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">Kelas {{ $class->grade_level }}</span>
                                        </td>
                                        <td>{{ $class->capacity }} siswa</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="me-2">{{ $class->current_students }}</span>
                                                <div class="progress" style="width: 60px; height: 8px;">
                                                    <div class="progress-bar {{ $class->is_full ? 'bg-danger' : 'bg-success' }}"
                                                         style="width: {{ $class->capacity > 0 ? ($class->current_students / $class->capacity) * 100 : 0 }}%">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $class->homeroom_teacher ?? '-' }}</td>
                                        <td>{{ $class->academic_year }}</td>
                                        <td>
                                            @if($class->status == 'active')
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('superadmin.classes.show', $class) }}" class="btn btn-sm btn-info">Detail</a>
                                            <a href="{{ route('superadmin.classes.edit', $class) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteClassModal" data-id="{{ $class->id }}" data-name="{{ $class->name }}">Hapus</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-school fa-3x mb-3"></i>
                                                <h6>Belum ada data kelas</h6>
                                                <p>Mulai dengan menambahkan kelas baru</p>
                                                <a href="{{ route('superadmin.classes.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus me-1"></i>Tambah Kelas
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Custom Pagination -->
                    @if($classes->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-4 px-3">
                            <div class="text-muted small">
                                Menampilkan {{ $classes->firstItem() }} sampai {{ $classes->lastItem() }} dari {{ $classes->total() }} hasil
                            </div>

                            <nav aria-label="Pagination Navigation">
                                <ul class="pagination pagination-sm mb-0">
                                    {{-- Previous Page Link --}}
                                    @if ($classes->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-left"></i>
                                                <span class="d-none d-sm-inline ms-1">Previous</span>
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $classes->appends(request()->query())->previousPageUrl() }}">
                                                <i class="fas fa-chevron-left"></i>
                                                <span class="d-none d-sm-inline ms-1">Previous</span>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($classes->appends(request()->query())->getUrlRange(1, $classes->lastPage()) as $page => $url)
                                        @if ($page == $classes->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($classes->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $classes->appends(request()->query())->nextPageUrl() }}">
                                                <span class="d-none d-sm-inline me-1">Next</span>
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <span class="d-none d-sm-inline me-1">Next</span>
                                                <i class="fas fa-chevron-right"></i>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus Kelas -->
<div class="modal fade" id="deleteClassModal" tabindex="-1" aria-labelledby="deleteClassModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteClassModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data kelas <strong id="delete-class-name"></strong>?</p>
            </div>
            <div class="modal-footer">
                <form id="deleteClassForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto submit form when filter changes
    document.querySelectorAll('select[name="grade_level"], select[name="status"], select[name="academic_year"]').forEach(function(select) {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });

    // Delete Class Modal
    document.querySelectorAll('[data-bs-target="#deleteClassModal"]').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');

            document.getElementById('delete-class-name').textContent = name;

            const form = document.getElementById('deleteClassForm');
            form.action = `/superadmin/classes/${id}`;
        });
    });
</script>
@endsection
