<div class="container">
    @foreach ($food_categories as $food_category)
        <h2>{{$food_categories}}</h2>
        @foreach ($categories as $category)
            @if ($category->$food_categories === $food_categories)
                <label class="kadai_002-sidebar-category-label"><a href="#">{{ $category->name }}</a></label>
            @endif
        @endforeach
    @endforeach
</div>