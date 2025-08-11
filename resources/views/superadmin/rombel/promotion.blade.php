@extends('layouts.superadmin')

@section('title', 'Promosi Siswa')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Promosi Siswa</h1>
            <p class="text-muted">Kelola perpindahan siswa dari {{ $currentAcademicYear }} ke {{ $nextAcademicYear }}</p>
        </div>
        <a href="{{ route('superadmin.rombel.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Auto Promotion Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-magic"></i> Promosi Otomatis</h5>
        </div>
        <div class="card-body">
            <p class="text-muted">Promosikan siswa secara otomatis berdasarkan tingkat kelas</p>

            <form action="{{ route('superadmin.rombel.auto-promotion') }}" method="POST" id="autoPromotionForm">
                @csrf
                <input type="hidden" name="current_academic_year" value="{{ $currentAcademicYear }}">
                <input type="hidden" name="next_academic_year" value="{{ $nextAcademicYear }}">

                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label">Pilih Tingkat Kelas untuk Promosi Otomatis:</label>
                        <div class="row">
                            @for($grade = 1; $grade <= 6; $grade++)
                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="grade_levels[]"
                                               value="{{ $grade }}"
                                               id="grade_{{ $grade }}">
                                        <label class="form-check-label" for="grade_{{ $grade }}">
                                            Kelas {{ $grade }}
                                            @if($grade == 6)
                                                <small class="text-info">(Lulus)</small>
                                            @else
                                                <small class="text-success">(→ Kelas {{ $grade + 1 }})</small>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-success" onclick="return confirmAutoPromotion()">
                                <i class="fas fa-magic"></i> Jalankan Promosi Otomatis
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Manual Promotion Section -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-users"></i> Promosi Manual</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('superadmin.rombel.process-promotion') }}" method="POST" id="manualPromotionForm">
                @csrf
                <input type="hidden" name="current_academic_year" value="{{ $currentAcademicYear }}">
                <input type="hidden" name="next_academic_year" value="{{ $nextAcademicYear }}">

                <!-- Tabs for each grade -->
                <ul class="nav nav-tabs" id="gradeTab" role="tablist">
                    @for($grade = 1; $grade <= 6; $grade++)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ $grade == 1 ? 'active' : '' }}"
                               id="grade{{ $grade }}-tab"
                               data-toggle="tab"
                               href="#grade{{ $grade }}"
                               role="tab"
                               aria-controls="grade{{ $grade }}"
                               aria-selected="{{ $grade == 1 ? 'true' : 'false' }}">
                                Kelas {{ $grade }}
                                @if(isset($studentsByGrade[$grade]))
                                    <span class="badge badge-primary ms-1">{{ $studentsByGrade[$grade]->count() }}</span>
                                @endif
                            </a>
                        </li>
                    @endfor
                </ul>

                <div class="tab-content" id="gradeTabContent">
                    @for($grade = 1; $grade <= 6; $grade++)
                        <div class="tab-pane fade {{ $grade == 1 ? 'show active' : '' }}"
                             id="grade{{ $grade }}"
                             role="tabpanel">

                            <div class="mt-3">
                                @if(isset($studentsByGrade[$grade]) && $studentsByGrade[$grade]->count() > 0)
                                    <!-- Bulk Actions -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <strong>{{ $studentsByGrade[$grade]->count() }} siswa</strong> di Kelas {{ $grade }}
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-sm btn-outline-success"
                                                    onclick="selectAllForGrade({{ $grade }}, 'promote')">
                                                <i class="fas fa-arrow-up"></i> Naik Semua
                                            </button>
                                            @if($grade < 6)
                                                <button type="button" class="btn btn-sm btn-outline-warning"
                                                        onclick="selectAllForGrade({{ $grade }}, 'repeat')">
                                                    <i class="fas fa-redo"></i> Ulang Semua
                                                </button>
                                            @endif
                                            @if($grade == 6)
                                                <button type="button" class="btn btn-sm btn-outline-info"
                                                        onclick="selectAllForGrade({{ $grade }}, 'graduate')">
                                                    <i class="fas fa-graduation-cap"></i> Lulus Semua
                                                </button>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Students Table -->
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Siswa</th>
                                                    <th>NIS</th>
                                                    <th>Kelas Saat Ini</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                    <th>Kelas Tujuan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($studentsByGrade[$grade] as $index => $student)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <strong>{{ $student->name }}</strong>
                                                            @if($student->is_repeating)
                                                                <span class="badge badge-warning">Mengulang</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $student->nis ?? '-' }}</td>
                                                        <td>{{ $student->class_level }}</td>
                                                        <td>
                                                            <span class="badge badge-{{ $student->status == 'active' ? 'success' : 'secondary' }}">
                                                                {{ ucfirst($student->status) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="promotions[{{ $student->id }}][student_id]" value="{{ $student->id }}">

                                                            <select name="promotions[{{ $student->id }}][action]"
                                                                    class="form-select form-select-sm action-select"
                                                                    data-student-id="{{ $student->id }}"
                                                                    data-grade="{{ $grade }}"
                                                                    onchange="handleActionChange(this)">
                                                                <option value="">Pilih Aksi</option>
                                                                @if($grade < 6)
                                                                    <option value="promote">Naik Kelas</option>
                                                                    <option value="repeat">Mengulang</option>
                                                                @endif
                                                                @if($grade == 6)
                                                                    <option value="promote">Naik Kelas</option>
                                                                    <option value="graduate">Lulus</option>
                                                                @endif
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="promotions[{{ $student->id }}][new_class]"
                                                                    class="form-select form-select-sm class-select"
                                                                    data-student-id="{{ $student->id }}"
                                                                    style="display: none;">
                                                                <option value="">Pilih Kelas</option>

                                                                <!-- Kelas untuk naik tingkat -->
                                                                @if($grade < 6 && isset($nextYearClasses[$grade + 1]))
                                                                    <optgroup label="Naik ke Kelas {{ $grade + 1 }}">
                                                                        @foreach($nextYearClasses[$grade + 1] as $class)
                                                                            <option value="{{ $class->name }}" data-action="promote">
                                                                                {{ $class->name }}
                                                                                ({{ $class->current_students }}/{{ $class->capacity }})
                                                                            </option>
                                                                        @endforeach
                                                                    </optgroup>
                                                                @endif

                                                                <!-- Kelas untuk mengulang -->
                                                                @if(isset($nextYearClasses[$grade]))
                                                                    <optgroup label="Mengulang Kelas {{ $grade }}">
                                                                        @foreach($nextYearClasses[$grade] as $class)
                                                                            <option value="{{ $class->name }}" data-action="repeat">
                                                                                {{ $class->name }} - Mengulang
                                                                                ({{ $class->current_students }}/{{ $class->capacity }})
                                                                            </option>
                                                                        @endforeach
                                                                    </optgroup>
                                                                @endif

                                                                <!-- Kelas 6 naik ke kelas 7 (jika ada SMP) -->
                                                                @if($grade == 6 && isset($nextYearClasses[7]))
                                                                    <optgroup label="Naik ke Kelas 7">
                                                                        @foreach($nextYearClasses[7] as $class)
                                                                            <option value="{{ $class->name }}" data-action="promote">
                                                                                {{ $class->name }}
                                                                                ({{ $class->current_students }}/{{ $class->capacity }})
                                                                            </option>
                                                                        @endforeach
                                                                    </optgroup>
                                                                @endif
                                                            </select>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                                        <p class="text-muted">Tidak ada siswa di Kelas {{ $grade }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endfor
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="text-muted">
                                <i class="fas fa-info-circle"></i>
                                Pastikan semua siswa telah dipilih aksinya sebelum menyimpan
                            </span>
                        </div>
                        <button type="submit" class="btn btn-primary" onclick="return confirmManualPromotion()">
                            <i class="fas fa-save"></i> Simpan Promosi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Promotion page loaded');

    // Initialize Bootstrap tabs if needed
    if (typeof bootstrap !== 'undefined') {
        var triggerTabList = [].slice.call(document.querySelectorAll('#gradeTab button'))
        triggerTabList.forEach(function (triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)
        });
    }
});

function handleActionChange(select) {
    console.log('Action changed:', select.value);

    const studentId = select.dataset.studentId;
    const grade = parseInt(select.dataset.grade);
    const action = select.value;
    const classSelect = document.querySelector(`select[name="promotions[${studentId}][new_class]"]`);

    console.log('Student ID:', studentId, 'Grade:', grade, 'Action:', action);

    if (action === 'promote' || action === 'repeat') {
        classSelect.style.display = 'block';
        classSelect.required = true;

        // Show/hide appropriate optgroups and options
        const optgroups = classSelect.querySelectorAll('optgroup');
        const options = classSelect.querySelectorAll('option[data-action]');

        // Reset all options
        optgroups.forEach(optgroup => {
            optgroup.style.display = 'none';
        });

        options.forEach(option => {
            option.style.display = 'none';
        });

        // Show relevant options based on action
        if (action === 'promote') {
            // Show promote options
            options.forEach(option => {
                if (option.dataset.action === 'promote') {
                    option.style.display = 'block';
                    option.parentElement.style.display = 'block';
                }
            });
        } else if (action === 'repeat') {
            // Show repeat options
            options.forEach(option => {
                if (option.dataset.action === 'repeat') {
                    option.style.display = 'block';
                    option.parentElement.style.display = 'block';
                }
            });
        }

        // Reset selection
        classSelect.value = '';
    } else if (action === 'graduate') {
        classSelect.style.display = 'none';
        classSelect.required = false;
        classSelect.value = '';
    } else {
        classSelect.style.display = 'none';
        classSelect.required = false;
        classSelect.value = '';
    }
}

function selectAllForGrade(grade, action) {
    const selects = document.querySelectorAll(`select[data-grade="${grade}"].action-select`);
    selects.forEach(select => {
        select.value = action;
        handleActionChange(select);
    });
}

function confirmAutoPromotion() {
    const checkedBoxes = document.querySelectorAll('input[name="grade_levels[]"]:checked');
    if (checkedBoxes.length === 0) {
        alert('Pilih minimal satu tingkat kelas untuk promosi otomatis');
        return false;
    }

    const grades = Array.from(checkedBoxes).map(cb => cb.value).join(', ');
    return confirm(`Yakin ingin menjalankan promosi otomatis untuk Kelas ${grades}?\n\nProses ini akan memindahkan semua siswa yang memenuhi syarat ke kelas berikutnya.`);
}

function confirmManualPromotion() {
    const actionSelects = document.querySelectorAll('.action-select');
    let selectedCount = 0;

    actionSelects.forEach(select => {
        if (select.value !== '') selectedCount++;
    });

    if (selectedCount === 0) {
        alert('Pilih minimal satu siswa untuk diproses');
        return false;
    }

    return confirm(`Yakin ingin memproses promosi untuk ${selectedCount} siswa?`);
}
</script>
@endpush

@push('styles')
<style>
.nav-tabs .nav-link {
    color: #495057;
}
.nav-tabs .nav-link.active {
    color: #4e73df;
    border-color: #4e73df #4e73df #fff;
}
.badge {
    font-size: 0.75em;
}
</style>
@endpush
@endsection
