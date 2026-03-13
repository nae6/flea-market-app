<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'test桃子',
                'email' => 'testmomoko@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('testmomoko'),
            ],
            [
                'name' => 'test太郎',
                'email' => 'testtarou@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('testtarou'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
