<?php

use Illuminate\Database\Seeder;
use App\Tag;
class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::create([
            "id"    =>  54,
            "name"  => "BB"
        ]);
        Tag::create([
            "id"    =>  101,
            "name"=>"CC",
        ]);
        Tag::create([
            "id"    =>  900,
            "name"  =>  "DD"
        ]);
    }

}
