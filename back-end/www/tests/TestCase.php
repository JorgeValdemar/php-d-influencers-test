<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    private ?string $token = null;

    //
    protected function getToken(): string
    {
        if (is_null($this->token)) {
            $userData = [
                "name" => "phpunit",
                "email" => "php@unit.com.br", 
                "password" => "123uni456",
                "password_confirmation" => "123uni456"
            ];
    
            $user = User::create($userData);
            $token = JWTAuth::fromUser($user);
    
            $this->token = $token;
        }

        return $this->token;
    }
}
