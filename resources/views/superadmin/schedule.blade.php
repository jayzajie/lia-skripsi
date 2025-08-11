@extends('layouts.superadmin')

@section('title', 'Jadwal Pembelajaran - Super Admin')

@section('content')
    <div class="position-relative">
        <h1 class="welcome-header">Jadwal Pembelajaran</h1>
        <div class="notification-icon">
            <i class="fa-regular fa-bell">🔔</i>
        </div>
    </div>

    <div class="dashboard-card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Filter Jadwal</span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="kelas" class="form-label">Kelas</label>
                    <select class="form-select" id="kelas">
                        <option value="">Semua Kelas</option>
                        <option value="1">Kelas 1</option>
                        <option value="2">Kelas 2</option>
                        <option value="3">Kelas 3</option>
                        <option value="4">Kelas 4</option>
                        <option value="5">Kelas 5</option>
                        <option value="6">Kelas 6</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="hari" class="form-label">Hari</label>
                    <select class="form-select" id="hari">
                        <option value="">Semua Hari</option>
                        <option value="senin">Senin</option>
                        <option value="selasa">Selasa</option>
                        <option value="rabu">Rabu</option>
                        <option value="kamis">Kamis</option>
                        <option value="jumat">Jumat</option>
                        <option value="sabtu">Sabtu</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="guru" class="form-label">Guru</label>
                    <select class="form-select" id="guru">
                        <option value="">Semua Guru</option>
                        <option value="1">Budi Setiawan, S.Pd</option>
                        <option value="2">Siti Aminah, S.Pd</option>
                        <option value="3">Ahmad Kosasih, S.Pd</option>
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button class="btn btn-primary me-2">Terapkan Filter</button>
                <button class="btn btn-outline-secondary">Reset</button>
            </div>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Jadwal Pembelajaran</span>
            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addScheduleModal">+ Tambah Jadwal</button>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="scheduleTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="senin-tab" data-bs-toggle="tab" data-bs-target="#senin" type="button" role="tab" aria-controls="senin" aria-selected="true">Senin</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="selasa-tab" data-bs-toggle="tab" data-bs-target="#selasa" type="button" role="tab" aria-controls="selasa" aria-selected="false">Selasa</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="rabu-tab" data-bs-toggle="tab" data-bs-target="#rabu" type="button" role="tab" aria-controls="rabu" aria-selected="false">Rabu</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="kamis-tab" data-bs-toggle="tab" data-bs-target="#kamis" type="button" role="tab" aria-controls="kamis" aria-selected="false">Kamis</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="jumat-tab" data-bs-toggle="tab" data-bs-target="#jumat" type="button" role="tab" aria-controls="jumat" aria-selected="false">Jumat</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="sabtu-tab" data-bs-toggle="tab" data-bs-target="#sabtu" type="button" role="tab" aria-controls="sabtu" aria-selected="false">Sabtu</button>
                </li>
            </ul>
            <div class="tab-content" id="scheduleTabContent">
                <div class="tab-pane fade show active" id="senin" role="tabpanel" aria-labelledby="senin-tab">
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-light">
                                    <th width="10%">Jam</th>
                                    <th>Kelas 1</th>
                                    <th>Kelas 2</th>
                                    <th>Kelas 3</th>
                                    <th>Kelas 4</th>
                                    <th>Kelas 5</th>
                                    <th>Kelas 6</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>07:30 - 08:10</td>
                                    <td>
                                        <div class="schedule-item">
                                            <div class="subject">Matematika</div>
                                            <div class="teacher">Budi Setiawan, S.Pd</div>
                                            <div class="actions">
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editScheduleModal">Edit</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="schedule-item">
                                            <div class="subject">Bahasa Indonesia</div>
                                            <div class="teacher">Siti Aminah, S.Pd</div>
                                            <div class="actions">
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editScheduleModal">Edit</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="schedule-item">
                                            <div class="subject">IPA</div>
                                            <div class="teacher">Ahmad Kosasih, S.Pd</div>
                                            <div class="actions">
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editScheduleModal">Edit</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="schedule-item">
                                            <div class="subject">IPS</div>
                                            <div class="teacher">Budi Setiawan, S.Pd</div>
                                            <div class="actions">
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editScheduleModal">Edit</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="schedule-item">
                                            <div class="subject">Pendidikan Agama</div>
                                            <div class="teacher">Siti Aminah, S.Pd</div>
                                            <div class="actions">
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editScheduleModal">Edit</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="schedule-item">
                                            <div class="subject">PJOK</div>
                                            <div class="teacher">Ahmad Kosasih, S.Pd</div>
                                            <div class="actions">
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editScheduleModal">Edit</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>08:10 - 08:50</td>
                                    <td>
                                        <div class="schedule-item">
                                            <div class="subject">Matematika</div>
                                            <div class="teacher">Budi Setiawan, S.Pd</div>
                                            <div class="actions">
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editScheduleModal">Edit</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="schedule-item">
                                            <div class="subject">Bahasa Indonesia</div>
                                            <div class="teacher">Siti Aminah, S.Pd</div>
                                            <div class="actions">
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editScheduleModal">Edit</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="schedule-item">
                                            <div class="subject">IPA</div>
                                            <div class="teacher">Ahmad Kosasih, S.Pd</div>
                                            <div class="actions">
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editScheduleModal">Edit</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="schedule-item">
                                            <div class="subject">IPS</div>
                                            <div class="teacher">Budi Setiawan, S.Pd</div>
                                            <div class="actions">
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editScheduleModal">Edit</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="schedule-item">
                                            <div class="subject">Pendidikan Agama</div>
                                            <div class="teacher">Siti Aminah, S.Pd</div>
                                            <div class="actions">
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editScheduleModal">Edit</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="schedule-item">
                                            <div class="subject">PJOK</div>
                                            <div class="teacher">Ahmad Kosasih, S.Pd</div>
                                            <div class="actions">
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editScheduleModal">Edit</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>08:50 - 09:30</td>
                                    <td>
                                        <div class="schedule-item">
                                            <div class="subject">Bahasa Indonesia</div>
                                            <div class="teacher">Siti Aminah, S.Pd</div>
                                            <div class="actions">
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editScheduleModal">Edit</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="schedule-item">
                                            <div class="subject">IPA</div>
                                            <div class="teacher">Ahmad Kosasih, S.Pd</div>
                                            <div class="actions">
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editScheduleModal">Edit</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="schedule-item">
                                            <div class="subject">Matematika</div>
                                            <div class="teacher">Budi Setiawan, S.Pd</div>
                                            <div class="actions">
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editScheduleModal">Edit</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="schedule-item">
                                            <div class="subject">Pendidikan Agama</div>
                                            <div class="teacher">Siti Aminah, S.Pd</div>
                                            <div class="actions">
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editScheduleModal">Edit</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="schedule-item">
                                            <div class="subject">PJOK</div>
                                            <div class="teacher">Ahmad Kosasih, S.Pd</div>
                                            <div class="actions">
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editScheduleModal">Edit</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="schedule-item">
                                            <div class="subject">IPS</div>
                                            <div class="teacher">Budi Setiawan, S.Pd</div>
                                            <div class="actions">
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editScheduleModal">Edit</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="selasa" role="tabpanel" aria-labelledby="selasa-tab">
                    <div class="p-3 text-center">
                        <p>Jadwal hari Selasa akan ditampilkan di sini.</p>
                    </div>
                </div>
                <div class="tab-pane fade" id="rabu" role="tabpanel" aria-labelledby="rabu-tab">
                    <div class="p-3 text-center">
                        <p>Jadwal hari Rabu akan ditampilkan di sini.</p>
                    </div>
                </div>
                <div class="tab-pane fade" id="kamis" role="tabpanel" aria-labelledby="kamis-tab">
                    <div class="p-3 text-center">
                        <p>Jadwal hari Kamis akan ditampilkan di sini.</p>
                    </div>
                </div>
                <div class="tab-pane fade" id="jumat" role="tabpanel" aria-labelledby="jumat-tab">
                    <div class="p-3 text-center">
                        <p>Jadwal hari Jumat akan ditampilkan di sini.</p>
                    </div>
                </div>
                <div class="tab-pane fade" id="sabtu" role="tabpanel" aria-labelledby="sabtu-tab">
                    <div class="p-3 text-center">
                        <p>Jadwal hari Sabtu akan ditampilkan di sini.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Jadwal -->
    <div class="modal fade" id="addScheduleModal" tabindex="-1" aria-labelledby="addScheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addScheduleModalLabel">Tambah Jadwal Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('superadmin.schedules.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="day" class="form-label">Hari</label>
                            <select class="form-select" id="day" name="day" required>
                                <option value="">Pilih Hari</option>
                                <option value="senin">Senin</option>
                                <option value="selasa">Selasa</option>
                                <option value="rabu">Rabu</option>
                                <option value="kamis">Kamis</option>
                                <option value="jumat">Jumat</option>
                                <option value="sabtu">Sabtu</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="class" class="form-label">Kelas</label>
                            <select class="form-select" id="class" name="class" required>
                                <option value="">Pilih Kelas</option>
                                <option value="1">Kelas 1</option>
                                <option value="2">Kelas 2</option>
                                <option value="3">Kelas 3</option>
                                <option value="4">Kelas 4</option>
                                <option value="5">Kelas 5</option>
                                <option value="6">Kelas 6</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="start_time" class="form-label">Jam Mulai</label>
                            <input type="time" class="form-control" id="start_time" name="start_time" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_time" class="form-label">Jam Selesai</label>
                            <input type="time" class="form-control" id="end_time" name="end_time" required>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Mata Pelajaran</label>
                            <select class="form-select" id="subject" name="subject" required>
                                <option value="">Pilih Mata Pelajaran</option>
                                <option value="Matematika">Matematika</option>
                                <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                                <option value="IPA">IPA</option>
                                <option value="IPS">IPS</option>
                                <option value="Pendidikan Agama">Pendidikan Agama</option>
                                <option value="PJOK">PJOK</option>
                                <option value="SBdP">SBdP</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="teacher" class="form-label">Guru</label>
                            <select class="form-select" id="teacher" name="teacher" required>
                                <option value="">Pilih Guru</option>
                                <option value="1">Budi Setiawan, S.Pd</option>
                                <option value="2">Siti Aminah, S.Pd</option>
                                <option value="3">Ahmad Kosasih, S.Pd</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Jadwal -->
    <div class="modal fade" id="editScheduleModal" tabindex="-1" aria-labelledby="editScheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editScheduleModalLabel">Edit Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editScheduleForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-day" class="form-label">Hari</label>
                            <select class="form-select" id="edit-day" name="day" required>
                                <option value="senin">Senin</option>
                                <option value="selasa">Selasa</option>
                                <option value="rabu">Rabu</option>
                                <option value="kamis">Kamis</option>
                                <option value="jumat">Jumat</option>
                                <option value="sabtu">Sabtu</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit-class" class="form-label">Kelas</label>
                            <select class="form-select" id="edit-class" name="class" required>
                                <option value="1">Kelas 1</option>
                                <option value="2">Kelas 2</option>
                                <option value="3">Kelas 3</option>
                                <option value="4">Kelas 4</option>
                                <option value="5">Kelas 5</option>
                                <option value="6">Kelas 6</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit-start-time" class="form-label">Jam Mulai</label>
                            <input type="time" class="form-control" id="edit-start-time" name="start_time" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-end-time" class="form-label">Jam Selesai</label>
                            <input type="time" class="form-control" id="edit-end-time" name="end_time" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-subject" class="form-label">Mata Pelajaran</label>
                            <select class="form-select" id="edit-subject" name="subject" required>
                                <option value="Matematika">Matematika</option>
                                <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                                <option value="IPA">IPA</option>
                                <option value="IPS">IPS</option>
                                <option value="Pendidikan Agama">Pendidikan Agama</option>
                                <option value="PJOK">PJOK</option>
                                <option value="SBdP">SBdP</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit-teacher" class="form-label">Guru</label>
                            <select class="form-select" id="edit-teacher" name="teacher" required>
                                <option value="1">Budi Setiawan, S.Pd</option>
                                <option value="2">Siti Aminah, S.Pd</option>
                                <option value="3">Ahmad Kosasih, S.Pd</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Edit Schedule Modal
    document.querySelectorAll('[data-bs-target="#editScheduleModal"]').forEach(button => {
        button.addEventListener('click', function() {
            // Dalam implementasi nyata, data ini akan diambil dari atribut data
            // Contoh data dummy untuk demo
            document.getElementById('edit-day').value = 'senin';
            document.getElementById('edit-class').value = '5';
            document.getElementById('edit-start-time').value = '07:30';
            document.getElementById('edit-end-time').value = '08:10';
            document.getElementById('edit-subject').value = 'Matematika';
            document.getElementById('edit-teacher').value = '1';
            
            // Set action form
            const form = document.getElementById('editScheduleForm');
            form.action = `/superadmin/schedules/1`;
        });
    });
</script>
@endsection 