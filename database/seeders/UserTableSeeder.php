<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => '1',
            'username' => 'reza' , 
            'first_name' => 'reza',
            'last_name' => 'akhoundi',
            'job_title' => 'manager',
            'password' => '123456789',
        ]);
    }
}
