<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full flex-col gap-3">
            <h1 class="text-3xl font-semibold text-slate-900 dark:text-white">Buat News</h1>
            <nav class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                <a href="{{ route('dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                <span>/</span>
                <a href="{{ route('news.index') }}" class="hover:text-indigo-600">News</a>
                <span>/</span>
                <span class="text-slate-700 dark:text-slate-200">Buat</span>
            </nav>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid gap-4">
                    <label class="block">
                        <span class="text-sm text-slate-700 dark:text-slate-300">Title</span>
                        <input type="text" name="title" value="{{ old('title') }}" class="mt-1 w-full rounded-md border-slate-200 px-3 py-2" required>
                    </label>
                    <label class="block">
                        <span class="text-sm text-slate-700 dark:text-slate-300">Slug (opsional)</span>
                        <input type="text" name="slug" value="{{ old('slug') }}" class="mt-1 w-full rounded-md border-slate-200 px-3 py-2" placeholder="">
                    </label>
                    <label class="block">
                        <span class="text-sm text-slate-700 dark:text-slate-300">Subtitle</span>
                        <input type="text" name="subtitle" value="{{ old('subtitle') }}" class="mt-1 w-full rounded-md border-slate-200 px-3 py-2">
                    </label>
                    <label class="block">
                        <span class="text-sm text-slate-700 dark:text-slate-300">Author</span>
                        <input type="text" name="author" value="{{ old('author') }}" class="mt-1 w-full rounded-md border-slate-200 px-3 py-2">
                    </label>
                    <label class="block">
                        <span class="text-sm text-slate-700 dark:text-slate-300">Deskripsi</span>
                        <textarea name="deskripsi" rows="6" class="mt-1 w-full rounded-md border-slate-200 px-3 py-2">{{ old('deskripsi') }}</textarea>
                    </label>
                    <label class="block">
                        <span class="text-sm text-slate-700 dark:text-slate-300">Photo (opsional)</span>
                        <input type="file" name="photo" class="mt-1">
                    </label>

                    <div class="pt-2">
                        <button class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
