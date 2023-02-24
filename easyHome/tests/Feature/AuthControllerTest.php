<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /**
     * Test register new user
     *
     * @return void
     */
    public function testRegister()
    {
        $user = User::factory()->make();

        $response = $this->postJson('/api/register', [
            'name' => $user->name,
            'email' => $user->email,
            'username' => $user->username,
            'password' => 'password',
            'password_confirmation' => 'password',
            'user_type' => 'usuario',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'username' => $user->username,
        ]);
    }

    /**
     * Test login with valid credentials
     *
     * @return void
     */
    public function testLoginWithValidCredentials()
    {
        $password = $this->faker->password;
        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => 'password'
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@test.com',
            'password' => 'password'
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'message' => 'Bienvenido',
        ]);
    }

    /**
     * Test login with invalid credentials
     *
     * @return void
     */
    public function testLoginWithInvalidCredentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'invalid-email@example.com',
            'password' => 'invalid-password',
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertJson([
            'message' => 'Credenciales inválidas',
        ]);
    }
}
