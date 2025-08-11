@extends('layouts.superadmin')

@section('title', 'Tambah Mata Pelajaran - Super Admin')

@section('content')
    <div class="position-relative">
        <h1 class="welcome-header">Tambah Mata Pelajaran</h1>
        <div class="notification-icon">
            <i class="fa-regular fa-bell">🔔</i>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Form Tambah Mata Pelajaran</span>
            <a href="{{ route('superadmin.subjects.index') }}" class="btn btn-sm btn-secondary">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('superadmin.subjects.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nama Mata Pelajaran <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="code" class="form-label">Kode Mata Pelajaran</label>
                        <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}">
                        <small class="text-muted">Contoh: MTK-5 untuk Matematika Kelas 5</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="class_level" class="form-label">Kelas</label>
                        <select class="form-select" id="class_level" name="class_level">
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
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="credit_hours" class="form-label">Jam Kredit</label>
                        <input type="number" class="form-control" id="credit_hours" name="credit_hours" value="{{ old('credit_hours') }}" min="0">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="teacher_id" class="form-label">Guru Pengajar</label>
                        <select class="form-select" id="teacher_id" name="teacher_id">
                            <option value="">Pilih Guru</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="reset" class="btn btn-secondary me-2">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection