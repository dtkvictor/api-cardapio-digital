<?php

namespace Tests\Feature;

use App\Models\Hierarchy;
use App\Models\User;
use Database\Factories\UserFactory;
use GuzzleHttp\Psr7\Response;
use Illuminate\Auth\Access\Response as AccessResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testShowAllUser(): void
    {
        $response = $this->withToken($this->authAdmin())->get("api/user");
        $response->assertOk();
        $response->assertJsonStructure();
    }

    public function testShowUserById(): void 
    {
        $user = User::first()->id;
        $response = $this->withToken($this->authAdmin())->get("api/user/$user");
        $response->assertOk();
        $response->assertJsonStructure();
    }

    public function testCreateUser(): void
    {        
        $data = new UserFactory();
        $data = $data->definition();        
        $data['password_confirmation'] = $data['password'];

        if(rand(0, 100) < 30) {
            $data['hierarchy'] = Hierarchy::first()->id;
        }

        $response = $this->withToken($this->authAdmin())->post("api/user/create", $data);
        $response->assertCreated();
        $response->assertJsonStructure();        
    }

    public function testUpdateUser(): void 
    {
        $user = User::first()->id;
        $data = new UserFactory();
        $data = $data->definition();
        $data['password_confirmation'] = $data['password'];        

        $response = $this->withToken($this->authAdmin())->put("api/user/update/$user", $data);
        $response->assertOk();        
    }

    public function testDeleteUser(): void
    {        
        $user = User::first()->id;
        $response = $this->withToken($this->authAdmin())
            ->delete("api/user/delete/$user");
        $response->assertNoContent();        
    }


}
