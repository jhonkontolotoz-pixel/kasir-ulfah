<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
   
    public function index(Request $request)
    {

       $products = Product::latest()->paginate($request->limit ?? 10);

       return successResponse(new ProductCollection($products));

    }

    public function store(ProductRequest $request)
    {

        $data = $request->validated();

        $product = Product::create($data);

        if($request->has('image'))
        {
            $file_name = $request->file('image')->storePublicly('images');

            $image = $product->images()->create(['image'=>$file_name]);

        }

        return successResponse(message: "Product Created Successfully");

    }

 
    public function show( Product $product)
    {

        return successResponse(new ProductResource($product));

    }


    public function update(ProductRequest $request, Product $product)
    {

        $product->update($request->validated());


        if($request->has('image'))
        {

            $old_image = $product->images()->first()->image;

            $file_name = $request->file('image')->storePublicly('images' , ['disk' => 'public']);

            $image = $product->images()->updateOrCreate(['image'=>$file_name]);

            unlink(storage_path('app/public/'.$old_image));
        }

        return successResponse(message: "Product Updated Successfully");
       
    }

 
    public function destroy(Product $product)
    {
        $product->delete();

        return successResponse(message: "Product Deleted Successfully");
    }
}
