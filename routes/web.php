<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BerkasController;
use App\Http\Controllers\FormulirController;
use App\Http\Controllers\KonfirmasiController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\VerificationController;
use App\Http\Controllers\Admin\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KartuPesertaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index'])->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard.home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Formulir routes
    Route::get('/dashboard/formulir', [FormulirController::class, 'index'])->name('formulir.index');
    Route::post('/dashboard/formulir', [FormulirController::class, 'store'])->name('formulir.store');
    Route::get('/dashboard/formulir/{formulir}', [FormulirController::class, 'show'])->name('formulir.show');
    Route::get('/dashboard/formulir/{formulir}/edit', [FormulirController::class, 'edit'])->name('formulir.edit');
    Route::put('/dashboard/formulir/{formulir}', [FormulirController::class, 'update'])->name('formulir.update');
    Route::post('/dashboard/formulir/{formulir}/submit', [FormulirController::class, 'submit'])->name('formulir.submit');
    Route::get('/dashboard/formulir/{formulir}/print', [FormulirController::class, 'print'])->name('formulir.print');

    // Berkas routes
    Route::get('/dashboard/berkas', [BerkasController::class, 'index'])->name('berkas.index');
    Route::get('/dashboard/berkas/create', [BerkasController::class, 'create'])->name('berkas.create');
    Route::post('/dashboard/berkas', [BerkasController::class, 'store'])->name('berkas.store');
    Route::get('/dashboard/berkas/{berkas}', [BerkasController::class, 'show'])->name('berkas.show');
    Route::get('/dashboard/berkas/{berkas}/edit', [BerkasController::class, 'edit'])->name('berkas.edit');
    Route::put('/dashboard/berkas/{berkas}', [BerkasController::class, 'update'])->name('berkas.update');
    Route::delete('/dashboard/berkas/{berkas}', [BerkasController::class, 'destroy'])->name('berkas.destroy');
    Route::get('/dashboard/berkas/{berkas}/download', [BerkasController::class, 'download'])->name('berkas.download');
    Route::post('/dashboard/berkas-sementara', [BerkasController::class, 'storeSementara'])->name('berkas.sementara.store');
    Route::post('/dashboard/berkas/finalisasi', [BerkasController::class, 'finalisasi'])->name('berkas.finalisasi');

    // Konfirmasi routes
    Route::get('/dashboard/konfirmasi', [KonfirmasiController::class, 'index'])->name('konfirmasi.index');
    Route::get('/dashboard/konfirmasi/create', [KonfirmasiController::class, 'create'])->name('konfirmasi.create');
    Route::post('/dashboard/konfirmasi', [KonfirmasiController::class, 'store'])->name('konfirmasi.store');
    Route::get('/dashboard/konfirmasi/{konfirmasi}', [KonfirmasiController::class, 'show'])->name('konfirmasi.show');
    Route::get('/dashboard/konfirmasi/{konfirmasi}/edit', [KonfirmasiController::class, 'edit'])->name('konfirmasi.edit');
    Route::put('/dashboard/konfirmasi/{konfirmasi}', [KonfirmasiController::class, 'update'])->name('konfirmasi.update');
    Route::delete('/dashboard/konfirmasi/{konfirmasi}', [KonfirmasiController::class, 'destroy'])->name('konfirmasi.destroy');
    Route::post('/dashboard/konfirmasi/{konfirmasi}/approve', [KonfirmasiController::class, 'approve'])->name('konfirmasi.approve');
    Route::post('/dashboard/konfirmasi/{konfirmasi}/reject', [KonfirmasiController::class, 'reject'])->name('konfirmasi.reject');
    Route::post('/dashboard/konfirmasi-final', [KonfirmasiController::class, 'konfirmasiFinal'])->name('konfirmasi.final');
    Route::post('/dashboard/konfirmasi/upload-bukti', [KonfirmasiController::class, 'uploadBukti'])->name('konfirmasi.upload-bukti');

    // Pengumuman routes
    Route::get('/dashboard/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::get('/dashboard/pengumuman/create', [PengumumanController::class, 'create'])->name('pengumuman.create');
    Route::post('/dashboard/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
    Route::get('/dashboard/pengumuman/{pengumuman}', [PengumumanController::class, 'show'])->name('pengumuman.show');
    Route::get('/dashboard/pengumuman/{pengumuman}/edit', [PengumumanController::class, 'edit'])->name('pengumuman.edit');
    Route::put('/dashboard/pengumuman/{pengumuman}', [PengumumanController::class, 'update'])->name('pengumuman.update');
    Route::delete('/dashboard/pengumuman/{pengumuman}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');

    // Admin routes - temporarily available to all authenticated users for testing
    Route::prefix('admin')->name('admin.')->group(function () {
        // Admin Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Verification routes
        Route::get('/verification', [VerificationController::class, 'index'])->name('verification.index');
        Route::get('/verification/{konfirmasi}', [VerificationController::class, 'show'])->name('verification.show');
        Route::post('/verification/{konfirmasi}/approve', [VerificationController::class, 'approve'])->name('verification.approve');
        Route::post('/verification/{konfirmasi}/reject', [VerificationController::class, 'reject'])->name('verification.reject');
        Route::get('/verification/berkas/{berkas}/view', [VerificationController::class, 'viewBerkas'])->name('verification.berkas.view');
        Route::get('/verification/berkas/{berkas}/download', [VerificationController::class, 'downloadBerkas'])->name('verification.berkas.download');

        // Cetak Kartu Peserta
        Route::get('/verification/{konfirmasi}/kartu', [VerificationController::class, 'cetakKartu'])->name('verification.kartu');

        // Student Management routes
        Route::get('/students', [StudentController::class, 'index'])->name('students.index');
        Route::get('/students/{formulir}', [StudentController::class, 'show'])->name('students.show');
        Route::get('/students/{formulir}/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::put('/students/{formulir}', [StudentController::class, 'update'])->name('students.update');
        Route::delete('/students/{formulir}', [StudentController::class, 'destroy'])->name('students.destroy');
    });
});

// Super Admin Routes - temporarily available to all authenticated users for development
// Tambahkan di bagian routes superadmin
Route::middleware(['auth'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'index'])->name('dashboard');

    // Students routes
    Route::resource('students', App\Http\Controllers\SuperAdmin\StudentController::class);

    // Staff routes
    Route::resource('staff', App\Http\Controllers\SuperAdmin\StaffController::class);

    // Classes routes
    Route::resource('classes', App\Http\Controllers\Superadmin\ClassController::class);

    // Activities routes
    Route::resource('activities', App\Http\Controllers\SuperAdmin\ActivityController::class);
    Route::put('activities/{activity}/toggle-published', [App\Http\Controllers\SuperAdmin\ActivityController::class, 'togglePublished'])->name('activities.toggle-published');

    // Evaluations routes
    Route::resource('evaluations', App\Http\Controllers\SuperAdmin\EvaluationController::class);
    Route::get('evaluations/student-report', [App\Http\Controllers\SuperAdmin\EvaluationController::class, 'studentReport'])->name('evaluations.studentReport');
    Route::get('evaluations/class-report', [App\Http\Controllers\SuperAdmin\EvaluationController::class, 'classReport'])->name('evaluations.classReport');

    // Subjects routes
    Route::resource('subjects', App\Http\Controllers\SuperAdmin\SubjectController::class);

    // Schedules routes
    Route::get('/schedule', [App\Http\Controllers\SuperAdmin\ScheduleController::class, 'index'])->name('schedule');
    Route::resource('schedules', App\Http\Controllers\SuperAdmin\ScheduleController::class);
    Route::get('/schedules/view-by-day', [App\Http\Controllers\SuperAdmin\ScheduleController::class, 'viewByDay'])->name('viewByDay');
    Route::get('/schedules/view-by-class', [App\Http\Controllers\SuperAdmin\ScheduleController::class, 'viewByClass'])->name('viewByClass');
    Route::put('schedules/{schedule}/toggle-status', [App\Http\Controllers\SuperAdmin\ScheduleController::class, 'toggleStatus'])->name('schedules.toggleStatus');
    Route::put('schedules/update-day/{day}', [App\Http\Controllers\SuperAdmin\ScheduleController::class, 'updateDay'])->name('schedules.update-day');
    Route::put('schedules/update-class/{class}', [App\Http\Controllers\SuperAdmin\ScheduleController::class, 'updateClass'])->name('schedules.update-class');

    // Academic Year routes
    Route::resource('academic-years', App\Http\Controllers\SuperAdmin\AcademicYearController::class);
    Route::put('academic-years/{academicYear}/set-active', [App\Http\Controllers\SuperAdmin\AcademicYearController::class, 'setActive'])->name('academic-years.set-active');

    // User Management routes
    Route::resource('users', App\Http\Controllers\SuperAdmin\UserController::class);

    // Rombel Management routes
    Route::prefix('rombel')->name('rombel.')->group(function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\RombelController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\SuperAdmin\RombelController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\SuperAdmin\RombelController::class, 'store'])->name('store');
        Route::get('/promotion', [App\Http\Controllers\SuperAdmin\RombelController::class, 'promotion'])->name('promotion');
        Route::post('/process-promotion', [App\Http\Controllers\SuperAdmin\RombelController::class, 'processPromotion'])->name('process-promotion');
        Route::post('/auto-promotion', [App\Http\Controllers\SuperAdmin\RombelController::class, 'autoPromotion'])->name('auto-promotion');
    });
});

// Tambahkan di bagian routes admin
Route::prefix('admin')->name('admin.')->group(function () {
    // Academic Year routes (dengan tambahan create dan store)
    Route::get('/academic-years', [App\Http\Controllers\Admin\AcademicYearController::class, 'index'])->name('academic-years.index');
    Route::get('/academic-years/create', [App\Http\Controllers\Admin\AcademicYearController::class, 'create'])->name('academic-years.create');
    Route::post('/academic-years', [App\Http\Controllers\Admin\AcademicYearController::class, 'store'])->name('academic-years.store');
    Route::get('/academic-years/{academicYear}/edit', [App\Http\Controllers\Admin\AcademicYearController::class, 'edit'])->name('academic-years.edit');
    Route::put('/academic-years/{academicYear}', [App\Http\Controllers\Admin\AcademicYearController::class, 'update'])->name('academic-years.update');
    Route::put('/academic-years/{academicYear}/set-active', [App\Http\Controllers\Admin\AcademicYearController::class, 'setActive'])->name('academic-years.set-active');
});

// Pindahkan rute kartu peserta ke luar grup admin dan tambahkan middleware auth
Route::get('/kartu-peserta/{id}', [KartuPesertaController::class, 'generatePDF'])->middleware('auth')->name('kartu.peserta.pdf');

require __DIR__.'/auth.php';
