<?php

namespace App\Http\Repositories;

use App\Http\Resources\Category\CategoriesCollection;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryRepository
{

    public function findAll($request)
    {
        $page = $request->get('page', 1);

        $key = "categories." . md5(http_build_query($request->all() + ['page' => $page]));

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

        return [$categories, $key];
    }

}
