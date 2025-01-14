@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-center">
    <div class="row w-75">
        <div class="col-5 offset-1">
            @if ($restaurant->image !== "")
            <img src="{{ asset($restaurant->image) }}" class="img-thumbnail">
            @else
            <img src="{{ asset('img/korea.png')}}" class="img-thumbnail">
            @endif
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
                <p class="">{{ $restaurant->formatted_open_time }}~{{ $restaurant->formatted_close_time }}</p>
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
                        <!-- デバッグコード -->
                        <p>デバッグ: ユーザー名 = {{ Auth::user()->name }}</p>
                        <p>デバッグ: 有料会員ステータス = {{ Auth::user()->premium_member ? '有効' : '無効' }}</p>

                        @if(Auth::user()->premium_member)
                            <a href="{{ route('restaurants.reservations.create', $restaurant->id) }}" class="btn btn-outline-success w-100">予約する</a>
                        @else
                            <a href="{{ route('subscription.create') }}" class="btn btn-outline-success w-100" onclick="event.preventDefault(); document.getElementById('upgrade-form-reservation').submit();">予約する</a>
                            <form id="upgrade-form-reservation" action="{{ route('subscription.create') }}" method="GET" style="display: none;">
                                @csrf
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-success w-100">予約する</a>
                    @endauth
                </div>
            </div>

            <!-- お気に入り機能 -->
            <div class="mt-4">
                @auth
                    @if(Auth::user()->premium_member)
                        <p>デバッグ: ユーザー名 = {{ Auth::user()->name }}</p>
                        <p>デバッグ: 有料会員ステータス = {{ Auth::user()->premium_member ? '有効' : '無効' }}</p>
                        @if($restaurant->isFavoritedBy(Auth::user()))
                            <form method="POST" action="{{ route('restaurants.favorite', $restaurant) }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-success w-100">
                                    <i class="fa fa-heart"></i> お気に入り解除
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('restaurants.favorite', $restaurant) }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-success w-100">
                                    <i class="fa fa-heart"></i> お気に入り
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('subscription.create') }}" class="btn btn-outline-success w-100">
                            <i class="fa fa-heart"></i> お気に入り
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-success w-100">お気に入り</a>
                @endauth
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
                    <!-- デバッグコード -->
                            <p>デバッグ: ユーザー名 = {{ Auth::user()->name }}</p>
                            <p>デバッグ: 有料会員ステータス = {{ Auth::user()->premium_member ? '有効' : '無効' }}</p>
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
                            <a href="{{ route('subscription.create') }}" class="btn btn-outline-success w-100" onclick="event.preventDefault(); document.getElementById('upgrade-form-review').submit();">レビューを追加</a>
                            <form id="upgrade-form-review" action="{{ route('subscription.create') }}" method="GET" style="display: none;">
                                @csrf
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-success w-100">レビューを追加</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
