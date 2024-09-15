<div>
    <h2>Add New Restaurant</h2>
</div>
<div>
    <a href="{{ route('restaurants.index') }}"> Back</a>
</div>

<form action="{{ route('restaurants.store') }}" method="POST">
    @csrf

    <div>
        <strong>Name:</strong>
        <input type="text" name="name" placeholder="Name">
    </div>
    <div>
        <strong>Image:</strong>
        <input type="text" name="image" placeholder="Image">
    </div>
    <div>
        <strong>Description:</strong>
        <textarea style="height:150px" placeholder="description"></textarea>
    </div>
    <div>
        <strong>Lowest Price:</strong>
        <input type="number" name="low_price" placeholder="Lowest Price">
    </div>
    <div>
        <strong>Highest Price:</strong>
        <input type="number" name="high_price" placeholder="Highest Price">
    </div>
    <div>
        <strong>Phone Number:</strong>
        <input type="tel" name="name" placeholder="Phone Number">
    </div>
    <div>
        <strong>Open Time:</strong>
        <input type="time" name="name" placeholder="Open Time">
    </div>
    <div>
        <strong>Close Time:</strong>
        <input type="time" name="name" placeholder="Close Time">
    </div>
    <div>
        <strong>Closed Day:</strong>
        <input type="text" name="name" placeholder="Closed Day">
    </div>
    <div>
        <strong>Post Code:</strong>
        <input type="text" name="name" placeholder="Post Code">
    </div>
    <div>
        <strong>Address:</strong>
        <input type="text" name="address" placeholder="Address">
    </div>
    <div>
        <strong>Category:</strong>
        <select name="category_id">
        @foreach ($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
        </select>
    </div>
    <div>
        <button type="submit">Submit</button>
    </div>

</form>