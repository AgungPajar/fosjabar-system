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
        <div class="flex items-center justify-between gap-4">
            <form method="GET" action="{{ route('news.tags.index') }}" class="relative w-full max-w-xs">
                <label for="tag-search" class="sr-only">Cari tag</label>
                <input
                    type="search"
                    id="tag-search"
                    name="query"
                    value="{{ $search }}"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm text-slate-700 shadow-sm transition focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring focus:ring-indigo-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:border-indigo-500"
                    placeholder="Cari tag..."
                >
                <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
            </form>
            <a href="{{ route('news.tags.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-700">
                <x-icon name="plus" class="h-4 w-4" />
                Tambah Tag
            </a>
        </div>

        @if (session('status'))
            <div class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-900/50 dark:bg-emerald-900/20 dark:text-emerald-200">
                {{ session('status') }}
            </div>
        @endif

        <div class="mt-6">
            @if ($tags->count())
                <div class="overflow-hidden rounded-xl border border-slate-200 dark:border-slate-700">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                        <thead class="bg-slate-50 dark:bg-slate-800/60">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-300">Nama</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-300">Slug</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-300">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-300">Dibuat</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-300">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                            @foreach ($tags as $tag)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-slate-700 dark:text-slate-200">{{ $tag->name }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">{{ $tag->slug }}</td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('news.tags.toggle', $tag) }}" method="POST" class="inline-flex items-center" aria-label="Ubah status aktif untuk {{ $tag->name }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="is_active" value="0">
                                            <label class="relative inline-flex cursor-pointer items-center">
                                                <input
                                                    type="checkbox"
                                                    name="is_active"
                                                    value="1"
                                                    class="peer sr-only"
                                                    onchange="this.form.submit()"
                                                    {{ $tag->is_active ? 'checked' : '' }}
                                                >
                                                <span class="block h-6 w-10 rounded-full bg-slate-300 transition peer-checked:bg-emerald-500 dark:bg-slate-700 dark:peer-checked:bg-emerald-400"></span>
                                                <span class="pointer-events-none absolute left-1 top-1 block h-4 w-4 rounded-full bg-white transition peer-checked:translate-x-4"></span>
                                            </label>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">{{ optional($tag->created_at)->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-right text-sm">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('news.tags.edit', $tag) }}" class="text-slate-500 transition hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-300" title="Edit tag">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <form action="{{ route('news.tags.destroy', $tag) }}" method="POST" onsubmit="return confirm('Hapus tag ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-slate-500 transition hover:text-rose-600 dark:text-slate-400 dark:hover:text-rose-400" title="Hapus tag">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $tags->links() }}
                </div>
            @else
                <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-10 text-center text-sm text-slate-500 dark:border-slate-700 dark:bg-slate-900/50 dark:text-slate-300">
                    @if ($search !== '')
                        Tidak ditemukan tag dengan kata kunci <span class="font-semibold text-slate-700 dark:text-slate-200">"{{ $search }}"</span>.
                    @else
                        Belum ada tag yang tersedia. Tambahkan tag baru untuk memulai.
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
