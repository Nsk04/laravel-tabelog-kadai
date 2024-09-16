
<a href="{{ route('restaurants.create') }}"> Create New Restaurant</a>

<table>
    <tr>
        <th>Category ID</th>
        <th>Name</th>
        <!-- <th>Image</th> -->
        <th>Description</th>
        <th>Lowest Price</th>
        <th>Highest Price</th>
        <th>Phone Number</th>
        <th>Open Time</th>
        <th>Close Time</th>
        <th>Closed Day</th>
        <th>Post Code</th>
        <th>Address</th>
        <th >Action</th>
    </tr>
    @foreach ($restaurants as $restaurant)
    <tr>
        <td>{{ $restaurant->category_id }}</td>
        <td>{{ $restaurant->name }}</td>
        <!-- <td>{{ $restaurant->image }}</td> -->
        <td>{{ $restaurant->description }}</td>
        <td>{{ $restaurant->lowest_price }}</td>
        <td>{{ $restaurant->highest_price }}</td>
        <td>{{ $restaurant->phone_number }}</td>
        <td>{{ $restaurant-open_time }}</td>
        <td>{{ $restaurant->close_time }}</td>
        <td>{{ $restaurant->closed_day }}</td>
        <td>{{ $restaurant->post_code }}</td>
        <td>{{ $restaurant->address }}</td>
        <td>
          <form action="{{ route('restaurants.destroy',$restaurant->id) }}" method="POST">
            <a href="{{ route('restaurants.show',$restaurant->id) }}">Show</a>
            <a href="{{ route('restaurants.edit',$restaurant->id) }}">Edit</a>
          @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
          </form>
        </td>
    </tr>
    @endforeach
</table>
