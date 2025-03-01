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
            <input id="card-holder-name" name="card_holder_name" type="text" class="form-control" placeholder="カード名義を入力" required>
        </div>

        <!-- Stripe Elementsでカード情報を入力 -->
        <div id="card-element" class="form-control"></div>
        <div id="card-errors" class="text-danger mt-2"></div> <!-- エラーメッセージ表示エリア -->

        <button id="card-button" class="btn btn-primary mt-3" data-secret="{{ $intent->client_secret }}">
            サブスクリプション開始
        </button>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>

<script>
    // Stripe初期化
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');
    const elements = stripe.elements();

    // カード入力のスタイル設定
    const style = {
        base: {
            fontSize: '16px',
            color: '#32325d',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    // カード要素を作成（hidePostalCodeを含める）
    const cardElement = elements.create('card', { 
        style: style, 
        hidePostalCode: true 
    });
    cardElement.mount('#card-element');

    // エラー表示用
    const cardErrors = document.getElementById('card-errors');

    // カード要素のイベントリスナー（エラー処理）
    cardElement.addEventListener('change', function(event) {
        if (event.error) {
            cardErrors.textContent = event.error.message;
        } else {
            cardErrors.textContent = '';
        }
    });

    // フォーム送信処理
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
            // エラーを表示
            console.error(error);
            cardErrors.textContent = error.message;
        } else {
            // setupIntent.payment_method をhiddenフィールドにセットしてフォームを送信
            const form = document.getElementById('payment-form');
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'payment_method');
            hiddenInput.setAttribute('value', setupIntent.payment_method);
            form.appendChild(hiddenInput);
            form.submit();
        }
    });
</script>

@endsection
