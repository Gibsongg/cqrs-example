<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserFollowerTest extends TestAbstract
{
    use RefreshDatabase;

    private string $login1 = 'user1@test1.ru';
    private string $login2 = 'user2@test2.ru';


    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_example()
    {
        //создем перевого пользователя
        $response = $this->postJson('/api/auth/registration', [
            'email' => $this->login1,
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ]);

        $response->assertStatus(200);
        $data = $response->decodeResponseJson();
        $oneUserId = $data->json('id');

        //Создаем второго пользователя
        $response = $this->postJson('/api/auth/registration', [
            'email' => $this->login2,
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ]);

        $response->assertStatus(200);
        $twoUserId = $data->json('id');

        //проверяем добавление фоловера
        $token = $this->token($this->login2);
        $response = $this->postJson('/api/user/follow/' . $oneUserId, [], ['Authorization' => $token]);

        $response->assertStatus(200);

        $count = DB::table('followers')
            ->where('follower_id', $twoUserId)
            ->count();

        self::assertEquals(1, $count);
    }
}
