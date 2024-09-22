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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $restaurant = new Restaurant();
        $restaurant->name = $request->input('name');
        /* $restaurant->image = $request->input('image'); */
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

        return to_route('restaurants.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function show(Restaurant $restaurant)
    {
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
        $restaurant = new Restaurant();
        $restaurant->name = $request->input('name');
        /* $restaurant->image = $request->input('image'); */
        $restaurant->description = $request->input('description');
        $restaurant->lowest_price = $request->input('lowest_price');
        $restaurant->highest_price = $request->input('highest_price');
        $restaurant->phone_number = $request->input('phone_number');
        $restaurant->open_time = $request->input('open_time');
        $restaurant->close_time = $request->input('close_time');
        $restaurant->closed_day = $request->input('closed_time');
        $restaurant->post_code = $request->input('post_code');
        $restaurant->address = $request->input('address');
        $restaurant->category_id = $request->input('category_id');
        $restaurant->update();

        return to_route('restaurants.index');
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

        return to_route('restaurants.index');
    }

    public function favorite(Restaurant $restaurant)
    {
        Auth::user()->togglefavorite($restaurant);

        return back();
    }
}
