<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\EventTimes;
use App\EventDays;
use App\Seminars;
use Response;
use Session;
use File;
use ZipStream\Exception;

class EventTimesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(){
        $eventTimes = EventTimes::with('eventDay')
            ->where('is_deleted', 0)
            ->paginate(10);
        return view('admin/event-times/index', ['eventTimes' => $eventTimes]);
    }

    public function getByEventDay(Request $request) {
        try {
            $eventTimes = [];
            $req = $request->all();
            if (!empty($req['eventDay'])) {
                $eventTimes = EventTimes::where('event_day_id', $req['eventDay'])->get()->toArray();
            }

            return response()->json(['code' => '200', 'message' => 'OK', 'eventTimes' => $eventTimes]);
        } catch (Exception $e) {
            return response()->json(['code' => '400', 'message' => $e->getMessage(), 'eventTimes' => []]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create(){
        $eventDays = DB::table('event_days')
            ->select('*')
            ->where('is_active', 1)->get();

        return view('admin/event-times/create', ['eventDays' => $eventDays]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request){
        $this->validateInput($request);

        $keys = ['event_day_id', 'start_time', 'end_time', 'is_active'];
        $input = $this->createQueryInput($keys, $request);
        $input['created_by'] = Auth::user()->id;
        $input['updated_by'] = Auth::user()->id;

        $created = EventTimes::create($input);
        if ($created) {
            Session::flash('success', 'Tạo mới thành công!');
        } else {
            Session::flash('error', 'Error');
        }

        return redirect()->intended('admin/event-times');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        $detail = EventTimes::where(['is_deleted' => 0, 'id' => $id])->first();
        $eventDays = DB::table('event_days')
            ->select('*')
            ->where('is_active', 1)->get();
        
        return view('admin.event-times.edit', ['detail' => $detail, 'eventDays' => $eventDays]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $this->validateInput($request);

        DB::beginTransaction();
        try {
            $keys = ['event_day_id', 'start_time', 'end_time', 'is_active'];
            $input = $this->createQueryInput($keys, $request);
            $input['updated_by'] = Auth::user()->id;

            $update = EventTimes::where('id', $id)->update($input);

            if ($update) {
                if ($request->is_active == 0) {
                    $deactiveSem = Seminars::where('event_time_id', $id)->update(['is_active' => 0]);
                    if ($deactiveSem) {
                        DB::commit();
                        Session::flash('success', 'Cập nhật thành công!');
                    } else {
                        DB::rollback();
                        Session::flash('error', 'Error');
                    }
                } else {
                    DB::commit();
                    Session::flash('success', 'Cập nhật thành công!');
                }
            } else {
                DB::rollback();
                Session::flash('error', 'Error');
            }

            return redirect()->intended('admin/event-times');

        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            die;
            DB::rollback();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        try {
            $deactiveSem = Seminars::where('event_day_id', $id)->get()->toArray();
            if (!empty($deactiveSem)) {
                Session::flash('error', 'Đang được sử dụng trong hội thảo');
            } else {
                $deleted = EventTimes::where('id',$id)->delete();
                if ($deleted) {
                    Session::flash('success', 'Xóa thành công!');
                } else {
                    Session::flash('error', 'Error');
                }
            }
            return redirect()->intended('admin/event-times');
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            die;
            DB::rollback();
        }
    }

    /**
     * Search state from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function search(Request $request){
        $constraints = [
            'title' => $request['name']
        ];
        $categories = $this->doSearchingQuery($constraints);

        return view('admin/event-times/index', ['categories' => $categories, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints){
        $query = DB::table('blog_category')
            ->select('*')
            ->where('is_deleted', 0);
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where($fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate(10);
    }

    private function validateInput($request) {
        $this->validate($request, [
            'event_day_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
    }
}