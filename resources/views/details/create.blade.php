@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Tambah Detail Baru untuk: <span class="font-bold">{{ $tutorial->title }}</span>
    </h2>
@endsection

@section('slot')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('tutorials.details.store', $tutorial) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tipe Konten -->
                            <div class="mb-4">
                                <label for="content_type" class="block font-medium text-sm text-gray-700">Tipe
                                    Konten</label>
                                <select name="content_type" id="content_type"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                                    <option value="text">Text</option>
                                    <option value="code">Code</option>
                                    <option value="image">Image</option>
                                    <option value="url">URL</option>
                                </select>
                            </div>
                            <!-- Urutan -->
                            <div class="mb-4">
                                <label for="sort_order" class="block font-medium text-sm text-gray-700">Urutan</label>
                                {{-- PERBAIKAN: Menambahkan min="1" untuk mencegah angka negatif --}}
                                <input type="number" name="sort_order" id="sort_order"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required min="1">
                            </div>
                        </div>

                        <!-- Input Dinamis berdasarkan Tipe Konten -->
                        <div id="content-input-area" class="mt-4">
                            <!-- Text/Code/URL Input -->
                            <div id="text-based-input" class="mb-4">
                                <label for="content_text" class="block font-medium text-sm text-gray-700">Konten</label>
                                <textarea name="content_text" id="content_text" rows="5"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300"></textarea>
                            </div>
                            <!-- Image Input -->
                            <div id="image-based-input" class="mb-4 hidden">
                                <label for="content_image" class="block font-medium text-sm text-gray-700">Upload
                                    Gambar</label>
                                <input type="file" name="content_image" id="content_image" class="block mt-1 w-full">
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('tutorials.details.index', $tutorial) }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 mr-4">Batal</a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">Simpan
                                Detail</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // JavaScript untuk mengubah input form secara dinamis
        document.getElementById('content_type').addEventListener('change', function() {
            const textInput = document.getElementById('text-based-input');
            const imageInput = document.getElementById('image-based-input');
            const label = textInput.querySelector('label');

            if (this.value === 'image') {
                textInput.classList.add('hidden');
                imageInput.classList.remove('hidden');
            } else {
                textInput.classList.remove('hidden');
                imageInput.classList.add('hidden');
                if (this.value === 'code') {
                    label.textContent = 'Code Block';
                } else if (this.value === 'url') {
                    label.textContent = 'URL Link';
                } else {
                    label.textContent = 'Konten Teks';
                }
            }
        });
    </script>
@endsection
