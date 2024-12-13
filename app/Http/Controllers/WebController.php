<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Restaurant;

use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $restaurants = Restaurant::paginate(8); // 店舗一覧をページネーション

        return view('web.index', compact('categories', 'restaurants'));
    }
}
