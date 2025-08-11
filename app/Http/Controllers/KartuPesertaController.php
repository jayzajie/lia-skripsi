<?php

namespace App\Http\Controllers;

use App\Models\FormulirSementara;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class KartuPesertaController extends Controller
{
    public function generatePDF($id)
    {
        // Jika id adalah 0, redirect ke halaman formulir dengan pesan
        if ($id == 0) {
            return redirect()->route('formulir.index')
                ->with('error', 'Silakan isi dan simpan formulir terlebih dahulu sebelum mencetak kartu peserta.');
        }

        $formulir = FormulirSementara::findOrFail($id);

        // Periksa apakah foto siswa ada dan konversi ke base64
        if ($formulir->foto_siswa) {
            if (Storage::disk('public')->exists($formulir->foto_siswa)) {
                \Illuminate\Support\Facades\Log::info("Foto siswa ditemukan: " . $formulir->foto_siswa);

                try {
                    // Konversi gambar ke base64 untuk DomPDF
                    $path = storage_path('app/public/' . $formulir->foto_siswa);
                    $type = pathinfo($path, PATHINFO_EXTENSION);

                    // Optimasi gambar untuk PDF
                    $imageData = $this->optimizeImageForPDF($path, $type);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($imageData);
                    $formulir->foto_base64 = $base64;
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Error processing foto: " . $e->getMessage());
                    $formulir->foto_siswa = null;
                    $formulir->foto_base64 = null;
                }
            } else {
                \Illuminate\Support\Facades\Log::warning("Foto siswa tidak ditemukan: " . $formulir->foto_siswa);
                $formulir->foto_siswa = null;
                $formulir->foto_base64 = null;
            }
        }

        // Konfigurasi DomPDF options terlebih dahulu
        $options = new \Dompdf\Options();
        $options->set('isPhpEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Arial');
        $options->set('dpi', 96);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        // Load view dengan options
        $pdf = PDF::loadView('dashboard.kartu_peserta', ['formulir' => $formulir]);
        $pdf->getDomPDF()->setOptions($options);

        // Set paper A4 landscape untuk desain kartu yang baru
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Kartu_Peserta_' . str_replace(' ', '_', $formulir->nama_lengkap) . '.pdf');
    }

    /**
     * Optimasi gambar untuk PDF agar ukuran file tidak terlalu besar
     * dan kualitas tetap baik untuk kartu peserta
     */
    private function optimizeImageForPDF($imagePath, $imageType)
    {
        // Jika GD extension tidak tersedia, return file asli
        if (!extension_loaded('gd')) {
            return file_get_contents($imagePath);
        }

        try {
            // Baca gambar berdasarkan tipe
            switch (strtolower($imageType)) {
                case 'jpg':
                case 'jpeg':
                    $image = imagecreatefromjpeg($imagePath);
                    break;
                case 'png':
                    $image = imagecreatefrompng($imagePath);
                    break;
                case 'gif':
                    $image = imagecreatefromgif($imagePath);
                    break;
                default:
                    return file_get_contents($imagePath);
            }

            if (!$image) {
                return file_get_contents($imagePath);
            }

            // Dapatkan dimensi asli
            $originalWidth = imagesx($image);
            $originalHeight = imagesy($image);

            // Tentukan ukuran target (3x4 ratio, max width 300px untuk kualitas baik)
            $targetWidth = 300;
            $targetHeight = 400;

            // Hitung ratio untuk maintain aspect ratio
            $ratio = min($targetWidth / $originalWidth, $targetHeight / $originalHeight);
            $newWidth = (int)($originalWidth * $ratio);
            $newHeight = (int)($originalHeight * $ratio);

            // Buat gambar baru dengan ukuran yang dioptimasi
            $optimizedImage = imagecreatetruecolor($newWidth, $newHeight);

            // Preserve transparency untuk PNG
            if (strtolower($imageType) === 'png') {
                imagealphablending($optimizedImage, false);
                imagesavealpha($optimizedImage, true);
                $transparent = imagecolorallocatealpha($optimizedImage, 255, 255, 255, 127);
                imagefill($optimizedImage, 0, 0, $transparent);
            }

            // Resize gambar
            imagecopyresampled($optimizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

            // Convert ke string
            ob_start();
            switch (strtolower($imageType)) {
                case 'jpg':
                case 'jpeg':
                    imagejpeg($optimizedImage, null, 85); // Quality 85%
                    break;
                case 'png':
                    imagepng($optimizedImage, null, 6); // Compression level 6
                    break;
                case 'gif':
                    imagegif($optimizedImage);
                    break;
            }
            $imageData = ob_get_contents();
            ob_end_clean();

            // Cleanup
            imagedestroy($image);
            imagedestroy($optimizedImage);

            return $imageData;

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error optimizing image: " . $e->getMessage());
            return file_get_contents($imagePath);
        }
    }
}
