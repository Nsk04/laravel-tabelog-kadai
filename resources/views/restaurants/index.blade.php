
@extends('layouts.app')

@section('content')
<div class="row">
    <!-- サイドバー: カテゴリ一覧 -->
    <div class="col-2">
        @component('components.sidebar', ['categories' => $categories])
        @endcomponent
    </div>

    <div class="col-9">
        <div class="container">
            <!-- エラーメッセージの表示 -->
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <!-- 検索条件の結果を表示 -->
            @if ($total_count > 0)
                <div class="alert alert-info">
                    {{-- 検索キーワードが設定されている場合 --}}
                    @if (!empty($query))
                        「<strong>{{ $query }}</strong>」のキーワード
                    @endif
                    {{-- カテゴリが設定されている場合 --}}
                    @if ($category !== null)
                        @if (!empty($query)) と @endif
                        「<strong>{{ $category->name }}</strong>」カテゴリ
                    @endif
                    で検索しました。該当件数は<strong>{{ $total_count }}</strong>件です。
                </div>
            @else
                <div class="alert alert-warning">
                    条件に一致するレストランが見つかりませんでした。
                </div>
            @endif
        </div>

        <!-- 表示順リンク -->
        <div class="mb-3">
            表示順:
            @sortablelink('lowest_price', '価格順')
            @sortablelink('score', '評価順')
        </div>

        <!-- レストラン一覧の表示 -->
        <div class="container mt-4">
            <div class="row w-100">
                @foreach($restaurants as $restaurant)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <!-- レストランカード -->
                    <div class="restaurant-card">
                        <a href="{{ route('restaurants.show', $restaurant) }}">
                            @if ($restaurant->image !== "")
                                <img src="{{ asset($restaurant->image) }}" alt="{{ $restaurant->name }}" class="img-thumbnail">
                            @else
                                <img src="{{ asset('img/korea.png')}}" alt="デフォルト画像" class="img-thumbnail">
                            @endif
                        </a>
                        <div class="details mt-2">
                            <h5>{{ $restaurant->name }}</h5>
                            <p>￥{{ $restaurant->lowest_price }}〜￥{{ $restaurant->highest_price }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- ページネーション -->
        {{ $restaurants->appends(request()->query())->links() }}
    </div>
</div>
@endsection
