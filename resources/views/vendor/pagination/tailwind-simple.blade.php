@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="inline-flex items-center rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-2 text-slate-300 dark:text-slate-700" aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                <i class="fa-solid fa-angle-left"></i>
            </span>
        @else
            <a class="px-3 py-2 text-slate-500 transition hover:bg-indigo-50 hover:text-indigo-600 dark:text-slate-300 dark:hover:bg-slate-800/70 dark:hover:text-indigo-300" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="{{ __('pagination.previous') }}">
                <i class="fa-solid fa-angle-left"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-3 py-2 text-slate-400">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-2 font-medium text-indigo-600 dark:text-indigo-300" aria-current="page">{{ $page }}</span>
                    @else
                        <a class="px-3 py-2 text-slate-500 transition hover:bg-indigo-50 hover:text-indigo-600 dark:text-slate-300 dark:hover:bg-slate-800/70 dark:hover:text-indigo-300" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="px-3 py-2 text-slate-500 transition hover:bg-indigo-50 hover:text-indigo-600 dark:text-slate-300 dark:hover:bg-slate-800/70 dark:hover:text-indigo-300" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="{{ __('pagination.next') }}">
                <i class="fa-solid fa-angle-right"></i>
            </a>
        @else
            <span class="px-3 py-2 text-slate-300 dark:text-slate-700" aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                <i class="fa-solid fa-angle-right"></i>
            </span>
        @endif
    </nav>
@endif
