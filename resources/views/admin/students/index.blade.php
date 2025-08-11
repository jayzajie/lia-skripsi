    @extends('layouts.admin')

    @section('title', 'Data Siswa Terdaftar')

    @section('content')
    <div class="row">
    <div class="col-12">
        <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title fw-semibold">Data Siswa Terdaftar</h5>
            <div class="input-group" style="width: 300px;">
                <input type="text" class="form-control" placeholder="Cari siswa..." id="searchInput">
                <button class="btn btn-primary" type="button" id="searchButton">Cari</button>
            </div>
            </div>

            <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($students as $key => $student)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $student->nama_lengkap }}</td>
                    <td>{{ $student->nik }}</td>
                    <td>{{ $student->tempat_lahir }}</td>
                    <td>{{ \Carbon\Carbon::parse($student->tanggal_lahir)->format('d/m/Y') }}</td>
                    <td>{{ $student->jenis_kelamin }}</td>
                    <td>{{ Str::limit($student->alamat, 50) }}</td>
                    <td>
                    <span class="badge bg-{{ $student->status == 'verified' ? 'success' : 'warning' }}">
                        {{ $student->status == 'verified' ? 'Terverifikasi' : 'Menunggu' }}
                    </span>
                    </td>
                    <td>
                    <a href="{{ route('admin.students.show', $student) }}" class="btn btn-sm btn-info text-white">Detail</a>
                    <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sm btn-warning">Edit</a>
                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $student->id }}">Hapus</button>
                    </td>
                </tr>

              <!-- Delete Modal -->
              <div class="modal fade" id="deleteModal{{ $student->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $student->id }}" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="deleteModalLabel{{ $student->id }}">Konfirmasi Hapus Data</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <p>Apakah Anda yakin ingin menghapus data siswa <strong>{{ $student->nama_lengkap }}</strong>?</p>
                      <p class="text-danger">Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                      <form action="{{ route('admin.students.destroy', $student) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              @empty
              <tr>
                <td colspan="9" class="text-center">Tidak ada data siswa terdaftar</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Pagination jika diperlukan -->
        @if($students->hasPages())
        <div class="d-flex justify-content-center mt-4">
          {{ $students->links('pagination::bootstrap-4') }}
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  // Fungsi pencarian sederhana
  document.getElementById('searchButton').addEventListener('click', function() {
    const searchValue = document.getElementById('searchInput').value;
    window.location.href = '{{ route("admin.students.index") }}?search=' + searchValue;
  });

  // Pencarian dengan tombol Enter
  document.getElementById('searchInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
      const searchValue = document.getElementById('searchInput').value;
      window.location.href = '{{ route("admin.students.index") }}?search=' + searchValue;
    }
  });
</script>
@endsection
