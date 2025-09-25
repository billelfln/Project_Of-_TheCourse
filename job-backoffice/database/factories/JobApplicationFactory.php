<?php

namespace Database\Factories;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\Resumy;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobApplicationFactory extends Factory
{
    protected $model = JobApplication::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'status' => $this->faker->randomElement(['pending', 'accepted', 'rejected']),
            'aiGeneratedScore' => $this->faker->randomFloat(2, 0, 100),
            'aiGeneratedFeedback' => $this->faker->paragraph(),
            'jobVacancyId' => JobVacancy::factory(),
            'resumeId' => Resumy::factory(),
            'userId' => User::factory(),
        ];
    }
}
