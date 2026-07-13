<x-admin-layout title="Kelola Pengembalian" active="returns">
    @php
        $borrowingBadges = [
            'dipinjam' => ['label' => 'Dipinjam', 'class' => 'bg-blue-100 text-blue-700'],
            'terlambat' => ['label' => 'Terlambat', 'class' => 'bg-rose-100 text-rose-700'],
        ];

        $paymentBadges = [
            'paid' => ['label' => 'Lunas', 'class' => 'bg-emerald-100 text-emerald-700'],
            'unpaid' => ['label' => 'Belum Dibayar', 'class' => 'bg-orange-100 text-orange-700'],
        ];
    @endphp

    <div x-data="{}">
        <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <h2 class="text-3xl font-bold leading-tight text-[#191c1d]">Manajemen Pengembalian</h2>
                <p class="mt-2 text-[#3d4947]">Proses pengembalian buku, hitung denda keterlambatan, dan pantau riwayat pengembalian.</p>
            </div>
        </div>

        <section class="mb-10">
            <h3 class="mb-4 text-xl font-bold text-[#191c1d]">Daftar Buku Dipinjam</h3>
            <div class="overflow-hidden rounded-lg border border-[#e1e3e4] bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead class="border-b border-[#e1e3e4] bg-[#f3f4f5] text-sm text-[#3d4947]">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Anggota</th>
                                <th class="px-6 py-4 font-semibold">Buku</th>
                                <th class="px-6 py-4 font-semibold">Tanggal Pinjam</th>
                                <th class="px-6 py-4 font-semibold">Jatuh Tempo</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                <th class="px-6 py-4 font-semibold">Denda</th>
                                <th class="px-6 py-4 text-right font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#e1e3e4] text-[#3d4947]">
                            @forelse ($activeBorrowings as $borrowing)
                                @php
                                    $overdueDays = max(0, now()->startOfDay()->diffInDays($borrowing->due_date, false) * -1);
                                    $fineAmount = $overdueDays * 1000;
                                    $badge = $borrowingBadges[$borrowing->status] ?? ['label' => $borrowing->status, 'class' => 'bg-gray-100 text-gray-700'];
                                @endphp
                                <tr class="transition hover:bg-[#00685f]/5">
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-[#191c1d]">{{ $borrowing->member?->name ?? '-' }}</div>
                                        <div class="mt-1 text-xs text-[#3d4947]">{{ $borrowing->member?->member_code ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-[#191c1d]">{{ $borrowing->book?->title ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">{{ $borrowing->borrow_date?->translatedFormat('d M Y') ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm">{{ $borrowing->due_date?->translatedFormat('d M Y') ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center rounded px-2 py-1 text-[10px] font-semibold uppercase tracking-wide {{ $badge['class'] }}">
                                            {{ $badge['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-semibold {{ $fineAmount > 0 ? 'text-rose-600' : 'text-[#3d4947]' }}">
                                        Rp {{ number_format($fineAmount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-end">
                                            <button class="rounded-md bg-[#00685f] px-4 py-1.5 text-sm font-medium text-white transition hover:bg-[#008378]" x-on:click="$refs.return{{ $borrowing->id }}.showModal()">Kembalikan</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center text-[#3d4947]">Tidak ada buku yang sedang dipinjam.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($activeBorrowings->hasPages())
                    <div class="flex items-center justify-between border-t border-[#e1e3e4] bg-[#f3f4f5] px-6 py-4">
                        <span class="text-sm text-[#3d4947]">
                            Menampilkan {{ $activeBorrowings->firstItem() }}-{{ $activeBorrowings->lastItem() }} dari {{ $activeBorrowings->total() }} peminjaman
                        </span>
                        <div class="flex gap-1">
                            @if ($activeBorrowings->onFirstPage())
                                <span class="flex size-8 items-center justify-center rounded border border-[#bcc9c6] text-[#bcc9c6]"><span class="material-symbols-outlined" style="font-size: 18px;">chevron_left</span></span>
                            @else
                                <a href="{{ $activeBorrowings->previousPageUrl() }}" class="flex size-8 items-center justify-center rounded border border-[#bcc9c6] text-[#3d4947] transition hover:bg-[#e1e3e4]"><span class="material-symbols-outlined" style="font-size: 18px;">chevron_left</span></a>
                            @endif

                            @if ($activeBorrowings->hasMorePages())
                                <a href="{{ $activeBorrowings->nextPageUrl() }}" class="flex size-8 items-center justify-center rounded border border-[#bcc9c6] text-[#3d4947] transition hover:bg-[#e1e3e4]"><span class="material-symbols-outlined" style="font-size: 18px;">chevron_right</span></a>
                            @else
                                <span class="flex size-8 items-center justify-center rounded border border-[#bcc9c6] text-[#bcc9c6]"><span class="material-symbols-outlined" style="font-size: 18px;">chevron_right</span></span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <section>
            <h3 class="mb-4 text-xl font-bold text-[#191c1d]">Riwayat Pengembalian</h3>
            <div class="overflow-hidden rounded-lg border border-[#e1e3e4] bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead class="border-b border-[#e1e3e4] bg-[#f3f4f5] text-sm text-[#3d4947]">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Anggota</th>
                                <th class="px-6 py-4 font-semibold">Buku</th>
                                <th class="px-6 py-4 font-semibold">Tanggal Kembali</th>
                                <th class="px-6 py-4 font-semibold">Denda</th>
                                <th class="px-6 py-4 font-semibold">Status Pembayaran</th>
                                <th class="px-6 py-4 font-semibold">Petugas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#e1e3e4] text-[#3d4947]">
                            @forelse ($returnHistory as $returnRecord)
                                @php
                                    $paymentBadge = $paymentBadges[$returnRecord->payment_status] ?? ['label' => $returnRecord->payment_status, 'class' => 'bg-gray-100 text-gray-700'];
                                @endphp
                                <tr class="transition hover:bg-[#00685f]/5">
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-[#191c1d]">{{ $returnRecord->borrowing?->member?->name ?? '-' }}</div>
                                        <div class="mt-1 text-xs text-[#3d4947]">{{ $returnRecord->borrowing?->member?->member_code ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-[#191c1d]">{{ $returnRecord->borrowing?->book?->title ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">{{ $returnRecord->return_date?->translatedFormat('d M Y') ?? '-' }}</td>
                                    @php
                                        $remainingFine = max(0, (float) $returnRecord->fine_amount - (float) $returnRecord->paid_amount);
                                    @endphp
                                    <td class="px-6 py-4 text-sm">
                                        <div class="font-semibold {{ $returnRecord->fine_amount > 0 ? 'text-rose-600' : 'text-[#3d4947]' }}">Rp {{ number_format((float) $returnRecord->fine_amount, 0, ',', '.') }}</div>
                                        @if ((float) $returnRecord->paid_amount > 0)
                                            <div class="mt-1 text-xs text-emerald-700">Dibayar: Rp {{ number_format((float) $returnRecord->paid_amount, 0, ',', '.') }}</div>
                                        @endif
                                        @if ($remainingFine > 0)
                                            <div class="mt-1 text-xs text-[#3d4947]">Sisa: Rp {{ number_format($remainingFine, 0, ',', '.') }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center rounded px-2 py-1 text-[10px] font-semibold uppercase tracking-wide {{ $paymentBadge['class'] }}">
                                                {{ $paymentBadge['label'] }}
                                            </span>
                                            @if ($remainingFine > 0)
                                                <button class="flex size-7 items-center justify-center rounded-full text-[#00685f] transition hover:bg-[#00685f]/10" title="Update pembayaran" x-on:click="$refs.payment{{ $returnRecord->id }}.showModal()">
                                                    <span class="material-symbols-outlined" style="font-size: 16px;">edit</span>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">{{ $returnRecord->staff?->name ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-[#3d4947]">Belum ada riwayat pengembalian.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($returnHistory->hasPages())
                    <div class="flex items-center justify-between border-t border-[#e1e3e4] bg-[#f3f4f5] px-6 py-4">
                        <span class="text-sm text-[#3d4947]">
                            Menampilkan {{ $returnHistory->firstItem() }}-{{ $returnHistory->lastItem() }} dari {{ $returnHistory->total() }} riwayat
                        </span>
                        <div class="flex gap-1">
                            @if ($returnHistory->onFirstPage())
                                <span class="flex size-8 items-center justify-center rounded border border-[#bcc9c6] text-[#bcc9c6]"><span class="material-symbols-outlined" style="font-size: 18px;">chevron_left</span></span>
                            @else
                                <a href="{{ $returnHistory->previousPageUrl() }}" class="flex size-8 items-center justify-center rounded border border-[#bcc9c6] text-[#3d4947] transition hover:bg-[#e1e3e4]"><span class="material-symbols-outlined" style="font-size: 18px;">chevron_left</span></a>
                            @endif

                            @if ($returnHistory->hasMorePages())
                                <a href="{{ $returnHistory->nextPageUrl() }}" class="flex size-8 items-center justify-center rounded border border-[#bcc9c6] text-[#3d4947] transition hover:bg-[#e1e3e4]"><span class="material-symbols-outlined" style="font-size: 18px;">chevron_right</span></a>
                            @else
                                <span class="flex size-8 items-center justify-center rounded border border-[#bcc9c6] text-[#bcc9c6]"><span class="material-symbols-outlined" style="font-size: 18px;">chevron_right</span></span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </section>

        @foreach ($activeBorrowings as $borrowing)
            @php
                $overdueDays = max(0, now()->startOfDay()->diffInDays($borrowing->due_date, false) * -1);
                $fineAmount = $overdueDays * 1000;
            @endphp
            <dialog x-ref="return{{ $borrowing->id }}" class="modal modal-middle">
                <div class="modal-box max-w-md p-0">
                    <form method="dialog">
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 z-10 text-[#3d4947] hover:text-rose-600">x</button>
                    </form>
                    <form method="POST" action="{{ route('admin.returns.store', $borrowing) }}">
                        @csrf
                        <div class="border-b border-[#e1e3e4] bg-[#f3f4f5] px-6 py-4">
                            <h3 class="text-xl font-semibold text-[#191c1d]">Konfirmasi Pengembalian</h3>
                        </div>
                        <div class="space-y-3 p-6 text-sm text-[#3d4947]">
                            <p><span class="font-semibold text-[#191c1d]">Anggota:</span> {{ $borrowing->member?->name }} ({{ $borrowing->member?->member_code }})</p>
                            <p><span class="font-semibold text-[#191c1d]">Buku:</span> {{ $borrowing->book?->title }}</p>
                            <p><span class="font-semibold text-[#191c1d]">Tanggal Pinjam:</span> {{ $borrowing->borrow_date?->translatedFormat('d M Y') }}</p>
                            <p><span class="font-semibold text-[#191c1d]">Tanggal Jatuh Tempo:</span> {{ $borrowing->due_date?->translatedFormat('d M Y') }}</p>
                            <p><span class="font-semibold text-[#191c1d]">Keterlambatan:</span> {{ $overdueDays > 0 ? $overdueDays.' hari' : 'Tidak terlambat' }}</p>
                            <p class="rounded-lg {{ $fineAmount > 0 ? 'bg-rose-50 text-rose-700' : 'bg-emerald-50 text-emerald-700' }} p-3 font-semibold">
                                Denda: Rp {{ number_format($fineAmount, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="flex justify-end gap-3 border-t border-[#e1e3e4] bg-[#f3f4f5] px-6 py-4">
                            <button type="button" class="rounded-lg bg-[#e1e3e4] px-6 py-2 text-sm font-semibold text-[#3d4947] transition hover:bg-[#bcc9c6]" x-on:click="$refs.return{{ $borrowing->id }}.close()">Batal</button>
                            <button type="submit" class="rounded-lg bg-[#00685f] px-6 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#008378]">Konfirmasi Pengembalian</button>
                        </div>
                    </form>
                </div>
                <form method="dialog" class="modal-backdrop"><button>close</button></form>
            </dialog>
        @endforeach

        @foreach ($returnHistory as $returnRecord)
            @php
                $remainingFine = max(0, (float) $returnRecord->fine_amount - (float) $returnRecord->paid_amount);
            @endphp
            @if ($remainingFine > 0)
                <dialog x-ref="payment{{ $returnRecord->id }}" class="modal modal-middle">
                    <div class="modal-box max-w-md p-0">
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 z-10 text-[#3d4947] hover:text-rose-600">x</button>
                        </form>
                        <form method="POST" action="{{ route('admin.returns.payment.update', $returnRecord) }}">
                            @csrf
                            @method('PATCH')
                            <div class="border-b border-[#e1e3e4] bg-[#f3f4f5] px-6 py-4">
                                <h3 class="text-xl font-semibold text-[#191c1d]">Update Pembayaran Denda</h3>
                            </div>
                            <div class="space-y-4 p-6 text-sm text-[#3d4947]">
                                <p><span class="font-semibold text-[#191c1d]">Anggota:</span> {{ $returnRecord->borrowing?->member?->name }} ({{ $returnRecord->borrowing?->member?->member_code }})</p>
                                <p><span class="font-semibold text-[#191c1d]">Buku:</span> {{ $returnRecord->borrowing?->book?->title }}</p>
                                <div class="grid grid-cols-1 gap-2 rounded-lg bg-[#f3f4f5] p-4">
                                    <p>Total denda: <span class="font-semibold text-rose-600">Rp {{ number_format((float) $returnRecord->fine_amount, 0, ',', '.') }}</span></p>
                                    <p>Sudah dibayar: <span class="font-semibold text-emerald-700">Rp {{ number_format((float) $returnRecord->paid_amount, 0, ',', '.') }}</span></p>
                                    <p>Sisa denda: <span class="font-semibold text-[#191c1d]">Rp {{ number_format($remainingFine, 0, ',', '.') }}</span></p>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Jumlah Pembayaran</label>
                                    <input type="number" name="amount" required min="0" max="{{ $remainingFine }}" step="500"
                                        class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                                </div>
                            </div>
                            <div class="flex justify-end gap-3 border-t border-[#e1e3e4] bg-[#f3f4f5] px-6 py-4">
                                <button type="button" class="rounded-lg bg-[#e1e3e4] px-6 py-2 text-sm font-semibold text-[#3d4947] transition hover:bg-[#bcc9c6]" x-on:click="$refs.payment{{ $returnRecord->id }}.close()">Batal</button>
                                <button type="submit" class="rounded-lg bg-[#00685f] px-6 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#008378]">Simpan Pembayaran</button>
                            </div>
                        </form>
                    </div>
                    <form method="dialog" class="modal-backdrop"><button>close</button></form>
                </dialog>
            @endif
        @endforeach
    </div>
</x-admin-layout>
