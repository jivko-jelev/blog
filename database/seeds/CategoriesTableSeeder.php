<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(App\Category::first() === null) {
            $categories = ['Laravel', 'PHP', 'Linux', 'Security'];
            for ($i = 0; $i < count($categories); $i++) {
                DB::table('categories')->insert([
                    'title' => $categories[$i],
                    'parent_id' => null,
                ]);
            }
        }
    }
}
