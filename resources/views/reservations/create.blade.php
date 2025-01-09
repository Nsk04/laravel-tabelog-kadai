@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ja.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const closedDays = @json($closedDays);

            flatpickr("#reservation_date", {
                enableTime: false,
                dateFormat: "Y-m-d",
                locale: "ja",
                minDate: "today",
                disable: [
                    function(date) {
                        const dayOfWeek = date.getDay();
                        return closedDays.includes(dayOfWeek);
                    }
                ],
            });

            console.log("Min time: {{ $minReservationTime }}");
            console.log("Max time: {{ $maxReservationTime }}");

            flatpickr("#reservation_time", {
                enableTime: true, 
                noCalendar: true, 
                dateFormat: "H:i",
                time_24hr: true,
                minuteIncrement: 30,
                minTime: "{{ $minReservationTime }}",  // 予約可能開始時刻
                maxTime: "{{ $maxReservationTime }}",  // 予約可能終了時刻
                onReady: function() {
                    console.log("Flatpickr initialized with minTime:", "{{ $minReservationTime }}");
                    console.log("Flatpickr initialized with maxTime:", "{{ $maxReservationTime }}");
                }
            });
        });
    </script>
@endpush



@section('content')
    <div class="container kadai_002-container pb-5">
        <div class="row justify-content-center">
            <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10">
                <nav class="my-3" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">ホーム</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('restaurants.index') }}">店舗一覧</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('restaurants.show', $restaurant->id) }}">店舗詳細</a></li>
                        <li class="breadcrumb-item active" aria-current="page">予約</li>
                    </ol>
                </nav>

                <h1 class="mb-2 text-center">{{ $restaurant->name }}</h1>
                <p class="text-center">
                    <span class="kadai_002-star-rating me-1" data-rate="{{ round($restaurant->reviews->avg('score') * 2) / 2 }}"></span>
                    {{ number_format(round($restaurant->reviews->avg('score'), 2), 2) }}（{{ $restaurant->reviews->count() }}件）
                </p>

                @if (session('flash_message'))
                    <div class="alert alert-info" role="alert">
                        <p class="mb-0">{{ session('flash_message') }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('restaurants.reservations.store') }}">
                    @csrf

                    <input type="hidden" name="restaurant_id", value="{{ $restaurant->id }}">
                    <div class="form-group row mb-3">
                        <label for="reservation_date" class="col-md-5 col-form-label text-md-left fw-bold">予約日</label>

                        <div class="col-md-7">
                            <input type="text" class="form-control" id="reservation_date" name="reservation_date" value="{{ old('reservation_date') }}">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="reservation_time" class="col-md-5 col-form-label text-md-left fw-bold">時間</label>

                        <div class="col-md-7">
                            <select class="form-control form-select" id="reservation_time" name="reservation_time">
                                <option value="" hidden>選択してください</option>
                                @for ($i = 0; $i <= (strtotime($restaurant->close_time) - strtotime($restaurant->open_time)) / 1800; $i++)
                                    {{ $reservation_time = date('H:i', strtotime($restaurant->open_time . '+' . $i * 30 . 'minute')) }}
                                    @if ($reservation_time == old('reservation_time'))
                                        <option value="{{ $reservation_time }}" selected>{{ $reservation_time }}</option>
                                    @else
                                        <option value="{{ $reservation_time }}">{{ $reservation_time }}</option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label for="reservation_people" class="col-md-5 col-form-label text-md-left fw-bold">人数</label>

                        <div class="col-md-7">
                            <select class="form-select" id="reservation_people" name="reservation_people">
                                <option value="" hidden>選択してください</option>
                                @for ($i = 1; $i <=5; $i++)
                                    <option value="{{ $i }}">{{ $i }}名</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="form-group d-flex justify-content-center mb-4">
                        <button type="submit" class="btn text-black shadow-sm w-50 kadai_002-btn">予約する</button>
                    </div>
                </form>

                <hr>
                <a>※予約人数が５名様以上の場合、お電話にてお問い合わせお願いいたします。</a>

            </div>
        </div>
    </div>
@endsection