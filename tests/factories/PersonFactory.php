<?php

use Faker\Generator as Faker;
use Konekt\Address\Models\Person;

$factory->define(Person::class, function (Faker $faker) {
    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName
    ];
});
