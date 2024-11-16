<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name' => 'Administrator',
            'email' => 'adminapotek@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('admin123')
        ]);

        User::create([
            'name' => 'Administrator',
            'email' => 'adminapotek1@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('admin1234')
        ]);

        User::create([
            'name' => 'Kasir',
            'email' => 'kasirapotek@gmail.com',
            'role' => 'kasir',
            'password' => Hash::make('kasir123')
        ]);

        User::create([
            'name' => 'Kasir1',
            'email' => 'kasirapotek1@gmail.com',
            'role' => 'kasir',
            'password' => Hash::make('kasir1234')
        ]);
    }
}
