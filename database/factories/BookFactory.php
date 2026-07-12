<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'publisher' => fake()->company(),
            'published_year' => fake()->year(),
            'total_copies' => fake()->numberBetween(1, 10),
            'isbn' => fake()->unique()->isbn13(),
            'description' => fake()->paragraph(),
        ];
    }
}
