<?php

namespace App\Actions\Catalog;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use DomainException;
use Illuminate\Support\Facades\DB;

class CreateBorrowing
{
    public function handle(Member $member, Book $book): Borrowing
    {
        return DB::transaction(function () use ($member, $book): Borrowing {
            if ($book->total_copies < 1) {
                throw new DomainException('Stok buku habis.');
            }

            $exists = Borrowing::query()
                ->where('member_id', $member->id)
                ->where('book_id', $book->id)
                ->whereIn('status', ['menunggu konfirmasi', 'dipinjam', 'terlambat'])
                ->exists();

            if ($exists) {
                throw new DomainException('Anda masih memiliki peminjaman aktif untuk buku ini.');
            }

            $borrowing = Borrowing::query()->create([
                'book_id' => $book->id,
                'member_id' => $member->id,
                'staff_id' => null,
                'borrow_date' => now(),
                'status' => 'menunggu konfirmasi',
            ]);

            $book->decrement('total_copies');

            return $borrowing;
        });
    }
}
