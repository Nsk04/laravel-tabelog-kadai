@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-center">
    <div class="row w-75">
        <div class="col-5 offset-1">
            <img src="{{ asset('img/korea.png')}}" class="w-100 img-fluid">
        </div>
        <div class="col">
            <div class="d-flex flex-column">
                <h1 class="">{{ $restaurant->name }}</h1>
                <hr>
                <b>店舗説明</b>
                <p class="">{{ $restaurant->description }}</p>
                <hr>
                <b>予算</b>
                <p class="">￥{{ $restaurant->lowest_price }}~{{ $restaurant->highest_price }}</p>
                <hr>
                <b>電話番号</b>
                <p class="">{{ $restaurant->phone_number }}</p>
                <hr>
                <b>営業時間</b>
                <p class="">{{ date('H:i', strtotime($restaurant->open_time)) }}~{{ date('H:i', strtotime($restaurant->close_time)) }}</p>
                <hr>
                <b>定休日</b>
                <p class="">{{ $restaurant->closed_day }}</p>
                <hr>
                <b>住所</b>
                <p class="">{{ $restaurant->post_code }}</p>
                <p class="">{{ $restaurant->address }}</p>

                <!-- 予約ボタン -->
                <div class="mt-4">
                    @auth
                        @if(Auth::user()->premium_member)
                            <a href="{{ route('restaurants.reservations.create', $restaurant->id) }}" class="btn btn-primary">予約する</a>
                        @else
                            <a href="{{ route('subscription.create') }}" class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('upgrade-form-reservation').submit();">予約する</a>
                            <form id="upgrade-form-reservation" action="{{ route('subscription.create') }}" method="GET" style="display: none;">
                                @csrf
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">ログインして予約する</a>
                    @endauth
                </div>
            </div>

            <!-- お気に入り機能 -->
            <div class="mt-4">
                <form method="POST" action="{{ route('restaurants.favorite', $restaurant) }}">
                    @csrf
                    @auth
                        @if(Auth::user()->premium_member)
                            @if($restaurant->isFavoritedBy(Auth::user()))
                                <button type="submit" class="btn kadai_002-favorite-button text-favorite w-100">
                                    <i class="fa fa-heart"></i> お気に入り解除
                                </button>
                            @else
                                <button type="submit" class="btn kadai_002-favorite-button text-favorite w-100">
                                    <i class="fa fa-heart"></i> お気に入り
                                </button>
                            @endif
                        @else
                            <a href="{{ route('subscription.create') }}" class="btn kadai_002-favorite-button text-favorite w-100" onclick="event.preventDefault(); document.getElementById('upgrade-form-favorite').submit();">
                                <i class="fa fa-heart"></i> お気に入り
                            </a>
                            <form id="upgrade-form-favorite" action="{{ route('subscription.create') }}" method="GET" style="display: none;">
                                @csrf
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">ログインしてお気に入りに追加</a>
                    @endauth
                </form>
            </div>
        </div>

        <!-- レビューリスト -->
        <div class="offset-1 col-11 mt-4">
            <hr class="w-100">
            <h3 class="float-left">レビュー</h3>
        </div>

        <div class="offset-1 col-10 mt-4">
            <div class="row">
                @foreach($reviews as $review)
                    <div class="col-md-10 offset-md-1">
                        <h3 class="review-score-color">{{ str_repeat('★', $review->score) }}</h3>
                        <p class="h3">{{ $review->content }}</p>
                        <label>{{ $review->created_at }} {{ $review->user->name }}</label>
                        @if($review->user_id === Auth::id())
                            <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-secondary">編集</a>
                            <form method="POST" action="{{ route('reviews.destroy', $review->id) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">削除</button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- レビュー投稿フォーム -->
            <div class="row mt-4">
                <div class="col-md-10 offset-md-1">
                    @auth
                        @if(Auth::user()->premium_member)
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
                                <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                                <button type="submit" class="btn btn-info w-50">レビューを追加</button>
                            </form>
                        @else
                            <a href="{{ route('subscription.create') }}" class="btn btn-info w-50" onclick="event.preventDefault(); document.getElementById('upgrade-form-review').submit();">レビューを追加</a>
                            <form id="upgrade-form-review" action="{{ route('subscription.create') }}" method="GET" style="display: none;">
                                @csrf
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">ログインしてレビューを追加する</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
