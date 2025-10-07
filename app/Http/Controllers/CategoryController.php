<?php

namespace App\Http\Controllers;

use App\Http\Repositories\CategoryRepository;
use App\Http\Requests\Category\CategoryRequest;
use App\Http\Resources\Category\CategoriesResource;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __construct(public CategoryRepository $categoryRepository ) {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        [$categories, $key] = $this->categoryRepository->findAll($request);

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
