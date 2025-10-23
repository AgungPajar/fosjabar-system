<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full flex-col gap-3">
            <h1 class="text-3xl font-semibold text-slate-900 dark:text-white">Manajemen Tag</h1>
            <nav class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 focus:text-indigo-600 dark:hover:text-indigo-300 dark:focus:text-indigo-300">Dashboard</a>
                <span>/</span>
                <a href="{{ route('news.tags.index') }}" class="hover:text-indigo-600 focus:text-indigo-600 dark:hover:text-indigo-300 dark:focus:text-indigo-300">News</a>
                <span>/</span>
                <span class="text-slate-700 dark:text-slate-200">Tag</span>
            </nav>
        </div>
    </x-slot>

    @php
        $currentSort = $sort ?? 'created_at';
        $currentDirection = $direction ?? 'desc';
        $perPage = $perPage ?? 10;
        $queryParams = request()->except(['page', 'sort', 'direction']);
        $persistParams = request()->except(['page']);
        $currentListingUrl = request()->fullUrl();

        $sortUrl = function (string $column) use ($queryParams, $currentSort, $currentDirection) {
            $isActive = $currentSort === $column;
            $nextDirection = $isActive && $currentDirection === 'asc' ? 'desc' : 'asc';

            return route('news.tags.index', array_merge($queryParams, [
                'sort' => $column,
                'direction' => $nextDirection,
            ]));
        };

        $sortIcon = function (string $column) use ($currentSort, $currentDirection) {
            if ($currentSort !== $column) {
                return 'fa-sort';
            }

            return $currentDirection === 'asc' ? 'fa-sort-up' : 'fa-sort-down';
        };
    @endphp

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="flex items-center justify-between gap-4">
            <form method="GET" action="{{ route('news.tags.index') }}" class="relative w-full max-w-xs">
                <label for="tag-search" class="sr-only">Cari tag</label>
                <input type="hidden" name="sort" value="{{ $currentSort }}">
                <input type="hidden" name="direction" value="{{ $currentDirection }}">
                <input type="hidden" name="per_page" value="{{ $perPage }}">
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
            <a href="{{ route('news.tags.create', array_merge($persistParams, ['redirect' => $currentListingUrl])) }}" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-700">
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
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-300">
                                    <a href="{{ $sortUrl('name') }}" class="flex w-full items-center gap-2 rounded-md px-1 py-1 hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-slate-800/70 dark:hover:text-indigo-300">
                                        Nama
                                        <i class="fa-solid {{ $sortIcon('name') }} text-slate-400"></i>
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-300">
                                    <a href="{{ $sortUrl('slug') }}" class="flex w-full items-center gap-2 rounded-md px-1 py-1 hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-slate-800/70 dark:hover:text-indigo-300">
                                        Slug
                                        <i class="fa-solid {{ $sortIcon('slug') }} text-slate-400"></i>
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-300">
                                    <a href="{{ $sortUrl('is_active') }}" class="flex w-full items-center gap-2 rounded-md px-1 py-1 hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-slate-800/70 dark:hover:text-indigo-300">
                                        Status
                                        <i class="fa-solid {{ $sortIcon('is_active') }} text-slate-400"></i>
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-300">
                                    <a href="{{ $sortUrl('created_at') }}" class="flex w-full items-center gap-2 rounded-md px-1 py-1 hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-slate-800/70 dark:hover:text-indigo-300">
                                        Dibuat
                                        <i class="fa-solid {{ $sortIcon('created_at') }} text-slate-400"></i>
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-300">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                            @foreach ($tags as $tag)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-slate-700 dark:text-slate-200">{{ $tag->name }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">{{ $tag->slug }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('news.tags.toggle', $tag) }}" method="POST" class="inline-flex items-center" aria-label="Ubah status aktif untuk {{ $tag->name }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="is_active" value="0">
                                            <input type="hidden" name="redirect" value="{{ $currentListingUrl }}">
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
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-3 text-base">
                                            <a href="{{ route('news.tags.edit', array_merge(['tag' => $tag->getKey()], $persistParams, ['redirect' => $currentListingUrl])) }}" class="text-slate-500 transition hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-300" title="Edit tag">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <form action="{{ route('news.tags.destroy', $tag) }}" method="POST" onsubmit="return confirm('Hapus tag ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="redirect" value="{{ $currentListingUrl }}">
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

                <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex flex-wrap items-center gap-3 text-sm text-slate-500 dark:text-slate-400">
                        <form method="GET" action="{{ route('news.tags.index') }}" class="flex items-center gap-2" id="tags-per-page-form">
                            <span>Tampilkan</span>
                            <select
                                name="per_page"
                                class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:border-indigo-400 focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:border-indigo-400 dark:focus:border-indigo-400"
                                onchange="this.form.submit()"
                            >
                                @foreach ([10, 25, 50, 100] as $option)
                                    <option value="{{ $option }}" @selected($perPage === $option)>{{ $option }}</option>
                                @endforeach
                            </select>
                            <span>per halaman</span>
                            <input type="hidden" name="query" value="{{ $search }}">
                            <input type="hidden" name="sort" value="{{ $currentSort }}">
                            <input type="hidden" name="direction" value="{{ $currentDirection }}">
                        </form>
                        <span>
                            Menampilkan
                            <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $tags->firstItem() }}</span>
                            sampai
                            <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $tags->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $tags->total() }}</span>
                            tag
                        </span>
                    </div>
                    <div>
                        {{ $tags->onEachSide(1)->links('vendor.pagination.tailwind-simple') }}
                    </div>
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
