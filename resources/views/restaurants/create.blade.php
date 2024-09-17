<!-- <div>
    <h2>Add New Restaurant</h2>
</div>
<div>
    <a href="{{ route('restaurants.index') }}"> Back</a>
</div>

<form action="{{ route('restaurants.store') }}" method="POST">
    @csrf

    <div>
        <strong>Name:</strong>
        <input type="text" name="name" placeholder="Name">
    </div>
    <div>
        <strong>Image:</strong>
        <input type="text" name="image" placeholder="Image">
    </div>
    <div>
        <strong>Description:</strong>
        <textarea style="height:150px" name="description" placeholder="Description"></textarea>
    </div>
    <div>
        <strong>Lowest Price:</strong>
        <input type="number" name="lowest_price" placeholder="Lowest Price">
    </div>
    <div>
        <strong>Highest Price:</strong>
        <input type="number" name="highest_price" placeholder="Highest Price">
    </div>
    <div>
        <strong>Phone Number:</strong>
        <input type="tel" name="phone_number" placeholder="Phone Number">
    </div>
    <div>
        <strong>Open Time:</strong>
        <input type="time" name="open_time" placeholder="Open Time">
    </div>
    <div>
        <strong>Close Time:</strong>
        <input type="time" name="close_time" placeholder="Close Time">
    </div>
    <div>
        <strong>Closed Day:</strong>
        <input type="text" name="closed_time" placeholder="Closed Day">
    </div>
    <div>
        <strong>Post Code:</strong>
        <input type="text" name="post_code" placeholder="Post Code">
    </div>
    <div>
        <strong>Address:</strong>
        <input type="text" name="address" placeholder="Address">
    </div>
    <div>
        <strong>Category:</strong>
        <select name="category_id">
        @foreach ($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
        </select>
    </div>
    <div>
        <button type="submit">Submit</button>
    </div>

</form> -->


@extends('layouts.app')

@section('content')
<div class="container">
    <h1>新しい店舗を追加</h1>

    <form action="{{ route('restaurants.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="restaurant-name">店舗名</label>
            <input type="text" name="name" id="product-name" class="form-control">
        </div>
        <div class="form-group">
            <label for="restaurant-description">店舗説明</label>
            <textarea name="description" id="restaurant-description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="restaurant-price">予算(低)</label>
            <input type="number" name="lowest_price" id="restaurant-lowest_price" class="form-control">
        </div>
        <div class="form-group">
            <label for="restaurant-price">予算(高)</label>
            <input type="number" name="highest_price" id="restaurant-highest_price" class="form-control">
        </div>
        <div class="form-group">
            <label for="restaurant-price">電話番号</label>
            <input type="tel" name="phone_number" id="restaurant-phone_number" class="form-control">
        </div>
        <div class="form-group">
            <label for="restaurant-open_time">営業開始時間</label>
            <input type="time" name="open_time" id="restaurant-open_time" class="form-control">
        </div>
        <div class="form-group">
            <label for="restaurant-price">営業終了時間</label>
            <input type="time" name="close_time" id="restaurant-close_time" class="form-control">
        </div>
        <div class="form-group">
            <label for="restaurant-price">定休日</label>
            <input type="text" name="closed_day" id="restaurant-closed_day" class="form-control">
        </div>
        <div class="form-group">
            <label for="restaurant-price">郵便番号</label>
            <input type="text" name="post_code" id="restaurant-post_code" class="form-control">
        </div>
        <div class="form-group">
            <label for="restaurant-price">住所</label>
            <input type="text" name="address" id="restaurant-address" class="form-control">
        </div>
        <div class="form-group">
            <label for="restaurant-category">カテゴリ</label>
            <select name="category_id" class="form-control" id="restaurant-category">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">店舗を登録</button>
    </form>

    <a href="{{ route('restaurants.index') }}">店舗一覧に戻る</a>
</div>
@endsection