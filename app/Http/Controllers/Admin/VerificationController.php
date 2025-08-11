<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formulir;
use App\Models\FormulirSementara;
use App\Models\BerkasSementara;
use App\Models\Konfirmasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VerificationController extends Controller
{
    /**
     * Display a listing of pending verifications.
     */
    public function index()
    {
        // Ambil data dari konfirmasi yang sudah dikonfirmasi user tapi belum diverifikasi admin
        $pendingVerifications = Konfirmasi::with(['user'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.verification.index', compact('pendingVerifications'));
    }

    /**
     * Show the verification details.
     */
    public function show(Konfirmasi $konfirmasi)
    {
        // Cari di formulir sementara dulu, jika tidak ada cari di formulir final
        $formulir = FormulirSementara::where('user_id', $konfirmasi->user_id)->first();
        if (!$formulir) {
            $formulir = Formulir::where('user_id', $konfirmasi->user_id)->latest()->first();
        }

        $berkas = BerkasSementara::where('user_id', $konfirmasi->user_id)->get()->keyBy('jenis_berkas');

        return view('admin.verification.show', compact('konfirmasi', 'formulir', 'berkas'));
    }

    /**
     * Approve a student registration.
     */
    public function approve(Request $request, Konfirmasi $konfirmasi)
    {
        // Cari formulir di kedua tabel
        $formulir = FormulirSementara::where('user_id', $konfirmasi->user_id)->first();
        if (!$formulir) {
            $formulir = Formulir::where('user_id', $konfirmasi->user_id)->latest()->first();
        }

        if (!$formulir) {
            return redirect()->route('admin.verification.index')
                ->with('error', 'Data formulir tidak ditemukan.');
        }

        $konfirmasi->update([
            'status' => 'approved',
            'keterangan' => $request->keterangan ?? 'Pendaftaran disetujui oleh admin',
        ]);

        return redirect()->route('admin.verification.index')
            ->with('success', "✅ Pendaftaran atas nama <strong>{$formulir->nama_lengkap}</strong> telah <strong>DISETUJUI</strong>. Siswa dapat melanjutkan ke tahap berikutnya.");
    }

    /**
     * Reject a student registration.
     */
    public function reject(Request $request, Konfirmasi $konfirmasi)
    {
        $request->validate([
            'keterangan' => 'required|string|max:500',
        ], [
            'keterangan.required' => 'Alasan penolakan harus diisi.',
            'keterangan.max' => 'Alasan penolakan maksimal 500 karakter.',
        ]);

        // Cari formulir di kedua tabel
        $formulir = FormulirSementara::where('user_id', $konfirmasi->user_id)->first();
        if (!$formulir) {
            $formulir = Formulir::where('user_id', $konfirmasi->user_id)->latest()->first();
        }

        if (!$formulir) {
            return redirect()->route('admin.verification.index')
                ->with('error', 'Data formulir tidak ditemukan.');
        }

        $konfirmasi->update([
            'status' => 'rejected',
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.verification.index')
            ->with('error', "❌ Pendaftaran atas nama <strong>{$formulir->nama_lengkap}</strong> telah <strong>DITOLAK</strong>.<br><strong>Alasan:</strong> {$request->keterangan}");
    }

    /**
     * View berkas file.
     */
    public function viewBerkas(BerkasSementara $berkas)
    {
        if (!Storage::disk('public')->exists($berkas->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        return Storage::disk('public')->response($berkas->file_path);
    }

    /**
     * Download berkas file.
     */
    public function downloadBerkas(BerkasSementara $berkas)
    {
        if (!Storage::disk('public')->exists($berkas->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        $fileName = $berkas->jenis_berkas . '_' . $berkas->user->name . '.' . pathinfo($berkas->file_path, PATHINFO_EXTENSION);

        return Storage::disk('public')->download($berkas->file_path, $fileName);
    }

    /**
     * Cetak kartu peserta.
     */
    public function cetakKartu(Konfirmasi $konfirmasi)
    {
        // Cari formulir siswa
        $formulir = FormulirSementara::where('user_id', $konfirmasi->user_id)->first();
        if (!$formulir) {
            $formulir = Formulir::where('user_id', $konfirmasi->user_id)->latest()->first();
        }

        if (!$formulir) {
            abort(404, 'Data formulir tidak ditemukan');
        }

        // Cari foto siswa
        $foto = BerkasSementara::where('user_id', $konfirmasi->user_id)
            ->where('jenis_berkas', 'pas_foto')
            ->first();

        // Generate nomor pendaftaran jika belum ada
        if (!$formulir->nomor_pendaftaran) {
            $tahun = date('Y');
            $lastNumber = Formulir::whereYear('created_at', $tahun)
                ->whereNotNull('nomor_pendaftaran')
                ->count();

            $nomorPendaftaran = $tahun . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

            // Update nomor pendaftaran
            if ($formulir instanceof FormulirSementara) {
                $formulir->update(['nomor_pendaftaran' => $nomorPendaftaran]);
            } else {
                $formulir->update(['nomor_pendaftaran' => $nomorPendaftaran]);
            }
        }

        return view('admin.verification.kartu', compact('formulir', 'foto', 'konfirmasi'));
    }
}
