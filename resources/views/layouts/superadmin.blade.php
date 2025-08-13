<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Super Admin Panel') - SD Normal Islam 2 Samarinda</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard-custom.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/logo-custom.css') }}" />
  <!-- FontAwesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Tambahkan CSS datepicker -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
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
          <a href="{{ route('superadmin.dashboard') }}" class="text-nowrap logo-img">
            <img src="{{ asset('images/logo.png') }}" alt="SD Normal Islam 2 Samarinda" />
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
              <span class="hide-menu">SUPER ADMIN</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}" href="{{ route('superadmin.dashboard') }}" aria-expanded="false">
                <i class="ti ti-home"></i>
                <span class="hide-menu">Beranda</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('superadmin.students.*') ? 'active' : '' }}" href="{{ route('superadmin.students.index') }}" aria-expanded="false">
                <i class="ti ti-users"></i>
                <span class="hide-menu">Data Siswa</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('superadmin.staff.*') ? 'active' : '' }}" href="{{ route('superadmin.staff.index') }}" aria-expanded="false">
                <i class="ti ti-user"></i>
                <span class="hide-menu">Data Pegawai</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('superadmin.classes.*') ? 'active' : '' }}" href="{{ route('superadmin.classes.index') }}" aria-expanded="false">
                <i class="ti ti-school"></i>
                <span class="hide-menu">Data Kelas</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('superadmin.rombel.*') ? 'active' : '' }}" href="{{ route('superadmin.rombel.index') }}" aria-expanded="false">
                <i class="ti ti-users"></i>
                <span class="hide-menu">Manajemen Rombel</span>
              </a>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('superadmin.activities.index') ? 'active' : '' }}" href="{{ route('superadmin.activities.index') }}" aria-expanded="false">
                <i class="ti ti-calendar"></i>
                <span class="hide-menu">Data Kegiatan</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('superadmin.evaluations.index') ? 'active' : '' }}" href="{{ route('superadmin.evaluations.index') }}" aria-expanded="false">
                <i class="ti ti-clipboard-check"></i>
                <span class="hide-menu">Data Penilaian</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('superadmin.subjects.index') ? 'active' : '' }}" href="{{ route('superadmin.subjects.index') }}" aria-expanded="false">
                <i class="ti ti-book"></i>
                <span class="hide-menu">Data Mata Pelajaran</span>
              </a>
            </li>
            {{-- <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('superadmin.schedule') ? 'active' : '' }}" href="{{ route('superadmin.schedule') }}" aria-expanded="false">
                <i class="ti ti-calendar-event"></i>
                <span class="hide-menu">Jadwal Pembelajaran</span>
              </a>
            </li> --}}
            <!-- Tambahkan di bagian sidebar navigation, sebelum menu Keluar -->
            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('superadmin.users.*') ? 'active' : '' }}" href="{{ route('superadmin.users.index') }}" aria-expanded="false">
                <i class="ti ti-user"></i>
                <span class="hide-menu">Manajemen User</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('superadmin.academic-years.*') ? 'active' : '' }}" href="{{ route('superadmin.academic-years.index') }}" aria-expanded="false">
                <i class="ti ti-calendar"></i>
                <span class="hide-menu">Tahun Ajaran</span>
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
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <div class="container-fluid p-0">
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @yield('content')
      </div>
    </div>
  </div>
  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
  <script src="{{ asset('assets/js/app.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Tambahkan JS datepicker -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  @yield('scripts')
</body>

</html>
