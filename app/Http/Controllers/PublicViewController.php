<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PublicViewController extends Controller
{
    public function showPresentation($slug)
    {
        // Cari tutorial di database, atau tampilkan halaman 404 jika tidak ditemukan.
        $tutorial = Tutorial::where('presentation_url', $slug)->firstOrFail();

        // Ambil HANYA detail dengan status 'show' untuk tampilan awal
        $visibleDetails = $tutorial->details()->where('status', 'show')->get();

        return view('public.presentation', [
            'tutorial' => $tutorial,
            'details' => $visibleDetails,
        ]);
    }

    public function showFinishedPdf($slug)
    {
        $tutorial = Tutorial::where('finished_url', $slug)->firstOrFail();
        $allDetails = $tutorial->details()->get();
        $pdf = Pdf::loadView('public.pdf-template', [
            'tutorial' => $tutorial,
            'details' => $allDetails,
        ]);
        return $pdf->stream('tutorial-lengkap.pdf');
    }
}
