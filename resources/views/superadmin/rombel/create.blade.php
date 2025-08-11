@extends('layouts.superadmin')

@section('title', 'Buat Rombel Baru')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Buat Rombongan Belajar Baru</h1>
            <p class="text-muted">Buat rombel untuk semua tingkat kelas (1-6) sekaligus</p>
        </div>
        <a href="{{ route('superadmin.rombel.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('superadmin.rombel.store') }}" method="POST">
        @csrf
        
        <!-- Basic Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Dasar</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="academic_year" class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('academic_year') is-invalid @enderror" 
                                   id="academic_year" 
                                   name="academic_year" 
                                   value="{{ old('academic_year', $nextAcademicYear) }}" 
                                   placeholder="2025/2026"
                                   required>
                            @error('academic_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="curriculum" class="form-label">Kurikulum <span class="text-danger">*</span></label>
                            <select class="form-select @error('curriculum') is-invalid @enderror" 
                                    id="curriculum" 
                                    name="curriculum" 
                                    required>
                                <option value="">Pilih Kurikulum</option>
                                <option value="Kurikulum Merdeka" {{ old('curriculum') == 'Kurikulum Merdeka' ? 'selected' : '' }}>
                                    Kurikulum Merdeka
                                </option>
                                <option value="Kurikulum 2013" {{ old('curriculum') == 'Kurikulum 2013' ? 'selected' : '' }}>
                                    Kurikulum 2013
                                </option>
                                <option value="KTSP" {{ old('curriculum') == 'KTSP' ? 'selected' : '' }}>
                                    KTSP
                                </option>
                            </select>
                            @error('curriculum')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="capacity_per_class" class="form-label">Kapasitas per Kelas <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('capacity_per_class') is-invalid @enderror" 
                                   id="capacity_per_class" 
                                   name="capacity_per_class" 
                                   value="{{ old('capacity_per_class', 30) }}" 
                                   min="20" 
                                   max="40"
                                   required>
                            @error('capacity_per_class')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Class Configuration -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-cogs"></i> Konfigurasi Kelas</h5>
                <small class="text-muted">Tentukan jumlah rombel untuk setiap tingkat kelas</small>
            </div>
            <div class="card-body">
                <div class="row">
                    @for($grade = 1; $grade <= 6; $grade++)
                        <div class="col-md-2 mb-3">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white text-center py-2">
                                    <strong>Kelas {{ $grade }}</strong>
                                </div>
                                <div class="card-body p-3">
                                    <label for="classes_per_grade_{{ $grade }}" class="form-label small">
                                        Jumlah Rombel
                                    </label>
                                    <select class="form-select form-select-sm @error('classes_per_grade.' . $grade) is-invalid @enderror" 
                                            id="classes_per_grade_{{ $grade }}" 
                                            name="classes_per_grade[{{ $grade }}]" 
                                            required>
                                        @for($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}" 
                                                {{ old('classes_per_grade.' . $grade, 2) == $i ? 'selected' : '' }}>
                                                {{ $i }} Rombel
                                            </option>
                                        @endfor
                                    </select>
                                    @error('classes_per_grade.' . $grade)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    <!-- Preview -->
                                    <div class="mt-2">
                                        <small class="text-muted">Preview:</small>
                                        <div id="preview_{{ $grade }}" class="small text-info">
                                            <!-- Will be populated by JavaScript -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Ringkasan</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center">
                            <div class="h4 text-primary" id="total_classes">0</div>
                            <div class="text-muted">Total Rombel</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <div class="h4 text-success" id="total_capacity">0</div>
                            <div class="text-muted">Total Kapasitas</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted">
                            <strong>Rombel yang akan dibuat:</strong>
                            <div id="class_list" class="mt-2">
                                <!-- Will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('superadmin.rombel.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Buat Rombel
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sections = ['A', 'B', 'C', 'D', 'E'];
    
    function updatePreview() {
        let totalClasses = 0;
        let totalCapacity = 0;
        const capacity = parseInt(document.getElementById('capacity_per_class').value) || 30;
        let classList = [];
        
        for (let grade = 1; grade <= 6; grade++) {
            const select = document.getElementById(`classes_per_grade_${grade}`);
            const classCount = parseInt(select.value) || 0;
            const preview = document.getElementById(`preview_${grade}`);
            
            totalClasses += classCount;
            totalCapacity += classCount * capacity;
            
            // Update preview for this grade
            let previewText = '';
            for (let i = 0; i < classCount; i++) {
                previewText += `${grade}${sections[i]} `;
                classList.push(`${grade}${sections[i]}`);
            }
            preview.textContent = previewText.trim();
        }
        
        // Update summary
        document.getElementById('total_classes').textContent = totalClasses;
        document.getElementById('total_capacity').textContent = totalCapacity;
        
        // Update class list
        const classListDiv = document.getElementById('class_list');
        if (classList.length > 0) {
            classListDiv.innerHTML = classList.map(cls => 
                `<span class="badge badge-primary me-1">${cls}</span>`
            ).join('');
        } else {
            classListDiv.textContent = 'Belum ada kelas yang dipilih';
        }
    }
    
    // Add event listeners
    document.getElementById('capacity_per_class').addEventListener('input', updatePreview);
    
    for (let grade = 1; grade <= 6; grade++) {
        document.getElementById(`classes_per_grade_${grade}`).addEventListener('change', updatePreview);
    }
    
    // Initial update
    updatePreview();
});
</script>
@endpush

@push('styles')
<style>
.card-header.bg-primary {
    background-color: #4e73df !important;
}
.badge {
    margin-right: 0.25rem;
    margin-bottom: 0.25rem;
}
</style>
@endpush
@endsection
