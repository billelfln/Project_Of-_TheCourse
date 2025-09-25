<?php

namespace Database\Seeders;

use App\Models\Resumy;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\JobCategory;
use App\Models\Company;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Models\JobApplication;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        // ======================
        // CREATE ADMIN USER
        // ======================
        $this->call(UserSeeder::class);

        // ======================
        // SEED JOBS DATA (004)
        // ======================
        $path = database_path('data/004 job-data.json');
        if (!file_exists($path)) {
            $this->command->error("JSON file not found: $path");
            return;
        }

        $jobsData = json_decode(file_get_contents($path), true);

        if (!$jobsData) {
            $this->command->error("Invalid JSON format in: $path");
            return;
        }

        // 1) Seed categories
        foreach ($jobsData['jobCategories'] as $categoryName) {
            JobCategory::firstOrCreate(['name' => $categoryName]);
        }

        // 2) Seed companies
        foreach ($jobsData['companies'] as $companyData) {
            $companyOnwner = User::firstOrCreate(
                ['email' => $companyData['email']],
                [
                    'name' => $companyData['ownerName'] ?? 'Default Owner',
                    'password' => bcrypt('password'), // Default password
                    'role' => 'company-owner',
                    'email_verified_at' => now(),
                ]
            );
            Company::firstOrCreate(
                ['name' => $companyData['name']],
                [
                    'address' => $companyData['address'] ?? null,
                    'industry' => $companyData['industry'] ?? 'Technology',
                    'website' => $companyData['website'] ?? null,

                    'ownerId' => $companyOnwner->id,
                ]
            );
        }

        // 3) Seed vacancies
        foreach ($jobsData['jobVacancies'] as $job) {
            //method one 
            // $category = JobCategory::firstOrCreate(['name' => $job['category']]);
            // $company = Company::firstOrCreate(['name' => $job['company']]);
            //method two
            $category = JobCategory::where('name', $job['category'])->first();
            $company = Company::where('name', $job['company'])->first();
            JobVacancy::create([
                'title' => $job['title'],
                'description' => $job['description'],
                'location' => $job['location'] ?? null,
                'type' => $job['type'] ?? 'Full-Time',
                'salary' => $job['salary'] ?? null,
                'jobCategoryId' => $category->id,
                'companyId' => $company->id,
            ]);
        }


        // ======================
        // SEED JOB APPLICATIONS (005)
        // ======================
        $path = database_path('data/004 job-applications.json');
        if (!file_exists($path)) {
            $this->command->error("JSON file not found: $path");
            return;
        }

        $data = json_decode(file_get_contents($path), true);

        if (!isset($data['jobApplications'])) {
            $this->command->error("Invalid JSON structure: 'jobApplications' key missing.");
            return;
        }

        foreach ($data['jobApplications'] as $applicationData) {
            // Save Resume
            $resumeData = $applicationData['resume'];
            $user = User::inRandomOrder()->first();

            $resume = Resumy::create([
                'filename' => $resumeData['filename'],
                'fileUrl' => $resumeData['fileUri'],
                'contactDetails' => $resumeData['contactDetails'],
                'summary' => $resumeData['summary'],
                'skills' => $resumeData['skills'],
                'experience' => $resumeData['experience'],
                'education' => $resumeData['education'],
                'userId' => $user->id,
            ]);

            // Save Job Application
            JobApplication::create([
                'status' => $applicationData['status'],
                'aiGeneratedScore' => $applicationData['aiGeneratedScore'],
                'aiGeneratedFeedback' => $applicationData['aiGeneratedFeedback'],
                'resumeId' => $resume->id,
                'userId' => $user->id,
                'jobVacancyId' => JobVacancy::inRandomOrder()->first()->id,
            ]);
        }

        $this->command->info("Job applications seeded successfully!");


    }
}

