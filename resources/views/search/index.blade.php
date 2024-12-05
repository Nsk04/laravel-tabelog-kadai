@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>レストラン検索</h1>
    
    <!-- 検索フォーム -->
    <form action="{{ route('search') }}" method="GET" class="mb-4">
        <div class="row">
            <!-- レストラン名の検索 -->
            <div class="col-md-6">
                <input type="text" name="query" value="{{ request('query') }}" class="form-control" placeholder="レストラン名を入力">
            </div>

            <!-- カテゴリ検索 -->
            <div class="col-md-4">
                <select name="category" class="form-control">
                    <option value="">全てのカテゴリ</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- 検索ボタン -->
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">検索</button>
            </div>
        </div>
    </form>

    <!-- 検索結果の表示 -->
    @if ($restaurants->count() > 0)
        <p>検索結果: {{ $restaurants->total() }} 件が見つかりました。</p>
        <div class="row">
            @foreach ($restaurants as $restaurant)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="{{ asset('storage/' . $restaurant->image) }}" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">{{ $restaurant->name }}</h5>
                            <p class="card-text">{{ $restaurant->description }}</p>
                            <a href="{{ route('restaurants.show', $restaurant->id) }}" class="btn btn-primary">詳細を見る</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- ページネーション -->
        {{ $restaurants->links() }}
    @else
        <p>該当するレストランは見つかりませんでした。</p>
    @endif
</div>
@endsection
