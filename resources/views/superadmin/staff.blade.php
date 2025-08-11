@extends('layouts.superadmin')

@section('title', 'Data Pegawai - Super Admin')

@section('content')
    <div class="position-relative">
        <h1 class="welcome-header">Data Pegawai</h1>
        <div class="notification-icon">
            <i class="fa-regular fa-bell">🔔</i>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Daftar Pegawai</span>
            <a href="{{ route('superadmin.staff.create') }}" class="btn btn-sm btn-success">+ Tambah Pegawai</a>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <select class="form-select">
                        <option value="">Pilih Jabatan</option>
                        <option value="guru">Guru</option>
                        <option value="staff_tu">Staff TU</option>
                        <option value="kepala_sekolah">Kepala Sekolah</option>
                        <option value="wakil_kepala_sekolah">Wakil Kepala Sekolah</option>
                        <option value="wali_kelas">Wali Kelas</option>
                        <option value="guru_bidang">Guru Bidang</option>
                        <option value="guru_tpq">Guru TPQ</option>
                        <option value="keamanan">Keamanan</option>
                        <option value="kebersihan">Kebersihan</option>
                        <option value="wakar">Wakar</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select">
                        <option value="">Status</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari pegawai...">
                        <button class="btn btn-primary" type="button">Cari</button>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100">Reset</button>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Jenis Kelamin</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>198501152010011001</td>
                            <td>Budi Setiawan, S.Pd</td>
                            <td>Guru</td>
                            <td>Laki-laki</td>
                            <td>budi.setiawan@example.com</td>
                            <td>081234567890</td>
                            <td><span class="badge bg-success">Aktif</span></td>
                            <td>
                                <a href="{{ route('superadmin.staff.show', 1) }}" class="btn btn-sm btn-info">Detail</a>
                                <a href="{{ route('superadmin.staff.edit', 1) }}" class="btn btn-sm btn-warning">Edit</a>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteStaffModal" data-id="1" data-name="Budi Setiawan, S.Pd">Hapus</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>198703212011012002</td>
                            <td>Siti Aminah, S.Pd</td>
                            <td>Guru</td>
                            <td>Perempuan</td>
                            <td>siti.aminah@example.com</td>
                            <td>081234567891</td>
                            <td><span class="badge bg-success">Aktif</span></td>
                            <td>
                                <a href="{{ route('superadmin.staff.show', 2) }}" class="btn btn-sm btn-info">Detail</a>
                                <a href="{{ route('superadmin.staff.edit', 2) }}" class="btn btn-sm btn-warning">Edit</a>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteStaffModal" data-id="2" data-name="Siti Aminah, S.Pd">Hapus</button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>198605102010011003</td>
                            <td>Ahmad Kosasih, S.Pd</td>
                            <td>Guru</td>
                            <td>Laki-laki</td>
                            <td>ahmad.kosasih@example.com</td>
                            <td>081234567892</td>
                            <td><span class="badge bg-success">Aktif</span></td>
                            <td>
                                <a href="{{ route('superadmin.staff.show', 3) }}" class="btn btn-sm btn-info">Detail</a>
                                <a href="{{ route('superadmin.staff.edit', 3) }}" class="btn btn-sm btn-warning">Edit</a>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteStaffModal" data-id="3" data-name="Ahmad Kosasih, S.Pd">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Sebelumnya</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Selanjutnya</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Pegawai -->
    <div class="modal fade" id="deleteStaffModal" tabindex="-1" aria-labelledby="deleteStaffModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteStaffModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data pegawai <strong id="delete-staff-name"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteStaffForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Delete Staff Modal
    document.querySelectorAll('[data-bs-target="#deleteStaffModal"]').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            
            document.getElementById('delete-staff-name').textContent = name;
            
            const form = document.getElementById('deleteStaffForm');
            form.action = `/superadmin/staff/${id}`;
        });
    });
</script>
@endsection 