@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-center">
    <div class="row w-75">
        <div class="col-5 offset-1">
            <img src="{{ asset('img/korea.png')}}" class="w-100 img-fluid">
        </div>
        <div class="col">
            <div class="d-flex flex-column">
                <h1 class="">
                    {{$restaurant->name}}
                </h1>
                <hr>
                <b>店舗説明</b>
                <p class="">
                    {{$restaurant->description}}
                </p>
                <hr>
                <b>予算</b>
                <p class="">
                    ￥{{$restaurant->lowest_price}}~{{$restaurant->highest_price}}
                </p>
                <hr>
                <b>電話番号</b>
                <p class="">
                    {{$restaurant->phone_number}}
                </p>
                <hr>
                <b>営業時間</b>
                <p class="">
                    {{ date('H:i', strtotime($restaurant->open_time)) }}~{{ date('H:i', strtotime($restaurant->close_time)) }}

                </p>
                <hr>
                <b>定休日</b>
                <p class="">
                    {{$restaurant->closed_day}}
                </p>
                <hr>
                <b>住所</b>
                <p class="">
                    {{$restaurant->post_code}}
                </p>
                <p class="">
                    {{$restaurant->address}}
                </p>
            </div>
            @auth
            <form method="POST" class="m-3 align-items-end">
                @csrf
                <input type="hidden" name="id" value="{{$restaurant->id}}">
                <input type="hidden" name="name" value="{{$restaurant->name}}">
                <input type="hidden" name="price" value="{{$restaurant->price}}">
                @if($restaurant->isFavoritedBy(Auth::user()))
                        <a href="{{ route('restaurants.favorite', $restaurant) }}" class="btn kadai_002-favorite-button text-favorite w-100">
                            <i class="fa fa-heart"></i>
                            お気に入り解除
                        </a>
                        @else
                        <a href="{{ route('restaurants.favorite', $restaurant) }}" class="btn kadai_002-favorite-button text-favorite w-100">
                            <i class="fa fa-heart"></i>
                            お気に入り
                        </a>
                        @endif
                    </div>
                </div>
            </form>
            @endauth
        </div>

        <div class="offset-1 col-11">
            <hr class="w-100">
            <h3 class="float-left">レビュー</h3>
        </div>

        <div class="offset-1 col-10">
        <div class="row">
                @foreach($reviews as $review)
                <div class="offset-md-5 col-md-5">
                    <p class="h3">{{$review->content}}</p>
                    <label>{{$review->created_at}} {{$review->user->name}}</label>
                </div>
                @endforeach
            </div><br />

            @auth
            <div class="row">
                <div class="offset-md-5 col-md-5">
                    <form method="POST" action="{{ route('reviews.store') }}">
                        @csrf
                        <h4>レビュー内容</h4>
                        @error('content')
                            <strong>レビュー内容を入力してください</strong>
                        @enderror
                        <textarea name="content" class="form-control m-2"></textarea>
                        <input type="hidden" name="product_id" value="{{$restaurant->id}}">
                        <button type="submit" class="btn ml=2 btn-info w-50">レビューを追加</button>
                    </form>
                </div>
            </div>
            @endauth
        </div>
    </div>
</div>
@endsection