@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <span>
                <a href="{{ route('mypage') }}">マイページ</a> > 会員情報の編集
            </span>

            <h1 class="mt-3 mb-3">会員情報の編集</h1>
            <hr>

            <form method="POST" action="{{ route('mypage') }}">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <label for="name" class="text-md-left kadai_002-edit-user-info-label">氏名</label>
                    </div>
                    <div class="collapse show editUserName">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus placeholder="食 太郎">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>氏名を入力してください</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <br>

                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <label for="email" class="text-md-left kadai_002-edit-user-info-label">メールアドレス</label>
                    </div>
                    <div class="collapse show editUserMail">
                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email" autofocus placeholder="tabelog@tabelog.com">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>メールアドレスを入力してください</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <br>

                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <label for="post_code" class="text-md-left kadai_002-edit-user-info-label">郵便番号</label>
                    </div>
                    <div class="collapse show editUserPhone">
                        <input id="post_code" type="text" class="form-control @error('post_code') is-invalid @enderror" name="post_code" value="{{ $user->postal_code }}" required autocomplete="postal_code" autofocus placeholder="XXX-XXXX">
                        @error('post_code')
                        <span class="invalid-feedback" role="alert">
                            <strong>郵便番号を入力してください</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <br>

                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <label for="address" class="text-md-left kadai_002-edit-user-info-label">住所</label>
                    </div>
                    <div class="collapse show editUserPhone">
                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $user->address }}" required autocomplete="address" autofocus placeholder="東京都渋谷区道玄坂X-X-X">
                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>住所を入力してください</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <br>

                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <label for="phone_number" class="text-md-left kadai_002-edit-user-info-label">電話番号</label>
                    </div>
                    <div class="collapse show editUserPhone">
                        <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ $user->phone_number }}" required autocomplete="phone_number" autofocus placeholder="XXX-XXXX-XXXX">
                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>電話番号を入力してください</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="premium_member">
                        <input type="checkbox" id="premium_member" name="premium_member" value="1" @if($user->is_premium) checked @endif> 有料会員になる（月々300円）
                    </label>
                </div>

                <div id="credit-card-info" style="display: none;">
                    <h4>クレジットカード情報</h4>
                    <div class="form-group">
                        <label for="card_number">カード番号</label>
                        <input type="text" name="card_number" id="card_number" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="expiry_date">有効期限</label>
                        <input type="text" name="expiry_date" id="expiry_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="cvc">CVC</label>
                        <input type="text" name="cvc" id="cvc" class="form-control">
                    </div>
                </div>

                <script>
                    document.getElementById('premium_member').addEventListener('change', function() {
                        var display = this.checked ? 'block' : 'none';
                        document.getElementById('credit-card-info').style.display = display;
                    });
                </script>

                <hr>
                <button type="submit" class="btn ml=2 btn-info w-50">
                    保存
                </button>
            </form>
        </div>
    </div>
</div>
@endsection