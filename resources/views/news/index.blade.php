<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">News</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">Kelola daftar berita</p>
            </div>
            <a href="{{ route('news.create') }}" class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-700">Buat News</a>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="rounded-md bg-green-50 p-4 text-green-700">{{ session('success') }}</div>
        @endif

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <table class="w-full table-auto text-sm">
                <thead>
                    <tr class="text-left text-xs text-slate-500">
                        <th class="px-4 py-2">Title</th>
                        <th class="px-4 py-2">Subtitle</th>
                        <th class="px-4 py-2">Photo</th>
                        <th class="px-4 py-2">Created</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($news as $item)
                        <tr>
                            <td class="px-4 py-3 font-medium text-slate-800 dark:text-slate-200">{{ $item->title }}</td>
                            <td class="px-4 py-3 text-slate-500 dark:text-slate-400">{{ $item->subtitle }}</td>
                            <td class="px-4 py-3 text-slate-500 dark:text-slate-400">{{ $item->author }}</td>
                            <td class="px-4 py-3">
                                @if($item->photo)
                                    <img src="{{ asset('storage/' . $item->photo) }}" alt="" class="h-12 w-20 object-cover rounded">
                                @endif
                            </td>
                            <td class="px-4 py-3 text-xs text-slate-400">{{ $item->created_at->format('Y-m-d') }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('news.show', $item) }}" class="text-indigo-600 mr-2">Lihat</a>
                                <a href="{{ route('news.edit', $item) }}" class="text-indigo-600 mr-2">Edit</a>
                                <form action="{{ route('news.destroy', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus news ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-slate-500">Belum ada news.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $news->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
