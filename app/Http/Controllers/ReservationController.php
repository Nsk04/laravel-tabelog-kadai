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
         // 現在時刻を取得
    $now = Carbon::now();

    // 開店時間と閉店時間
    $openingTime = Carbon::createFromFormat('H:i', $restaurant->open_time);
    $closingTime = Carbon::createFromFormat('H:i', $restaurant->close_time)->subHours(2); // 閉店2時間前

    // minTime は、現在時刻が開店時間を過ぎている場合は現在時刻、そうでなければ開店時間
    $minReservationTime = $now->gt($openingTime) ? $now->format('H:i') : $openingTime->format('H:i');

    // maxTime は閉店時間の2時間前
    $maxReservationTime = $closingTime->format('H:i');

    // 定休日の処理
    $closedDays = $this->parseClosedDays($restaurant->closed_day);

    return view('reservations.create', compact('restaurant', 'closedDays', 'minReservationTime', 'maxReservationTime'));
    }

    /**
     * Helper function to parse closed_days string to an array of weekdays
     * 定休日を文字列から曜日配列に変換するヘルパー関数
     */
    private function parseClosedDays($closedDayText)
    {
        // 曜日と対応する配列を作成 (0: 日曜日, 1: 月曜日, ...)
        $dayOfWeekMap = [
            "日" => 0, // 日曜日
            "月" => 1, // 月曜日
            "火" => 2, // 火曜日
            "水" => 3, // 水曜日
            "木" => 4, // 木曜日
            "金" => 5, // 金曜日
            "土" => 6, // 土曜日
        ];
    
        // 定休日の文字列が空の場合は空の配列を返す
        if (empty($closedDayText)) {
            return []; // 定休日が設定されていない場合は空の配列を返す
        }
    
       // 定休日が "月曜日" のような形式で保存されていると仮定
    // 「月」という部分を抽出する
    $dayChar = mb_substr($closedDayText, 0, 1); // "月", "火", "水", "木", "金", "土", "日" を取得

    // 曜日に対応する数値を返す (該当する曜日がない場合は null を返す)
    return isset($dayOfWeekMap[$dayChar]) ? [$dayOfWeekMap[$dayChar]] : [];
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
