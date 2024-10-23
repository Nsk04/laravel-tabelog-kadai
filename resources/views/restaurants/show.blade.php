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

                <!-- 予約ボタン -->
                @auth
                    @if(Auth::user()->premium_member && (!Auth::user()->premium_member_expiration || Auth::user()->premium_member_expiration->isFuture()))
                        <a href="{{ route('restaurants.reservations.create', $restaurant->id) }}" class="btn btn-primary">予約する</a>
                    @else
                        <p class="text-danger">予約するには有料会員になる必要があります。</p>
                        <a href="{{ route('subscription.create') }}" class="btn btn-secondary">有料会員にアップグレード</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">ログインして予約する</a>
                @endauth
            </div>

            <!-- お気に入り機能 -->
            <form method="POST" class="m-3 align-items-end">
                @csrf
                <input type="hidden" name="id" value="{{$restaurant->id}}">
                <input type="hidden" name="name" value="{{$restaurant->name}}">
                <input type="hidden" name="price" value="{{$restaurant->price}}">
                @if($restaurant->isFavoritedBy(Auth::user()))
                    <a href="{{ route('restaurants.favorite', $restaurant) }}" class="btn kadai_002-favorite-button text-favorite w-100">
                        <i class="fa fa-heart"></i> お気に入り解除
                    </a>
                @else
                    <a href="{{ route('restaurants.favorite', $restaurant) }}" class="btn kadai_002-favorite-button text-favorite w-100">
                        <i class="fa fa-heart"></i> お気に入り
                    </a>
                @endif
            </form>

            <!-- お気に入り機能の注意文言 -->
            @if(!Auth::user() || !Auth::user()->is_premium)
                <p class="text-danger">お気に入り機能を利用するには有料会員になる必要があります。</p>
            @endif
        </div>

        <div class="offset-1 col-11">
            <hr class="w-100">
            <h3 class="float-left">レビュー</h3>
        </div>

        <div class="offset-1 col-10">
            <div class="row">
                @foreach($reviews as $review)
                    <div class="offset-md-5 col-md-5">
                        <h3 class="review-score-color">{{ str_repeat('★', $review->score) }}</h3>
                        <p class="h3">{{$review->content}}</p>
                        <label>{{$review->created_at}} {{$review->user->name}}</label>
                    </div>
                    @if($review->user_id === Auth::id())
                        <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-secondary">編集</a>

                        <form method="POST" action="{{ route('reviews.destroy', $review->id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                    @endif
                @endforeach
            </div>
            <br />

            <!-- レビュー投稿フォーム（全ユーザーにボタン表示） -->
            <div class="row">
                <div class="offset-md-5 col-md-5">
                    <form method="POST" action="{{ route('reviews.store') }}">
                        @csrf
                        <h4>評価</h4>
                        <select name="score" class="form-control m-2 review-score-color">
                            <option value="5" class="review-score-color">★★★★★</option>
                            <option value="4" class="review-score-color">★★★★</option>
                            <option value="3" class="review-score-color">★★★</option>
                            <option value="2" class="review-score-color">★★</option>
                            <option value="1" class="review-score-color">★</option>
                        </select>
                        <h4>レビュー内容</h4>
                        @error('content')
                            <strong>レビュー内容を入力してください</strong>
                        @enderror
                        <textarea name="content" class="form-control m-2"></textarea>
                        <input type="hidden" name="restaurant_id" value="{{$restaurant->id}}">
                        <button type="submit" class="btn ml=2 btn-info w-50">レビューを追加</button>
                    </form>

                    <!-- 注意文言（有料会員への誘導） -->
                    @if(!Auth::user() || !Auth::user()->is_premium)
                        <p class="text-danger mt-2">レビューを投稿するには、有料会員になる必要があります。</p>
                        @auth
                            <a href="{{ route('subscription.create') }}" class="btn btn-secondary">有料会員にアップグレード</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
