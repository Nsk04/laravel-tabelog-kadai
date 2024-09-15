<div>
    <h2>Edit Product</h2>
</div>
<div>
    <a href="{{ route('restaurants.index') }}"> Back</a>
</div>

<form action="{{ route('restaurants.update',$restaurant->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <strong>Name:</strong>
        <input type="text" name="name" value="{{ $restaurant->name }}" placeholder="Name">
    </div>
    <div>
        <strong>Image:</strong>
        <input type="text" name="image" value="{{ $restaurant->image }}" placeholder="Image">
    </div>
    <div>
        <strong>Description:</strong>
        <textarea style="height:150px" name="description" placeholder="description"></textarea>
    </div>
    <div>
        <strong>Lowest Price:</strong>
        <input type="number" name="low_price"  value="{{ $restaurant->low_price }}">
    </div>
    <div>
        <strong>Highest Price:</strong>
        <input type="number" name="high_price" value="{{ $restaurant->high_price }}">
    </div>
    <div>
        <strong>Phone Number:</strong>
        <input type="tel" name="name" value="{{ $restaurant->phone_number }}" placeholder="Phone Number">
    </div>
    <div>
        <strong>Open Time:</strong>
        <input type="time" name="name" value="{{ $restaurant->open_time }}" placeholder="Open Time">
    </div>
    <div>
        <strong>Close Time:</strong>
        <input type="time" name="name" value="{{ $restaurant->close_time }}" placeholder="Close Time">
    </div>
    <div>
        <strong>Closed Day:</strong>
        <input type="text" name="name" value="{{ $restaurant->closed_day }}" placeholder="Closed Day">
    </div>
    <div>
        <strong>Post Code:</strong>
        <input type="text" name="name" value="{{ $restaurant->post_code }}" placeholder="Post Code">
    </div>
    <div>
        <strong>Address:</strong>
        <input type="text" name="address" value="{{ $restaurant->address }}" placeholder="Address">
    </div>
    <div>
        <strong>Category:</strong>
        <select name="category_id">
        @foreach ($categories as $category)
            @if ($category->id == $restaurant->category_id)
                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
            @else
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endif
        @endforeach
        </select>
    </div>
    <div>
        <button type="submit">Submit</button>
    </div>

</form>
