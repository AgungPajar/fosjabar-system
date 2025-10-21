
    <div
            x-data="{ open: true }"
            x-init="open = JSON.parse(localStorage.getItem('sidebarOpen') || 'true')"
            @keydown.window.escape="open = false; localStorage.setItem('sidebarOpen', JSON.stringify(open))"
            class="bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-200 h-screen border-r border-gray-200 dark:border-gray-700 transition-all duration-300"
            :class="open ? 'w-64' : 'w-20'"
        >
        <!-- Header / Logo -->
        <div class="flex items-center justify-between p-4">
            <div class="flex items-center space-x-3">
                <div x-show="open" class="text-lg font-semibold">Codinglab</div>
            </div>
            <button @click="open = !open; localStorage.setItem('sidebarOpen', JSON.stringify(open))" :aria-label="open ? 'Collapse sidebar' : 'Expand sidebar'" class="text-gray-500 dark:text-gray-300 focus:outline-none p-1" aria-label="Toggle sidebar">
                <!-- show '<' when open -->
                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 transition-opacity duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <!-- show '>' when closed -->
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 transition-opacity duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="mt-2">
            @php
                $menus = [
                    ['icon' => 'home', 'label' => 'Dashboard', 'route' => route('dashboard')],
                    ['icon' => 'users', 'label' => 'Users', 'route' => '#'],
                    ['icon' => 'newspaper', 'label' => 'News', 'route' => '#'],
                ];
            @endphp

            <div class="flex flex-col gap-2 px-2">
            @foreach ($menus as $menu)
                @php $isActive = url()->current() === $menu['route']; @endphp
                <a href="{{ $menu['route'] }}" title="{{ $menu['label'] }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all text-base
                      {{ $isActive ? 'bg-indigo-100 dark:bg-gray-800 text-indigo-600' : 'text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-gray-800' }}"
                   @if($isActive) aria-current="page" @endif>

                    {{-- larger icon --}}
                    <x-icon :name="$menu['icon']" class="w-6 h-6 {{ $isActive ? 'text-indigo-500' : 'text-gray-400' }}" />
                    <span x-show="open" class="text-base font-medium">{{ $menu['label'] }}</span>
                    {{-- When collapsed, keep a hidden accessible label for screen readers --}}
                    <span x-show="!open" class="sr-only">{{ $menu['label'] }}</span>

                </a>
            @endforeach
            </div>
        </nav>
    </div>
