<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\User;
use Database\Factories\AddressFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AddressControllerTest extends TestCase
{
    public function testShowAllUserAddress(): void
    {
        $user = Address::first()->user;                
        $response = $this->withToken($this->authAdmin())
            ->get("api/user/$user/address");
        $response->assertOk();
        $response->assertJsonStructure();        
    }

    public function testShowAddressById(): void
    {
        $address = Address::first();          
        
        $response = $this->withToken($this->authAdmin())
            ->get("api/user/$address->user/address/$address->id");

        $response->assertOk();
        $response->assertJsonStructure();
    }

    public function testCreateAddress(): void
    {
        $user = Address::first()->user;
        $address = new AddressFactory();
        $address = $address->definition();

        $response = $this->withToken($this->authAdmin())
            ->post("api/user/$user/address/create", $address);

        $response->assertCreated();        
    }

    public function testUpdateAddressById(): void
    {
        $user = Address::first()->user;  
        $address = Address::first();        
        
        $addressData = new AddressFactory();
        $addressData = $addressData->definition();

        $response = $this->withToken($this->authAdmin($address->user))
            ->put("api/user/$user/address/update/$address->id", $addressData);
        $response->assertOk();        
    }

    public function testDeleteAddressById(): void
    {
        $user = Address::first()->user;  
        $address = Address::first();                        

        $response = $this->withToken($this->authAdmin($address->user))
            ->delete("api/user/$user/address/delete/$address->id");

        $response->assertNoContent();        
    }
}