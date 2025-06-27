<?php

// ====================================================================
// File: resources/views/details/edit.blade.php (LENGKAP & BENAR)
// ====================================================================

?>
@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    Edit Detail #{{ $detail->sort_order }} untuk: <span class="font-bold">{{ $tutorial->title }}</span>
</h2>
@endsection

@section('slot')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form action="{{ route('tutorials.details.update', [$tutorial, $detail]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tipe Konten -->
                        <div class="mb-4">
                            <label for="content_type" class="block font-medium text-sm text-gray-700">Tipe Konten</label>
                            <select name="content_type" id="content_type" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                                <option value="text" {{ $detail->content_type == 'text' ? 'selected' : '' }}>Text</option>
                                <option value="code" {{ $detail->content_type == 'code' ? 'selected' : '' }}>Code</option>
                                <option value="image" {{ $detail->content_type == 'image' ? 'selected' : '' }}>Image</option>
                                <option value="url" {{ $detail->content_type == 'url' ? 'selected' : '' }}>URL</option>
                            </select>
                        </div>
                        <!-- Urutan -->
                        <div class="mb-4">
                            <label for="sort_order" class="block font-medium text-sm text-gray-700">Urutan</label>
                            {{-- PERBAIKAN: Menambahkan min="1" untuk mencegah angka negatif --}}
                            <input type="number" name="sort_order" id="sort_order" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ old('sort_order', $detail->sort_order) }}" required min="1">
                        </div>
                    </div>

                    <!-- Input Dinamis berdasarkan Tipe Konten -->
                    <div id="content-input-area" class="mt-4">
                        <!-- Text/Code/URL Input -->
                        <div id="text-based-input" class="mb-4">
                            <label for="content_text" id="content_text_label" class="block font-medium text-sm text-gray-700">Konten</label>
                            <textarea name="content_text" id="content_text" rows="5" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">{{ old('content_text', $detail->content_text) }}</textarea>
                        </div>
                        <!-- Image Input -->
                        <div id="image-based-input" class="mb-4 hidden">
                            <label for="content_image" class="block font-medium text-sm text-gray-700">Upload Gambar Baru (Opsional)</label>
                             @if($detail->content_image_path)
                                <div class="my-2">
                                    <p class="text-sm text-gray-600">Gambar Saat Ini:</p>
                                    <img src="{{ asset('storage/' . $detail->content_image_path) }}" alt="Current Image" class="max-w-xs rounded-md border mt-1">
                                </div>
                            @endif
                            <input type="file" name="content_image" id="content_image" class="block mt-1 w-full">
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                         <a href="{{ route('tutorials.details.index', $tutorial) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 mr-4">Batal</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">Perbarui Detail</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const contentTypeSelect = document.getElementById('content_type');
        const textInput = document.getElementById('text-based-input');
        const imageInput = document.getElementById('image-based-input');
        const label = document.getElementById('content_text_label');

        function toggleInputs() {
            if (contentTypeSelect.value === 'image') {
                textInput.classList.add('hidden');
                imageInput.classList.remove('hidden');
            } else {
                textInput.classList.remove('hidden');
                imageInput.classList.add('hidden');
                if(contentTypeSelect.value === 'code') {
                    label.textContent = 'Code Block';
                } else if (contentTypeSelect.value === 'url') {
                    label.textContent = 'URL Link';
                } else {
                    label.textContent = 'Konten Teks';
                }
            }
        }

        // Atur tampilan awal saat halaman dimuat
        toggleInputs();

        // Tambahkan event listener untuk perubahan
        contentTypeSelect.addEventListener('change', toggleInputs);
    });
</script>
@endsection
