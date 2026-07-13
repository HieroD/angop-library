<x-admin-layout title="Kelola Anggota" active="members">
    <div x-data="{}">
        <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h2 class="text-3xl font-bold leading-tight text-[#191c1d]">Daftar Anggota</h2>
                <p class="mt-1 text-[#3d4947]">Kelola data seluruh anggota perpustakaan.</p>
            </div>
            <button class="flex shrink-0 items-center gap-2 rounded-lg bg-[#00685f] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#008378]" x-on:click="$refs.storeModal.showModal()">
                <span class="material-symbols-outlined" style="font-size: 20px;">add</span>
                Tambah Anggota
            </button>
        </div>

        <div class="overflow-hidden rounded-xl border border-[#e1e3e4] bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="table w-full table-fixed">
                    <thead class="bg-[#f3f4f5] text-xs uppercase tracking-wider text-[#3d4947]">
                        <tr>
                            <th class="w-[14%] px-6 py-4">Kode Anggota</th>
                            <th class="w-[24%] px-6 py-4">Nama Lengkap</th>
                            <th class="w-[28%] px-6 py-4">Kontak</th>
                            <th class="w-[14%] px-6 py-4">Tgl Daftar</th>
                            <th class="w-[12%] px-6 py-4 text-center">Total Pinjaman</th>
                            <th class="w-[8%] px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#e1e3e4]/50 text-sm">
                        @forelse ($members as $member)
                            @php
                                $initials = collect(explode(' ', $member->name))
                                    ->filter()
                                    ->take(2)
                                    ->map(fn (string $part): string => mb_substr($part, 0, 1))
                                    ->implode('');
                            @endphp
                            <tr class="transition hover:bg-[#00685f]/5">
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center rounded-full border border-blue-100 bg-blue-100 px-2.5 py-0.5 font-mono text-xs font-medium text-blue-800">
                                        {{ $member->member_code }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex min-w-0 items-center gap-3">
                                        <div class="flex size-8 shrink-0 items-center justify-center rounded-full bg-[#89f5e7] text-xs font-bold uppercase text-[#005049]">
                                            {{ $initials }}
                                        </div>
                                        <span class="truncate font-semibold text-[#191c1d]" title="{{ $member->name }}">{{ $member->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="min-w-0">
                                        <p class="truncate text-[#191c1d]" title="{{ $member->email }}">{{ $member->email }}</p>
                                        @if ($member->phone)
                                            <p class="mt-0.5 truncate text-xs text-[#3d4947]" title="{{ $member->phone }}">{{ $member->phone }}</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-[#3d4947]">{{ $member->created_at?->translatedFormat('d M Y') ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex size-7 items-center justify-center rounded-full bg-[#e1e3e4] text-xs font-semibold text-[#191c1d]">
                                        {{ $member->borrowings_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-1">
                                        <button class="flex size-8 items-center justify-center rounded-full text-blue-600 transition hover:bg-blue-50" title="Edit" x-on:click="$refs.edit{{ $member->id }}.showModal()">
                                            <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
                                        </button>
                                        <button class="flex size-8 items-center justify-center rounded-full text-rose-600 transition hover:bg-rose-50" title="Hapus" x-on:click="$refs.delete{{ $member->id }}.showModal()">
                                            <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-[#3d4947]">Belum ada anggota.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($members->hasPages())
                <div class="flex items-center justify-between border-t border-[#e1e3e4] bg-white px-6 py-4">
                    <span class="text-sm text-[#3d4947]">
                        Menampilkan {{ $members->firstItem() }}-{{ $members->lastItem() }} dari {{ $members->total() }} anggota
                    </span>
                    <div class="flex items-center gap-1">
                        @if ($members->onFirstPage())
                            <span class="flex size-8 items-center justify-center rounded text-[#bcc9c6]"><span class="material-symbols-outlined" style="font-size: 20px;">chevron_left</span></span>
                        @else
                            <a href="{{ $members->previousPageUrl() }}" class="flex size-8 items-center justify-center rounded text-[#3d4947] transition hover:bg-[#e1e3e4]"><span class="material-symbols-outlined" style="font-size: 20px;">chevron_left</span></a>
                        @endif

                        @foreach ($members->getUrlRange(1, $members->lastPage()) as $page => $url)
                            <a href="{{ $url }}" @class([
                                'flex size-8 items-center justify-center rounded text-sm font-semibold transition',
                                'bg-[#00685f] text-white' => $page === $members->currentPage(),
                                'text-[#3d4947] hover:bg-[#e1e3e4]' => $page !== $members->currentPage(),
                            ])>{{ $page }}</a>
                        @endforeach

                        @if ($members->hasMorePages())
                            <a href="{{ $members->nextPageUrl() }}" class="flex size-8 items-center justify-center rounded text-[#3d4947] transition hover:bg-[#e1e3e4]"><span class="material-symbols-outlined" style="font-size: 20px;">chevron_right</span></a>
                        @else
                            <span class="flex size-8 items-center justify-center rounded text-[#bcc9c6]"><span class="material-symbols-outlined" style="font-size: 20px;">chevron_right</span></span>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        @foreach ($members as $member)
            <dialog x-ref="edit{{ $member->id }}" class="modal modal-middle">
                <div class="modal-box max-w-2xl p-0">
                    <form method="dialog">
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 z-10 text-[#3d4947] hover:text-rose-600">x</button>
                    </form>
                    <form method="POST" action="{{ route('admin.members.update', $member) }}" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="border-b border-[#e1e3e4] bg-[#f3f4f5] px-6 py-4">
                            <h3 class="text-xl font-semibold text-[#191c1d]">Edit Anggota</h3>
                        </div>
                        <div class="max-h-[70vh] space-y-4 overflow-y-auto p-6">
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Nama</label>
                                    <input type="text" name="name" value="{{ old('name', $member->name) }}" required
                                        class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Email</label>
                                    <input type="email" name="email" value="{{ old('email', $member->email) }}" required autocomplete="off"
                                        class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Password Baru</label>
                                    <input type="password" name="password" placeholder="Kosongkan jika tidak diubah" autocomplete="new-password"
                                        class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Telepon</label>
                                    <input type="tel" name="phone" value="{{ old('phone', $member->phone) }}" inputmode="tel" autocomplete="tel" pattern="[0-9+()\s-]+"
                                        class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Jenis Kelamin</label>
                                    <select name="gender"
                                        class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                                        <option value="">Pilih jenis kelamin</option>
                                        <option value="M" @selected(old('gender', $member->gender) === 'M')>Laki-laki</option>
                                        <option value="F" @selected(old('gender', $member->gender) === 'F')>Perempuan</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Tanggal Lahir</label>
                                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $member->date_of_birth?->format('Y-m-d')) }}"
                                        class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                                </div>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Alamat</label>
                                <textarea name="address" rows="3"
                                    class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">{{ old('address', $member->address) }}</textarea>
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 border-t border-[#e1e3e4] bg-[#f3f4f5] px-6 py-4">
                            <button type="button" class="rounded-lg bg-[#e1e3e4] px-6 py-2 text-sm font-semibold text-[#3d4947] transition hover:bg-[#bcc9c6]" x-on:click="$refs.edit{{ $member->id }}.close()">Batal</button>
                            <button type="submit" class="rounded-lg bg-[#00685f] px-6 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#008378]">Simpan</button>
                        </div>
                    </form>
                </div>
                <form method="dialog" class="modal-backdrop"><button>close</button></form>
            </dialog>

            <dialog x-ref="delete{{ $member->id }}" class="modal modal-middle">
                <div class="modal-box max-w-md p-0">
                    <form method="dialog">
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 z-10 text-[#3d4947] hover:text-rose-600">x</button>
                    </form>
                    <form method="POST" action="{{ route('admin.members.destroy', $member) }}">
                        @csrf
                        @method('DELETE')
                        <div class="border-b border-[#e1e3e4] bg-[#f3f4f5] px-6 py-4">
                            <h3 class="text-xl font-semibold text-[#191c1d]">Konfirmasi Hapus Anggota</h3>
                        </div>
                        <div class="space-y-4 p-6">
                            <div class="flex items-center gap-3 text-rose-600">
                                <span class="material-symbols-outlined">warning</span>
                                <p class="text-sm font-semibold">Tindakan ini tidak dapat dibatalkan.</p>
                            </div>
                            <p class="text-sm text-[#3d4947]">Seluruh data anggota <strong>{{ $member->name }}</strong> akan dihapus secara permanen dari sistem.</p>
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Ketik kembali email anggota untuk konfirmasi:</label>
                                <input type="email" name="email_confirmation" required
                                    placeholder="{{ $member->email }}"
                                    class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-rose-600 focus:ring-2 focus:ring-rose-600/20">
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 border-t border-[#e1e3e4] bg-[#f3f4f5] px-6 py-4">
                            <button type="button" class="rounded-lg bg-[#e1e3e4] px-6 py-2 text-sm font-semibold text-[#3d4947] transition hover:bg-[#bcc9c6]" x-on:click="$refs.delete{{ $member->id }}.close()">Batal</button>
                            <button type="submit" class="rounded-lg bg-rose-600 px-6 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-rose-700">Hapus Permanen</button>
                        </div>
                    </form>
                </div>
                <form method="dialog" class="modal-backdrop"><button>close</button></form>
            </dialog>
        @endforeach

        <dialog x-ref="storeModal" class="modal modal-middle">
            <div class="modal-box max-w-2xl p-0">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 z-10 text-[#3d4947] hover:text-rose-600">x</button>
                </form>
                <form method="POST" action="{{ route('admin.members.store') }}" autocomplete="off">
                    @csrf
                    <div class="border-b border-[#e1e3e4] bg-[#f3f4f5] px-6 py-4">
                        <h3 class="text-xl font-semibold text-[#191c1d]">Tambah Anggota Baru</h3>
                    </div>
                    <div class="max-h-[70vh] space-y-4 overflow-y-auto p-6">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Nama</label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                    class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" required autocomplete="off"
                                    class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Password</label>
                                <input type="password" name="password" required autocomplete="new-password"
                                    class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Telepon</label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" inputmode="tel" autocomplete="tel" pattern="[0-9+()\s-]+"
                                    class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Jenis Kelamin</label>
                                <select name="gender"
                                    class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                                    <option value="">Pilih jenis kelamin</option>
                                    <option value="M" @selected(old('gender') === 'M')>Laki-laki</option>
                                    <option value="F" @selected(old('gender') === 'F')>Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Tanggal Lahir</label>
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                                    class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                            </div>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Alamat</label>
                            <textarea name="address" rows="3" placeholder="Alamat lengkap anggota..."
                                class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">{{ old('address') }}</textarea>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 border-t border-[#e1e3e4] bg-[#f3f4f5] px-6 py-4">
                        <button type="button" class="rounded-lg bg-[#e1e3e4] px-6 py-2 text-sm font-semibold text-[#3d4947] transition hover:bg-[#bcc9c6]" x-on:click="$refs.storeModal.close()">Batal</button>
                        <button type="submit" class="rounded-lg bg-[#00685f] px-6 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#008378]">Simpan</button>
                    </div>
                </form>
            </div>
            <form method="dialog" class="modal-backdrop"><button>close</button></form>
        </dialog>
    </div>
</x-admin-layout>
