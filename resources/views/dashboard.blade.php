<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <span class="text-sm text-slate-500 dark:text-slate-400">Ringkasan hari ini</span>
            <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">{{ __('Dashboard Admin') }}</h2>
        </div>
    </x-slot>

    <div class="space-y-8">
        <section class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Users</p>
                        <p class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">{{ $totalUsers }}</p>
                    </div>
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-300">
                        <x-icon name="users" class="h-6 w-6" />
                    </span>
                </div>
                <p class="mt-4 text-xs text-slate-400 dark:text-slate-500">Pantau jumlah pengguna yang sudah terdaftar di sistem.</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total News</p>
                        <p class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">{{ $totalNews }}</p>
                    </div>
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-300">
                        <x-icon name="newspaper" class="h-6 w-6" />
                    </span>
                </div>
                <p class="mt-4 text-xs text-slate-400 dark:text-slate-500">Melihat jumlah artikel berita yang sudah dipublikasikan.</p>
            </div>

            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-6 shadow-inner dark:border-slate-700 dark:bg-slate-900/40">
                <div class="flex h-full flex-col justify-center gap-3 text-center">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Butuh fitur lain?</p>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Tambahkan modul baru atau integrasikan dengan layanan lain kapan pun.</p>
                    <a href="#" class="mx-auto inline-flex items-center gap-2 rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-700">Minta Pengembangan</a>
                </div>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 lg:col-span-2">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Aktivitas Cepat</h3>
                    <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-300">Lihat semua</a>
                </div>
                <ul class="mt-6 space-y-4 text-sm">
                    <li class="flex items-start gap-3">
                        <span class="mt-1 inline-flex h-6 w-6 flex-none items-center justify-center rounded-full bg-indigo-500/10 text-xs font-semibold text-indigo-600 dark:text-indigo-300">1</span>
                        <div class="flex-1">
                            <p class="font-medium text-slate-800 dark:text-slate-200">Lengkapi data pengguna baru</p>
                            <p class="text-slate-500 dark:text-slate-400">Pastikan profil pengguna memiliki informasi kontak dan peran yang jelas.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-1 inline-flex h-6 w-6 flex-none items-center justify-center rounded-full bg-indigo-500/10 text-xs font-semibold text-indigo-600 dark:text-indigo-300">2</span>
                        <div class="flex-1">
                            <p class="font-medium text-slate-800 dark:text-slate-200">Perbarui berita penting</p>
                            <p class="text-slate-500 dark:text-slate-400">Sorot berita terbaru agar mudah ditemukan oleh pengunjung.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-1 inline-flex h-6 w-6 flex-none items-center justify-center rounded-full bg-indigo-500/10 text-xs font-semibold text-indigo-600 dark:text-indigo-300">3</span>
                        <div class="flex-1">
                            <p class="font-medium text-slate-800 dark:text-slate-200">Tinjau laporan aktivitas</p>
                            <p class="text-slate-500 dark:text-slate-400">Analisis aktivitas pengguna untuk memahami kebutuhan mereka.</p>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Catatan Sistem</h3>
                <div class="flex flex-col gap-3 text-sm text-slate-500 dark:text-slate-400">
                    <div class="rounded-xl bg-slate-100 px-4 py-3 dark:bg-slate-800/60">
                        <p class="font-semibold text-slate-800 dark:text-slate-200">Backup terakhir</p>
                        <p class="text-xs">12 Januari 2024 • 22:15 WIB</p>
                    </div>
                    <div class="rounded-xl bg-slate-100 px-4 py-3 dark:bg-slate-800/60">
                        <p class="font-semibold text-slate-800 dark:text-slate-200">Status Server</p>
                        <p class="text-xs">Semua layanan berjalan normal</p>
                    </div>
                    <div class="rounded-xl bg-slate-100 px-4 py-3 dark:bg-slate-800/60">
                        <p class="font-semibold text-slate-800 dark:text-slate-200">Pengingat</p>
                        <p class="text-xs">Jadwalkan pelatihan admin baru minggu depan.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
