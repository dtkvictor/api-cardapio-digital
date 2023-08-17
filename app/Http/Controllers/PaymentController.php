<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponse;
use App\Http\Resources\SaleResource;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use App\Models\Sale;

class PaymentController extends Controller
{
    public function info(int $id)
    {
        $payment = PaymentMethod::where('name', 'cash')->first()->id;
        $sale = Sale::where('payment', $payment)->find($id);         

        if(!$sale) return abort(404);

        $sale->user();
        $sale->payment();
        $sale->details();
        
        return new SaleResource($sale);
    }

    public function cash(int $id)
    {
        $payment = PaymentMethod::where('name', 'cash')->first()->id;
        if(!$sale = Sale::where('payment', $payment)->find($id)) return abort(404);
        $sale->status = true;
        $sale->save();
        return ApiResponse::success("Payment confirmed successfully");
    }
}
