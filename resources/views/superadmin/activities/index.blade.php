@extends('layouts.superadmin')

@section('title', 'Data Kegiatan - Super Admin')

@section('content')
    <div class="position-relative">
        <h1 class="welcome-header">Data Kegiatan</h1>
        <div class="notification-icon">
            <i class="fa-regular fa-bell">🔔</i>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header">
            <span>Daftar Kegiatan</span>
        </div>
        <div class="card-body">
            <!-- Filter dan Tambah Button -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Filter Kegiatan</h5>
                <a href="{{ route('superadmin.activities.create') }}" class="btn btn-success">
                    <i class="fas fa-plus me-1"></i> Tambah Kegiatan
                </a>
            </div>

            <form action="{{ route('superadmin.activities.index') }}" method="GET">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <select class="form-select" id="status-filter" name="status">
                            <option value="">Semua Status</option>
                            <option value="Mendatang" {{ request('status') == 'Mendatang' ? 'selected' : '' }}>Mendatang</option>
                            <option value="Berlangsung" {{ request('status') == 'Berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="published-filter" name="published">
                            <option value="">Semua Publikasi</option>
                            <option value="1" {{ request('published') == '1' ? 'selected' : '' }}>Dipublikasikan</option>
                            <option value="0" {{ request('published') == '0' ? 'selected' : '' }}>Disembunyikan</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari kegiatan..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('superadmin.activities.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kegiatan</th>
                            <th>Nama orang</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Publikasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($activities as $index => $activity)
                        <tr>
                            <td>{{ $activities->firstItem() + $index }}</td>
                            <td>{{ $activity->name }}</td>
                            <td>{{ $activity->created_by }}</td>
                            <td>{{ $activity->date->format('d F Y') }}</td>
                            <td>{{ $activity->location }}</td>
                            <td>
                                <span class="badge bg-{{ $activity->status == 'Mendatang' ? 'warning' : ($activity->status == 'Berlangsung' ? 'primary' : 'success') }}">
                                    {{ $activity->status }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('superadmin.activities.toggle-published', $activity) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-check form-switch">
                                        <input class="form-check-input toggle-publish" type="checkbox"
                                            id="publish-{{ $activity->id }}"
                                            {{ $activity->is_published ? 'checked' : '' }}
                                            onChange="this.form.submit()">
                                    </div>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('superadmin.activities.show', $activity) }}" class="btn btn-sm btn-info">Detail</a>
                                <a href="{{ route('superadmin.activities.edit', $activity) }}" class="btn btn-sm btn-warning">Edit</a>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteActivityModal"
                                    data-id="{{ $activity->id }}"
                                    data-name="{{ $activity->name }}">Hapus</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data kegiatan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Custom Pagination -->
            @if($activities->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4 px-3">
                    <div class="text-muted small">
                        Menampilkan {{ $activities->firstItem() }} sampai {{ $activities->lastItem() }} dari {{ $activities->total() }} hasil
                    </div>

                    <nav aria-label="Pagination Navigation">
                        <ul class="pagination pagination-sm mb-0">
                            {{-- Previous Page Link --}}
                            @if ($activities->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">
                                        <i class="fas fa-chevron-left"></i>
                                        <span class="d-none d-sm-inline ms-1">Previous</span>
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $activities->appends(request()->query())->previousPageUrl() }}">
                                        <i class="fas fa-chevron-left"></i>
                                        <span class="d-none d-sm-inline ms-1">Previous</span>
                                    </a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($activities->appends(request()->query())->getUrlRange(1, $activities->lastPage()) as $page => $url)
                                @if ($page == $activities->currentPage())
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
                            @if ($activities->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $activities->appends(request()->query())->nextPageUrl() }}">
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

    <!-- Modal Hapus Kegiatan -->
    <div class="modal fade" id="deleteActivityModal" tabindex="-1" aria-labelledby="deleteActivityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteActivityModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus kegiatan <strong id="delete-activity-name"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteActivityForm" method="POST">
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
    // Delete Activity Modal
    document.querySelectorAll('[data-bs-target="#deleteActivityModal"]').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');

            document.getElementById('delete-activity-name').textContent = name;

            const form = document.getElementById('deleteActivityForm');
            form.action = `{{ url('superadmin/activities') }}/${id}`;
        });
    });
</script>
@endsection
