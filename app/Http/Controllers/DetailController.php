<?php

namespace App\Http\Controllers;

use App\Seminars;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\UserSeminar;
use App\EventDays;
use ZipStream\Exception;

class DetailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
        setlocale(LC_TIME, 'vi');
    }

    /**
     * Show the application dashboard.
     *
     * @return View
     */
    public function index() {
        $userId = Auth::user()->id;

        $seminarArr = [];
        $userSeminar = UserSeminar::with('seminar')->where(['user_id' => $userId, 'is_active' => 1, 'is_deleted' => 0])->get()->toArray();
        if (!empty($userSeminar)) {
            $seminarArr = array_map(function ($val) {
                return $val['seminar_id'];
            }, $userSeminar);
        }
//        echo '<pre>';
//        print_r($userSeminar);die;
        $eventDays = EventDays::where('is_active', 1)->get();

        return view('detail', [
            'userId' => $userId,
            'eventDays' => $eventDays,
            'seminarArr' => $seminarArr,
        ]);
    }
}
