<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $this->call(CategorysTableSeeder::class);
        $this->call(ArticleTableSeeder::class);
        $this->call(TagTableSeeder::class);
        $this->call(ArticleTagTableSeeder::class);
    }
}
