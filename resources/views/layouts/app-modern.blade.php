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

        <!-- Sidebar Styles -->
        <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <!-- Skip navigation link per screen reader -->
        <a href="#main-content" class="skip-link">Salta alla navigazione principale</a>

        <!-- Mobile toggle button with proper ARIA -->
        <button 
            class="mobile-toggle" 
            type="button" 
            onclick="toggleSidebar()"
            aria-expanded="false"
            aria-controls="sidebar"
            aria-label="Apri/chiudi menu di navigazione"
        >
            <i data-lucide="menu" aria-hidden="true"></i>
            <span class="sr-only">Menu</span>
        </button>

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
        
        <script src="{{ asset('js/app-modern.js') }}"></script>

        <!-- Sidebar with proper navigation role -->
        <nav id="sidebar" role="navigation" aria-label="Menu principale">
            @include('layouts.sidebar')
        </nav>

        <!-- Main content with proper landmark -->
        <main class="main-content" id="main-content" role="main" aria-label="Contenuto principale">
            <div class="content-wrapper">
                <!-- Page Header with proper heading structure -->
                @hasSection('header')
                    <header class="page-header fade-in" role="banner">
                        @yield('header')
                    </header>
                @elseif(isset($header))
                    <header class="page-header fade-in" role="banner">
                        {{ $header }}
                    </header>
                @endif

                <!-- Flash Messages with proper ARIA live region -->
                <div aria-live="polite" aria-atomic="true">
                    @include('partials.flash-modern')
                </div>

                <!-- Page Content -->
                <section class="slide-up" aria-label="Contenuto della pagina">
                    @if (isset($slot))
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endif
                </section>
            </div>
        </main>

        <!-- Sidebar JavaScript -->
        <script src="{{ asset('js/sidebar.js') }}"></script>
    </body>
</html>