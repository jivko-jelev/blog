<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<1000; $i++) {
            DB::table('comments')->insert([
                'message' => 'Paginating Query Builder Results',
                'user_id' => rand(1, count(App\User::all())),
                'blog_id' => rand(1, count(App\Blog::all())),
                'created_at' => Carbon\Carbon::create(2000 + rand(1, 17), rand(1, 12), rand(1, 28), rand(0,23), rand(0,59), rand(0,59))
            ]);
        }
    }
}
