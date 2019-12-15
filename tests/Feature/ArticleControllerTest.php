<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class ArticleControllerTest extends TestCase
{

    use RefreshDatabase;

    public function testStore_HttpAndDataOK()
    {
        Storage::fake('images');
        $response = $this->json('POST', 'articles', [
            "title" => "關於文章",
            "content" => "cccd",
            "category_id" => 47,
            "status" => true,
            "images" => UploadedFile::fake()->image('avatar.jpg'),
            "tag_ids"  =>   [
                101,
                900
            ],
        ]);
        $data = json_decode($response->content(), true);
        $this->assertNotEmpty($data['images']);
        $response
            ->assertStatus(200)
            ->assertJson([
                "title" => "關於文章",
                "content" => "cccd",
                "category_id" => 47,
                "status" => true,
                "tags"  =>  [
                    [
                        "id"    =>  101
                    ],
                    [
                        "id"    =>  900
                    ]
                ]
            ]);
    }

    public function testUpdate_HttpOk()
    {
        $response = $this->json('PUT', 'articles', [
            "id" => 101,
            "title" => "PHP學習",
            "content" => "cccc",
            "category_id" => 22,
            "status" =>true,
            "images" =>  "empty",
            'tags' => [
                [
                    "tag_id"    =>  900,
                ],
                [
                    "tag_id"    =>  101,
                ]
            ]
        ]);


        $response->assertStatus(200)
            ->assertJson([
                "id" => 101,
                "title" => "PHP學習",
                "content" => "cccc",
                "status" =>true,
                "images" =>"empty",
                "category" => [
                    "id"    =>  22
                ],
                'tags' => [
                    [
                        "id"    =>  900,
                    ],
                    [
                        "id"    =>  101,

                    ]
                ]
            ]);
    }

    public function testUpdateUploadFile_HttpAndFileDataOk()
    {
        Storage::fake(config("filesystems.default"));
        Storage::put("files/dVZiwOcl4mudQTt5LxHjLiE4NLyrjoNDGpwCYRen.jpeg", "132145646546");
        $response = $this->json('PUT', 'articles', [
            "id" => 101,
            "title" => "關於文章",
            "content" => "cccd",
            "category_id" => 47,
            "status" => true,
            "images" => UploadedFile::fake()->image('file.jpg'),
        ]);
        $data = json_decode($response->content(), true);
        $this->assertNotEmpty($data['images']);
        Storage::assertMissing('files/dVZiwOcl4mudQTt5LxHjLiE4NLyrjoNDGpwCYRen.jpeg');
        $response->assertStatus(200)
                  ->assertJson([
                      "title" => "關於文章",
                      "content" => "cccd",
                      "category_id" => 47,
                      "status" => true
        ]);
    }


    public function testUpdateCancelAllTag_HttpAnDataOk()
    {
        $response = $this->json('PUT', 'articles', [
            "id" => 101,
            "title" => "PHP學習",
            "content" => "cccc",
            "category_id" => 22,
            "status" =>true,
            "images" => UploadedFile::fake()->image('file.jpg'),
            'tags' => []
        ]);

        $data = json_decode($response->content(), true);

        $response->assertStatus(200);

        $this->assertEmpty($data['tags']);
    }

    public function testGet_HttpAndDataOk()
    {
        $response = $this->json('GET', 'articles', [
            [
                'id' => 54,
                "category_id" => 22,
                "status" =>1,
                "images" => UploadedFile::fake()->image('file.jpg'),
            ],

        ]);

        $response->assertStatus(200)
            ->assertJson([
                [
                    'id' =>  54,
                    "title" =>"PHP",
                    "content" =>"你好啊",
                    "status" =>1,
                    "images" => UploadedFile::fake()->image('file.jpg'),
                    'category'  => [
                        "id"    =>  22,
                        "name"  =>  "JAVA",
                    ]
                ],
                [
                    'id'    =>  101,
                    'category'  => [
                        "id"    =>  34
                    ],
                    'tags'  =>  [
                        [
                            "id"    =>  101
                        ],
                        [
                            "id"    =>  900
                        ]
                    ]
                ]
            ]);
    }

    public function testDestroy_HttpAndDateOk()
    {
        $response = $this->json('DELETE', 'articles', [
            'id' => 54,
        ]);

        $response->assertStatus(200);

    }


}


