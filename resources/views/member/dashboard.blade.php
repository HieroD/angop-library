<x-member-layout title="Dashboard" active="dashboard">
    <div class="mb-6 flex flex-col gap-1">
        <h2 class="text-2xl font-bold text-[#191c1d] sm:text-3xl">Halo, {{ $member->name }}</h2>
        <p class="text-base text-[#3d4947]">Senang melihat Anda kembali. Berikut adalah ringkasan aktivitas perpustakaan Anda.</p>
    </div>

    <div class="mb-6 inline-flex items-center gap-2 rounded-lg bg-[#008378] px-4 py-2 text-sm font-semibold text-[#f4fffc]">
        <span class="material-symbols-outlined" style="font-size: 18px; font-variation-settings: 'FILL' 1;">badge</span>
        Kode Anggota: {{ $member->member_code }}
    </div>

    <section class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-3">
        <article class="flex items-start gap-4 rounded-lg border border-[#e1e3e4] bg-white p-5 shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md">
            <div class="rounded-lg bg-[#d5e3fc] p-3 text-[#57657a]">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1; font-size: 24px;">menu_book</span>
            </div>
            <div>
                <p class="mb-1 text-xs font-semibold tracking-wider text-[#3d4947] uppercase">Buku Sedang Dipinjam</p>
                <p class="text-3xl font-bold text-[#191c1d]">{{ $bukuSedangDipinjam }}</p>
            </div>
        </article>

        <article class="flex items-start gap-4 rounded-lg border border-[#e1e3e4] bg-white p-5 shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md">
            <div class="rounded-lg bg-[#e1e3e4] p-3 text-[#3d4947]">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1; font-size: 24px;">history</span>
            </div>
            <div>
                <p class="mb-1 text-xs font-semibold tracking-wider text-[#3d4947] uppercase">Total Buku Dipinjam</p>
                <p class="text-3xl font-bold text-[#191c1d]">{{ $totalBukuDipinjam }}</p>
            </div>
        </article>

        <article class="flex items-start gap-4 rounded-lg border border-[#e1e3e4] bg-white p-5 shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md">
            <div class="rounded-lg bg-[#ffdad6] p-3 text-[#93000a]">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1; font-size: 24px;">payments</span>
            </div>
            <div>
                <p class="mb-1 text-xs font-semibold tracking-wider text-[#3d4947] uppercase">Total Denda</p>
                <p class="text-3xl font-bold {{ $totalDenda > 0 ? 'text-[#ba1a1a]' : 'text-[#191c1d]' }}">Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
            </div>
        </article>
    </section>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            <section class="overflow-hidden rounded-lg border border-[#e1e3e4] bg-white shadow-sm">
                <div class="border-b border-[#e1e3e4] px-5 py-4">
                    <h3 class="text-lg font-semibold text-[#191c1d]">Peminjaman Aktif</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-[#e1e3e4] bg-[#f3f4f5]">
                                <th class="px-5 py-3 text-xs font-semibold tracking-wider text-[#3d4947] uppercase">Judul Buku</th>
                                <th class="px-5 py-3 text-xs font-semibold tracking-wider text-[#3d4947] uppercase">Tenggat Waktu</th>
                                <th class="px-5 py-3 text-xs font-semibold tracking-wider text-[#3d4947] uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($peminjamanAktif as $borrowing)
                                @php
                                    $daysRemaining = $borrowing->due_date ? now()->startOfDay()->diffInDays($borrowing->due_date, false) : null;
                                @endphp
                                <tr class="border-b border-[#e1e3e4] transition-colors hover:bg-[#f3f4f5]">
                                    <td class="px-5 py-4">
                                        <p class="font-medium text-[#191c1d]">{{ $borrowing->book->title }}</p>
                                        <p class="text-sm text-[#3d4947]">{{ $borrowing->book->authors->pluck('name')->join(', ') }}</p>
                                    </td>
                                    <td class="px-5 py-4 text-sm @if ($daysRemaining !== null && $daysRemaining < 0) font-medium text-[#ba1a1a] @elseif ($daysRemaining !== null && $daysRemaining <= 2) font-medium text-[#f97316] @else text-[#3d4947] @endif">
                                        @if ($borrowing->due_date)
                                            {{ $borrowing->due_date->translatedFormat('d M Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-5 py-4">
                                        @if ($borrowing->status === 'menunggu konfirmasi')
                                            <span class="inline-flex items-center rounded bg-[#e1e3e4] px-2 py-1 text-xs font-semibold tracking-wider text-[#3d4947] uppercase">
                                                Menunggu Konfirmasi
                                            </span>
                                        @elseif ($daysRemaining < 0)
                                            <span class="inline-flex items-center rounded bg-[#ffdad6] px-2 py-1 text-xs font-semibold tracking-wider text-[#93000a] uppercase">
                                                Terlambat {{ abs($daysRemaining) }} Hari
                                            </span>
                                        @elseif ($daysRemaining == 0)
                                            <span class="inline-flex items-center rounded bg-[#ffedd5] px-2 py-1 text-xs font-semibold tracking-wider text-[#f97316] uppercase">
                                                Jatuh Tempo Hari Ini
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded bg-[#d5e3fc] px-2 py-1 text-xs font-semibold tracking-wider text-[#57657a] uppercase">
                                                {{ $daysRemaining }} Hari Lagi
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-5 py-10 text-center text-sm text-[#3d4947]">
                                        <div class="flex flex-col items-center gap-2">
                                            <span class="material-symbols-outlined text-[#6d7a77]" style="font-size: 32px;">library_books</span>
                                            <p>Tidak ada peminjaman aktif saat ini.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="overflow-hidden rounded-lg border border-[#e1e3e4] bg-white shadow-sm">
                <div class="border-b border-[#e1e3e4] px-5 py-4">
                    <h3 class="text-lg font-semibold text-[#191c1d]">Riwayat Peminjaman</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-[#e1e3e4] bg-[#f3f4f5]">
                                <th class="px-5 py-3 text-xs font-semibold tracking-wider text-[#3d4947] uppercase">Judul Buku</th>
                                <th class="px-5 py-3 text-xs font-semibold tracking-wider text-[#3d4947] uppercase">Tanggal Pinjam</th>
                                <th class="px-5 py-3 text-xs font-semibold tracking-wider text-[#3d4947] uppercase">Tanggal Kembali</th>
                                <th class="px-5 py-3 text-xs font-semibold tracking-wider text-[#3d4947] uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($riwayatPeminjaman as $borrowing)
                                <tr class="border-b border-[#e1e3e4] transition-colors hover:bg-[#f3f4f5]">
                                    <td class="px-5 py-4">
                                        <p class="font-medium text-[#191c1d]">{{ $borrowing->book->title }}</p>
                                        <p class="text-sm text-[#3d4947]">{{ $borrowing->book->authors->pluck('name')->join(', ') }}</p>
                                    </td>
                                    <td class="px-5 py-4 text-sm text-[#3d4947]">{{ $borrowing->borrow_date->translatedFormat('d M Y') }}</td>
                                    <td class="px-5 py-4 text-sm text-[#3d4947]">
                                        {{ $borrowing->returned_at?->translatedFormat('d M Y') ?? '-' }}
                                    </td>
                                    <td class="px-5 py-4">
                                        @if ($borrowing->status === 'dikembalikan')
                                            <span class="inline-flex items-center rounded bg-[#008378] px-2 py-1 text-xs font-semibold tracking-wider text-[#f4fffc] uppercase">Selesai</span>
                                        @else
                                            <span class="inline-flex items-center rounded bg-[#ffdad6] px-2 py-1 text-xs font-semibold tracking-wider text-[#93000a] uppercase">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-10 text-center text-sm text-[#3d4947]">
                                        <div class="flex flex-col items-center gap-2">
                                            <span class="material-symbols-outlined text-[#6d7a77]" style="font-size: 32px;">history</span>
                                            <p>Belum ada riwayat peminjaman.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <aside class="lg:col-span-1">
            <section class="overflow-hidden rounded-lg border border-[#e1e3e4] bg-white shadow-sm">
                <div class="border-b border-[#e1e3e4] px-5 py-4">
                    <h3 class="text-lg font-semibold text-[#191c1d]">Rekomendasi Untukmu</h3>
                </div>
                <div class="grid grid-cols-2 gap-3 p-4">
                    @forelse ($bukuRekomendasi as $book)
                        <div class="group cursor-pointer">
                            <div class="relative mb-2 aspect-[2/3] w-full overflow-hidden rounded-lg border border-[#e1e3e4] bg-gradient-to-br from-[#008378] to-[#00685f]">
                                @if ($book->book_cover)
                                    <img alt="{{ $book->title }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" src="{{ Storage::url($book->book_cover) }}">
                                @else
                                    <div class="flex h-full items-center justify-center">
                                        <span class="select-none text-4xl font-bold text-[#f4fffc]/30">{{ strtoupper(substr($book->title, 0, 1)) }}</span>
                                    </div>
                                @endif
                                @if ($book->category)
                                    <div class="absolute left-2 top-2 rounded px-1.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white shadow-sm" style="background-color: {{ match($book->category->name) { 'Sains', 'Science' => '#515f74', 'Bisnis', 'Business' => '#924628', default => '#00685f' } }}">{{ $book->category->name }}</div>
                                @endif
                            </div>
                            <h4 class="truncate text-sm font-semibold text-[#191c1d] transition-colors group-hover:text-[#00685f]">{{ $book->title }}</h4>
                            <p class="truncate text-xs text-[#3d4947]">{{ $book->authors->pluck('name')->join(', ') }}</p>
                        </div>
                    @empty
                        <div class="col-span-2 py-8 text-center text-sm text-[#3d4947]">
                            <div class="flex flex-col items-center gap-2">
                                <span class="material-symbols-outlined text-[#6d7a77]" style="font-size: 32px;">auto_stories</span>
                                <p>Belum ada rekomendasi.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </section>
        </aside>
    </div>
</x-member-layout>
