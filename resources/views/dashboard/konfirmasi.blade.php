<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>Konfirmasi Pendaftaran - SD Normal Islam 2 Samarinda</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <link rel="stylesheet" href="../assets/css/dashboard-custom.css" />
  <style>
    /* Custom Logo Style */
    .centered-logo {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 10px 0 5px 0; /* Mengurangi padding bawah */
      margin-bottom: 0; /* Menghilangkan margin bawah */
    }

    .centered-logo .logo-img {
      text-align: center;
      width: 100%;
    }

    .centered-logo .logo-img img {
      max-height: 150px; /* Ukuran logo yang diminta */
      width: auto;
    }
  </style>
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <div class="scroll-sidebar" style="height: 100%;">
        <div class="centered-logo">
          <div class="logo-img">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Sekolah" />
          </div>
        </div>
        <div class="d-flex justify-content-end d-xl-none">
          <button id="sidebarCollapse" class="btn btn-sm btn-light-primary">
            <i class="ti ti-x"></i>
          </button>
        </div>
        <nav class="sidebar-nav">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Menu</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
                <span><i class="ti ti-home"></i></span>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('formulir.index') }}" aria-expanded="false">
                <span><i class="ti ti-file-text"></i></span>
                <span class="hide-menu">Formulir Pendaftaran</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('berkas.index') }}" aria-expanded="false">
                <span><i class="ti ti-files"></i></span>
                <span class="hide-menu">Upload Berkas</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link active" href="{{ route('konfirmasi.index') }}" aria-expanded="false">
                <span><i class="ti ti-receipt"></i></span>
                <span class="hide-menu">Konfirmasi Pembayaran</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('pengumuman.index') }}" aria-expanded="false">
                <span><i class="ti ti-bell"></i></span>
                <span class="hide-menu">Pengumuman</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Akun</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('profile.edit') }}" aria-expanded="false">
                <span><i class="ti ti-user-circle"></i></span>
                <span class="hide-menu">Profil</span>
              </a>
            </li>
            <li class="sidebar-item">
              <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <a class="sidebar-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" aria-expanded="false">
                  <span><i class="ti ti-logout"></i></span>
                  <span class="hide-menu">Logout</span>
                </a>
              </form>
            </li>
          </ul>
        </nav>
      </div>
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <div class="container-fluid p-0">
        <!--  Row 1 -->
        <div class="row m-0">
          <div class="col-12 p-0">
            <div class="card w-100 border-0">
              <div class="card-body p-4">
                <h1 class="card-title fs-1 fw-bold mb-4">Status Pendaftaran</h1>

                <!-- Status Pendaftaran -->
                @if(isset($statusKonfirmasi))
                  @if($statusKonfirmasi->status == 'approved')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <i class="fas fa-check-circle me-2"></i>
                      <strong>🎉 SELAMAT! Pendaftaran Anda telah DISETUJUI</strong><br>
                      @if($statusKonfirmasi->keterangan)
                        <small>Keterangan: {{ $statusKonfirmasi->keterangan }}</small>
                      @endif
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                  @elseif($statusKonfirmasi->status == 'rejected')
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <i class="fas fa-times-circle me-2"></i>
                      <strong>❌ Pendaftaran Anda telah DITOLAK</strong><br>
                      @if($statusKonfirmasi->keterangan)
                        <strong>Alasan:</strong> {{ $statusKonfirmasi->keterangan }}
                      @endif
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                  @elseif($statusKonfirmasi->status == 'pending')
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                      <i class="fas fa-clock me-2"></i>
                      <strong>⏳ Pendaftaran Anda sedang dalam proses VERIFIKASI</strong><br>
                      <small>Mohon tunggu konfirmasi dari admin. Anda akan mendapat notifikasi setelah proses verifikasi selesai.</small>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                  @endif
                @endif

                @if(session('success'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                @endif

                @if(session('error'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                @endif

                @if($errors->any())
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong>
                    <ul class="mb-0">
                      @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                @endif

                <div class="form-container p-4 bg-light rounded">
                  <div class="alert alert-warning mb-4">
                    <h5 class="alert-heading">Perhatian!</h5>
                    <p class="mb-0">Pastikan semua data dan berkas telah dilengkapi sebelum melakukan konfirmasi pendaftaran.</p>
                  </div>

                  @php
                    use App\Models\BerkasSementara;
                    $jenisBerkasWajib = [
                        'kartu_keluarga' => 'Kartu Keluarga',
                        'akte_kelahiran' => 'Akta Kelahiran',
                        'pas_foto' => 'Pas Foto 3x4',
                        'ktp_ortu' => 'KTP Orang Tua',
                    ];
                    $userBerkasSementara = BerkasSementara::where('user_id', Auth::id())->get()->keyBy('jenis_berkas');
                  @endphp

                  <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                      <h5 class="mb-0">Status Kelengkapan Dokumen</h5>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th>Dokumen</th>
                              <th>Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Formulir Pendaftaran</td>
                              <td><span class="badge bg-success">Lengkap</span></td>
                            </tr>
                            @foreach($jenisBerkasWajib as $key => $label)
                              <tr>
                                <td>{{ $label }}</td>
                                <td>
                                  @if(isset($userBerkasSementara[$key]))
                                    <span class="badge bg-success">Lengkap</span>
                                  @else
                                    <span class="badge bg-warning">Belum Upload</span>
                                  @endif
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                  <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                      <h5 class="mb-0">Ringkasan Data Pendaftaran</h5>
                    </div>
                    <div class="card-body">
                      <div class="row mb-3">
                        <div class="col-md-6">
                          <h6>Data Pribadi</h6>
                          <table class="table table-sm">
                            <tr>
                              <td width="40%">Nama Lengkap</td>
                              <td width="60%">: {{ optional($formulir)->nama_lengkap ?: 'Belum diisi' }}</td>
                            </tr>
                            <tr>
                              <td>NIK</td>
                              <td>: {{ optional($formulir)->nik ?: 'Belum diisi' }}</td>
                            </tr>
                            <tr>
                              <td>Tempat, Tanggal Lahir</td>
                              <td>: {{ optional($formulir)->tempat_lahir ?: 'Belum diisi' }}, {{ optional($formulir)->tanggal_lahir ? \Carbon\Carbon::parse(optional($formulir)->tanggal_lahir)->format('d F Y') : 'Belum diisi' }}</td>
                            </tr>
                            <tr>
                              <td>Jenis Kelamin</td>
                              <td>: {{ optional($formulir)->jenis_kelamin ?: 'Belum diisi' }}</td>
                            </tr>
                            <tr>
                              <td>Agama</td>
                              <td>: {{ optional($formulir)->agama ?: 'Belum diisi' }}</td>
                            </tr>
                          </table>
                        </div>
                        <div class="col-md-6">
                          <h6>Data Orang Tua</h6>
                          <table class="table table-sm">
                            <tr>
                              <td width="40%">Nama Ayah</td>
                              <td width="60%">: {{ $formulir->nama_ayah ?? 'Belum diisi' }}</td>
                            </tr>
                            <tr>
                              <td>Nama Ibu</td>
                              <td>: {{ $formulir->nama_ibu ?? 'Belum diisi' }}</td>
                            </tr>
                            <tr>
                              <td>Pekerjaan Ayah</td>
                              <td>: {{ $formulir->pekerjaan_ayah ?? 'Belum diisi' }}</td>
                            </tr>
                            <tr>
                              <td>Pekerjaan Ibu</td>
                              <td>: {{ $formulir->pekerjaan_ibu ?? 'Belum diisi' }}</td>
                            </tr>
                            <tr>
                              <td>No. HP</td>
                              <td>: {{ $formulir->no_telp_ortu ?? 'Belum diisi' }}</td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <h6>Alamat</h6>
                          <p>{{ $formulir->alamat ?? 'Belum diisi' }}</p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                      <h5 class="mb-0">Pembayaran</h5>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th>Jenis Pembayaran</th>
                              <th>Nominal</th>
                              <th>Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Biaya Pendaftaran</td>
                              <td>Rp 600.000</td>
                              <td><span class="badge bg-success">Lunas</span></td>
                            </tr>
                            <tr>
                              <td>SPP Bulan Pertama</td>
                              <td>Rp 350.000</td>
                              <td><span class="badge bg-danger">Belum Dibayar</span></td>
                            </tr>
                            <tr>
                              <td>Seragam dan Perlengkapan</td>
                              <td>Rp 750.000</td>
                              <td><span class="badge bg-danger">Belum Dibayar</span></td>
                            </tr>
                            <tr class="table-secondary">
                              <td><strong>Total</strong></td>
                              <td><strong>Rp 1.700.000</strong></td>
                              <td><span class="badge bg-warning">Sebagian</span></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                      <div class="mt-3">
                        <h6>Informasi Pembayaran</h6>
                        <p>Silakan melakukan pembayaran ke rekening berikut:</p>
                        <ul>
                          <li>Bank Mandiri: 1234567890 a.n. SD Normal Islam 2 Samarinda</li>
                          <li>Bank BNI: 0987654321 a.n. SD Normal Islam 2 Samarinda</li>
                        </ul>
                        <p>Setelah melakukan pembayaran, silakan upload bukti pembayaran di bawah ini:</p>

                        <form action="{{ route('konfirmasi.upload-bukti') }}" method="POST" enctype="multipart/form-data" id="upload-bukti-form">
                          @csrf
                          <div class="mb-3">
                            <label for="bukti_pembayaran" class="form-label">Upload Bukti Pembayaran</label>
                            <input class="form-control" type="file" id="bukti_pembayaran" name="bukti_pembayaran" accept=".jpg,.jpeg,.png,.pdf" required>
                            <div class="form-text">Format: JPG/PNG/PDF, Maks: 2MB</div>
                          </div>
                          <div class="mb-3">
                            <label for="keterangan_pembayaran" class="form-label">Keterangan Pembayaran</label>
                            <textarea class="form-control" id="keterangan_pembayaran" name="keterangan_pembayaran" rows="3" placeholder="Contoh: Pembayaran biaya pendaftaran via transfer Bank Mandiri"></textarea>
                          </div>
                          <button type="submit" class="btn btn-primary" id="upload-btn">
                            <i class="ti ti-upload me-2"></i>Upload Bukti Pembayaran
                          </button>
                        </form>

                        @if(isset($buktiPembayaran) && $buktiPembayaran)
                          <div class="mt-3 p-3 bg-success-subtle rounded">
                            <h6 class="text-success"><i class="ti ti-check-circle me-2"></i>Bukti Pembayaran Diterima</h6>
                            <p class="mb-2"><strong>File:</strong> {{ $buktiPembayaran->nama_file }}</p>
                            <p class="mb-2"><strong>Tanggal Upload:</strong> {{ $buktiPembayaran->created_at->format('d F Y H:i') }}</p>
                            <p class="mb-2"><strong>Status:</strong>
                              <span class="badge bg-success"><i class="ti ti-check me-1"></i>Diterima</span>
                            </p>
                            @if($buktiPembayaran->keterangan)
                              <p class="mb-2"><strong>Keterangan:</strong> {{ $buktiPembayaran->keterangan }}</p>
                            @endif
                            <div class="alert alert-success mb-0 mt-2">
                              <i class="ti ti-info-circle me-2"></i>
                              <strong>Pembayaran Anda telah diterima!</strong> Silakan lanjutkan dengan mengkonfirmasi pendaftaran di bawah ini.
                            </div>
                          </div>
                        @else
                          <div class="mt-3 p-3 bg-warning-subtle rounded">
                            <h6 class="text-warning"><i class="ti ti-alert-triangle me-2"></i>Bukti Pembayaran Belum Diupload</h6>
                            <p class="mb-0">Silakan upload bukti pembayaran terlebih dahulu sebelum melakukan konfirmasi pendaftaran.</p>
                          </div>
                        @endif
                      </div>
                    </div>
                  </div>

                  <div class="text-center">
                    <form action="{{ route('konfirmasi.final') }}" method="POST" id="konfirmasi-form">
                      @csrf

                      <div class="form-check mb-4 text-start">
                        <input class="form-check-input" type="checkbox" id="konfirmasi_check" name="konfirmasi_check" value="1" required>
                        <label class="form-check-label" for="konfirmasi_check">
                          Saya menyatakan bahwa data yang diisi adalah benar dan saya bersedia mengikuti semua peraturan yang berlaku di SD Normal Islam 2 Samarinda.
                        </label>
                      </div>

                      <button type="submit" class="btn btn-danger btn-lg px-5" id="submit-btn" @if(!$formulir || !$userBerkasSementara || count($userBerkasSementara) < count($jenisBerkasWajib) || !isset($buktiPembayaran) || !$buktiPembayaran || $buktiPembayaran->status != 'approved') disabled @endif>
                        <i class="ti ti-check me-2"></i>Konfirmasi Pendaftaran
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/js/dashboard.js"></script>

  <script>
    $(document).ready(function() {
        // Handle form submission
        $('#konfirmasi-form').on('submit', function(e) {
            const checkbox = $('#konfirmasi_check');
            const submitBtn = $('#submit-btn');

            if (!checkbox.is(':checked')) {
                e.preventDefault();
                alert('Anda harus menyetujui pernyataan konfirmasi terlebih dahulu!');
                return false;
            }

            // Disable button to prevent double submission
            submitBtn.prop('disabled', true);
            submitBtn.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Memproses...');

            // Show confirmation dialog
            if (!confirm('Apakah Anda yakin ingin mengkonfirmasi pendaftaran? Data yang sudah dikonfirmasi tidak dapat diubah lagi.')) {
                e.preventDefault();
                submitBtn.prop('disabled', false);
                submitBtn.html('Konfirmasi Pendaftaran');
                return false;
            }
        });

        // Enable/disable submit button based on checkbox
        $('#konfirmasi_check').on('change', function() {
            const submitBtn = $('#submit-btn');
            const isFormValid = @if(!$formulir || !$userBerkasSementara || count($userBerkasSementara) < count($jenisBerkasWajib) || !isset($buktiPembayaran) || !$buktiPembayaran || $buktiPembayaran->status != 'approved') false @else true @endif;

            if ($(this).is(':checked') && isFormValid) {
                submitBtn.prop('disabled', false);
            } else {
                submitBtn.prop('disabled', true);
            }
        });

        // Handle upload bukti pembayaran form
        $('#upload-bukti-form').on('submit', function(e) {
            const uploadBtn = $('#upload-btn');
            const fileInput = $('#bukti_pembayaran');

            if (!fileInput.val()) {
                e.preventDefault();
                alert('Silakan pilih file bukti pembayaran terlebih dahulu!');
                return false;
            }

            // Check file size (2MB = 2048KB)
            const file = fileInput[0].files[0];
            if (file && file.size > 2048 * 1024) {
                e.preventDefault();
                alert('Ukuran file terlalu besar! Maksimal 2MB.');
                return false;
            }

            // Disable button and show loading
            uploadBtn.prop('disabled', true);
            uploadBtn.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Mengupload...');
        });

        // File input change handler
        $('#bukti_pembayaran').on('change', function() {
            const file = this.files[0];
            if (file) {
                const fileSize = (file.size / 1024 / 1024).toFixed(2); // Convert to MB
                if (file.size > 2048 * 1024) {
                    alert('Ukuran file terlalu besar: ' + fileSize + 'MB. Maksimal 2MB.');
                    $(this).val('');
                }
            }
        });
    });
  </script>
</body>

</html>
