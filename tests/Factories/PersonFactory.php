<?php

declare(strict_types=1);

namespace Konekt\User\Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Konekt\Address\Models\Person;

class PersonFactory extends Factory
{
    protected $model = Person::class;

    public function definition(): array
    {
        return [
            'firstname' => fake()->firstName,
            'lastname' => fake()->lastName,
        ];
    }
}
