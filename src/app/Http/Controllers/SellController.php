<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ProductStatus;
use App\Models\Product;
use App\Http\Requests\ExhibitionRequest;

class SellController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $categories = Category::all();
        $statuses = ProductStatus::all();
        return view('products.create', compact('user', 'categories', 'statuses'));
    }

    public function create(ExhibitionRequest $request)
    {
        $product = new Product();

        $path = $request->file('image')->store('public/products');
        $product->image = str_replace('public/', '', $path);

        $product->user_id = auth()->id();
        $product->product_status_id = $request->product_status_id;
        $product->name = $request->name;
        $product->brand_name = $request->brand_name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();

        $product->categories()->sync($request->categories);

        return redirect('/');
    }
}
