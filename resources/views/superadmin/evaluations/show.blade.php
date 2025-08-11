@extends('layouts.superadmin')

@section('title', 'Detail Penilaian - Super Admin')

@section('content')
    <div class="position-relative">
        <h1 class="welcome-header">Detail Penilaian</h1>
    </div>

    <div class="dashboard-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Informasi Penilaian</span>
            <div>
                <a href="{{ route('superadmin.evaluations.edit', $evaluation) }}" class="btn btn-sm btn-warning">
                    <i class="ti ti-edit me-1"></i> Edit
                </a>
                <a href="{{ route('superadmin.evaluations.index') }}" class="btn btn-sm btn-secondary ms-2">
                    <i class="ti ti-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="border-bottom pb-2">Informasi Siswa</h5>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="150">Nama Siswa</th>
                            <td>: {{ $evaluation->student->name }}</td>
                        </tr>
                        <tr>
                            <th>NIS</th>
                            <td>: {{ $evaluation->student->nis }}</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>: {{ $evaluation->student->class_level }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="border-bottom pb-2">Informasi Mata Pelajaran</h5>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="150">Mata Pelajaran</th>
                            <td>: {{ $evaluation->subject->name }}</td>
                        </tr>
                        <tr>
                            <th>Kode</th>
                            <td>: {{ $evaluation->subject->code }}</td>
                        </tr>
                        <tr>
                            <th>Guru</th>
                            <td>: {{ $evaluation->subject->teacher->name ?? 'Belum ditentukan' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <h5 class="border-bottom pb-2">Informasi Akademik</h5>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="150">Tahun Ajaran</th>
                            <td>: {{ $evaluation->academic_year }}</td>
                        </tr>
                        <tr>
                            <th>Semester</th>
                            <td>: {{ $evaluation->semester }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="border-bottom pb-2">Detail Nilai</h5>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="150">Nilai Tugas (30%)</th>
                            <td>: {{ $evaluation->assessment_score ?? 'Belum dinilai' }}</td>
                        </tr>
                        <tr>
                            <th>Nilai UTS (30%)</th>
                            <td>: {{ $evaluation->mid_exam_score ?? 'Belum dinilai' }}</td>
                        </tr>
                        <tr>
                            <th>Nilai UAS (40%)</th>
                            <td>: {{ $evaluation->final_exam_score ?? 'Belum dinilai' }}</td>
                        </tr>
                        <tr>
                            <th>Nilai Akhir</th>
                            <td>: <strong>{{ $evaluation->final_score ?? 'Belum dihitung' }}</strong></td>
                        </tr>
                        <tr>
                            <th>Grade</th>
                            <td>: 
                                @if($evaluation->grade)
                                    <span class="badge bg-{{ 
                                        $evaluation->grade == 'A' ? 'success' : 
                                        ($evaluation->grade == 'B' ? 'primary' : 
                                        ($evaluation->grade == 'C' ? 'warning' : 
                                        ($evaluation->grade == 'D' ? 'danger' : 'danger'))) 
                                    }}">{{ $evaluation->grade }}</span>
                                @else
                                    <span class="text-muted">Belum dihitung</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="mt-4">
                <h5 class="border-bottom pb-2">Catatan Guru</h5>
                <div class="p-3 bg-light rounded">
                    {{ $evaluation->teacher_notes ?? 'Tidak ada catatan' }}
                </div>
            </div>
            
            <div class="mt-4 d-flex justify-content-between">
                <form action="{{ route('superadmin.evaluations.destroy', $evaluation) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data penilaian ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="ti ti-trash me-1"></i> Hapus Data Penilaian
                    </button>
                </form>
                
                <a href="{{ route('superadmin.evaluations.edit', $evaluation) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i> Edit Data Penilaian
                </a>
            </div>
        </div>
    </div>
@endsection 