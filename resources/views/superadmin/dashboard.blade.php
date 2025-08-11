@extends('layouts.superadmin')

@section('title', 'Dashboard - Super Admin')

@section('content')
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                <div class="card-body py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h2 mb-1 fw-bold">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Dashboard Super Admin
                            </h1>
                            <p class="mb-0 opacity-75">
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ date('l, d F Y') }} - Ringkasan Data Sekolah
                            </p>
                        </div>
                        <div class="text-end">
                            {{-- <div class="badge bg-light text-primary fs-6 px-3 py-2 mb-2">
                                <i class="fas fa-sync-alt me-1"></i>
                                Live Data
                            </div> --}}
                            <div class="notification-icon">
                                <i class="fas fa-bell text-warning fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <!-- Students Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-gradient rounded-3 p-3">
                                <i class="fas fa-user-graduate text-white fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small fw-bold text-uppercase">Total Siswa</div>
                            <div class="fs-2 fw-bold text-primary">{{ $totalStudents }}</div>
                            <div class="small text-muted">
                                <span class="text-success">{{ $activeStudents }} Aktif</span> •
                                <span class="text-danger">{{ $inactiveStudents }} Tidak Aktif</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('superadmin.students.index') }}" class="btn btn-outline-primary btn-sm w-100">
                            <i class="fas fa-eye me-1"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teachers Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-gradient rounded-3 p-3">
                                <i class="fas fa-chalkboard-teacher text-white fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small fw-bold text-uppercase">Total Guru</div>
                            <div class="fs-2 fw-bold text-success">{{ $totalTeachers }}</div>
                            <div class="small text-muted">Guru Aktif</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('superadmin.staff.index') }}" class="btn btn-outline-success btn-sm w-100">
                            <i class="fas fa-eye me-1"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Classes Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-gradient rounded-3 p-3">
                                <i class="fas fa-school text-white fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small fw-bold text-uppercase">Total Kelas</div>
                            <div class="fs-2 fw-bold text-warning">{{ $totalClasses }}</div>
                            <div class="small text-muted">
                                <span class="text-success">{{ $activeClasses }} Aktif</span> •
                                <span class="text-secondary">{{ $inactiveClasses }} Tidak Aktif</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('superadmin.classes.index') }}" class="btn btn-outline-warning btn-sm w-100">
                            <i class="fas fa-eye me-1"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Verification Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-danger bg-gradient rounded-3 p-3">
                                <i class="fas fa-clipboard-check text-white fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small fw-bold text-uppercase">Verifikasi</div>
                            <div class="fs-2 fw-bold text-danger">{{ $pendingVerifications }}</div>
                            <div class="small text-muted">Menunggu Verifikasi</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.verification.index') }}" class="btn btn-outline-danger btn-sm w-100">
                            <i class="fas fa-eye me-1"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Statistics -->
    <div class="row g-4">
        <!-- Chart Section -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1 fw-bold">
                                <i class="fas fa-chart-bar text-primary me-2"></i>
                                Distribusi Siswa per Kelas
                            </h5>
                            <p class="text-muted small mb-0">Grafik jumlah siswa di setiap kelas</p>
                        </div>
                        <a href="{{ route('superadmin.students.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-external-link-alt me-1"></i> Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 350px;">
                        <canvas id="classChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1 fw-bold">
                                <i class="fas fa-list-alt text-success me-2"></i>
                                Detail per Kelas
                            </h5>
                            <p class="text-muted small mb-0">Rincian jumlah siswa</p>
                        </div>
                        <a href="{{ route('superadmin.classes.index') }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-external-link-alt me-1"></i> Kelola
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($classDetails->count() > 0)
                        <div class="class-stats-modern">
                            @foreach($classDetails as $class)
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle p-2 me-3">
                                        <i class="fas fa-users text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">Kelas {{ $class['name'] }}</div>
                                        <small class="text-muted">
                                            Tingkat {{ $class['grade_level'] }}
                                            @if($class['homeroom_teacher'])
                                                • {{ $class['homeroom_teacher'] }}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-{{ $class['status'] == 'active' ? 'primary' : 'secondary' }}-subtle text-{{ $class['status'] == 'active' ? 'primary' : 'secondary' }} fs-6 px-3 py-2">
                                        {{ $class['student_count'] }} siswa
                                    </span>
                                    <div class="small text-muted mt-1">
                                        {{ $class['capacity'] - $class['student_count'] }} tersisa
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            <!-- Summary -->
                            <div class="mt-3 p-3 bg-light rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark">Total Keseluruhan:</span>
                                    <span class="badge bg-success fs-6 px-3 py-2">
                                        {{ $classDetails->sum('student_count') }} siswa
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="small text-muted">Total Kapasitas:</span>
                                    <span class="small text-muted">
                                        {{ $classDetails->sum('capacity') }} tempat
                                    </span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-school text-muted" style="font-size: 3rem;"></i>
                            </div>
                            <h6 class="text-muted">Belum ada data kelas</h6>
                            <p class="text-muted small">Mulai dengan menambahkan kelas baru</p>
                            <a href="{{ route('superadmin.classes.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i> Tambah Kelas
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
    /* Custom Dashboard Styles */
    .hover-lift {
        transition: all 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .chart-container {
        position: relative;
        width: 100%;
        height: 350px;
    }

    .class-stats-modern .border-bottom:last-child {
        border-bottom: none !important;
    }

    .badge {
        font-weight: 500;
    }

    .bg-primary-subtle {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }

    .card {
        border-radius: 12px;
    }

    .rounded-3 {
        border-radius: 8px !important;
    }

    .fs-2 {
        font-size: 2.5rem !important;
        font-weight: 700;
    }

    /* Animation for numbers */
    .dashboard-stat {
        animation: countUp 1s ease-out;
    }

    @keyframes countUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .fs-2 {
            font-size: 2rem !important;
        }

        .chart-container {
            height: 250px;
        }
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Modern Chart Configuration
    const ctx = document.getElementById('classChart').getContext('2d');

    // Gradient colors for bars
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(102, 126, 234, 0.8)');
    gradient.addColorStop(1, 'rgba(118, 75, 162, 0.2)');

    const classChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($classData)) !!},
            datasets: [{
                label: 'Jumlah Siswa',
                data: {!! json_encode(array_values($classData)) !!},
                backgroundColor: gradient,
                borderColor: 'rgba(102, 126, 234, 1)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index',
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgba(102, 126, 234, 1)',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        title: function(context) {
                            return 'Kelas ' + context[0].label;
                        },
                        label: function(context) {
                            return context.parsed.y + ' siswa terdaftar';
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6c757d',
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        stepSize: 1,
                        color: '#6c757d',
                        callback: function(value) {
                            return value + ' siswa';
                        }
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeInOutQuart'
            }
        }
    });
</script>
@endsection
