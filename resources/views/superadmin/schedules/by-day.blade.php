@extends('layouts.superadmin')

@section('title', 'Jadwal Pembelajaran Hari ' . $validated['day_of_week'] . ' - Super Admin')

@section('content')
    <div class="position-relative">
        <h1 class="welcome-header">Jadwal Pembelajaran Hari {{ $validated['day_of_week'] }}</h1>
    </div>

    <div class="dashboard-card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Informasi Jadwal</span>
            <a href="{{ route('superadmin.schedules.index') }}" class="btn btn-sm btn-secondary">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-3">
                    <h6>Hari</h6>
                    <p class="text-primary fw-bold">{{ $validated['day_of_week'] }}</p>
                </div>
                @if(isset($validated['class_level']) && $validated['class_level'])
                    <div class="col-md-3">
                        <h6>Kelas</h6>
                        <p class="text-primary fw-bold">{{ $validated['class_level'] }}</p>
                    </div>
                @endif
                <div class="col-md-3">
                    <h6>Tahun Ajaran</h6>
                    <p class="text-primary fw-bold">{{ $validated['academic_year'] }}</p>
                </div>
                <div class="col-md-3">
                    <h6>Semester</h6>
                    <p class="text-primary fw-bold">{{ $validated['semester'] }}</p>
                </div>
            </div>
            
            @if(count($groupedSchedules) == 0)
                <div class="alert alert-info">
                    Belum ada jadwal yang ditambahkan untuk hari {{ $validated['day_of_week'] }}.
                </div>
            @else
                @if(isset($validated['class_level']) && $validated['class_level'])
                    <!-- Single class schedule -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Jam</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Guru</th>
                                    <th>Ruangan</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($groupedSchedules['all'] as $schedule)
                                    <tr>
                                        <td>{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</td>
                                        <td>{{ $schedule->subject->name ?? 'N/A' }}</td>
                                        <td>{{ $schedule->teacher->name ?? 'Belum ditentukan' }}</td>
                                        <td>{{ $schedule->room ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('superadmin.schedules.show', $schedule) }}" class="btn btn-sm btn-info">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                <a href="{{ route('superadmin.schedules.edit', $schedule) }}" class="btn btn-sm btn-warning">
                                                    <i class="ti ti-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada jadwal untuk kelas ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <!-- All classes schedule -->
                    <ul class="nav nav-tabs" id="classTab" role="tablist">
                        @foreach($groupedSchedules as $classLevel => $schedules)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="class{{ $classLevel }}-tab" data-bs-toggle="tab" 
                                        data-bs-target="#class{{ $classLevel }}" type="button" role="tab" 
                                        aria-controls="class{{ $classLevel }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                    Kelas {{ $classLevel }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content pt-3" id="classTabContent">
                        @foreach($groupedSchedules as $classLevel => $schedules)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="class{{ $classLevel }}" 
                                 role="tabpanel" aria-labelledby="class{{ $classLevel }}-tab">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Jam</th>
                                                <th>Mata Pelajaran</th>
                                                <th>Guru</th>
                                                <th>Ruangan</th>
                                                <th width="10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($schedules as $schedule)
                                                <tr>
                                                    <td>{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</td>
                                                    <td>{{ $schedule->subject->name ?? 'N/A' }}</td>
                                                    <td>{{ $schedule->teacher->name ?? 'Belum ditentukan' }}</td>
                                                    <td>{{ $schedule->room ?? '-' }}</td>
                                                    <td>
                                                        <div class="d-flex gap-1">
                                                            <a href="{{ route('superadmin.schedules.show', $schedule) }}" class="btn btn-sm btn-info">
                                                                <i class="ti ti-eye"></i>
                                                            </a>
                                                            <a href="{{ route('superadmin.schedules.edit', $schedule) }}" class="btn btn-sm btn-warning">
                                                                <i class="ti ti-edit"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Belum ada jadwal untuk kelas ini.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif
        </div>
    </div>
    
    <div class="d-flex justify-content-center">
        <a href="{{ route('superadmin.schedules.create') }}" class="btn btn-success">
            <i class="ti ti-plus me-1"></i> Tambah Jadwal Baru
        </a>
    </div>
@endsection 