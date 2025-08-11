@extends('layouts.superadmin')

@section('title', 'Detail Kegiatan - Super Admin')

@section('content')
    <div class="position-relative">
        <h1 class="welcome-header">Detail Kegiatan</h1>
    </div>

    <div class="dashboard-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Informasi Kegiatan</span>
            <div>
                <a href="{{ route('superadmin.activities.edit', $activity) }}" class="btn btn-sm btn-warning">
                    <i class="ti ti-edit me-1"></i> Edit
                </a>
                <a href="{{ route('superadmin.activities.index') }}" class="btn btn-sm btn-secondary ms-2">
                    <i class="ti ti-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Kegiatan</th>
                            <td width="70%">: {{ $activity->name }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>: {{ $activity->date->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <td>: {{ $activity->location }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Status</th>
                            <td width="70%">: 
                                <span class="badge bg-{{ $activity->status == 'Mendatang' ? 'warning' : ($activity->status == 'Berlangsung' ? 'primary' : 'success') }}">
                                    {{ $activity->status }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Publikasi</th>
                            <td>: 
                                <span class="badge bg-{{ $activity->is_published ? 'success' : 'secondary' }}">
                                    {{ $activity->is_published ? 'Dipublikasikan' : 'Disembunyikan' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Dibuat oleh</th>
                            <td>: {{ $activity->created_by }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="mt-4">
                <h5>Deskripsi</h5>
                <div class="p-3 bg-light rounded">
                    {{ $activity->description ?? 'Tidak ada deskripsi' }}
                </div>
            </div>
            
            <div class="mt-4 d-flex justify-content-between">
                <form action="{{ route('superadmin.activities.destroy', $activity) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="ti ti-trash me-1"></i> Hapus Kegiatan
                    </button>
                </form>
                
                <form action="{{ route('superadmin.activities.toggle-published', $activity) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-{{ $activity->is_published ? 'warning' : 'success' }}">
                        <i class="ti ti-{{ $activity->is_published ? 'eye-off' : 'eye' }} me-1"></i> 
                        {{ $activity->is_published ? 'Sembunyikan' : 'Publikasikan' }} Kegiatan
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection