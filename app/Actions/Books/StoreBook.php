<?php

namespace App\Actions\Books;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\UploadedFile;

class StoreBook
{
    public function handle(array $data, ?UploadedFile $bookCover = null): Book
    {
        $author = $this->resolveAuthor($data);
        $category = $this->resolveCategory($data);

        $book = Book::query()->create([
            'category_id' => $category->id,
            'title' => $data['title'],
            'publisher' => $data['publisher'] ?? null,
            'published_year' => $data['published_year'],
            'total_copies' => $data['total_copies'],
            'book_cover' => $bookCover?->store('book-covers', 'public'),
            'isbn' => $data['isbn'] ?? null,
            'description' => $data['description'] ?? null,
        ]);

        $book->authors()->sync([$author->id]);

        return $book;
    }

    private function resolveAuthor(array $data): Author
    {
        if (! empty($data['author_id'])) {
            return Author::query()->findOrFail($data['author_id']);
        }

        return Author::query()->firstOrCreate([
            'name' => $data['author_name'],
        ]);
    }

    private function resolveCategory(array $data): Category
    {
        if (! empty($data['category_id'])) {
            return Category::query()->findOrFail($data['category_id']);
        }

        return Category::query()->firstOrCreate([
            'name' => $data['category_name'],
        ]);
    }
}
