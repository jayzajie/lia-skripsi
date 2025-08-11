<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formulir;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        // Get statistics for the dashboard
        $totalStudents = Formulir::count();
        $maleStudents = Formulir::where('jenis_kelamin', 'Laki-Laki')->count();
        $femaleStudents = Formulir::where('jenis_kelamin', 'Perempuan')->count();
        $pendingVerification = Formulir::where('status', 'submitted')->count();

        return view('admin.dashboard', compact('totalStudents', 'maleStudents', 'femaleStudents', 'pendingVerification'));
    }
} 