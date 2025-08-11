@extends('layouts.superadmin')

@section('title', 'Data Pegawai - Super Admin')

@section('content')
    <div class="position-relative">
        <h1 class="welcome-header">Data Pegawai</h1>
        <div class="notification-icon">
            <i class="fa-regular fa-bell">🔔</i>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Daftar Pegawai</span>
            <a href="{{ route('superadmin.staff.create') }}" class="btn btn-sm btn-success">+ Tambah Pegawai</a>
        </div>
        <div class="card-body">
            <form action="{{ route('superadmin.staff.index') }}" method="GET" class="mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <select class="form-select" name="position">
                            <option value="">Pilih Jabatan</option>
                            <option value="Guru" {{ request('position') == 'Guru' ? 'selected' : '' }}>Guru</option>
                            <option value="Staff TU" {{ request('position') == 'Staff TU' ? 'selected' : '' }}>Staff TU</option>
                            <option value="Kepala Sekolah" {{ request('position') == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                            <option value="Wakil Kepala Sekolah" {{ request('position') == 'Wakil Kepala Sekolah' ? 'selected' : '' }}>Wakil Kepala Sekolah</option>
                            <option value="Wali Kelas" {{ request('position') == 'Wali Kelas' ? 'selected' : '' }}>Wali Kelas</option>
                            <option value="Guru Bidang" {{ request('position') == 'Guru Bidang' ? 'selected' : '' }}>Guru Bidang</option>
                            <option value="Guru TPQ" {{ request('position') == 'Guru TPQ' ? 'selected' : '' }}>Guru TPQ</option>
                            <option value="Keamanan" {{ request('position') == 'Keamanan' ? 'selected' : '' }}>Keamanan</option>
                            <option value="Kebersihan" {{ request('position') == 'Kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                            <option value="Wakar" {{ request('position') == 'Wakar' ? 'selected' : '' }}>Wakar</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari pegawai..." name="search" value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('superadmin.staff.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Jenis Kelamin</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staff as $index => $s)
                        <tr>
                            <td>{{ $index + $staff->firstItem() }}</td>
                            <td>{{ $s->nip ?? '-' }}</td>
                            <td>{{ $s->name }}</td>
                            <td>{{ $s->position }}</td>
                            <td>{{ $s->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td>{{ $s->email ?? '-' }}</td>
                            <td>{{ $s->phone ?? '-' }}</td>
                            <td>
                                <a href="{{ route('superadmin.staff.show', $s->id) }}" class="btn btn-sm btn-info">Detail</a>
                                <a href="{{ route('superadmin.staff.edit', $s->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteStaffModal" data-id="{{ $s->id }}" data-name="{{ $s->name }}">Hapus</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data pegawai</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Custom Pagination -->
            @if($staff->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4 px-3">
                    <div class="text-muted small">
                        Menampilkan {{ $staff->firstItem() }} sampai {{ $staff->lastItem() }} dari {{ $staff->total() }} hasil
                    </div>

                    <nav aria-label="Pagination Navigation">
                        <ul class="pagination pagination-sm mb-0">
                            {{-- Previous Page Link --}}
                            @if ($staff->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">
                                        <i class="fas fa-chevron-left"></i>
                                        <span class="d-none d-sm-inline ms-1">Previous</span>
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $staff->appends(request()->query())->previousPageUrl() }}">
                                        <i class="fas fa-chevron-left"></i>
                                        <span class="d-none d-sm-inline ms-1">Previous</span>
                                    </a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($staff->appends(request()->query())->getUrlRange(1, $staff->lastPage()) as $page => $url)
                                @if ($page == $staff->currentPage())
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
                            @if ($staff->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $staff->appends(request()->query())->nextPageUrl() }}">
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

    <!-- Modal Hapus Pegawai -->
    <div class="modal fade" id="deleteStaffModal" tabindex="-1" aria-labelledby="deleteStaffModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteStaffModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data pegawai <strong id="delete-staff-name"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteStaffForm" method="POST">
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
    // Delete Staff Modal
    document.querySelectorAll('[data-bs-target="#deleteStaffModal"]').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');

            document.getElementById('delete-staff-name').textContent = name;

            const form = document.getElementById('deleteStaffForm');
            form.action = `/superadmin/staff/${id}`;
        });
    });
</script>
@endsection
