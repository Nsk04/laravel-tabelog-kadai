@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">カード情報の編集</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- 現在のカード情報の表示 -->
    <div class="card mb-4">
        <div class="card-body">
            <h5>現在のカード情報</h5>
            <p>カード名義: {{ Auth::user()->card_holder_name ?? '未登録' }}</p>
            <p>カード番号: **** **** **** {{ Auth::user()->pm_last_four ?? '未登録' }}</p>
            <p>カードの種類: {{ Auth::user()->pm_type ?? '未登録' }}</p>
            <p>有効期限: {{ Auth::user()->card_expiry ?? '未登録' }}</p>
        </div>
    </div>

    <!-- 新しいカード情報の入力フォーム -->
    <form id="update-card-form" method="POST" action="{{ route('subscription.update') }}">
        @csrf

        <div class="form-group">
            <label for="card-holder-name">カード名義</label>
            <input id="card-holder-name" type="text" class="form-control" placeholder="カード名義を入力" required>
        </div>

        <div class="form-group">
            <label for="card-element">カード情報</label>
            <div id="card-element" class="form-control"></div>
        </div>

        <button id="card-button" class="btn btn-primary mt-3" data-secret="{{ $intent->client_secret }}">
            カード情報を更新する
        </button>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');
    const elements = stripe.elements();
    const cardElement = elements.create('card', {
    hidePostalCode: true,
    });
    cardElement.mount('#card-element');

    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;

    cardButton.addEventListener('click', async (e) => {
        e.preventDefault();

        const { setupIntent, error } = await stripe.confirmCardSetup(
            clientSecret, {
                payment_method: {
                    card: cardElement,
                    billing_details: { name: cardHolderName.value }
                }
            }
        );

        if (error) {
            console.error(error);
            alert('カード情報の更新に失敗しました。もう一度お試しください。');
        } else {
            document.getElementById('update-card-form').submit();
        }
    });
</script>
@endsection
