<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.setup');
    }

    public function store(ProfileRequest $request)
    {
        $profile = new Profile();
        $profile->user_id = auth()->id();

        if ($request->hasFile('user_image')) {
            $path = $request->file('user_image')->store('public/profile');
            $filename = basename($path);
            $profile->image = $filename;
        }

        $profile->name = $request->name;
        $profile->post_code = $request->post_code;
        $profile->address = $request->address;
        $profile->building = $request->building;
        $profile->save();

        return redirect('/');

    }

    public function edit(Request $request)
    {
        $user = auth()->user();

        return view('profile.edit', compact('user'));

    }
    public function update(ProfileRequest $request)
    {
        $user = auth()->user();
        $profile = $user->profile ?? new Profile();
        $profile->user_id = $user->id;

        if ($request->hasFile('user_image')) {
            $path = $request->file('user_image')->store('public/profile');
            $profile->image = basename($path);
        }

        $profile->name = $request->name;
        $profile->post_code = $request->post_code;
        $profile->address = $request->address;
        $profile->building = $request->building;
        $profile->save();

        return redirect('/mypage');
    }
}
