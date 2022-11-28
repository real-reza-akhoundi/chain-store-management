<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(['id' => 1,'name' => 'general manager' , 'guard_name' => config('backpack.base.guard')]);
        DB::table('roles')->insert(['id' => 2,'name' => 'manager' , 'guard_name' => config('backpack.base.guard')]);
        DB::table('roles')->insert(['id' => 3,'name' => 'employee' , 'guard_name' => config('backpack.base.guard')]);
    }
}
