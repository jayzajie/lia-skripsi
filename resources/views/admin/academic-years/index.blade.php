@extends('layouts.admin')

@section('title', 'Tahun Ajaran - Admin')

@section('content')
    <div class="position-relative">
        <h1 class="welcome-header">Manajemen Tahun Ajaran</h1>
        <div class="notification-icon">
            <i class="fa-regular fa-bell">🔔</i>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title fw-semibold">Daftar Tahun Ajaran</h5>
                        {{-- <a href="{{ route('admin.academic-years.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Tambah Tahun Ajaran
                        </a> --}}
                    </div>

                    @if($academicYears->isEmpty())
                        <div class="alert alert-info">
                            Belum ada data tahun ajaran. Silakan tambahkan tahun ajaran baru.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Status</th>
                                        <th>Deskripsi</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($academicYears as $index => $year)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $year->year }}</td>
                                            <td>
                                                @if($year->is_active)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                                @endif
                                            </td>
                                            <td>{{ $year->description ?? '-' }}</td>
                                            <td>{{ $year->created_at->format('d M Y') }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    @if(!$year->is_active)
                                                        <form action="{{ route('admin.academic-years.set-active', $year) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Apakah Anda yakin ingin mengaktifkan tahun ajaran ini?')">
                                                                <i class="ti ti-check"></i> Aktifkan
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <a href="{{ route('admin.academic-years.edit', $year) }}" class="btn btn-sm btn-primary">
                                                        <i class="ti ti-edit"></i> Edit
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                                                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection