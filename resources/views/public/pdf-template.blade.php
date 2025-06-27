<?php

// File: resources/views/public/pdf-template.blade.php

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tutorial: {{ $tutorial->title }}</title>
    <style>
        /* CSS sederhana untuk PDF */
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .page-break { page-break-after: always; }
        .header { text-align: center; border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { font-size: 24px; margin: 0; }
        .header p { font-size: 14px; margin: 5px 0; color: #555; }
        .step { margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px; }
        .step-title { font-size: 16px; font-weight: bold; margin-bottom: 10px; }
        .step-content p { line-height: 1.6; }
        .step-content pre { background-color: #f4f4f4; padding: 10px; border-radius: 4px; white-space: pre-wrap; word-wrap: break-word; font-family: 'Courier New', Courier, monospace; }
        .step-content img { max-width: 400px; height: auto; border-radius: 4px; border: 1px solid #ddd; }
        .step-content a { color: #0066cc; text-decoration: none; }
    </style>
</head>
<body>
    <header class="header">
        <h1>{{ $tutorial->title }}</h1>
        <p>Kode Mata Kuliah: {{ $tutorial->course_code }}</p>
        <p>Dibuat oleh: {{ $tutorial->creator_email }}</p>
    </header>

    <main>
        @foreach ($details as $detail)
            <div class="step">
                <div class="step-title">
                    Langkah {{ $detail->sort_order }}.
                </div>
                <div class="step-content">
                    @if ($detail->content_type == 'text')
                        <p>{{ $detail->content_text }}</p>
                    @elseif ($detail->content_type == 'code')
                        <pre><code>{{ $detail->content_text }}</code></pre>
                    @elseif ($detail->content_type == 'url')
                        <a href="{{ $detail->content_text }}">{{ $detail->content_text }}</a>
                    @elseif ($detail->content_type == 'image')
                        {{-- ======================================================= --}}
                        {{-- PERBAIKAN: Gunakan storage_path() untuk path absolut  --}}
                        {{-- ======================================================= --}}
                        @if($detail->content_image_path && file_exists(storage_path('app/public/' . $detail->content_image_path)))
                            <img src="{{ storage_path('app/public/' . $detail->content_image_path) }}">
                        @else
                            <p>[Gambar tidak dapat dimuat: {{ $detail->content_image_path }}]</p>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
    </main>
</body>
</html>
