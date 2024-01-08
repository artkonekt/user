<?php

declare(strict_types=1);

namespace Konekt\User\Tests\Factories;

use Faker\Generator as Faker;
use Konekt\Address\Models\Person;

$factory->define(Person::class, function (Faker $faker) {
    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName
    ];
});