<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Cashier\Cashier; // Laravel Cashierのインポート
use Carbon\Carbon; // 日付操作用
use Stripe\Exception\CardException;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/email/verify';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'string'],
            'post_code' => ['required', 'string'],
            'address' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'card_number' => ['nullable', 'string'], // クレジットカード番号
            'expiry_date' => ['nullable', 'string'], // 有効期限
            'cvc' => ['nullable', 'string'], // CVC
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'post_code' => $data['post_code'],
            'address' => $data['address'],
            'premium_member' => 0,
            'password' => Hash::make($data['password']),
        ]);
         // 有料会員が選択された場合の処理
        if (isset($data['premium_member'])) {
            // Stripe顧客を作成し、支払い方法を設定
            try {
                $paymentMethod = $data['payment_method']; // フロントエンドで取得した支払い方法ID
                $user->createOrGetStripeCustomer(); // Stripe顧客作成
                $user->updateDefaultPaymentMethod($paymentMethod); // 支払い方法を設定

                // サブスクリプション作成（月額300円のプラン）
                $user->newSubscription('default', 'price_1Q7FzQ04OpOW60oOS2kiNCJm')
                    ->create($paymentMethod);

            } catch (CardException $e) {
                // エラーハンドリング: カードエラーの場合
                return redirect()->back()->withErrors(['card_error' => 'カード情報が正しくありません。']);
            }
        }

        return $user;
    }
}
