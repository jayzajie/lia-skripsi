@extends('layouts.admin')

@section('title', 'Detail Verifikasi')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <!-- Notifikasi Success -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="fas fa-check-circle me-2"></i>
          {!! session('success') !!}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Notifikasi Error -->
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="fas fa-exclamation-circle me-2"></i>
          {!! session('error') !!}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
          <h5 class="card-title fw-semibold">Detail Pendaftaran</h5>
          <div>
            <a href="{{ route('admin.verification.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('admin.verification.kartu', $konfirmasi) }}" class="btn btn-info text-white" target="_blank">🎫 Cetak Kartu</a>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal">Setujui</button>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">Tolak</button>
          </div>
        </div>

        <div class="row mb-4">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header bg-primary text-white">
                <h6 class="mb-0">Data Pribadi</h6>
              </div>
              <div class="card-body">
                @if($formulir)
                <table class="table table-bordered">
                  <tr>
                    <th width="35%">Nama Lengkap</th>
                    <td width="65%">{{ $formulir->nama_lengkap }}</td>
                  </tr>
                  <tr>
                    <th>NIK</th>
                    <td>{{ $formulir->nik }}</td>
                  </tr>
                  <tr>
                    <th>Tempat, Tanggal Lahir</th>
                    <td>{{ $formulir->tempat_lahir }}, {{ \Carbon\Carbon::parse($formulir->tanggal_lahir)->format('d F Y') }}</td>
                  </tr>
                  <tr>
                    <th>Jenis Kelamin</th>
                    <td>{{ $formulir->jenis_kelamin }}</td>
                  </tr>
                  <tr>
                    <th>Agama</th>
                    <td>{{ $formulir->agama }}</td>
                  </tr>
                  <tr>
                    <th>Alamat</th>
                    <td>{{ $formulir->alamat }}</td>
                  </tr>
                </table>
                @else
                <div class="alert alert-warning">
                  <h6>Data Formulir Tidak Ditemukan</h6>
                  <p>Data formulir pendaftaran untuk konfirmasi ini tidak ditemukan.</p>
                </div>
                @endif
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card">
              <div class="card-header bg-info text-white">
                <h6 class="mb-0">Data Orang Tua</h6>
              </div>
              <div class="card-body">
                @if($formulir)
                <table class="table table-bordered">
                  <tr>
                    <th width="35%">Nama Ayah</th>
                    <td width="65%">{{ $formulir->nama_ayah }}</td>
                  </tr>
                  <tr>
                    <th>Nama Ibu</th>
                    <td>{{ $formulir->nama_ibu }}</td>
                  </tr>
                  <tr>
                    <th>Pekerjaan Ayah</th>
                    <td>{{ $formulir->pekerjaan_ayah }}</td>
                  </tr>
                  <tr>
                    <th>Pekerjaan Ibu</th>
                    <td>{{ $formulir->pekerjaan_ibu }}</td>
                  </tr>
                  <tr>
                    <th>Alamat Orang Tua</th>
                    <td>{{ $formulir->alamat_ortu }}</td>
                  </tr>
                  <tr>
                    <th>No. Telp Orang Tua</th>
                    <td>{{ $formulir->no_telp_ortu }}</td>
                  </tr>
                </table>
                @else
                <div class="alert alert-warning">
                  <h6>Data Orang Tua Tidak Ditemukan</h6>
                  <p>Data orang tua untuk konfirmasi ini tidak ditemukan.</p>
                </div>
                @endif
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header bg-success text-white">
                <h6 class="mb-0">Berkas Pendaftaran</h6>
              </div>
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Jenis Berkas</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Kartu Keluarga</td>
                      <td>
                        @if(isset($berkas['kartu_keluarga']))
                          <span class="badge bg-success">Tersedia</span>
                        @else
                          <span class="badge bg-danger">Tidak Tersedia</span>
                        @endif
                      </td>
                      <td>
                        @if(isset($berkas['kartu_keluarga']))
                          <a href="{{ route('admin.verification.berkas.view', $berkas['kartu_keluarga']) }}" class="btn btn-sm btn-primary" target="_blank">Lihat</a>
                          <a href="{{ route('admin.verification.berkas.download', $berkas['kartu_keluarga']) }}" class="btn btn-sm btn-secondary">Download</a>
                        @else
                          -
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td>Akte Kelahiran</td>
                      <td>
                        @if(isset($berkas['akte_kelahiran']))
                          <span class="badge bg-success">Tersedia</span>
                        @else
                          <span class="badge bg-danger">Tidak Tersedia</span>
                        @endif
                      </td>
                      <td>
                        @if(isset($berkas['akte_kelahiran']))
                          <a href="{{ route('admin.verification.berkas.view', $berkas['akte_kelahiran']) }}" class="btn btn-sm btn-primary" target="_blank">Lihat</a>
                          <a href="{{ route('admin.verification.berkas.download', $berkas['akte_kelahiran']) }}" class="btn btn-sm btn-secondary">Download</a>
                        @else
                          -
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td>Pas Foto</td>
                      <td>
                        @if(isset($berkas['pas_foto']))
                          <span class="badge bg-success">Tersedia</span>
                        @else
                          <span class="badge bg-danger">Tidak Tersedia</span>
                        @endif
                      </td>
                      <td>
                        @if(isset($berkas['pas_foto']))
                          <a href="{{ route('admin.verification.berkas.view', $berkas['pas_foto']) }}" class="btn btn-sm btn-primary" target="_blank">Lihat</a>
                          <a href="{{ route('admin.verification.berkas.download', $berkas['pas_foto']) }}" class="btn btn-sm btn-secondary">Download</a>
                        @else
                          -
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td>KTP Orang Tua</td>
                      <td>
                        @if(isset($berkas['ktp_ortu']))
                          <span class="badge bg-success">Tersedia</span>
                        @else
                          <span class="badge bg-danger">Tidak Tersedia</span>
                        @endif
                      </td>
                      <td>
                        @if(isset($berkas['ktp_ortu']))
                          <a href="{{ route('admin.verification.berkas.view', $berkas['ktp_ortu']) }}" class="btn btn-sm btn-primary" target="_blank">Lihat</a>
                          <a href="{{ route('admin.verification.berkas.download', $berkas['ktp_ortu']) }}" class="btn btn-sm btn-secondary">Download</a>
                        @else
                          -
                        @endif
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="approveModalLabel">Setujui Pendaftaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.verification.approve', $konfirmasi) }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
          </div>
          <p>Yakin ingin menyetujui pendaftaran ini?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Setujui</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rejectModalLabel">Tolak Pendaftaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.verification.reject', $konfirmasi) }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="keterangan" class="form-label">Alasan Penolakan</label>
            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
          </div>
          <p>Yakin ingin menolak pendaftaran ini?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">Tolak</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
