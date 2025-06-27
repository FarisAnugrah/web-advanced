@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Manajemen Master Tutorial
    </h2>
@endsection

@section('slot')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('tutorials.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Buat Tutorial Baru
                        </a>
                    </div>

                    <!-- Notifikasi Sukses/Error -->
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Judul</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Mata Kuliah</th>

                                    {{-- =================================== --}}
                                    {{-- PERUBAHAN DIMULAI DARI SINI (1/2) --}}
                                    {{-- =================================== --}}
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        URL Publik</th>
                                    {{-- =================================== --}}

                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($tutorials as $tutorial)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $tutorial->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $tutorial->course_code }}</td>

                                        {{-- =================================== --}}
                                        {{-- PERUBAHAN DIMULAI DARI SINI (2/2) --}}
                                        {{-- =================================== --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <a href="{{ route('presentation.show', $tutorial->presentation_url) }}" target="_blank" class="text-blue-600 hover:underline">Link Presentasi</a>
                                            <br>
                                            <a href="{{ route('finished.show', $tutorial->finished_url) }}" target="_blank" class="text-green-600 hover:underline">Link PDF</a>
                                        </td>
                                        {{-- =================================== --}}

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('tutorials.details.index', $tutorial) }}"
                                                class="text-indigo-600 hover:text-indigo-900 mr-4">Detail</a>
                                            <a href="{{ route('tutorials.edit', $tutorial) }}"
                                                class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                                            <form action="{{ route('tutorials.destroy', $tutorial) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus tutorial ini? Seluruh detailnya juga akan terhapus.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            Belum ada data tutorial.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $tutorials->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
