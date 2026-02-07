<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Item;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Item $item)
    {
        $request->validate([
            'comment' => 'required|max:255',
        ]);

        Comment::create([
            'item_id' => $item->id,
            'comment' => $request->comment,
        ]);

        return back();
    }
}