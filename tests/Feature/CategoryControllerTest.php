<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Database\Factories\CategoryFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class CategoryControllerTest extends TestCase
{    

    public function testShowAllCategories(): void
    {
        $response = $this->get('/api/category');                
        $response->assertOk();
        $response->assertJsonStructure();
    }

    public function testShowCategoryById(): void
    {        
        $categoryId = Category::first()->id;                
        $response = $this->get("/api/category/$categoryId");        
        $response->assertOk();
        $response->assertJsonStructure();
    }

    public function testCreateNewCategory(): void
    {                
        $factory = new CategoryFactory();                
        $response = $this->withToken($this->authAdmin())
                         ->post('/api/category/create', $factory->definition());                
        $response->assertCreated();
    }

    public function testUpdateCategoryById(): void
    {        
        $categoryId = Category::first()->id;        
        $factory = new CategoryFactory();                
        $response = $this->withToken($this->authAdmin())
                         ->put("/api/category/update/$categoryId", $factory->definition());                
        $response->assertOk();
    }

    public function testDeleteCategoryById(): void
    {
        $categoryId = category::first()->id;
        $response = $this->withToken($this->authAdmin())
                         ->delete("/api/category/delete/$categoryId");
        $response->assertNoContent();
    }
}
