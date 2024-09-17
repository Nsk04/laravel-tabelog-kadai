<!-- <div>
    <h2>Edit Restaurnt</h2>
</div>
<div>
    <a href="{{ route('restaurants.index') }}"> Back</a>
</div>

<form action="{{ route('restaurants.update',$restaurant->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <strong>Name:</strong>
        <input type="text" name="name" value="{{ $restaurant->name }}" placeholder="Name">
    </div>
    <div>
        <strong>Description:</strong>
        <textarea style="height:150px" name="description" placeholder="description">{{ $restaurant->description }}</textarea>
    </div>
    <div>
        <strong>Lowest Price:</strong>
        <input type="number" name="lowest_price"  value="{{ $restaurant->lowest_price }}">
    </div>
    <div>
        <strong>Highest Price:</strong>
        <input type="number" name="highest_price" value="{{ $restaurant->highest_price }}">
    </div>
    <div>
        <strong>Phone Number:</strong>
        <input type="tel" name="phone_number" value="{{ $restaurant->phone_number }}" placeholder="Phone Number">
    </div>
    <div>
        <strong>Open Time:</strong>
        <input type="time" name="open_time" value="{{ $restaurant->open_time }}" placeholder="Open Time">
    </div>
    <div>
        <strong>Close Time:</strong>
        <input type="time" name="close_time" value="{{ $restaurant->close_time }}" placeholder="Close Time">
    </div>
    <div>
        <strong>Closed Day:</strong>
        <input type="text" name="closed_day" value="{{ $restaurant->closed_day }}" placeholder="Closed Day">
    </div>
    <div>
        <strong>Post Code:</strong>
        <input type="text" name="post_code" value="{{ $restaurant->post_code }}" placeholder="Post Code">
    </div>
    <div>
        <strong>Address:</strong>
        <input type="text" name="address" value="{{ $restaurant->address }}" placeholder="Address">
    </div>
    <div>
        <strong>Category:</strong>
        <select name="category_id">
        @foreach ($categories as $category)
            @if ($category->id == $restaurant->category_id)
                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
            @else
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endif
        @endforeach
        </select>
    </div>
    <div>
        <button type="submit">Submit</button>
    </div>

</form>
-->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>店舗情報更新</h1>

    <form action="{{ route('restaurants.update',$restaurant->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="restaurant-name">店舗名</label>
            <input type="text" name="name" id="restaurant-name" class="form-control" value="{{ $restaurant->name }}">
        </div>
        <div class="form-group">
            <label for="restaurant-description">店舗説明</label>
            <textarea name="description" id="restaurant-description" class="form-control">{{ $restaurant->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="restaurant-price">予算</label>
            <input type="number" name="lowest_price" id="restaurant-lowest_price" class="form-control" value="{{ $restaurant->lowest_price }}">
        </div>
        <div class="form-group">
            <label for="restaurant-price">予算</label>
            <input type="number" name="highest_price" id="restaurant-highest_price" class="form-control" value="{{ $restaurant->highest_price }}">
        </div>
        <div class="form-group">
            <label for="restaurant-name">電話番号</label>
            <input type="tel" name="phone_number" id="restaurant-phone_number" class="form-control" value="{{ $restaurant->phone_number }}">
        </div>
        <div class="form-group">
            <label for="restaurant-name">営業開始時間</label>
            <input type="time" name="opne_time" id="restaurant-open_time" class="form-control" value="{{ $restaurant->open_time }}">
        </div>
        <div class="form-group">
            <label for="restaurant-name">営業終了時間</label>
            <input type="time" name="name" id="restaurant-close_time" class="form-control" value="{{ $restaurant->close_time }}">
        </div>
        <div class="form-group">
            <label for="restaurant-name">定休日</label>
            <input type="text" name="closed_day" id="restaurant-closed_day" class="form-control" value="{{ $restaurant->closed_day }}">
        </div>
        <div class="form-group">
            <label for="prestaurant-name">郵便番号</label>
            <input type="text" name="post_code" id="restaurant-post_code" class="form-control" value="{{ $restaurant->post_code }}">
        </div>
        <div class="form-group">
            <label for="prestaurant-name">住所</label>
            <input type="text" name="address" id="restaurant-address" class="form-control" value="{{ $restaurant->address }}">
        </div>
        <div class="form-group">
            <label for="restaurant-category">カテゴリ</label>
            <select name="category_id" class="form-control" id="restaurant-category">
                @foreach ($categories as $category)
                @if ($category->id == $restaurant->category_id)
                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                @else
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endif
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-danger">更新</button>
    </form>

    <a href="{{ route('restaurants.index') }}">店舗一覧に戻る</a>
</div>
@endsection
