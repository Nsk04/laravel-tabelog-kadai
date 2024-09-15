@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-9">
        <div class="container mt-4">
            <div class="row w-100">
                @foreach($products as $product)
                <div class="col-3">
                    <a href="{{route('restaurants.show', $restaurant)}}">
                        <img src="{{ asset('img/yakiniku.png')}}" class="img-thumbnail">
                    </a>
                    <div class="row">
                        <div class="col-12">
                            <p class="kadai_002-restaurant-label mt-2">
                                {{$restaurant->name}}<br>
                                <label>￥{{$restaurant->price}}</label>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection