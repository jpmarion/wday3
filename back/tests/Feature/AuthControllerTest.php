<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login()
    {
        $data = [
            'email' => 'totomarion@gmail.com',
            'password' => 'jpm141560',
            'remember_me' => true
        ];

        $this->withoutExceptionHandling();
        $response = $this->post('/api/auth/login', $data);
        $token = $response->assertStatus(200)->getContent();
        return $token;
    }

    /**
     * @depends  test_login
     */
    public function testUser($token)
    {
        $this->withExceptionHandling();
        $json = json_decode($token);
        $access_token = $json->access_token;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $access_token
        ])->getJson('/api/auth/logout');
        $response->assertStatus(200);
    }
}
