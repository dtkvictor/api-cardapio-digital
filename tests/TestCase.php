<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    public function auth(): string
    {
        $user = User::whereNull('hierarchy')->first();
        return JWTAuth::fromUser($user);
    }   

    public function authAdmin(): string
    {                        
        $user = User::whereNotNull('hierarchy')->first();
        return JWTAuth::fromUser($user);
    }

    public function authUserById(int $userId): string
    {
        $user = User::find($userId);
        return JWTAuth::fromUser($user);
    }

    use CreatesApplication;
}
