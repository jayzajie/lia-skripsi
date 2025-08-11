<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>Upload Berkas - SD Normal Islam 2 Samarinda</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <link rel="stylesheet" href="../assets/css/dashboard-custom.css" />
  <!-- Add jsPDF for PDF export -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <style>
    /* Mobile sidebar toggle visibility */
    @media (max-width: 1199.98px) {
      .mobile-sidebar-toggle {
        display: block !important;
      }
      .body-wrapper {
        padding-left: 15px !important;
        padding-right: 15px !important;
      }
    }
    @media (min-width: 1200px) {
      .mobile-sidebar-toggle {
        display: none !important;
      }
    }

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

    /* Print styles */
    @media print {
      body * {
        visibility: hidden;
      }
      .print-section, .print-section * {
        visibility: visible;
      }
      .print-section {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
      }
      .no-print {
        display: none !important;
      }
    }

    /* Success alert */
    .alert-success {
      padding: 15px;
      margin-bottom: 20px;
      border: 1px solid transparent;
      border-radius: 4px;
      color: #155724;
      background-color: #d4edda;
      border-color: #c3e6cb;
      display: none;
    }

    /* File preview */
    .file-preview {
      max-width: 100px;
      max-height: 100px;
      cursor: pointer;
      border: 1px solid #ddd;
      padding: 3px;
    }

    /* Modal styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 1060;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.7);
    }

    .modal-content {
      position: relative;
      background-color: #fefefe;
      margin: 10% auto;
      padding: 20px;
      border: 1px solid #888;
      border-radius: 10px;
      width: 80%;
      max-width: 800px;
      animation-name: animatetop;
      animation-duration: 0.4s;
    }

    @keyframes animatetop {
      from {top: -300px; opacity: 0}
      to {top: 0; opacity: 1}
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    /* File upload button improvement */
    .custom-file-upload {
      position: relative;
      overflow: hidden;
      display: inline-block;
    }

    .custom-file-upload input[type="file"] {
      position: absolute;
      font-size: 100px;
      opacity: 0;
      right: 0;
      top: 0;
      cursor: pointer;
    }

    /* Form finalized banner */
    .form-finalized-banner {
      background-color: #d1e7dd;
      color: #0f5132;
      padding: 10px 15px;
      border-radius: 5px;
      margin-bottom: 20px;
      display: none;
      align-items: center;
      justify-content: space-between;
    }

    .form-finalized-banner i {
      font-size: 1.5rem;
      margin-right: 10px;
    }

    .form-finalized-banner .banner-content {
      display: flex;
      align-items: center;
    }

    /* School header for printable form */
    .school-header {
      text-align: center;
      margin-bottom: 20px;
      border-bottom: 2px solid #ccc;
      padding-bottom: 15px;
    }

    .school-header h2 {
      margin-bottom: 5px;
    }

    .school-header p {
      margin-bottom: 0;
    }

    /* Uploaded files section */
    .file-item {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
      padding: 10px;
      background-color: #f8f9fa;
      border-radius: 5px;
      border: 1px solid #eee;
    }

    .file-item .file-icon {
      font-size: 24px;
      margin-right: 10px;
      color: var(--bs-primary);
    }

    .file-item .file-name {
      flex-grow: 1;
    }

    .file-actions {
      display: flex;
      gap: 5px;
    }
  </style>
</head>

<body>
  @php
    use App\Models\BerkasSementara;
    $userBerkasSementara = BerkasSementara::where('user_id', Auth::id())->get()->keyBy('jenis_berkas');
    $jenisBerkasWajib = [
        'kartu_keluarga' => 'Kartu Keluarga',
        'akte_kelahiran' => 'Akta Kelahiran',
        'pas_foto' => 'Pas Foto 3x4',
        'ktp_ortu' => 'KTP Orang Tua',
    ];
    $allUploaded = collect($jenisBerkasWajib)->keys()->diff($userBerkasSementara->keys())->isEmpty();
  @endphp
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
              <a class="sidebar-link active" href="{{ route('berkas.index') }}" aria-expanded="false">
                <span><i class="ti ti-files"></i></span>
                <span class="hide-menu">Upload Berkas</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('konfirmasi.index') }}" aria-expanded="false">
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

    <!-- Mobile sidebar toggle button -->
    <button class="mobile-sidebar-toggle d-xl-none" aria-label="Toggle sidebar">☰</button>

    <!-- Sidebar overlay -->
    <div class="sidebar-overlay"></div>

    <!--  Main wrapper -->
    <div class="body-wrapper">
      <div class="container-fluid p-0">
        <!--  Row 1 -->
        <div class="row m-0">
          <div class="col-12 p-0">
            <div class="card w-100 border-0">
              <div class="card-body p-4">
                <h1 class="card-title fs-1 fw-bold mb-4">Upload Berkas</h1>

                <!-- Success Alert -->
                <div id="successAlert" class="alert alert-success" role="alert">
                  Berkas berhasil diupload!
                </div>

                <!-- Files finalized banner -->
                <div id="filesFinalizedBanner" class="form-finalized-banner" style="display: none;">
                  <div class="banner-content">
                    <i class="ti ti-check-circle"></i>
                    <div>
                      <h5 class="mb-0">Berkas telah difinalisasi!</h5>
                      <p class="mb-0">Berkas yang sudah diupload tidak dapat diubah kecuali dengan izin admin.</p>
                    </div>
                  </div>
                </div>

                <div class="form-container p-4 bg-light rounded">
                  <div class="alert alert-info mb-4">
                    <h5 class="alert-heading">Petunjuk Upload Berkas</h5>
                    <p class="mb-0">Silakan upload dokumen berikut dalam format PDF atau JPG dengan ukuran maksimal 2MB per file.</p>
                  </div>

                  @foreach($jenisBerkasWajib as $key => $label)
                    <form action="{{ route('berkas.sementara.store') }}" method="POST" enctype="multipart/form-data" class="mb-3">
                      @csrf
                      <input type="hidden" name="jenis_berkas" value="{{ $key }}">
                      <div class="row align-items-center">
                        <div class="col-md-4">
                          <label class="form-label">{{ $label }}</label>
                        </div>
                        <div class="col-md-5">
                          <input type="file" name="file" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                          <button type="submit" class="btn btn-primary">Upload</button>
                          @if(isset($userBerkasSementara[$key]))
                            <a href="{{ asset('storage/'.$userBerkasSementara[$key]->file_path) }}" target="_blank" class="btn btn-success ms-2">Lihat</a>
                            <span class="badge bg-info ms-1">{{ $userBerkasSementara[$key]->status }}</span>
                          @endif
                        </div>
                      </div>
                    </form>
                  @endforeach

                  @if($allUploaded)
                    <form action="{{ route('berkas.finalisasi') }}" method="POST" class="mt-4">
                      @csrf
                      <button type="submit" class="btn btn-warning btn-lg">
                        <i class="ti ti-device-floppy me-1"></i> Setor Data
                      </button>
                    </form>
                  @else
                    <div class="alert alert-warning mt-4">Upload semua berkas wajib sebelum setor data.</div>
                  @endif

                  <div class="mt-5 print-section" id="uploadedFilesSection">
                    <h4 class="mb-3">Berkas Terupload</h4>

                    <!-- School header for print only -->
                    <div class="school-header d-none d-print-block">
                      <h2>SD NORMAL ISLAM 2 SAMARINDA</h2>
                      <p>Jl. Kadrie Oening No. 77, Samarinda, Kalimantan Timur</p>
                      <p>Telp: (0541) 7777777 | Email: info@sdnormalislam2.sch.id</p>
                      <h3 class="mt-3">DAFTAR BERKAS TERUPLOAD</h3>
                    </div>

                    <div id="filesList" class="mb-4">
                      <!-- Files will be displayed here -->
                    </div>

                    <div class="table-responsive">
                      <table class="table table-bordered" id="uploadedFilesTable">
                        <thead>
                          <tr>
                            <th>Nama Dokumen</th>
                            <th>Tanggal Upload</th>
                            <th>Status</th>
                            <th class="no-print">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- Dynamic content from JavaScript -->
                        </tbody>
                      </table>
                    </div>

                    <div class="text-end mt-3 no-print">
                      <button id="printFilesBtn" class="btn btn-success">Cetak Daftar</button>
                      <button id="exportFilesBtn" class="btn btn-danger">Export PDF</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- File Preview Modal -->
  <div id="filePreviewModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2 id="previewFileName">Preview File</h2>
      <div id="previewContent" class="text-center p-3">
        <!-- Content will be inserted here by JavaScript -->
      </div>
      <div class="text-center mt-4">
        <button id="closeModalBtn" class="btn btn-primary">Tutup</button>
      </div>
    </div>
  </div>

  <!-- Add confirmation modal for file uploads -->
  <div id="confirmUploadModal" class="modal">
    <div class="modal-content">
      <h3>Konfirmasi Upload Berkas</h3>
      <p>Apakah Anda yakin ingin mengupload berkas ini?</p>
      <p><strong>Perhatian:</strong> Setelah diupload, berkas tidak dapat diubah kecuali dengan izin admin.</p>
      <div class="text-center mt-4">
        <button id="cancelUploadBtn" class="btn btn-secondary">Batal</button>
        <button id="confirmUploadBtn" class="btn btn-primary">Ya, Upload Berkas</button>
      </div>
    </div>
  </div>

  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/js/dashboard.js"></script>
  <script>
    // Initialize mobile sidebar toggle
    document.addEventListener('DOMContentLoaded', function() {
      const mobileToggle = document.querySelector('.mobile-sidebar-toggle');
      const sidebarOverlay = document.querySelector('.sidebar-overlay');
      const mainWrapper = document.getElementById('main-wrapper');
      const sidebarClose = document.getElementById('sidebarCollapse');

      if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
          mainWrapper.classList.add('sidebar-open');
        });
      }

      if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
          mainWrapper.classList.remove('sidebar-open');
        });
      }

      if (sidebarClose) {
        sidebarClose.addEventListener('click', function() {
          mainWrapper.classList.remove('sidebar-open');
        });
      }

      // Files upload management
      const form = document.getElementById('berkasForm');
      const successAlert = document.getElementById('successAlert');
      const filePreviewModal = document.getElementById('filePreviewModal');
      const closeModalBtns = document.querySelectorAll('.close, #closeModalBtn');
      const printFilesBtn = document.getElementById('printFilesBtn');
      const exportFilesBtn = document.getElementById('exportFilesBtn');

      // Mock data for uploaded files
      let uploadedFiles = JSON.parse(localStorage.getItem('uploadedFiles')) || [];

      // Display existing files
      displayUploadedFiles();

      // Show finalized banner if files exist
      if (uploadedFiles.length > 0) {
        const filesFinalizedBanner = document.getElementById('filesFinalizedBanner');
        if (filesFinalizedBanner) {
          filesFinalizedBanner.style.display = 'flex';
        }
      }

      if (form) {
        form.addEventListener('submit', function(e) {
          e.preventDefault();

          // Check if any files are selected
          let hasFiles = false;
          const inputs = form.querySelectorAll('input[type="file"]');
          inputs.forEach(input => {
            if (input.files.length > 0) {
              hasFiles = true;
            }
          });

          if (hasFiles) {
            // Show confirmation modal
            confirmUploadModal.style.display = 'block';
          } else {
            alert('Silakan pilih berkas yang akan diupload.');
          }
        });
      }

      // Process file upload after confirmation
      function processFileUpload() {
        // Simulate file upload
        const formData = new FormData(form);
        const files = [];

        formData.forEach((file, key) => {
          if (file.name && file.size > 0) {
            const now = new Date();
            const fileName = file.name;
            const fileType = fileName.split('.').pop().toLowerCase();
            const status = "Diverifikasi"; // For demo

            // Create a new file entry
            const fileEntry = {
              id: Date.now() + Math.random().toString(36).substr(2, 5),
              name: key,
              fileName: fileName,
              fileType: fileType,
              uploadDate: now.toISOString().split('T')[0],
              status: status,
              dataUrl: URL.createObjectURL(file)
            };

            files.push(fileEntry);
            uploadedFiles.push(fileEntry);
          }
        });

        // Save to localStorage
        localStorage.setItem('uploadedFiles', JSON.stringify(uploadedFiles));

        // Update the files list
        displayUploadedFiles();

        // Show finalized banner if files were uploaded
        if (files.length > 0) {
          const filesFinalizedBanner = document.getElementById('filesFinalizedBanner');
          if (filesFinalizedBanner) {
            filesFinalizedBanner.style.display = 'flex';
          }
        }

        // Show success message
        successAlert.textContent = 'Berkas berhasil diupload dan difinalisasi!';
        successAlert.style.display = 'block';
        setTimeout(function() {
          successAlert.style.display = 'none';
        }, 3000);

        // Reset form
        form.reset();
      }

      // Display uploaded files
      function displayUploadedFiles() {
        const filesTable = document.querySelector('#uploadedFilesTable tbody');
        const filesList = document.getElementById('filesList');

        if (!filesTable || !filesList) return;

        // Clear existing entries
        filesTable.innerHTML = '';
        filesList.innerHTML = '';

        // Document name mapping
        const documentNames = {
          'kartu_keluarga': 'Kartu Keluarga',
          'akta_lahir': 'Akta Kelahiran',
          'foto': 'Pas Foto 3x4',
          'ktp_ortu': 'KTP Orang Tua',
          'ijazah_tk': 'Ijazah TK',
          'sertifikat': 'Sertifikat Prestasi'
        };

        // Check if any files uploaded
        if (uploadedFiles.length === 0) {
          // Display empty state for the table
          const emptyRow = document.createElement('tr');
          emptyRow.innerHTML = `
            <td colspan="4" class="text-center">Belum ada berkas yang diupload</td>
          `;
          filesTable.appendChild(emptyRow);

          // Display empty state for the files list
          filesList.innerHTML = `
            <div class="alert alert-warning">
              Belum ada berkas yang diupload. Silakan upload berkas yang diperlukan.
            </div>
          `;
          return;
        }

        // Populate the files table
        uploadedFiles.forEach(file => {
          const row = document.createElement('tr');

          // Status badge color
          let statusBadge = 'bg-warning';
          if (file.status === 'Diverifikasi') {
            statusBadge = 'bg-success';
          } else if (file.status === 'Ditolak') {
            statusBadge = 'bg-danger';
          }

          row.innerHTML = `
            <td>${documentNames[file.name] || file.name}</td>
            <td>${file.uploadDate}</td>
            <td><span class="badge ${statusBadge}">${file.status}</span></td>
            <td class="no-print">
              <button class="btn btn-sm btn-info preview-file" data-id="${file.id}">Lihat</button>
              <button class="btn btn-sm btn-danger delete-file" data-id="${file.id}">Hapus</button>
            </td>
          `;

          filesTable.appendChild(row);

          // Add to files list view
          const fileItem = document.createElement('div');
          fileItem.className = 'file-item';

          // Icon based on file type
          let fileIcon = 'ti-file-text';
          if (['jpg', 'jpeg', 'png', 'gif'].includes(file.fileType)) {
            fileIcon = 'ti-photo';
          } else if (file.fileType === 'pdf') {
            fileIcon = 'ti-file-description';
          }

          fileItem.innerHTML = `
            <i class="ti ${fileIcon} file-icon"></i>
            <div class="file-name">
              <strong>${documentNames[file.name] || file.name}</strong>
              <div class="small text-muted">${file.fileName} • ${file.uploadDate}</div>
            </div>
            <div class="file-status">
              <span class="badge ${statusBadge}">${file.status}</span>
            </div>
            <div class="file-actions no-print">
              <button class="btn btn-sm btn-info preview-file" data-id="${file.id}">Lihat</button>
              <button class="btn btn-sm btn-danger delete-file" data-id="${file.id}">Hapus</button>
            </div>
          `;

          filesList.appendChild(fileItem);
        });

        // Add event listeners for file preview
        document.querySelectorAll('.preview-file').forEach(button => {
          button.addEventListener('click', function() {
            const fileId = this.getAttribute('data-id');
            const file = uploadedFiles.find(f => f.id === fileId);

            if (file) {
              const previewContent = document.getElementById('previewContent');
              const previewFileName = document.getElementById('previewFileName');

              previewFileName.textContent = `${documentNames[file.name] || file.name} - ${file.fileName}`;

              // Clear previous content
              previewContent.innerHTML = '';

              // Display based on file type
              if (['jpg', 'jpeg', 'png', 'gif'].includes(file.fileType)) {
                const img = document.createElement('img');
                img.src = file.dataUrl;
                img.className = 'img-fluid';
                img.style.maxHeight = '500px';
                previewContent.appendChild(img);
              } else {
                // For PDFs and other file types
                previewContent.innerHTML = `
                  <div class="alert alert-info">
                    <i class="ti ti-file-description fs-1 d-block mb-3"></i>
                    <p>File: ${file.fileName}</p>
                    <p>Type: ${file.fileType.toUpperCase()}</p>
                    <p>Uploaded: ${file.uploadDate}</p>
                  </div>
                `;
              }

              filePreviewModal.style.display = 'block';
            }
          });
        });

        // Add event listeners for file deletion
        document.querySelectorAll('.delete-file').forEach(button => {
          button.addEventListener('click', function() {
            const fileId = this.getAttribute('data-id');

            if (confirm('Apakah Anda yakin ingin menghapus berkas ini?')) {
              uploadedFiles = uploadedFiles.filter(f => f.id !== fileId);
              localStorage.setItem('uploadedFiles', JSON.stringify(uploadedFiles));
              displayUploadedFiles();

              // Show success message
              successAlert.textContent = 'Berkas berhasil dihapus!';
              successAlert.style.display = 'block';
              setTimeout(function() {
                successAlert.style.display = 'none';
              }, 3000);
            }
          });
        });
      }

      // Close modal on click
      closeModalBtns.forEach(btn => {
        btn.addEventListener('click', function() {
          filePreviewModal.style.display = 'none';
        });
      });

      // Close modal when clicking outside
      window.addEventListener('click', function(event) {
        if (event.target == filePreviewModal) {
          filePreviewModal.style.display = 'none';
        }
      });

      // Print files list
      if (printFilesBtn) {
        printFilesBtn.addEventListener('click', function() {
          window.print();
        });
      }

      // Export files list to PDF
      if (exportFilesBtn) {
        exportFilesBtn.addEventListener('click', function() {
          // Initialize jsPDF if needed
          if (typeof window.jsPDF === 'undefined' && typeof window.jspdf !== 'undefined') {
            window.jsPDF = window.jspdf.jsPDF;
          }

          if (typeof window.jsPDF === 'undefined') {
            console.error('jsPDF is not loaded');
            alert('PDF export is not available at the moment. Please try again later.');
            return;
          }

          const pdf = new jsPDF('p', 'mm', 'a4');

          // Add title
          pdf.setFontSize(16);
          pdf.text('DAFTAR BERKAS TERUPLOAD', 105, 20, { align: 'center' });
          pdf.text('SD NORMAL ISLAM 2 SAMARINDA', 105, 30, { align: 'center' });
          pdf.setLineWidth(0.5);
          pdf.line(20, 35, 190, 35);

          // Document name mapping
          const documentNames = {
            'kartu_keluarga': 'Kartu Keluarga',
            'akta_lahir': 'Akta Kelahiran',
            'foto': 'Pas Foto 3x4',
            'ktp_ortu': 'KTP Orang Tua',
            'ijazah_tk': 'Ijazah TK',
            'sertifikat': 'Sertifikat Prestasi'
          };

          // Add content
          pdf.setFontSize(12);
          let y = 45;

          // Add header
          pdf.setFont(undefined, 'bold');
          pdf.text('Nama Dokumen', 20, y);
          pdf.text('Tanggal Upload', 90, y);
          pdf.text('Status', 150, y);
          pdf.setFont(undefined, 'normal');

          y += 10;

          // Add files
          if (uploadedFiles.length === 0) {
            pdf.text('Belum ada berkas yang diupload', 20, y);
          } else {
            uploadedFiles.forEach(file => {
              pdf.text(documentNames[file.name] || file.name, 20, y);
              pdf.text(file.uploadDate, 90, y);
              pdf.text(file.status, 150, y);
              y += 10;

              // Check if we need a new page
              if (y > 270) {
                pdf.addPage();
                y = 20;
              }
            });
          }

          // Add signature section
          y += 20;
          pdf.text('Samarinda, ................................', 120, y);
          y += 10;
          pdf.text('Orang Tua/Wali', 140, y);
          y += 30;
          pdf.text('(.................................................)', 130, y);

          // Save PDF
          pdf.save('Daftar_Berkas_SD_Normal_Islam_2.pdf');
        });
      }

      // Confirmation modal functionality
      const confirmUploadModal = document.getElementById('confirmUploadModal');
      const confirmUploadBtn = document.getElementById('confirmUploadBtn');
      const cancelUploadBtn = document.getElementById('cancelUploadBtn');

      // Handle confirmation modal actions
      if (confirmUploadBtn) {
        confirmUploadBtn.addEventListener('click', function() {
          // Process the form submission
          processFileUpload();

          // Close modal
          confirmUploadModal.style.display = 'none';
        });
      }

      // Cancel button in confirmation modal
      if (cancelUploadBtn) {
        cancelUploadBtn.addEventListener('click', function() {
          confirmUploadModal.style.display = 'none';
        });
      }

      // Close modal when clicking outside
      window.addEventListener('click', function(event) {
        if (event.target == confirmUploadModal) {
          confirmUploadModal.style.display = 'none';
        }
      });
    });
  </script>
</body>

</html>
