<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">{{ $news->title }}</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $news->subtitle }}</p>
            </div>
            <a href="{{ route('news.index') }}" class="text-sm text-indigo-600">Kembali</a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            @if($news->photo)
                <img src="{{ asset('storage/' . $news->photo) }}" alt="" class="mb-4 w-full max-h-64 object-cover rounded">
            @endif
            @if($news->author)
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-2">Penulis: {{ $news->author }}</p>
            @endif
            <div class="prose dark:prose-invert">{!! nl2br(e($news->deskripsi)) !!}</div>
        </div>
    </div>
</x-app-layout>
