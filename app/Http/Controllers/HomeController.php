<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\UserSeminar;
use App\EventDays;
use ZipStream\Exception;

class HomeController extends Controller
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
        $userName = Auth::user()->name;
        $userCompany = Auth::user()->company;
        $userPosition = Auth::user()->position;

        $seminarArr = [];
        $userSeminar = UserSeminar::select('seminar_id')->where(['user_id' => $userId, 'is_active' => 1, 'is_deleted' => 0])->get()->toArray();
        if (!empty($userSeminar)) {
            $seminarArr = array_map(function ($val) {
                return $val['seminar_id'];
            }, $userSeminar);
        }

        $eventDays = EventDays::where('is_active', 1)->get();
        $userArr = User::all()->toJson();

        return view('home', [
            'userId' => $userId,
            'userName' => $userName,
            'userCompany' => $userCompany,
            'userPosition' => $userPosition,
            'eventDays' => $eventDays,
            'seminarArr' => $seminarArr,
            'userArr' => json_encode($userArr)
        ]);
    }

    public function getListUsers(){
        $users = User::all()->toJson();

        return response()->json(['users'=>$users]);
    }

    public function dashboard() {
        return view('dashboard');
    }

    public function chat() {
        return view('chat');
    }

    public function addToWishlist(Request $request) {
        try {
            $req = $request->all();
            if (!empty($req['seminarId'])) {
                $input= [
                    'user_id' => Auth::user()->id,
                    'seminar_id' => $req['seminarId'],
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id
                ];
                UserSeminar::create($input);
            }
            return response()->json(['code' => '200', 'message' => 'OK', 'data' => null]);

        } catch (Exception $e) {
            return response()->json(['code' => '400', 'message' => $e->getMessage(), 'eventTimes' => []]);
        }
    }
}
