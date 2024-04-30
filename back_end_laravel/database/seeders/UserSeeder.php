<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            User::create([
                'name' => 'Đinh Văn Huy',
                'email' => 'huydinhvan13@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('12345'),
                'role'=> 'admin',
            ]);
            User::create([
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'avatar' => 'images/avatardefault.png',
                'password' => bcrypt('12345'),
                'role'=> 'admin',
            ]);
            User::create([
                'name' => 'admin',
                'email' => 'admin2@gmail.com',
                'email_verified_at' => now(),
                'avatar' => 'images/avatardefault.png',
                'password' => bcrypt('12345'),
                'role'=> 'admin',
            ]);
            User::create([
                'name' => 'client1',
                'email' => 'client1@gmail.com',
                'email_verified_at' => now(),
                'avatar' => 'images/avatardefault.png',
                'password' => bcrypt('12345'),
                'role'=> 'client',
            ]);
            User::create([
                'name' => 'client2',
                'email' => 'client2@gmail.com',
                'email_verified_at' => now(),
                'avatar' => 'images/avatardefault.png',
                'password' => bcrypt('12345'),
                'role'=> 'client',
            ]);
        } catch (\Throwable $th) {
        }
        
    }
}
