<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-animation="false" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
    <div class="container-xxl d-flex align-items-center flex-lg-stack">
        @php
            $authUser = auth()->user();
        @endphp
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-2 me-lg-5">
            <div class="flex-grow-1">
                <button class="btn btn-icon btn-color-gray-800 btn-active-color-primary aside-toggle justify-content-start w-30px w-lg-40px" id="gnc_menu_toggle">
                    <span class="svg-icon svg-icon-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 16 15" fill="none">
                            <rect y="6" width="16" height="3" rx="1.5" fill="black" />
                            <rect opacity="0.3" y="12" width="8" height="3" rx="1.5" fill="black" />
                            <rect opacity="0.3" width="12" height="3" rx="1.5" fill="black" />
                        </svg>
                    </span>
                </button>
                <a href="{{route('admin.dashboard')}}">
                    <img alt="Logo" src="{{ img_src(data_get($settings ?? [], 'logo'), 'setting') ?: asset('assets/media/img/default/logo.png') }}" class="h-30px h-lg-35px" style="height:50px; width:auto;" />
                </a>
            </div>
            <div class="ms-5 ms-md-10 d-flex align-items-center">
                <div id="kt_header_search" class="d-flex align-items-center w-lg-400px" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-search-responsive="lg" data-kt-menu-trigger="auto" data-kt-menu-permanent="true" data-kt-menu-placement="{default: 'bottom-end', lg: 'bottom-start'}">
                    <div data-kt-search-element="toggle" class="d-flex d-lg-none align-items-center">
                        <div class="btn btn-icon btn-color-gray-800 btn-active-light-primary w-30px h-30px w-md-40px h-md-40px">
                            <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <form data-kt-search-element="form" class="d-none d-lg-block w-100 position-relative mb-5 mb-lg-0" autocomplete="off">
                        <input type="hidden" />
                        <span class="svg-icon svg-icon-2 svg-icon-lg-3 svg-icon-gray-800 position-absolute top-50 translate-middle-y ms-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                            </svg>
                        </span>
                        <input type="text" class="search-input form-control form-control-solid ps-13" name="search" value="" placeholder="Search..." data-kt-search-element="input" />
                        <span class="position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5" data-kt-search-element="spinner">
                            <span class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
                        </span>
                        <span class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-4" data-kt-search-element="clear">
                            <span class="svg-icon svg-icon-2 svg-icon-lg-1 me-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                                </svg>
                            </span>
                        </span>
                    </form>
                    <div data-kt-search-element="content" class="menu menu-sub menu-sub-dropdown w-300px w-md-350px py-7 px-7 overflow-hidden">
                        <div data-kt-search-element="wrapper">
                            <div data-kt-search-element="results" class="d-none">
                                <div class="scroll-y mh-200px mh-lg-350px">
                                    <h3 class="fs-5 text-muted m-0 pt-5 pb-5" data-kt-search-element="module">Module</h3>
                                    @php
                                        $data = dataModule();
                                        $menuItems = $data['menu'];
                                        $modules = $data['modul']->sortBy('row_order');
                                    @endphp

                                    @foreach($modules as $module)
                                        @if(showModule($module->identifiers))
                                            <a href="{{ url('/admin') . '/' . $module->url }}" class="d-flex text-dark text-hover-primary align-items-center mb-5" data-key="{{$module->name}}" data-id="{{$module->id}}">
                                                <div class="symbol symbol-40px me-4">
                                                    <span class="symbol-label bg-light">
                                                        <span class="menu-icon">
                                                            <i class="fa {{ $module->menu->icon ?? $module->icon ?? 'fa-tachometer-alt' }}"></i>
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="fs-6 fw-bold">{{ $module->name }}</span>
                                                    <span class="fs-7 fw-bold text-muted">#{{$module->id}}</span>
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="" data-kt-search-element="main">
                                <div class="d-flex flex-stack fw-bold mb-4">
                                    <span class="text-muted fs-6 me-2">Recently Searched:</span>
                                    <div class="d-flex" data-kt-search-element="toolbar">
                                        <div data-kt-search-element="preferences-show" class="btn btn-icon w-20px btn-sm btn-active-color-primary me-2 data-bs-toggle=" title="Show search preferences">
                                            <span class="svg-icon svg-icon-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M22.1 11.5V12.6C22.1 13.2 21.7 13.6 21.2 13.7L19.9 13.9C19.7 14.7 19.4 15.5 18.9 16.2L19.7 17.2999C20 17.6999 20 18.3999 19.6 18.7999L18.8 19.6C18.4 20 17.8 20 17.3 19.7L16.2 18.9C15.5 19.3 14.7 19.7 13.9 19.9L13.7 21.2C13.6 21.7 13.1 22.1 12.6 22.1H11.5C10.9 22.1 10.5 21.7 10.4 21.2L10.2 19.9C9.4 19.7 8.6 19.4 7.9 18.9L6.8 19.7C6.4 20 5.7 20 5.3 19.6L4.5 18.7999C4.1 18.3999 4.1 17.7999 4.4 17.2999L5.2 16.2C4.8 15.5 4.4 14.7 4.2 13.9L2.9 13.7C2.4 13.6 2 13.1 2 12.6V11.5C2 10.9 2.4 10.5 2.9 10.4L4.2 10.2C4.4 9.39995 4.7 8.60002 5.2 7.90002L4.4 6.79993C4.1 6.39993 4.1 5.69993 4.5 5.29993L5.3 4.5C5.7 4.1 6.3 4.10002 6.8 4.40002L7.9 5.19995C8.6 4.79995 9.4 4.39995 10.2 4.19995L10.4 2.90002C10.5 2.40002 11 2 11.5 2H12.6C13.2 2 13.6 2.40002 13.7 2.90002L13.9 4.19995C14.7 4.39995 15.5 4.69995 16.2 5.19995L17.3 4.40002C17.7 4.10002 18.4 4.1 18.8 4.5L19.6 5.29993C20 5.69993 20 6.29993 19.7 6.79993L18.9 7.90002C19.3 8.60002 19.7 9.39995 19.9 10.2L21.2 10.4C21.7 10.5 22.1 11 22.1 11.5ZM12.1 8.59998C10.2 8.59998 8.6 10.2 8.6 12.1C8.6 14 10.2 15.6 12.1 15.6C14 15.6 15.6 14 15.6 12.1C15.6 10.2 14 8.59998 12.1 8.59998Z" fill="black" />
                                                    <path d="M17.1 12.1C17.1 14.9 14.9 17.1 12.1 17.1C9.30001 17.1 7.10001 14.9 7.10001 12.1C7.10001 9.29998 9.30001 7.09998 12.1 7.09998C14.9 7.09998 17.1 9.29998 17.1 12.1ZM12.1 10.1C11 10.1 10.1 11 10.1 12.1C10.1 13.2 11 14.1 12.1 14.1C13.2 14.1 14.1 13.2 14.1 12.1C14.1 11 13.2 10.1 12.1 10.1Z" fill="black" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div data-kt-search-element="advanced-options-form-show" class="btn btn-icon w-20px btn-sm btn-active-color-primary me-n1" data-bs-toggle="tooltip" title="Show more search options">
                                            <span class="svg-icon svg-icon-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="scroll-y mh-200px mh-lg-325px">
                                    @php
                                        $data = dataModule();
                                        $menuItems = $data['menu'];
                                        $modules = $data['modul']->sortBy('row_order');
                                    @endphp

                                    @foreach($modules as $module)
                                        @if(empty($module->menu_id) && showModule($module->identifiers))
                                            <div class="d-flex align-items-center mb-5">
                                                <div class="symbol symbol-40px me-4">
                                                    <span class="symbol-label bg-light">
                                                        <span class="menu-icon">
                                                            <i class="fa {{ $module->icon ?? 'fa-tachometer-alt' }}"></i>
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <a href="{{ url('/admin') . '/' . $module->url }}" class="fs-6 text-gray-800 text-hover-primary fw-bold">{{ $module->name }}</a>
                                                    <span class="fs-7 text-muted fw-bold">#{{$module->id}}</span>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div data-kt-search-element="empty" class="text-center d-none">
                                <div class="pt-10 pb-10">
                                    <span class="svg-icon svg-icon-4x opacity-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3" d="M14 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8L14 2Z" fill="black" />
                                            <path d="M20 8L14 2V6C14 7.10457 14.8954 8 16 8H20Z" fill="black" />
                                            <rect x="13.6993" y="13.6656" width="4.42828" height="1.73089" rx="0.865447" transform="rotate(45 13.6993 13.6656)" fill="black" />
                                            <path d="M15 12C15 14.2 13.2 16 11 16C8.8 16 7 14.2 7 12C7 9.8 8.8 8 11 8C13.2 8 15 9.8 15 12ZM11 9.6C9.68 9.6 8.6 10.68 8.6 12C8.6 13.32 9.68 14.4 11 14.4C12.32 14.4 13.4 13.32 13.4 12C13.4 10.68 12.32 9.6 11 9.6Z" fill="black" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="pb-15 fw-bold">
                                    <h3 class="text-gray-600 fs-5 mb-2">No result found</h3>
                                    <div class="text-muted fs-7">Please try again with a different query</div>
                                </div>
                            </div>
                        </div>
                        <form data-kt-search-element="advanced-options-form" class="pt-1 d-none">
                            <h3 class="fw-bold text-dark mb-7">Advanced Search</h3>
                            <div class="mb-5">
                                <input type="text" class="form-control form-control-sm form-control-solid" placeholder="Contains the word" name="query" />
                            </div>
                            <div class="mb-5">
                                <div class="nav-group nav-group-fluid">
                                    <label>
                                        <input type="radio" class="btn-check" name="type" value="has" checked="checked" />
                                        <span class="btn btn-sm btn-color-muted btn-active btn-active-primary">All</span>
                                    </label>
                                    <label>
                                        <input type="radio" class="btn-check" name="type" value="users" />
                                        <span class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Users</span>
                                    </label>
                                    <label>
                                        <input type="radio" class="btn-check" name="type" value="orders" />
                                        <span class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Orders</span>
                                    </label>
                                    <label>
                                        <input type="radio" class="btn-check" name="type" value="projects" />
                                        <span class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Projects</span>
                                    </label>
                                </div>
                            </div>
                            <div class="mb-5">
                                <input type="text" name="assignedto" class="form-control form-control-sm form-control-solid" placeholder="Assigned to" value="" />
                            </div>
                            <div class="mb-5">
                                <input type="text" name="collaborators" class="form-control form-control-sm form-control-solid" placeholder="Collaborators" value="" />
                            </div>
                            <div class="mb-5">
                                <div class="nav-group nav-group-fluid">
                                    <label>
                                        <input type="radio" class="btn-check" name="attachment" value="has" checked="checked" />
                                        <span class="btn btn-sm btn-color-muted btn-active btn-active-primary">Has attachment</span>
                                    </label>
                                    <label>
                                        <input type="radio" class="btn-check" name="attachment" value="any" />
                                        <span class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">Any</span>
                                    </label>
                                </div>
                            </div>
                            <div class="mb-5">
                                <select name="timezone" aria-label="Select a Timezone" data-control="select2" data-placeholder="date_period" class="form-select form-select-sm form-select-solid">
                                    <option value="next">Within the next</option>
                                    <option value="last">Within the last</option>
                                    <option value="between">Between</option>
                                    <option value="on">On</option>
                                </select>
                            </div>
                            <div class="row mb-8">
                                <div class="col-6">
                                    <input type="number" name="date_number" class="form-control form-control-sm form-control-solid" placeholder="Lenght" value="" />
                                </div>
                                <div class="col-6">
                                    <select name="date_typer" aria-label="Select a Timezone" data-control="select2" data-placeholder="Period" class="form-select form-select-sm form-select-solid">
                                        <option value="days">Days</option>
                                        <option value="weeks">Weeks</option>
                                        <option value="months">Months</option>
                                        <option value="years">Years</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-sm btn-light fw-bolder btn-active-light-primary me-2" data-kt-search-element="advanced-options-form-cancel">Cancel</button>
                                <a href="../../demo18/dist/pages/search/horizontal.html" class="btn btn-sm fw-bolder btn-primary" data-kt-search-element="advanced-options-form-search">Search</a>
                            </div>
                        </form>
                        <form data-kt-search-element="preferences" class="pt-1 d-none">
                            <h3 class="fw-bold text-dark mb-7">Search Preferences</h3>
                            <div class="pb-4 border-bottom">
                                <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                    <span class="form-check-label text-gray-700 fs-6 fw-bold ms-0 me-2">Projects</span>
                                    <input class="form-check-input" type="checkbox" value="1" checked="checked" />
                                </label>
                            </div>
                            <div class="py-4 border-bottom">
                                <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                    <span class="form-check-label text-gray-700 fs-6 fw-bold ms-0 me-2">Targets</span>
                                    <input class="form-check-input" type="checkbox" value="1" checked="checked" />
                                </label>
                            </div>
                            <div class="py-4 border-bottom">
                                <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                    <span class="form-check-label text-gray-700 fs-6 fw-bold ms-0 me-2">Affiliate Programs</span>
                                    <input class="form-check-input" type="checkbox" value="1" />
                                </label>
                            </div>
                            <div class="py-4 border-bottom">
                                <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                    <span class="form-check-label text-gray-700 fs-6 fw-bold ms-0 me-2">Referrals</span>
                                    <input class="form-check-input" type="checkbox" value="1" checked="checked" />
                                </label>
                            </div>
                            <div class="py-4 border-bottom">
                                <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                    <span class="form-check-label text-gray-700 fs-6 fw-bold ms-0 me-2">Users</span>
                                    <input class="form-check-input" type="checkbox" value="1" />
                                </label>
                            </div>
                            <div class="d-flex justify-content-end pt-7">
                                <button type="reset" class="btn btn-sm btn-light fw-bolder btn-active-light-primary me-2" data-kt-search-element="preferences-dismiss">Cancel</button>
                                <button type="submit" class="btn btn-sm fw-bolder btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-stretch flex-shrink-0">
            <div class="d-flex align-items-center ms-1 ms-lg-3">
                <button type="button" class="btn btn-icon btn-color-gray-800 btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="gnc-theme-toggle" aria-label="Toggle theme" data-theme="light">
                    <span class="svg-icon svg-icon-2" data-icon="sun">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                            <path d="M12 18.25C15.4518 18.25 18.25 15.4518 18.25 12C18.25 8.54822 15.4518 5.75 12 5.75C8.54822 5.75 5.75 8.54822 5.75 12C5.75 15.4518 8.54822 18.25 12 18.25Z" fill="currentColor"/>
                            <path d="M12 3V4.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M20.5 12H22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M12 19.5V21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M2 12H3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M18.364 5.63604L19.4246 4.57541" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M18.364 18.364L19.4246 19.4246" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M5.63605 18.364L4.57541 19.4246" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M5.63604 5.63605L4.57541 4.57541" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span class="svg-icon svg-icon-2 d-none" data-icon="moon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                            <path d="M20.3541 15.6038C18.4741 15.6755 16.6379 14.9912 15.3255 13.6788C14.0132 12.3665 13.3288 10.5303 13.4005 8.6503C13.4642 6.9788 14.1871 5.3913 15.4005 4.2403C13.997 3.8985 12.5153 3.9936 11.1678 4.5122C9.82029 5.0307 8.67612 5.94521 7.8899 7.11889C7.10368 8.29258 6.71478 9.66401 6.77571 11.0501C6.83664 12.4362 7.34477 13.7631 8.22631 14.8447C9.10785 15.9264 10.3216 16.7067 11.6877 17.073C13.0537 17.4392 14.5045 17.3746 15.8305 16.8888C17.1564 16.4031 18.2909 15.5196 19.0751 14.3702C19.3867 13.9143 19.6355 13.4248 19.8168 12.912C20.0541 13.8213 20.2428 14.7248 20.3541 15.6038Z" fill="currentColor"/>
                        </svg>
                    </span>
                </button>
            </div>
            <div class="d-flex align-items-center ms-1 ms-lg-3">
                <!-- Ikon notifikasi -->
                <a class="btn btn-color-gray-800 btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px position-relative btn btn-color-gray-800 btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px me-2" href="javascript:void(0);">
                    <span class="svg-icon svg-icon-2x" >
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C10.34 2 9 3.34 9 5V5.29C6.72 6.14 5 8.36 5 11V16L3 18V19H21V18L19 16V11C19 8.36 17.28 6.14 15 5.29V5C15 3.34 13.66 2 12 2Z" fill="#C7CBD1"/>
                            <path d="M13 21H11C11 21.55 11.45 22 12 22C12.55 22 13 21.55 13 21Z" fill="#C7CBD1"/>
                            <rect x="11.25" y="7" width="1.5" height="10" rx="0.75" fill="#3D5A80"/>
                        </svg>
                    </span>
                </a>
                <!-- Ikon user -->
                <div class="btn btn-color-gray-800 btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px position-relative btn btn-color-gray-800 btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                    <span class="svg-icon svg-icon-2x">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="black" />
                            <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="black" />
                        </svg>
                    </span>
                </div>
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
                    <div class="menu-item px-3">
                        <div class="menu-content d-flex align-items-center px-3">
                            <div class="symbol symbol-50px me-5">
                                <img alt="Logo" src="{{ $authUser && $authUser->image ? asset('assets/media/modules/profile/' . $authUser->image) : asset('assets/media/svg/avatars/blank.svg') }}" />
                            </div>
                            <div class="d-flex flex-column">
                                <div class="fw-bolder d-flex align-items-center fs-5">{{ $authUser->name ?? 'Guest' }}</div>
                                <a href="{{route('admin.profile')}}" class="fw-bold text-muted text-hover-primary fs-7">{{ $authUser->email ?? '-' }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="separator my-2"></div>
                    <div class="menu-item px-5">
                        <a href="{{route('admin.profile')}}" class="menu-link px-5">My Profile</a>
                    </div>
                    <div class="separator my-2"></div>
                    <div class="menu-item px-5 my-1">
                        <a href="../../demo18/dist/account/settings.html" class="menu-link px-5">Account Settings</a>
                    </div>
                    <div class="menu-item px-5">
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="menu-link px-5 btn btn-link text-start text-decoration-none">Sign Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        const headerSearch = new KTSearch(document.querySelector('#kt_header_search'), {
            minLength: 2,
            enter: true,
            });

            headerSearch.on('kt.search.process', () => {
            const query = headerSearch.getQuery().toLowerCase().trim();

            const resultItems = document.querySelectorAll('#kt_header_search [data-kt-search-element="results"] a');
            const mainElement = document.querySelector('#kt_header_search [data-kt-search-element="main"]');
            const resultsElement = document.querySelector('#kt_header_search [data-kt-search-element="results"]');
            const emptyElement = document.querySelector('#kt_header_search [data-kt-search-element="empty"]');

            let found = 0;

            resultItems.forEach(item => {
                const key = item.getAttribute('data-key')?.toLowerCase() || '';
                const id = item.getAttribute('data-id')?.toLowerCase() || '';

                if (key.includes(query) || id.includes(query)) {
                item.classList.remove('d-none');
                found++;
                } else {
                item.classList.add('d-none');
                }
            });

            // Tampilkan hasil jika ditemukan, sembunyikan main
            if (found > 0) {
                resultsElement.classList.remove('d-none');
                emptyElement.classList.add('d-none');
                mainElement.classList.add('d-none');
            } else {
                resultsElement.classList.add('d-none');
                emptyElement.classList.remove('d-none');
                mainElement.classList.add('d-none');
            }

            headerSearch.complete();
            });

            // Reset saat input kosong
            headerSearch.on('kt.search.clear', () => {
            const resultItems = document.querySelectorAll('#kt_header_search [data-kt-search-element="results"] a');
            const mainElement = document.querySelector('#kt_header_search [data-kt-search-element="main"]');
            const resultsElement = document.querySelector('#kt_header_search [data-kt-search-element="results"]');
            const emptyElement = document.querySelector('#kt_header_search [data-kt-search-element="empty"]');

            resultItems.forEach(item => item.style.display = '');

            resultsElement.classList.add('d-none');
            emptyElement.classList.add('d-none');
            mainElement.classList.remove('d-none');
            });

    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleButton = document.getElementById('gnc_menu_toggle');
            if (!toggleButton) return;

            // Ensure sidebar is closed by default on page load
            document.body.classList.remove('sidebar-open');

            // Set accessibility attributes
            toggleButton.setAttribute('aria-expanded', 'false');
            toggleButton.setAttribute('aria-controls', 'kt_aside');

            toggleButton.addEventListener('click', function () {
                const isOpen = document.body.classList.toggle('sidebar-open');
                toggleButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                try { window.localStorage.setItem('gnc-sidebar-open', isOpen ? 'true' : 'false'); } catch(e){}
            });

            // If there's a mobile close button, ensure it updates the toggle aria state
            const mobileClose = document.getElementById('gnc-sidebar-close');
            if (mobileClose) {
                mobileClose.addEventListener('click', () => {
                    document.body.classList.remove('sidebar-open');
                    toggleButton.setAttribute('aria-expanded', 'false');
                    try { window.localStorage.setItem('gnc-sidebar-open', 'false'); } catch(e){}
                });
            }

            // Close sidebar when clicking/tapping the overlay element
            const overlay = document.getElementById('gnc_overlay');
            if (overlay) {
                overlay.addEventListener('click', () => {
                    if (document.body.classList.contains('sidebar-open')) {
                        document.body.classList.remove('sidebar-open');
                        toggleButton.setAttribute('aria-expanded', 'false');
                        try { window.localStorage.setItem('gnc-sidebar-open', 'false'); } catch(e){}
                    }
                });

                overlay.addEventListener('touchstart', () => {
                    if (document.body.classList.contains('sidebar-open')) {
                        document.body.classList.remove('sidebar-open');
                        toggleButton.setAttribute('aria-expanded', 'false');
                        try { window.localStorage.setItem('fosja-sidebar-open', 'false'); } catch(e){}
                    }
                }, {passive: true});
            }
        });
    </script>
@endpush
