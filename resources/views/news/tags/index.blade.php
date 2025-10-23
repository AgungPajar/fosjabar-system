<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full flex-col gap-3">
            <h1 class="text-3xl font-semibold text-slate-900 dark:text-white">Manajemen Tag</h1>
            <nav class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 focus:text-indigo-600 dark:hover:text-indigo-300 dark:focus:text-indigo-300">Dashboard</a>
                <span>/</span>
                <a href="#" class="hover:text-indigo-600 focus:text-indigo-600 dark:hover:text-indigo-300 dark:focus:text-indigo-300">News</a>
                <span>/</span>
                <span class="text-slate-700 dark:text-slate-200">Tag</span>
            </nav>
        </div>
    </x-slot>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Daftar Tag</h3>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Kelola tag untuk mengelompokkan berita dengan lebih mudah.</p>
            </div>
            <a href="#" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-700">
                <x-icon name="plus" class="h-4 w-4" />
                Tambah Tag
            </a>
        </div>

        <div class="mt-6 rounded-xl border border-dashed border-slate-300 bg-slate-50 p-10 text-center dark:border-slate-700 dark:bg-slate-900/50">
            <x-icon name="tag" class="mx-auto h-12 w-12 text-indigo-500 dark:text-indigo-300" />
            <p class="mt-4 text-sm text-slate-600 dark:text-slate-300">Integrasikan daftar tag dengan data aktual ketika fitur backend sudah siap.</p>
        </div>
    </div>
</x-app-layout>
