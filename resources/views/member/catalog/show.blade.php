<x-member-layout title="Detail Buku" active="catalog">
    <div class="mb-6">
        <a href="{{ route('member.catalog.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-[#3d4947] transition-colors hover:text-[#00685f]">
            <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span>
            Kembali ke Katalog
        </a>
    </div>

    <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
        <div class="flex flex-col gap-4 md:col-span-4 lg:col-span-3">
            <div class="aspect-[2/3] w-full overflow-hidden rounded-xl border border-[#e1e3e4] bg-gradient-to-br from-[#008378] to-[#00685f] shadow-sm">
                @if ($book->book_cover)
                    <img src="{{ Storage::url($book->book_cover) }}" alt="{{ $book->title }}" class="h-full w-full object-cover transition-transform duration-300 hover:scale-105">
                @else
                    <div class="flex h-full items-center justify-center">
                        <span class="select-none text-6xl font-bold tracking-tight text-[#f4fffc]/30">{{ strtoupper(substr($book->title, 0, 1)) }}</span>
                    </div>
                @endif
            </div>

            @if ($book->total_copies > 0)
                <div class="flex items-center justify-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2.5">
                    <span class="material-symbols-outlined text-[#008378]" style="font-size: 18px; font-variation-settings: 'FILL' 1;">check_circle</span>
                    <span class="text-sm font-semibold text-[#00685f]">Tersedia ({{ $book->total_copies }} Salinan)</span>
                </div>
            @else
                <div class="flex items-center justify-center gap-2 rounded-full border border-rose-200 bg-rose-50 px-4 py-2.5">
                    <span class="material-symbols-outlined text-[#ba1a1a]" style="font-size: 18px; font-variation-settings: 'FILL' 1;">cancel</span>
                    <span class="text-sm font-semibold text-[#ba1a1a]">Stok Habis</span>
                </div>
            @endif
        </div>

        <div class="flex flex-col gap-6 md:col-span-8 lg:col-span-9">
            <div>
                <h1 class="text-3xl font-bold text-[#191c1d]">{{ $book->title }}</h1>
                <p class="mt-1 text-xl text-[#3d4947]">{{ $book->authors->pluck('name')->join(', ') }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                <div class="rounded-lg border border-[#e1e3e4] bg-white p-4 shadow-sm transition hover:-translate-y-0.5">
                    <span class="block text-xs font-semibold uppercase tracking-wider text-[#3d4947]">Penerbit</span>
                    <span class="mt-1 block text-sm font-medium text-[#191c1d]">{{ $book->publisher ?? '-' }}</span>
                </div>
                <div class="rounded-lg border border-[#e1e3e4] bg-white p-4 shadow-sm transition hover:-translate-y-0.5">
                    <span class="block text-xs font-semibold uppercase tracking-wider text-[#3d4947]">Tahun Terbit</span>
                    <span class="mt-1 block text-sm font-medium text-[#191c1d]">{{ $book->published_year ?? '-' }}</span>
                </div>
                <div class="rounded-lg border border-[#e1e3e4] bg-white p-4 shadow-sm transition hover:-translate-y-0.5">
                    <span class="block text-xs font-semibold uppercase tracking-wider text-[#3d4947]">ISBN</span>
                    <span class="mt-1 block text-sm font-medium text-[#191c1d]">{{ $book->isbn ?? '-' }}</span>
                </div>
                <div class="rounded-lg border border-[#e1e3e4] bg-white p-4 shadow-sm transition hover:-translate-y-0.5">
                    <span class="block text-xs font-semibold uppercase tracking-wider text-[#3d4947]">Kategori</span>
                    @if ($book->category)
                        <span class="mt-2 inline-flex rounded-full bg-[#d5e3fc] px-2.5 py-1 text-xs font-semibold text-[#57657a]">{{ $book->category->name }}</span>
                    @else
                        <span class="mt-1 block text-sm font-medium text-[#191c1d]">-</span>
                    @endif
                </div>
            </div>

            <div x-data="{ open: false }">
                @if ($book->total_copies > 0)
                    <button @click="open = true" class="flex w-full items-center justify-center gap-2 rounded-lg bg-[#00685f] px-8 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#005049] active:scale-95 md:w-auto">
                        <span class="material-symbols-outlined" style="font-size: 20px;">book</span>
                        Pinjam Buku Ini
                    </button>

                    <div x-show="open" x-cloak class="fixed inset-0 z-50">
                        <div class="fixed inset-0 bg-black/50" @click="open = false"></div>
                        <div class="fixed inset-0 flex items-center justify-center p-4">
                            <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-xl">
                                <h3 class="text-lg font-bold text-[#191c1d]">Konfirmasi Peminjaman</h3>
                                <p class="mt-2 text-sm leading-relaxed text-[#3d4947]">
                                    Apakah Anda yakin ingin meminjam buku <strong>{{ $book->title }}</strong>?
                                </p>
                                <form method="POST" action="{{ route('member.catalog.borrow', $book) }}">
                                    @csrf
                                    <div class="mt-6 flex justify-end gap-3">
                                        <button type="button" @click="open = false" class="rounded-lg border border-[#e1e3e4] px-4 py-2 text-sm font-semibold text-[#3d4947] transition hover:bg-[#f3f4f5]">
                                            Batal
                                        </button>
                                        <button type="submit" class="rounded-lg bg-[#00685f] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#005049]">
                                            Ya, Pinjam
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <button class="flex w-full cursor-not-allowed items-center justify-center gap-2 rounded-lg bg-[#e1e3e4] px-8 py-3 text-sm font-semibold text-[#6d7a77] shadow-sm md:w-auto" disabled>
                        <span class="material-symbols-outlined" style="font-size: 20px;">block</span>
                        Stok Habis
                    </button>
                @endif
            </div>

            <hr class="border-[#e1e3e4]">

            <div>
                <h3 class="text-xl font-bold text-[#191c1d]">Sinopsis</h3>
                @if ($book->description)
                    <div class="mt-3 space-y-4 text-base leading-relaxed text-[#3d4947]">
                        {{ $book->description }}
                    </div>
                @else
                    <p class="mt-3 text-base text-[#6d7a77]">Tidak ada sinopsis untuk buku ini.</p>
                @endif
            </div>
        </div>
    </div>
</x-member-layout>
