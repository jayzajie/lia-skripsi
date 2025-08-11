@extends('layouts.admin')

@section('title', 'Verifikasi Data Siswa Baru')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Verifikasi Data Siswa Baru</h5>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="fas fa-check-circle me-2"></i>
          {!! session('success') !!}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="fas fa-exclamation-circle me-2"></i>
          {!! session('error') !!}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="fas fa-exclamation-triangle me-2"></i>
          <strong>Terjadi kesalahan:</strong>
          <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Keterangan</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($pendingVerifications as $key => $konfirmasi)
              @php
                // Cari di formulir sementara dulu, jika tidak ada cari di formulir final
                $formulir = \App\Models\FormulirSementara::where('user_id', $konfirmasi->user_id)->first();
                if (!$formulir) {
                    $formulir = \App\Models\Formulir::where('user_id', $konfirmasi->user_id)->latest()->first();
                }
              @endphp
              <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $formulir ? $formulir->nama_lengkap : 'Data tidak ditemukan' }}</td>
                <td>{{ $formulir ? $formulir->jenis_kelamin : '-' }}</td>
                <td>Data Lengkap</td>
                <td>
                  <div class="form-check form-check-inline">
                    <form action="{{ route('admin.verification.approve', $konfirmasi) }}" method="POST">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-success">Diterima</button>
                    </form>
                  </div>
                  <div class="form-check form-check-inline">
                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $konfirmasi->id }}">Ditolak</button>
                  </div>
                  <a href="{{ route('admin.verification.show', $konfirmasi) }}" class="btn btn-sm btn-info text-white">Detail</a>
                  <a href="{{ route('admin.verification.kartu', $konfirmasi) }}" class="btn btn-sm btn-warning text-white" target="_blank">🎫 Kartu</a>
                </td>
              </tr>

              <!-- Reject Modal -->
              <div class="modal fade" id="rejectModal{{ $konfirmasi->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $konfirmasi->id }}" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="rejectModalLabel{{ $konfirmasi->id }}">Tolak Pendaftaran</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.verification.reject', $konfirmasi) }}" method="POST">
                      @csrf
                      <div class="modal-body">
                        <div class="mb-3">
                          <label for="keterangan" class="form-label">Alasan Penolakan</label>
                          <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Tolak</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              @empty
              <tr>
                <td colspan="5" class="text-center">Tidak ada data yang perlu diverifikasi</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="text-end mt-3">
          <button class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
