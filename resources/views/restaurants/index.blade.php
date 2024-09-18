<!-- 
<a href="{{ route('restaurants.create') }}"> Create New Restaurant</a>

<table>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Lowest Price</th>
        <th>Highest Price</th>
        <th>Phone Number</th>
        <th>Open Time</th>
        <th>Close Time</th>
        <th>Closed Day</th>
        <th>Post Code</th>
        <th>Address</th>
        <th>Category ID</th>
        <th >Action</th>
    </tr>
    @foreach ($restaurants as $restaurant)
    <tr>
        <td>{{ $restaurant->name }}</td>
        <td>{{ $restaurant->description }}</td>
        <td>{{ $restaurant->lowest_price }}</td>
        <td>{{ $restaurant->highest_price }}</td>
        <td>{{ $restaurant->phone_number }}</td>
        <td>{{ $restaurant->open_time }}</td>
        <td>{{ $restaurant->close_time }}</td>
        <td>{{ $restaurant->closed_day }}</td>
        <td>{{ $restaurant->post_code }}</td>
        <td>{{ $restaurant->address }}</td>
        <td>{{ $restaurant->category_id }}</td>
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
</table> -->

@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-2">
        @component('components.sidebar', ['categories' => $categories, 'food_categories' => $food_categories])
        @endcomponent
    </div>
    <div class="col-9">
        <div class="container mt-4">
            <div class="row w-100">
                @foreach($restaurants as $restaurant)
                <div class="col-3">
                    <a href="{{route('restaurants.show', $restaurant)}}">
                        <img src="{{ asset('img/korea.png')}}" class="img-thumbnail">
                    </a>
                    <div class="row">
                        <div class="col-12">
                            <p class="kadai_002-restaurant-label mt-2">
                                {{$restaurant->name}}<br>
                                <label>￥{{$restaurant->lowest_price}}</label>~<label>￥{{$restaurant->highest_price}}</label>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        {{ $restaurants->links() }}
    </div>
</div>
@endsection
