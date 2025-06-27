<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div>
            <a href="/">
                <svg class="w-20 h-20 fill-current text-gray-500" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M256 0c17.67 0 32 14.33 32 32v64h-64v-64c0-17.67 14.33-32 32-32zm-32 128h64v64h-64v-64zm128-64v64h64v-32c0-17.67-14.33-32-32-32h-32zm-256 0c-17.67 0-32 14.33-32 32v32h64v-64h-32zm-64 128h64v64h-64v-64zm384 0h64v64h-64v-64zM256 256c-44.18 0-80 35.82-80 80s35.82 80 80 80 80-35.82 80-80-35.82-80-80-80zm160-64h-64v64h64v-64zm-384 0v64h64v-64h-64zm160 192v96h-32c-17.67 0-32 14.33-32 32s14.33 32 32 32h96c17.67 0 32-14.33 32-32s-14.33-32-32-32h-32v-96h64v-64h-192v64h64z"/></svg>
            </a>
        </div>
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-4">
                    <div class="font-medium text-red-600">Whoops! Something went wrong.</div>
                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <!-- Email Address -->
                <div>
                    <label class="block font-medium text-sm text-gray-700" for="email">Email</label>
                    <input class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="email" type="email" name="email" :value="old('email')" required autofocus />
                </div>
                <!-- Password -->
                <div class="mt-4">
                     <label class="block font-medium text-sm text-gray-700" for="password">Password</label>
                    <input class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="password" type="password" name="password" required autocomplete="current-password" />
                </div>
                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="ms-3 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Log in
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
