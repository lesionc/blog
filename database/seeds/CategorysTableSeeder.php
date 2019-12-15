<?php

use Illuminate\Database\Seeder;
use App\Category;
class CategorysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            "id"    =>  2,
            "name"  => "PHP",
            "status" => true,
        ]);
        Category::create([
            "id"    =>  22,
            "name"  =>  "JAVA",
            "status" => true,

        ]);
        Category::create([
            "id"    =>  34,
            "name"  =>  "JS",
            "status" => true,

        ]);

        Category::create([
            "id"    =>  100,
            "name"  =>  "JS",
            "status" =>true,
        ]);

    }
}
