<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\TutorialController;
use App\Http\Controllers\TutorialDetailController;
use App\Http\Controllers\PublicViewController;
use App\Models\TutorialDetail;

// Rute Halaman Utama
Route::get('/', function () { return view('welcome'); });

// Rute untuk Tamu (Guest)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// Rute untuk Pengguna yang Sudah Login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Kita langsung siapkan rute untuk tutorial di sini
    Route::resource('tutorials', TutorialController::class)->except(['show']);
});

Route::middleware('auth')->group(function () {
    // ... (rute dashboard, logout, tutorials)

    // Tambahkan grup rute ini untuk detail
    Route::prefix('tutorials/{tutorial}')->name('tutorials.details.')->group(function () {
        Route::get('/details', [TutorialDetailController::class, 'index'])->name('index');
        Route::get('/details/create', [TutorialDetailController::class, 'create'])->name('create');
        Route::post('/details', [TutorialDetailController::class, 'store'])->name('store');
        Route::get('/details/{detail}/edit', [TutorialDetailController::class, 'edit'])->name('edit');
        Route::put('/details/{detail}', [TutorialDetailController::class, 'update'])->name('update');
        Route::delete('/details/{detail}', [TutorialDetailController::class, 'destroy'])->name('destroy');
        // Rute khusus untuk mengubah status show/hide
        Route::patch('/details/{detail}/toggle-status', [TutorialDetailController::class, 'toggleStatus'])->name('toggleStatus');
    });
});

Route::get('/get-step-html/{detail}', function (TutorialDetail $detail) {
    // Pastikan hanya detail yang statusnya 'show' yang bisa diambil
    if ($detail->status !== 'show') {
        return response('Unauthorized', 403);
    }
    return view('public.partials.detail-step', compact('detail'))->render();
});

// Rute Publik (tanpa login)
Route::get('/presentation/{slug}', [PublicViewController::class, 'showPresentation'])->name('presentation.show');
Route::get('/finished/{slug}', [PublicViewController::class, 'showFinishedPdf'])->name('finished.show');
