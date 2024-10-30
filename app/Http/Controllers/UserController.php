<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function mypage()
    {
        $user = Auth::user();

        return view('users.mypage', compact('user'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user = Auth::user();

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user = Auth::user();

        $user->name = $request->input('name') ? $request->input('name') : $user->name;
        $user->email = $request->input('email') ? $request->input('email') : $user->email;
        $user->post_code = $request->input('post_code') ? $request->input('post_code') : $user->post_code;
        $user->address = $request->input('address') ? $request->input('address') : $user->address;
        $user->phone_number = $request->input('phone_number') ? $request->input('phone_number') : $user->phone_number;
        $user->premium_member = $request->input('premium_member') ? $request->input('premium_member') : $user->premium_member;
        $user->premium_member_expiration = $request->input('premium_member_expiration') ? $request->input('premium_member_expiration') : $user->premium_member_expiration;
        $user->update();

            // 有料会員登録
    if ($request->has('premium_member')) {
        if (!$user->subscribed('default')) {
            // サブスクリプションを開始（StripeのプランIDを指定）
            $user->newSubscription('default', 'price_1Q7FzQ04OpOW60oOS2kiNCJm')
            ->create($paymentMethod);

            $user->premium_member = true;
        }
    } else {
        // 無料会員への変更処理
        if ($user->subscribed('default')) {
            // サブスクリプションをキャンセル
            $user->subscription('default')->cancel();
        }

        $user->premium_member = false;
    }

        $user->save();

        return redirect()->route('mypage')->with('status', '会員情報が更新されました');
    }

    public function update_password(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required|confirmed',
        ]);

        $user = Auth::user();

        if ($request->input('password') == $request->input('password_confirmation')) {
            $user->password = bcrypt($request->input('password'));
            $user->update();
        } else {
            return to_route('mypage.edit_password');
        }

        return to_route('mypage');
    }

    public function edit_password()
    {
        return view('users.edit_password');
    }

    public function favorite()
    {
        $user = Auth::user();

        $favorites = $user->favorites(Restaurant::class)->get();

        return view('users.favorite', compact('favorites'));
    }

    public function cancelSubscription()
    {
        $user = Auth::user();

        if ($user->subscribed('default')) {
            $user->subscription('default')->cancel();
            $user->premium_member = false;
            $user->save();

            return redirect()->route('mypage')->with('status', 'サブスクリプションをキャンセルしました');
        }

        return redirect()->route('mypage')->with('error', 'サブスクリプションが存在しません');
    }
}