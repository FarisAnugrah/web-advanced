// ====================================================================
// LOKASI PERBAIKAN: File Konfigurasi JavaScript Utama
// File: resources/js/bootstrap.js
//
// File ini bertanggung jawab untuk menginisialisasi library JavaScript,
// termasuk Laravel Echo. Kita akan memastikan konfigurasinya benar untuk Reverb.
// Ganti seluruh isi file ini dengan kode di bawah.
// ====================================================================

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js'; // Reverb kompatibel dengan Pusher JS client

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb', // <-- Pastikan ini 'reverb'
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT,
    wssPort: import.meta.env.VITE_REVERB_PORT,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

