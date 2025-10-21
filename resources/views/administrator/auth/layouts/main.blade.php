<!DOCTYPE html>
<html lang="en">

<head>
    <base href="../../../">
    <title>System - {{ data_get($settings ?? [], 'site_name', config('app.name', 'Website')) }}</title>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('administrator.layouts.base.meta')
    @include('administrator.layouts.base.favicon')

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

    <!-- Fallback: load Bootstrap CSS from CDN when local admin assets are not available -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="{{ asset_administrator('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset_administrator('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

    @stack('styles')
</head>

<body id="kt_body" class="bg-body">
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-column-fluid" style="background-color: #f8faf9;">
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <a href="../../demo18/dist/index.html" class="mb-12">
                    <img alt="Logo"
                        src="{{ img_src(data_get($settings ?? [], 'logo'), 'logo') ?: asset('assets/media/img/default/logo.png') }}"
                        class="h-6rem" style="height:6rem; width:auto;" />
                </a>
                <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto"
                    style="border:2px solid #7c3aed; box-shadow: 0 6px 18px rgba(124,58,237,0.08);">
                        <div class="text-center mb-10">
                            <h1 class="text-dark mb-3">
                                {{ $label ?? 'Untitled' }}
                            </h1>
                            @if(!empty($subtitle))
                                <div class="text-muted mb-3">{{ $subtitle }}</div>
                            @endif
                        </div>
                    @yield('content')
                </div>
            </div>
            @include('administrator.auth.layouts.footer')
        </div>
    </div>
    <script>
        var hostUrl = "assets/";
    </script>
    <script src="{{ asset_administrator('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset_administrator('assets/js/scripts.bundle.js') }}"></script>

    <!-- Fallback: load Bootstrap JS from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
