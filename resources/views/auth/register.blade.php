@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 class="mt-3 mb-3">新規会員登録</h3>

            <hr>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- ユーザー情報入力フォーム -->
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-left">氏名<span class="text-danger">*</span></label>
                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control" name="name" required placeholder="例: 侍 太郎">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-left">メールアドレス<span class="text-danger">*</span></label>
                    <div class="col-md-8">
                        <input id="email" type="email" class="form-control" name="email" required placeholder="例: samurai@samurai.com">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="post_code" class="col-md-5 col-form-label text-md-left">郵便番号<span class="text-danger">*</span></label>
                    <div class="col-md-8">
                        <input type="text" class="form-control @error('postal_code') is-invalid @enderror kadai_002-login-input" name="postal_code" required placeholder="150-0043">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="address" class="col-md-5 col-form-label text-md-left">住所<span class="text-danger">*</span></label>
                    <div class="col-md-8">
                        <input type="text" class="form-control @error('address') is-invalid @enderror kadai_002-login-input" name="address" required placeholder="東京都渋谷区道玄坂２丁目１１−１">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="phone_number" class="col-md-5 col-form-label text-md-left">電話番号<span class="text-danger">*</span></label>
                    <div class="col-md-8">
                        <input type="text" class="form-control @error('phone') is-invalid @enderror kadai_002-login-input" name="phone" required placeholder="03-5790-9039">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-5 col-form-label text-md-left">パスワード<span class="text-danger">*</span></label>

                    <div class="col-md-8">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror kadai_002-login-input" name="password" required autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>


                <!-- 有料会員チェックボックス -->
                <div class="form-group row">
                    <div class="col-md-12">
                        <label>
                            <input type="checkbox" id="premium_member" name="premium_member" value="1">
                            有料会員になる（月々300円）
                        </label>
                    </div>
                </div>

                <!-- 有料会員用フォームをここに表示 -->
                <div id="premium-options" style="display:none; margin-top:20px;">
                    <h4>有料会員登録情報</h4>
                    <p>以下の情報を入力して、有料会員登録を進めてください。</p>
                    
                    <!-- Stripeのカード入力フォーム -->
                    <div class="form-group">
                        <label for="card-holder-name">カード名義</label>
                        <input id="card-holder-name" type="text" class="form-control" placeholder="カード名義を入力" required>
                    </div>

                    <div class="form-group">
                        <label for="card-element">カード情報</label>
                        <div id="card-element" class="form-control"></div>
                    </div>

                    <small class="text-muted">※ 決済はStripeを通じて安全に処理されます。</small>
                </div>

                <!-- サブミットボタン -->
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary w-100">
                        アカウント作成
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    // プレミアム会員チェックボックスのトグル処理
    document.getElementById('premium_member').addEventListener('change', function() {
        var premiumOptions = document.getElementById('premium-options');
        if (this.checked) {
            premiumOptions.style.display = 'block';

            // Stripeのセットアップ
            const stripe = Stripe('{{ env('STRIPE_KEY') }}');
            const elements = stripe.elements();
            const cardElement = elements.create('card');
            cardElement.mount('#card-element');
        } else {
            premiumOptions.style.display = 'none';
        }
    });
</script>
@endsection
