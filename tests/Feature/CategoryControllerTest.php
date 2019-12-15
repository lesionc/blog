<?php

namespace Tests\Feature;

use App\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryControllerTest extends TestCase
{

    use RefreshDatabase;

    public function testStore_HttpAndDataOK()
    {
        $response = $this ->json('POST','categorys',[
            "name" => "phcp",
            "status" =>true,
        ]);


        $response
        ->assertStatus(200)
        ->assertJson([
            "name" => "phcp",
            "status" =>1,
        ]);
    }

    public function testUpdate_HttpOk(){
        $response = $this ->json('PUT','categorys',[
            "id"    =>  22,
            "name"  =>  "JAVA",
            "status" => true
        ]);
        $response->assertStatus(200)
                 ->assertJson([
                     "id"    =>  22,
                     "name"  =>  "JAVA",
                     "status" => true
                 ]);
    }

    public function testGet_HttpOk(){
        $response =$this ->json('GET','categorys',[
            [['id' =>2,
             'name' => 'PHP',
              'status' => 1
            ]]
        ]);
        $response->assertStatus(200)
                 ->assertJson([
                     [
                         'id' =>2,
                         'name' => 'PHP',
                         'status' => 1
                     ]
                ] );
    }

    public function testDrop_HttpOk()
    {
      $response = $this ->json('DELETE','categorys',[
            'id'    => 2
      ]);

      $response->assertStatus(200);
    }

    public function testDropExistArticle_HttpError()
    {
        $response = $this ->json('DELETE','categorys',[
            'id'    => 34
        ]);
        $response->assertStatus(500);
    }


    public function testDropExistArticle_HttpOK()
    {
        $response = $this ->json('DELETE','categorys',[
            'id'    => 100
        ]);

        $response->assertStatus(200);
    }

}
