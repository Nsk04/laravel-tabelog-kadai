<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // 現在ログインしているユーザーを取得
        $user = Auth::user();

        // ユーザーがログインしていない、もしくはサブスクリプションに未加入の場合の処理
        if (!$user || !$user->subscribed('default')) {
            // 「有料会員のみアクセス可能」としてトップページにリダイレクト
            return redirect()->route('subscription.create')->with('error', '有料会員のみアクセス可能です。');
        }

        // サブスクリプションの状態を確認し、キャンセルされているか期限切れかどうかをチェック
        $subscription = $user->subscription('default');

        /* ddd($subscription); */
        if( !is_null($subscription ) ){
            return redirect()->route('restaurants.index')->with('error', 'サブスクリプションが無効です。');
        }
        
        // サブスクリプションがキャンセルされたか、期限切れの場合の処理
        if ($subscription->cancelled() || $subscription->ended()) {
            // サブスクリプションが無効としてリダイレクト
            return redirect()->route('subscription.create')->with('error', 'サブスクリプションが無効です。');
        }

        // すべてのチェックを通過したら次のリクエストに進む
        return $next($request);
    }
}
