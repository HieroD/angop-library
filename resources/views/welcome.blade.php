<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Angop Library') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen bg-[#f3f4f5] font-sans text-[#191c1d]">
    <header class="fixed top-0 z-50 flex h-16 w-full items-center border-b border-[#e1e3e4] bg-white shadow-sm">
        <div class="mx-auto flex h-full w-full max-w-[1280px] items-center justify-between px-4 sm:px-6">
            <h1 class="text-2xl font-bold text-[#00685f] sm:text-3xl">Angop Library</h1>
            <a href="{{ route('login') }}" class="rounded-lg bg-[#008378] px-5 py-2 text-sm font-semibold text-white transition-colors hover:bg-[#00685f]">
                Masuk
            </a>
        </div>
    </header>

    <main>
        <section class="flex min-h-[90vh] items-center bg-gradient-to-br from-[#f3f4f5] via-white to-[#d5f5f0] px-4 pt-16 sm:px-6">
            <div class="mx-auto flex w-full max-w-[820px] flex-col items-center text-center">
                <h2 class="text-4xl font-bold leading-tight text-[#191c1d] sm:text-5xl lg:text-7xl">
                    Pinjam Buku
                    <span class="text-[#008378]">Lebih Mudah</span>
                </h2>

                <div class="relative my-8">
                    <div class="absolute inset-0 mx-auto h-24 w-24 rounded-full bg-[#008378]/10 blur-xl"></div>
                    <span class="material-symbols-outlined relative text-[#008378]/30" style="font-size: 80px;">auto_stories</span>
                </div>

                <p class="max-w-lg text-lg leading-relaxed text-[#3d4947]">
                    Kelola peminjaman buku perpustakaan secara digital. Cari, pinjam, dan pantau riwayat peminjaman Anda kapan saja.
                </p>

                <div class="mt-8 flex flex-col items-center gap-4 sm:flex-row">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#008378] px-8 py-3 text-base font-semibold text-white shadow-sm transition-all hover:bg-[#00685f] hover:-translate-y-0.5">
                        Mulai Sekarang
                        <span class="material-symbols-outlined" style="font-size: 20px;">arrow_forward</span>
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-lg border border-[#e1e3e4] bg-white px-8 py-3 text-base font-semibold text-[#3d4947] transition-all hover:border-[#008378] hover:text-[#008378] hover:-translate-y-0.5">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
        </section>

        <section class="px-4 py-20 sm:px-6">
            <div class="mx-auto max-w-[1280px]">
                <div class="mb-12 text-center">
                    <h3 class="text-3xl font-bold text-[#191c1d] sm:text-4xl">Kenapa Angop Library?</h3>
                    <p class="mt-3 text-lg text-[#3d4947]">Kemudahan dalam setiap langkah peminjaman buku perpustakaan.</p>
                </div>
                <div class="flex flex-wrap justify-center gap-6 *:w-72">
                    <div class="rounded-xl border border-[#e1e3e4] bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:shadow-md">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-[#008378]/10 text-[#008378]">
                            <span class="material-symbols-outlined" style="font-size: 24px;">menu_book</span>
                        </div>
                        <h4 class="mb-2 text-lg font-semibold text-[#191c1d]">Katalog Digital</h4>
                        <p class="text-sm leading-relaxed text-[#3d4947]">Telusuri koleksi buku perpustakaan secara digital dengan fitur pencarian dan filter kategori.</p>
                    </div>
                    <div class="rounded-xl border border-[#e1e3e4] bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:shadow-md">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-[#008378]/10 text-[#008378]">
                            <span class="material-symbols-outlined" style="font-size: 24px;">how_to_reg</span>
                        </div>
                        <h4 class="mb-2 text-lg font-semibold text-[#191c1d]">Peminjaman Online</h4>
                        <p class="text-sm leading-relaxed text-[#3d4947]">Ajukan peminjaman buku secara online dan tunggu konfirmasi dari petugas perpustakaan.</p>
                    </div>
                    <div class="rounded-xl border border-[#e1e3e4] bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:shadow-md">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-[#008378]/10 text-[#008378]">
                            <span class="material-symbols-outlined" style="font-size: 24px;">history</span>
                        </div>
                        <h4 class="mb-2 text-lg font-semibold text-[#191c1d]">Riwayat Terkelola</h4>
                        <p class="text-sm leading-relaxed text-[#3d4947]">Pantau riwayat peminjaman dan pengembalian buku Anda dengan mudah melalui dashboard.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white px-4 py-20 sm:px-6">
            <div class="mx-auto max-w-[1280px]">
                <div class="mb-12 text-center">
                    <h3 class="text-3xl font-bold text-[#191c1d] sm:text-4xl">Bagaimana Cara Meminjam Buku?</h3>
                    <p class="mt-3 text-lg text-[#3d4947]">Hanya tiga langkah mudah untuk meminjam buku dari perpustakaan.</p>
                </div>
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <div class="relative text-center">
                        <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-[#008378] text-2xl font-bold text-white shadow-md">1</div>
                        <h4 class="mb-2 text-xl font-semibold text-[#191c1d]">Cari Buku</h4>
                        <p class="text-sm leading-relaxed text-[#3d4947]">Telusuri katalog buku yang tersedia. Gunakan fitur pencarian untuk menemukan buku yang Anda butuhkan.</p>
                    </div>
                    <div class="relative text-center">
                        <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-[#008378] text-2xl font-bold text-white shadow-md">2</div>
                        <h4 class="mb-2 text-xl font-semibold text-[#191c1d]">Ajukan Peminjaman</h4>
                        <p class="text-sm leading-relaxed text-[#3d4947]">Klik tombol pinjam pada buku yang diinginkan. Petugas akan mengonfirmasi permohonan Anda.</p>
                    </div>
                    <div class="relative text-center">
                        <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-[#008378] text-2xl font-bold text-white shadow-md">3</div>
                        <h4 class="mb-2 text-xl font-semibold text-[#191c1d]">Baca & Kembalikan</h4>
                        <p class="text-sm leading-relaxed text-[#3d4947]">Nikmati bacaan Anda dan kembalikan buku sebelum tenggat waktu untuk menghindari denda.</p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer class="border-t border-[#005f57] bg-[#00685f] px-4 py-8 sm:px-6">
        <div class="mx-auto flex max-w-[1280px] flex-col items-center justify-between gap-4 sm:flex-row">
            <p class="text-sm text-[#d5f5f0]">&copy; {{ date('Y') }} {{ config('app.name', 'Angop Library') }}. All rights reserved.</p>
            <p class="text-sm text-[#d5f5f0]">Sistem Informasi Perpustakaan Digital</p>
        </div>
    </footer>
</body>
</html>
