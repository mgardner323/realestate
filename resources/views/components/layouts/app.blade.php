<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? 'Page Title' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        
        <!-- Firebase SDK -->
        <script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-app.js" defer></script>
        <script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-auth.js" defer></script>
    </head>
    <body class="bg-gray-100">
        <main>
            {{ $slot }}
        </main>
        @livewireScripts
    </body>
</html>
