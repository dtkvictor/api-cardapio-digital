<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function testRegister(): void
    {
        $data = [
            'email' => fake()->unique()->safeEmail(),            
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];
        
        $response = $this->post('/api/auth/register', $data);
        $response->assertCreated();
    }

    public function testLogin(): void
    {
        $password = "12345678";
        $email = User::where('password', sha1($password))->first()->email;        
        $data = [ 
            'email' => $email,
            'password' => $password
        ];
        $response = $this->post('api/auth/login', $data);
        $response->assertOk();
        $response->assertJsonStructure();
    }

    public function testRefresh(): void
    {
        $response = $this->withToken($this->auth())->post('api/auth/refresh');
        $response->assertOk();
        $response->assertJsonStructure();
    }

    public function testLogout()
    {   
        $response = $this->withToken($this->auth())->post('api/auth/logout');
        $response->assertOk();        
    }
}
