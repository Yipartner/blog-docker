<?php

use Illuminate\Database\Seeder;

class addAdminUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \Illuminate\Support\Facades\DB::table('users')->insert([
            'name'=>config('app.name'),
            'email'=>config('app.admin_email'),
            'password'=>bcrypt('app.admin_password'),
            'is_admin'=>1
        ]);
    }
}
