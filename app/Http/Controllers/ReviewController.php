<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'restaurant_id' => 'required|exists:restaurants,id' // ここで必須かつ存在するrestaurant_idであることを確認
    ]);

        $review = new Review();
        $review->content = $request->input('content');
        $review->score = $request->input('score');
        $review->restaurant_id = $request->input('restaurant_id');
        $review->user_id = Auth::user()->id;
        $review->save();

        return back();
    }

}


