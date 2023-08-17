<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Factories\ProductFactory;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{    
    public function testShowAllProducts(): void
    {
        $response = $this->get('/api/product');                
        $response->assertOk();
        $response->assertJsonStructure();
    }

    public function testShowProductById(): void
    {
        $productId = Product::first()->id;                
        $response = $this->get("/api/product/$productId");        
        $response->assertOk();
        $response->assertJsonStructure();
    }

    public function testCreateNewProduct(): void
    {        
        $factory = new ProductFactory();        
        $data = $factory->definition();
        $data['thumb'] = UploadedFile::fake()->create('teste.jpg');
        
        $response = $this->withToken($this->authAdmin())
                         ->post('/api/product/create', $data);                
        $response->assertCreated();
    }

    public function testUpdateProductById(): void
    {        
        $productId = Product::first()->id;
        
        $factory = new ProductFactory();        
        $data = $factory->definition();
        $data['thumb'] = UploadedFile::fake()->create('teste.jpg');
        
        $response = $this->withToken($this->authAdmin())
                         ->put("/api/product/update/$productId", $data);                
        $response->assertOk();
    }

    public function testDeleteProductById(): void
    {
        $productId = Product::first()->id;
        $response = $this->withToken($this->authAdmin())
                         ->delete("/api/product/delete/$productId");
        $response->assertNoContent();
    }
}
