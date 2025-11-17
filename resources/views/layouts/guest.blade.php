<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Lucide Icons -->
        <script src="https://unpkg.com/lucide@latest"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="min-vh-100 d-flex align-items-center py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                        @yield('content')
                        {{ $slot ?? '' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- 🌙 Dark Mode Toggle (Optional - 3 states: Auto/Light/Dark) -->
        <div x-data="darkMode" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;">
            <button 
                @click="toggle()" 
                class="btn btn-sm btn-outline-secondary rounded-circle" 
                style="width: 50px; height: 50px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);"
                :aria-label="'Tema: ' + label"
                :title="'Tema: ' + label"
            >
                <i data-lucide="sun" x-show="theme === 'light'" style="width: 20px; height: 20px;"></i>
                <i data-lucide="moon" x-show="theme === 'dark'" style="width: 20px; height: 20px;"></i>
                <i data-lucide="monitor" x-show="theme === 'auto'" style="width: 20px; height: 20px;"></i>
            </button>
        </div>
        
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                lucide.createIcons();
            });
            document.addEventListener('alpine:initialized', () => {
                setTimeout(() => lucide.createIcons(), 100);
            });
        </script>
    </body>
</html>
