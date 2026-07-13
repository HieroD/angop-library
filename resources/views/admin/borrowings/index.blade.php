<x-admin-layout title="Kelola Peminjaman" active="borrowings">
    @php
        $statusBadges = [
            'menunggu konfirmasi' => ['label' => 'Menunggu Konfirmasi', 'class' => 'bg-[#00685f]/10 text-[#00685f]'],
            'dipinjam' => ['label' => 'Dipinjam', 'class' => 'bg-emerald-100 text-emerald-700'],
            'ditolak' => ['label' => 'Ditolak', 'class' => 'bg-rose-100 text-rose-700'],
        ];
    @endphp

    <div x-data="{}">
        <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <h2 class="text-3xl font-bold leading-tight text-[#191c1d]">Manajemen Konfirmasi Peminjaman</h2>
                <p class="mt-2 text-[#3d4947]">Tinjau dan kelola permohonan peminjaman buku dari anggota.</p>
            </div>
        </div>

        <section class="mb-10">
            <h3 class="mb-4 text-xl font-bold text-[#191c1d]">Daftar Pengajuan Peminjaman</h3>
            <div class="overflow-hidden rounded-lg border border-[#e1e3e4] bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead class="border-b border-[#e1e3e4] bg-[#f3f4f5] text-sm text-[#3d4947]">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Anggota</th>
                                <th class="px-6 py-4 font-semibold">Buku</th>
                                <th class="px-6 py-4 font-semibold">Tanggal Pengajuan</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                <th class="px-6 py-4 text-right font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#e1e3e4] text-[#3d4947]">
                            @forelse ($pendingBorrowings as $borrowing)
                                <tr class="transition hover:bg-[#00685f]/5">
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-[#191c1d]">{{ $borrowing->member?->name ?? '-' }}</div>
                                        <div class="mt-1 text-xs text-[#3d4947]">{{ $borrowing->member?->member_code ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-[#191c1d]">{{ $borrowing->book?->title ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">{{ $borrowing->created_at?->translatedFormat('d M Y') ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        @php($badge = $statusBadges[$borrowing->status] ?? ['label' => $borrowing->status, 'class' => 'bg-gray-100 text-gray-700'])
                                        <span class="inline-flex items-center rounded px-2 py-1 text-[10px] font-semibold uppercase tracking-wide {{ $badge['class'] }}">
                                            {{ $badge['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-end gap-2">
                                            <button class="rounded-md bg-[#00685f] px-4 py-1.5 text-sm font-medium text-white transition hover:bg-[#008378]" x-on:click="$refs.approve{{ $borrowing->id }}.showModal()">Setujui</button>
                                            <button class="rounded-md border border-rose-600 px-4 py-1.5 text-sm font-medium text-rose-600 transition hover:bg-rose-50" x-on:click="$refs.reject{{ $borrowing->id }}.showModal()">Tolak</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-[#3d4947]">Tidak ada pengajuan peminjaman yang menunggu konfirmasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($pendingBorrowings->hasPages())
                    <div class="flex items-center justify-between border-t border-[#e1e3e4] bg-[#f3f4f5] px-6 py-4">
                        <span class="text-sm text-[#3d4947]">
                            Menampilkan {{ $pendingBorrowings->firstItem() }}-{{ $pendingBorrowings->lastItem() }} dari {{ $pendingBorrowings->total() }} permohonan
                        </span>
                        <div class="flex gap-1">
                            @if ($pendingBorrowings->onFirstPage())
                                <span class="flex size-8 items-center justify-center rounded border border-[#bcc9c6] text-[#bcc9c6]"><span class="material-symbols-outlined" style="font-size: 18px;">chevron_left</span></span>
                            @else
                                <a href="{{ $pendingBorrowings->previousPageUrl() }}" class="flex size-8 items-center justify-center rounded border border-[#bcc9c6] text-[#3d4947] transition hover:bg-[#e1e3e4]"><span class="material-symbols-outlined" style="font-size: 18px;">chevron_left</span></a>
                            @endif

                            @if ($pendingBorrowings->hasMorePages())
                                <a href="{{ $pendingBorrowings->nextPageUrl() }}" class="flex size-8 items-center justify-center rounded border border-[#bcc9c6] text-[#3d4947] transition hover:bg-[#e1e3e4]"><span class="material-symbols-outlined" style="font-size: 18px;">chevron_right</span></a>
                            @else
                                <span class="flex size-8 items-center justify-center rounded border border-[#bcc9c6] text-[#bcc9c6]"><span class="material-symbols-outlined" style="font-size: 18px;">chevron_right</span></span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <section>
            <h3 class="mb-4 text-xl font-bold text-[#191c1d]">Riwayat Peminjaman</h3>
            <div class="overflow-hidden rounded-lg border border-[#e1e3e4] bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead class="border-b border-[#e1e3e4] bg-[#f3f4f5] text-sm text-[#3d4947]">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Anggota</th>
                                <th class="px-6 py-4 font-semibold">Buku</th>
                                <th class="px-6 py-4 font-semibold">Tanggal Selesai</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                <th class="px-6 py-4 font-semibold">Petugas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#e1e3e4] text-[#3d4947]">
                            @forelse ($historyBorrowings as $borrowing)
                                <tr class="transition hover:bg-[#00685f]/5">
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-[#191c1d]">{{ $borrowing->member?->name ?? '-' }}</div>
                                        <div class="mt-1 text-xs text-[#3d4947]">{{ $borrowing->member?->member_code ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-[#191c1d]">{{ $borrowing->book?->title ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">{{ $borrowing->updated_at?->translatedFormat('d M Y') ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        @php($badge = $statusBadges[$borrowing->status] ?? ['label' => $borrowing->status, 'class' => 'bg-gray-100 text-gray-700'])
                                        <span class="inline-flex items-center rounded px-2 py-1 text-[10px] font-semibold uppercase tracking-wide {{ $badge['class'] }}">
                                            {{ $badge['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm">{{ $borrowing->staff?->name ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-[#3d4947]">Belum ada riwayat peminjaman.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($historyBorrowings->hasPages())
                    <div class="flex items-center justify-between border-t border-[#e1e3e4] bg-[#f3f4f5] px-6 py-4">
                        <span class="text-sm text-[#3d4947]">
                            Menampilkan {{ $historyBorrowings->firstItem() }}-{{ $historyBorrowings->lastItem() }} dari {{ $historyBorrowings->total() }} riwayat
                        </span>
                        <div class="flex gap-1">
                            @if ($historyBorrowings->onFirstPage())
                                <span class="flex size-8 items-center justify-center rounded border border-[#bcc9c6] text-[#bcc9c6]"><span class="material-symbols-outlined" style="font-size: 18px;">chevron_left</span></span>
                            @else
                                <a href="{{ $historyBorrowings->previousPageUrl() }}" class="flex size-8 items-center justify-center rounded border border-[#bcc9c6] text-[#3d4947] transition hover:bg-[#e1e3e4]"><span class="material-symbols-outlined" style="font-size: 18px;">chevron_left</span></a>
                            @endif

                            @if ($historyBorrowings->hasMorePages())
                                <a href="{{ $historyBorrowings->nextPageUrl() }}" class="flex size-8 items-center justify-center rounded border border-[#bcc9c6] text-[#3d4947] transition hover:bg-[#e1e3e4]"><span class="material-symbols-outlined" style="font-size: 18px;">chevron_right</span></a>
                            @else
                                <span class="flex size-8 items-center justify-center rounded border border-[#bcc9c6] text-[#bcc9c6]"><span class="material-symbols-outlined" style="font-size: 18px;">chevron_right</span></span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </section>

        @foreach ($pendingBorrowings as $borrowing)
            <dialog x-ref="approve{{ $borrowing->id }}" class="modal modal-middle">
                <div class="modal-box max-w-md p-0">
                    <form method="dialog">
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 z-10 text-[#3d4947] hover:text-rose-600">x</button>
                    </form>
                    <form method="POST" action="{{ route('admin.borrowings.approve', $borrowing) }}">
                        @csrf
                        @method('PATCH')
                        <div class="border-b border-[#e1e3e4] bg-[#f3f4f5] px-6 py-4">
                            <h3 class="text-xl font-semibold text-[#191c1d]">Konfirmasi Persetujuan</h3>
                        </div>
                        <div class="space-y-3 p-6 text-sm text-[#3d4947]">
                            <p><span class="font-semibold text-[#191c1d]">Anggota:</span> {{ $borrowing->member?->name }} ({{ $borrowing->member?->member_code }})</p>
                            <p><span class="font-semibold text-[#191c1d]">Buku:</span> {{ $borrowing->book?->title }}</p>
                            <p><span class="font-semibold text-[#191c1d]">Tanggal Pinjam:</span> {{ now()->translatedFormat('d M Y') }}</p>
                            <p><span class="font-semibold text-[#191c1d]">Tanggal Jatuh Tempo:</span> {{ now()->addDays(7)->translatedFormat('d M Y') }}</p>
                        </div>
                        <div class="flex justify-end gap-3 border-t border-[#e1e3e4] bg-[#f3f4f5] px-6 py-4">
                            <button type="button" class="rounded-lg bg-[#e1e3e4] px-6 py-2 text-sm font-semibold text-[#3d4947] transition hover:bg-[#bcc9c6]" x-on:click="$refs.approve{{ $borrowing->id }}.close()">Batal</button>
                            <button type="submit" class="rounded-lg bg-[#00685f] px-6 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#008378]">Setujui Peminjaman</button>
                        </div>
                    </form>
                </div>
                <form method="dialog" class="modal-backdrop"><button>close</button></form>
            </dialog>

            <dialog x-ref="reject{{ $borrowing->id }}" class="modal modal-middle">
                <div class="modal-box max-w-md p-0">
                    <form method="dialog">
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 z-10 text-[#3d4947] hover:text-rose-600">x</button>
                    </form>
                    <form method="POST" action="{{ route('admin.borrowings.reject', $borrowing) }}">
                        @csrf
                        @method('PATCH')
                        <div class="border-b border-[#e1e3e4] bg-[#f3f4f5] px-6 py-4">
                            <h3 class="text-xl font-semibold text-[#191c1d]">Konfirmasi Penolakan</h3>
                        </div>
                        <div class="space-y-3 p-6 text-sm text-[#3d4947]">
                            <p><span class="font-semibold text-[#191c1d]">Anggota:</span> {{ $borrowing->member?->name }} ({{ $borrowing->member?->member_code }})</p>
                            <p><span class="font-semibold text-[#191c1d]">Buku:</span> {{ $borrowing->book?->title }}</p>
                            <p class="rounded-lg bg-rose-50 p-3 font-medium text-rose-700">Permohonan ini akan ditolak dan masuk ke riwayat peminjaman.</p>
                        </div>
                        <div class="flex justify-end gap-3 border-t border-[#e1e3e4] bg-[#f3f4f5] px-6 py-4">
                            <button type="button" class="rounded-lg bg-[#e1e3e4] px-6 py-2 text-sm font-semibold text-[#3d4947] transition hover:bg-[#bcc9c6]" x-on:click="$refs.reject{{ $borrowing->id }}.close()">Batal</button>
                            <button type="submit" class="rounded-lg bg-rose-600 px-6 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-rose-700">Tolak Permohonan</button>
                        </div>
                    </form>
                </div>
                <form method="dialog" class="modal-backdrop"><button>close</button></form>
            </dialog>
        @endforeach
    </div>
</x-admin-layout>
