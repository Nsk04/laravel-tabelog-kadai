<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // 定休日の文字列を曜日に変換
        $closedDays = $this->parseClosedDays($restaurant->closed_day);

        return view('reservations.create', compact('restaurant', 'closedDays'));
    }

    /**
     * Helper function to parse closed_days string to an array of weekdays
     * 定休日を文字列から曜日配列に変換するヘルパー関数
     */
    private function parseClosedDays($closedDayText)
    {
        // 曜日と対応する配列を作成
        $dayOfWeekMap = [
            "月" => 1, // 月曜日
            "火" => 2, // 火曜日
            "水" => 3, // 水曜日
            "木" => 4, // 木曜日
            "金" => 5, // 金曜日
            "土" => 6, // 土曜日
            "日" => 0, // 日曜日
        ];

        // 定休日の文字列が空の場合は空の配列を返す
        if (empty($closedDayText)) {
            return []; // 定休日が設定されていない場合は空の配列を返す
        }

        // 複数の定休日がカンマ区切りで渡される場合も対応
        $closedDaysArray = explode(',', $closedDayText);  // カンマ区切りで分割

        // 曜日に対応する数値を配列で返す
        return array_map(function($dayChar) use ($dayOfWeekMap) {
            $dayChar = trim(mb_substr($dayChar, 2, 1)); // 各曜日を抽出
            return $dayOfWeekMap[$dayChar] ?? null; // 存在する曜日ならその数値、そうでなければ null
        }, $closedDaysArray);
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
