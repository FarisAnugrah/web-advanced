<?php

// ====================================================================
// LANGKAH 1: TAMBAHKAN CSRF TOKEN KE LAYOUT UTAMA
// (Kode ini seharusnya sudah ada di layouts/app.blade.php)
// ====================================================================

?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- PASTIKAN BARIS INI ADA --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    {{-- ... sisa dari file <head> ... --}}
</head>
{{-- ... sisa dari file app.blade.php ... --}}
</html>


<?php

// ====================================================================
// LANGKAH 2: KODE LENGKAP UNTUK HALAMAN DAFTAR DETAIL
// Ganti seluruh isi file resources/views/details/index.blade.php
// dengan kode di bawah ini.
// ====================================================================

?>
@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail untuk: <span class="font-bold">{{ $tutorial->title }}</span>
        </h2>
        <a href="{{ route('tutorials.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
            &larr; Kembali ke Daftar Tutorial
        </a>
    </div>
@endsection

@section('slot')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-end mb-4">
                    <a href="{{ route('tutorials.details.create', $tutorial) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Tambah Detail Baru
                    </a>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="space-y-4">
                    @forelse ($details as $detail)
                        <div class="border rounded-lg p-4 flex justify-between items-start">
                            {{-- ========================================================== --}}
                            {{-- KODE YANG HILANG DIKEMBALIKAN DI SINI                 --}}
                            {{-- ========================================================== --}}
                            <div>
                                <div class="flex items-center mb-2">
                                    <span class="font-bold text-lg mr-2">{{ $detail->sort_order }}.</span>
                                    <span class="text-sm font-medium uppercase text-gray-500 mr-4">[{{ $detail->content_type }}]</span>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $detail->status == 'show' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $detail->status }}
                                    </span>
                                </div>
                                <div class="ml-6">
                                    @if ($detail->content_type == 'text')
                                        <p>{{ $detail->content_text }}</p>
                                    @elseif ($detail->content_type == 'code')
                                        <pre class="bg-gray-900 text-white p-4 rounded-md overflow-x-auto"><code>{{ $detail->content_text }}</code></pre>
                                    @elseif ($detail->content_type == 'url')
                                        <a href="{{ $detail->content_text }}" target="_blank" class="text-blue-600 hover:underline">{{ $detail->content_text }}</a>
                                    @elseif ($detail->content_type == 'image')
                                        <img src="{{ asset('storage/' . $detail->content_image_path) }}" alt="Gambar Tutorial" class="max-w-xs rounded-md">
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center flex-shrink-0 ml-4">
                                <a href="#"
                                   class="toggle-status-btn text-sm font-medium {{ $detail->status == 'show' ? 'text-yellow-600 hover:text-yellow-900' : 'text-green-600 hover:text-green-900' }}"
                                   data-url="{{ route('tutorials.details.toggleStatus', [$tutorial, $detail]) }}">
                                   {{ $detail->status == 'show' ? 'Hide' : 'Show' }}
                                </a>

                                <a href="{{ route('tutorials.details.edit', [$tutorial, $detail]) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900 ml-4">Edit</a>

                                <form action="{{ route('tutorials.details.destroy', [$tutorial, $detail]) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus detail ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-900 ml-4">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">Belum ada detail untuk tutorial ini.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tambahkan script ini di akhir file --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleButtons = document.querySelectorAll('.toggle-status-btn');

    toggleButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault(); // Mencegah link berpindah halaman

            const url = this.dataset.url;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(url, {
                method: 'POST', // Menipu sebagai POST karena form HTML tidak mendukung PATCH/PUT secara native
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    _method: 'PATCH' // Mengirim method yang sebenarnya di body
                })
            })
            .then(response => {
                if (response.ok) {
                    window.location.reload(); // Muat ulang halaman untuk melihat perubahan
                } else {
                    alert('Gagal mengubah status. Silakan coba lagi.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan yang tidak terduga.');
            });
        });
    });
});
</script>
@endsection
