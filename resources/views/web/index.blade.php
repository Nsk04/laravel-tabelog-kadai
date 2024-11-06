@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-2">
        @component('components.sidebar', ['categories' => $categories])
        @endcomponent
    </div>
</div>