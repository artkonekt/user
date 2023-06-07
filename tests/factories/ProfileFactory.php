<?php

declare(strict_types=1);

use Faker\Generator as Faker;
use Konekt\Address\Models\Person;
use Konekt\User\Models\Profile;
use Konekt\User\Models\User;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'person_id' => function () {
            return factory(Person::class)->create()->id;
        }
    ];
});
