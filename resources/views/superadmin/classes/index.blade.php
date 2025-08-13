@extends('layouts.superadmin')

@section('title', 'Data Kelas')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Data Kelas</h1>
            <p class="text-muted">Informasi kelas dan kapasitas siswa untuk tahun ajaran {{ $currentAcademicYear }}</p>
        </div>
        <div>
            <a href="{{ route('superadmin.rombel.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Kelas Baru
            </a>
        </div>
    </div>

    <!-- Academic Year Filter -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <label for="academicYear" class="form-label">Tahun Ajaran</label>
                    <select class="form-select" id="academicYear" onchange="filterByYear(this.value)">
                        @foreach($academicYears as $year)
                            <option value="{{ $year }}" {{ $year == $currentAcademicYear ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                @foreach($studentStats as $stat)
                <div class="col-md-3">
                    <div class="card border-left-{{ $stat['color'] }}">
                        <div class="card-body">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">{{ $stat['label'] }}</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $stat['count'] }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Classes by Grade -->
    @foreach(range(1, 6) as $grade)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-school"></i> Kelas {{ $grade }}
                    @if(isset($classesByGrade[$grade]))
                        <span class="badge badge-primary">{{ $classesByGrade[$grade]->count() }} Kelas</span>
                    @endif
                </h5>
            </div>
            <div class="card-body">
                @if(isset($classesByGrade[$grade]) && $classesByGrade[$grade]->count() > 0)
                    <div class="row">
                        @foreach($classesByGrade[$grade] as $class)
                            <div class="col-md-4 mb-3">
                                <div class="card border-left-{{ $class->status === 'active' ? 'success' : 'secondary' }}">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0 font-weight-bold">{{ $class->name }}</h6>
                                            <span class="badge badge-{{ $class->status === 'active' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($class->status) }}
                                            </span>
                                        </div>

                                        <div class="row text-center">
                                            <div class="col-6">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Kapasitas</div>
                                                <div class="h6 mb-0">{{ $class->current_students }}/{{ $class->capacity }}</div>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Wali Kelas</div>
                                                <div class="small">
                                                    {{ $class->teacher ? $class->teacher->name : 'Belum ditentukan' }}
                                                </div>
                                            </div>
                                        </div>

                                        @if($class->current_students > 0)
                                            <div class="progress mt-2" style="height: 6px;">
                                                <div class="progress-bar bg-{{ $class->current_students >= $class->capacity ? 'danger' : 'success' }}"
                                                     style="width: {{ ($class->current_students / $class->capacity) * 100 }}%"></div>
                                            </div>
                                        @endif

                                        <div class="mt-2">
                                            <small class="text-muted">
                                                Kelas {{ $grade }}{{ substr($class->name, -1) }} - Kurikulum {{ $class->curriculum ?? 'Merdeka' }}
                                            </small>
                                        </div>

                                        <div class="mt-2">
                                            <a href="{{ route('superadmin.rombel.show', $class) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            <a href="{{ route('superadmin.rombel.edit', $class) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-school fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada kelas {{ $grade }} untuk tahun ajaran {{ $currentAcademicYear }}</p>
                        <a href="{{ route('superadmin.rombel.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-plus"></i> Tambah Kelas {{ $grade }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>

<script>
function filterByYear(year) {
    window.location.href = "{{ route('superadmin.classes.index') }}?year=" + year;
}
</script>
@endsection
