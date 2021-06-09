<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

abstract class TestAbstract extends TestCase
{
    public function token(string $login, string $password = 'secret')
    {

        $response = $this->postJson('/api/auth/login', [
            'email' => $login,
            'password' => $password,
        ]);

        return $response->json('token')['plainTextToken'];
    }
}
