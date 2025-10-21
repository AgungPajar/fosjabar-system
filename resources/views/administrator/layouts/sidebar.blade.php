@php
    use Illuminate\Support\Str;

    $data = dataModule();
    $menuItems = $data['menu']->sortBy('row_order');
    $modules = $data['modul']->sortBy('row_order');
    $standaloneModules = $modules->filter(fn ($module) => empty($module->menu_id) || $module->menu_id === '0');

    $currentPath = trim(request()->path(), '/');
    $activeModule = $modules->first(function ($module) use ($currentPath) {
        if (!$module->url) {
            return false;
        }

        $modulePath = 'admin/' . ltrim($module->url, '/');
        return Str::startsWith($currentPath, $modulePath);
    });

    $initialMenuId = $activeModule->menu_id ?? null;

    if (empty($initialMenuId)) {
        if ($standaloneModules->isNotEmpty()) {
            $initialMenuId = 'standalone';
        } elseif ($menuItems->isNotEmpty()) {
            $initialMenuId = $menuItems->first()->id;
        }
    }

    $resolveModules = function ($menuId) use ($modules, $standaloneModules) {
        if ($menuId === 'standalone' || empty($menuId)) {
            return $standaloneModules;
        }

        return $modules->where('menu_id', $menuId)->sortBy('row_order');
    };

    $initialModules = $resolveModules($initialMenuId);

    $initialTitle = $initialMenuId === 'standalone'
        ? 'Quick Access'
        : optional($menuItems->firstWhere('id', $initialMenuId))->name;
@endphp

<div id="kt_aside" class="gnc-discord-aside">
<div id="gnc_discord_shell">
    <div class="gnc-primary-nav">
        @if($standaloneModules->isNotEmpty())
            <button class="gnc-primary-item fosja-primary-item {{ $initialMenuId === 'standalone' ? 'is-active' : '' }}" data-menu-id="standalone" title="Quick Access" data-label="Quick Access">
                <span class="gnc-primary-icon fosja-primary-icon">
                    <i class="fa fa-home"></i>
                </span>
            </button>
        @endif

        @foreach($menuItems as $menu)
            <button class="gnc-primary-item fosja-primary-item {{ (string) $initialMenuId === (string) $menu->id ? 'is-active' : '' }}" data-menu-id="{{ $menu->id }}" title="{{ $menu->name }}" data-label="{{ $menu->name }}">
                <span class="gnc-primary-icon fosja-primary-icon">
                    <i class="fa {{ $menu->icon ?? 'fa-folder' }}"></i>
                </span>
            </button>
        @endforeach
    </div>

    <div class="gnc-secondary-nav">
        <div class="gnc-secondary-header">
            <h4 id="gnc-secondary-title">{{ $initialTitle ?? 'Modules' }}</h4>
            <button class="btn btn-icon btn-sm btn-active-light-primary d-lg-none" id="gnc-sidebar-close">
                <i class="fa fa-times"></i>
            </button>
        </div>
    <div class="gnc-secondary-body" id="gnc-secondary-body">
            @forelse($initialModules as $module)
                @if(showModule($module->identifiers))
                    <a href="{{ $module->url ? url('/admin/' . ltrim($module->url, '/')) : 'javascript:void(0);' }}"
                        class="gnc-module-link {{ $activeModule && $activeModule->id === $module->id ? 'is-active' : '' }}"
                        data-module-id="{{ $module->id }}">
                        <span class="gnc-module-icon">
                            <i class="fa {{ $module->icon ?? 'fa-circle' }}"></i>
                        </span>
                        <span class="gnc-module-title">{{ $module->name }}</span>
                    </a>
                @endif
            @empty
                <div class="gnc-empty-state fosja-empty-state">
                    <i class="fa fa-info-circle me-2"></i>
                    <span>No modules available</span>
                </div>
            @endforelse
        </div>
    </div>
</div>
</div>

@php
    $menuPayload = $menuItems->map(function ($menu) {
        return [
            'id' => (string) $menu->id,
            'name' => $menu->name,
            'icon' => $menu->icon ?? 'fa-folder',
        ];
    })->values();

    $modulePayload = $modules->map(function ($module) {
        return [
            'id' => (string) $module->id,
            'menu_id' => $module->menu_id ?? null,
            'identifiers' => $module->identifiers,
            'name' => $module->name,
            'url' => $module->url ? url('/admin/' . ltrim($module->url, '/')) : null,
            'icon' => $module->icon ?? 'fa-circle',
            'row_order' => $module->row_order ?? null,
        ];
    })->values();

    $permissionMap = $modules->mapWithKeys(function ($module) {
        return [(string) $module->id => showModule($module->identifiers)];
    });
@endphp

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Support both legacy fosja-* selectors and new gnc-* selectors
            const primaryItems = document.querySelectorAll('.gnc-primary-item, .fosja-primary-item');
            const bodyContainer = document.getElementById('gnc-secondary-body') || document.getElementById('fosja-secondary-body');
            const headerTitle = document.getElementById('gnc-secondary-title') || document.getElementById('fosja-secondary-title');
            const mobileClose = document.getElementById('gnc-sidebar-close') || document.getElementById('fosja-sidebar-close');

    const menus = @json($menuPayload);
    const modules = @json($modulePayload);
    const standaloneModules = @json($standaloneModules->pluck('id')->values());
            const currentModuleId = @json($activeModule->id ?? null);

    const permissionMap = @json($permissionMap->toArray());
            let activeMenuId = @json((string) $initialMenuId ?? null);

            function resolveModules(menuId) {
                if (menuId === 'standalone' || !menuId) {
                    return modules.filter(m => !m.menu_id || m.menu_id === '0' || standaloneModules.includes(m.id));
                }
                return modules.filter(m => String(m.menu_id) === String(menuId));
            }

            function resolveTitle(menuId) {
                if (menuId === 'standalone' || !menuId) {
                    return 'Quick Access';
                }

                const menu = menus.find(m => String(m.id) === String(menuId));
                return menu ? menu.name : 'Modules';
            }

            function renderModules(menuId) {
                const items = resolveModules(menuId).filter(item => permissionMap[item.id]);

                if (!items.length) {
                    bodyContainer.innerHTML = `
                        <div class="gnc-empty-state fosja-empty-state">
                            <i class="fa fa-info-circle me-2"></i>
                            <span>No modules available</span>
                        </div>
                    `;
                    return;
                }

                bodyContainer.innerHTML = items.map(item => {
                    const isActive = currentModuleId && currentModuleId === item.id;
                    const href = item.url ? item.url : 'javascript:void(0);';

                    return `
                        <a href="${href}" class="gnc-module-link fosja-module-link ${isActive ? 'is-active' : ''}" data-module-id="${item.id}">
                            <span class="gnc-module-icon fosja-module-icon">
                                <i class="fa ${item.icon}"></i>
                            </span>
                            <span class="gnc-module-title fosja-module-title">${item.name}</span>
                        </a>
                    `;
                }).join('');
            }

            // Restore sidebar open state from previous session
            try {
                const stored = window.localStorage.getItem('gnc-sidebar-open');
                if (stored === 'true') {
                    document.body.classList.add('sidebar-open');
                } else {
                    document.body.classList.remove('sidebar-open');
                }
            } catch (e) {
                // ignore storage errors
            }

            primaryItems.forEach(button => {
                button.addEventListener('click', () => {
                    const menuId = button.getAttribute('data-menu-id');
                    activeMenuId = menuId;

                    primaryItems.forEach(item => item.classList.remove('is-active'));
                    button.classList.add('is-active');

                    headerTitle.textContent = resolveTitle(menuId);
                    renderModules(menuId);

                    // On small screens, close sidebar to give space for content. On desktop, keep it open.
                    if (window.innerWidth < 992) {
                        document.body.classList.remove('sidebar-open');
                        try { window.localStorage.setItem('gnc-sidebar-open', 'false'); } catch(e){}
                    } else {
                        try { window.localStorage.setItem('gnc-sidebar-open', 'true'); } catch(e){}
                    }
                });
            });

            if (mobileClose) {
                mobileClose.addEventListener('click', () => {
                    document.body.classList.remove('sidebar-open');
                });
            }
        });
    </script>
@endpush
