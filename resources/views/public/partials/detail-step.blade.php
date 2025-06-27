<div class="bg-white p-6 rounded-lg shadow-md flex items-start" id="step-{{ $detail->id }}" data-order="{{ $detail->sort_order }}">
    <span class="font-bold text-2xl text-gray-400 mr-4">{{ $detail->sort_order }}.</span>
    <div class="flex-grow">
        @if ($detail->content_type == 'text')
            <p class="text-gray-700 text-lg">{{ $detail->content_text }}</p>
        @elseif ($detail->content_type == 'code')
            <pre class="bg-gray-800 text-white p-4 rounded-md overflow-x-auto text-sm"><code>{{ $detail->content_text }}</code></pre>
        @elseif ($detail->content_type == 'url')
            <a href="{{ $detail->content_text }}" target="_blank" class="text-blue-600 hover:underline break-all">{{ $detail->content_text }}</a>
        @elseif ($detail->content_type == 'image')
            <img src="{{ asset('storage/' . $detail->content_image_path) }}" alt="Gambar Tutorial" class="max-w-full md:max-w-md rounded-md border">
        @endif
    </div>
</div>
