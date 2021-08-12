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
        $this->withExceptionHandling();
        $json = json_decode($token);
        $access_token = $json->access_token;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $access_token
        ])->getJson('/api/auth/user');

        $usuarioJson = $response->assertStatus(200)->getContent();
        $usuario = json_decode($usuarioJson);

        $data = [
            'user_id' => $usuario->id,
            'apellido' => 'prueba',
            'nombre' => 'prueba',
            'email' => 'prueba1@prueba.com.ar'
        ];

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
        ])->getJson('/api/auth/user');

        $usuarioJson = $response->assertStatus(200)->getContent();
        $usuario = json_decode($usuarioJson);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $access_token
        ])->get('/api/empleado/showIdUser/' . $usuario->id);
        $empleados = $response->assertStatus(200)->getContent();
        return $empleados;
    }

    /**
     * @depends  test_login
     * @depends  test_EmpleadoXIdUser
     */
    public function test_buscarEmpleado($token, $empleados)
    {
        $this->withExceptionHandling();
        $json = json_decode($token);
        $access_token = $json->access_token;

        $empleados = json_decode($empleados, true);
        $ultimoempleado = end($empleados);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $access_token
        ])->get('/api/empleado/' . $ultimoempleado['id']);
        $response->assertStatus(200);
    }

    /**
     * @depends  test_login
     * @depends  test_EmpleadoXIdUser
     */
    public function test_eliminarEmpleado($token, $empleados)
    {
        $this->withExceptionHandling();
        $json = json_decode($token);
        $access_token = $json->access_token;

        $empleados = json_decode($empleados, true);
        $ultimoempleado = end($empleados);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $access_token
        ])->deleteJson('/api/empleado/' . $ultimoempleado['id']);
        $response->assertStatus(200);
    }
}
