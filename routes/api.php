<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TutorialApiController; // <-- Pastikan use ini ada
use App\Models\TutorialDetail;

Route::get('/get-step-html/{detail}', function (TutorialDetail $detail) {
    if ($detail->status !== 'show') {
        return response('Unauthorized', 403);
    }
    return view('public.partials.detail-step', compact('detail'))->render();

// Pastikan baris ini ada dan tidak ada kesalahan ketik
Route::get('/tutorials/{courseCode}', [TutorialApiController::class, 'getTutorialsByCourse']);

});
