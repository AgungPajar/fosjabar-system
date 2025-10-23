@php
    $menus = [
        ['icon' => 'home', 'label' => 'Dashboard', 'route' => route('dashboard')],
        ['icon' => 'users', 'label' => 'Users', 'route' => '#'],
        ['icon' => 'newspaper', 'label' => 'News', 'route' => route('news.index')],
    ];

    $navBaseClasses = 'group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-colors';
    $navActiveClasses = 'bg-indigo-100 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-200';
    $navInactiveClasses = 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800';
    $iconBaseClasses = 'h-5 w-5 flex-shrink-0 transition-colors';
    $iconActiveClasses = 'text-indigo-600 dark:text-indigo-300';
    $iconInactiveClasses = 'text-slate-400 group-hover:text-indigo-600 dark:text-slate-500 dark:group-hover:text-indigo-200';
@endphp

<div x-data="{}" x-cloak>
    <!-- Mobile sidebar -->
    <div
        x-show="$store.layout.mobileSidebarOpen"
        x-transition.opacity
        class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden"
        @click="$store.layout.closeMobileSidebar()"
    ></div>

    <aside
        x-show="$store.layout.mobileSidebarOpen"
        x-transition:enter="transform transition ease-out duration-200"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in duration-150"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col border-r border-slate-200 bg-white/95 px-5 py-6 shadow-xl backdrop-blur dark:border-slate-800 dark:bg-slate-900/95 lg:hidden"
    >
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-500/10 text-indigo-600 dark:text-indigo-300">
                    <span class="text-lg font-semibold">CL</span>
                </div>
                <span class="text-lg font-semibold text-slate-900 dark:text-white">Codinglab</span>
            </div>
            <button
                type="button"
                class="rounded-full p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800"
                @click="$store.layout.closeMobileSidebar()"
                aria-label="Close sidebar"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <nav class="mt-6 flex-1 overflow-y-auto">
            <div class="space-y-1">
                @foreach ($menus as $menu)
                    @php
                        $isActive = url()->current() === $menu['route'];
                    @endphp
                    <a
                        href="{{ $menu['route'] }}"
                        title="{{ $menu['label'] }}"
                        class="{{ $navBaseClasses }} {{ $isActive ? $navActiveClasses : $navInactiveClasses }}"
                        @click="$store.layout.closeMobileSidebar()"
                        @if($isActive) aria-current="page" @endif
                    >
                        <x-icon :name="$menu['icon']" class="{{ $iconBaseClasses }} {{ $isActive ? $iconActiveClasses : $iconInactiveClasses }}" />
                        <span>{{ $menu['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </nav>
    </aside>

    <!-- Desktop sidebar -->
    <aside
        class="relative hidden h-screen flex-col border-r border-slate-200 bg-white/95 px-4 py-6 text-slate-700 backdrop-blur transition-[width] duration-300 dark:border-slate-800 dark:bg-slate-900/95 dark:text-slate-200 lg:flex"
        :class="$store.layout.sidebarExpanded ? 'w-72' : 'w-24'"
    >
        <div class="flex items-center" :class="$store.layout.sidebarExpanded ? 'justify-start' : 'justify-center'">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-500/10 text-xl font-semibold text-indigo-600 dark:text-indigo-300">
                    CL
                </div>
                <span
                    class="text-lg font-semibold text-slate-900 dark:text-white"
                    x-show="$store.layout.sidebarExpanded"
                    x-transition.opacity
                >Codinglab</span>
            </div>
        </div>

        <nav class="mt-8 flex-1 overflow-y-auto">
            <div class="space-y-1">
                @foreach ($menus as $menu)
                    @php
                        $isActive = url()->current() === $menu['route'];
                    @endphp
                    <a
                        href="{{ $menu['route'] }}"
                        title="{{ $menu['label'] }}"
                        class="{{ $navBaseClasses }} {{ $isActive ? $navActiveClasses : $navInactiveClasses }}"
                        @if($isActive) aria-current="page" @endif
                    >
                        <x-icon :name="$menu['icon']" class="{{ $iconBaseClasses }} {{ $isActive ? $iconActiveClasses : $iconInactiveClasses }}" />
                        <span
                            x-show="$store.layout.sidebarExpanded"
                            x-transition.opacity
                        >{{ $menu['label'] }}</span>
                        <span x-show="!$store.layout.sidebarExpanded" class="sr-only">{{ $menu['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </nav>

        <div class="mt-auto rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm dark:border-slate-800 dark:bg-slate-800/60">
            <p class="font-semibold text-slate-900 dark:text-white" x-show="$store.layout.sidebarExpanded">Sambutan 👋</p>
            <p class="mt-1 leading-relaxed text-slate-600 dark:text-slate-300" x-show="$store.layout.sidebarExpanded">
                Kelola data pengguna dan berita dengan lebih mudah lewat dashboard baru.
            </p>
            <div class="flex items-center justify-center" x-show="!$store.layout.sidebarExpanded">
                <span class="text-lg">👋</span>
            </div>
        </div>
    </aside>
</div>
