@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <h2>有料会員登録(月額300円)</h2>
    <p>---利用可能サービス---</p>
    <p>・店舗予約</p>
    <p>・お気に入り登録</p>
    <p>・レビューの登録</p>

    <!-- Stripeのカード入力フォーム -->
    <form id="payment-form" method="POST" action="{{ route('subscription.store') }}">
        @csrf

        <div class="form-group">
            <label for="card-holder-name">カード名義</label>
            <input id="card-holder-name" type="text" class="form-control" placeholder="カード名義を入力" required>
        </div>

        <!-- Stripe Elementsでカード情報を入力 -->
        <div id="card-element" class="form-control"></div>

        <button id="card-button" class="btn btn-primary mt-3" data-secret="{{ $intent->client_secret }}">
            サブスクリプション開始
        </button>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>

<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');
    const elements = stripe.elements();
    const cardElement = elements.create('card');
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
            // エラーハンドリング
            console.error(error);
        } else {
            // 支払い成功時にフォームを送信
            document.getElementById('payment-form').submit();
        }
    });
</script>
@endsection
