<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formulir;
use App\Models\Berkas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of all registered students.
     */
    public function index(Request $request)
    {
        $query = Formulir::where('status', 'verified');
        
        // Tambahkan fitur pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }
        
        $students = $query->orderBy('nama_lengkap', 'asc')
                         ->paginate(10);
        
        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the student details.
     */
    public function show(Formulir $formulir)
    {
        $berkas = Berkas::where('formulir_id', $formulir->id)->get()->keyBy('jenis_berkas');
        
        return view('admin.students.show', compact('formulir', 'berkas'));
    }

    /**
     * Show the form for editing the student.
     */
    public function edit(Formulir $formulir)
    {
        return view('admin.students.edit', compact('formulir'));
    }

    /**
     * Update the student information.
     */
    public function update(Request $request, Formulir $formulir)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'nik' => 'required|string|max:16',
            'agama' => 'required|string|max:50',
            'alamat' => 'required|string',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ayah' => 'required|string|max:255',
            'pekerjaan_ibu' => 'required|string|max:255',
            'alamat_ortu' => 'required|string',
            'no_telp_ortu' => 'required|string|max:15',
        ]);

        $formulir->update($request->all());
        
        return redirect()->route('admin.students.show', $formulir)
            ->with('success', 'Data siswa berhasil diperbarui');
    }

    /**
     * Remove the student from the system.
     */
    public function destroy(Formulir $formulir)
    {
        // Delete related berkas
        $berkas = Berkas::where('formulir_id', $formulir->id)->get();
        
        foreach ($berkas as $b) {
            if ($b->file_path) {
                Storage::disk('public')->delete($b->file_path);
            }
            $b->delete();
        }
        
        // Delete the formulir
        $formulir->delete();
        
        return redirect()->route('admin.students.index')
            ->with('success', 'Data siswa berhasil dihapus');
    }
}