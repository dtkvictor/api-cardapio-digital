<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Sale;
use Database\Factories\SaleDetailsFactory;
use Database\Factories\SaleFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SaleControllerTest extends TestCase
{
    public function testShowAllSales(): void
    {
        $response = $this->withToken($this->authAdmin())->get('/api/sale/'); 
        $response->assertOk();
        $response->assertJsonStructure();
    }

    public function testShowSaleById(): void
    {
        $sale = Sale::first();
        $response = $this->withToken($this->authAdmin())
            ->get("/api/sale/$sale->id"); 
        $response->assertOk();
        $response->assertJsonStructure();
    }

    public function testShowByUserId(): void
    {
        $sale = Sale::whereNotNull('user')->first();        
        $response = $this->withToken($this->authAdmin())
            ->get("/api/sale/user/$sale->user");
        $response->assertOk();
        $response->assertJsonStructure();
    }

    public function testShowByUserAndSaleId(): void
    {
        $sale = Sale::whereNotNull('user')->first();    
        $response = $this->withToken($this->authAdmin())
            ->get("/api/user/$sale->user/shopping/$sale->id");
        $response->assertOk();
        $response->assertJsonStructure();
    }

    public function testCreateNewSale()
    {
        $sale = new SaleFactory();
        $sale = $sale->definition();                
        $sale['products'] = [
            ['id' => Product::first()->id, 'quantity' => 1],
            ['id' => Product::first()->id, 'quantity' => 1],
            ['id' => Product::first()->id, 'quantity' => 1],
        ];                 

        $response = $this->withToken($this->auth())
            ->post("/api/sale/create", $sale);

        $response->assertCreated();        
    }

    public function testDeleteBySaleAndUserId(): void
    {
        $sale = Sale::first()->id;

        $response = $this->withToken($this->authAdmin())
            ->delete("/api/sale/delete/$sale");

        $response->assertNoContent();        
    }
}
