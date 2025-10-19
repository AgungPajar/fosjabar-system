@extends('administrator.layouts.main', [
    'pageTitle' => 'Dashboard',
    'breadcrumbs' => [
        ['label' => 'Dashboard'],
    ],
])

@section('content')
<div class="row g-5 g-xl-8">
    <div class="col-xl-12">
        <div class="card card-flush">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <h2 class="mb-0">Welcome to GnC</h2>
                </div>
            </div>
            <div class="card-body py-5">
                <p class="fs-5 text-gray-600 mb-5">
                    Gunakan panel ini untuk mengelola modul sistem, pengguna, dan konten berita.
                </p>
                <div class="row g-5">
                    <div class="col-md-4">
                        <div class="bg-success bg-opacity-10 border border-success border-dashed rounded-3 p-6 h-100">
                            <span class="fs-4 fw-bold text-success mb-2 d-block">Mode Gelap & Terang</span>
                            <p class="text-gray-600 mb-0">Aktifkan toggle tema di kanan atas untuk beralih sesuai preferensi Anda.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-success bg-opacity-10 border border-success border-dashed rounded-3 p-6 h-100">
                            <span class="fs-4 fw-bold text-success mb-2 d-block">Kelola Berita</span>
                            <p class="text-gray-600 mb-0">Modul News membantu tim mempublikasikan informasi terbaru secara konsisten.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-success bg-opacity-10 border border-success border-dashed rounded-3 p-6 h-100">
                            <span class="fs-4 fw-bold text-success mb-2 d-block">Aksen Hijau Elegan</span>
                            <p class="text-gray-600 mb-0">Antarmuka memanfaatkan warna hijau sebagai identitas Gnc.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
