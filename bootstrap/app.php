<?php

// ====================================================================
// LOKASI PERBAIKAN: File Bootstrap Utama Aplikasi
// File: bootstrap/app.php
//
// File ini bertanggung jawab untuk "membangun" aplikasi Anda,
// termasuk memuat semua file rute yang diperlukan.
// Ganti seluruh isi file ini dengan kode di bawah untuk memastikannya benar.
// ====================================================================

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',

        // ====================================================================
        // BAGIAN YANG HILANG: Pastikan baris ini ada.
        // ====================================================================
        api: __DIR__.'/../routes/api.php',

        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
