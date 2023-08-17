<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserDetail;
use Database\Factories\UserDetailFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserDetailControllerTest extends TestCase
{
    public function testShowUserDetails(): void
    {
        $user = UserDetail::first()->user;

        $response = $this->withToken($this->authAdmin())
            ->get("api/user/$user/details");

        $response->assertOk();
        $response->assertJsonStructure();
    }

    public function testSaveUserDetails(): void
    {        
        $user = User::factory()->create();        
        $details = new UserDetailFactory();        
        $details = $details->definition();
        unset($details['profile']);

        $response = $this->withToken($this->authAdmin())
            ->post("api/user/$user->id/details/create", $details);
        $response->assertCreated();
    }

    public function testReturnNotFoundIfExistUserDetails(): void
    {
        $user = UserDetail::first()->user;        
    
        $response = $this->withToken($this->authAdmin())
            ->post("api/user/$user/details/create");

        $response->assertNotFound();
    }

    public function testUpdateUserDetails(): void
    {
        $user = UserDetail::first()->user;
        $details = new UserDetailFactory();        
        $details = $details->definition();
        unset($details['profile']);

        $response = $this->withToken($this->authAdmin())
            ->put("api/user/$user/details/update", $details);
        $response->assertOk();        
    }

}
