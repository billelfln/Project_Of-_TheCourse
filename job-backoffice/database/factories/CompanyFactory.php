<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'name' => $this->faker->company(),
            'address' => $this->faker->address(),
            'industry' => $this->faker->word(),
            'website' => $this->faker->url(),
            'ownerId' => User::factory(), // يرتبط بـ User
        ];
    }
}
