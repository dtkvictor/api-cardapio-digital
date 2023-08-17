<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponse;
use App\Http\Resources\Collection\ProductCollection;
use App\Models\Product;
use App\Http\Repository\ProductRepository;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {                
        $validator = Validator::make($request->all(), [
            'search' => 'string',
            'category' => 'numeric',
            'orderBy' => Rule::in(['ASC', 'DESC']),
            'minPrice' => 'numeric',
            'maxPrice' => 'numeric'
        ]);

        if($validator->fails()) {
            return ApiResponse::unprocessableContent(
                $validator->errors()
            );            
        }

        $products = new ProductRepository(new Product());                   
        $products = $products->filterBy($request->all())                             
                             ->paginate(8)
                             ->onEachSide(0)
                             ->withQueryString();        
                                                                          
        $products->each(function($product) {
            $product->getThumbUrl();
            $product->amountOfSales();
        });                             
                             
        return new ProductCollection($products);        
    }

    /**
     * Display the specified resource.
     */

    public function show(int $id)
    {
        $product = Product::with('category')->find($id);        
        if(!$product) {
            return abort(404);
        } 
        $product->getThumbUrl();
        $product->amountOfSales();                        
        return new ProductResource($product);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|exists:categories,id',
            'thumb' => 'required|image',      
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'price' => 'required|numeric',
        ]);        

        if($validator->fails()) {
            return ApiResponse::unprocessableContent(
                $validator->errors()
            );            
        }

        $product = new Product();
        $product->category = $request->input('category');
        $product->thumb = $request->file('thumb')->store('product');
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');        
        $product->save();

        return ApiResponse::created("Success in registering product", []);        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)    
    {                
        if(!$product = Product::find($id)) return abort(404);

        $validator = Validator::make($request->all(), [
            'category' => 'exists:categories,id',
            'thumb' => 'image',      
            'name' => 'string|max:255',
            'description' => 'string|max:500',
            'price' => 'numeric',
        ]);        

        if($validator->fails()) {
            return ApiResponse::unprocessableContent(
                $validator->errors()
            );            
        }
        
        $data = $request->only(['category', 'name', 'description', 'price']);

        if($request->hasFile('thumb')) {
            if(Storage::exists($product->thumb)) {
                Storage::delete($product->thumb);
            }                
            $data['thumb'] = $request->file('thumb')->store('product');
        }                

        $product->fill($data)->save();
        return ApiResponse::success("Successfully updated product");       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {      
        if(!$product = Product::find($id)) return abort(404);
        if(Storage::exists($product->thumb)) {
            Storage::delete($product->thumb);
        }        
        $product->delete();        
        return ApiResponse::noContent("Successfully deleted product");
    }
}
