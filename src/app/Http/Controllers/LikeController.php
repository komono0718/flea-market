<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Item $item)
    {

        $userId = Auth::id();

$like = Like::where('item_id', $item->id)
    ->where('user_id', $userId)
    ->first();

if ($like) {
    $like->delete();
} else {
    Like::create([
        'item_id' => $item->id,
        'user_id' => $userId,
    ]);
        }

        return back();
    }
}