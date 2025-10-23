<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">Edit News</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">Perbarui berita</p>
            </div>
            <a href="{{ route('news.index') }}" class="text-sm text-indigo-600">Kembali</a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <form action="{{ route('news.update', $news) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid gap-4">
                    <label class="block">
                        <span class="text-sm text-slate-700 dark:text-slate-300">Title</span>
                        <input type="text" name="title" value="{{ old('title', $news->title) }}" class="mt-1 w-full rounded-md border-slate-200 px-3 py-2" required>
                    </label>
                    <label class="block">
                        <span class="text-sm text-slate-700 dark:text-slate-300">Subtitle</span>
                        <input type="text" name="subtitle" value="{{ old('subtitle', $news->subtitle) }}" class="mt-1 w-full rounded-md border-slate-200 px-3 py-2">
                    </label>
                    <label class="block">
                        <span class="text-sm text-slate-700 dark:text-slate-300">Author</span>
                        <input type="text" name="author" value="{{ old('author', $news->author) }}" class="mt-1 w-full rounded-md border-slate-200 px-3 py-2">
                    </label>
                    <label class="block">
                        <span class="text-sm text-slate-700 dark:text-slate-300">Deskripsi</span>
                        <textarea name="deskripsi" rows="6" class="mt-1 w-full rounded-md border-slate-200 px-3 py-2">{{ old('deskripsi', $news->deskripsi) }}</textarea>
                    </label>
                    <label class="block">
                        <span class="text-sm text-slate-700 dark:text-slate-300">Photo (opsional)</span>
                        <input type="file" name="photo" class="mt-1">
                        @if($news->photo)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $news->photo) }}" alt="" class="h-24 w-32 object-cover rounded">
                            </div>
                        @endif
                    </label>

                    <div class="pt-2">
                        <button class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
