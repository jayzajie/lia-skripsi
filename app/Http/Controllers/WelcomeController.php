<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Staff;

class WelcomeController extends Controller
{
    public function index()
    {
        // Hitung jumlah siswa dari database
        $jumlahSiswa = Student::count();

        // Hitung jumlah guru dari tabel staff
        $jumlahGuru = Staff::count();

        // Jumlah kelas tetap 12 (1A, 1B, 2A, 2B, 3A, 3B, 4A, 4B, 5A, 5B, 6A, 6B)
        $jumlahKelas = 12;

        return view('welcome', compact('jumlahSiswa', 'jumlahGuru', 'jumlahKelas'));
    }
}
