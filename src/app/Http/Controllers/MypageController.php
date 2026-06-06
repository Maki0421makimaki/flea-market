<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $image = $user->profile?->image;
        $name = $user->profile->name;

        $page = $request->query('page', 'sell');
        $keyword = $request->query('keyword');

        if ($page === 'buy') {
            $products = $user->purchases()
                ->with('product')
                ->whereHas('product', function ($query) use ($keyword) {
                    if (!empty($keyword)) {
                        $query->where('name', 'like', '%' . $keyword . '%');
                    }
                })
                ->get();
        } else {
            $products = $user->products()
                ->with('purchase')
                ->when($keyword, function ($query, $keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })
                ->get();
        }

        return view('profile.mypage', compact('image', 'name', 'products', 'page', 'keyword'));

    }

}
