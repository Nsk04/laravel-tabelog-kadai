@extends('layouts.app')

@section('content')

<div class="form-group">
        <label for="category-id">{{ __('カテゴリー') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
        <select class="form-control" id="category-id" name="category_id">
            @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

<div class="row">
    <div class="col-2">
        @component('components.sidebar', ['categories' => $categories])
        @endcomponent
    </div>
</div>


    