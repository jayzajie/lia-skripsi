<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\FormulirSementara;
use App\Models\Konfirmasi;
use App\Models\BerkasSementara;

class TestVerificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user yang sudah ada atau buat baru
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
        }

        // Buat formulir sementara
        $formulir = FormulirSementara::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nama_lengkap' => 'Ahmad Rizki Pratama',
                'nik' => '6472010101010001',
                'tempat_lahir' => 'Samarinda',
                'tanggal_lahir' => '2018-01-01',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'alamat' => 'Jl. Contoh No. 123, Samarinda',
                'anak_ke' => '1',
                'nama_ayah' => 'Budi Santoso',
                'nama_ibu' => 'Siti Aminah',
                'pekerjaan_ayah' => 'Pegawai Swasta',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'alamat_ortu' => 'Jl. Contoh No. 123, Samarinda',
                'no_telp_ortu' => '081234567890',
                'status' => 'completed'
            ]
        );

        // Buat konfirmasi
        $konfirmasi = Konfirmasi::updateOrCreate(
            ['user_id' => $user->id],
            [
                'judul' => 'Konfirmasi Pendaftaran Siswa Baru',
                'deskripsi' => 'Konfirmasi pendaftaran untuk tahun ajaran 2024/2025',
                'status' => 'pending',
                'tanggal_konfirmasi' => now()->format('Y-m-d'),
                'keterangan' => null
            ]
        );

        // Buat berkas sementara dummy
        $jenisBerkas = [
            'kartu_keluarga' => 'uploads/berkas/dummy_kk.pdf',
            'akte_kelahiran' => 'uploads/berkas/dummy_akte.pdf',
            'pas_foto' => 'uploads/berkas/dummy_foto.jpg',
            'ktp_ortu' => 'uploads/berkas/dummy_ktp.pdf',
        ];

        foreach ($jenisBerkas as $jenis => $path) {
            BerkasSementara::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'jenis_berkas' => $jenis
                ],
                [
                    'file_path' => $path,
                    'status' => 'final'
                ]
            );
        }

        $this->command->info('Test verification data created successfully!');
        $this->command->info('User ID: ' . $user->id);
        $this->command->info('Konfirmasi ID: ' . $konfirmasi->id);
    }
}
