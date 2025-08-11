<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample students
        Student::create([
            'name' => 'Ahmad Rizki',
            'gender' => 'male',
            'class' => '1',
            'student_id' => '001/2023',
            'address' => 'Jl. Pramuka No. 10, Samarinda',
            'phone' => '08123456789',
            'parent_name' => 'Budi Santoso',
            'parent_phone' => '08123456780',
            'parent_occupation' => 'PNS',
            'birth_place' => 'Samarinda',
            'birth_date' => '2016-05-10',
            'religion' => 'Islam',
        ]);

        Student::create([
            'name' => 'Siti Aminah',
            'gender' => 'female',
            'class' => '1',
            'student_id' => '002/2023',
            'address' => 'Jl. Pahlawan No. 15, Samarinda',
            'phone' => '08123456790',
            'parent_name' => 'Dewi Kartika',
            'parent_phone' => '08123456791',
            'parent_occupation' => 'Dokter',
            'birth_place' => 'Samarinda',
            'birth_date' => '2016-07-15',
            'religion' => 'Islam',
        ]);

        Student::create([
            'name' => 'Muhammad Iqbal',
            'gender' => 'male',
            'class' => '2',
            'student_id' => '003/2022',
            'address' => 'Jl. Ahmad Yani No. 20, Samarinda',
            'phone' => '08123456792',
            'parent_name' => 'Agus Widodo',
            'parent_phone' => '08123456793',
            'parent_occupation' => 'Wiraswasta',
            'birth_place' => 'Balikpapan',
            'birth_date' => '2015-08-20',
            'religion' => 'Islam',
        ]);

        Student::create([
            'name' => 'Anisa Putri',
            'gender' => 'female',
            'class' => '2',
            'student_id' => '004/2022',
            'address' => 'Jl. Diponegoro No. 25, Samarinda',
            'phone' => '08123456794',
            'parent_name' => 'Siti Rahayu',
            'parent_phone' => '08123456795',
            'parent_occupation' => 'Guru',
            'birth_place' => 'Samarinda',
            'birth_date' => '2015-09-25',
            'religion' => 'Islam',
        ]);

        // Create more sample students for classes 3-6
        for ($class = 3; $class <= 6; $class++) {
            for ($i = 1; $i <= 5; $i++) {
                $gender = $i % 2 === 0 ? 'female' : 'male';
                $studentId = sprintf('%03d/%d', ($class * 10) + $i, 2023 - ($class - 1));
                $birthYear = 2017 - $class;
                
                Student::create([
                    'name' => $gender === 'male' ? "Murid Laki-laki {$class}-{$i}" : "Murid Perempuan {$class}-{$i}",
                    'gender' => $gender,
                    'class' => (string)$class,
                    'student_id' => $studentId,
                    'address' => 'Jl. Contoh No. ' . rand(1, 100) . ', Samarinda',
                    'phone' => '08' . rand(100000000, 999999999),
                    'parent_name' => 'Orang Tua ' . rand(1, 100),
                    'parent_phone' => '08' . rand(100000000, 999999999),
                    'parent_occupation' => ['PNS', 'Wiraswasta', 'Guru', 'Dokter', 'Karyawan Swasta'][rand(0, 4)],
                    'birth_place' => ['Samarinda', 'Balikpapan', 'Tenggarong', 'Bontang'][rand(0, 3)],
                    'birth_date' => $birthYear . '-' . rand(1, 12) . '-' . rand(1, 28),
                    'religion' => 'Islam',
                ]);
            }
        }
    }
} 