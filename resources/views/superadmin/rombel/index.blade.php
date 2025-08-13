@extends('layouts.superadmin')

@section('title', 'Manajemen Rombel')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Manajemen Rombongan Belajar (Rombel)</h1>
            <p class="text-muted">Kelola rombel dan promosi siswa untuk tahun ajaran {{ $currentAcademicYear }}</p>
        </div>
        <div>
            <a href="{{ route('superadmin.rombel.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Buat Rombel Baru
            </a>
            <a href="{{ route('superadmin.rombel.promotion') }}" class="btn btn-success">
                <i class="fas fa-arrow-up"></i> Promosi Siswa
            </a>
        </div>
    </div>

    <!-- Academic Year Selector -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row align-items-end">
                <div class="col-md-4">
                    <label for="academic_year" class="form-label">Tahun Ajaran</label>
                    <select name="academic_year" id="academic_year" class="form-select" onchange="this.form.submit()">
                        @foreach($academicYears as $year)
                            <option value="{{ $year }}" {{ request('academic_year', $currentAcademicYear) == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        @for($grade = 1; $grade <= 6; $grade++)
            <div class="col-md-2">
                <div class="card border-left-primary">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Kelas {{ $grade }}
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $studentStats[$grade]['total'] ?? 0 }}
                                </div>
                                @if(($studentStats[$grade]['repeating'] ?? 0) > 0)
                                    <div class="text-xs text-warning">
                                        {{ $studentStats[$grade]['repeating'] }} mengulang
                                    </div>
                                @endif
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>



    <!-- Classes by Grade -->
    @for($grade = 1; $grade <= 6; $grade++)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-school"></i> Kelas {{ $grade }}
                    @if(isset($classesByGrade[$grade]))
                        <span class="badge badge-primary">{{ $classesByGrade[$grade]->count() }} Rombel</span>
                    @endif
                </h5>
                <div>
                    <a href="{{ route('superadmin.rombel.create') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-plus"></i> Tambah Rombel
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(isset($classesByGrade[$grade]) && $classesByGrade[$grade]->count() > 0)
                    <div class="row">
                        @foreach($classesByGrade[$grade] as $class)
                            <div class="col-md-4 mb-3">
                                <div class="card border-left-{{ $class->status == 'active' ? 'success' : 'secondary' }}">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="card-title mb-0">{{ $class->name }}</h6>
                                            <span class="badge badge-{{ $class->status == 'active' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($class->status) }}
                                            </span>
                                        </div>

                                        <div class="row text-sm">
                                            <div class="col-6">
                                                <strong>Kapasitas:</strong><br>
                                                {{ $class->current_students }}/{{ $class->capacity }}
                                            </div>
                                            <div class="col-6">
                                                <strong>Wali Kelas:</strong><br>
                                                {{ $class->homeroom_teacher ?? 'Belum ditentukan' }}
                                            </div>
                                        </div>

                                        <!-- Progress Bar -->
                                        <div class="mt-2">
                                            @php
                                                $percentage = $class->capacity > 0 ? ($class->current_students / $class->capacity) * 100 : 0;
                                                $progressClass = $percentage >= 90 ? 'danger' : ($percentage >= 75 ? 'warning' : 'success');
                                            @endphp
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-{{ $progressClass }}"
                                                     style="width: {{ $percentage }}%"></div>
                                            </div>
                                            <small class="text-muted">{{ number_format($percentage, 1) }}% terisi</small>
                                        </div>

                                        <div class="mt-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    <i class="fas fa-info-circle"></i>
                                                    {{ $class->description ?? 'Kelas ' . $class->name }}
                                                </small>
                                                <div>
                                                    <a href="{{ route('superadmin.rombel.show', $class->id) }}"
                                                       class="btn btn-sm btn-outline-info"
                                                       title="Detail Rombel">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('superadmin.rombel.edit', $class->id) }}"
                                                       class="btn btn-sm btn-outline-warning"
                                                       title="Edit Rombel">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-danger"
                                                            onclick="confirmDelete({{ $class->id }}, '{{ $class->name }}')"
                                                            title="Hapus Rombel">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-school fa-3x text-gray-300 mb-3"></i>
                        <p class="text-muted">Belum ada rombel untuk kelas {{ $grade }}</p>
                        <a href="{{ route('superadmin.rombel.create') }}"
                           class="btn btn-primary">
                            <i class="fas fa-plus"></i> Buat Rombel Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endfor

    <!-- Summary Card -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Ringkasan Rombel</h5>
        </div>
        <div class="card-body">
            @php
                $totalClasses = 0;
                $totalStudents = 0;
                $totalCapacity = 0;
                foreach($classesByGrade as $grade => $classes) {
                    $totalClasses += $classes->count();
                    foreach($classes as $class) {
                        $totalStudents += $class->current_students;
                        $totalCapacity += $class->capacity;
                    }
                }
                $occupancyRate = $totalCapacity > 0 ? ($totalStudents / $totalCapacity) * 100 : 0;
            @endphp

            <div class="row text-center">
                <div class="col-md-3">
                    <div class="border-right">
                        <h3 class="text-primary">{{ $totalClasses }}</h3>
                        <p class="text-muted mb-0">Total Rombel</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border-right">
                        <h3 class="text-success">{{ $totalStudents }}</h3>
                        <p class="text-muted mb-0">Total Siswa</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border-right">
                        <h3 class="text-info">{{ $totalCapacity }}</h3>
                        <p class="text-muted mb-0">Total Kapasitas</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <h3 class="text-warning">{{ number_format($occupancyRate, 1) }}%</h3>
                    <p class="text-muted mb-0">Tingkat Hunian</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-secondary {
    border-left: 0.25rem solid #858796 !important;
}
.card-title {
    font-size: 1.1rem;
    font-weight: 600;
}
.text-sm {
    font-size: 0.875rem;
}
.border-right {
    border-right: 1px solid #e3e6f0;
}
</style>
@endpush

@push('scripts')
<script>
function confirmDelete(classId, className) {
    if (confirm(`Yakin ingin menghapus rombel ${className}?\n\nPerhatian: Semua data siswa di kelas ini akan terpengaruh!`)) {
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ url('/superadmin/rombel') }}/${classId}`;

        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        // Add method override
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);

        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush
@endsection
