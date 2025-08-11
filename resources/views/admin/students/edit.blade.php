@extends('layouts.admin')

@section('title', 'Edit Data Siswa')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h5 class="card-title fw-semibold">Edit Data Siswa</h5>
          <a href="{{ route('admin.students.show', $formulir) }}" class="btn btn-secondary">Kembali</a>
        </div>
        
        <form action="{{ route('admin.students.update', $formulir) }}" method="POST">
          @csrf
          @method('PUT')
          
          <div class="row mb-4">
            <div class="col-md-6">
              <div class="card">
                <div class="card-header bg-primary text-white">
                  <h6 class="mb-0">Data Pribadi</h6>
                </div>
                <div class="card-body">
                  <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $formulir->nama_lengkap) }}" required>
                    @error('nama_lengkap')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  
                  <div class="mb-3">
                    <label for="nik" class="form-label">NIK</label>
                    <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik', $formulir->nik) }}" required>
                    @error('nik')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  
                  <div class="mb-3">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $formulir->tempat_lahir) }}" required>
                    @error('tempat_lahir')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  
                  <div class="mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $formulir->tanggal_lahir) }}" required>
                    @error('tanggal_lahir')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  
                  <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                      <option value="">Pilih Jenis Kelamin</option>
                      <option value="Laki-Laki" {{ old('jenis_kelamin', $formulir->jenis_kelamin) == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                      <option value="Perempuan" {{ old('jenis_kelamin', $formulir->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  
                  <div class="mb-3">
                    <label for="agama" class="form-label">Agama</label>
                    <select class="form-select @error('agama') is-invalid @enderror" id="agama" name="agama" required>
                      <option value="">Pilih Agama</option>
                      <option value="Islam" {{ old('agama', $formulir->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                      <option value="Kristen" {{ old('agama', $formulir->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                      <option value="Katolik" {{ old('agama', $formulir->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                      <option value="Hindu" {{ old('agama', $formulir->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                      <option value="Buddha" {{ old('agama', $formulir->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                      <option value="Konghucu" {{ old('agama', $formulir->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                    @error('agama')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  
                  <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $formulir->alamat) }}</textarea>
                    @error('alamat')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="card">
                <div class="card-header bg-info text-white">
                  <h6 class="mb-0">Data Orang Tua</h6>
                </div>
                <div class="card-body">
                  <div class="mb-3">
                    <label for="nama_ayah" class="form-label">Nama Ayah</label>
                    <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror" id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah', $formulir->nama_ayah) }}" required>
                    @error('nama_ayah')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  
                  <div class="mb-3">
                    <label for="nama_ibu" class="form-label">Nama Ibu</label>
                    <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror" id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu', $formulir->nama_ibu) }}" required>
                    @error('nama_ibu')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  
                  <div class="mb-3">
                    <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
                    <input type="text" class="form-control @error('pekerjaan_ayah') is-invalid @enderror" id="pekerjaan_ayah" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $formulir->pekerjaan_ayah) }}" required>
                    @error('pekerjaan_ayah')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  
                  <div class="mb-3">
                    <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
                    <input type="text" class="form-control @error('pekerjaan_ibu') is-invalid @enderror" id="pekerjaan_ibu" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $formulir->pekerjaan_ibu) }}" required>
                    @error('pekerjaan_ibu')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  
                  <div class="mb-3">
                    <label for="alamat_ortu" class="form-label">Alamat Orang Tua</label>
                    <textarea class="form-control @error('alamat_ortu') is-invalid @enderror" id="alamat_ortu" name="alamat_ortu" rows="3" required>{{ old('alamat_ortu', $formulir->alamat_ortu) }}</textarea>
                    @error('alamat_ortu')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  
                  <div class="mb-3">
                    <label for="no_telp_ortu" class="form-label">No. Telp Orang Tua</label>
                    <input type="text" class="form-control @error('no_telp_ortu') is-invalid @enderror" id="no_telp_ortu" name="no_telp_ortu" value="{{ old('no_telp_ortu', $formulir->no_telp_ortu) }}" required>
                    @error('no_telp_ortu')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="text-end">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection 