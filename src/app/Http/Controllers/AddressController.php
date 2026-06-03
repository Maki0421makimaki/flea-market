<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;
use App\Models\Profile;

class AddressController extends Controller
{
    public function edit($item_id)
    {
        $address = Profile::where('user_id', auth()->id())->first();
        return view('products.address', compact('address', 'item_id'));
    }

    public function update(AddressRequest $request, $item_id)
    {

        $address = Profile::where('user_id', auth()->id())->firstOrFail();
        $address->post_code = $request->post_code;
        $address->address = $request->address;
        $address->building = $request->building;
        $address-> save();

        return redirect('purchase/'. $item_id);
    }
}
