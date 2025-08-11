@extends('layouts.superadmin')

@section('title', 'Tambah Siswa - Super Admin')

@section('content')
    <div class="position-relative">
        <h1 class="welcome-header">Tambah Siswa Baru</h1>
        <div class="notification-icon">
            <i class="fa-regular fa-bell">🔔</i>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Form Tambah Siswa</span>
            <a href="{{ route('superadmin.students.index') }}" class="btn btn-sm btn-secondary">
                Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('superadmin.students.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nis" class="form-label">NIS</label>
                        <input type="text" class="form-control @error('nis') is-invalid @enderror" id="nis" name="nis" value="{{ old('nis') }}">
                        @error('nis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="class_level" class="form-label">Kelas <span class="text-danger">*</span></label>
                        <select class="form-select @error('class_level') is-invalid @enderror" id="class_level" name="class_level" required>
                            <option value="">Pilih Kelas</option>
                            <option value="1A" {{ old('class_level') == '1A' ? 'selected' : '' }}>Kelas 1A</option>
                            <option value="1B" {{ old('class_level') == '1B' ? 'selected' : '' }}>Kelas 1B</option>
                            <option value="2A" {{ old('class_level') == '2A' ? 'selected' : '' }}>Kelas 2A</option>
                            <option value="2B" {{ old('class_level') == '2B' ? 'selected' : '' }}>Kelas 2B</option>
                            <option value="3A" {{ old('class_level') == '3A' ? 'selected' : '' }}>Kelas 3A</option>
                            <option value="3B" {{ old('class_level') == '3B' ? 'selected' : '' }}>Kelas 3B</option>
                            <option value="4A" {{ old('class_level') == '4A' ? 'selected' : '' }}>Kelas 4A</option>
                            <option value="4B" {{ old('class_level') == '4B' ? 'selected' : '' }}>Kelas 4B</option>
                            <option value="5A" {{ old('class_level') == '5A' ? 'selected' : '' }}>Kelas 5A</option>
                            <option value="5B" {{ old('class_level') == '5B' ? 'selected' : '' }}>Kelas 5B</option>
                            <option value="6A" {{ old('class_level') == '6A' ? 'selected' : '' }}>Kelas 6A</option>
                            <option value="6B" {{ old('class_level') == '6B' ? 'selected' : '' }}>Kelas 6B</option>
                        </select>
                        @error('class_level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="gender" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="birth_date" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                        @error('birth_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="academic_year" class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                    <input type="text" name="academic_year" id="academic_year" class="form-control @error('academic_year') is-invalid @enderror" value="{{ old('academic_year', date('Y').'/'.date('Y')+1) }}" placeholder="Contoh: 2025/2026" required>
                    @error('academic_year')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <button type="reset" class="btn btn-secondary me-2">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection