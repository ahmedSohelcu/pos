<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Prepare user seed
        $users = [
            [
                'name' => 'Ahmed Rahman',
                'email' => 'ahmed1@example.com',
                'phone' => '01710000001',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Karim Hasan',
                'email' => 'karim2@example.com',
                'phone' => '01710000002',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Rafiul Islam',
                'email' => 'rafiul3@example.com',
                'phone' => '01710000003',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Sabbir Hossain',
                'email' => 'sabbir4@example.com',
                'phone' => '01710000004',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Tanvir Ahmed',
                'email' => 'tanvir5@example.com',
                'phone' => '01710000005',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Nusrat Jahan',
                'email' => 'nusrat6@example.com',
                'phone' => '01710000006',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Mithila Akter',
                'email' => 'mithila7@example.com',
                'phone' => '01710000007',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Fahim Chowdhury',
                'email' => 'fahim8@example.com',
                'phone' => '01710000008',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Arif Hossain',
                'email' => 'arif9@example.com',
                'phone' => '01710000009',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Jannat Ara',
                'email' => 'jannat10@example.com',
                'phone' => '01710000010',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Imran Khan',
                'email' => 'imran11@example.com',
                'phone' => '01710000011',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Farzana Rahman',
                'email' => 'farzana12@example.com',
                'phone' => '01710000012',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Rakibul Hasan',
                'email' => 'rakib13@example.com',
                'phone' => '01710000013',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Sumaiya Islam',
                'email' => 'sumaiya14@example.com',
                'phone' => '01710000014',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Shakib Al Hasan',
                'email' => 'shakib15@example.com',
                'phone' => '01710000015',
                'password' => Hash::make('password123'),
            ],
        ];
        User::insert($users);
    }
}
