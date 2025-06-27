<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TutorialApiController extends Controller
{
    /**
     * Mengambil daftar tutorial berdasarkan kode mata kuliah.
     */
    public function getTutorialsByCourse($courseCode)
    {
        // 1. Cari semua tutorial di database yang cocok
        // PERUBAHAN: Tambahkan 'course_name' ke dalam select
        $tutorials = Tutorial::where('course_code', $courseCode)
            ->select('title', 'course_code', 'course_name', 'presentation_url', 'finished_url', 'creator_email', 'created_at', 'updated_at')
            ->get();

        // 2. Handle jika tidak ditemukan
        if ($tutorials->isEmpty()) {
            return response()->json([
                'results' => [],
                'status' => ['code' => 404, 'description' => 'Not Found data ' . $courseCode]
            ], 404);
        }

        // 3. Format data (sekarang jauh lebih sederhana)
        $formattedTutorials = $tutorials->map(function ($tutorial) {
            return [
                'kode_matkul' => $tutorial->course_code,
                'nama_matkul' => $tutorial->course_name, // Ambil langsung dari DB
                'judul' => $tutorial->title,
                'url_presentation' => route('presentation.show', $tutorial->presentation_url),
                'url_finished' => route('finished.show', $tutorial->finished_url),
                'creator_email' => $tutorial->creator_email,
                'created_at' => $tutorial->created_at->toDateTimeString(),
                'updated_at' => $tutorial->updated_at->toDateTimeString(),
            ];
        });

        // 4. Kirim respons
        return response()->json([
            'results' => $formattedTutorials,
            'status' => ['code' => 200, 'description' => 'OK']
        ]);
    }
}
