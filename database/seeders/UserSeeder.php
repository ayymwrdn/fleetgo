<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@fleetgo.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'approval_level' => null,
            ],
            [
                'name' => 'Sissy Nuraini',
                'email' => 'sissy@fleetgo.com',
                'password' => Hash::make('password'),
                'role' => 'approver',
                'approval_level' => 1,
            ],
            [
                'name' => 'Ayudya Kusumawardani',
                'email' => 'ayudya@fleetgo.com',
                'password' => Hash::make('password'),
                'role' => 'approver',
                'approval_level' => 2,
            ],
            [
                'name' => 'Manager Pool',
                'email' => 'manager@fleetgo.com',
                'password' => Hash::make('password'),
                'role' => 'approver',
                'approval_level' => 1,
            ],
            [
                'name' => 'Direktur Utama',
                'email' => 'direktur@fleetgo.com',
                'password' => Hash::make('password'),
                'role' => 'approver',
                'approval_level' => 2,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}