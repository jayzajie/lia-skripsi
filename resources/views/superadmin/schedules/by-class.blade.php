@extends('layouts.superadmin')

@section('title', 'Jadwal Pembelajaran Kelas ' . $validated['class_level'] . ' - Super Admin')

@section('content')
    <div class="position-relative">
        <h1 class="welcome-header">Jadwal Pembelajaran Kelas {{ $validated['class_level'] }}</h1>
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
                <div class="col-md-4">
                    <h6>Kelas</h6>
                    <p class="text-primary fw-bold">{{ $validated['class_level'] }}</p>
                </div>
                <div class="col-md-4">
                    <h6>Tahun Ajaran</h6>
                    <p class="text-primary fw-bold">{{ $validated['academic_year'] }}</p>
                </div>
                <div class="col-md-4">
                    <h6>Semester</h6>
                    <p class="text-primary fw-bold">{{ $validated['semester'] }}</p>
                </div>
            </div>
            
            @if(count($sortedSchedules) == 0)
                <div class="alert alert-info">
                    Belum ada jadwal yang ditambahkan untuk kelas {{ $validated['class_level'] }}.
                </div>
            @else
                <ul class="nav nav-tabs" id="dayTab" role="tablist">
                    @foreach($sortedSchedules as $day => $schedules)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ strtolower($day) }}-tab" data-bs-toggle="tab" 
                                    data-bs-target="#{{ strtolower($day) }}" type="button" role="tab" 
                                    aria-controls="{{ strtolower($day) }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ $day }}
                            </button>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content pt-3" id="dayTabContent">
                    @foreach($sortedSchedules as $day => $schedules)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ strtolower($day) }}" 
                             role="tabpanel" aria-labelledby="{{ strtolower($day) }}-tab">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="15%">Jam</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Guru</th>
                                            <th>Ruangan</th>
                                            <th width="10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($schedules->sortBy('start_time') as $schedule)
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
                                                <td colspan="5" class="text-center">Belum ada jadwal untuk hari ini.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    
    <div class="dashboard-card mb-4">
        <div class="card-header">
            <span>Ringkasan Jadwal Kelas {{ $validated['class_level'] }}</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="15%">Jam</th>
                            <th>Senin</th>
                            <th>Selasa</th>
                            <th>Rabu</th>
                            <th>Kamis</th>
                            <th>Jumat</th>
                            <th>Sabtu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $timeSlots = [
                                '07:30-08:10', '08:10-08:50', '08:50-09:30', '09:30-10:10', 
                                '10:10-10:50', '10:50-11:30', '11:30-12:10', '12:10-12:50'
                            ];
                            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                        @endphp
                        
                        @foreach($timeSlots as $timeSlot)
                            <tr>
                                <td>{{ $timeSlot }}</td>
                                @foreach($days as $day)
                                    <td>
                                        @php
                                            $foundSchedule = null;
                                            
                                            if(isset($sortedSchedules[$day])) {
                                                $timeParts = explode('-', $timeSlot);
                                                $startTime = \Carbon\Carbon::createFromFormat('H:i', $timeParts[0]);
                                                $endTime = \Carbon\Carbon::createFromFormat('H:i', $timeParts[1]);
                                                
                                                foreach($sortedSchedules[$day] as $schedule) {
                                                    $scheduleStart = \Carbon\Carbon::createFromTimeString($schedule->start_time->format('H:i'));
                                                    $scheduleEnd = \Carbon\Carbon::createFromTimeString($schedule->end_time->format('H:i'));
                                                    
                                                    // Check if schedule overlaps with time slot
                                                    if(($scheduleStart <= $startTime && $scheduleEnd > $startTime) || 
                                                       ($scheduleStart >= $startTime && $scheduleStart < $endTime)) {
                                                        $foundSchedule = $schedule;
                                                        break;
                                                    }
                                                }
                                            }
                                        @endphp
                                        
                                        @if($foundSchedule)
                                            <div class="small">
                                                <div class="fw-bold">{{ $foundSchedule->subject->name ?? 'N/A' }}</div>
                                                <div>{{ $foundSchedule->teacher->name ?? 'Belum ditentukan' }}</div>
                                                <div class="text-muted">{{ $foundSchedule->room ?? 'Ruang -' }}</div>
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-center">
        <a href="{{ route('superadmin.schedules.create') }}" class="btn btn-success">
            <i class="ti ti-plus me-1"></i> Tambah Jadwal Baru
        </a>
    </div>
@endsection 