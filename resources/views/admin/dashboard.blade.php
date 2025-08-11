@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row m-0">
  <div class="col-12 p-0">
    <div class="card w-100 border-0">
      <div class="card-body p-4">
        <h1 class="card-title fs-1 fw-bold mb-4">Selamat Datang !</h1>
        
        <div class="mb-4">
          <h5 class="mb-3">Pemberitahuan</h5>
          <div class="d-flex align-items-center bg-light p-3 rounded">
            <div class="d-flex align-items-center justify-content-center bg-success text-white rounded" style="width: 60px; height: 60px;">
              <h3 class="mb-0 fw-bold">{{ $pendingVerification }}</h3>
            </div>
            <div class="ms-3">
              <div>Verifikasi Data Masuk</div>
              <a href="{{ route('admin.verification.index') }}" class="btn btn-sm btn-primary mt-2">Lihat Data</a>
            </div>
          </div>
        </div>
        
        <div>
          <h5 class="mb-3">Data</h5>
          <div class="row">
            <div class="col-md-4">
              <div class="card bg-light text-center p-3">
                <div class="d-flex flex-column align-items-center">
                  <h1 class="mb-0 fw-bold text-primary">{{ $totalStudents }}</h1>
                  <p class="mb-0 text-muted">Jumlah Siswa Mendaftar</p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card bg-light text-center p-3">
                <div class="d-flex flex-column align-items-center">
                  <h1 class="mb-0 fw-bold text-primary">{{ $maleStudents }}</h1>
                  <p class="mb-0 text-muted">Siswa Laki Laki</p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card bg-light text-center p-3">
                <div class="d-flex flex-column align-items-center">
                  <h1 class="mb-0 fw-bold text-primary">{{ $femaleStudents }}</h1>
                  <p class="mb-0 text-muted">Siswa Perempuan</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection 