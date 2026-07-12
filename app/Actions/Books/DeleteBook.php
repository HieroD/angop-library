<?php

namespace App\Actions\Books;

use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class DeleteBook
{
    public function handle(Book $book): void
    {
        if ($book->book_cover !== null) {
            Storage::disk('public')->delete($book->book_cover);
        }

        $book->delete();
    }
}
