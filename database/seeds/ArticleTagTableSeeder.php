<?php

use Illuminate\Database\Seeder;

class ArticleTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\ArticleTag::create([
            "article_id"    =>  101,
            "tag_id"    => 101
        ]);

        \App\ArticleTag::create([
            "article_id"    =>  101,
            "tag_id"    => 900
        ]);
    }
}
