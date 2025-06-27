@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit Tutorial: {{ $tutorial->title }}
    </h2>
@endsection

@section('slot')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form action="{{ route('tutorials.update', $tutorial) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="title" class="block font-medium text-sm text-gray-700">Judul Tutorial</label>
                        <input type="text" name="title" id="title" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('title', $tutorial->title) }}" required>
                         @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="course_code" class="block font-medium text-sm text-gray-700">Mata Kuliah</label>
                        <select name="course_code" id="course_code" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            <option value="">Pilih Mata Kuliah</option>
                            @if(!empty($courses))
                                @foreach ($courses as $course)
                                     {{-- PERBAIKAN: Menggunakan key 'kdmk' dan 'nama' sesuai output debug --}}
                                    <option value="{{ $course['kdmk'] }}" {{ old('course_code', $tutorial->course_code) == $course['kdmk'] ? 'selected' : '' }}>
                                        {{ $course['nama'] }} ({{ $course['kdmk'] }})
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('course_code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('tutorials.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 mr-4">Batal</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
