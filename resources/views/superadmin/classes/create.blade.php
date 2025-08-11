@extends('layouts.superadmin')

@section('title', 'Tambah Kelas - Super Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1 fw-bold">
                                <i class="fas fa-plus text-success me-2"></i>
                                Tambah Kelas Baru
                            </h5>
                            <p class="text-muted small mb-0">Buat kelas baru untuk tahun ajaran</p>
                        </div>
                        <a href="{{ route('superadmin.classes.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('superadmin.classes.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border-0 bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title fw-bold mb-3">
                                            <i class="fas fa-info-circle text-primary me-2"></i>
                                            Informasi Dasar Kelas
                                        </h6>
                                        
                                        <div class="mb-3">
                                            <label for="grade_level" class="form-label fw-bold">Tingkat Kelas <span class="text-danger">*</span></label>
                                            <select class="form-select @error('grade_level') is-invalid @enderror" 
                                                    id="grade_level" name="grade_level" required>
                                                <option value="">Pilih Tingkat Kelas</option>
                                                @for($i = 1; $i <= 6; $i++)
                                                    <option value="{{ $i }}" {{ old('grade_level') == $i ? 'selected' : '' }}>
                                                        Kelas {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                            @error('grade_level')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="section" class="form-label fw-bold">Bagian Kelas <span class="text-danger">*</span></label>
                                            <select class="form-select @error('section') is-invalid @enderror" 
                                                    id="section" name="section" required>
                                                <option value="">Pilih Bagian</option>
                                                <option value="A" {{ old('section') == 'A' ? 'selected' : '' }}>A</option>
                                                <option value="B" {{ old('section') == 'B' ? 'selected' : '' }}>B</option>
                                            </select>
                                            @error('section')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Contoh: A atau B untuk membentuk kelas 1A, 1B, dst.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="capacity" class="form-label fw-bold">Kapasitas Maksimal <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('capacity') is-invalid @enderror" 
                                                   id="capacity" name="capacity" value="{{ old('capacity', 30) }}" 
                                                   min="1" max="50" required>
                                            @error('capacity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Jumlah maksimal siswa yang dapat diterima di kelas ini</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="academic_year" class="form-label fw-bold">Tahun Ajaran <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('academic_year') is-invalid @enderror" 
                                                   id="academic_year" name="academic_year" value="{{ old('academic_year', '2025/2026') }}" 
                                                   placeholder="2025/2026" required>
                                            @error('academic_year')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Format: YYYY/YYYY (contoh: 2025/2026)</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card border-0 bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title fw-bold mb-3">
                                            <i class="fas fa-user-tie text-warning me-2"></i>
                                            Informasi Tambahan
                                        </h6>

                                        <div class="mb-3">
                                            <label for="homeroom_teacher" class="form-label fw-bold">Wali Kelas</label>
                                            <select class="form-select @error('homeroom_teacher') is-invalid @enderror" 
                                                    id="homeroom_teacher" name="homeroom_teacher">
                                                <option value="">Pilih Wali Kelas (Opsional)</option>
                                                @foreach($teachers as $name => $displayName)
                                                    <option value="{{ $name }}" {{ old('homeroom_teacher') == $name ? 'selected' : '' }}>
                                                        {{ $displayName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('homeroom_teacher')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Guru yang bertanggung jawab sebagai wali kelas</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="status" class="form-label fw-bold">Status Kelas <span class="text-danger">*</span></label>
                                            <select class="form-select @error('status') is-invalid @enderror" 
                                                    id="status" name="status" required>
                                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                                                    Aktif
                                                </option>
                                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                                    Tidak Aktif
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label fw-bold">Deskripsi</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                                      id="description" name="description" rows="4" 
                                                      placeholder="Deskripsi atau catatan khusus untuk kelas ini...">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Informasi tambahan tentang kelas (opsional)</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Preview Section -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white">
                                        <h6 class="mb-0">
                                            <i class="fas fa-eye me-2"></i>
                                            Preview Kelas
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Nama Kelas:</strong> <span id="preview-name">-</span></p>
                                                <p><strong>Kapasitas:</strong> <span id="preview-capacity">-</span> siswa</p>
                                                <p><strong>Tahun Ajaran:</strong> <span id="preview-year">-</span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Wali Kelas:</strong> <span id="preview-teacher">-</span></p>
                                                <p><strong>Status:</strong> <span id="preview-status">-</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row mt-4">
                            <div class="col-12 text-end">
                                <a href="{{ route('superadmin.classes.index') }}" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-times me-1"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i>Simpan Kelas
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Live preview functionality
    function updatePreview() {
        const gradeLevel = document.getElementById('grade_level').value;
        const section = document.getElementById('section').value;
        const capacity = document.getElementById('capacity').value;
        const teacher = document.getElementById('homeroom_teacher').selectedOptions[0]?.text || '-';
        const year = document.getElementById('academic_year').value;
        const status = document.getElementById('status').selectedOptions[0]?.text || '-';

        document.getElementById('preview-name').textContent = gradeLevel && section ? gradeLevel + section : '-';
        document.getElementById('preview-capacity').textContent = capacity || '-';
        document.getElementById('preview-teacher').textContent = teacher === 'Pilih Wali Kelas (Opsional)' ? '-' : teacher;
        document.getElementById('preview-year').textContent = year || '-';
        document.getElementById('preview-status').textContent = status;
    }

    // Add event listeners
    document.getElementById('grade_level').addEventListener('change', updatePreview);
    document.getElementById('section').addEventListener('change', updatePreview);
    document.getElementById('capacity').addEventListener('input', updatePreview);
    document.getElementById('homeroom_teacher').addEventListener('change', updatePreview);
    document.getElementById('academic_year').addEventListener('input', updatePreview);
    document.getElementById('status').addEventListener('change', updatePreview);

    // Initial preview update
    updatePreview();
</script>
@endsection
