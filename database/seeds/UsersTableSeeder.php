<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role_id' => '1',
            'name' => 'Admin',
            'username' => 'dantam',
            'email' => 'dtamdp@gmail.com',
            'phone' => '0963262877',
            'password' => bcrypt('120584'),
        ]);

        DB::table('users')->insert([
            'role_id' => '2',
            'name' => 'Author',
            'username' => 'hongchau',
            'email' => 'ngthihongchau@gmail.com',
            'phone' => '0987767995',
            'password' => bcrypt('130181'),
        ]);
    }
}
