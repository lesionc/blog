<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagControllerTest extends TestCase
{
    use RefreshDatabase;
    public function testStore_HttpAndDataOK()
    {
        $response = $this->json('POST', 'tags', [
            "name"  => "PHP"
        ]);
        $response
            ->assertStatus(200)
            ->assertJson([

                "name"  => "PHP"
            ]);
    }

    public function testUpdate_HttpAndDataOK()
    {
        $response = $this->json('PUT', 'tags', [
            "id"    =>  54,
            "name"  => "PHP"
        ]);

        $response
            ->assertStatus(200);

    }

    public function testGet_HttpAndDataOK()
    {
        $response = $this->json('GET', 'tags', [
            [
                "id"    =>  54,

        ]
        ]);
        $response->assertStatus(200)
                ->assertJson([
                [
                    "id"    =>  54,

                ]
            ]);
    }
    public function testDestroy_HttpAndDateOk(){
        $response = $this->json('DELETE', 'tags', [
            "id" => 54
        ]);
        $response->assertStatus(200);
    }
}
