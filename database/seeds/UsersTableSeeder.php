<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        if(App\User::first() === null) {
            DB::table('users')->insert([
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'admin' => true,
                'gender' => 2,
                'password' => bcrypt('admin@admin.com'),
                'created_at' => Carbon\Carbon::create(2000 + rand(1, 17), rand(1, 12), rand(1, 28), 0, 0, 0)
            ]);
        }
        for($i=0; $i<10; $i++){
            DB::table('users')->insert([
                'name' => str_random(10),
                'email' => str_random(10) . '@gmail.com',
                'gender' => rand(1, 2),
                'password' => bcrypt('secret'),
                'created_at' => Carbon\Carbon::create(2000 + rand(1, 17), rand(1, 12), rand(1, 28), 0, 0, 0)
            ]);
        }
    }
}
