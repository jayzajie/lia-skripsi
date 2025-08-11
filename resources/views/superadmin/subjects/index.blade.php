@extends('layouts.superadmin')

@section('title', 'Data Mata Pelajaran - Super Admin')

@section('content')
    <div class="position-relative">
        <h1 class="welcome-header">Data Mata Pelajaran</h1>
        <div class="notification-icon">
            <i class="fa-regular fa-bell">🔔</i>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header">
            <span>Daftar Mata Pelajaran</span>
        </div>
        <div class="card-body">
            <!-- Filter dan Tambah Button -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Filter Mata Pelajaran</h5>
                <a href="{{ route('superadmin.subjects.create') }}" class="btn btn-success">
                    <i class="fas fa-plus me-1"></i> Tambah Mata Pelajaran
                </a>
            </div>

            <form action="{{ route('superadmin.subjects.index') }}" method="GET">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <select class="form-select" id="class-filter" name="class_level">
                            <option value="">Semua Kelas</option>
                            <option value="1A" {{ request('class_level') == '1A' ? 'selected' : '' }}>Kelas 1A</option>
                            <option value="1B" {{ request('class_level') == '1B' ? 'selected' : '' }}>Kelas 1B</option>
                            <option value="2A" {{ request('class_level') == '2A' ? 'selected' : '' }}>Kelas 2A</option>
                            <option value="2B" {{ request('class_level') == '2B' ? 'selected' : '' }}>Kelas 2B</option>
                            <option value="3A" {{ request('class_level') == '3A' ? 'selected' : '' }}>Kelas 3A</option>
                            <option value="3B" {{ request('class_level') == '3B' ? 'selected' : '' }}>Kelas 3B</option>
                            <option value="4A" {{ request('class_level') == '4A' ? 'selected' : '' }}>Kelas 4A</option>
                            <option value="4B" {{ request('class_level') == '4B' ? 'selected' : '' }}>Kelas 4B</option>
                            <option value="5A" {{ request('class_level') == '5A' ? 'selected' : '' }}>Kelas 5A</option>
                            <option value="5B" {{ request('class_level') == '5B' ? 'selected' : '' }}>Kelas 5B</option>
                            <option value="6A" {{ request('class_level') == '6A' ? 'selected' : '' }}>Kelas 6A</option>
                            <option value="6B" {{ request('class_level') == '6B' ? 'selected' : '' }}>Kelas 6B</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="status-filter" name="status">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari mata pelajaran..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('superadmin.subjects.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Guru Pengajar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subjects as $index => $subject)
                        <tr>
                            <td>{{ $subjects->firstItem() + $index }}</td>
                            <td>{{ $subject->code ?? '-' }}</td>
                            <td>{{ $subject->name }}</td>
                            <td>{{ $subject->class_level ?? 'Semua' }}</td>
                            <td>{{ $subject->teacher->name ?? 'Belum ditentukan' }}</td>
                            <td>
                                <span class="badge bg-{{ $subject->status == 'active' ? 'success' : 'danger' }}">
                                    {{ $subject->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('superadmin.subjects.show', $subject) }}" class="btn btn-sm btn-info">Detail</a>
                                <a href="{{ route('superadmin.subjects.edit', $subject) }}" class="btn btn-sm btn-warning">Edit</a>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteSubjectModal"
                                       data-id="{{ $subject->id }}"
                                       data-name="{{ $subject->name }}">Hapus</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data mata pelajaran</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $subjects->firstItem() ?? 0 }} hingga {{ $subjects->lastItem() ?? 0 }} dari {{ $subjects->total() ?? 0 }} data
                </div>
                <div>
                    {{ $subjects->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Mata Pelajaran -->
    <div class="modal fade" id="deleteSubjectModal" tabindex="-1" aria-labelledby="deleteSubjectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteSubjectModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus mata pelajaran <strong id="delete-subject-name"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteSubjectForm" method="POST">
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
    // Delete Subject Modal
    document.querySelectorAll('[data-bs-target="#deleteSubjectModal"]').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');

            document.getElementById('delete-subject-name').textContent = name;

            const form = document.getElementById('deleteSubjectForm');
            form.action = `{{ url('superadmin/subjects') }}/${id}`;
        });
    });
</script>
@endsection
