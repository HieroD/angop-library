@php
    $member = auth('member')->user();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} - {{ config('app.name', 'Angop Library') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen bg-[#f3f4f5] font-sans text-[#191c1d]">
    <div x-data="{ mobileNavOpen: false }">
        <header class="fixed top-0 z-50 flex h-16 w-full items-center border-b border-[#e1e3e4] bg-white shadow-sm">
            <div class="mx-auto flex h-full w-full max-w-[1280px] items-center justify-between px-4 sm:px-6">
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-[#00685f] sm:text-3xl">Angop Library</h1>
                </div>

                <nav class="hidden h-16 items-end gap-6 md:flex">
                    <a href="{{ route('member.dashboard') }}" @class([
                        'flex h-full items-end border-b-2 pb-4 font-semibold transition-colors',
                        'border-[#00685f] text-[#00685f]' => $active === 'dashboard',
                        'border-transparent text-[#3d4947] hover:border-[#00685f] hover:text-[#00685f]' => $active !== 'dashboard',
                    ])>
                        <span class="text-sm uppercase tracking-wider">Dashboard</span>
                    </a>
                    <a href="{{ route('member.catalog.index') }}" @class([
                        'flex h-full items-end border-b-2 pb-4 font-semibold transition-colors',
                        'border-[#00685f] text-[#00685f]' => $active === 'catalog',
                        'border-transparent text-[#3d4947] hover:border-[#00685f] hover:text-[#00685f]' => $active !== 'catalog',
                    ])>
                        <span class="text-sm uppercase tracking-wider">Katalog Buku</span>
                    </a>
                    <a href="{{ route('member.borrowings.rules') }}" @class([
                        'flex h-full items-end border-b-2 pb-4 font-semibold transition-colors',
                        'border-[#00685f] text-[#00685f]' => $active === 'borrowings',
                        'border-transparent text-[#3d4947] hover:border-[#00685f] hover:text-[#00685f]' => $active !== 'borrowings',
                    ])>
                        <span class="text-sm uppercase tracking-wider">Aturan Peminjaman</span>
                    </a>
                </nav>

                <div class="flex flex-1 items-center justify-end gap-3 text-[#3d4947]">

                    <form class="hidden md:block" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="flex cursor-pointer items-center gap-2 rounded-lg bg-[#ba1a1a] px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-[#93000a]" type="submit">
                            Keluar
                        </button>
                    </form>

                    <button class="flex h-9 w-9 items-center justify-center rounded-lg transition-colors hover:bg-[#e1e3e4] md:hidden" x-on:click="mobileNavOpen = !mobileNavOpen">
                        <span class="material-symbols-outlined" x-text="mobileNavOpen ? 'close' : 'menu'">menu</span>
                    </button>
                </div>
            </div>
        </header>

        <div class="fixed inset-0 z-40 bg-black/50 transition-opacity md:hidden" x-show="mobileNavOpen" x-on:click="mobileNavOpen = false" x-transition.opacity></div>

        <nav class="fixed inset-y-0 left-0 z-50 flex w-[260px] flex-col border-r border-[#e1e3e4] bg-white px-3 py-6 shadow-sm transition-transform duration-300 md:hidden" x-bind:class="mobileNavOpen ? 'translate-x-0' : '-translate-x-full'">
            <div class="mb-8 flex items-center justify-between px-3">
                <div>
                    <h1 class="text-xl font-bold text-[#00685f]">Angop Library</h1>
                    <p class="mt-1 text-sm text-[#3d4947]">Anggota</p>
                </div>
                <button class="text-[#3d4947] hover:text-[#191c1d]" x-on:click="mobileNavOpen = false">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <nav class="flex flex-1 flex-col gap-2">
                <a href="{{ route('member.dashboard') }}" @class([
                    'flex items-center gap-3 rounded-lg px-4 py-3 font-medium transition',
                    'bg-[#00685f] text-white' => $active === 'dashboard',
                    'text-[#3d4947] hover:bg-[#e1e3e4]' => $active !== 'dashboard',
                ])>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ $active === 'dashboard' ? 1 : 0 }}">home</span>
                    Beranda
                </a>
                <a href="{{ route('member.catalog.index') }}" @class([
                    'flex items-center gap-3 rounded-lg px-4 py-3 font-medium transition',
                    'bg-[#00685f] text-white' => $active === 'catalog',
                    'text-[#3d4947] hover:bg-[#e1e3e4]' => $active !== 'catalog',
                ])>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ $active === 'catalog' ? 1 : 0 }}">menu_book</span>
                    Katalog Buku
                </a>
                <a href="{{ route('member.borrowings.rules') }}" @class([
                    'flex items-center gap-3 rounded-lg px-4 py-3 font-medium transition',
                    'bg-[#00685f] text-white' => $active === 'borrowings',
                    'text-[#3d4947] hover:bg-[#e1e3e4]' => $active !== 'borrowings',
                ])>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ $active === 'borrowings' ? 1 : 0 }}">assignment</span>
                    Aturan Peminjaman
                </a>
            </nav>

            <div class="border-t border-[#e1e3e4] px-3 pt-5">
                <p class="text-sm font-semibold text-[#191c1d]">{{ $member->name }}</p>
                <p class="text-xs text-[#3d4947]">{{ $member->member_code }}</p>
            </div>

            <form class="mt-4" method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="flex w-full items-center gap-3 rounded-lg px-4 py-3 text-left font-medium text-[#ba1a1a] transition-colors hover:bg-[#ffdad6]" type="submit">
                    Keluar
                </button>
            </form>
        </nav>

        <main class="mx-auto min-h-screen max-w-[1280px] px-4 pb-6 pt-24 sm:px-6">
            @if (session('success'))
                <div class="mb-6 flex items-center gap-3 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                    <span class="material-symbols-outlined text-emerald-600" style="font-size: 20px;">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 flex items-center gap-3 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700">
                    <span class="material-symbols-outlined text-rose-600" style="font-size: 20px;">error</span>
                    {{ $errors->first() }}
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</body>
</html>
