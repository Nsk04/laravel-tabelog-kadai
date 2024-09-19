<div class="container">
    @foreach ($categories as $category)
        <label class="kadai_002-sidebar-category-label"><a href="{{ route('restaurants.index', ['category' => $category->id]) }}">{{ $category->name }}</a></label>
    @endforeach
</div>