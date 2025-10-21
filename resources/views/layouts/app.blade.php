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
    <body class="font-sans antialiased" x-data="{ sidebarOpen: false }">

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex">
   @include('layouts.sidebar')

<div 
    x-show="sidebarOpen" 
    @click="sidebarOpen = false"
    class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden">
</div>

{{-- Tambahkan wrapper konten utama di sini --}}
<div class="flex-1 flex flex-col lg:ml-64 transition-all duration-200">
    @include('layouts.navigation')

    <!-- Page Heading -->
    @isset($header)
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex items-center">
                {{ $header }}
            </div>
        </header>
    @endisset

    <!-- Page Content -->
    <main class="p-6">
        {{ $slot }}
    </main>
</div>
