<?php

namespace Database\Factories;

use App\Models\Resumy;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResumyFactory extends Factory
{
    protected $model = Resumy::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'fileName' => $this->faker->word() . '.pdf',
            'fileUrl' => $this->faker->url(),
            'contactDetails' => $this->faker->phoneNumber(),
            'summary' => $this->faker->paragraph(),
            'skills' => implode(', ', $this->faker->words(5)),
            'experience' => $this->faker->text(),
            'education' => $this->faker->sentence(),
            'userId' => User::factory(),
        ];
    }
}
