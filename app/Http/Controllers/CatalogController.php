<?php

namespace App\Http\Controllers;

use App\Actions\Catalog\SearchBooks;
use App\Http\Requests\Catalog\IndexCatalogRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Contracts\View\View;

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
}
