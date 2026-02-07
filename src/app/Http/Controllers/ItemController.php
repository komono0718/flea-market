<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;
use App\Models\Purchase;

class ItemController extends Controller
{
public function index(Request $request)
{
    // マイリストか？
    if ($request->tab === 'mylist') {

        if (!Auth::check()) {
            $items = collect();
        } else {
            $items = Item::whereIn(
                'id',
                Like::where('user_id', Auth::id())->pluck('item_id')
            )->get();
        }

    } else {
        // 通常一覧
        $query = Item::with('purchase');

        if (Auth::check()) {
            $query->where('user_id', '!=', Auth::id());
        }

        $items = $query->get();
    }

    return view('items.index', compact('items'));
}
    public function show(Item $item)
    {
        $item->load('comments', 'likes');

        return view('items.show', compact('item'));
    }

public function mylist()
{
    $userId = Auth::id();

    $items = Item::whereIn(
        'id',
        Like::where('user_id', $userId)->pluck('item_id')
    )->get();

    return view('items.index', compact('items'));
}

public function purchase(Item $item)
{
    Purchase::create([
        'user_id' => auth()->id(),
        'item_id' => $item->id,
    ]);

    return redirect('/');
}

}
