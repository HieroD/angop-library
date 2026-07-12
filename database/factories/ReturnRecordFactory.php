<?php

namespace Database\Factories;

use App\Models\ReturnRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ReturnRecord>
 */
class ReturnRecordFactory extends Factory
{
    public function definition(): array
    {
        return [
            'return_date' => now(),
            'fine_amount' => 0.00,
            'payment_status' => 'unpaid',
        ];
    }
}
