<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $org = Organization::first();

        User::create([
            'org_id' => $org->id,
            'username' => 'student1',
            'name' => 'Student 1',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);
    }
}
