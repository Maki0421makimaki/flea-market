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

        $tab = $request->query('tab', 'sell');

        if ($tab === 'purchased') {
            $products = $user->purchases()->with('product')->get();
        } else {
            $products = $user->products()->with('purchase')->get();
        }

        return view('profile.mypage', compact('image', 'name', 'products', 'tab'));

    }

    


}
