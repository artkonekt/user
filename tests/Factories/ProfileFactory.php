<?php

declare(strict_types=1);

namespace Konekt\User\Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Konekt\User\Models\Profile;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition(): array
    {
        return [
            'user_id' => UserFactory::new(),
            'person_id' => PersonFactory::new(),
        ];
    }
}
