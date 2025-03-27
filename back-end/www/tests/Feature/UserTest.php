<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_success(): void
    {
        $response = $this->post(route('user.register', [
            "name" => "phpunit",
            "email" => "php@unit.com.br", 
            "password" => "123uni456",
            "password_confirmation" => "123uni456"
        ]));

        $response->assertStatus(201)->assertJson([
            "user" => [
                "name" => true,
                "email" => true,
                "updated_at" => true,
                "created_at" => true,
                "id" => true
            ],
            "token" => true
        ]);
    }
    
    public function test_register_failed(): void
    {
        $response = $this->post(route(
            'user.register', 
            []
        ));

        $response->assertJson([
            "error" => [
                "name" => true,
                "email" => true,
                "password" => true,
                "password_confirmation" => true
            ]
        ]);
    }
    
    public function test_register_already_exists(): void
    {
        $response = $this->post(route(
            'user.register', 
            [
                "name" => "phpunit",
                "email" => "already_exists@unit.com.br", 
                "password" => "123uni456",
                "password_confirmation" => "123uni456"
            ]
        ));

        $response->assertStatus(201)->assertJson([
            "user" => [
                "name" => true,
                "email" => true,
                "updated_at" => true,
                "created_at" => true,
                "id" => true
            ],
            "token" => true
        ]);

        $userLogin2 = [
            "name" => "phpunit2",
            "email" => "already_exists@unit.com.br", 
            "password" => "123uni456SEC",
            "password_confirmation" => "123uni456SEC"
        ];

        $response2 = $this->post(route(
            'user.register', 
            $userLogin2
        ));

        $response2->assertJson([
            "error" => [
                "email" => ["O email já está em uso."]
            ]
        ]);        
    }
    
    public function test_login_success(): void
    {
        $response = $this->post(route('user.register', [
            "name" => "phpunit",
            "email" => "php@unit.com.br", 
            "password" => "123uni456",
            "password_confirmation" => "123uni456"
        ]));

        $response = $this->post(route(
            'user.login', 
            ['email' => "php@unit.com.br",  'password' => "123uni456"]
        ));

        $response->assertStatus(200)->assertJson(["token" => true]);
    }
    
    public function test_login_failed(): void
    {
        $response = $this->post(route(
            'user.login', 
            ['email' => "php@unit.com.br",  'password' => "30kfk52ff"]
        ));

        $response->assertJson(["error"=> "Login ou senha inválido"]);
    }
}
