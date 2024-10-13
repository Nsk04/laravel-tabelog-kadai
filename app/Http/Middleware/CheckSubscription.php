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
        $user = Auth::user();

        // ユーザーがログインしていない場合の処理
        if (!$user || !$user->subscribed('default')) {
            return redirect()->route('top')->with('error', '有料会員のみアクセス可能です。');
        }
    
        // サブスクリプションがキャンセルされていないか、有効期限が切れていないかを追加でチェック
        if ($user->subscription('default')->cancelled() || $user->subscription('default')->ended()) {
            return redirect()->route('top')->with('error', 'サブスクリプションが無効です。');
        }
    

        return $next($request);
    }
}
