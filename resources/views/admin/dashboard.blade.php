<x-admin-layout title="Dashboard Admin" active="dashboard">
    <div class="mb-8 flex flex-col gap-1">
        <h2 class="text-3xl font-bold leading-tight text-[#191c1d]">Selamat datang, {{ Str::before($admin->name, ' ') }}</h2>
        <p class="text-base text-[#3d4947]">Ringkasan aktivitas perpustakaan hari ini.</p>
    </div>

    <section class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <article class="flex items-center gap-4 rounded-lg border border-[#e1e3e4] bg-white p-6 shadow-sm transition hover:shadow-md">
            <div class="flex size-16 shrink-0 items-center justify-center rounded-full bg-teal-100 text-teal-700">
                <span class="material-symbols-outlined text-[32px]" style="font-variation-settings: 'FILL' 1">book</span>
            </div>
            <div>
                <p class="text-sm text-[#3d4947]">Total Buku</p>
                <p class="text-2xl font-bold text-[#191c1d]">{{ number_format($totalBuku, 0, ',', '.') }}</p>
            </div>
        </article>

        <article class="flex items-center gap-4 rounded-lg border border-[#e1e3e4] bg-white p-6 shadow-sm transition hover:shadow-md">
            <div class="flex size-16 shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-700">
                <span class="material-symbols-outlined text-[32px]" style="font-variation-settings: 'FILL' 1">people</span>
            </div>
            <div>
                <p class="text-sm text-[#3d4947]">Total Anggota</p>
                <p class="text-2xl font-bold text-[#191c1d]">{{ number_format($totalAnggota, 0, ',', '.') }}</p>
            </div>
        </article>

        <article class="flex items-center gap-4 rounded-lg border border-[#e1e3e4] bg-white p-6 shadow-sm transition hover:shadow-md">
            <div class="flex size-16 shrink-0 items-center justify-center rounded-full bg-orange-100 text-orange-700">
                <span class="material-symbols-outlined text-[32px]" style="font-variation-settings: 'FILL' 1">local_library</span>
            </div>
            <div>
                <p class="text-sm text-[#3d4947]">Peminjaman Aktif</p>
                <p class="text-2xl font-bold text-[#191c1d]">{{ number_format($totalPeminjamanAktif, 0, ',', '.') }}</p>
            </div>
        </article>

        <article class="flex items-center gap-4 rounded-lg border border-[#e1e3e4] bg-white p-6 shadow-sm transition hover:shadow-md">
            <div class="flex size-16 shrink-0 items-center justify-center rounded-full bg-rose-100 text-rose-700">
                <span class="material-symbols-outlined text-[32px]" style="font-variation-settings: 'FILL' 1">warning</span>
            </div>
            <div>
                <p class="text-sm text-[#3d4947]">Buku Terlambat</p>
                <p class="text-2xl font-bold text-[#191c1d]">{{ number_format($totalTerlambat, 0, ',', '.') }}</p>
            </div>
        </article>
    </section>

    <section class="overflow-hidden rounded-lg border border-[#e1e3e4] bg-white shadow-sm">
        <div class="flex items-center justify-between gap-4 border-b border-[#e1e3e4] p-6">
            <h3 class="text-xl font-semibold text-[#191c1d]">Peminjaman Terbaru</h3>
            <a href=" {{ route('admin.borrowings.index') }}" class="text-sm font-semibold text-[#00685f] hover:underline">Lihat Semua</a>
        </div>

        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead class="bg-[#f3f4f5] text-xs uppercase text-[#3d4947]">
                    <tr>
                        <th class="px-6 py-4">Anggota</th>
                        <th class="px-6 py-4">Judul Buku</th>
                        <th class="px-6 py-4">Tanggal Pinjam</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjamanTerbaru as $peminjaman)
                        @php($status = $statuses[$peminjaman->status] ?? ['label' => Str::title($peminjaman->status), 'class' => 'bg-slate-100 text-slate-700'])
                        <tr class="border-b border-[#e1e3e4] transition hover:bg-[#008378]/5">
                            <td class="px-6 py-4 font-medium text-[#191c1d]">{{ $peminjaman->member->name }}</td>
                            <td class="px-6 py-4 text-[#3d4947]">{{ $peminjaman->book->title }}</td>
                            <td class="px-6 py-4 text-[#3d4947]">{{ $peminjaman->borrow_date->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="badge border-none px-3 py-1 text-xs font-semibold {{ $status['class'] }}">
                                    {{ $status['label'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-[#3d4947]">Belum ada peminjaman terbaru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-admin-layout>
