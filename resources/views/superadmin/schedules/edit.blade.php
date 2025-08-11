@extends('layouts.superadmin')

@section('title', 'Edit Jadwal Pembelajaran - Super Admin')

@section('content')
    <div class="position-relative">
        <h1 class="welcome-header">Edit Jadwal Pembelajaran</h1>
    </div>

    <div class="dashboard-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Form Edit Jadwal</span>
            <a href="{{ route('superadmin.schedules.index') }}" class="btn btn-sm btn-secondary">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('superadmin.schedules.update', $schedule) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="subject_id" class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                        <select name="subject_id" id="subject_id" class="form-select @error('subject_id') is-invalid @enderror" required>
                            <option value="">Pilih Mata Pelajaran</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ (old('subject_id', $schedule->subject_id) == $subject->id) ? 'selected' : '' }}>
                                    {{ $subject->name }} ({{ $subject->code }})
                                </option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="teacher_id" class="form-label">Guru Pengajar</label>
                        <select name="teacher_id" id="teacher_id" class="form-select @error('teacher_id') is-invalid @enderror">
                            <option value="">Pilih Guru Pengajar</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ (old('teacher_id', $schedule->teacher_id) == $teacher->id) ? 'selected' : '' }}>
                                    {{ $teacher->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('teacher_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="class_level" class="form-label">Kelas <span class="text-danger">*</span></label>
                        <select name="class_level" id="class_level" class="form-select @error('class_level') is-invalid @enderror" required>
                            <option value="">Pilih Kelas</option>
                            <option value="1" {{ (old('class_level', $schedule->class_level) == '1') ? 'selected' : '' }}>Kelas 1</option>
                            <option value="2" {{ (old('class_level', $schedule->class_level) == '2') ? 'selected' : '' }}>Kelas 2</option>
                            <option value="3" {{ (old('class_level', $schedule->class_level) == '3') ? 'selected' : '' }}>Kelas 3</option>
                            <option value="4" {{ (old('class_level', $schedule->class_level) == '4') ? 'selected' : '' }}>Kelas 4</option>
                            <option value="5" {{ (old('class_level', $schedule->class_level) == '5') ? 'selected' : '' }}>Kelas 5</option>
                            <option value="6" {{ (old('class_level', $schedule->class_level) == '6') ? 'selected' : '' }}>Kelas 6</option>
                        </select>
                        @error('class_level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="day_of_week" class="form-label">Hari <span class="text-danger">*</span></label>
                        <select name="day_of_week" id="day_of_week" class="form-select @error('day_of_week') is-invalid @enderror" required>
                            <option value="">Pilih Hari</option>
                            @foreach($daysOfWeek as $day)
                                <option value="{{ $day }}" {{ (old('day_of_week', $schedule->day_of_week) == $day) ? 'selected' : '' }}>{{ $day }}</option>
                            @endforeach
                        </select>
                        @error('day_of_week')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="start_time" class="form-label">Waktu Mulai <span class="text-danger">*</span></label>
                        <input type="time" name="start_time" id="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time', $schedule->start_time ? $schedule->start_time->format('H:i') : '') }}" required>
                        @error('start_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="end_time" class="form-label">Waktu Selesai <span class="text-danger">*</span></label>
                        <input type="time" name="end_time" id="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time', $schedule->end_time ? $schedule->end_time->format('H:i') : '') }}" required>
                        @error('end_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="room" class="form-label">Ruangan</label>
                        <input type="text" name="room" id="room" class="form-control @error('room') is-invalid @enderror" value="{{ old('room', $schedule->room) }}" placeholder="Contoh: Ruang 1A">
                        @error('room')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="active" {{ (old('status', $schedule->status) == 'active') ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ (old('status', $schedule->status) == 'inactive') ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="academic_year" class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                        <input type="text" name="academic_year" id="academic_year" class="form-control @error('academic_year') is-invalid @enderror" value="{{ old('academic_year', $schedule->academic_year) }}" placeholder="Contoh: 2023/2024" required>
                        @error('academic_year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                        <select name="semester" id="semester" class="form-select @error('semester') is-invalid @enderror" required>
                            <option value="Ganjil" {{ (old('semester', $schedule->semester) == 'Ganjil') ? 'selected' : '' }}>Ganjil</option>
                            <option value="Genap" {{ (old('semester', $schedule->semester) == 'Genap') ? 'selected' : '' }}>Genap</option>
                        </select>
                        @error('semester')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="notes" class="form-label">Catatan</label>
                    <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $schedule->notes) }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection 