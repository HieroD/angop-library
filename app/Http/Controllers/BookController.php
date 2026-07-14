<?php

namespace App\Http\Controllers;

use App\Actions\Books\DeleteBook;
use App\Actions\Books\StoreBook;
use App\Actions\Books\UpdateBook;
use App\Http\Requests\Books\DestroyBookRequest;
use App\Http\Requests\Books\StoreBookRequest;
use App\Http\Requests\Books\UpdateBookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class BookController extends Controller
{
    public function index(): View
    {
        $books = Book::query()
            ->with(['authors', 'category'])
            ->latest()
            ->paginate(7);

        $authors = Author::query()->orderBy('name')->get(['id', 'name']);

        $categories = Category::query()->orderBy('name')->get(['id', 'name']);

        return view('admin.books.index', compact('books', 'authors', 'categories'));
    }

    public function store(StoreBookRequest $request, StoreBook $storeBook): RedirectResponse
    {
        $storeBook->handle($request->validated(), $request->file('book_cover'));

        return back()->with('success', 'Buku berhasil ditambahkan.');
    }

    public function update(UpdateBookRequest $request, Book $book, UpdateBook $updateBook): RedirectResponse
    {
        $updateBook->handle($book, $request->validated(), $request->file('book_cover'));

        return back()->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(DestroyBookRequest $request, Book $book, DeleteBook $deleteBook): RedirectResponse
    {
        $deleteBook->handle($book);

        return back()->with('success', 'Buku berhasil dihapus.');
    }
}
