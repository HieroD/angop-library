<x-member-layout title="Katalog Buku" active="catalog">
    <div class="mb-6 flex flex-col gap-1">
        <h2 class="text-2xl font-bold text-[#191c1d] sm:text-3xl">Katalog Buku</h2>
        <p class="text-base text-[#3d4947]">Telusuri koleksi buku yang tersedia di perpustakaan.</p>
    </div>

    <form method="GET" class="mb-8 rounded-xl border border-[#e1e3e4] bg-white p-4 shadow-sm sm:p-5">
        <div class="flex flex-col gap-4 md:flex-row">
            <div class="relative flex-1">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#6d7a77]" style="font-size: 20px;">search</span>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari judul atau penulis..."
                    class="w-full rounded-lg border border-[#e1e3e4] bg-white px-4 py-2.5 pl-10 text-sm text-[#191c1d] placeholder-[#6d7a77] transition focus:border-[#00685f] focus:outline-none focus:ring-2 focus:ring-[#00685f]/20"
                >
            </div>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <select name="category_id" class="w-full cursor-pointer rounded-lg border border-[#e1e3e4] bg-white px-4 py-2.5 pr-8 text-sm text-[#191c1d] transition focus:border-[#00685f] focus:outline-none focus:ring-2 focus:ring-[#00685f]/20 sm:w-auto">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <select name="sort" class="w-full cursor-pointer rounded-lg border border-[#e1e3e4] bg-white px-4 py-2.5 pr-8 text-sm text-[#191c1d] transition focus:border-[#00685f] focus:outline-none focus:ring-2 focus:ring-[#00685f]/20 sm:w-auto">
                    <option value="terbaru" @selected(request('sort') === 'terbaru')>Terbaru</option>
                    <option value="judul-az" @selected(request('sort') === 'judul-az')>Judul A-Z</option>
                    <option value="stok-tersedia" @selected(request('sort') === 'stok-tersedia')>Stok Tersedia</option>
                </select>
                <button type="submit" class="flex items-center justify-center gap-2 rounded-lg bg-[#00685f] px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-[#005049]">
                    <span class="material-symbols-outlined" style="font-size: 18px;">search</span>
                    Cari
                </button>
            </div>
        </div>
    </form>

    @if ($books->isEmpty())
        <div class="flex flex-col items-center justify-center rounded-xl border border-[#e1e3e4] bg-white px-6 py-16 shadow-sm">
            <span class="material-symbols-outlined mb-3 text-[#6d7a77]" style="font-size: 48px;">search</span>
            <p class="text-lg font-semibold text-[#191c1d]">Tidak ada buku ditemukan</p>
            <p class="mt-1 text-sm text-[#3d4947]">Coba ubah kata kunci atau filter pencarian Anda.</p>
        </div>
    @else
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($books as $book)
                <div class="group flex flex-col overflow-hidden rounded-xl border border-[#e1e3e4] bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="relative aspect-[3/4] w-full overflow-hidden bg-gradient-to-br from-[#008378] to-[#00685f]">
                        @if ($book->book_cover)
                            <img src="{{ Storage::url($book->book_cover) }}" alt="{{ $book->title }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                        @else
                            <div class="flex h-full items-center justify-center">
                                <span class="select-none text-5xl font-bold tracking-tight text-[#f4fffc]/30">{{ strtoupper(substr($book->title, 0, 1)) }}</span>
                            </div>
                        @endif
                        @if ($book->category)
                            <span class="absolute left-2 top-2 rounded bg-white/90 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-[#00685f] shadow-sm">
                                {{ $book->category->name }}
                            </span>
                        @endif
                    </div>

                    <div class="flex flex-1 flex-col gap-2 p-4">
                        <h3 class="line-clamp-2 text-sm font-bold leading-snug text-[#191c1d] transition-colors group-hover:text-[#00685f]">
                            {{ $book->title }}
                        </h3>
                        <p class="truncate text-xs text-[#3d4947]">{{ $book->authors->pluck('name')->join(', ') }}</p>

                        <div class="mt-auto flex flex-col gap-3 pt-2">
                            <div class="flex items-center gap-1 text-sm font-semibold">
                                @if ($book->total_copies > 0)
                                    <span class="material-symbols-outlined text-[#008378]" style="font-size: 16px;">check_circle</span>
                                    <span class="text-[#00685f]">Tersedia: {{ $book->total_copies }}</span>
                                @else
                                    <span class="material-symbols-outlined text-[#ba1a1a]" style="font-size: 16px;">cancel</span>
                                    <span class="text-[#ba1a1a]">Habis</span>
                                @endif
                            </div>
                            <a href="{{ route('member.catalog.show', $book) }}" class="block w-full rounded-lg bg-[#00685f] px-4 py-2 text-center text-sm font-semibold text-white transition hover:bg-[#005049]">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $books->links() }}
        </div>
    @endif
</x-member-layout>
