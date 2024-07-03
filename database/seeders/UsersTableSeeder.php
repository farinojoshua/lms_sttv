<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin', // Mengisi kolom role dengan 'admin'
        ]);

        // Lecturer User
        User::create([
            'name' => 'Lecturer User',
            'email' => 'lecturer@example.com',
            'password' => Hash::make('password'),
            'role' => 'lecturer', // Mengisi kolom role dengan 'lecturer'
        ]);

        // Student User
        User::create([
            'name' => 'Student User',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'role' => 'student', // Mengisi kolom role dengan 'student'
        ]);
    }
}
