<!DOCTYPE html>
<html lang="en">
	<head><base href="">
		<title>System - {{ data_get($settings ?? [], 'site_name', config('app.name', 'Website')) }}</title>
		<meta charset="utf-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">

		@include('administrator.layouts.base.meta')
		@include('administrator.layouts.base.favicon')

		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-Sdun0nZ/SSRyhokW2N1DbStO2Qd6hw2yffA9H9n1tFoZT3zh0ElBTtPlqvGjufH6G+j6lJzi10BGSAdoo6gWQw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

		<!-- Fallback Bootstrap CSS for dashboard when local admin assets are missing -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
		<link href="{{ asset_administrator("assets/plugins/custom/fullcalendar/fullcalendar.bundle.css") }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset_administrator("assets/plugins/custom/datatables/datatables.bundle.css") }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset_administrator("assets/plugins/custom/jstree/jstree.bundle.css") }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset_administrator("assets/plugins/global/plugins.bundle.css") }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset_administrator("assets/css/style.bundle.css") }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset_administrator("assets/css/custom.css") }}" rel="stylesheet" type="text/css" />
		<style>
			:root {
				--gnc-accent: #4f1f9b;
				--gnc-accent-dark: rgb(43, 15, 107);
				--gnc-surface: #ffffff;
				--gnc-surface-subtle: #effff4;
				--gnc-text: #1b1f1d;
				--gnc-primary-nav-bg: #1e1f26;
				--gnc-primary-nav-active: #603ba5;
				--gnc-secondary-bg: rgb(233, 240, 232);
				--gnc-secondary-border: rgba(0, 0, 0, 0.05);
				--gnc-secondary-active: rgba(106, 63, 185, 0.12);
			}

			[data-theme="dark"] {
				--gnc-surface: #142018;
				--gnc-surface-subtle: #110d16;
				--gnc-text: #eaf7ef;
			}

			body {
				background: var(--gnc-surface-subtle);
				color: var(--gnc-text);
				transition: background 0.3s ease, color 0.3s ease;
			}

			body[data-theme="dark"] {
				background: var(--gnc-surface-subtle);
				color: var(--gnc-text);
			}

			.gnc-discord-aside {
				display: flex;
				flex-direction: column;
				width: 340px;
				background: var(--gnc-secondary-bg);
				transition: transform 0.25s ease;
				/* hide by default and position fixed so it overlays content when opened */
				position: fixed;
				top: 0;
				bottom: 0;
				left: 0;
				transform: translateX(-100%);
				z-index: 1080;
			}

			#gnc_discord_shell {
				display: flex;
				height: 100%;
				background: var(--gnc-secondary-bg);
				border-right: 1px solid var(--gnc-secondary-border);
				box-shadow: 6px 0 18px rgba(15, 15, 15, 0.08);
			}

			.gnc-primary-nav {
				width: 86px;
				background: var(--gnc-primary-nav-bg);
				display: flex;
				flex-direction: column;
				align-items: center;
				gap: 12px;
				padding: 18px 12px;
			}

			.gnc-primary-item {
				width: 52px;
				height: 52px;
				border-radius: 18px;
				border: none;
				background: rgba(255, 255, 255, 0.08);
				color: rgba(255, 255, 255, 0.76);
				transition: all 120ms ease;
				display: flex;
				align-items: center;
				justify-content: center;
				cursor: pointer;
			}

			.gnc-primary-item:hover {
				background: rgba(255, 255, 255, 0.18);
				color: #ffffff;
				transform: translateY(-2px);
			}

			/* Right-side tooltip label for primary nav items */
			.gnc-primary-item::after {
				content: attr(data-label);
				position: absolute;
				top: 50%;
				left: 100%;
				transform: translateY(-50%) translateX(12px);
				display: inline-block;
				padding: 8px 12px;
				background: rgba(255,255,255,0.98);
				color: var(--gnc-text);
				border-radius: 8px;
				box-shadow: 0 6px 18px rgba(15,15,15,0.08);
				white-space: nowrap;
				opacity: 0;
				pointer-events: none;
				transition: opacity 120ms ease, transform 120ms ease;
				z-index: 1100;
			}

			.gnc-primary-item:hover::after {
				opacity: 1;
				transform: translateY(-50%) translateX(6px);
			}

			.gnc-primary-item.is-active {
				background: var(--gnc-primary-nav-active);
				color: #ffffff;
				box-shadow: 0 6px 16px rgba(59, 165, 93, 0.35);
			}

			.gnc-secondary-nav {
				flex: 1;
				display: flex;
				flex-direction: column;
				padding: 24px 24px;
				background: transparent;
			}

			.gnc-secondary-header {
				display: flex;
				align-items: center;
				justify-content: space-between;
				margin-bottom: 18px;
			}

			.gnc-secondary-header h4 {
				margin: 0;
				font-weight: 700;
				font-size: 1.05rem;
			}

			.gnc-secondary-body {
				flex: 1;
				display: flex;
				flex-direction: column;
				row-gap: 10px;
				overflow-y: auto;
				padding-right: 6px;
			}

			.gnc-module-link {
				display: flex;
				align-items: center;
				gap: 14px;
				padding: 12px 18px;
				border-radius: 14px;
				background: transparent;
				color: var(--gnc-text);
				text-decoration: none;
				transition: all 0.2s ease;
				font-weight: 600;
				font-size: 0.97rem;
			}

			.gnc-module-link:hover {
				background: rgba(63, 185, 80, 0.16);
				color: var(--gnc-accent-dark);
				transform: translateX(4px);
			}

			.gnc-module-link.is-active {
				background: var(--gnc-secondary-active);
				color: var(--gnc-accent-dark);
				box-shadow: inset 2px 0 0 var(--gnc-accent);
			}

			.gnc-module-icon {
				width: 36px;
				height: 36px;
				border-radius: 12px;
				display: flex;
				align-items: center;
				justify-content: center;
				background: rgba(31, 155, 87, 0.12);
				color: var(--gnc-accent);
				font-size: 1rem;
			}

			.gnc-empty-state {
				display: flex;
				align-items: center;
				justify-content: center;
				gap: 10px;
				padding: 20px;
				border-radius: 12px;
				border: 1px dashed var(--gnc-secondary-border);
				color: rgba(0, 0, 0, 0.55);
				font-weight: 500;
			}

			[data-theme="dark"] .gnc-primary-nav {
				background: #202225;
			}

			[data-theme="dark"] #gnc_discord_shell {
				background: rgba(30, 31, 38, 0.96);
				border-color: rgba(255, 255, 255, 0.05);
			}

			[data-theme="dark"] .gnc-module-icon {
				background: rgba(59, 165, 93, 0.12);
			}

			/* Sidebar open state and overlay for all screen sizes */
			body.sidebar-open .gnc-discord-aside {
				transform: translateX(0);
			}

			/* Real overlay element shown when sidebar is open */
			.gnc-overlay {
				display: none;
				position: fixed;
				top: 0;
				left: 0;
				right: 0;
				bottom: 0;
				background: rgba(15, 15, 15, 0.45);
				z-index: 1075;
			}

			body.sidebar-open .gnc-overlay {
				display: block;
			}

			/* Ensure header/navbar is fixed at top; sidebar will overlay it when opened */
			#kt_header {
				position: fixed;
				top: 0;
				left: 0;
				right: 0;
				z-index: 1060;
				width: 100%;
				background: var(--gnc-surface);
				box-shadow: 0 1px 8px rgba(15,15,15,0.04);
				backdrop-filter: blur(4px);
			}

			/* push page content down so header doesn't overlap it */
			#kt_wrapper {
				padding-top: 72px; /* adjust if header height differs */
			}

			body[data-theme="dark"] .card,
			body[data-theme="dark"] .menu-sub,
			body[data-theme="dark"] .dropdown-menu {
				background: var(--gnc-surface);
				color: var(--gnc-text);
			}

			.btn.btn-primary {
				background-color: var(--gnc-accent);
				border-color: var(--gnc-accent);
			}

			.btn.btn-primary:hover,
			.btn.btn-primary:focus,
			.btn.btn-primary:active {
				background-color: var(--gnc-accent-dark);
				border-color: var(--gnc-accent-dark);
			}

			a {
				color: var(--gnc-accent);
			}

			a:hover {
				color: var(--gnc-accent-dark);
			}

			.dataTables_length{
				float: left !important;
			}

			/* Utility: make a card transparent (used by some admin pages like menus) */
			/* Card variant: solid white background for pages that need a white container */
			.card-white {
				background: var(--gnc-surface) !important;
				box-shadow: 0 6px 18px rgba(15, 15, 15, 0.04) !important;
				border: 1px solid rgba(0,0,0,0.03) !important;
			}
			.dataTables_info{
				float: left !important;
			}
            .resi-area table, th, td {
                border: 2px solid;
            }
            @media print{
                img{
                    display: block;
                }
                .pagebreak {
                    page-break-before: always;
                }
            }
		</style>
		@stack('style')
	</head>
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-enabled" data-theme="light">
		<div class="d-flex flex-column flex-root">
			<div class="page d-flex flex-row flex-column-fluid">
				@include('administrator.layouts.sidebar')
				<!-- Overlay that appears when sidebar is open -->
				<div id="gnc_overlay" class="gnc-overlay" aria-hidden="true"></div>
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					@include('administrator.layouts.header')
					<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
						<div class="content flex-row-fluid" id="kt_content">
							<div class="page-title d-flex flex-column me-3 mb-3">
								<h1 class="d-flex text-dark fw-bolder my-1 fs-3">
									{{ $pageTitle ?? 'Untitled' }}
								</h1>
								<ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
									<li class="breadcrumb-item text-gray-600">
										<a href="{{ route('admin.dashboard') }}" class="text-gray-600 text-hover-primary">Dashboard</a>
									</li>
									@foreach ($breadcrumbs ?? [] as $item)
										<li class="breadcrumb-item text-gray-{{ $loop->last ? '500' : '600' }}">
											@if(isset($item['url']))
												<a href="{{ $item['url'] }}" class="text-gray-600 text-hover-primary">
													{{ $item['label'] }}
												</a>
											@else
												{{ $item['label'] }}
											@endif
										</li>
									@endforeach
								</ul>
							</div>
							@yield('content')
						</div>
					</div>
					@include('administrator.layouts.footer')
				</div>
			</div>
		</div>
		@stack('modal')
		<script>
			(function applyStoredTheme(){
				const body = document.getElementById('kt_body');
				const storedTheme = window.localStorage.getItem('gnc-theme');
				if(storedTheme === 'dark') {
					body.setAttribute('data-theme', 'dark');
					document.documentElement.setAttribute('data-theme', 'dark');
				} else {
					body.setAttribute('data-theme', 'light');
					document.documentElement.setAttribute('data-theme', 'light');
				}
			})();
			var hostUrl = "{{asset_administrator('assets/')}}";
		</script>
		<script src="{{asset_administrator('assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset_administrator('assets/js/scripts.bundle.js')}}"></script>

		<!-- Fallback Bootstrap JS -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
		<script src="{{asset_administrator('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
		<script src="{{asset_administrator('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
		<script src="{{asset_administrator('ckeditor\ckeditor.js')}}"></script>
		<script src="{{ asset_administrator('assets/plugins/custom/inputmask/inputmask.min.js') }}"></script>
		<script src="{{ asset_administrator('assets/plugins/custom/inputmask/page/inputmask.js') }}"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
		<script>
			var tagifys = {};
			$(document).ready(function () {
				$("input.tagify").each(function () {
					const tagifyInstance = new Tagify(this, {
						whitelist: [],
						dropdown: {
							maxItems: 20,
							classname: "tagify__inline__suggestions",
							enabled: 0,
							closeOnSelect: false,
						},
					});

					tagifys[$(this).attr("name")] = tagifyInstance;
				});
			});
		</script>
		<script>
			document.addEventListener('DOMContentLoaded', function () {
				const themeToggle = document.getElementById('gnc-theme-toggle');
				if (!themeToggle) {
					return;
				}

				const applyTheme = (nextTheme) => {
					const body = document.getElementById('kt_body');
					body.setAttribute('data-theme', nextTheme);
					document.documentElement.setAttribute('data-theme', nextTheme);
					window.localStorage.setItem('gnc-theme', nextTheme);
					themeToggle.setAttribute('data-theme', nextTheme);
					const iconSun = themeToggle.querySelector('[data-icon="sun"]');
					const iconMoon = themeToggle.querySelector('[data-icon="moon"]');
					if (nextTheme === 'dark') {
						iconMoon.classList.remove('d-none');
						iconSun.classList.add('d-none');
					} else {
						iconMoon.classList.add('d-none');
						iconSun.classList.remove('d-none');
					}
				};

				// Initialize button icon state
				const currentTheme = window.localStorage.getItem('gnc-theme') === 'dark' ? 'dark' : 'light';
				applyTheme(currentTheme);

				themeToggle.addEventListener('click', function () {
					const nextTheme = (window.localStorage.getItem('gnc-theme') === 'dark') ? 'light' : 'dark';
					applyTheme(nextTheme);
				});
			});
		</script>
		@stack('scripts')
	</body>
</html>
