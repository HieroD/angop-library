<x-member-layout title="Aturan Peminjaman" active="borrowings">
    <div class="mb-6 flex flex-col gap-1">
        <h2 class="text-2xl font-bold text-[#191c1d] sm:text-3xl">Aturan Peminjaman</h2>
        <p class="text-base text-[#3d4947]">Panduan lengkap alur peminjaman dan pengembalian buku.</p>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <section class="overflow-hidden rounded-lg border border-[#e1e3e4] bg-white shadow-sm">
            <div class="border-b border-[#e1e3e4] bg-[#008378] px-5 py-4">
                <h3 class="flex items-center gap-2 text-lg font-semibold text-white">
                    <span class="material-symbols-outlined" style="font-size: 20px;">login</span>
                    Alur Peminjaman
                </h3>
            </div>
            <div class="space-y-0 divide-y divide-[#e1e3e4]">
                <div class="flex gap-4 px-5 py-4">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#d5e3fc] text-sm font-bold text-[#515f74]">1</span>
                    <div>
                        <p class="font-semibold text-[#191c1d]">Cari Buku</p>
                        <p class="mt-1 text-sm text-[#3d4947]">Telusuri katalog buku yang tersedia di halaman <a href="{{ route('member.catalog.index') }}" class="font-semibold text-[#00685f] hover:underline">Katalog Buku</a>. Pastikan stok buku tersedia.</p>
                    </div>
                </div>
                <div class="flex gap-4 px-5 py-4">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#d5e3fc] text-sm font-bold text-[#515f74]">2</span>
                    <div>
                        <p class="font-semibold text-[#191c1d]">Ajukan Peminjaman</p>
                        <p class="mt-1 text-sm text-[#3d4947]">Klik tombol <strong>Pinjam Buku Ini</strong> pada detail buku. Status peminjaman akan menjadi <strong>Menunggu Konfirmasi</strong>.</p>
                    </div>
                </div>
                <div class="flex gap-4 px-5 py-4">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#d5e3fc] text-sm font-bold text-[#515f74]">3</span>
                    <div>
                        <p class="font-semibold text-[#191c1d]">Konfirmasi Petugas</p>
                        <p class="mt-1 text-sm text-[#3d4947]">Petugas perpustakaan akan memproses permohonan Anda. Jika disetujui, status berubah menjadi <strong>Dipinjam</strong> dan masa peminjaman dimulai.</p>
                    </div>
                </div>
                <div class="flex gap-4 px-5 py-4">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#ffdad6] text-sm font-bold text-[#93000a]">!</span>
                    <div>
                        <p class="font-semibold text-[#191c1d]">Jika Ditolak</p>
                        <p class="mt-1 text-sm text-[#3d4947]">Permohonan dapat ditolak oleh petugas. Stok buku akan dikembalikan secara otomatis dan Anda dapat mengajukan ulang.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="overflow-hidden rounded-lg border border-[#e1e3e4] bg-white shadow-sm">
            <div class="border-b border-[#e1e3e4] bg-[#515f74] px-5 py-4">
                <h3 class="flex items-center gap-2 text-lg font-semibold text-white">
                    <span class="material-symbols-outlined" style="font-size: 20px;">logout</span>
                    Alur Pengembalian
                </h3>
            </div>
            <div class="space-y-0 divide-y divide-[#e1e3e4]">
                <div class="flex gap-4 px-5 py-4">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#ede7d7] text-sm font-bold text-[#6d5e2e]">1</span>
                    <div>
                        <p class="font-semibold text-[#191c1d]">Kembalikan Buku</p>
                        <p class="mt-1 text-sm text-[#3d4947]">Kembalikan buku yang Anda pinjam ke petugas perpustakaan sebelum atau pada tanggal tenggat waktu yang ditentukan.</p>
                    </div>
                </div>
                <div class="flex gap-4 px-5 py-4">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#ede7d7] text-sm font-bold text-[#6d5e2e]">2</span>
                    <div>
                        <p class="font-semibold text-[#191c1d]">Petugas Memproses</p>
                        <p class="mt-1 text-sm text-[#3d4947]">Petugas akan memproses pengembalian dan mencatat status buku. Status peminjaman berubah menjadi <strong>Dikembalikan</strong>.</p>
                    </div>
                </div>
                <div class="flex gap-4 px-5 py-4">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#ede7d7] text-sm font-bold text-[#6d5e2e]">3</span>
                    <div>
                        <p class="font-semibold text-[#191c1d]">Pelunasan Denda</p>
                        <p class="mt-1 text-sm text-[#3d4947]">Jika melewati batas waktu, Anda akan dikenakan denda yang harus dilunasi sebelum dapat meminjam kembali.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <section class="mt-6 overflow-hidden rounded-lg border border-[#e1e3e4] bg-white shadow-sm">
        <div class="border-b border-[#e1e3e4] bg-[#191c1d] px-5 py-4">
            <h3 class="flex items-center gap-2 text-lg font-semibold text-white">
                <span class="material-symbols-outlined" style="font-size: 20px;">info</span>
                Ketentuan &amp; Kebijakan
            </h3>
        </div>
        <div class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-lg border border-[#e1e3e4] bg-[#f3f4f5] p-4">
                <div class="mb-2 flex h-10 w-10 items-center justify-center rounded-lg bg-[#008378] text-white">
                    <span class="material-symbols-outlined" style="font-size: 20px;">calendar_today</span>
                </div>
                <p class="font-semibold text-[#191c1d]">Batas Waktu</p>
                <p class="mt-1 text-sm text-[#3d4947]">Masa peminjaman adalah <strong>7 hari</strong> sejak tanggal disetujui.</p>
            </div>
            <div class="rounded-lg border border-[#e1e3e4] bg-[#f3f4f5] p-4">
                <div class="mb-2 flex h-10 w-10 items-center justify-center rounded-lg bg-[#93000a] text-white">
                    <span class="material-symbols-outlined" style="font-size: 20px;">payments</span>
                </div>
                <p class="font-semibold text-[#191c1d]">Denda Keterlambatan</p>
                <p class="mt-1 text-sm text-[#3d4947]">Denda sebesar <strong>Rp 1.000</strong> per hari untuk setiap buku yang terlambat dikembalikan.</p>
            </div>
            <div class="rounded-lg border border-[#e1e3e4] bg-[#f3f4f5] p-4">
                <div class="mb-2 flex h-10 w-10 items-center justify-center rounded-lg bg-[#515f74] text-white">
                    <span class="material-symbols-outlined" style="font-size: 20px;">block</span>
                </div>
                <p class="font-semibold text-[#191c1d]">Peminjaman Ganda</p>
                <p class="mt-1 text-sm text-[#3d4947]">Tidak dapat meminjam buku yang sama jika masih memiliki peminjaman aktif.</p>
            </div>
            <div class="rounded-lg border border-[#e1e3e4] bg-[#f3f4f5] p-4">
                <div class="mb-2 flex h-10 w-10 items-center justify-center rounded-lg bg-[#6d5e2e] text-white">
                    <span class="material-symbols-outlined" style="font-size: 20px;">assignment</span>
                </div>
                <p class="font-semibold text-[#191c1d]">Riwayat Peminjaman</p>
                <p class="mt-1 text-sm text-[#3d4947]">Semua riwayat peminjaman dapat dilihat di halaman <strong>Dashboard</strong> Anda.</p>
            </div>
        </div>
    </section>
</x-member-layout>
