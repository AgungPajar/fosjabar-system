<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full flex-col gap-3">
            <h1 class="text-3xl font-semibold text-slate-900 dark:text-white">{{ $news->title }}</h1>
            <nav class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                <a href="{{ route('dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                <span>/</span>
                <a href="{{ route('news.index') }}" class="hover:text-indigo-600">News</a>
                <span>/</span>
                <span class="text-slate-700 dark:text-slate-200">Detail</span>
            </nav>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            {{-- Informasi dasar --}}
            <div class="mb-2 text-sm text-slate-500 dark:text-slate-400">
                <div><strong>ID:</strong> {{ $news->id }}</div>
                <div><strong>Slug:</strong> {{ $news->slug }}</div>
                @if($news->author)
                    <div><strong>Penulis:</strong> {{ $news->author }}</div>
                @endif
            </div>

            {{-- Gambar utama --}}
                @php
                    $photoUrl = null;
                    if (!empty($news->photo)) {
                        if (str_starts_with($news->photo, 'foto/')) {
                            $photoUrl = asset($news->photo);
                        } else {
                            $photoUrl = asset('storage/' . $news->photo);
                        }
                    }
                @endphp

                <div class="mb-4">
    @if($photoUrl)
        <div class="flex justify-center items-center bg-slate-100 dark:bg-slate-800 rounded overflow-hidden">
            <img src="{{ $photoUrl }}" 
                 alt="Foto berita" 
                 class="max-h-96 w-auto object-contain rounded" 
                 loading="lazy">
        </div>
    @else
        <div class="rounded-md border border-dashed border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-500">
            Saat ini gambarnya belum ada.
        </div>
    @endif
</div>


            {{-- Deskripsi --}}
            <div class="prose dark:prose-invert">
                {!! nl2br(e($news->deskripsi)) !!}
            </div>
        </div>
    </div>
</x-app-layout>
