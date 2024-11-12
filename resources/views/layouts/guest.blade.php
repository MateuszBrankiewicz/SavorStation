<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-white">
    <div
        class="flex flex-col items-center pt-6 min-h-screen bg-gray-900 sm:justify-center sm:pt-0 bg-[url('../../../public/assets/background.png')] dark:bg[url({{ asset('../../../public/assets/background.png') }})]">
        <div class="mb-6">
            <a href="/" class="flex justify-center items-center">
                <x-application-logo class="w-5/12 text-gray-500 fill-current" />
            </a>
        </div>

        <div
            class="px-4 w-3/5 bg-gray-900 bg-opacity-30 rounded-md border border-black sm:px-6 md:w-2/4 lg:px-8 lg:w-2/5 xl:w-1/3 backdrop-filter backdrop-blur-sm">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
