<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PurchaseRequest;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Purchase;
use Stripe\StripeClient;

class PurchaseController extends Controller
{
    public function show($item_id)
    {
        $product = Product::find($item_id);
        $profile = Profile::where('user_id', auth()->id())->first();
        return view('products.purchase', compact('product','profile'));
    }


    // public function buy(PurchaseRequest $request, $item_id)
    // {
    //     $profile = Profile::where('user_id', auth()->id())->first();
    //     if (!$profile || !$profile->post_code || !$profile->address) {
    //         return back()->withInput();
    //     }

    //     $product = Product::findOrFail($item_id);

    //     Purchase::create([
    //         'user_id' => auth()->id(),
    //         'product_id' => $product->id,
    //     ]);

    //     return redirect()->route('items.index');
    // }



    public function buy(PurchaseRequest $request, $item_id)
    {
        $profile = Profile::where('user_id', auth()->id())->first();

        if (!$profile || !$profile->post_code || !$profile->address) {
            return back()->withInput();
        }

        $product = Product::findOrFail($item_id);

        $paymentMethod = $request->payment_method;

        $stripe = new StripeClient(config('stripe.secret'));

        $checkout = $stripe->checkout->sessions->create([
            'payment_method_types' => [$paymentMethod],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'jpy',
                        'unit_amount' => $product->price,
                        'product_data' => [
                            'name' => $product->name,
                        ],
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'success_url' => route('purchase.success', ['item_id' => $product->id]),
            'cancel_url' => route('purchase.success', ['item_id' => $product->id]),
        ]);

        return redirect($checkout->url);
    }

    public function success($item_id)
    {
        $product = Product::findOrFail($item_id);

        Purchase::firstOrCreate(
            [
                'product_id' => $product->id,
            ],
            [
                'user_id' => auth()->id(),
            ]
        );

        return redirect()->route('items.index');
    }


}
