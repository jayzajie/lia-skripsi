<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>Formulir Pendaftaran - SD Normal Islam 2 Samarinda</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <link rel="stylesheet" href="../assets/css/dashboard-custom.css" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Tambahkan library html2pdf.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <style>
    /* Mobile sidebar toggle visibility */
    @media (max-width: 1199.98px) {
      .mobile-sidebar-toggle {
        display: block !important;
      }
      .body-wrapper {
        padding-left: 15px !important;
        padding-right: 15px !important;
      }
    }
    @media (min-width: 1200px) {
      .mobile-sidebar-toggle {
        display: none !important;
      }
    }
    
    /* Custom Logo Style */
    .centered-logo {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 10px 0 5px 0; /* Mengurangi padding bawah */
      margin-bottom: 0; /* Menghilangkan margin bawah */
    }
    
    .centered-logo .logo-img {
      text-align: center;
      width: 100%;
    }
    
    .centered-logo .logo-img img {
      max-height: 150px; /* Ukuran logo yang diminta */
      width: auto;
    }
    
    /* Memperbaiki posisi navbar agar tidak turun */
    .sidebar-nav {
      padding-top: 0 !important;
      margin-top: 0 !important;
    }
    
    /* Mengurangi jarak antara logo dan navbar */
    .scroll-sidebar {
      padding-top: 5px !important;
    }
    
    /* Memastikan tombol close di mobile tidak terlalu jauh */
    .d-flex.justify-content-end.d-xl-none {
      margin-top: -10px;
      margin-bottom: 5px;
    }
    
    /* Print styles */
    @media print {
      body * {
        visibility: hidden;
      }
      .form-container, .form-container * {
        visibility: visible;
      }
      .form-container {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
      }
      .no-print {
        display: none !important;
      }
    }
    
    /* Data preview modal */
    .modal {
      display: none;
      position: fixed;
      z-index: 1060;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.4);
    }
    
    .modal-content {
      background-color: #fefefe;
      margin: 10% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      max-width: 600px;
      border-radius: 8px;
    }
    
    /* Form finalized banner */
    .form-finalized-banner {
      display: none;
      background-color: #e8f5e9;
      border: 1px solid #c8e6c9;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 20px;
      align-items: center;
      justify-content: space-between;
    }
    
    .banner-content {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    
    .banner-content i {
      font-size: 24px;
      color: #4caf50;
    }
    
    .edit-form-btn {
      white-space: nowrap;
    }
    
    /* Form section styling */
    .form-section-title {
      border-bottom: 2px solid #f0f0f0;
      padding-bottom: 8px;
      color: #333;
    }
    
    /* Disabled form style */
    .form-control:disabled, .form-select:disabled {
      background-color: #f8f9fa;
      opacity: 0.8;
    }
    
    /* School header for print/PDF */
    .school-header {
      text-align: center;
      margin-bottom: 30px;
      border-bottom: 2px solid #000;
      padding-bottom: 15px;
    }
    
    .page-wrapper {
      position: relative !important;
      min-height: 100vh !important;
      height: auto !important;
      top: 0 !important;
      padding-top: 0 !important;
      margin-top: 0 !important;
      background: #f5f5f5 !important;
    }
    .body-wrapper {
      min-height: 100vh;
      background-color: #f5f5f5;
      padding-top: 0 !important;
      margin-top: 0 !important;
    }
    .container-fluid {
      padding-top: 0 !important;
      margin-top: 0 !important;
      background: transparent !important;
    }
    .card {
      margin-top: 0 !important;
      background: #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    /* Hapus spasi kosong di atas form */
    .card-body {
      padding-top: 1.5rem !important;
    }
    /* Hapus garis putih panjang di atas */
    header.app-header {
      margin-bottom: 0 !important;
      background: #fff !important;
      border-bottom: none !important;
      box-shadow: none !important;
    }
    .navbar {
      background: #fff !important;
      border-bottom: none !important;
      box-shadow: none !important;
    }
    .navbar-collapse {
      background: #fff !important;
    }
    .dropdown-menu {
      background: #fff !important;
    }
    /* Pastikan form-container menempel ke atas */
    .form-container {
      margin-top: 0 !important;
    }
  </style>
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div class="scroll-sidebar" style="height: 100%;">
        <!-- Logo at top -->
        <div class="centered-logo">
          <div class="logo-img">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Sekolah" />
          </div>
        </div>
        <!-- Close button for mobile -->
        <div class="d-flex justify-content-end d-xl-none">
          <button id="sidebarCollapse" class="btn btn-sm btn-light-primary">
            <i class="ti ti-x"></i>
          </button>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Menu</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-home"></i>
                </span>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link active" href="{{ route('formulir.index') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-file-text"></i>
                </span>
                <span class="hide-menu">Formulir Pendaftaran</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('berkas.index') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-files"></i>
                </span>
                <span class="hide-menu">Upload Berkas</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('konfirmasi.index') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-receipt"></i>
                </span>
                <span class="hide-menu">Konfirmasi Pembayaran</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('pengumuman.index') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-bell"></i>
                </span>
                <span class="hide-menu">Pengumuman</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Akun</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('profile.edit') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-user-circle"></i>
                </span>
                <span class="hide-menu">Profil</span>
              </a>
            </li>
            <li class="sidebar-item">
              <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <a class="sidebar-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" aria-expanded="false">
                  <span>
                    <i class="ti ti-logout"></i>
                  </span>
                  <span class="hide-menu">Logout</span>
                </a>
              </form>
            </li>
          </ul>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!-- Sidebar End -->
    
    <!-- Main wrapper -->
    <div class="body-wrapper">
      <!-- Header Start -->
      <header class="app-header">
        {{-- <nav class="navbar navbar-expand-lg navbar-light">
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <button class="navbar-toggler mobile-sidebar-toggle d-xl-none" type="button">
              <i class="ti ti-menu-2"></i>
            </button>
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="{{ route('profile.edit') }}" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">Profil Saya</p>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                    </form>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav> --}}
      </header>
      <!-- Header End -->
      
      <div class="container-fluid">
        <!-- Main Content -->
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Formulir Pendaftaran Siswa Baru</h5>
                
                <!-- Tampilkan pesan sukses jika ada -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <div class="d-flex align-items-center">
                    <i class="ti ti-check-circle fs-5 me-2"></i>
                    <strong>{{ session('success') }}</strong>
                  </div>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                
                <!-- Tampilkan pesan error jika ada -->
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <div class="d-flex align-items-center">
                    <i class="ti ti-alert-circle fs-5 me-2"></i>
                    <strong>{{ session('error') }}</strong>
                  </div>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                
                <!-- Form finalized banner -->
                @if(isset($formulir_sementara) && $formulir_sementara->status == 'submitted')
                <div class="form-finalized-banner" style="display: flex;">
                  <div class="banner-content">
                    <i class="ti ti-check-circle"></i>
                    <div>
                      <h5 class="mb-0">Formulir telah difinalisasi!</h5>
                      <p class="mb-0">Data tidak dapat diubah kecuali dengan izin admin.</p>
                    </div>
                  </div>
                  <a href="{{ route('formulir.edit', $formulir_sementara->id) }}" class="btn btn-sm btn-outline-success edit-form-btn">Edit Formulir</a>
                </div>
                @endif
                
                <div class="form-container p-4 bg-light rounded" id="printableForm">
                  <!-- School header - visible in print/PDF -->
                  <div class="school-header d-none d-print-block">
                    <h2>SD NORMAL ISLAM 2 SAMARINDA</h2>
                    <p>Jl. Kadrie Oening No. 77, Samarinda, Kalimantan Timur</p>
                    <p>Telp: (0541) 7777777 | Email: info@sdnormalislam2.sch.id</p>
                    <h3 class="mt-3">FORMULIR PENDAFTARAN SISWA BARU</h3>
                  </div>
                  
                  <form id="formulirPendaftaran" method="POST" action="{{ route('formulir.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                      <h4 class="form-section-title mb-3">Data Pribadi</h4>
                      <div class="row g-3">
                        <div class="col-md-6">
                          <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                          <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $formulir_sementara->nama_lengkap ?? '') }}" required>
                          @error('nama_lengkap')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="col-md-6">
                          <label for="nik" class="form-label">NIK</label>
                          <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik', $formulir_sementara->nik ?? '') }}" required>
                          @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="col-md-6">
                          <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                          <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $formulir_sementara->tempat_lahir ?? '') }}" required>
                          @error('tempat_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="col-md-6">
                          <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                          <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $formulir_sementara->tanggal_lahir ?? '') }}" required>
                          @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="col-md-6">
                          <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                          <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="">Pilih...</option>
                            <option value="Laki-Laki" {{ old('jenis_kelamin', $formulir_sementara->jenis_kelamin ?? '') == 'Laki-Laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $formulir_sementara->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                          </select>
                          @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="col-md-6">
                          <label for="agama" class="form-label">Agama</label>
                          <select class="form-select @error('agama') is-invalid @enderror" id="agama" name="agama" required>
                            <option value="">Pilih...</option>
                            <option value="Islam" {{ old('agama', $formulir_sementara->agama ?? '') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('agama', $formulir_sementara->agama ?? '') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('agama', $formulir_sementara->agama ?? '') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('agama', $formulir_sementara->agama ?? '') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('agama', $formulir_sementara->agama ?? '') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ old('agama', $formulir_sementara->agama ?? '') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                          </select>
                          @error('agama')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    
                    <div class="mb-4">
                      <h4 class="form-section-title mb-3">Data Orang Tua</h4>
                      <div class="row g-3">
                        <div class="col-md-6">
                          <label for="nama_ayah" class="form-label">Nama Ayah</label>
                          <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror" id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah', $formulir_sementara->nama_ayah ?? '') }}" required>
                          @error('nama_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="col-md-6">
                          <label for="nama_ibu" class="form-label">Nama Ibu</label>
                          <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror" id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu', $formulir_sementara->nama_ibu ?? '') }}" required>
                          @error('nama_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="col-md-6">
                          <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
                          <input type="text" class="form-control @error('pekerjaan_ayah') is-invalid @enderror" id="pekerjaan_ayah" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $formulir_sementara->pekerjaan_ayah ?? '') }}" required>
                          @error('pekerjaan_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="col-md-6">
                          <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
                          <input type="text" class="form-control @error('pekerjaan_ibu') is-invalid @enderror" id="pekerjaan_ibu" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $formulir_sementara->pekerjaan_ibu ?? '') }}" required>
                          @error('pekerjaan_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="col-md-6">
                          <label for="no_telp_ortu" class="form-label">No. HP</label>
                          <input type="text" class="form-control @error('no_telp_ortu') is-invalid @enderror" id="no_telp_ortu" name="no_telp_ortu" value="{{ old('no_telp_ortu', $formulir_sementara->no_telp_ortu ?? '') }}" required>
                          @error('no_telp_ortu')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="col-md-6">
                          <label for="anak_ke" class="form-label">Anak ke-</label>
                          <input type="text" class="form-control @error('anak_ke') is-invalid @enderror" id="anak_ke" name="anak_ke" value="{{ old('anak_ke', $formulir_sementara->anak_ke ?? '') }}" required>
                          @error('anak_ke')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    
                    <div class="mb-4">
                      <h4 class="form-section-title mb-3">Alamat</h4>
                      <div class="row g-3">
                        <div class="col-12">
                          <label for="alamat" class="form-label">Alamat Lengkap</label>
                          <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $formulir_sementara->alamat ?? '') }}</textarea>
                          @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="col-12">
                          <label for="alamat_ortu" class="form-label">Alamat Orang Tua</label>
                          <textarea class="form-control @error('alamat_ortu') is-invalid @enderror" id="alamat_ortu" name="alamat_ortu" rows="3" required>{{ old('alamat_ortu', $formulir_sementara->alamat_ortu ?? '') }}</textarea>
                          @error('alamat_ortu')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    
                    <!-- Foto Siswa Upload -->
                    <div class="mb-4">
                      <h4 class="form-section-title mb-3">Foto Siswa</h4>
                      <div class="row g-3">
                        <div class="col-12">
                          <label for="foto_siswa" class="form-label">Upload Foto (Ukuran 3x4)</label>
                          <input type="file" class="form-control @error('foto_siswa') is-invalid @enderror" id="foto_siswa" name="foto_siswa" accept="image/*">
                          @error('foto_siswa')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                          <div class="foto-siswa-preview mt-2">
                            @if(isset($formulir_sementara) && $formulir_sementara->foto_siswa)
                              <img src="{{ asset('storage/' . $formulir_sementara->foto_siswa) }}" alt="Foto Siswa" class="img-thumbnail">
                              <p class="text-success mb-0 mt-2"><i class="ti ti-check-circle"></i> Foto telah diupload</p>
                            @else
                              <p class="text-muted mb-0"><i class="ti ti-photo"></i> Belum ada foto yang diupload</p>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Signature section for printing -->
                    <div class="d-none d-print-block mt-5">
                      <div class="row">
                        <div class="col-7"></div>
                        <div class="col-5 text-center">
                          <p>Samarinda, ...............................<br>Orang Tua/Wali</p>
                          <div style="height: 80px;"></div>
                          <p>(.................................................)</p>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Kartu Peserta Template - hanya muncul saat print -->
                    <div class="d-none d-print-block mt-5" id="kartu-peserta">
                      <div style="page-break-before: always;"></div>
                      <div class="card" style="max-width: 500px; margin: 0 auto; border: 1px solid #000;">
                        <div class="card-body p-4">
                          <div class="row mb-3">
                            <div class="col-2 text-center">
                              <img src="{{ asset('images/logo.png') }}" alt="Logo Sekolah" style="width: 60px; height: auto;">
                            </div>
                            <div class="col-10 text-center">
                              <h4 class="text-primary mb-1">KARTU PESERTA</h4>
                              <p class="mb-0" style="font-size: 12px;">PENDAFTARAN MAHASISWA BARU</p>
                              <p class="mb-0" style="font-size: 12px;">JALUR SELEKSI MANDIRI KONSORSIUM POLITEKNIK</p>
                              <p class="mb-0" style="font-size: 12px;">Politeknik Pertanian Negeri Samarinda</p>
                              <p class="mb-0" style="font-size: 12px;">TAHUN 2023</p>
                            </div>
                          </div>
                          
                          <div class="row">
                            <div class="col-8">
                              <table class="table table-sm table-borderless" style="font-size: 12px;">
                                <tr>
                                  <td width="100">NOMOR</td>
                                  <td>: {{ $formulir_sementara->id ?? '2525030030' }}</td>
                                </tr>
                                <tr>
                                  <td>NAMA</td>
                                  <td>: {{ $formulir_sementara->nama_lengkap ?? 'SISWA NO JEKO' }}</td>
                                </tr>
                                <tr>
                                  <td>ALAMAT</td>
                                  <td>: {{ $formulir_sementara->alamat ?? 'LEMPAKE' }}</td>
                                </tr>
                                <tr>
                                  <td>TELEPON</td>
                                  <td>: {{ $formulir_sementara->no_telp_ortu ?? '081346578923' }}</td>
                                </tr>
                                <tr>
                                  <td>PILIHAN PROGRAM STUDI</td>
                                  <td>:</td>
                                </tr>
                                <tr>
                                  <td colspan="2">
                                    <ol style="padding-left: 20px; margin-bottom: 0;">
                                      <li>D3 TEKNOLOGI REKAYASA PERANGKAT LUNAK</li>
                                      <li>D4 TEKNOLOGI REKAYASA GEOMATIKA DAN SURVEI</li>
                                      <li>D3 SISTEM INFORMASI AKUNTANSI</li>
                                    </ol>
                                  </td>
                                </tr>
                              </table>
                            </div>
                            <div class="col-4 text-center">
                              @if(isset($formulir_sementara) && $formulir_sementara->foto_siswa)
                                <img src="{{ asset('storage/' . $formulir_sementara->foto_siswa) }}" alt="Foto Siswa" style="width: 100px; height: 133px; object-fit: cover; border: 1px solid #ddd;">
                              @else
                                <!-- Dummy image placeholder -->
                                <div style="width: 100px; height: 133px; border: 1px solid #ddd; margin: 0 auto; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
                                  <span>Foto 3x4</span>
                                </div>
                              @endif
                            </div>
                          </div>
                          
                          <div class="row mt-3">
                            <div class="col-12 text-center">
                              <div style="border-bottom: 1px dashed #000; padding-bottom: 10px;">
                                <img src="https://dummyimage.com/150x40/000/fff&text=Barcode" alt="Barcode" style="height: 40px;">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="text-end mt-4 no-print">
                      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" onclick="window.print()" class="btn btn-success btn-action">
                          <i class="ti ti-printer me-1"></i> Cetak Formulir
                        </button>
                        @if(isset($formulir_sementara) && $formulir_sementara->id)
                          <a href="{{ route('kartu.peserta.pdf', $formulir_sementara->id) }}" class="btn btn-info btn-action">
                            <i class="ti ti-id me-1"></i> Cetak Kartu Peserta
                          </a>
                        @else
                          <button type="button" class="btn btn-info btn-action" disabled>
                            <i class="ti ti-id me-1"></i> Cetak Kartu Peserta
                          </button>
                        @endif
                        <button type="submit" class="btn btn-warning btn-action">
                          <i class="ti ti-device-floppy me-1"></i> Setor Data
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/js/dashboard.js"></script>
  <script>
    // Initialize mobile sidebar toggle
    document.addEventListener('DOMContentLoaded', function() {
      const mobileToggle = document.querySelector('.mobile-sidebar-toggle');
      const sidebarOverlay = document.querySelector('.sidebar-overlay');
      const mainWrapper = document.getElementById('main-wrapper');
      const sidebarClose = document.getElementById('sidebarCollapse');
      
      if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
          mainWrapper.classList.add('sidebar-open');
        });
      }
      
      if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
          mainWrapper.classList.remove('sidebar-open');
        });
      }
      
      if (sidebarClose) {
        sidebarClose.addEventListener('click', function() {
          mainWrapper.classList.remove('sidebar-open');
        });
      }
    });
    
    // Function to print only the kartu peserta
    function printKartuPeserta() {
      // Hide all content except kartu peserta
      const originalContent = document.body.innerHTML;
      const kartuPeserta = document.getElementById('kartu-peserta').innerHTML;
      
      document.body.innerHTML = 
        '<div style="padding: 20px;">' + 
        kartuPeserta + 
        '</div>';
      
      window.print();
      
      // Restore original content
      document.body.innerHTML = originalContent;
      
      // Reattach event listeners
      document.querySelectorAll('button').forEach(button => {
        if (button.getAttribute('onclick') === 'printKartuPeserta()') {
          button.addEventListener('click', printKartuPeserta);
        }
      });
    }
    
    // Function to download kartu peserta as PDF
    function printKartuPeserta() {
      // Get the kartu peserta element
      const kartuPeserta = document.getElementById('kartu-peserta');
      
      // Clone the element to avoid modifying the original
      const kartuPesertaClone = kartuPeserta.cloneNode(true);
      
      // Remove d-none and d-print-block classes to make it visible
      kartuPesertaClone.classList.remove('d-none', 'd-print-block');
      
      // Create a temporary container
      const tempContainer = document.createElement('div');
      tempContainer.appendChild(kartuPesertaClone);
      
      // Set the container style
      tempContainer.style.padding = '20px';
      tempContainer.style.backgroundColor = 'white';
      
      // Get the student name for the filename
      const studentName = '{{ $formulir_sementara->nama_lengkap ?? "Peserta" }}';
      const fileName = `Kartu_Peserta_${studentName.replace(/\s+/g, '_')}.pdf`;
      
      // Configure html2pdf options
      const opt = {
        margin: 10,
        filename: fileName,
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
      };
      
      // Generate and download PDF
      html2pdf().from(tempContainer).set(opt).save();
    }
  </script>
</body>

</html>