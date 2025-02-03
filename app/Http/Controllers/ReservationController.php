<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())->get();

        foreach($reservations as $reservation){
            $restaurant = Restaurant::find($reservation->restaurant_id);
            $reservation->restaurant_name = $restaurant->name;
        }

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Restaurant $restaurant)
    {
    
        // ユーザーがログインしていない場合は、ログインページへリダイレクト
    if (!Auth::check()) {
        // 元のURLを保存して、ログイン後にリダイレクトするための設定
        session(['url.intended' => url()->current()]);
        return redirect()->route('login');
    }

    $user = Auth::user();

    // 有料会員であるか、サブスクリプションが有効かを確認
    if (!$user->subscribed('default') || $user->subscription('default')->canceled() || $user->subscription('default')->ended()) {
        return redirect()->route('subscription.create')
            ->with('error', '予約を行うには有料会員である必要があります。');
    }
    
    
     // 現在時刻を取得
    $now = Carbon::now();

    // 開店時間と閉店時間
    $openingTime = Carbon::createFromFormat('H:i:s', $restaurant->open_time);
    $closingTime = Carbon::createFromFormat('H:i:s', $restaurant->close_time);

    $minReservationTime = $now->gt($openingTime) ? $now->format('H:i') : $openingTime->format('H:i');

    $maxReservationTime = $closingTime->format('H:i');

    $closedDays = $this->parseClosedDays($restaurant->closed_day);
    /* dd($closedDays); */

    return view('reservations.create', compact('restaurant', 'closedDays', 'minReservationTime', 'maxReservationTime'));
    }

    /**
     * Helper function to parse closed_days string to an array of weekdays
     * 定休日を文字列から曜日配列に変換するヘルパー関数
     */
    private function parseClosedDays($closedDayText)
    {
        $dayOfWeekMap = [
            "日" => 0,
            "月" => 1,
            "火" => 2,
            "水" => 3,
            "木" => 4,
            "金" => 5,
            "土" => 6,
        ];
    
        if (empty($closedDayText)) {
            return 7;
        }
    
    $dayChar = mb_substr($closedDayText, 0, 1);

    return isset($dayOfWeekMap[$dayChar]) ? $dayOfWeekMap[$dayChar] : 7;
    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required',
            'reservation_people' => 'required|integer|min:1|max:50',
        ]);

        $reservation = new Reservation();
        $reservation->restaurant_id = $request->input('restaurant_id');
        $reservation->user_id = Auth::user()->id;
        $reservation->reservation_date = $request->input('reservation_date');
        $reservation->reservation_time = $request->input('reservation_time');
        $reservation->reservation_people = $request->input('reservation_people');
        $reservation->save();

        return redirect()->route('reservations.complete');
    }

    /**
     * 予約完了画面を表示する
     *
     * @return \Illuminate\Http\Response
     */
    public function complete()
    {
        return view('reservations.complete');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('reservations.index')->with('success', 'レビューを削除しました。');
    }
}
