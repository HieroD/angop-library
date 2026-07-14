<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use App\Models\ReturnRecord;
use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class LibraryWorkflowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staff = Staff::query()->firstOrCreate([
            'email' => 'admin@gmail.com',
        ], [
            'name' => 'Admin',
            'password' => 'adminadmin',
        ]);

        $members = $this->members($staff);
        $books = Book::query()->take(10)->get();

        if ($books->count() < 10) {
            $this->call(BookSeeder::class);
            $books = Book::query()->take(10)->get();
        }

        $this->pendingBorrowings($members, $books, $staff);
        $this->activeBorrowings($members, $books, $staff);
        $this->returnHistory($members, $books, $staff);
    }

    /**
     * @return Collection<int, Member>
     */
    private function members(Staff $staff): Collection
    {
        return collect([
            ['member_code' => 'MBR-101', 'name' => 'Ahmad Fauzi', 'email' => 'ahmad.fauzi@example.com', 'phone' => '081234567101'],
            ['member_code' => 'MBR-102', 'name' => 'Siti Rahma', 'email' => 'siti.rahma@example.com', 'phone' => '081234567102'],
            ['member_code' => 'MBR-103', 'name' => 'Budi Santoso', 'email' => 'budi.santoso@example.com', 'phone' => '081234567103'],
            ['member_code' => 'MBR-104', 'name' => 'Imam', 'email' => 'imam@gmail.com', 'phone' => '087777777777'],
        ])->map(fn (array $member): Member => Member::query()->updateOrCreate([
            'email' => $member['email'],
        ], $member + [
            'staff_id' => $staff->id,
            'password' => match ($member['email']) {
                'imam@gmail.com' => 'imam1234',
                default => 'password',
            },
            'gender' => match ($member['email']) {
                'imam@gmail.com' => 'M',
                default => fake('id_ID')->randomElement(['M', 'F']),
            },
            'date_of_birth' => fake('id_ID')->date('Y-m-d', '-18 years'),
            'address' => match ($member['email']) {
                'imam@gmail.com' => 'Jalan KungKingKang Nomor 67',
                default => fake('id_ID')->address(),
            },
        ]));
    }

    /**
     * @param  Collection<int, Member>  $members
     * @param  Collection<int, Book>  $books
     */
    private function pendingBorrowings(Collection $members, Collection $books, Staff $staff): void
    {
        foreach (range(0, 2) as $index) {
            Borrowing::query()->updateOrCreate([
                'member_id' => $members[$index % $members->count()]->id,
                'book_id' => $books[$index % $books->count()]->id,
                'status' => 'menunggu konfirmasi',
            ], [
                'staff_id' => $staff->id,
                'borrow_date' => now()->subDays($index),
                'due_date' => now()->addDays(7),
                'returned_at' => null,
            ]);
        }
    }

    /**
     * @param  Collection<int, Member>  $members
     * @param  Collection<int, Book>  $books
     */
    private function activeBorrowings(Collection $members, Collection $books, Staff $staff): void
    {
        foreach (range(0, 2) as $index) {
            Borrowing::query()->updateOrCreate([
                'member_id' => $members[$index % $members->count()]->id,
                'book_id' => $books[($index + 3) % $books->count()]->id,
                'status' => 'dipinjam',
            ], [
                'staff_id' => $staff->id,
                'borrow_date' => now()->subDays($index + 2),
                'due_date' => now()->addDays($index + 1),
                'returned_at' => null,
            ]);
        }

        foreach (range(0, 2) as $index) {
            Borrowing::query()->updateOrCreate([
                'member_id' => $members[($index + 4) % $members->count()]->id,
                'book_id' => $books[($index + 7) % $books->count()]->id,
                'status' => 'terlambat',
            ], [
                'staff_id' => $staff->id,
                'borrow_date' => now()->subDays($index + 12),
                'due_date' => now()->subDays($index + 1),
                'returned_at' => null,
            ]);
        }
    }

    /**
     * @param  Collection<int, Member>  $members
     * @param  Collection<int, Book>  $books
     */
    private function returnHistory(Collection $members, Collection $books, Staff $staff): void
    {
        foreach (range(0, 2) as $index) {
            $borrowing = Borrowing::query()->updateOrCreate([
                'member_id' => $members[$index % $members->count()]->id,
                'book_id' => $books[($index + 10) % $books->count()]->id,
                'status' => 'dikembalikan',
            ], [
                'staff_id' => $staff->id,
                'borrow_date' => now()->subDays($index + 20),
                'due_date' => now()->subDays($index + 10),
                'returned_at' => now()->subDays($index + 2),
            ]);

            $fineAmount = $index % 2 === 0 ? 0 : ($index + 1) * 1000;

            ReturnRecord::query()->updateOrCreate([
                'borrowing_id' => $borrowing->id,
            ], [
                'staff_id' => $staff->id,
                'return_date' => $borrowing->returned_at,
                'fine_amount' => $fineAmount,
                'paid_amount' => 0,
                'payment_status' => $fineAmount > 0 ? 'unpaid' : 'paid',
                'fine_reason' => $fineAmount > 0 ? 'Terlambat '.($index + 1).' hari' : null,
            ]);
        }
    }
}
