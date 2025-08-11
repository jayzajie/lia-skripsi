<?php

namespace App\Http\Controllers;

use App\Models\Formulir;
use App\Models\FormulirSubmission;
use App\Models\FormulirSementara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FormulirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data formulir sementara jika ada
        $formulir_sementara = FormulirSementara::where('user_id', Auth::id())->first();
        return view('dashboard.formulir', compact('formulir_sementara'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.formulir.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'nik' => 'required|string|max:16',
            'agama' => 'required|string|max:50',
            'alamat' => 'required|string',
            'anak_ke' => 'required|string|max:10',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ayah' => 'required|string|max:255',
            'pekerjaan_ibu' => 'required|string|max:255',
            'alamat_ortu' => 'required|string',
            'no_telp_ortu' => 'required|string|max:15',
            'foto_siswa' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Cek apakah ada formulir sementara yang sudah ada
        $formulir = FormulirSementara::where('user_id', Auth::id())->first();
        
        // Jika ada foto yang diupload
        $foto_path = null;
        if ($request->hasFile('foto_siswa')) {
            // Hapus foto lama jika ada
            if ($formulir && $formulir->foto_siswa) {
                Storage::disk('public')->delete($formulir->foto_siswa);
            }
            
            // Simpan foto baru
            $foto_path = $request->file('foto_siswa')->store('foto-siswa', 'public');
        } elseif ($formulir && $formulir->foto_siswa) {
            // Pertahankan foto yang sudah ada
            $foto_path = $formulir->foto_siswa;
        }

        // Data untuk disimpan
        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nik' => $request->nik,
            'agama' => $request->agama,
            'alamat' => $request->alamat,
            'anak_ke' => $request->anak_ke,
            'nama_ayah' => $request->nama_ayah,
            'nama_ibu' => $request->nama_ibu,
            'pekerjaan_ayah' => $request->pekerjaan_ayah,
            'pekerjaan_ibu' => $request->pekerjaan_ibu,
            'alamat_ortu' => $request->alamat_ortu,
            'no_telp_ortu' => $request->no_telp_ortu,
            'status' => 'draft',
            'user_id' => Auth::id(),
        ];
        
        // Tambahkan foto jika ada
        if ($foto_path) {
            $data['foto_siswa'] = $foto_path;
        }

        // Simpan atau update data
        FormulirSementara::updateOrCreate(
            ['user_id' => Auth::id()],
            $data
        );

        return redirect()->route('formulir.index')->with('success', 'Data formulir berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Formulir $formulir)
    {
        return view('dashboard.formulir.show', compact('formulir'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Formulir $formulir)
    {
        return view('dashboard.formulir.edit', compact('formulir'));
    }

    /**
     * Update the specified resource in storage.
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
            'anak_ke' => 'required|string|max:10',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ayah' => 'required|string|max:255',
            'pekerjaan_ibu' => 'required|string|max:255',
            'alamat_ortu' => 'required|string',
            'no_telp_ortu' => 'required|string|max:15',
        ]);

        $formulir->update([
            'nama_lengkap' => $request->nama_lengkap,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nik' => $request->nik,
            'agama' => $request->agama,
            'alamat' => $request->alamat,
            'anak_ke' => $request->anak_ke,
            'nama_ayah' => $request->nama_ayah,
            'nama_ibu' => $request->nama_ibu,
            'pekerjaan_ayah' => $request->pekerjaan_ayah,
            'pekerjaan_ibu' => $request->pekerjaan_ibu,
            'alamat_ortu' => $request->alamat_ortu,
            'no_telp_ortu' => $request->no_telp_ortu,
        ]);

        return redirect()->route('dashboard')->with('success', 'Data formulir berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Formulir $formulir)
    {
        if ($formulir->file_path) {
            Storage::disk('public')->delete($formulir->file_path);
        }
        
        // Delete all related submissions
        foreach ($formulir->submissions as $submission) {
            if ($submission->file_path) {
                Storage::disk('public')->delete($submission->file_path);
            }
            $submission->delete();
        }
        
        $formulir->delete();

        return redirect()->route('formulir.index')->with('success', 'Formulir berhasil dihapus.');
    }

    /**
     * Download the specified file.
     */
    public function download(Formulir $formulir)
    {
        return Storage::disk('public')->download($formulir->file_path, $formulir->judul);
    }

    /**
     * Submit a form response.
     */
    public function submitResponse(Request $request, Formulir $formulir)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
        ]);

        $file = $request->file('file');
        $filePath = $file->store('formulir-submissions', 'public');

        FormulirSubmission::create([
            'formulir_id' => $formulir->id,
            'user_id' => Auth::id(),
            'file_path' => $filePath,
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Formulir berhasil dikirim.');
    }

    /**
     * Submit the form for verification.
     */
    public function submit(Formulir $formulir)
    {
        // Check if all required berkas are uploaded
        $berkas = $formulir->berkas;
        $requiredTypes = ['kartu_keluarga', 'akte_kelahiran', 'pas_foto', 'ktp_ortu'];
        $uploadedTypes = $berkas->pluck('jenis_berkas')->toArray();
        
        $missingTypes = array_diff($requiredTypes, $uploadedTypes);
        
        if (count($missingTypes) > 0) {
            return redirect()->back()->with('error', 'Mohon upload semua berkas yang diperlukan sebelum mengirimkan formulir.');
        }
        
        $formulir->update(['status' => 'submitted']);
        
        return redirect()->route('dashboard')->with('success', 'Formulir pendaftaran berhasil dikirim untuk diverifikasi.');
    }

    /**
     * Print the form.
     */
    public function print(Formulir $formulir)
    {
        return view('dashboard.formulir.print', compact('formulir'));
    }
}