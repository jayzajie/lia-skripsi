<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Kartu Peserta</title>
    <style>
        @page {
            margin: 8mm;
            size: A4 landscape;
        }
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
            line-height: 1.2;
        }
        .card {
            width: 100%;
            height: 100%;
            position: relative;
            overflow: hidden;
            background: #228B22;
            box-sizing: border-box;
            page-break-inside: avoid;
        }
        .yellow-section {
            position: absolute;
            top: 0;
            right: 0;
            width: 65%;
            height: 100%;
            background: #FFD700;
            clip-path: polygon(40% 0%, 100% 0%, 100% 100%, 0% 100%);
            z-index: 1;
        }
        .header-section {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 10;
            width: 50%;
        }
        .school-name {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .logo {
            width: 50px;
            height: 50px;
            margin-right: 15px;
            flex-shrink: 0;
        }
        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .school-text {
            color: white;
            font-weight: bold;
            font-size: 18px;
            text-transform: uppercase;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
        }
        .card-title {
            color: white;
            font-weight: bold;
            font-size: 28px;
            text-transform: uppercase;
            margin: 8px 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
            line-height: 1.1;
        }
        .card-subtitle {
            color: white;
            font-weight: bold;
            font-size: 16px;
            text-transform: uppercase;
            margin: 2px 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
            line-height: 1.1;
        }
        .content-section {
            position: absolute;
            top: 200px;
            left: 20px;
            width: 50%;
            z-index: 10;
        }
        .data-row {
            margin-bottom: 15px;
            align-items: flex-start;
        }
        .data-label {
            color: white;
            font-weight: bold;
            font-size: 16px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.7);
            margin-bottom: 3px;
        }
        .data-value {
            color: white;
            font-size: 16px;
            font-weight: 500;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.7);
        }
        .photo-section {
            position: absolute;
            top: 180px;
            right: 100px;
            z-index: 10;
        }
        .photo-frame {
            width: 150px;
            height: 200px;
            border: 4px solid #0066cc;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }
        .photo-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
        }
        .photo-placeholder {
            color: #666;
            font-size: 12px;
            text-align: center;
            font-weight: bold;
        }

        .year-section {
            position: absolute;
            bottom: 30px;
            left: 20px;
            z-index: 10;
        }
        .year-text {
            color: white;
            font-weight: bold;
            font-size: 20px;
            text-transform: uppercase;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
        }
    </style>
</head>
<body>
    <div class="card">
        <!-- Yellow diagonal section -->
        <div class="yellow-section"></div>

        <!-- Header Section -->
        <div class="header-section">
            <div class="school-name">
                <div class="logo">
                    <img src="{{ public_path('images/logo.png') }}" alt="Logo">
                </div>
                <div class="school-text">NORMAL ISLAM 2 SAMARINDA</div>
            </div>

            <div class="card-title">KARTU PENDAFTARAN</div>
            <div class="card-subtitle">PPDB SEKOLAH DASAR</div>
            <div class="card-subtitle">NORMAL ISLAM 2 SAMARINDA</div>
        </div>

        <!-- Content Section -->
        <div class="content-section">
            <div class="data-row">
                <div class="data-label">Nama</div>
                <div class="data-value">: {{ $formulir->nama_lengkap ?? 'Muhammad Surya Wijaya' }}</div>
            </div>

            <div class="data-row">
                <div class="data-label">No.Pendaftaran</div>
                <div class="data-value">: {{ str_pad($formulir->id ?? '0002', 4, '0', STR_PAD_LEFT) }} {{ str_pad(rand(7910, 9999), 4, '0', STR_PAD_LEFT) }} {{ str_pad(rand(9550, 9999), 4, '0', STR_PAD_LEFT) }}</div>
            </div>

            <div class="data-row">
                <div class="data-label">Jenis Kelamin</div>
                <div class="data-value">: {{ $formulir->jenis_kelamin ?? 'Laki-laki' }}</div>
            </div>

            <div class="data-row">
                <div class="data-label">Tanggal Lahir</div>
                <div class="data-value">: {{ $formulir->tanggal_lahir ? date('d M Y', strtotime($formulir->tanggal_lahir)) : '02 July 2025' }}</div>
            </div>

            <div class="data-row">
                <div class="data-label">Alamat</div>
                <div class="data-value">: {{ $formulir->alamat ?? 'Jalan Minecraft' }}</div>
            </div>
        </div>

        <!-- Photo Section -->
        <div class="photo-section">
            <div class="photo-frame">
                @if(isset($formulir->foto_base64) && $formulir->foto_base64)
                    <img src="{{ $formulir->foto_base64 }}" alt="Foto Siswa">
                @else
                    <div class="photo-placeholder">
                        <span>Foto<br>3x4</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Year Section -->
        <div class="year-section">
            <div class="year-text">TAHUN AJARAN 2025/2026</div>
        </div>
    </div>
</body>
</html>
