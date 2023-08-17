<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponse;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\Collection\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\FlareClient\Api;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();
        return new CategoryCollection($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        if(!$category = Category::find($id)) return abort(404);
        return new CategoryResource($category);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
        ]);        
        if($validator->fails()) {
            return ApiResponse::unprocessableContent(
                $validator->errors()
            );
        }        
        $category = new Category();
        $category->name = $request->input('name');
        $category->save();

        return ApiResponse::created("Category created successfully");        
    }    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        if(!$category = Category::find($id)) return abort(404);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
        ]);        

        if($validator->fails()) {
            return ApiResponse::unprocessableContent(
                $validator->errors()
            );
        }        

        $category->name = $request->input('name');
        $category->save();
        return ApiResponse::success("Category updated successfully");        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        if(!$category = Category::find($id)) return abort(404);
        $category->delete();
        return ApiResponse::noContent("Category deleted successfully");
    }
}
