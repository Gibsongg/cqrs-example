<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRegistrationTest extends TestAbstract
{
    private string $login1 = 'user1@test1.ru';

    use RefreshDatabase;


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->postJson('/api/auth/registration', [
            'email' => $this->login1,
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ]);

        $response->assertStatus(200);
    }
}
