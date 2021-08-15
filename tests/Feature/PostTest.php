<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class PostTest extends TestAbstract
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(UserSeeder::class);
    }


    public function testCreate(): void
    {
        $token = $this->token('user1@mail.ru');

        $response = $this->postJson(
            'api/posts',
            [
                'title' => 'post1',
                'message' => 'post1',
            ],
            [
                'Authorization' => $token
            ]
        );

        $postCountUser = DB::table('users_posts')->where('post_id', $response->json('id'))->count();

        $response->assertStatus(200);

        $this->assertDatabaseHas('posts', [
            'user_id' => '00000000-0000-0000-0000-000000000001',
            'title' => 'post1',
            'message' => 'post1'
        ]);

        self::assertEquals(2, $postCountUser);
    }

    public function testRead(): void
    {
        DB::table('users_posts')->delete();

        $token = $this->token('user1@mail.ru');

        $this->postJson(
            'api/posts',
            [
                'title' => 'post1',
                'message' => 'post1',
            ],
            [
                'Authorization' => $token
            ]
        );

        $response = $this->getJson(
            'api/posts',
            [
                'Authorization' => $token
            ]
        );

        self::assertCount(1, $response->json());

        $response = $this->getJson(
            'api/posts',
            [
                'Authorization' => $this->token('user2@mail.ru')
            ]
        );

        self::assertCount(1, $response->json());
    }
}
