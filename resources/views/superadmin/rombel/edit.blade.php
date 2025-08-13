@extends('layouts.superadmin')

@section('title', 'Edit Rombel')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Edit Rombel {{ $class->name }}</h1>
            <p class="text-muted">Ubah pengaturan rombel untuk tahun ajaran {{ $class->academic_year }}</p>
        </div>
        <div>
            <a href="{{ route('superadmin.rombel.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Form Edit -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-edit"></i> Form Edit Rombel</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('superadmin.rombel.update', $class) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Nama Kelas -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name', $class->name) }}"
                                           placeholder="Contoh: 1A, 2B, 3C"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Format: [Tingkat][Huruf] (contoh: 1A, 2B)</small>
                                </div>
                            </div>

                            <!-- Kapasitas -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="capacity" class="form-label">Kapasitas Siswa <span class="text-danger">*</span></label>
                                    <input type="number"
                                           class="form-control @error('capacity') is-invalid @enderror"
                                           id="capacity"
                                           name="capacity"
                                           value="{{ old('capacity', $class->capacity) }}"
                                           min="10"
                                           max="50"
                                           required>
                                    @error('capacity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Minimal 10, maksimal 50 siswa</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Wali Kelas -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="homeroom_teacher" class="form-label">Wali Kelas</label>
                                    <input type="text"
                                           class="form-control @error('homeroom_teacher') is-invalid @enderror"
                                           id="homeroom_teacher"
                                           name="homeroom_teacher"
                                           value="{{ old('homeroom_teacher', $class->homeroom_teacher) }}"
                                           placeholder="Nama wali kelas">
                                    @error('homeroom_teacher')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Opsional - nama guru wali kelas</small>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror"
                                            id="status"
                                            name="status"
                                            required>
                                        <option value="">Pilih Status</option>
                                        <option value="active" {{ old('status', $class->status) == 'active' ? 'selected' : '' }}>
                                            Aktif
                                        </option>
                                        <option value="inactive" {{ old('status', $class->status) == 'inactive' ? 'selected' : '' }}>
                                            Tidak Aktif
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="3"
                                      placeholder="Deskripsi tambahan untuk kelas ini (opsional)">{{ old('description', $class->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Info Siswa -->
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle"></i> Informasi Siswa</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Siswa Saat Ini:</strong> {{ $class->current_students }} siswa
                                </div>
                                <div class="col-md-4">
                                    <strong>Kapasitas Saat Ini:</strong> {{ $class->capacity }} siswa
                                </div>
                                <div class="col-md-4">
                                    <strong>Sisa Slot:</strong> {{ $class->capacity - $class->current_students }} siswa
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('superadmin.rombel.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-format nama kelas
    const nameInput = document.getElementById('name');
    nameInput.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });

    // Validasi kapasitas vs siswa saat ini
    const capacityInput = document.getElementById('capacity');
    const currentStudents = {{ $class->current_students }};

    capacityInput.addEventListener('input', function() {
        const newCapacity = parseInt(this.value);
        if (newCapacity < currentStudents) {
            this.setCustomValidity(`Kapasitas tidak boleh kurang dari jumlah siswa saat ini (${currentStudents})`);
        } else {
            this.setCustomValidity('');
        }
    });
});
</script>
@endpush
