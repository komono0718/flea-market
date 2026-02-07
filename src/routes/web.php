    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\ItemController;
    use App\Http\Controllers\CommentController;
    use App\Http\Controllers\LikeController;

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    */

        Route::get('/', [ItemController::class, 'index']);
        Route::get('/item/{item}', [ItemController::class, 'show']);

        Route::middleware('auth')->group(function () {

        Route::post('/item/{item}/comment', [CommentController::class, 'store']);
        Route::post('/item/{item}/like', [LikeController::class, 'toggle']);

        Route::get('/mypage', function () {
        return view('mypage');
        });

        Route::get('/mypage/edit', function () {
        return view('mypage_edit');
        });

        Route::post('/mypage/edit', function () {
        return redirect('/mypage');
        });

        Route::post('/mypage/profile', function () {
        return redirect('/mypage');
        });

        Route::get('/sell', function () {
        return view('sell');
        });

        Route::post('/sell', function () {

        \App\Models\Item::create([
            'name' => request('name'),
            'price' => request('price'),
            'brand' => request('brand'),
            'description' => request('description'),
            'img_url' => request('img_url'),
            'condition' => '良好',
            'user_id' => auth()->id(),
        ]);

        return redirect('/');
        });
    });

    Route::post('/purchase/{item}', [ItemController::class, 'purchase'])->middleware('auth');