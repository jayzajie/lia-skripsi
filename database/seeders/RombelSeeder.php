<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Staff;

class RombelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentAcademicYear = '2024/2025';
        $nextAcademicYear = '2025/2026';
        $sections = ['A', 'B'];

        // Create sample classes for current academic year
        for ($grade = 1; $grade <= 6; $grade++) {
            foreach ($sections as $section) {
                $className = $grade . $section;

                // Check if class already exists
                $existingClass = SchoolClass::where('name', $className)
                                           ->where('academic_year', $currentAcademicYear)
                                           ->first();

                if (!$existingClass) {
                    SchoolClass::create([
                        'name' => $className,
                        'grade_level' => $grade,
                        'section' => $section,
                        'capacity' => 30,
                        'current_students' => 0,
                        'homeroom_teacher' => 'Guru Kelas ' . $className,
                        'academic_year' => $currentAcademicYear,
                        'description' => 'Kelas ' . $className . ' - Kurikulum Merdeka',
                        'status' => 'active'
                    ]);
                }
            }
        }

        // Create sample students
        $studentNames = [
            'Ahmad Rizki Pratama', 'Siti Nurhaliza', 'Budi Santoso', 'Dewi Sartika',
            'Eko Prasetyo', 'Fitri Handayani', 'Galih Permana', 'Hana Safitri',
            'Indra Gunawan', 'Jihan Aulia', 'Krisna Wijaya', 'Lestari Putri',
            'Muhammad Fadil', 'Nadia Rahmawati', 'Oki Setiawan', 'Putri Maharani',
            'Qori Alamsyah', 'Rina Sari', 'Surya Pratama', 'Tika Wulandari'
        ];

        $studentIndex = 0;
        for ($grade = 1; $grade <= 6; $grade++) {
            foreach ($sections as $section) {
                $className = $grade . $section;

                // Check if students already exist for this class
                $existingStudents = Student::where('class_level', $className)
                                          ->where('academic_year', $currentAcademicYear)
                                          ->count();

                if ($existingStudents == 0) {
                    // Add 15-20 students per class
                    $studentCount = rand(15, 20);

                    for ($i = 0; $i < $studentCount; $i++) {
                        $name = $studentNames[$studentIndex % count($studentNames)];
                        $studentIndex++;

                        Student::create([
                            'name' => $name . ' ' . $className . '-' . ($i + 1),
                            'nis' => str_pad($grade . $section . ($i + 1), 8, '0', STR_PAD_LEFT),
                            'gender' => rand(0, 1) ? 'Laki-laki' : 'Perempuan',
                            'class_level' => $className,
                            'academic_year' => $currentAcademicYear,
                            'status' => 'active',
                            'is_repeating' => false,
                            'promotion_status' => 'pending',
                            'birth_date' => now()->subYears(6 + $grade)->subDays(rand(1, 365)),
                            'address' => 'Jalan Contoh No. ' . rand(1, 100),
                            'parent_name' => 'Orang Tua ' . $name,
                            'parent_phone' => '08' . rand(1000000000, 9999999999),
                        ]);
                    }
                }
            }
        }

        // Update student counts for all classes
        $classes = SchoolClass::where('academic_year', $currentAcademicYear)->get();
        foreach ($classes as $class) {
            $class->updateStudentCount();
        }

        // Create classes for next academic year (for promotion testing)
        for ($grade = 1; $grade <= 6; $grade++) {
            foreach ($sections as $section) {
                $className = $grade . $section;

                // Check if class already exists for next year
                $existingClass = SchoolClass::where('name', $className)
                                           ->where('academic_year', $nextAcademicYear)
                                           ->first();

                if (!$existingClass) {
                    SchoolClass::create([
                        'name' => $className,
                        'grade_level' => $grade,
                        'section' => $section,
                        'capacity' => 30,
                        'current_students' => 0,
                        'homeroom_teacher' => 'Guru Kelas ' . $className,
                        'academic_year' => $nextAcademicYear,
                        'description' => 'Kelas ' . $className . ' - Kurikulum Merdeka',
                        'status' => 'active'
                    ]);
                }
            }
        }

        // Create some sample staff (only if not exists)
        $staffPositions = [
            'Kepala Sekolah', 'Wakil Kepala Sekolah', 'Guru Kelas 1', 'Guru Kelas 2',
            'Guru Kelas 3', 'Guru Kelas 4', 'Guru Kelas 5', 'Guru Kelas 6',
            'Guru Olahraga', 'Guru Agama', 'Guru Bahasa Inggris', 'Guru Seni'
        ];

        foreach ($staffPositions as $position) {
            $email = strtolower(str_replace(' ', '.', $position)) . '@sekolah.com';

            // Check if staff already exists
            $existingStaff = Staff::where('email', $email)->first();

            if (!$existingStaff) {
                Staff::create([
                    'nip' => '19' . rand(70, 90) . rand(10, 12) . rand(10, 31) . ' ' . rand(100000, 999999),
                    'name' => 'Staff ' . $position,
                    'gender' => rand(0, 1) ? 'Laki-laki' : 'Perempuan',
                    'position' => $position,
                    'address' => 'Alamat Staff ' . $position,
                    'phone' => '08' . rand(1000000000, 9999999999),
                    'email' => $email,
                    'birth_place' => 'Jakarta',
                    'birth_date' => now()->subYears(rand(25, 55)),
                    'religion' => 'Islam',
                    'education' => 'S1',
                    'join_year' => rand(2010, 2023),
                ]);
            }
        }
    }
}
