<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyPageController extends Controller
{
    public function index()
{
    $user = Auth::user();

    return view('mypage', compact('user'));
}
}
