{{-- File: resources/views/dashboard.blade.php --}}

@extends('layouts.app') {{-- Menggunakan layout utama kita --}}

{{-- Mendefinisikan konten untuk bagian 'header' --}}
@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
@endsection

{{-- Mendefinisikan konten untuk bagian 'slot' (atau konten utama) --}}
@section('slot')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
@endsection
