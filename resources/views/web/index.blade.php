@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-2">
        @component('components.sidebar', ['categories' => $categories])
        @endcomponent
    </div>
    <form action="{{ route('search') }}" method="GET" class="d-flex justify-content-center">
    <input type="text" name="query" value="{{ request('query') }}" class="form-control w-50" placeholder="レストラン名を入力">
    <button type="submit" class="btn btn-primary ml-2">検索</button>
</form>

    <div class="col-9">
        <h1>店舗</h1>
        <div class="row">
            <div class="col-4">
                <a href="#">
                    <img src="{{ asset('img/korea.png') }}" class="img-thumbnail">
                </a>
</div>