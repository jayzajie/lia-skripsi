@extends('layouts.superadmin')

@section('title', 'Data Penilaian - Super Admin')

@section('content')
    <div class="position-relative">
        <h1 class="welcome-header">Data Penilaian</h1>
        <div class="notification-icon">
            <i class="fa-regular fa-bell">🔔</i>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header">
            <span>Daftar Penilaian</span>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Filter Penilaian</h5>
                <a href="{{ route('superadmin.evaluations.create') }}" class="btn btn-success">
                    <i class="fas fa-plus me-1"></i> Tambah Penilaian
                </a>
            </div>

            <form action="{{ route('superadmin.evaluations.index') }}" method="GET">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <select class="form-select" id="subject-filter" name="subject_id">
                            <option value="">Semua Mata Pelajaran</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="academic-year-filter" name="academic_year">
                            <option value="">Semua Tahun Ajaran</option>
                            @foreach($academicYears as $year)
                                <option value="{{ $year }}" {{ request('academic_year') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari nama siswa..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('superadmin.evaluations.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Semester</th>
                            <th>Tahun Ajaran</th>
                            <th>Nilai Akhir</th>
                            <th>Grade</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($evaluations as $index => $evaluation)
                        <tr>
                            <td>{{ $evaluations->firstItem() + $index }}</td>
                            <td>{{ $evaluation->student->name }}</td>
                            <td>{{ $evaluation->student->class_level }}</td>
                            <td>{{ $evaluation->subject->name }}</td>
                            <td>{{ $evaluation->semester }}</td>
                            <td>{{ $evaluation->academic_year }}</td>
                            <td class="text-center">
                                <strong>{{ $evaluation->final_score ?? 'Belum ada' }}</strong>
                            </td>
                            <td class="text-center">
                                @if($evaluation->grade)
                                    <span class="badge bg-{{
                                        $evaluation->grade == 'A' ? 'success' :
                                        ($evaluation->grade == 'B' ? 'primary' :
                                        ($evaluation->grade == 'C' ? 'warning' :
                                        ($evaluation->grade == 'D' ? 'danger' : 'danger')))
                                    }}">{{ $evaluation->grade }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('superadmin.evaluations.show', $evaluation) }}" class="btn btn-sm btn-info">Detail</a>
                                <a href="{{ route('superadmin.evaluations.edit', $evaluation) }}" class="btn btn-sm btn-warning">Edit</a>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteEvaluationModal"
                                    data-id="{{ $evaluation->id }}"
                                    data-name="Penilaian {{ $evaluation->student->name }} - {{ $evaluation->subject->name }}">Hapus</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data penilaian</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $evaluations->firstItem() ?? 0 }} hingga {{ $evaluations->lastItem() ?? 0 }} dari {{ $evaluations->total() ?? 0 }} data
                </div>
                <div>
                    {{ $evaluations->links('pagination::bootstrap-4') }}
                </div>
            </div>

            <div class="mt-5">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Generate Laporan Penilaian Siswa</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('superadmin.evaluations.studentReport') }}" method="GET" target="_blank">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="student_id" class="form-label">Pilih Siswa</label>
                                        <select name="student_id" id="student_id" class="form-select" required>
                                            <option value="">Pilih Siswa</option>
                                            @foreach($students as $student)
                                                <option value="{{ $student->id }}">{{ $student->name }} - {{ $student->nis }} (Kelas {{ $student->class_level }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="academic_year" class="form-label">Tahun Ajaran</label>
                                        <select name="academic_year" id="academic_year" class="form-select" required>
                                            <option value="">Pilih Tahun Ajaran</option>
                                            @foreach($academicYears as $year)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="semester" class="form-label">Semester</label>
                                        <select name="semester" id="semester" class="form-select" required>
                                            <option value="">Pilih Semester</option>
                                            <option value="Ganjil">Ganjil</option>
                                            <option value="Genap">Genap</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="ti ti-report me-1"></i> Generate
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Penilaian -->
    <div class="modal fade" id="deleteEvaluationModal" tabindex="-1" aria-labelledby="deleteEvaluationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteEvaluationModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus penilaian <strong id="delete-evaluation-name"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteEvaluationForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Delete Evaluation Modal
    document.querySelectorAll('[data-bs-target="#deleteEvaluationModal"]').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');

            document.getElementById('delete-evaluation-name').textContent = name;

            const form = document.getElementById('deleteEvaluationForm');
            form.action = `{{ url('superadmin/evaluations') }}/${id}`;
        });
    });
</script>
@endsection
