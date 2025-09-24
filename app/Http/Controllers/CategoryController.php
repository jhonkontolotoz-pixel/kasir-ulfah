<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryRequest;
use App\Http\Resources\Category\CategoriesCollection;
use App\Http\Resources\Category\CategoriesResource;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $key = "categories.".implode('.', $request->all());

        $categories = Cache::remember($key, 60,  function () use ($request) {

            $categories = Category::withCount('products')
                ->when($request->name, function ($q) use ($request) {
                    $q->where("name", "LIKE", "{$request->name}");
                })
                ->when($request->sortBy && $request->order, function ($q) use ($request) {
                    $q->orderBy($request->sortBy, $request->order);
                }, function ($q) {
                    $q->latest();
                })
                ->paginate($request->limit ?? 10);

            return new CategoriesCollection($categories);
        });

        return successResponse($categories, additional: ['pdf_url' => url('reports/categories/' . $key)]);
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

        return successResponse(message: "Category Created Successfully");
    }


    public function show(Category $category)
    {
        return successResponse(new CategoriesResource($category->load('products')->loadCount('products')));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return successResponse(message: "Category Updated Successfully");
    }


    public function destroy(Category $category)
    {
        $category->delete();

        return successResponse(message: "Category Deleted Successfully");
    }
}
