<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full flex-col gap-3">
            <h1 class="text-3xl font-semibold text-slate-900 dark:text-white">Edit Peserta</h1>
            <nav class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 focus:text-indigo-600 dark:hover:text-indigo-300 dark:focus:text-indigo-300">Dashboard</a>
                <span>/</span>
                <a href="{{ route('participants.index') }}" class="hover:text-indigo-600 focus:text-indigo-600 dark:hover:text-indigo-300 dark:focus:text-indigo-300">Peserta</a>
                <span>/</span>
                <span class="text-slate-700 dark:text-slate-200">{{ $participant->name }}</span>
            </nav>
        </div>
    </x-slot>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Perbarui Data Peserta</h2>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Sesuaikan informasi peserta di bawah ini.</p>

        @if ($errors->any())
            <div class="mt-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700 dark:border-rose-900/40 dark:bg-rose-900/20 dark:text-rose-200">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('participants.update', $participant) }}" method="POST" class="mt-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $participant->name) }}" required class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring focus:ring-indigo-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-indigo-400">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Username</label>
                        <input type="text" name="username" value="{{ old('username', $participant->username) }}" required class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring focus:ring-indigo-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-indigo-400">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
                        <input type="email" name="email" value="{{ old('email', $participant->email) }}" required class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring focus:ring-indigo-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-indigo-400">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Nomor HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $participant->no_hp) }}" required class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring focus:ring-indigo-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-indigo-400">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Tanggal Lahir</label>
                        <input type="date" name="birthday" value="{{ old('birthday', optional($participant->birthday)->format('Y-m-d')) }}" class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring focus:ring-indigo-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-indigo-400">
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Asal Sekolah</label>
                        <input type="text" name="from_school" value="{{ old('from_school', $participant->from_school) }}" class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring focus:ring-indigo-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-indigo-400">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">URL Foto (opsional)</label>
                        <input type="text" name="photo" value="{{ old('photo', $participant->photo) }}" class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring focus:ring-indigo-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-indigo-400">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Generasi</label>
                        <select name="generations_id" class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring focus:ring-indigo-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-indigo-400">
                            <option value="">-- Pilih generasi --</option>
                            @foreach ($generations as $generation)
                                <option value="{{ $generation->id }}" @selected(old('generations_id', $participant->generations_id) === $generation->id)>
                                    {{ $generation->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Posisi</label>
                        @php
                            $selectedPositions = collect(old('positions', $participant->positions->pluck('id')->all()));
                        @endphp
                        <select name="positions[]" multiple size="5" class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring focus:ring-indigo-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-indigo-400">
                            @foreach ($positions as $position)
                                <option value="{{ $position->id }}" @selected($selectedPositions->contains($position->id))>
                                    {{ $position->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Gunakan tombol Ctrl (atau Cmd di Mac) untuk memilih lebih dari satu posisi.</p>
                    </div>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Password Baru</label>
                            <input type="password" name="password" class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring focus:ring-indigo-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-indigo-400">
                            <p class="text-xs text-slate-500 dark:text-slate-400">Kosongkan jika tidak ingin mengubah password.</p>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-900 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring focus:ring-indigo-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-indigo-400">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('participants.index') }}" class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-800 dark:border-slate-700 dark:text-slate-300 dark:hover:border-slate-600 dark:hover:text-slate-100">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-700">
                    <i class="fa-solid fa-check text-xs"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
