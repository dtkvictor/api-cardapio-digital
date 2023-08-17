<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponse;
use App\Http\Resources\Collection\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {        
        $user = User::with(['details', 'address', 'sales'])->get();
        return new UserCollection($user);
    }

    public function show(int $userId)
    {
        $user = User::with(['details', 'address', 'sales'])->find($userId);
        return new UserResource($user);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:users,email',
            'hierarchy' => 'numeric|exists:hierarchies,id',
            'password' => 'required|max:255|confirmed'
        ]);

        if($validator->fails()) {
            return ApiResponse::unprocessableContent(
                $validator->errors()
            );            
        }

        $user = new User();
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        if($request->input('hierarchy')) {
            $user->hierarchy = $request->input('hierarchy');
        }
        $user->save();

        return ApiResponse::created("Successfully registered user", []);   
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $userId)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'email|max:255|unique:users,email',
            'hierarchy' => 'numeric|exists:hierarchies,id',
            'password' => 'max:255|confirmed'
        ]);
        
        if($validator->fails()) {
            return ApiResponse::unprocessableContent(
                $validator->errors()
            );            
        }

        $data = $request->only(['email', 'password', 'hierarchy']);        
        $user = User::find($userId);
        $user->fill($data)->save();

        return ApiResponse::success("Data updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $userId)
    {        
        User::find($userId)->delete();
        return ApiResponse::noContent("User deleted succesfully");
    }
}
