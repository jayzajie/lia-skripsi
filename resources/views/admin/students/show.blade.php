@extends('layouts.admin')

@section('title', 'Detail Siswa')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h5 class="card-title fw-semibold">Detail Siswa</h5>
          <div>
            <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('admin.students.edit', $formulir) }}" class="btn btn-warning">Edit</a>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Hapus</button>
          </div>
        </div>
        
        <div class="row mb-4">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header bg-primary text-white">
                <h6 class="mb-0">Data Pribadi</h6>
              </div>
              <div class="card-body">
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
                  <tr>
                    <th>Status Pendaftaran</th>
                    <td>
                      <span class="badge bg-success">Diterima</span>
                      <p class="text-muted small mt-1 mb-0">{{ $formulir->approved_at ? \Carbon\Carbon::parse($formulir->approved_at)->format('d M Y H:i') : '' }}</p>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="card">
              <div class="card-header bg-info text-white">
                <h6 class="mb-0">Data Orang Tua</h6>
              </div>
              <div class="card-body">
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
                          <a href="{{ Storage::url($berkas['kartu_keluarga']->file_path) }}" class="btn btn-sm btn-primary" target="_blank">Lihat</a>
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
                          <a href="{{ Storage::url($berkas['akte_kelahiran']->file_path) }}" class="btn btn-sm btn-primary" target="_blank">Lihat</a>
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
                          <a href="{{ Storage::url($berkas['pas_foto']->file_path) }}" class="btn btn-sm btn-primary" target="_blank">Lihat</a>
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
                          <a href="{{ Storage::url($berkas['ktp_ortu']->file_path) }}" class="btn btn-sm btn-primary" target="_blank">Lihat</a>
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

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Apakah Anda yakin ingin menghapus data siswa <strong>{{ $formulir->nama_lengkap }}</strong>?</p>
        <p class="text-danger">Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <form action="{{ route('admin.students.destroy', $formulir) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection 