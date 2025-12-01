<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'cpf' => fake()->numerify('###.###.###-##'),
            'email' => fake()->unique()->safeEmail(),
            'birth_date' => fake()->date(),
            'phone_number' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'uf_id' => fake()->numberBetween(11, 53),
            'city_id' => fake()->numberBetween(1000, 5000),
        ];
    }
}
