@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h2>有料会員登録が完了しました！</h2>
    <p>この度は、有料会員にご登録いただきありがとうございます。</p>
    <a href="{{ route('top') }}" class="btn btn-success">ホームに戻る</a>
</div>
@endsection
