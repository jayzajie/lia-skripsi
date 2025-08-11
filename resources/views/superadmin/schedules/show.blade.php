@extends('layouts.superadmin')

@section('title', 'Detail Jadwal Pembelajaran - Super Admin')

@section('content')
    <div class="position-relative">
        <h1 class="welcome-header">Detail Jadwal Pembelajaran</h1>
    </div>

    <div class="dashboard-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Informasi Jadwal</span>
            <div>
                <a href="{{ route('superadmin.schedules.edit', $schedule) }}" class="btn btn-sm btn-warning">
                    <i class="ti ti-edit me-1"></i> Edit
                </a>
                <a href="{{ route('superadmin.schedules.index') }}" class="btn btn-sm btn-secondary ms-2">
                    <i class="ti ti-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="35%">Mata Pelajaran</th>
                            <td width="65%">: {{ $schedule->subject->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Kode Mata Pelajaran</th>
                            <td>: {{ $schedule->subject->code ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Guru Pengajar</th>
                            <td>: {{ $schedule->teacher->name ?? 'Belum ditentukan' }}</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>: {{ $schedule->class_level }}</td>
                        </tr>
                        <tr>
                            <th>Hari</th>
                            <td>: {{ $schedule->day_of_week }}</td>
                        </tr>
                        <tr>
                            <th>Jam Pembelajaran</th>
                            <td>: {{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="35%">Ruangan</th>
                            <td width="65%">: {{ $schedule->room ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tahun Ajaran</th>
                            <td>: {{ $schedule->academic_year }}</td>
                        </tr>
                        <tr>
                            <th>Semester</th>
                            <td>: {{ $schedule->semester }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>: 
                                <span class="badge bg-{{ $schedule->status === 'active' ? 'success' : 'danger' }}">
                                    {{ $schedule->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Terakhir Diperbarui</th>
                            <td>: {{ $schedule->updated_at->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat Pada</th>
                            <td>: {{ $schedule->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            @if($schedule->notes)
                <div class="mt-4">
                    <h5>Catatan:</h5>
                    <div class="p-3 bg-light rounded">
                        {{ $schedule->notes }}
                    </div>
                </div>
            @endif
            
            <div class="mt-4 d-flex justify-content-between">
                <form action="{{ route('superadmin.schedules.destroy', $schedule) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="ti ti-trash me-1"></i> Hapus Jadwal
                    </button>
                </form>
                
                <form action="{{ route('superadmin.schedules.toggleStatus', $schedule) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-{{ $schedule->status === 'active' ? 'warning' : 'success' }}">
                        <i class="ti ti-{{ $schedule->status === 'active' ? 'ban' : 'check' }} me-1"></i> 
                        {{ $schedule->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }} Jadwal
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection 