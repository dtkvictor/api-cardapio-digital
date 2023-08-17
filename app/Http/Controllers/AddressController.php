<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponse;
use App\Http\Resources\AddressResource;
use App\Http\Resources\Colletion\AddressCollection;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{    
    /**
     * Display a listing of the resource.
     */
    public function showByUserId(int $userId)
    {                
        if(!$address = Address::where('user', $userId)->get()) {
            return abort(404);
        }
        return new AddressCollection($address);
    }


    public function showByUserAndAddressId(int $userId, int $addressId) 
    {
        if(!$address = Address::where('user', $userId)->find($addressId)) {
            return abort(404);
        }
        return new AddressResource($address);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $userId)
    {
        $validator = Validator::make($request->all(), [            
            'zipcode' => 'required|numeric|digits:8',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'street_address' => 'required|string|max:255',
            'number' => 'required|numeric',
            'complement' => 'string'
        ]);

        if($validator->fails()) {
            return ApiResponse::unprocessableContent(
                $validator->errors()
            );
        }

        $address = new Address();
        $address->user = $userId;
        $address->zipcode = $request->input('zipcode');
        $address->state = $request->input('state');
        $address->city = $request->input('city');
        $address->neighborhood = $request->input('neighborhood');
        $address->street_address = $request->input('street_address');
        $address->number = $request->input('number');
        $address->complement = $request->input('complement') ?? null;
        $address->save();

        return ApiResponse::created('Address created successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $userId, int $addressId)
    {
        if(!$address = Address::where('user', $userId)->find($addressId)) return abort(404);

        $validator = Validator::make($request->all(), [            
            'zipcode' => 'required|numeric|digits:8',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'street_address' => 'required|string|max:255',
            'number' => 'required|numeric',
            'complement' => 'string'
        ]);

        if($validator->fails()) {
            return ApiResponse::unprocessableContent(
                $validator->errors()
            );
        }

        $data = $request->only(
            ['zipcode', 'state', 'city', 'neighborhood', 'street_address', 'number', 'complement']
        );

        $address->fill($data)->save();
        return ApiResponse::success("Address updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $userId, int $addressId)
    {
        if(!$address = Address::where('user', $userId)->find($addressId)) return abort(404);   
        $address->delete();
        return ApiResponse::noContent("Address deleted successfully");
    }
}
