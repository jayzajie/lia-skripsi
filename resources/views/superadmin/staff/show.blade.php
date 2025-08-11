@extends('layouts.superadmin')

@section('title', 'Detail Pegawai - Super Admin')

@section('content')
    <div class="position-relative">
        <h1 class="welcome-header">Detail Pegawai</h1>
        <div class="notification-icon">
            <i class="fa-regular fa-bell">🔔</i>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Informasi Pegawai</span>
            <div>
                <a href="{{ route('superadmin.staff.edit', $staff->id) }}" class="btn btn-sm btn-warning">
                    <i class="ti ti-pencil"></i> Edit
                </a>
                <a href="{{ route('superadmin.staff.index') }}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">NIP</th>
                            <td>: {{ $staff->nip ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Nama Lengkap</th>
                            <td>: {{ $staff->name }}</td>
                        </tr>
                        <tr>
                            <th>Jabatan</th>
                            <td>: {{ $staff->position }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>: {{ $staff->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>: {{ $staff->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>No. Telepon</th>
                            <td>: {{ $staff->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tempat, Tanggal Lahir</th>
                            <td>: {{ $staff->birth_place ?? '-' }}, {{ $staff->birth_date ? date('d F Y', strtotime($staff->birth_date)) : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Agama</th>
                            <td>: {{ $staff->religion ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>: {{ $staff->address ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tahun Bergabung</th>
                            <td>: {{ $staff->join_year ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4 text-center">
                    <div class="mb-3">
                        <img src="{{ $staff->photo ? asset('storage/' . $staff->photo) : asset('images/default-staff.png') }}" 
                            alt="Foto {{ $staff->name }}" 
                            class="img-thumbnail" style="max-width: 200px;">
                    </div>
                </div>
            </div>

            @if($staff->description)
            <div class="mt-4">
                <h5>Deskripsi</h5>
                <div class="card">
                    <div class="card-body">
                        {{ $staff->description }}
                    </div>
                </div>
            </div>
            @endif

            @if($staff->position == 'Guru')
            <div class="mt-4">
                <h5>Mata Pelajaran yang Diampu</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-light">
                                <th>Kode</th>
                                <th>Mata Pelajaran</th>
                                <th>Kelas</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($staff->subjects ?? [] as $subject)
                            <tr>
                                <td>{{ $subject->code }}</td>
                                <td>{{ $subject->name }}</td>
                                <td>{{ $subject->class_level }}</td>
                                <td>
                                    @if($subject->status == 'active')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada mata pelajaran yang diampu</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Tombol Hapus di bagian bawah -->
    <div class="mt-3 text-end">
        <form action="{{ route('superadmin.staff.destroy', $staff->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pegawai ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="ti ti-trash"></i> Hapus Pegawai
            </button>
        </form>
    </div>
@endsection 