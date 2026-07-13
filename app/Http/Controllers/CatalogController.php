<?php

namespace App\Http\Controllers;

use App\Actions\Catalog\CreateBorrowing;
use App\Actions\Catalog\SearchBooks;
use App\Http\Requests\Catalog\IndexCatalogRequest;
use App\Http\Requests\Catalog\StoreBorrowingRequest;
use App\Models\Book;
use App\Models\Category;
use DomainException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CatalogController extends Controller
{
    public function index(IndexCatalogRequest $request, SearchBooks $searchBooks): View
    {
        $books = $searchBooks->handle($request->validated());

        $categories = Category::query()->orderBy('name')->get();

        return view('member.catalog.index', compact('books', 'categories'));
    }

    public function show(Book $book): View
    {
        $book->load(['category', 'authors']);

        return view('member.catalog.show', compact('book'));
    }

    public function borrow(StoreBorrowingRequest $request, Book $book, CreateBorrowing $createBorrowing): RedirectResponse
    {
        try {
            $createBorrowing->handle(auth('member')->user(), $book);
        } catch (DomainException $e) {
            return back()->withErrors([$e->getMessage()]);
        }

        return back()->with('success', 'Permohonan peminjaman berhasil diajukan.');
    }
}
