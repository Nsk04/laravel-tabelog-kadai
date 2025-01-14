<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = Review::all();

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
        $user = Auth::user();
        $user->refresh(); // ユーザー情報をリフレッシュ

        $request->validate([
            'content' => 'required',
            'score' => 'required|integer|min:1|max:5',
    ]);

        $review = new Review();
        $review->content = $request->input('content');
        $review->score = $request->input('score');
        $review->restaurant_id = $request->input('restaurant_id');
        $review->user_id = Auth::user()->id;
        $review->save();

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {

        if ($review->user_id !== Auth::id()) {
            return redirect()->route('restaurants.show', $review->restaurant_id)->with('error', '権限がありません。');
        }

        return view('reviews.edit', compact('review'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        $request->validate([
            'content' => 'required',
            'score' => 'required|integer|min:1|max:5',
        ]);

        if ($review->user_id !== Auth::id()) {
            return redirect()->route('restaurants.show', $review->restaurant_id)->with('error', '権限がありません。');
        }

        $review->update([
            'score' => $request->score,
            'content' => $request->content,
        ]);

        return redirect()->route('restaurants.show', $review->restaurant_id)->with('success', 'レビューを更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            return redirect()->route('restaurants.show', $review->restaurant_id)->with('error', '権限がありません。');
        }

        $review->delete();

        return redirect()->route('restaurants.show', $review->restaurant_id)->with('success', 'レビューを削除しました。');
    
    }

}


