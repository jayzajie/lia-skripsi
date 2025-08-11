<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>Pengumuman - SD Normal Islam 2 Samarinda</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <link rel="stylesheet" href="../assets/css/dashboard-custom.css" />
  <style>
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
  </style>
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <div class="scroll-sidebar" style="height: 100%;">
        <div class="centered-logo">
          <div class="logo-img">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Sekolah" />
          </div>
        </div>
        <div class="d-flex justify-content-end d-xl-none">
          <button id="sidebarCollapse" class="btn btn-sm btn-light-primary">
            <i class="ti ti-x"></i>
          </button>
        </div>
        <nav class="sidebar-nav">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Menu</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
                <span><i class="ti ti-home"></i></span>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('formulir.index') }}" aria-expanded="false">
                <span><i class="ti ti-file-text"></i></span>
                <span class="hide-menu">Formulir Pendaftaran</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('berkas.index') }}" aria-expanded="false">
                <span><i class="ti ti-files"></i></span>
                <span class="hide-menu">Upload Berkas</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('konfirmasi.index') }}" aria-expanded="false">
                <span><i class="ti ti-receipt"></i></span>
                <span class="hide-menu">Konfirmasi Pembayaran</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link active" href="{{ route('pengumuman.index') }}" aria-expanded="false">
                <span><i class="ti ti-bell"></i></span>
                <span class="hide-menu">Pengumuman</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Akun</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('profile.edit') }}" aria-expanded="false">
                <span><i class="ti ti-user-circle"></i></span>
                <span class="hide-menu">Profil</span>
              </a>
            </li>
            <li class="sidebar-item">
              <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <a class="sidebar-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" aria-expanded="false">
                  <span><i class="ti ti-logout"></i></span>
                  <span class="hide-menu">Logout</span>
                </a>
              </form>
            </li>
          </ul>
        </nav>
      </div>
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <div class="container-fluid p-0">
        <!--  Row 1 -->
        <div class="row m-0">
          <div class="col-12 p-0">
            <div class="card w-100 border-0">
              <div class="card-body p-4">
                <h1 class="card-title fs-1 fw-bold mb-4">Pengumuman</h1>
                
                <div class="form-container p-4 bg-light rounded">
                  <div class="alert alert-primary mb-4">
                    <h5 class="alert-heading">Informasi Penting</h5>
                    <p class="mb-0">Berikut adalah pengumuman dan informasi penting terkait pendaftaran siswa baru SD Normal Islam 2 Samarinda.</p>
                  </div>
                  
                  <div class="pengumuman-list">
                    @if(count($pengumumans) > 0)
                      @foreach($pengumumans as $pengumuman)
                        <div class="card mb-3">
                          <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $pengumuman->nama }}</h5>
                            <span class="badge bg-light text-dark">{{ \Carbon\Carbon::parse($pengumuman->tanggal_terbit)->format('d M Y') }}</span>
                          </div>
                          <div class="card-body">
                            <p>{{ $pengumuman->keterangan }}</p>
                          </div>
                        </div>
                      @endforeach
                    @else
                      <!-- Static content for when there are no announcements -->
                      <div class="card mb-3">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                          <h5 class="mb-0">Jadwal Pendaftaran Tahun Ajaran 2023/2024</h5>
                          <span class="badge bg-light text-dark">20 Mei 2023</span>
                        </div>
                        <div class="card-body">
                          <p>Pendaftaran siswa baru SD Normal Islam 2 Samarinda untuk tahun ajaran 2023/2024 akan dibuka pada:</p>
                          <ul>
                            <li>Gelombang 1: 1 Juni - 30 Juni 2023</li>
                            <li>Gelombang 2: 1 Juli - 31 Juli 2023</li>
                          </ul>
                          <p>Kuota terbatas. Segera lengkapi pendaftaran Anda.</p>
                        </div>
                      </div>
                      
                      <div class="card mb-3">
                        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                          <h5 class="mb-0">Persyaratan Pendaftaran</h5>
                          <span class="badge bg-light text-dark">15 Mei 2023</span>
                        </div>
                        <div class="card-body">
                          <p>Berikut adalah persyaratan yang harus dilengkapi untuk pendaftaran:</p>
                          <ol>
                            <li>Mengisi formulir pendaftaran</li>
                            <li>Fotokopi Kartu Keluarga</li>
                            <li>Fotokopi Akta Kelahiran</li>
                            <li>Pas foto 3x4 (4 lembar)</li>
                            <li>Fotokopi KTP orang tua/wali</li>
                            <li>Ijazah TK (jika ada)</li>
                          </ol>
                        </div>
                      </div>
                      
                      <div class="card mb-3">
                        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                          <h5 class="mb-0">Biaya Pendaftaran</h5>
                          <span class="badge bg-light text-dark">10 Mei 2023</span>
                        </div>
                        <div class="card-body">
                          <p>Informasi biaya pendaftaran:</p>
                          <ul>
                            <li>Biaya pendaftaran: Rp 600.000</li>
                            <li>SPP bulan pertama: Rp 350.000</li>
                            <li>Seragam dan perlengkapan: Rp 750.000</li>
                          </ul>
                          <p>Pembayaran dapat dilakukan melalui transfer bank atau langsung di sekolah.</p>
                        </div>
                      </div>
                      
                      <div class="card mb-3">
                        <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                          <h5 class="mb-0">Jadwal Tes Masuk</h5>
                          <span class="badge bg-light text-dark">5 Mei 2023</span>
                        </div>
                        <div class="card-body">
                          <p>Tes masuk akan dilaksanakan pada:</p>
                          <ul>
                            <li>Gelombang 1: 5 Juli 2023</li>
                            <li>Gelombang 2: 5 Agustus 2023</li>
                          </ul>
                          <p>Materi tes meliputi: Calistung, Wawancara, dan Tes Kesiapan Sekolah.</p>
                        </div>
                      </div>
                    @endif
                  </div>
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
</body>

</html>