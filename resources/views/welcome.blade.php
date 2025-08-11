<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>SD Normal Islam 2 Samarinda</title>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <div class="nav-container">
                <div class="nav-links">
                    <a href="#beranda">Beranda</a>
                    <a href="#profil">Profil</a>
                    <a href="#ppdb">PPDB</a>
                    <a href="#kurikulum">Kurikulum</a>
                    <a href="#fasilitas">Fasilitas</a>
                    <a href="#berita">Berita</a>
                    <a href="#galeri">Galeri</a>
                    <div class="nav-dropdown">
                        <a href="#" class="dropdown-toggle">Akun</a>
                        <div class="dropdown-menu">
                            <a href="{{ route('register') }}" class="dropdown-item">Register</a>
                            <a href="{{ route('login') }}" class="dropdown-item">Login</a>
                        </div>
                    </div>
                </div>
                <div class="search-container">
                    <input type="text" placeholder="Cari..." class="search-input">
                    <button class="search-btn">🔍</button>
                </div>
                <button class="hamburger">☰</button>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="beranda" class="hero">
        <div class="hero-left">
            <div class="hero-text">
                <h1>PENDAFTARAN PESERTA DIDIK BARU</h1>
                <!-- Ganti baris yang ada dengan ini -->
                <h2 class="academic-year">TAHUN AJARAN {{ $activeAcademicYear }}</h2>
                <p>Selamat datang di website resmi SD Normal Islam 2 Samarinda. Kami mengundang putra-putri terbaik Anda untuk bergabung dengan keluarga besar sekolah kami. Daftarkan anak Anda sekarang juga dan berikan pendidikan terbaik untuk masa depan yang gemilang.</p>
                <a href="{{ route('register') }}" class="cta-button">Daftar Sekarang</a>
            </div>
        </div>
        <div class="hero-right">
            <div class="school-identity">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SD Normal Islam 2 Samarinda" class="school-logo">
                <h2 class="school-name">SD NORMAL ISLAM 2<br>SAMARINDA</h2>
                <p class="school-handle">@sdnormalislam02</p>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="profil" class="about section-divider">
        <div class="container">
            <h2>Sekolah Dasar Normal Islam 2 Samarinda</h2>
            <p>SD Normal Islam 2 Samarinda adalah lembaga pendidikan yang berkomitmen untuk memberikan pendidikan berkualitas dengan nilai-nilai Islam yang kuat. Kami mengintegrasikan kurikulum nasional dengan pembelajaran agama Islam untuk membentuk generasi yang berakhlak mulia dan berprestasi.</p>

            <div class="staff-section">
                <div class="staff-grid">
                    <div class="staff-card">
                        <div class="staff-photo">
                            <div class="placeholder-avatar">😊</div>
                        </div>
                        <h4>Kepala Sekolah</h4>
                        <p>Drs. Ahmad Fauzi, M.Pd</p>
                    </div>
                    <div class="staff-card">
                        <div class="staff-photo">
                            <div class="placeholder-avatar">😊</div>
                        </div>
                        <h4>Wakil Kepala Sekolah</h4>
                        <p>Siti Nurhaliza, S.Pd</p>
                    </div>
                    <div class="staff-card">
                        <div class="staff-photo">
                            <div class="placeholder-avatar">😊</div>
                        </div>
                        <h4>Koordinator Kurikulum</h4>
                        <p>Muhammad Rizki, S.Pd.I</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision Mission Section -->
    <section id="ppdb" class="vision-mission section-divider">
        <div class="container">
            <h2>Visi Misi & Tujuan</h2>
            <div class="vm-grid">
                <div class="vm-card">
                    <h3>Visi</h3>
                    <p>Menjadi lembaga pendidikan unggulan yang menghasilkan lulusan berkarakter Islami, berprestasi akademik, dan siap menghadapi tantangan masa depan dengan landasan iman dan taqwa.</p>
                </div>
                <div class="vm-card">
                    <h3>Misi</h3>
                    <p>Menyelenggarakan pendidikan yang berkualitas dengan mengintegrasikan nilai-nilai Islam dalam setiap aspek pembelajaran untuk membentuk generasi yang berakhlak mulia dan berprestasi.</p>
                </div>
                <div class="vm-card">
                    <h3>Tujuan</h3>
                    <p>Menghasilkan lulusan yang cerdas dan berkarakter, memiliki kemampuan akademik yang unggul, serta berakhlak mulia sesuai dengan ajaran Islam yang rahmatan lil alamiin.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section id="kurikulum" class="statistics section-divider">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">{{ $jumlahSiswa }}</div>
                    <div class="stat-label">Jumlah Siswa</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $jumlahGuru }}</div>
                    <div class="stat-label">Jumlah Guru</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $jumlahKelas }}</div>
                    <div class="stat-label">Jumlah Kelas</div>
                </div>
                {{-- <div class="stat-item">
                    <div class="stat-number">1250</div>
                    <div class="stat-label">Jumlah Alumni</div>
                </div> --}}
            </div>
        </div>
    </section>

    <!-- Facilities Section -->
    <section id="fasilitas" class="facilities section-divider">
        <div class="container">
            <h2>Fasilitas</h2>
            <div class="facilities-grid">
                <div class="facility-card">
                    <div class="facility-image">
                        <div class="placeholder-facility">🏫</div>
                    </div>
                    <h4>Laboratorium Komputer</h4>
                </div>
                <div class="facility-card">
                    <div class="facility-image">
                        <div class="placeholder-facility">📚</div>
                    </div>
                    <h4>Perpustakaan Sekolah</h4>
                </div>
                <div class="facility-card">
                    <div class="facility-image">
                        <div class="placeholder-facility">🏃</div>
                    </div>
                    <h4>Ruang Olahraga</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- Activities Section -->
    <section id="berita" class="activities section-divider">
        <div class="container">
            <h2>Galeri Kegiatan</h2>
            <div class="activities-grid">
                <div class="activity-card">
                    <h4>Kegiatan Belajar Mengajar</h4>
                    <p>Suasana pembelajaran yang kondusif dan interaktif dengan menggunakan metode pembelajaran modern dan berbasis teknologi untuk meningkatkan pemahaman siswa.</p>
                </div>
                <div class="activity-card">
                    <h4>Kegiatan Kerja Seni</h4>
                    <p>Pengembangan bakat dan minat siswa melalui berbagai kegiatan seni seperti menari, menyanyi, dan melukis untuk mengasah kreativitas siswa.</p>
                </div>
                <div class="activity-card">
                    <h4>Kegiatan Olahraga</h4>
                    <p>Program olahraga rutin untuk menjaga kesehatan dan kebugaran siswa serta mengembangkan jiwa sportivitas dan kerjasama tim yang baik.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="galeri" class="gallery section-divider">
        <div class="container">
            <h2>Galeri Foto</h2>
            <div class="gallery-grid">
                <div class="gallery-item">
                    <div class="placeholder-gallery">📷</div>
                </div>
                <div class="gallery-item">
                    <div class="placeholder-gallery">📷</div>
                </div>
                <div class="gallery-item">
                    <div class="placeholder-gallery">📷</div>
                </div>
                <div class="gallery-item">
                    <div class="placeholder-gallery">📷</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 80 80'%3E%3Ccircle cx='40' cy='40' r='35' fill='%2322c55e'/%3E%3Ccircle cx='40' cy='40' r='25' fill='%23fbbf24'/%3E%3Ccircle cx='40' cy='40' r='15' fill='%2322c55e'/%3E%3Ctext x='40' y='35' text-anchor='middle' fill='white' font-size='6' font-weight='bold'%3ESD NORMAL%3C/text%3E%3Ctext x='40' y='42' text-anchor='middle' fill='white' font-size='6'%3EISLAM 2%3C/text%3E%3Ctext x='40' y='49' text-anchor='middle' fill='white' font-size='5'%3ESAMARINDA%3C/text%3E%3C/svg%3E" alt="Logo" style="width: 120px; height: auto;">
            </div>
            <div class="footer-info">
                <h3>Kontak Kami</h3>
                <p>📞 (0541) 123-4567</p>
                <p>✉️ info@sdnormalislam2.sch.id</p>
                <p>📍 Jl. Pendidikan No. 123, Samarinda</p>
            </div>
            <div class="footer-social">
                <a href="#" class="social-link">📘</a>
                <a href="#" class="social-link">📷</a>
                <a href="#" class="social-link">🎵</a>
            </div>
        </div>
        <div class="footer-text">
            <p>&copy; 2024 SD Normal Islam 2 Samarinda. All rights reserved.</p>
        </div>
    </footer>

    <script src="{{ asset('js/landing.js') }}"></script>
</body>
</html>
