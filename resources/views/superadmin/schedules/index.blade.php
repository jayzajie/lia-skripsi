@extends('layouts.superadmin')

@section('title', 'Jadwal Pembelajaran - Super Admin')

@section('content')
    <div class="position-relative">
        <h1 class="welcome-header">Jadwal Pembelajaran</h1>
        <div class="notification-icon">
            <i class="fa-regular fa-bell">🔔</i>
        </div>
    </div>

    <div class="dashboard-card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Filter Jadwal</span>
        </div>
        <div class="card-body">
            <form action="{{ route('superadmin.schedules.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="class_level" class="form-label">Kelas</label>
                        <select class="form-select" id="class_level" name="class_level">
                            <option value="">Semua Kelas</option>
                            @foreach($classLevels as $level)
                                <option value="{{ $level }}" {{ request('class_level') == $level ? 'selected' : '' }}>Kelas {{ $level }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="day_of_week" class="form-label">Hari</label>
                        <select class="form-select" id="day_of_week" name="day_of_week">
                            <option value="">Semua Hari</option>
                            @foreach($daysOfWeek as $day)
                                <option value="{{ $day }}" {{ request('day_of_week') == $day ? 'selected' : '' }}>{{ $day }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="teacher_id" class="form-label">Guru</label>
                        <select class="form-select" id="teacher_id" name="teacher_id">
                            <option value="">Semua Guru</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="subject_id" class="form-label">Mata Pelajaran</label>
                        <select class="form-select" id="subject_id" name="subject_id">
                            <option value="">Semua Mata Pelajaran</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="academic_year" class="form-label">Tahun Ajaran</label>
                        <select class="form-select" id="academic_year" name="academic_year">
                            <option value="">Semua Tahun Ajaran</option>
                            @foreach($academicYears as $year)
                                <option value="{{ $year }}" {{ request('academic_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="semester" class="form-label">Semester</label>
                        <select class="form-select" id="semester" name="semester">
                            <option value="">Semua Semester</option>
                            @foreach($semesters as $sem)
                                <option value="{{ $sem }}" {{ request('semester') == $sem ? 'selected' : '' }}>{{ $sem }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 d-flex align-items-end">
                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary me-2">Terapkan Filter</button>
                            <a href="{{ route('superadmin.schedules.index') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Jadwal Pembelajaran</span>
            <div>
                <a href="{{ route('superadmin.schedules.create') }}" class="btn btn-sm btn-success">+ Tambah Jadwal</a>
                <div class="dropdown d-inline-block ms-2">
                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="viewByDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Lihat Berdasarkan
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="viewByDropdown">
                        <li>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewByDayModal">
                                <i class="ti ti-calendar-event me-1"></i> Lihat per Hari
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewByClassModal">
                                <i class="ti ti-users me-1"></i> Lihat per Kelas
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($schedules->isEmpty())
                <div class="alert alert-info">
                    Belum ada jadwal yang ditambahkan. Silakan tambahkan jadwal baru.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Hari</th>
                                <th>Jam</th>
                                <th>Mata Pelajaran</th>
                                <th>Kelas</th>
                                <th>Guru</th>
                                <th>Ruangan</th>
                                <th>Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->day_of_week }}</td>
                                    <td>{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</td>
                                    <td>{{ $schedule->subject->name ?? 'N/A' }}</td>
                                    <td>{{ $schedule->class_level }}</td>
                                    <td>{{ $schedule->teacher->name ?? 'Belum ditentukan' }}</td>
                                    <td>{{ $schedule->room ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $schedule->status === 'active' ? 'success' : 'danger' }}">
                                            {{ $schedule->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('superadmin.schedules.show', $schedule) }}" class="btn btn-sm btn-info">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <a href="{{ route('superadmin.schedules.edit', $schedule) }}" class="btn btn-sm btn-warning">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <form action="{{ route('superadmin.schedules.destroy', $schedule) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Custom Pagination -->
                @if($schedules->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4 px-3">
                        <div class="text-muted small">
                            Menampilkan {{ $schedules->firstItem() }} sampai {{ $schedules->lastItem() }} dari {{ $schedules->total() }} hasil
                        </div>

                        <nav aria-label="Pagination Navigation">
                            <ul class="pagination pagination-sm mb-0">
                                {{-- Previous Page Link --}}
                                @if ($schedules->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <i class="fas fa-chevron-left"></i>
                                            <span class="d-none d-sm-inline ms-1">Previous</span>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $schedules->appends(request()->query())->previousPageUrl() }}">
                                            <i class="fas fa-chevron-left"></i>
                                            <span class="d-none d-sm-inline ms-1">Previous</span>
                                        </a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($schedules->appends(request()->query())->getUrlRange(1, $schedules->lastPage()) as $page => $url)
                                    @if ($page == $schedules->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($schedules->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $schedules->appends(request()->query())->nextPageUrl() }}">
                                            <span class="d-none d-sm-inline me-1">Next</span>
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <span class="d-none d-sm-inline me-1">Next</span>
                                            <i class="fas fa-chevron-right"></i>
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- View By Day Modal -->
    <div class="modal fade" id="viewByDayModal" tabindex="-1" aria-labelledby="viewByDayModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewByDayModalLabel">Lihat Jadwal Per Hari</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('superadmin.viewByDay') }}" method="GET">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="day_select" class="form-label">Pilih Hari</label>
                            <select class="form-select" id="day_select" name="day_of_week" required>
                                @foreach($daysOfWeek as $day)
                                    <option value="{{ $day }}">{{ $day }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="class_select" class="form-label">Kelas (Opsional)</label>
                            <select class="form-select" id="class_select" name="class_level">
                                <option value="">Semua Kelas</option>
                                @foreach($classLevels as $level)
                                    <option value="{{ $level }}">Kelas {{ $level }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="year_select" class="form-label">Tahun Ajaran</label>
                            <select class="form-select" id="year_select" name="academic_year" required>
                                @foreach($academicYears as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="semester_select" class="form-label">Semester</label>
                            <select class="form-select" id="semester_select" name="semester" required>
                                @foreach($semesters as $sem)
                                    <option value="{{ $sem }}">{{ $sem }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Lihat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View By Class Modal -->
    <div class="modal fade" id="viewByClassModal" tabindex="-1" aria-labelledby="viewByClassModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewByClassModalLabel">Lihat Jadwal Per Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('superadmin.viewByClass') }}" method="GET">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="class_level_select" class="form-label">Pilih Kelas</label>
                            <select class="form-select" id="class_level_select" name="class_level" required>
                                @foreach($classLevels as $level)
                                    <option value="{{ $level }}">Kelas {{ $level }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="academic_year_select" class="form-label">Tahun Ajaran</label>
                            <select class="form-select" id="academic_year_select" name="academic_year" required>
                                @foreach($academicYears as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="semester_select" class="form-label">Semester</label>
                            <select class="form-select" id="semester_select" name="semester" required>
                                @foreach($semesters as $sem)
                                    <option value="{{ $sem }}">{{ $sem }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Lihat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
