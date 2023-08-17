<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponse;
use App\Http\Resources\UserDetailsResource;
use App\Http\Resources\UserResource;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserDetailController extends Controller
{       
    /**
     * Display a listing of the resource.
     */
    public function showByUserId(int $userId)
    {
        if(!$userDetail = UserDetail::where('user', $userId)->first()) {
            return abort(404);
        }
        return new UserDetailsResource($userDetail);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $userId)
    {
        if(UserDetail::where('user', $userId)->first()) return abort(404);

        $validator = Validator::make($request->all(), [            
            'profile' => 'image',
            'cpf' => 'required|numeric|digits:11|unique:user_details,cpf',            
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',            
            'phone_number' => 'required|numeric|digits:11'
        ]);

        if($validator->fails()) {
            return ApiResponse::unprocessableContent(
                $validator->errors()
            );
        }

        $details = new UserDetail();
        $details->user = $userId;
        $details->cpf = $request->input('cpf');
        $details->first_name = $request->input('first_name');
        $details->last_name = $request->input('last_name');
        $details->phone_number = $request->input('phone_number');
        
        if($request->hasFile('profile')) {
            $details->profile = $request->file('profile')->store('user/profile');
        }

        $details->save();    
        return ApiResponse::created("User data created successfully");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $userId)
    {
        if(!$details = UserDetail::where('user', $userId)->first()) return abort(404);

        $validator = Validator::make($request->all(), [            
            'profile' => 'image',
            'cpf' => 'numeric|digits:11|unique:user_details,cpf',            
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',            
            'phone_number' => 'numeric|digits:11'
        ]);

        if($validator->fails()) {
            return ApiResponse::unprocessableContent(
                $validator->errors()
            );
        }

        $data = $request->only(['cpf', 'first_name', 'last_name', 'phone_number']);

        if($request->hasFile('profile')) {
            if(Storage::exists($details->profile)) {
                Storage::delete($details->profile);
            }
            $data['profile'] = $request->file('profile')->store('user/profile');   
        }

        $details->fill($data)->save();
        return ApiResponse::success("User data updated successfully");
    }
}
