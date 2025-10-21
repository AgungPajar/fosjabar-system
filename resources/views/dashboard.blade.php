<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Statistik singkat --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 p-6 shadow-sm rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Total Users</h3>
                    <p class="text-3xl font-bold mt-2 text-indigo-600">{{ $totalUsers }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 shadow-sm rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Total News</h3>
                    <p class="text-3xl font-bold mt-2 text-indigo-600">{{ $totalNews }}</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
