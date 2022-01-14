<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@mail.com',
                'password' => bcrypt('admin'),
                'role' => 'admin',
                'avatar' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User',
                'username' => 'user',
                'email' => 'user@mail.com',
                'password' => bcrypt('user'),
                'role' => 'member',
                'avatar' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
