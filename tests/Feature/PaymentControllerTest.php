<?php

namespace Tests\Feature;

use App\Models\Sale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    public function testPaymentInfo()
    {
        $sale = Sale::where('status', false)->first()->id;
        $response = $this->withToken($this->authAdmin())->get("api/payment/cash/$sale");
        $response->assertOk();
        $response->assertJsonStructure();
    }

    public function testConfimationPayment()
    {
        $sale = Sale::where('status', false)->first()->id;
        $response = $this->withToken($this->authAdmin())->put("api/payment/cash/$sale");
        $response->assertOk();        
    }
}
