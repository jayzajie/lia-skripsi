@extends('layouts.superadmin')

@section('title', 'Data Siswa - Super Admin')

@section('content')
    <div class="position-relative">
        <h1 class="welcome-header">Data Siswa</h1>
        <div class="notification-icon">
            <i class="fa-regular fa-bell">🔔</i>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <span>Daftar Siswa</span>
                @if(request('class'))
                    <span class="badge bg-primary ms-2">Kelas: {{ request('class') }}</span>
                @endif
                @if(request('status'))
                    <span class="badge bg-info ms-2">Status: {{ ucfirst(request('status')) }}</span>
                @endif
                @if(request('academic_year'))
                    <span class="badge bg-warning ms-2">Tahun: {{ request('academic_year') }}</span>
                @endif
                @if(request('search'))
                    <span class="badge bg-secondary ms-2">Pencarian: "{{ request('search') }}"</span>
                @endif
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('superadmin.students.index') }}" method="GET">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <select class="form-select" name="class" id="class-filter">
                            <option value="">Pilih Kelas</option>
                            <option value="1A" {{ request('class') == '1A' ? 'selected' : '' }}>Kelas 1A</option>
                            <option value="1B" {{ request('class') == '1B' ? 'selected' : '' }}>Kelas 1B</option>
                            <option value="2A" {{ request('class') == '2A' ? 'selected' : '' }}>Kelas 2A</option>
                            <option value="2B" {{ request('class') == '2B' ? 'selected' : '' }}>Kelas 2B</option>
                            <option value="3A" {{ request('class') == '3A' ? 'selected' : '' }}>Kelas 3A</option>
                            <option value="3B" {{ request('class') == '3B' ? 'selected' : '' }}>Kelas 3B</option>
                            <option value="4A" {{ request('class') == '4A' ? 'selected' : '' }}>Kelas 4A</option>
                            <option value="4B" {{ request('class') == '4B' ? 'selected' : '' }}>Kelas 4B</option>
                            <option value="5A" {{ request('class') == '5A' ? 'selected' : '' }}>Kelas 5A</option>
                            <option value="5B" {{ request('class') == '5B' ? 'selected' : '' }}>Kelas 5B</option>
                            <option value="6A" {{ request('class') == '6A' ? 'selected' : '' }}>Kelas 6A</option>
                            <option value="6B" {{ request('class') == '6B' ? 'selected' : '' }}>Kelas 6B</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="status" id="status-filter">
                            <option value="">Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="academic_year" id="academic-year-filter">
                            <option value="">Tahun Ajaran</option>
                            @foreach($academicYears as $year)
                                <option value="{{ $year }}" {{ request('academic_year') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari siswa..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12 text-end">
                        <a href="{{ route('superadmin.students.create') }}" class="btn btn-success me-2">
                            <i class="fas fa-plus me-1"></i>Tambah Siswa
                        </a>
                        <a href="{{ route('superadmin.students.index') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Tahun Ajaran</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $index => $student)
                        <tr>
                            <td>{{ $students->firstItem() + $index }}</td>
                            <td>{{ $student->nis ?? '-' }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->class_level }}</td>
                            <td>{{ $student->academic_year ?? '-' }}</td>
                            <td>{{ $student->gender }}</td>
                            <td>{{ $student->birth_date ? $student->birth_date->format('d M Y') : '-' }}</td>
                            <td>{{ $student->address ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $student->status == 'active' ? 'success' : 'danger' }}">
                                    {{ $student->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('superadmin.students.show', $student) }}" class="btn btn-sm btn-info">Detail</a>
                                <a href="{{ route('superadmin.students.edit', $student) }}" class="btn btn-sm btn-warning">Edit</a>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteStudentModal"
                                       data-id="{{ $student->id }}"
                                       data-name="{{ $student->name }}">Hapus</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">Tidak ada data siswa</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $students->firstItem() ?? 0 }} hingga {{ $students->lastItem() ?? 0 }} dari {{ $students->total() ?? 0 }} data
                </div>
                <div>
                    {{ $students->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Siswa -->
    <div class="modal fade" id="deleteStudentModal" tabindex="-1" aria-labelledby="deleteStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteStudentModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data siswa <strong id="delete-student-name"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteStudentForm" method="POST">
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
    // Auto-submit form when filter changes
    document.addEventListener('DOMContentLoaded', function() {
        const classFilter = document.getElementById('class-filter');
        const statusFilter = document.getElementById('status-filter');
        const academicYearFilter = document.getElementById('academic-year-filter');
        const form = classFilter.closest('form');

        // Auto-submit when class filter changes
        classFilter.addEventListener('change', function() {
            form.submit();
        });

        // Auto-submit when status filter changes
        statusFilter.addEventListener('change', function() {
            form.submit();
        });

        // Auto-submit when academic year filter changes
        academicYearFilter.addEventListener('change', function() {
            form.submit();
        });
    });

    // Delete Student Modal
    document.querySelectorAll('[data-bs-target="#deleteStudentModal"]').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');

            document.getElementById('delete-student-name').textContent = name;

            const form = document.getElementById('deleteStudentForm');
            form.action = `{{ url('superadmin/students') }}/${id}`;
        });
    });
</script>
@endsection
