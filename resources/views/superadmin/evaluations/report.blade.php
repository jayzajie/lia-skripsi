@extends('layouts.superadmin')

@section('title', 'Laporan Penilaian Siswa - Super Admin')

@section('content')
    <div class="position-relative">
        <h1 class="welcome-header">Laporan Penilaian Siswa</h1>
    </div>

    <div class="dashboard-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Laporan Penilaian {{ $student->name }} ({{ $student->nis }})</span>
            <div>
                <button onclick="window.print()" class="btn btn-sm btn-success">
                    <i class="ti ti-printer me-1"></i> Cetak Laporan
                </button>
                <a href="{{ route('superadmin.evaluations.index') }}" class="btn btn-sm btn-secondary ms-2">
                    <i class="ti ti-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="150">Nama Siswa</th>
                                <td>: {{ $student->name }}</td>
                            </tr>
                            <tr>
                                <th>NIS</th>
                                <td>: {{ $student->nis }}</td>
                            </tr>
                            <tr>
                                <th>Kelas</th>
                                <td>: {{ $student->class_level }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="150">Tahun Ajaran</th>
                                <td>: {{ $evaluations->first()->academic_year ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Semester</th>
                                <td>: {{ $evaluations->first()->semester ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th rowspan="2" class="text-center align-middle">No</th>
                            <th rowspan="2" class="text-center align-middle">Mata Pelajaran</th>
                            <th colspan="3" class="text-center">Komponen Nilai</th>
                            <th rowspan="2" class="text-center align-middle">Nilai Akhir</th>
                            <th rowspan="2" class="text-center align-middle">Grade</th>
                        </tr>
                        <tr>
                            <th class="text-center">Tugas (30%)</th>
                            <th class="text-center">UTS (30%)</th>
                            <th class="text-center">UAS (40%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($evaluations as $index => $evaluation)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $evaluation->subject->name }}</td>
                                <td class="text-center">{{ $evaluation->assessment_score ?? '-' }}</td>
                                <td class="text-center">{{ $evaluation->mid_exam_score ?? '-' }}</td>
                                <td class="text-center">{{ $evaluation->final_exam_score ?? '-' }}</td>
                                <td class="text-center"><strong>{{ $evaluation->final_score ?? '-' }}</strong></td>
                                <td class="text-center">
                                    @if($evaluation->grade)
                                        <span class="badge bg-{{ 
                                            $evaluation->grade == 'A' ? 'success' : 
                                            ($evaluation->grade == 'B' ? 'primary' : 
                                            ($evaluation->grade == 'C' ? 'warning' : 
                                            ($evaluation->grade == 'D' ? 'danger' : 'danger'))) 
                                        }}">{{ $evaluation->grade }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data penilaian</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="2" class="text-end">Rata-rata</th>
                            <th class="text-center">{{ number_format($averageAssessment, 2) ?? '-' }}</th>
                            <th class="text-center">{{ number_format($averageMidExam, 2) ?? '-' }}</th>
                            <th class="text-center">{{ number_format($averageFinalExam, 2) ?? '-' }}</th>
                            <th class="text-center"><strong>{{ number_format($averageFinal, 2) ?? '-' }}</strong></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="mt-5 row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <p><strong>Keterangan Grade:</strong></p>
                        <ul>
                            <li>A = 90-100 (Sangat Baik)</li>
                            <li>B = 80-89 (Baik)</li>
                            <li>C = 70-79 (Cukup)</li>
                            <li>D = 60-69 (Perlu Bimbingan)</li>
                            <li>E = < 60 (Perlu Perhatian Khusus)</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <p>Samarinda, {{ date('d F Y') }}</p>
                    <p>Kepala Sekolah,</p>
                    <br><br><br>
                    <p><strong>__________________</strong></p>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        @media print {
            body {
                padding: 0;
                margin: 0;
            }
            
            .card-header, .btn, nav, footer, .sidebar, .left-sidebar, .notification-icon {
                display: none !important;
            }
            
            .dashboard-card {
                border: none !important;
                box-shadow: none !important;
            }
            
            .welcome-header {
                text-align: center;
                margin-bottom: 20px;
            }
        }
    </style>
@endsection 