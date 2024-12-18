<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;

class ProductController extends Controller
{
   
    public function index(Request $request)
    {

       $products = Product::with('category')->latest()->paginate($request->limit ?? 10);

       return successResponse(new ProductCollection($products));

    }

    public function store(ProductRequest $request)
    {

        $data = $request->validated();
        $product = Product::create($data);

        //$product = Product::create([...$data,'sku'=>fake()->unique()->regexify('[A-Z0-9]{6}')]);

        if($request->has('image'))
        {
            $file_name = $request->file('image')->store('products_covers');

            $image = $product->images()->create(['image'=>$file_name]);
        }

        return simpleSuccessResponse(message: "Product Created Successfully");

    }

 
    public function show( Product $product)
    {

        return simpleSuccessResponse(new ProductResource($product));

    }


    public function update(ProductRequest $request, Product $product)
    {

        $product->update($request->validated());


        if($request->hasFile('image'))
        {

            $file_name = $request->file('image')->store('covers');

            $image = $product->images()->update(['image'=>$file_name]);

        }

        return simpleSuccessResponse(message: "Product Updated Successfully");
       
    }

 
    public function destroy(Product $product)
    {
        $product->delete();

        return simpleSuccessResponse(message: "Product Deleted Successfully");
    }
}
