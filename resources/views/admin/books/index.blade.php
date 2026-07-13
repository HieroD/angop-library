<x-admin-layout title="Kelola Buku" active="books">
    <div x-data="{}">
    <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h2 class="text-3xl font-bold leading-tight text-[#191c1d]">Manajemen Buku</h2>
            <p class="mt-1 text-[#3d4947]">Kelola katalog buku, tambah judul baru, dan pantau ketersediaan stok.</p>
        </div>
        <button class="flex shrink-0 items-center gap-2 rounded-lg bg-[#00685f] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#008378]" x-on:click="$refs.storeModal.showModal()">
            <span class="material-symbols-outlined" style="font-size: 20px;">add</span>
            Tambah Buku
        </button>
    </div>

    <div class="overflow-hidden rounded-xl border border-[#e1e3e4] bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full table-fixed">
                <thead class="bg-[#f3f4f5] text-xs uppercase tracking-wider text-[#3d4947]">
                    <tr>
                        <th class="w-[38%] px-6 py-4">Judul Buku</th>
                        <th class="w-[16%] px-6 py-4">Kategori</th>
                        <th class="w-[18%] px-6 py-4">Penerbit</th>
                        <th class="w-[10%] px-6 py-4">Tahun</th>
                        <th class="w-[10%] px-6 py-4">Stok</th>
                        <th class="w-[8%] px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e1e3e4]/50">
                    @forelse ($books as $book)
                        <tr class="transition hover:bg-[#00685f]/5">
                            <td class="px-6 py-4">
                                <div class="flex min-w-0 items-center gap-3">
                                    <div class="flex size-10 shrink-0 items-center justify-center overflow-hidden rounded bg-[#e1e3e4]">
                                        @if ($book->book_cover)
                                            <img class="size-full object-contain" src="{{ asset('storage/'.$book->book_cover) }}" alt="{{ $book->title }}">
                                        @else
                                            <span class="material-symbols-outlined text-[#3d4947]/50">menu_book</span>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="truncate font-semibold text-[#191c1d]" title="{{ $book->title }}">{{ $book->title }}</p>
                                        <p class="truncate text-xs text-[#3d4947]" title="{{ $book->authors->first()?->name }}">{{ $book->authors->first()?->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($book->category)
                                    <span class="inline-flex max-w-full items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                                        <span class="truncate" title="{{ $book->category->name }}">
                                        {{ $book->category->name }}
                                        </span>
                                    </span>
                                @endif
                            </td>
                            <td class="truncate px-6 py-4 text-[#3d4947]" title="{{ $book->publisher ?? '-' }}">{{ $book->publisher ?? '-' }}</td>
                            <td class="px-6 py-4 text-[#3d4947]">{{ $book->published_year }}</td>
                            <td class="px-6 py-4">
                                @php($stockClass = $book->total_copies > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700')
                                @php($stockLabel = $book->total_copies > 0 ? $book->total_copies.' Tersedia' : 'Habis')
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $stockClass }}">
                                    {{ $stockLabel }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-1">
                                    <button class="flex size-8 items-center justify-center rounded-full text-blue-600 transition hover:bg-blue-50" title="Edit" x-on:click="$refs.edit{{ $book->id }}.showModal()">
                                        <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
                                    </button>
                                    <button class="flex size-8 items-center justify-center rounded-full text-rose-600 transition hover:bg-rose-50" title="Hapus" x-on:click="$refs.delete{{ $book->id }}.showModal()">
                                        <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-[#3d4947]">Belum ada buku.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($books->hasPages())
            <div class="flex items-center justify-between border-t border-[#e1e3e4] bg-white px-6 py-4">
                <span class="text-sm text-[#3d4947]">
                    Menampilkan {{ $books->firstItem() }}-{{ $books->lastItem() }} dari {{ $books->total() }} buku
                </span>
                <div class="flex items-center gap-1">
                    @if ($books->onFirstPage())
                        <span class="flex size-8 items-center justify-center rounded text-[#bcc9c6]"><span class="material-symbols-outlined" style="font-size: 20px;">chevron_left</span></span>
                    @else
                        <a href="{{ $books->previousPageUrl() }}" class="flex size-8 items-center justify-center rounded text-[#3d4947] transition hover:bg-[#e1e3e4]"><span class="material-symbols-outlined" style="font-size: 20px;">chevron_left</span></a>
                    @endif

                    @foreach ($books->getUrlRange(1, $books->lastPage()) as $page => $url)
                        <a href="{{ $url }}" @class([
                            'flex size-8 items-center justify-center rounded text-sm font-semibold transition',
                            'bg-[#00685f] text-white' => $page === $books->currentPage(),
                            'text-[#3d4947] hover:bg-[#e1e3e4]' => $page !== $books->currentPage(),
                        ])>{{ $page }}</a>
                    @endforeach

                    @if ($books->hasMorePages())
                        <a href="{{ $books->nextPageUrl() }}" class="flex size-8 items-center justify-center rounded text-[#3d4947] transition hover:bg-[#e1e3e4]"><span class="material-symbols-outlined" style="font-size: 20px;">chevron_right</span></a>
                    @else
                        <span class="flex size-8 items-center justify-center rounded text-[#bcc9c6]"><span class="material-symbols-outlined" style="font-size: 20px;">chevron_right</span></span>
                    @endif
                </div>
            </div>
        @endif
    </div>

    @foreach ($books as $book)
        <dialog x-ref="edit{{ $book->id }}" class="modal modal-middle">
            <div class="modal-box max-w-2xl p-0">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 z-10 text-[#3d4947] hover:text-rose-600">✕</button>
                </form>
                <form method="POST" action="{{ route('admin.books.update', $book) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="border-b border-[#e1e3e4] bg-[#f3f4f5] px-6 py-4">
                        <h3 class="text-xl font-semibold text-[#191c1d]">Edit Buku</h3>
                    </div>
                    <div class="max-h-[70vh] space-y-4 overflow-y-auto p-6">
                        <div class="flex flex-col gap-6 md:flex-row">
                            <div class="w-full shrink-0 md:w-40" x-data="{ previewUrl: @js($book->book_cover ? asset('storage/'.$book->book_cover) : null) }">
                                <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Sampul Buku</label>
                                <div class="relative flex aspect-[3/4] w-full cursor-pointer flex-col items-center justify-center overflow-hidden rounded-lg border-2 border-dashed border-[#bcc9c6] bg-[#e1e3e4]/20 text-[#3d4947]/50 transition hover:bg-[#e1e3e4]/30">
                                    <img x-show="previewUrl" x-bind:src="previewUrl" class="size-full object-contain" alt="Preview sampul buku">
                                    <div x-show="!previewUrl" class="flex flex-col items-center justify-center">
                                        <span class="material-symbols-outlined" style="font-size: 40px;">add_a_photo</span>
                                        <span class="mt-2 text-xs">Upload Foto</span>
                                    </div>
                                    <input type="file" name="book_cover" accept="image/*" class="absolute inset-0 cursor-pointer opacity-0" x-on:change="previewUrl = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : previewUrl">
                                </div>
                                <p class="mt-2 text-xs text-[#3d4947]/70">Disarankan rasio 3:4 (portrait). Format: JPG, PNG, WEBP.</p>
                            </div>
                            <div class="flex-1 space-y-4">
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Judul Buku</label>
                                    <input type="text" name="title" value="{{ old('title', $book->title) }}" required
                                        class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                                </div>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">ISBN</label>
                                        <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}"
                                            class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                                    </div>
                                    <div x-data="{ authorId: @js((string) old('author_id', $book->authors->first()?->id)) }" x-init="if (authorId) $refs.authorName.value = ''">
                                        <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Pengarang</label>
                                        <select name="author_id" x-model="authorId" x-on:change="if (authorId) $refs.authorName.value = ''"
                                            class="mb-2 w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                                            <option value="">— Pilih —</option>
                                            @foreach ($authors as $author)
                                                <option value="{{ $author->id }}" @selected(old('author_id', $book->authors->first()?->id) == $author->id)>{{ $author->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="author_name" value="{{ old('author_name') }}" placeholder="Atau ketik nama baru..." x-ref="authorName" x-bind:disabled="authorId !== ''" x-on:input="if ($event.target.value) authorId = ''"
                                            class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition disabled:cursor-not-allowed disabled:bg-[#f3f4f5] disabled:text-[#3d4947]/50 focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div x-data="{ categoryId: @js((string) old('category_id', $book->category?->id)) }" x-init="if (categoryId) $refs.categoryName.value = ''">
                                <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Kategori</label>
                                <select name="category_id" x-model="categoryId" x-on:change="if (categoryId) $refs.categoryName.value = ''"
                                    class="mb-2 w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                                    <option value="">— Pilih —</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id', $book->category?->id) == $category->id)>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <input type="text" name="category_name" value="{{ old('category_name') }}" placeholder="Atau ketik nama baru..." x-ref="categoryName" x-bind:disabled="categoryId !== ''" x-on:input="if ($event.target.value) categoryId = ''"
                                    class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition disabled:cursor-not-allowed disabled:bg-[#f3f4f5] disabled:text-[#3d4947]/50 focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Penerbit</label>
                                <input type="text" name="publisher" value="{{ old('publisher', $book->publisher) }}"
                                    class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Tahun Terbit</label>
                                <input type="number" name="published_year" value="{{ old('published_year', $book->published_year) }}" required
                                    class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Stok</label>
                                <input type="number" name="total_copies" value="{{ old('total_copies', $book->total_copies) }}" required min="0"
                                    class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                            </div>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Deskripsi</label>
                            <textarea name="description" rows="3"
                                class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">{{ old('description', $book->description) }}</textarea>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 border-t border-[#e1e3e4] bg-[#f3f4f5] px-6 py-4">
                        <button type="button" class="rounded-lg bg-[#e1e3e4] px-6 py-2 text-sm font-semibold text-[#3d4947] transition hover:bg-[#bcc9c6]" x-on:click="$refs.edit{{ $book->id }}.close()">Batal</button>
                        <button type="submit" class="rounded-lg bg-[#00685f] px-6 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#008378]">Simpan</button>
                    </div>
                </form>
            </div>
            <form method="dialog" class="modal-backdrop"><button>close</button></form>
        </dialog>

        <dialog x-ref="delete{{ $book->id }}" class="modal modal-middle">
            <div class="modal-box max-w-md p-0">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 z-10 text-[#3d4947] hover:text-rose-600">✕</button>
                </form>
                <form method="POST" action="{{ route('admin.books.destroy', $book) }}">
                    @csrf
                    @method('DELETE')
                    <div class="border-b border-[#e1e3e4] bg-[#f3f4f5] px-6 py-4">
                        <h3 class="text-xl font-semibold text-[#191c1d]">Konfirmasi Hapus Buku</h3>
                    </div>
                    <div class="space-y-4 p-6">
                        <div class="flex items-center gap-3 text-rose-600">
                            <span class="material-symbols-outlined">warning</span>
                            <p class="text-sm font-semibold">Tindakan ini tidak dapat dibatalkan.</p>
                        </div>
                        <p class="text-sm text-[#3d4947]">Seluruh data terkait buku <strong>{{ $book->title }}</strong> akan dihapus secara permanen dari sistem.</p>
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Ketik kembali judul buku untuk konfirmasi:</label>
                            <input type="text" name="title_confirmation" required
                                placeholder="Masukkan judul buku"
                                class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-rose-600 focus:ring-2 focus:ring-rose-600/20">
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 border-t border-[#e1e3e4] bg-[#f3f4f5] px-6 py-4">
                        <button type="button" class="rounded-lg bg-[#e1e3e4] px-6 py-2 text-sm font-semibold text-[#3d4947] transition hover:bg-[#bcc9c6]" x-on:click="$refs.delete{{ $book->id }}.close()">Batal</button>
                        <button type="submit" class="rounded-lg bg-rose-600 px-6 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-rose-700">Hapus Permanen</button>
                    </div>
                </form>
            </div>
            <form method="dialog" class="modal-backdrop"><button>close</button></form>
        </dialog>
    @endforeach

    {{-- Store Modal --}}
    <dialog x-ref="storeModal" class="modal modal-middle">
        <div class="modal-box max-w-2xl p-0">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 z-10 text-[#3d4947] hover:text-rose-600">✕</button>
            </form>
            <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="border-b border-[#e1e3e4] bg-[#f3f4f5] px-6 py-4">
                    <h3 class="text-xl font-semibold text-[#191c1d]">Tambah Buku Baru</h3>
                </div>
                <div class="max-h-[70vh] space-y-4 overflow-y-auto p-6">
                    <div class="flex flex-col gap-6 md:flex-row">
                        <div class="relative w-full shrink-0 md:w-40" x-data="{ previewUrl: null }">
                            <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Sampul Buku</label>
                            <div class="relative flex aspect-[3/4] w-full cursor-pointer flex-col items-center justify-center overflow-hidden rounded-lg border-2 border-dashed border-[#bcc9c6] bg-[#e1e3e4]/20 text-[#3d4947]/50 transition hover:bg-[#e1e3e4]/30">
                                <img x-show="previewUrl" x-bind:src="previewUrl" class="size-full object-contain" alt="Preview sampul buku">
                                <div x-show="!previewUrl" class="flex flex-col items-center justify-center">
                                    <span class="material-symbols-outlined" style="font-size: 40px;">add_a_photo</span>
                                    <span class="mt-2 text-xs">Upload Foto</span>
                                </div>
                                <input type="file" name="book_cover" accept="image/*" class="absolute inset-0 cursor-pointer opacity-0" x-on:change="previewUrl = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
                            </div>
                            <p class="mt-2 text-xs text-[#3d4947]/70">Disarankan rasio 3:4 (portrait). Format: JPG, PNG, WEBP.</p>
                        </div>
                        <div class="flex-1 space-y-4">
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Judul Buku</label>
                                <input type="text" name="title" value="{{ old('title') }}" required
                                    class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                            </div>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">ISBN</label>
                                    <input type="text" name="isbn" value="{{ old('isbn') }}"
                                        class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                                </div>
                                <div x-data="{ authorId: @js((string) old('author_id')) }" x-init="if (authorId) $refs.authorName.value = ''">
                                    <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Pengarang</label>
                                    <select name="author_id" x-model="authorId" x-on:change="if (authorId) $refs.authorName.value = ''"
                                        class="mb-2 w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                                        <option value="">— Pilih —</option>
                                        @foreach ($authors as $author)
                                            <option value="{{ $author->id }}">{{ $author->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="author_name" value="{{ old('author_name') }}" placeholder="Atau ketik nama baru..." x-ref="authorName" x-bind:disabled="authorId !== ''" x-on:input="if ($event.target.value) authorId = ''"
                                        class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition disabled:cursor-not-allowed disabled:bg-[#f3f4f5] disabled:text-[#3d4947]/50 focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div x-data="{ categoryId: @js((string) old('category_id')) }" x-init="if (categoryId) $refs.categoryName.value = ''">
                            <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Kategori</label>
                            <select name="category_id" x-model="categoryId" x-on:change="if (categoryId) $refs.categoryName.value = ''"
                                class="mb-2 w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                                <option value="">— Pilih —</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="category_name" value="{{ old('category_name') }}" placeholder="Atau ketik nama baru..." x-ref="categoryName" x-bind:disabled="categoryId !== ''" x-on:input="if ($event.target.value) categoryId = ''"
                                class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition disabled:cursor-not-allowed disabled:bg-[#f3f4f5] disabled:text-[#3d4947]/50 focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Penerbit</label>
                            <input type="text" name="publisher" value="{{ old('publisher') }}"
                                class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Tahun Terbit</label>
                            <input type="number" name="published_year" value="{{ old('published_year') }}" required
                                class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Stok</label>
                            <input type="number" name="total_copies" value="{{ old('total_copies', 1) }}" required min="0"
                                class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">
                        </div>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-[#3d4947]">Deskripsi</label>
                        <textarea name="description" rows="3" placeholder="Ringkasan singkat buku..."
                            class="w-full rounded-lg border border-[#bcc9c6] bg-white px-4 py-2 text-sm transition focus:border-[#00685f] focus:ring-2 focus:ring-[#00685f]/20">{{ old('description') }}</textarea>
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
