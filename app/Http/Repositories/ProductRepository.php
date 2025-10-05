<?php

namespace App\Http\Repositories;

use App\Http\Resources\Product\ProductCollection;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ProductRepository
{

    public function __construct(private Product $model) {}


    public function findAll($request)
    {
        $page = $request->get('page', 1);

        $key = 'products.' . md5(http_build_query($request->all() + ['page' => $page]));

        $products = Cache::remember($key, 60, function () use ($request) {

            $products = $this->model->when($request->sku, function ($q) use ($request) {
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

        return [$products, $key];
    }


    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create($request)
    {
        $data = $request->validated();

        $product = Product::create($data);

        if ($request->has('image')) {

            $file_name = $request->file('image')->store('images', 'public');

            $image = $product->images()->create(['image' => $file_name]);
        }


    }

    public function update($product, $request)
    {
        $product->update($request->validated());

        if ($request->has('image')) {

            $old_image = $product->images()->first()?->image;

            $file_name = $request->file('image')->store('products', 'public');

            $image = $product->images()->updateOrCreate(['image' => $file_name]);

            if ($old_image && Storage::disk('public')->exists($old_image)) {
                Storage::disk('public')->delete($old_image);
            }
        }

        return $product->fresh();
    }

    public function delete($id)
    {
        return $this->model->findOrFail($id)->delete();
    }
}
