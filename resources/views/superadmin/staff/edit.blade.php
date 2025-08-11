@extends('layouts.superadmin')

@section('title', 'Edit Pegawai - Super Admin')

@section('content')
    <div class="position-relative">
        <h1 class="welcome-header">Edit Data Pegawai</h1>
        <div class="notification-icon">
            <i class="fa-regular fa-bell">🔔</i>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Form Edit Pegawai</span>
            <a href="{{ route('superadmin.staff.index') }}" class="btn btn-sm btn-secondary">
                Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('superadmin.staff.update', $staff->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" value="{{ old('nip', $staff->nip) }}">
                        @error('nip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $staff->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="position" class="form-label">Jabatan <span class="text-danger">*</span></label>
                        <select class="form-select @error('position') is-invalid @enderror" id="position" name="position" required>
                            <option value="">Pilih Jabatan</option>
                            <option value="Guru" {{ old('position', $staff->position) == 'Guru' ? 'selected' : '' }}>Guru</option>
                            <option value="Staff TU" {{ old('position', $staff->position) == 'Staff TU' ? 'selected' : '' }}>Staff TU</option>
                            <option value="Kepala Sekolah" {{ old('position', $staff->position) == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                            <option value="Wakil Kepala Sekolah" {{ old('position', $staff->position) == 'Wakil Kepala Sekolah' ? 'selected' : '' }}>Wakil Kepala Sekolah</option>
                            <option value="Wali Kelas" {{ old('position', $staff->position) == 'Wali Kelas' ? 'selected' : '' }}>Wali Kelas</option>
                            <option value="Guru Bidang" {{ old('position', $staff->position) == 'Guru Bidang' ? 'selected' : '' }}>Guru Bidang</option>
                            <option value="Guru TPQ" {{ old('position', $staff->position) == 'Guru TPQ' ? 'selected' : '' }}>Guru TPQ</option>
                            <option value="Keamanan" {{ old('position', $staff->position) == 'Keamanan' ? 'selected' : '' }}>Keamanan</option>
                            <option value="Kebersihan" {{ old('position', $staff->position) == 'Kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                            <option value="Wakar" {{ old('position', $staff->position) == 'Wakar' ? 'selected' : '' }}>Wakar</option>
                        </select>
                        @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="gender" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="male" {{ old('gender', $staff->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="female" {{ old('gender', $staff->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $staff->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">No. Telepon</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $staff->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="birth_place" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control @error('birth_place') is-invalid @enderror" id="birth_place" name="birth_place" value="{{ old('birth_place', $staff->birth_place) }}">
                        @error('birth_place')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="birth_date" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ old('birth_date', $staff->birth_date) }}">
                        @error('birth_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="religion" class="form-label">Agama</label>
                        <select class="form-select @error('religion') is-invalid @enderror" id="religion" name="religion">
                            <option value="">Pilih Agama</option>
                            <option value="Islam" {{ old('religion', $staff->religion) == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('religion', $staff->religion) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('religion', $staff->religion) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('religion', $staff->religion) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('religion', $staff->religion) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ old('religion', $staff->religion) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </select>
                        @error('religion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="join_year" class="form-label">Tahun Bergabung</label>
                        <input type="number" class="form-control @error('join_year') is-invalid @enderror" id="join_year" name="join_year" value="{{ old('join_year', $staff->join_year) }}" min="1900" max="{{ date('Y') }}">
                        @error('join_year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $staff->address) }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-9 mb-3">
                        <label for="photo" class="form-label">Foto</label>
                        <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        @if($staff->photo)
                            <img src="{{ asset('storage/' . $staff->photo) }}" alt="Current Photo" class="img-thumbnail" style="max-height: 100px;">
                        @endif
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $staff->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('superadmin.staff.show', $staff->id) }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection 