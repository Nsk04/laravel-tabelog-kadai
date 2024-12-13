@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <h1>予約が完了しました</h1>
        <p>ご予約ありがとうございます。下記ボタンより、トップページに戻ります。</p>
        <a href="{{ route('top') }}" class="btn btn-success">トップページに戻る</a>
    </div>
@endsection
