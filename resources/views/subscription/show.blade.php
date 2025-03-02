@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">現在のカード情報</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
        <h5>現在のカード情報</h5>
            <p>カード番号: **** **** **** {{ Auth::user()->pm_last_four ?? '未登録' }}</p>
            <p>カードの種類: {{ Auth::user()->pm_type ?? '未登録' }}</p>
            <!-- <p>有効期限: {{ Auth::user()->card_expiry ?? '未登録' }}</p> -->
        </div>
    </div>
@endsection