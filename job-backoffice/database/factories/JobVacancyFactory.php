<?php

namespace Database\Factories;

use App\Models\JobVacancy;
use App\Models\JobCategory;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobVacancyFactory extends Factory
{
    protected $model = JobVacancy::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->paragraph(),
            'location' => $this->faker->city(),
            'salary' => $this->faker->randomFloat(2, 1000, 10000),
            'type' => $this->faker->randomElement(['Full-Time', 'Contract', 'Remote', 'hybrid']),
            'jobCategoryId' => JobCategory::factory(),
            'companyId' => Company::factory(),
        ];
    }
}
