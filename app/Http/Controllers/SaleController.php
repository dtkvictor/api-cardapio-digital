<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponse;
use App\Http\Repository\SaleRepository;
use App\Http\Resources\Collection\SaleCollection;
use App\Http\Resources\SaleResource;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'numeric'
        ]);

        if($validator->fails()) {
            return ApiResponse::unprocessableContent(
                $validator->errors()
            );
        }

        $sale = new SaleRepository(new Sale());
        $sale = $sale->filterBy($request->all())
                     ->paginate(8)
                     ->onEachSide(0)
                     ->withQueryString();
        
        return new SaleCollection($sale);                        
    }

    public function showBySaleId(int $id)
    {
        if(!$sale = Sale::with('details')->find($id)) return abort(404);
        return new SaleResource($sale);        
    }


    public function showByUserId(int $userId)
    {
        if(!$sale = Sale::where('user', $userId)->with('details')->get()) {
            return abort(404);
        } 
        return new SaleCollection($sale);        
    }    

    public function showByUserAndSaleId(int $userId, int $saleId)
    {
        $sale = Sale::where('user', $userId)->find($saleId);                
        if(!$sale) return abort(404);        
        $sale->details();
        return new SaleResource($sale);   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'payment' => 'required|numeric|exists:payment_methods,id',
            'delivery_address' => 'requerid|numeric|exists:addresses,id',
            'products' => 'required|array',
            'products.*.id' => 'required|numeric|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:1'
        ]);

        if($validator->fails()){
            return ApiResponse::unprocessableContent(
                $validator->errors()
            );
        }

        $sale = new Sale();
        $sale->user = auth()->id();
        $sale->payment = $request->input('payment');
        $sale->save();
        
        foreach($request->input('products') as $product) {                    
            $saleDetails = new SaleDetails();
            $saleDetails->sale = $sale->id;
            $saleDetails->product = $product['id'];
            $saleDetails->quantity = $product['quantity'];
            $saleDetails->price = Product::find($product['id'])->price;
            $saleDetails->save();
            unset($saleDetails);
        }

        return ApiResponse::created("Order placed successfully, awaiting payment");
    }    

    public function hidden($userId, int $saleId)
    {
        if(!$shopping = Sale::where('user', $userId)->find($saleId)) {
            return abort(404);
        } 
        $shopping->hidden = true;
        $shopping->save();
        return ApiResponse::noContent("Shopping deleted with success");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        if(!$sale = Sale::find($id)) abort(404);
        $sale->delete();
        return ApiResponse::noContent("Sale Deleted Successfully");
    }

    public function destroyBySaleAndUserId(int $userId, int $saleId)
    {
        if(!$sale = Sale::where('user', $userId)->find($saleId)) abort(404);
        $sale->delete();
        return ApiResponse::noContent("Sale Deleted Successfully");
    }
}
