<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|exists:users,email',
            'password' => 'required|max:255'
        ]);

        if($validator->fails()) {
            return ApiResponse::unprocessableContent(
                $validator->errors()
            );
        }              

        $user = User::where('email', $request->input('email'))
            ->where('password', sha1($request->input('password')))->first();

        if(!$user) return ApiResponse::unauthorized();

        return ApiResponse::success("Authorized", [
            "token" => JWTAuth::fromUser($user)
        ]);                
    }    

    public function logout(Request $request)
    {
        auth()->logout(true);
        return ApiResponse::success("Successfully logged out");        
    }    

    public function refresh(Request $request)
    {        
        $token = auth()->refresh();        
        return ApiResponse::success("Authorized", ["token" => $token]); 
    }

    public function register(Request $request)
    {
        $request->request->remove('hierarchy');
        $controller = new UserController();
        return $controller->store($request);
    }
}
