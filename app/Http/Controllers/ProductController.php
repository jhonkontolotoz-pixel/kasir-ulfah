<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index(Request $request)
    {

        $key = "products." . implode('.', $request->all());

        $products = Cache::remember($key, 60, function () use ($request) {

            $products = Product::when($request->sku, function ($q) use ($request) {
                $q->where("sku", "LIKE", "%{$request->sku}%");
            })
                ->when($request->title, function ($q) use ($request) {
                    $q->where("title", "LIKE", "%{$request->title}%");
                })
                ->when($request->category, function ($q) use ($request) {
                    $q->whereHas("category", function ($query) use ($request) {
                        $query->where('name', "LIKE", "%{$request->category}%");
                    });
                })
                ->when($request->sortBy && $request->order, function ($q) use ($request) {
                    $q->orderBy($request->sortBy, $request->order);
                }, function ($q) {
                    $q->latest();
                })
                ->paginate($request->limit ?? 10);

            return new ProductCollection($products);
        });

        return successResponse($products, additional: ['pdf_url' => url('reports/products/' . $key)]);
    }

    public function store(ProductRequest $request)
    {

        $data = $request->validated();

        $product = Product::create($data);

        if ($request->has('image')) {

            $file_name = $request->file('image')->storePublicly('images');

            $image = $product->images()->create(['image' => $file_name]);
        }

        return successResponse(message: "Product Created Successfully");
    }


    public function show(Product $product)
    {

        return successResponse(new ProductResource($product));
    }


    public function update(ProductRequest $request, Product $product)
    {

        $product->update($request->validated());


        if ($request->has('image')) {

            $old_image = $product->images()->first()->image;

            $file_name = $request->file('image')->storePublicly('images', ['disk' => 'public']);

            $image = $product->images()->updateOrCreate(['image' => $file_name]);

            unlink(storage_path('app/public/' . $old_image));
        }

        return successResponse(message: "Product Updated Successfully");
    }


    public function destroy(Product $product)
    {
        $product->delete();

        return successResponse(message: "Product Deleted Successfully");
    }
}
