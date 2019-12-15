<?php

use Illuminate\Database\Seeder;
use App\Article;
class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Article::create([
            "id"    =>  54,
            "title"  => "PHP",
             "content"=>"你好啊",
            "category_id" => 22,
            "status" => true,
            "images" => null

        ]);
        Article::create([
            "id"    =>  101,
            "content"=>"你好啊",
            "title"  =>  "JAVA",
            "category_id" => 34,
            "status" => true,
            "images" => "files/dVZiwOcl4mudQTt5LxHjLiE4NLyrjoNDGpwCYRen.jpeg"
        ]);
        Article::create([
            "id"    =>  900,
            "content"=>"你好啊",
            "title"  =>  "JS",
            "category_id" => 34,
            "status" => true,
            "images" => null
        ]);
    }
}
