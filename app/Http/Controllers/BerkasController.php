<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use App\Models\BerkasSementara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BerkasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $berkas = Berkas::where('user_id', Auth::id())->get();
        return view('dashboard.berkas', compact('berkas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $formulir_id = $request->formulir_id;
        return view('dashboard.berkas', compact('formulir_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kartu_keluarga' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'akte_kelahiran' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'pas_foto' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'ktp_ortu' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $userId = Auth::id();
        $formulirId = $request->formulir_id;

        $fileKK = $request->file('kartu_keluarga');
        $filePathKK = $fileKK->store('berkas/kartu-keluarga', 'public');
        Berkas::create([
            'jenis_berkas' => 'kartu_keluarga',
            'file_path' => $filePathKK,
            'user_id' => $userId,
            'formulir_id' => $formulirId,
            'status' => 'pending',
        ]);

        $fileAkte = $request->file('akte_kelahiran');
        $filePathAkte = $fileAkte->store('berkas/akte-kelahiran', 'public');
        Berkas::create([
            'jenis_berkas' => 'akte_kelahiran',
            'file_path' => $filePathAkte,
            'user_id' => $userId,
            'formulir_id' => $formulirId,
            'status' => 'pending',
        ]);

        $fileFoto = $request->file('pas_foto');
        $filePathFoto = $fileFoto->store('berkas/pas-foto', 'public');
        Berkas::create([
            'jenis_berkas' => 'pas_foto',
            'file_path' => $filePathFoto,
            'user_id' => $userId,
            'formulir_id' => $formulirId,
            'status' => 'pending',
        ]);

        $fileKTP = $request->file('ktp_ortu');
        $filePathKTP = $fileKTP->store('berkas/ktp-ortu', 'public');
        Berkas::create([
            'jenis_berkas' => 'ktp_ortu',
            'file_path' => $filePathKTP,
            'user_id' => $userId,
            'formulir_id' => $formulirId,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Berkas berhasil diunggah.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Berkas $berkas)
    {
        return view('dashboard.berkas.show', compact('berkas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Berkas $berkas)
    {
        return view('dashboard.berkas.edit', compact('berkas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Berkas $berkas)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($berkas->file_path) {
            Storage::disk('public')->delete($berkas->file_path);
        }

        $file = $request->file('file');
        $folder = 'berkas/';

        switch ($berkas->jenis_berkas) {
            case 'kartu_keluarga':
                $folder .= 'kartu-keluarga';
                break;
            case 'akte_kelahiran':
                $folder .= 'akte-kelahiran';
                break;
            case 'pas_foto':
                $folder .= 'pas-foto';
                break;
            case 'ktp_ortu':
                $folder .= 'ktp-ortu';
                break;
        }

        $filePath = $file->store($folder, 'public');

        $berkas->update([
            'file_path' => $filePath,
            'status' => 'pending',
        ]);

        return redirect()->route('berkas.index')->with('success', 'Berkas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Berkas $berkas)
    {
        if ($berkas->file_path) {
            Storage::disk('public')->delete($berkas->file_path);
        }

        $berkas->delete();

        return redirect()->route('berkas.index')->with('success', 'Berkas berhasil dihapus.');
    }

    /**
     * Download the specified file.
     */
    public function download(Berkas $berkas)
    {
        return Storage::disk('public')->download($berkas->file_path);
    }

    /**
     * Store a newly created resource in berkas_sementara (draft).
     */
    public function storeSementara(Request $request)
    {
        $request->validate([
            'jenis_berkas' => 'required|in:kartu_keluarga,akte_kelahiran,pas_foto,ktp_ortu',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $userId = Auth::id();
        $file = $request->file('file');
        $filePath = $file->store('berkas_sementara/' . $request->jenis_berkas, 'public');

        BerkasSementara::updateOrCreate(
            [
                'user_id' => $userId,
                'jenis_berkas' => $request->jenis_berkas,
            ],
            [
                'file_path' => $filePath,
                'status' => 'draft',
            ]
        );

        return redirect()->route('berkas.index')->with('success', 'Berkas sementara berhasil diupload.');
    }

    /**
     * Finalisasi semua berkas_sementara user ke tabel berkas utama.
     */
    public function finalisasi()
    {
        $userId = Auth::id();
        $berkasSementara = BerkasSementara::where('user_id', $userId)->get();

        foreach ($berkasSementara as $bs) {
            Berkas::create([
                'jenis_berkas' => $bs->jenis_berkas,
                'file_path' => $bs->file_path,
                'user_id' => $userId,
                'status' => 'pending',
                'keterangan' => $bs->keterangan,
            ]);
            $bs->status = 'final';
            $bs->save();
        }

        return redirect()->route('berkas.index')->with('success', 'Berkas berhasil difinalisasi.');
    }
}
