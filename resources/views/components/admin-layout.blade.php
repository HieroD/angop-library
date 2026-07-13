@php
    $staff = auth('staff')->user();
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
<body class="min-h-screen bg-[#f8f9fa] font-sans text-[#191c1d]">
    <div class="min-h-screen lg:flex" x-data="{ sidebarOpen: false }">
        <aside class="fixed inset-y-0 left-0 z-40 flex w-[260px] flex-col border-r border-[#bcc9c6] bg-[#2e3132] px-3 py-6 shadow-sm transition-transform duration-300 lg:translate-x-0" x-bind:class="sidebarOpen ? 'max-lg:translate-x-0' : 'max-lg:-translate-x-full'">
            <div class="flex items-center justify-between px-3 mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-[#f4fffc]">Angop Library</h1>
                    <p class="mt-1 text-sm text-[#e1e3e4]">Admin Panel</p>
                </div>
                <button class="text-[#e1e3e4] hover:text-white lg:hidden" x-on:click="sidebarOpen = false">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <nav class="flex flex-1 flex-col gap-2">
                <a href="{{ route('admin.dashboard') }}" @class([
                    'flex items-center gap-3 rounded-lg px-4 py-3 font-medium transition',
                    'bg-[#00685f] text-white' => $active === 'dashboard',
                    'text-[#e1e3e4] hover:bg-white/10' => $active !== 'dashboard',
                ])>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ $active === 'dashboard' ? 1 : 0 }}">dashboard</span>
                    Dashboard
                </a>
                <a href="{{ route('admin.books.index') }}" @class([
                    'flex items-center gap-3 rounded-lg px-4 py-3 font-medium transition',
                    'bg-[#00685f] text-white' => $active === 'books',
                    'text-[#e1e3e4] hover:bg-white/10' => $active !== 'books',
                ])>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ $active === 'books' ? 1 : 0 }}">menu_book</span>
                    Kelola Buku
                </a>
                <a href="{{ route('admin.members.index') }}" @class([
                    'flex items-center gap-3 rounded-lg px-4 py-3 font-medium transition',
                    'bg-[#00685f] text-white' => $active === 'members',
                    'text-[#e1e3e4] hover:bg-white/10' => $active !== 'members',
                ])>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ $active === 'members' ? 1 : 0 }}">group</span>
                    Kelola Anggota
                </a>
                <a href="{{ route('admin.borrowings.index') }}" @class([
                    'flex items-center gap-3 rounded-lg px-4 py-3 font-medium transition',
                    'bg-[#00685f] text-white' => $active === 'borrowings',
                    'text-[#e1e3e4] hover:bg-white/10' => $active !== 'borrowings',
                ])>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ $active === 'borrowings' ? 1 : 0 }}">handshake</span>
                    Kelola Peminjaman
                </a>
                <a href="{{ route('admin.returns.index') }}" @class([
                    'flex items-center gap-3 rounded-lg px-4 py-3 font-medium transition',
                    'bg-[#00685f] text-white' => $active === 'returns',
                    'text-[#e1e3e4] hover:bg-white/10' => $active !== 'returns',
                ])>
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ $active === 'returns' ? 1 : 0 }}">assignment_return</span>
                    Kelola Pengembalian
                </a>
            </nav>

            <form class="mt-4" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="flex w-full items-center gap-3 rounded-lg px-4 py-3 text-left font-medium text-rose-100 transition hover:bg-rose-500/15" type="submit">
                        <span class="material-symbols-outlined">logout</span>
                        Logout
                    </button>
            </form>

            <div class="border-t border-white/10 px-3 pt-5">
                <p class="text-sm font-semibold text-[#f4fffc]">{{ $staff?->name ?? 'Admin' }}</p>
                <p class="text-sm text-[#e1e3e4]">Administrator</p>
            </div>
        </aside>

        <header class="sticky top-0 z-20 flex items-center justify-between border-b border-[#bcc9c6] bg-white/95 px-4 py-3 shadow-sm backdrop-blur lg:hidden">
            <div>
                <p class="text-lg font-bold text-[#00685f]">Angop Library</p>
                <p class="text-xs text-[#3d4947]">Admin Panel</p>
            </div>
            <button class="btn btn-sm border-0 bg-[#00685f] text-white hover:bg-[#008378]" x-on:click="sidebarOpen = true">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </header>

        <main class="min-h-screen flex-1 bg-[#f3f4f5] p-4 sm:p-6 lg:ml-[260px] lg:p-8">
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
