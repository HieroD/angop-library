<?php

namespace Database\Factories;

use App\Models\Borrowing;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Borrowing>
 */
class BorrowingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'borrow_date' => now(),
            'due_date' => now()->addDays(14),
            'status' => 'menunggu konfirmasi',
        ];
    }
}
