@extends('layouts.app')

@section('content')
<div class="container">
    <h2>レビューの編集</h2>
    <form method="POST" action="{{ route('reviews.update', $review->id) }}">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="score">評価</label>
            <select name="score" class="form-control">
                <option value="5" @if($review->score == 5) selected @endif>★★★★★</option>
                <option value="4" @if($review->score == 4) selected @endif>★★★★</option>
                <option value="3" @if($review->score == 3) selected @endif>★★★</option>
                <option value="2" @if($review->score == 2) selected @endif>★★</option>
                <option value="1" @if($review->score == 1) selected @endif>★</option>
            </select>
        </div>

        <div class="form-group">
            <label for="content">レビュー内容</label>
            <textarea name="content" class="form-control" rows="5">{{ old('content', $review->content) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">更新</button>
    </form>

    <form method="POST" action="{{ route('reviews.destroy', $review->id) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger mt-3">削除</button>
    </form>
</div>
@endsection
