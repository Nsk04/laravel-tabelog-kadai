<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::all(); // 全カテゴリ取得
        $query = $request->input('query'); // 検索キーワード
        $categoryId = $request->input('category'); // カテゴリID
    
        // 検索条件を元にクエリを構築
        $restaurants = Restaurant::query();
    
        if (!empty($query) || !empty($categoryId)) {
            $restaurants->where(function ($q) use ($query, $categoryId) {
                if (!empty($query)) {
                    $q->where('name', 'LIKE', "%{$query}%");
                }
                if (!empty($categoryId)) {
                    $q->orWhere('category_id', $categoryId);
                }
            });
        }
    
        $restaurants = $restaurants->sortable()->paginate(15); // ページネーション
        $total_count = $restaurants->total(); // 検索結果件数
    
        // 現在のカテゴリ情報を取得 (必要に応じて)
        $category = $categoryId ? Category::find($categoryId) : null;
    
        return view('restaurants.index', compact(
            'restaurants', 'categories', 'query', 'category', 'total_count'
        ));
    }
    
        
    /*  public function index(Request $request)
    {
        $categories = Category::all();
        if ($request->category !== null) {
            $restaurants = Restaurant::where('category_id', $request->category)->sortable()->paginate(15);
            $total_count = Restaurant::where('category_id', $request->category)->count();
            $category = Category::find($request->category);
        } else {
            $restaurants = Restaurant::sortable()->paginate(15);
            $total_count = "";
            $category = null;
        }

        return view('restaurants.index', compact('restaurants', 'category', 'categories', 'total_count'));
    } */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         // ログインしていなければログイン画面へリダイレクト
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', '予約するにはログインが必要です。');
    }

    // ユーザー情報の取得
    $user = Auth::user();

    // 有料会員かつ有効期限内かどうかを確認
    if (!$user->premium_member || ($user->premium_member_expiration && $user->premium_member_expiration->lt(now()))) {
        return redirect()->route('restaurants.index')->with('error', '予約機能は有料会員限定です。会員登録または更新を行ってください。');
    }

     // カテゴリ情報を取得
    $categories = Category::all();

    return view('restaurants.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // ログインしていなければログイン画面へリダイレクト
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', '予約するにはログインが必要です。');
    }

    // ユーザー情報の取得
    $user = Auth::user();

    // 有料会員かつ有効期限内かどうかを確認
    if (!$user->premium_member || ($user->premium_member_expiration && $user->premium_member_expiration->lt(now()))) {
        return redirect()->route('restaurants.index')->with('error', '予約機能は有料会員限定です。会員登録または更新を行ってください。');
    }

        $restaurant = new Restaurant();
        $restaurant->name = $request->input('name');
        $restaurant->description = $request->input('description');
        $restaurant->lowest_price = $request->input('lowest_price');
        $restaurant->highest_price = $request->input('highest_price');
        $restaurant->phone_number = $request->input('phone_number');
        $restaurant->open_time = $request->input('open_time');
        $restaurant->close_time = $request->input('close_time');
        $restaurant->closed_day = $request->input('closed_day');
        $restaurant->post_code = $request->input('post_code');
        $restaurant->address = $request->input('address');
        $restaurant->category_id = $request->input('category_id');
        $restaurant->save();

        return redirect()->route('restaurants.index')->with('success', '店舗が登録されました。');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function show(Restaurant $restaurant)
    {
     // 店舗情報の表示（ログイン不要）
    $reviews = $restaurant->reviews()->get();

    return view('restaurants.show', compact('restaurant', 'reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function edit(Restaurant $restaurant)
    {
        $categories = Category::all();

        return view('restaurants.edit', compact('restaurant', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restaurant $restaurant)
    {
         // 必須フィールドにバリデーションを追加
        $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'lowest_price' => 'nullable|integer',
        'highest_price' => 'nullable|integer',
        'phone_number' => 'nullable|string|max:20',
        'open_time' => 'required', // 必須
        'close_time' => 'required', // 必須
        'closed_day' => 'nullable|string',
        'post_code' => 'nullable|string|max:10',
        'address' => 'nullable|string',
        'category_id' => 'nullable|exists:categories,id'
        ]);

        $restaurant->name = $request->input('name');
        $restaurant->description = $request->input('description');
        $restaurant->lowest_price = $request->input('lowest_price');
        $restaurant->highest_price = $request->input('highest_price');
        $restaurant->phone_number = $request->input('phone_number');
        $restaurant->open_time = $request->input('open_time');
        $restaurant->close_time = $request->input('close_time');
        $restaurant->closed_day = $request->input('closed_day');
        $restaurant->post_code = $request->input('post_code');
        $restaurant->address = $request->input('address');
        $restaurant->category_id = $request->input('category_id');
        $restaurant->save();

        return to_route('restaurants.index')->with('success', '店舗情報が更新されました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();

        return redirect()->route('restaurants.index')->with('success', 'レストランを削除しました。');
    }

    public function favorite(Restaurant $restaurant)
    {
        // ユーザーを取得
    $user = Auth::user();

    // 有料会員か確認
    if (!$user->premium_member) {
        return redirect()->route('subscription.create')
            ->with('error', 'お気に入り機能は有料会員限定です。');
    }
    
        Auth::user()->togglefavorite($restaurant);

        return back()->with('success', 'お気に入り状態が更新されました。');
    }
}
