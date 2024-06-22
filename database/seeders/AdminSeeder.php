<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            Admin::create([
                'fullname' => 'Ishan Subedi',
                'username' => 'ishansubedi',
                'email' => 'ishan@gmail.com',
                'password' => Hash::make('password123'),
                'countrycode' => '977',
                'mobile_number' => '9819102361',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            Admin::create([
                'fullname' => 'Swachita Gurung',
                'username' => 'swachitagurung',
                'email' => 'swachita@.com',
                'password' => Hash::make('password123'),
                'countrycode' => '977',
                'mobile_number' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            Admin::create([
                'fullname' => 'Pramod Gurung',
                'username' => 'pramodgurung',
                'email' => 'pramod@gmail.com',
                'password' => Hash::make('password123'),
                'countrycode' => '977',
                'mobile_number' => '1235123412',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

    }
}
