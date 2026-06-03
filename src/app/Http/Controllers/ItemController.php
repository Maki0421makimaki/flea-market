<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->profile === null) {
            return redirect('/mypage/profile');
        }

        $tab = $request->query('tab', 'recommend');
        $keyword = $request->input('keyword');

        $query = Product::with('purchase');

        if (auth()->check()) {
            $query->where('user_id', '!=', auth()->id());
        }

        if ($tab === 'mylist') {
            $query->whereHas('likes', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%");
            });
        }

        $products = $query->get();

        return view('products.index', compact('products', 'tab', 'keyword'));

    }

    public function show($item_id)
    {
        $product = Product::find($item_id);

        return view('products.show', compact('product'));
    }

    public function purchase($item_id)
    {
        $product = Product::find($item_id);

        return view('products.purchase', compact('product'));
    }

    public function __construct()
    {
        $this->middleware(['auth', 'verified'])->only(['like', 'unlike']);
    }



    public function like($id)
    {
        Like::create([
            'product_id' => $id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back();
    }

    public function unlike($id)
    {
        $like = Like::where('product_id', $id)->where('user_id', Auth::id())->first();
        if ($like) {
            $like->delete();
        }

        return redirect()->back();
    }

    public function store(CommentRequest $request,$id)
    {
        Comment::create([
            'product_id' => $id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        return redirect()->back();
    }


}