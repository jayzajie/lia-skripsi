<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Peserta PPDB - {{ $formulir->nama_lengkap }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: white;
            width: 297mm;
            height: 210mm;
            position: relative;
            overflow: hidden;
        }

        .kartu-container {
            width: 100%;
            height: 100%;
            position: relative;
            background: linear-gradient(135deg, #ffffff 0%, #ffffff 45%, #4CAF50 45%, #4CAF50 55%, #FFC107 55%, #FFC107 100%);
        }

        .header {
            position: absolute;
            top: 20px;
            left: 40px;
            z-index: 10;
        }

        .logo {
            width: 60px;
            height: 60px;
            margin-bottom: 10px;
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .school-name {
            color: #4CAF50;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .card-title {
            color: #4CAF50;
            font-size: 28px;
            font-weight: bold;
            line-height: 1.2;
            margin-bottom: 20px;
        }

        .student-info {
            position: absolute;
            top: 180px;
            left: 40px;
            z-index: 10;
        }

        .info-row {
            display: flex;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .info-label {
            width: 180px;
            color: #333;
            font-weight: 500;
        }

        .info-colon {
            width: 20px;
            color: #333;
        }

        .info-value {
            color: #333;
            font-weight: 600;
        }

        .center-logo {
            position: absolute;
            top: 50%;
            left: 45%;
            transform: translate(-50%, -50%);
            z-index: 5;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: #4CAF50;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid #FFC107;
        }

        .center-logo img {
            width: 80px;
            height: 80px;
            opacity: 1;
        }

        .center-logo-text {
            color: white;
            font-size: 10px;
            font-weight: bold;
            text-align: center;
            line-height: 1.1;
        }

        .student-photo {
            position: absolute;
            top: 120px;
            right: 80px;
            z-index: 10;
        }

        .photo-frame {
            width: 150px;
            height: 200px;
            border: 4px solid #2196F3;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .photo-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-placeholder {
            color: #999;
            text-align: center;
            font-size: 14px;
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .photo-placeholder i {
            font-size: 40px;
            margin-bottom: 10px;
            color: #ccc;
        }

        .footer {
            position: absolute;
            bottom: 30px;
            left: 40px;
            background: #4CAF50;
            color: white;
            padding: 15px 30px;
            font-size: 20px;
            font-weight: bold;
            z-index: 10;
        }

        .decorative-elements {
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            z-index: 1;
        }

        .green-section {
            position: absolute;
            top: 0;
            right: 0;
            width: 60%;
            height: 60%;
            background: #4CAF50;
            clip-path: polygon(30% 0%, 100% 0%, 100% 100%, 0% 100%);
        }

        .yellow-section {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 40%;
            background: #FFC107;
            clip-path: polygon(40% 0%, 100% 0%, 100% 100%, 0% 100%);
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .no-print {
                display: none !important;
            }
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #2196F3;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            z-index: 1000;
        }

        .print-button:hover {
            background: #1976D2;
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">🖨️ Cetak Kartu</button>

    <div class="kartu-container">
        <!-- Decorative Background Elements -->
        <div class="decorative-elements">
            <div class="green-section"></div>
            <div class="yellow-section"></div>
        </div>

        <!-- Header Section -->
        <div class="header">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Sekolah">
            </div>
            <div class="school-name">NORMAL ISLAM 2 SAMARINDA</div>
            <div class="card-title">
                KARTU PENDAFTARAN<br>
                PPDB SEKOLAH DASAR<br>
                NORMAL ISLAM 2 SAMARINDA
            </div>
        </div>

        <!-- Student Information -->
        <div class="student-info">
            <div class="info-row">
                <span class="info-label">Nama</span>
                <span class="info-colon">:</span>
                <span class="info-value">{{ $formulir->nama_lengkap }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">No.Pendaftaran</span>
                <span class="info-colon">:</span>
                <span class="info-value">{{ $formulir->nomor_pendaftaran ?? 'Belum Tersedia' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Jenis Kelamin</span>
                <span class="info-colon">:</span>
                <span class="info-value">{{ $formulir->jenis_kelamin }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Lahir</span>
                <span class="info-colon">:</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($formulir->tanggal_lahir)->format('d F Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Alamat</span>
                <span class="info-colon">:</span>
                <span class="info-value">{{ $formulir->alamat }}</span>
            </div>
        </div>

        <!-- Center Logo -->
        <div class="center-logo">
            <div class="center-logo-text">
                SD NORMAL ISLAM 2<br>
                SAMARINDA
            </div>
        </div>

        <!-- Student Photo -->
        <div class="student-photo">
            <div class="photo-frame">
                @if($foto && Storage::disk('public')->exists($foto->file_path))
                    <img src="{{ Storage::url($foto->file_path) }}" alt="Foto {{ $formulir->nama_lengkap }}">
                @else
                    <div class="photo-placeholder">
                        <i>👤</i>
                        <div>
                            Foto<br>
                            Siswa
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            TAHUN AJARAN 2025/2026
        </div>
    </div>
</body>
</html>
