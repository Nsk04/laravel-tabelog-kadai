<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function create()
    {
        // ユーザーのSetup Intentを取得して、カード登録用のクライアントシークレットを取得
        $intent = Auth::user()->createSetupIntent();

        return view('subscription.create', ['intent' => $intent]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $paymentMethod = $request->payment_method;

        // StripeのPrice ID（サブスクリプションプラン）を指定
        $priceId = 'price_1Q7FzQ04OpOW60oOS2kiNCJm'; 

        // サブスクリプションを作成
        $user->newSubscription('default', $priceId)
            ->create($paymentMethod);

        // サブスクリプションが作成されたら、完了ページへリダイレクト
        return redirect()->route('home')->with('success', '有料会員に登録されました。');
    }

    public function cancel()
    {
        $user = Auth::user();

        // サブスクリプションをキャンセル
        $user->subscription('default')->cancel();

        return redirect()->route('mypage')->with('success', '有料会員を解約しました。');
    }
}
