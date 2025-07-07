<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tutorial->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="container mx-auto max-w-4xl mt-10 mb-20 px-4">
        <header class="mb-8 border-b pb-4">
            <h1 class="text-4xl font-bold text-gray-800">{{ $tutorial->title }}</h1>
            <p class="text-lg text-gray-600">Kode Mata Kuliah: {{ $tutorial->course_code }}</p>
            <p class="text-sm text-gray-500">Dibuat oleh: {{ $tutorial->creator_email }}</p>
        </header>

        <main id="tutorial-steps" class="space-y-6">
            @foreach ($details as $detail)
                @include('public.partials.detail-step', ['detail' => $detail])
            @endforeach
        </main>
    </div>

    <script type="module">
        Echo.channel('tutorial.{{ $tutorial->id }}')
            .listen('TutorialStepStatusChanged', (e) => {
                console.log('Event diterima:', e.newStatus, e.detail);

                setTimeout(() => {
                    const existingElement = document.getElementById(`step-${e.detail.id}`);

                    if (e.newStatus === 'hide') {
                        if (existingElement) {
                            console.log(`Menyembunyikan langkah #${e.detail.id}.`);
                            existingElement.remove();
                        }
                        return;
                    }

                    if (e.newStatus === 'show') {
                        if (existingElement) {
                            return;
                        }

                        fetch(`/api/get-step-html/${e.detail.id}`)
                            .then(response => {
                                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                                return response.text();
                            })
                            .then(html => {
                                if (html.trim() === '') return;

                                const stepsContainer = document.getElementById('tutorial-steps');
                                const tempDiv = document.createElement('div');
                                tempDiv.innerHTML = html;
                                const newStepElement = tempDiv.firstChild;

                                stepsContainer.appendChild(newStepElement);

                                const allSteps = Array.from(stepsContainer.children);
                                allSteps.sort((a, b) => {
                                    const orderA = parseInt(a.dataset.order, 10);
                                    const orderB = parseInt(b.dataset.order, 10);
                                    return orderA - orderB;
                                });

                                allSteps.forEach(step => stepsContainer.appendChild(step));

                                newStepElement.scrollIntoView({ behavior: 'smooth', block: 'end' });
                            })
                            .catch(error => {
                                console.error('Gagal mengambil HTML langkah baru:', error);
                            });
                    }
                }, 3000); // 3000 milidetik = 3 detik
            });
    </script>
</body>
</html>
