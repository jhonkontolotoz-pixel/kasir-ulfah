<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryRequest;
use App\Http\Resources\Category\CategoriesCollection;
use App\Http\Resources\Category\CategoriesResource;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::withCount('products')->paginate($request->limit ?? 10);

        return successResponse(new CategoriesCollection($categories));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        
        Category::create($request->validated());

       return simpleSuccessResponse(message:"Category Created Successfully");
    }

  
    public function show(Category $category)
    {
        return simpleSuccessResponse(new CategoriesResource($category->load('products')->loadCount('products')));
    }

    public function update(CategoryRequest $request,Category $category)
    {
        $category->update($request->validated());

        return simpleSuccessResponse(message:"Category Updated Successfully");
        
    }


    public function destroy(Category $category)
    {
        $category->delete();

        return simpleSuccessResponse(message:"Category Deleted Successfully");
        
    }

}
