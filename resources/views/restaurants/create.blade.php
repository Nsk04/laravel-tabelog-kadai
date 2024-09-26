@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

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