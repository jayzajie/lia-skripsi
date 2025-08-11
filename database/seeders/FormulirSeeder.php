<?php

namespace Database\Seeders;

use App\Models\Formulir;
use App\Models\User;
use App\Models\Berkas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormulirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')->first();

        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        // Create some forms with different statuses
        $draftFormulir = Formulir::create([
            'nama_lengkap' => 'Andi Saputra',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2016-05-15',
            'jenis_kelamin' => 'Laki-Laki',
            'nik' => '3175060504160001',
            'agama' => 'Islam',
            'alamat' => 'Jl. Pahlawan No. 123, Jakarta Selatan',
            'anak_ke' => '2',
            'nama_ayah' => 'Budi Saputra',
            'nama_ibu' => 'Siti Rahayu',
            'pekerjaan_ayah' => 'Karyawan Swasta',
            'pekerjaan_ibu' => 'Guru',
            'alamat_ortu' => 'Jl. Pahlawan No. 123, Jakarta Selatan',
            'no_telp_ortu' => '081234567890',
            'status' => 'draft',
            'user_id' => $user->id,
        ]);

        $submittedFormulir1 = Formulir::create([
            'nama_lengkap' => 'Budi Santoso',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '2017-03-20',
            'jenis_kelamin' => 'Laki-Laki',
            'nik' => '3175060503170002',
            'agama' => 'Islam',
            'alamat' => 'Jl. Merdeka No. 45, Bandung',
            'anak_ke' => '1',
            'nama_ayah' => 'Agus Santoso',
            'nama_ibu' => 'Dewi Wulandari',
            'pekerjaan_ayah' => 'Wiraswasta',
            'pekerjaan_ibu' => 'Ibu Rumah Tangga',
            'alamat_ortu' => 'Jl. Merdeka No. 45, Bandung',
            'no_telp_ortu' => '085678901234',
            'status' => 'submitted',
            'user_id' => $user->id,
        ]);

        $submittedFormulir2 = Formulir::create([
            'nama_lengkap' => 'Citra Lestari',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '2016-07-10',
            'jenis_kelamin' => 'Perempuan',
            'nik' => '3175060507160003',
            'agama' => 'Islam',
            'alamat' => 'Jl. Raya Darmo No. 78, Surabaya',
            'anak_ke' => '3',
            'nama_ayah' => 'Hendra Lestari',
            'nama_ibu' => 'Ratna Sari',
            'pekerjaan_ayah' => 'Dosen',
            'pekerjaan_ibu' => 'Dokter',
            'alamat_ortu' => 'Jl. Raya Darmo No. 78, Surabaya',
            'no_telp_ortu' => '082345678901',
            'status' => 'submitted',
            'user_id' => $user->id,
        ]);

        $approvedFormulir = Formulir::create([
            'nama_lengkap' => 'Dian Pratiwi',
            'tempat_lahir' => 'Semarang',
            'tanggal_lahir' => '2016-09-05',
            'jenis_kelamin' => 'Perempuan',
            'nik' => '3175060509160004',
            'agama' => 'Islam',
            'alamat' => 'Jl. Pemuda No. 56, Semarang',
            'anak_ke' => '2',
            'nama_ayah' => 'Eko Pratama',
            'nama_ibu' => 'Maya Anggraini',
            'pekerjaan_ayah' => 'PNS',
            'pekerjaan_ibu' => 'PNS',
            'alamat_ortu' => 'Jl. Pemuda No. 56, Semarang',
            'no_telp_ortu' => '083456789012',
            'status' => 'verified',
            'approved_at' => now(),
            'user_id' => $user->id,
        ]);

        // Create some berkas
        $berkas = [
            [
                'formulir_id' => $submittedFormulir1->id,
                'jenis_berkas' => 'kartu_keluarga',
                'file_path' => 'berkas/kartu_keluarga_sample.pdf',
                'user_id' => $user->id,
            ],
            [
                'formulir_id' => $submittedFormulir1->id,
                'jenis_berkas' => 'akte_kelahiran',
                'file_path' => 'berkas/akte_kelahiran_sample.pdf',
                'user_id' => $user->id,
            ],
            [
                'formulir_id' => $submittedFormulir1->id,
                'jenis_berkas' => 'pas_foto',
                'file_path' => 'berkas/pas_foto_sample.jpg',
                'user_id' => $user->id,
            ],
            [
                'formulir_id' => $submittedFormulir1->id,
                'jenis_berkas' => 'ktp_ortu',
                'file_path' => 'berkas/ktp_ortu_sample.pdf',
                'user_id' => $user->id,
            ],
            [
                'formulir_id' => $submittedFormulir2->id,
                'jenis_berkas' => 'kartu_keluarga',
                'file_path' => 'berkas/kartu_keluarga_sample.pdf',
                'user_id' => $user->id,
            ],
            [
                'formulir_id' => $submittedFormulir2->id,
                'jenis_berkas' => 'akte_kelahiran',
                'file_path' => 'berkas/akte_kelahiran_sample.pdf',
                'user_id' => $user->id,
            ],
            [
                'formulir_id' => $submittedFormulir2->id,
                'jenis_berkas' => 'pas_foto',
                'file_path' => 'berkas/pas_foto_sample.jpg',
                'user_id' => $user->id,
            ],
            [
                'formulir_id' => $submittedFormulir2->id,
                'jenis_berkas' => 'ktp_ortu',
                'file_path' => 'berkas/ktp_ortu_sample.pdf',
                'user_id' => $user->id,
            ],
            [
                'formulir_id' => $approvedFormulir->id,
                'jenis_berkas' => 'kartu_keluarga',
                'file_path' => 'berkas/kartu_keluarga_sample.pdf',
                'user_id' => $user->id,
            ],
            [
                'formulir_id' => $approvedFormulir->id,
                'jenis_berkas' => 'akte_kelahiran',
                'file_path' => 'berkas/akte_kelahiran_sample.pdf',
                'user_id' => $user->id,
            ],
            [
                'formulir_id' => $approvedFormulir->id,
                'jenis_berkas' => 'pas_foto',
                'file_path' => 'berkas/pas_foto_sample.jpg',
                'user_id' => $user->id,
            ],
            [
                'formulir_id' => $approvedFormulir->id,
                'jenis_berkas' => 'ktp_ortu',
                'file_path' => 'berkas/ktp_ortu_sample.pdf',
                'user_id' => $user->id,
            ],
        ];

        foreach ($berkas as $b) {
            Berkas::create($b);
        }
    }
} 