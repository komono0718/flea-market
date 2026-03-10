<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;
use App\Models\Purchase;
use App\Models\Category;
use App\Http\Requests\ExhibitionRequest;

class ItemController extends Controller
{

    /*
|--------------------------------------------------------------------------
| 商品一覧
|--------------------------------------------------------------------------
*/
    public function index(Request $request)
    {
        if ($request->tab === 'mylist') {

            if (!Auth::check()) {
                $items = collect();
            } else {
                $query = Item::whereIn(
                    'id',
                    Like::where('user_id', Auth::id())->pluck('item_id')
                );

                if ($request->keyword) {
                    $query->where('name', 'like', '%' . $request->keyword . '%');
                }

                $items = $query->get();
            }

            return view('items.index', compact('items'));
        }

        $query = Item::with('purchase');

        if ($request->keyword) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        if (Auth::check()) {
            $query->where('user_id', '!=', Auth::id());
        }

        $items = $query->get();

        return view('items.index', compact('items'));
    }


    /*
|--------------------------------------------------------------------------
| 商品詳細
|--------------------------------------------------------------------------
*/
    public function show(Item $item)
    {
        // 商品詳細で必要な関連を全部読み込む
        $item->load([
            'categories',        // カテゴリ複数表示
            'likes',             // いいね数
            'comments.user',     // コメントしたユーザー情報
            'purchase',          // sold判定
            'user',              // 出品者
        ]);

        $likeCount = $item->likes->count();

        $isLiked = auth()->check()
            ? $item->likes->where('user_id', auth()->id())->isNotEmpty()
            : false;

        return view('items.show', compact('item', 'likeCount', 'isLiked'));
    }

    /*
|--------------------------------------------------------------------------
| いいね
|--------------------------------------------------------------------------
*/
    public function toggleLike(Item $item)
    {
        $like = Like::where('user_id', auth()->id())
            ->where('item_id', $item->id)
            ->first();

        if ($like) {
            $like->delete(); // 解除
        } else {
            Like::create([
                'user_id' => auth()->id(),
                'item_id' => $item->id,
            ]); // 登録
        }

        return back();
    }

    /*
|--------------------------------------------------------------------------
| マイリスト
|--------------------------------------------------------------------------
*/
    public function mylist()
    {
        if (!Auth::check()) {
            return view('items.index', ['items' => collect()]);
        }

        $items = Item::whereIn(
            'id',
            Like::where('user_id', Auth::id())->pluck('item_id')
        )->get();

        return view('items.index', compact('items'));
    }


    /*
|--------------------------------------------------------------------------
| 購入確認画面
|--------------------------------------------------------------------------
*/
    public function purchaseForm(Item $item)
    {
        $user = auth()->user();

        return view('purchase.index', compact('item', 'user'));
    }


    /*
|--------------------------------------------------------------------------
| 購入確定
|--------------------------------------------------------------------------
*/
    public function purchase(Item $item)
    {
        // 自分の商品は買えない
        if ($item->user_id === auth()->id()) {
            return back()->with('error', '自分の商品は購入できません');
        }

        // 既に売れてる
        if ($item->purchase) {
            return back()->with('error', 'この商品は売り切れです');
        }

        $user = auth()->user();

        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'postcode' => $user->postcode,
            'address' => $user->address,
            'building' => $user->building,
        ]);

        return redirect('/')->with('success', '購入しました');
    }


    /*
|--------------------------------------------------------------------------
| 住所変更
|--------------------------------------------------------------------------
*/
    public function addressForm(Item $item)
    {
        return view('purchase.address', compact('item'));
    }

    public function addressUpdate(Request $request, Item $item)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $user->postcode = $request->postcode;
        $user->address = $request->address;
        $user->building = $request->building;
        $user->save();

        return redirect('/purchase/' . $item->id);
    }


    /*
|--------------------------------------------------------------------------
| マイページ
|--------------------------------------------------------------------------
*/
    public function mypage()
    {
        $user = auth()->user();

        $purchases = Purchase::with('item')
            ->where('user_id', $user->id)
            ->get();

        $items = Item::where('user_id', $user->id)->get();

        return view('mypage', compact('user', 'purchases', 'items'));
    }


    /*
|--------------------------------------------------------------------------
| プロフィール更新
|--------------------------------------------------------------------------
*/
    public function profileUpdate(Request $request)
    {
        /** @var \App\Models\User $user */
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

    /*
|--------------------------------------------------------------------------
| 出品画面
|--------------------------------------------------------------------------
*/
    public function create()
    {
        $categories = Category::all();

        return view('sell', [
            'categories' => $categories
        ]);
    }
    /*
|--------------------------------------------------------------------------
| 出品保存
|--------------------------------------------------------------------------
*/
    public function store(ExhibitionRequest $request)
    {
        $path = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
        }

        $item = Item::create([
            'name' => $request->name,
            'brand' => $request->brand,
            'description' => $request->description,
            'price' => $request->price,
            'condition' => $request->condition,
            'img_url' => $path,
            'user_id' => auth()->id(),
        ]);

        if ($request->categories) {
            $item->categories()->attach($request->categories);
        }

        return redirect('/');
    }
}
