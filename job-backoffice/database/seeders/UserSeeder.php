<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'email'             => 'a@gmail.com',
            'name'              => 'admin',
            'email_verified_at' => now(),
            'password'          => Hash::make('12345678'), // password
            'remember_token'    => Str::random(10),
            'role'              => 'admin',
        ]);
         User::create([
            'email'             => 'aa@gmail.com',
            'name'              => 'koko',
            'email_verified_at' => now(),
            'password'          => Hash::make('12345678'), // password
            'remember_token'    => Str::random(10),
            'role'              => 'company-owner',
        ]);
         User::create([
            'email'             => 'aaa@gmail.com',
            'name'              => 'koko',
            'email_verified_at' => now(),
            'password'          => Hash::make('12345678'), // password
            'remember_token'    => Str::random(10),
            'role'              => 'job-seeker',
        ]);
    }
}
