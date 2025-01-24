@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('/js/reservation-modal.js') }}"></script>
@endpush

@section('content')
    <!-- 予約のキャンセル用モーダル -->
    <div class="modal fade" id="cancelReservationModal" tabindex="-1" aria-labelledby="cancelReservationModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelReservationModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                </div>
                <div class="modal-footer">
                    <form action="" method="post" name="cancelReservationForm">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn text-white shadow-sm kadai_002-btn-danger" onclick="return confirm('本当に実行しますか?');">削除</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container kadai_002-container pb-5">
        <div class="row justify-content-center">
            <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10">
                <nav class="my-3" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('top') }}">ホーム</a></li>
                        <li class="breadcrumb-item active" aria-current="page">予約一覧</li>
                    </ol>
                </nav>

                <h1 class="mb-3 text-center">予約一覧</h1>

                @if (session('flash_message'))
                    <div class="alert alert-info" role="alert">
                        <p class="mb-0">{{ session('flash_message') }}</p>
                    </div>
                @endif

                @if (session('error_message'))
                    <div class="alert alert-danger" role="alert">
                        <p class="mb-0">{{ session('error_message') }}</p>
                    </div>
                @endif

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">店舗名</th>
                            <th scope="col">予約日時</th>
                            <th scope="col">人数</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservations as $reservation)
                            <tr>
                                <td>
                                    <a href="{{ route('restaurants.show', ['restaurant' => $reservation->restaurant_id]) }}">
                                        {{ $reservation->restaurant_name }}
                                    </a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('Y年n月j日') }} {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}</td>
                                <td>{{ $reservation->reservation_people }}名</td>
                                <td>
                                    @if ($reservation->reserved_datetime < now())
                                        <form method="POST" action="{{ route('reservations.destroy' , $reservation->id)}}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-success" onclick="return confirm('本当に実行しますか?');">キャンセル</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection