@extends('layouts.superadmin')

@section('title', 'Tambah Data Penilaian - Super Admin')

@section('content')
    <div class="position-relative">
        <h1 class="welcome-header">Tambah Data Penilaian</h1>
    </div>

    <div class="dashboard-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Form Tambah Data Penilaian</span>
            <a href="{{ route('superadmin.evaluations.index') }}" class="btn btn-sm btn-secondary">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('superadmin.evaluations.store') }}" method="POST">
                @csrf
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="student_id" class="form-label">Siswa <span class="text-danger">*</span></label>
                        <select name="student_id" id="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
                            <option value="">Pilih Siswa</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }} - {{ $student->nis }} (Kelas {{ $student->class_level }})
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="subject_id" class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                        <select name="subject_id" id="subject_id" class="form-select @error('subject_id') is-invalid @enderror" required>
                            <option value="">Pilih Mata Pelajaran</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }} - {{ $subject->code }} (Kelas {{ $subject->class_level }})
                                </option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="academic_year" class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                        <input type="text" name="academic_year" id="academic_year" class="form-control @error('academic_year') is-invalid @enderror" value="{{ old('academic_year', date('Y').'/'.date('Y')+1) }}" placeholder="Contoh: 2023/2024" required>
                        @error('academic_year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                        <select name="semester" id="semester" class="form-select @error('semester') is-invalid @enderror" required>
                            <option value="">Pilih Semester</option>
                            <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                        @error('semester')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="assessment_score" class="form-label">Nilai Tugas (30%)</label>
                        <input type="number" name="assessment_score" id="assessment_score" class="form-control @error('assessment_score') is-invalid @enderror" value="{{ old('assessment_score') }}" min="0" max="100" step="0.01">
                        @error('assessment_score')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="mid_exam_score" class="form-label">Nilai UTS (30%)</label>
                        <input type="number" name="mid_exam_score" id="mid_exam_score" class="form-control @error('mid_exam_score') is-invalid @enderror" value="{{ old('mid_exam_score') }}" min="0" max="100" step="0.01">
                        @error('mid_exam_score')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="final_exam_score" class="form-label">Nilai UAS (40%)</label>
                        <input type="number" name="final_exam_score" id="final_exam_score" class="form-control @error('final_exam_score') is-invalid @enderror" value="{{ old('final_exam_score') }}" min="0" max="100" step="0.01">
                        @error('final_exam_score')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="teacher_notes" class="form-label">Catatan Guru</label>
                    <textarea name="teacher_notes" id="teacher_notes" class="form-control @error('teacher_notes') is-invalid @enderror" rows="3">{{ old('teacher_notes') }}</textarea>
                    @error('teacher_notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="alert alert-info">
                    <small>
                        <i class="ti ti-info-circle me-1"></i>
                        Nilai akhir dan grade akan dihitung otomatis saat semua komponen nilai diisi. Jika komponen nilai tidak diisi, nilai akhir dan grade tidak akan dihitung.
                    </small>
                </div>
                
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy me-1"></i> Simpan Penilaian
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection 