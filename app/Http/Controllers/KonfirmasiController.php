<?php

namespace App\Http\Controllers;

use App\Models\Konfirmasi;
use App\Models\FormulirSementara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Formulir;
use App\Models\BerkasSementara;
use App\Models\Berkas;
use App\Models\BuktiPembayaran;

class KonfirmasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $konfirmasis = Konfirmasi::all();
        $formulir = FormulirSementara::where('user_id', Auth::id())->first();
        $buktiPembayaran = BuktiPembayaran::where('user_id', Auth::id())->latest()->first();

        // Cari status konfirmasi pendaftaran user
        $statusKonfirmasi = Konfirmasi::where('user_id', Auth::id())->latest()->first();

        return view('dashboard.konfirmasi', compact('konfirmasis', 'formulir', 'buktiPembayaran', 'statusKonfirmasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.konfirmasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_konfirmasi' => 'required|date',
        ]);

        Konfirmasi::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal_konfirmasi' => $request->tanggal_konfirmasi,
            'status' => 'pending',
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('konfirmasi.index')->with('success', 'Konfirmasi berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Konfirmasi $konfirmasi)
    {
        return view('dashboard.konfirmasi.show', compact('konfirmasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Konfirmasi $konfirmasi)
    {
        return view('dashboard.konfirmasi.edit', compact('konfirmasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Konfirmasi $konfirmasi)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_konfirmasi' => 'required|date',
            'status' => 'required|in:pending,approved,rejected',
            'keterangan' => 'nullable|string',
        ]);

        $konfirmasi->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal_konfirmasi' => $request->tanggal_konfirmasi,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('konfirmasi.index')->with('success', 'Konfirmasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Konfirmasi $konfirmasi)
    {
        $konfirmasi->delete();

        return redirect()->route('konfirmasi.index')->with('success', 'Konfirmasi berhasil dihapus.');
    }

    /**
     * Approve the specified konfirmasi.
     */
    public function approve(Request $request, Konfirmasi $konfirmasi)
    {
        $request->validate([
            'keterangan' => 'nullable|string',
        ]);

        $konfirmasi->update([
            'status' => 'approved',
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('konfirmasi.index')->with('success', 'Konfirmasi berhasil disetujui.');
    }

    /**
     * Reject the specified konfirmasi.
     */
    public function reject(Request $request, Konfirmasi $konfirmasi)
    {
        $request->validate([
            'keterangan' => 'required|string',
        ]);

        $konfirmasi->update([
            'status' => 'rejected',
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('konfirmasi.index')->with('success', 'Konfirmasi berhasil ditolak.');
    }

    public function konfirmasiFinal(Request $request)
    {
        $userId = Auth::id();

        Log::info('Konfirmasi final dimulai untuk user: ' . $userId);

        $request->validate([
            'konfirmasi_check' => 'accepted'
        ], [
            'konfirmasi_check.accepted' => 'Anda harus menyetujui pernyataan konfirmasi terlebih dahulu.'
        ]);

        $formulirSementara = FormulirSementara::where('user_id', $userId)->first();
        $berkasSementara = BerkasSementara::where('user_id', $userId)->get();

        if (!$formulirSementara) {
            return redirect()->back()->with('error', 'Formulir pendaftaran belum dilengkapi.');
        }

        $jenisBerkasWajib = ['kartu_keluarga', 'akte_kelahiran', 'pas_foto', 'ktp_ortu'];
        $userBerkas = $berkasSementara->pluck('jenis_berkas')->toArray();

        foreach ($jenisBerkasWajib as $jenis) {
            if (!in_array($jenis, $userBerkas)) {
                return redirect()->back()->with('error', 'Berkas ' . $jenis . ' belum diupload.');
            }
        }

        $buktiPembayaran = BuktiPembayaran::where('user_id', $userId)->where('status', 'approved')->first();
        if (!$buktiPembayaran) {
            return redirect()->back()->with('error', 'Bukti pembayaran belum diupload atau belum diterima. Silakan upload bukti pembayaran terlebih dahulu.');
        }

        try {
            DB::beginTransaction();

            if ($formulirSementara) {
                $formulir = new Formulir($formulirSementara->toArray());
                $formulir->user_id = $userId;
                $formulir->status = 'submitted';
                $formulir->save();
                $formulirSementara->delete();
            }

            foreach ($berkasSementara as $berkasTemp) {
                $data = $berkasTemp->toArray();
                $data['status'] = 'pending'; // status valid untuk tabel berkas
                $berkas = new Berkas($data);
                $berkas->user_id = $userId;
                $berkas->save();
                $berkasTemp->delete();
            }

            Konfirmasi::create([
                'judul' => 'Konfirmasi Pendaftaran PPDB',
                'deskripsi' => 'Konfirmasi pendaftaran siswa baru untuk tahun ajaran ' . date('Y') . '/' . (date('Y') + 1),
                'status' => 'pending',
                'user_id' => $userId,
                'tanggal_konfirmasi' => now()->toDateString(),
                'keterangan' => 'Pendaftaran telah dikonfirmasi oleh calon siswa'
            ]);

            DB::commit();

            return redirect()->route('konfirmasi.index')->with('success', 'Pendaftaran berhasil dikonfirmasi! Data Anda akan diverifikasi oleh admin.');

        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Error dalam konfirmasi final: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses konfirmasi. Silakan coba lagi. Error: ' . $e->getMessage());
        }
    }

    public function uploadBukti(Request $request)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'keterangan_pembayaran' => 'nullable|string|max:500'
        ], [
            'bukti_pembayaran.required' => 'File bukti pembayaran harus diupload.',
            'bukti_pembayaran.mimes' => 'File harus berformat JPG, PNG, atau PDF.',
            'bukti_pembayaran.max' => 'Ukuran file maksimal 2MB.'
        ]);

        try {
            $userId = Auth::id();
            $file = $request->file('bukti_pembayaran');

            // Generate nama file unik
            $fileName = time() . '_' . $userId . '_' . $file->getClientOriginalName();

            // Simpan file ke storage
            $filePath = $file->storeAs('bukti-pembayaran', $fileName, 'public');

            // Hapus bukti pembayaran lama jika ada
            $buktiLama = BuktiPembayaran::where('user_id', $userId)->first();
            if ($buktiLama) {
                // Hapus file lama
                if (Storage::disk('public')->exists($buktiLama->path_file)) {
                    Storage::disk('public')->delete($buktiLama->path_file);
                }
                $buktiLama->delete();
            }

            // Simpan data ke database
            BuktiPembayaran::create([
                'user_id' => $userId,
                'nama_file' => $file->getClientOriginalName(),
                'path_file' => $filePath,
                'jenis_pembayaran' => 'pendaftaran',
                'keterangan' => $request->keterangan_pembayaran,
                'status' => 'approved',
                'catatan_admin' => 'Bukti pembayaran diterima secara otomatis',
                'tanggal_upload' => now()
            ]);

            return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload dan diterima! Anda dapat melanjutkan proses konfirmasi pendaftaran.');

        } catch (\Exception $e) {
            Log::error('Error upload bukti pembayaran: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupload bukti pembayaran. Silakan coba lagi.');
        }
    }
}
