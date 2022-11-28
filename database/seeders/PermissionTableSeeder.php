<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(['id' => 1 , 'name' => 'registerUser' , 'guard_name' => config('backpack.base.guard')]);
        DB::table('roles')->insert(['id' => 2 , 'name' => 'assignPermission' , 'guard_name' => config('backpack.base.guard')]);
        DB::table('roles')->insert(['id' => 3 , 'name' => 'writeNews' , 'guard_name' => config('backpack.base.guard')]);
        DB::table('roles')->insert(['id' => 4 , 'name' => 'registerBranch' , 'guard_name' => config('backpack.base.guard')]);

    }
}
