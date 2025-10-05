<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ProductRepository;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Requests\Product\ProductFilterRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function __construct(public ProductRepository $productRepository )
    {

    }

    public function index(ProductFilterRequest $request)
    {

        [$products, $key] = $this->productRepository->findAll($request);

        return successResponse($products, additional: ['pdf_url' => url('reports/products/' . $key)]);
    }

    public function store(ProductRequest $request)
    {

        $this->productRepository->create($request);

        return successResponse(message: "Product Created Successfully");
    }


    public function show(Product $product)
    {
        return successResponse(new ProductResource($product));
    }


    public function update(ProductRequest $request, Product $product)
    {

        $product = $this->productRepository->update($product, $request);

        return successResponse(new ProductResource($product) , message: "Product Updated Successfully");
    }


    public function destroy(Product $product)
    {
        $product->delete();

        return successResponse(message: "Product Deleted Successfully");
    }
}
