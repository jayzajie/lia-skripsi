<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>Dashboard - SD Normal Islam 2 Samarinda</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <link rel="stylesheet" href="../assets/css/dashboard-custom.css" />
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
  </style>
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo centered-logo">
          <a href="./index.html" class="text-nowrap logo-img">
            <img src="../images/logo.png" alt="SD Normal Islam 2 Samarinda" />
          </a>
        </div>
        <div class="d-flex justify-content-end d-xl-none">
          <div class="close-btn d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-6"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">User</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
                <i class="ti ti-home"></i>
                <span class="hide-menu">Beranda</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('formulir.index') }}" aria-expanded="false">
                <i class="ti ti-file-description"></i>
                <span class="hide-menu">Formulir Pendaftaran</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('berkas.index') }}" aria-expanded="false">
                <i class="ti ti-upload"></i>
                <span class="hide-menu">Upload Berkas</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('konfirmasi.index') }}" aria-expanded="false">
                <i class="ti ti-check-circle"></i>
                <span class="hide-menu">Status Pendaftaran</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('pengumuman.index') }}" aria-expanded="false">
                <i class="ti ti-bell"></i>
                <span class="hide-menu">Pengumuman</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();" aria-expanded="false">
                <i class="ti ti-logout"></i>
                <span class="hide-menu">Keluar</span>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </li>
          </ul>

          <!-- Admin testing section -->
          <div class="mt-4 mx-4">
            <div class="alert alert-info">
              <h6 class="alert-heading">Admin Panel (Testing)</h6>
              <div class="mt-2">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-primary d-block mb-2">Admin Dashboard</a>
                <a href="{{ route('admin.verification.index') }}" class="btn btn-sm btn-primary d-block mb-2">Verifikasi Data</a>
                <a href="{{ route('admin.students.index') }}" class="btn btn-sm btn-primary d-block mb-2">Data Siswa</a>
                <a href="{{ route('superadmin.dashboard') }}" class="btn btn-sm btn-success d-block">Super Admin Dashboard</a>
              </div>
            </div>
          </div>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->

    <!-- Mobile sidebar toggle button -->
    <button class="mobile-sidebar-toggle d-xl-none" aria-label="Toggle sidebar">☰</button>

    <!-- Sidebar overlay -->
    <div class="sidebar-overlay"></div>

    <!--  Main wrapper -->
    <div class="body-wrapper">
      <div class="container-fluid p-0">
        <!--  Row 1 -->
        <div class="row m-0">
          <div class="col-12 p-0">
            <div class="card w-100 border-0">
              <div class="card-body p-4">
                <div class="welcome-section text-center">
                  <h1 class="card-title fs-1 fw-bold mb-4">Selamat Datang !</h1>

                  <!-- Admin Test Area -->
                  {{-- <div class="alert alert-warning mb-4">
                    <h5 class="alert-heading">Menu Admin (Testing)</h5>
                    <p>Anda dapat mengakses panel admin untuk testing melalui link berikut:</p>
                    <div class="d-flex justify-content-center gap-2 mt-3">
                      <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Admin Dashboard</a>
                      <a href="{{ route('admin.verification.index') }}" class="btn btn-info text-white">Verifikasi Data</a>
                      <a href="{{ route('admin.students.index') }}" class="btn btn-success">Data Siswa</a>
                      <a href="{{ route('superadmin.dashboard') }}" class="btn btn-danger">Super Admin</a>
                    </div>
                  </div> --}}

                  <div class="form-container p-4 bg-light rounded">
                    <h2 class="mb-5">Formulir Pendaftaran</h2>
                    <h3 class="mb-5">Lengkapi Data Dibawah Ini !</h3>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-box bg-success bg-opacity-25 p-4 rounded mb-3">
                          <h5 class="mb-3">Formulir Pendaftaran</h5>
                          <div class="text-center mt-3">
                            <a href="{{ route('formulir.index') }}" class="btn btn-info text-white">Cetak Formulir Pendaftaran</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-box bg-success bg-opacity-25 p-4 rounded mb-3">
                          <h5 class="mb-3">Upload Berkas</h5>
                          <div class="text-center mt-3">
                            <a href="{{ route('berkas.index') }}" class="btn btn-info text-white">Cetak Formulir</a>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="text-end mt-3">
                      <a href="{{ route('konfirmasi.index') }}" class="btn btn-danger">Konfirmasi Pendaftaran !</a>
                    </div>
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
  </script>
</body>

</html>
