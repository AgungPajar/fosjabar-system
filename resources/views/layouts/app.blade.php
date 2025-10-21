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
    <body
        class="font-sans antialiased bg-slate-100 dark:bg-slate-950 text-slate-700 dark:text-slate-200"
        x-data="{}"
        x-bind:class="{ 'overflow-hidden': $store.layout.mobileSidebarOpen }"
        x-on:keydown.window.escape="$store.layout.closeMobileSidebar()"
    >
        <div class="min-h-screen flex">
            @include('layouts.sidebar')

            <div class="flex min-h-screen flex-1 flex-col">
                @include('layouts.navigation')

                @isset($header)
                    <header class="border-b border-slate-200 bg-white/70 backdrop-blur dark:border-slate-800 dark:bg-slate-900/60">
                        <div class="mx-auto flex max-w-7xl items-center px-6 py-6">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="flex-1">
                    <div class="mx-auto min-h-full w-full max-w-7xl px-6 py-8 lg:px-8">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
