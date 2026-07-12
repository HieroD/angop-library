<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<Member>
 */
class MemberFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'member_code' => fake()->unique()->numerify('MEM####'),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'phone' => fake()->phoneNumber(),
            'gender' => fake()->randomElement(['M', 'F']),
            'date_of_birth' => fake()->date(),
            'address' => fake()->address(),
        ];
    }
}
