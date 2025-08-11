<?php

namespace Database\Seeders;

use App\Models\Pengumuman;
use App\Models\User;
use Illuminate\Database\Seeder;

class PengumumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first() ?? User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        Pengumuman::create([
            'no' => '001',
            'nama' => 'Jadwal Pendaftaran',
            'jenis_kelamin' => 'Laki-Laki',
            'keterangan' => 'Pendaftaran dibuka dari tanggal 1 Juni sampai 30 Juli 2023',
            'tanggal_terbit' => '2023-05-01',
            'tanggal_berakhir' => '2025-07-30',
            'status' => 'active',
            'user_id' => $admin->id,
        ]);

        Pengumuman::create([
            'no' => '002',
            'nama' => 'Pengumuman Kelulusan',
            'jenis_kelamin' => 'Perempuan',
            'keterangan' => 'Hasil seleksi akan diumumkan pada tanggal 5 Agustus 2023',
            'tanggal_terbit' => '2023-06-01',
            'tanggal_berakhir' => '2025-08-10',
            'status' => 'active',
            'user_id' => $admin->id,
        ]);

        Pengumuman::create([
            'no' => '003',
            'nama' => 'Jadwal Masuk Sekolah',
            'jenis_kelamin' => 'Laki-Laki',
            'keterangan' => 'Tahun ajaran baru dimulai pada tanggal 17 Juli 2023',
            'tanggal_terbit' => '2023-06-15',
            'tanggal_berakhir' => '2025-07-20',
            'status' => 'active',
            'user_id' => $admin->id,
        ]);
    }
} 