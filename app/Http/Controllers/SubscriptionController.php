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
        $user->newSubscription('default', $priceId)->create($paymentMethod);

         // 有料会員フラグを設定
        $user->premium_member = true;
        $user->save();

        // サブスクリプションが作成されたら、完了ページへリダイレクト
        return redirect()->route('home')->with('success', '有料会員に登録されました。');
    }

    public function edit()
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
    }


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


}
