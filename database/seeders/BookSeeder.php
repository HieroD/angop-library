<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Seed the book catalog.
     */
    public function run(): void
    {
        $books = [
            ['title' => 'Laskar Pelangi', 'author' => 'Andrea Hirata', 'category' => 'Novel', 'publisher' => 'Bentang Pustaka', 'year' => 2005, 'isbn' => '9789793062792'],
            ['title' => 'Bumi Manusia', 'author' => 'Pramoedya Ananta Toer', 'category' => 'Novel', 'publisher' => 'Hasta Mitra', 'year' => 1980, 'isbn' => '9789799731234'],
            ['title' => 'Negeri 5 Menara', 'author' => 'Ahmad Fuadi', 'category' => 'Novel', 'publisher' => 'Gramedia Pustaka Utama', 'year' => 2009, 'isbn' => '9789792254860'],
            ['title' => 'Ayat-Ayat Cinta', 'author' => 'Habiburrahman El Shirazy', 'category' => 'Novel', 'publisher' => 'Republika', 'year' => 2004, 'isbn' => '9789793210605'],
            ['title' => 'Sang Pemimpi', 'author' => 'Andrea Hirata', 'category' => 'Novel', 'publisher' => 'Bentang Pustaka', 'year' => 2006, 'isbn' => '9789793062921'],
            ['title' => 'Atomic Habits', 'author' => 'James Clear', 'category' => 'Pengembangan Diri', 'publisher' => 'Gramedia Pustaka Utama', 'year' => 2019, 'isbn' => '9786020633176'],
            ['title' => 'Filosofi Teras', 'author' => 'Henry Manampiring', 'category' => 'Pengembangan Diri', 'publisher' => 'Kompas', 'year' => 2018, 'isbn' => '9786024125189'],
            ['title' => 'The Psychology of Money', 'author' => 'Morgan Housel', 'category' => 'Bisnis', 'publisher' => 'Harriman House', 'year' => 2020, 'isbn' => '9780857197689'],
            ['title' => 'Rich Dad Poor Dad', 'author' => 'Robert T. Kiyosaki', 'category' => 'Bisnis', 'publisher' => 'Plata Publishing', 'year' => 1997, 'isbn' => '9781612680194'],
            ['title' => 'Clean Code', 'author' => 'Robert C. Martin', 'category' => 'Teknologi', 'publisher' => 'Prentice Hall', 'year' => 2008, 'isbn' => '9780132350884'],
            ['title' => 'Design Patterns', 'author' => 'Erich Gamma', 'category' => 'Teknologi', 'publisher' => 'Addison-Wesley', 'year' => 1994, 'isbn' => '9780201633610'],
            ['title' => 'Introduction to Algorithms', 'author' => 'Thomas H. Cormen', 'category' => 'Teknologi', 'publisher' => 'MIT Press', 'year' => 2009, 'isbn' => '9780262033848'],
            ['title' => 'Sejarah Indonesia Modern', 'author' => 'M. C. Ricklefs', 'category' => 'Sejarah', 'publisher' => 'Serambi', 'year' => 2008, 'isbn' => '9789790241152'],
            ['title' => 'Sapiens', 'author' => 'Yuval Noah Harari', 'category' => 'Sejarah', 'publisher' => 'Kepustakaan Populer Gramedia', 'year' => 2017, 'isbn' => '9786024244163'],
            ['title' => 'A Brief History of Time', 'author' => 'Stephen Hawking', 'category' => 'Sains', 'publisher' => 'Bantam Books', 'year' => 1988, 'isbn' => '9780553380163'],
            ['title' => 'The Selfish Gene', 'author' => 'Richard Dawkins', 'category' => 'Sains', 'publisher' => 'Oxford University Press', 'year' => 1976, 'isbn' => '9780198788607'],
            ['title' => 'Harry Potter and the Sorcerer Stone', 'author' => 'J. K. Rowling', 'category' => 'Fantasi', 'publisher' => 'Scholastic', 'year' => 1997, 'isbn' => '9780590353427'],
            ['title' => 'The Hobbit', 'author' => 'J. R. R. Tolkien', 'category' => 'Fantasi', 'publisher' => 'George Allen & Unwin', 'year' => 1937, 'isbn' => '9780547928227'],
        ];

        foreach ($books as $bookData) {
            $category = Category::query()->firstOrCreate(['name' => $bookData['category']]);
            $author = Author::query()->firstOrCreate(['name' => $bookData['author']]);

            $book = Book::query()->updateOrCreate([
                'isbn' => $bookData['isbn'],
            ], [
                'category_id' => $category->id,
                'title' => $bookData['title'],
                'publisher' => $bookData['publisher'],
                'published_year' => $bookData['year'],
                'total_copies' => 5,
                'description' => 'Koleksi perpustakaan untuk katalog awal Angop Library.',
            ]);

            $book->authors()->syncWithoutDetaching([$author->id]);
        }
    }
}
