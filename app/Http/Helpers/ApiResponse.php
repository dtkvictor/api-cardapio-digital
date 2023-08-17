<?php

namespace App\Http\Helpers;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{

    static function success(string $message, array $data = []):Response
    {
        return response()->json([
            "type" => "Success",
            "message" => $message,
            "data" => $data
        ]);
    }
    
    static function created(string $message, array $data = []): Response
    {
        return response()->json([
            "type" => "Success", 
            "message" => $message,
            "data" => $data
        ], Response::HTTP_CREATED);
    }

    static function noContent(string $message): Response
    {
        return response()->json([
            "type" => "Success",
            "message" => $message
        ], Response::HTTP_NO_CONTENT);
    }

    static function unauthorized($message = "Unauthorized access"): Response
    {
        return response()->json([
           "type" => "Error",
           "message" => "Unauthorized access",
        ], Response::HTTP_UNAUTHORIZED);
    }

    static function forbidden(): Response
    {
        return response()->json([
            "type" => "Error",
            "message" => "Unauthorized access",
         ], Response::HTTP_FORBIDDEN);
    }

    static function unprocessableContent(object|array $errors): Response
    {
        return response()->json([
            "type" => "Error",
            "message" => "Unprocessable content",
            "errors" => $errors
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
   
}