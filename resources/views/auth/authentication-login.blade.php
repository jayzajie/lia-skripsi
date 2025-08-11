@extends('layouts.auth')

@section('content')
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden text-bg-light min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="text-center mb-4">
              <div class="mb-3">
                <img src="../images/logo.png" alt="SD Normal Islam 2 Samarinda" style="width: 150px; height: auto;" />
              </div>
              <p style="color: var(--primary); font-weight: 900;">TAHUN AJARAN {{ $activeAcademicYear }}</p>
              <h2 style="color: var(--primary-dark); font-weight: 700;">SD NORMAL ISLAM 2</h2>
              <p style="color: var(--primary); font-weight: 500;">SAMARINDA</p>
            </div>
            <div class="card mb-0">
              <div class="card-body">
                <p class="text-center" style="color: var(--accent); font-weight: 600;">Masuk ke Akun Anda</p>
                <form method="POST" action="{{ route('login') }}">
                  @csrf
                  <div class="mb-3">
                    <label for="login" class="form-label">Email atau Nomor Telepon</label>
                    <input type="text" name="login" class="form-control @error('login') is-invalid @enderror @error('email') is-invalid @enderror" id="login" value="{{ old('login') }}" required autofocus>
                    @error('login')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                      <input class="form-check-input primary" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                      <label class="form-check-label text-dark" for="remember">
                        Ingat Saya
                      </label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="text-primary fw-bold" href="{{ route('password.request') }}">Lupa Password?</a>
                    @endif
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Masuk</button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">Belum punya akun?</p>
                    <a class="text-primary fw-bold ms-2" href="{{ route('register') }}">Daftar</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection