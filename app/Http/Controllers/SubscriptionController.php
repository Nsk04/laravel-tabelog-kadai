<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function create()
    {
        // ユーザーのSetup Intentを取得して、カード登録用のクライアントシークレットを取得
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $intent = Auth::user()->createSetupIntent();

        return view('subscription.create', ['intent' => $intent]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $paymentMethod = $request->payment_method;

        // StripeのPrice ID（サブスクリプションプラン）を指定
        $priceId = 'price_1Q7FzQ04OpOW60oOS2kiNCJm'; 

        try {

            // サブスクリプションを作成
            $user->newSubscription('default', $priceId)->create($paymentMethod);

            // 有料会員フラグを設定
            $user->premium_member = true;
            $user->premium_member_expiration = now()->addMonth(); // 1か月間有効
            $user->save();

            // ユーザー情報をリフレッシュ
            $user->refresh();

            return redirect()->route('subscription.complete')->with('success', '有料会員に登録されました。'); // リダイレクト先変更
        } catch (\Exception $e) {
            return redirect()->route('subscription.create')->with('error', '登録に失敗しました: ' . $e->getMessage());
        }
    }

    public function show()
    {
        $user = Auth::user();
        $paymentMethod = $user->hasPaymentMethod() ? $user->defaultPaymentMethod() : null;

        return view('subscription.show', compact('paymentMethod'));
    }


    /* public function edit()
    {
        $intent = Auth::user()->createSetupIntent();
        return view('subscription.edit', ['intent' => $intent]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $paymentMethod = $request->payment_method;

        try {
            // ユーザーの支払い方法を更新
            $user->updateDefaultPaymentMethod($paymentMethod);

        return redirect()->route('subscription.edit')->with('success', 'カード情報を更新しました。');
        } catch (\Exception $e) {
        return redirect()->route('subscription.edit')->with('error', 'カード情報の更新に失敗しました。');
        }
    } */


    public function cancel()
    {
        $user = Auth::user();
        $subscription = $user->subscription('default');
        /*  ddd($subscription); */

    if ($subscription && ($subscription->active() || $subscription->onGracePeriod())) {
        /*  ddd($subscription->cancellation_details); */
            $subscription->cancel();

            // サブスクリプション状態の最新情報を反映
            $user->premium_member = false;
            $user->save();

            // セッションをリフレッシュ
            $user->refresh();
            session()->forget('subscription'); // セッションキャッシュをリセット
            session()->put('premium_member', $user->premium_member); // 状態を再セット

            return redirect()->route('mypage')->with('success', '有料会員を解約しました。');
        } else {
            return redirect()->route('mypage')->with('error', '解約できるサブスクリプションが存在しません。');
        }
    }

    public function complete()
    {
        return view('subscription.complete');
    }

}
