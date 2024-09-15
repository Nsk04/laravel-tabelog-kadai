<div>
    <h2> Show Product</h2>
</div>
<div>
    <a href="{{ route('restaurants.index') }}"> Back</a>
</div>

<div>
    <strong>Name:</strong>
    {{$restaurant->name}}
</div>

<div>
    <strong>Image:</strong>
    {{$$restaurant->image}}
</div>

<div>
    <strong>Description:</strong>
    {{$product->description}}
</div>

<div>
    <strong>Lowest Price:</strong>
    {{$restaurant->lowest_price}} 
</div>

<div>
    <strong>Highest Price:</strong>
    {{$restaurant->highest_price}} 
</div>

<div>
    <strong>Phone Number:</strong>
    {{$restaurant->phone_number}} 
</div>

<div>
    <strong>Open Time:</strong>
    {{ $restaurant->open_time}} 
</div>

<div>
    <strong>Close Time:</strong>
    {{$restaurant->close_time}} 
</div>

<div>
    <strong>Closed Day:</strong>
    {{$restaurant->closed_day}} 
</div>

<div>
    <strong>Post Code:</strong>
    {{$restaurant->post_code}}
</div>

<div>
    <strong>Address:</strong>
    {{$restaurant->address}} 
</div>