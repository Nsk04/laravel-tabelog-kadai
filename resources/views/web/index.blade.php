@extends('layouts.app')

@section('content')

<div class="top-page-container">
    <div class="overlay">
        <div class="search-container text-center">
            <h1 class="search-title">お店を探す</h1>
            <form action="{{ route('restaurants.index') }}" method="GET" class="d-flex mb-4">
                <input type="text" name="query" value="{{ request('query') }}" class="form-control w-50" placeholder="レストラン名を入力">
                <select name="category" class="form-control w-50">
                    <option value="">すべてのカテゴリ</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-success ml-2">検索</button>
            </form>
        </div>
    </div>
</div>
<br>
<br>
<div class="container mt-5">
    <h2 class="restaurant-top text-center">店舗</h2>
    <div class="row">
        @foreach($restaurants as $restaurant)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="restaurant-card">
                    <a href="{{ route('restaurants.show', $restaurant) }}">
                        <img src="{{ $restaurant->image ?: asset('img/default.jpg') }}" alt="{{ $restaurant->name }}" class="img-thumbnail">
                    </a>
                    <div class="details mt-2">
                        <h5>{{ $restaurant->name }}</h5>
                        <p>￥{{ $restaurant->lowest_price }}〜￥{{ $restaurant->highest_price }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $restaurants->links() }}
</div>

@endsection
