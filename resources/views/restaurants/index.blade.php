
@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-2">
        @component('components.sidebar', ['categories' => $categories])
        @endcomponent
    </div>
    <div class="col-9">
    <div class="container">
            @if ($category !== null)
                <a href="{{ route('restaurants.index') }}">トップ</a> > {{ $category->name }}
                <h1>{{ $category->name }}の店舗一覧{{$total_count}}件</h1>
            @endif
        </div>
        <div>
            表示順
            @sortablelink('lowest_price', '価格')
        </div>
        <div class="container mt-4">
            <div class="row w-100">
                @foreach($restaurants as $restaurant)
                <div class="col-3">
                    <a href="{{route('restaurants.show', $restaurant)}}">
                        <img src="{{ asset('img/korea.png')}}" class="img-thumbnail">
                    </a>
                    <div class="row">
                        <div class="col-12">
                            <p class="kadai_002-restaurant-label mt-2">
                                {{$restaurant->name}}<br>
                                <label>￥{{$restaurant->lowest_price}}</label>~<label>￥{{$restaurant->highest_price}}</label>
                            </p>
                            <a href="{{ route('restaurants.reservations.create', $restaurant->id) }}" class="btn btn-primary">予約する</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        {{ $restaurants->appends(request()->query())->links() }}
    </div>
</div>
@endsection
