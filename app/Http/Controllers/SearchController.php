<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Category;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        // クエリパラメータの取得
        $query = $request->input('query'); // レストラン名のキーワード
        $categoryId = $request->input('category'); // カテゴリID

        // 検索クエリの構築
        $restaurants = Restaurant::query();

        // レストラン名の部分一致検索
        if (!empty($query)) {
            $restaurants->where('name', 'LIKE', "%{$query}%");
        }

        // カテゴリフィルタリング
        if (!empty($categoryId)) {
            $restaurants->where('category_id', $categoryId);
        }

        // 結果を取得（ページネーション付き）
        $restaurants = $restaurants->paginate(10);

        // 全てのカテゴリを取得（ドロップダウン用）
        $categories = Category::all();

        // 検索条件と結果をビューに渡す
        return view('search.index', [
            'restaurants' => $restaurants,
            'categories' => $categories,
            'query' => $query,
            'categoryId' => $categoryId,
        ]);
    }

}
