<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        /** @var User $user */
        $user = auth()->user();

        return view('mypage.edit', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profiles', 'public');
            $user->profile_image = $path;
        }

        $user->name = $request->name;
        $user->postcode = $request->postcode;
        $user->address = $request->address;
        $user->building = $request->building;

        $user->save();

        return redirect('/mypage');
    }

    public function rules()
    {
        return [
            'image' => [
                'nullable',
                'mimes:jpeg,png'
            ],

            'name' => [
                'required',
                'max:20'
            ],

            'postcode' => [
                'required',
                'regex:/^\d{3}-\d{4}$/'
            ],

            'address' => [
                'required'
            ],
        ];
    }

}
