<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmpleadoControllerTest extends TestCase
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
    public function test_crearEmpleado($token)
    {
        $data = [
            'user_id' => 1,
            'apellido' => 'prueba',
            'nombre' => 'prueba',
            'email' => 'prueba@prueba.com.ar'
        ];
        $this->withExceptionHandling();
        $json = json_decode($token);
        $access_token = $json->access_token;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $access_token
        ])->postJson('/api/empleado', $data);
        $response->assertStatus(201);
    }

    /**
     * @depends  test_login
     */
    public function test_todosEmpleados($token)
    {
        $this->withExceptionHandling();
        $json = json_decode($token);
        $access_token = $json->access_token;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $access_token
        ])->get('/api/empleado');
        $response->assertStatus(200);
    }

    /**
     * @depends  test_login
     */
    public function test_EmpleadoXIdUser($token)
    {
        $this->withExceptionHandling();
        $json = json_decode($token);
        $access_token = $json->access_token;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $access_token
        ])->get('/api/empleado/showIdUser/1');
        $empleados = $response->assertStatus(200)->getContent();
        print_r($empleados);
    }

    /**
     * @depends  test_login
     */
    // public function test_buscarEmpleado($token)
    // {
    //     $this->withExceptionHandling();
    //     $json = json_decode($token);
    //     $access_token = $json->access_token;
    //     $response = $this->withHeaders([
    //         'Authorization' => 'Bearer ' . $access_token
    //     ])->get('/api/empleado');
    //     $response->assertStatus(200);
    // }
}
