<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Seminars;
use App\UserSeminar;
use Response;
use Session;
use File;
use ZipStream\Exception;

class SeminarsController extends Controller
{
    private $seminarPath = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:admin');
        $this->seminarPath = public_path() . '/uploads/seminars/';
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index() {
        $seminars = Seminars::with(['eventDay', 'eventTime'])
            ->where('is_deleted', 0)
            ->paginate(10);
        return view('admin/seminars/index', ['seminars' => $seminars]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create() {
        $eventDays = DB::table('event_days')
            ->select('*')
            ->where('is_active', 1)->get();

        return view('admin/seminars/create', ['eventDays' => $eventDays]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request) {
        $this->validateInput($request);
        $fn = '';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->extension();
            $fn = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, 10) . time() . '.' . $extension;
            $file->move($this->seminarPath, $fn);
        }
        $keys = [
            'event_day_id',
            'event_time_id',
            'is_main',
            'name',
            'link',
            'description',
            'is_active'
        ];
        $input = $this->createQueryInput($keys, $request);
        $input['image'] = $fn;
        $input['created_by'] = Auth::user()->id;
        $input['updated_by'] = Auth::user()->id;

        $created = Seminars::create($input);
        if ($created) {
            Session::flash('success', 'Tạo mới thành công!');
        } else {
            Session::flash('error', 'Error');
        }

        return redirect()->intended('admin/seminars');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     */
    public function edit($id) {
        $detail = Seminars::where(['is_deleted' => 0, 'id' => $id])->first();
        $eventDays = DB::table('event_days')
            ->select('*')
            ->where('is_active', 1)->get();
        $eventTimes = DB::table('event_times')
            ->select('*')
            ->where(['is_active' => 1, 'event_day_id' => $detail['event_day_id']])->get();

        return view('admin.seminars.edit', [
            'detail' => $detail,
            'eventDays' => $eventDays,
            'eventTimes' => $eventTimes
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     */
    public function update(Request $request, $id) {
        $oldSem = Seminars::where(['id' => $id])->first();
        $oldImg = $oldSem['image'];

        $this->validateInput($request);
        $fn = '';
        $isUploaded = false;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->extension();
            $fn = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, 10) . time() . '.' . $extension;
            $file->move($this->seminarPath, $fn);
            if (is_file($this->seminarPath . $fn)) {
                $isUploaded = true;
            }
        }
        $keys = [
            'event_day_id',
            'event_time_id',
            'is_main',
            'name',
            'link',
            'description',
            'is_active'
        ];
        $input = $this->createQueryInput($keys, $request);
        if ($request->hasFile('image')) {
            $input['image'] = $fn;
        }
        $input['updated_by'] = Auth::user()->id;

        $update = Seminars::where('id', $id)->update($input);
        if ($update && $isUploaded && !empty($oldImg)) {
            unlink($this->seminarPath . $oldImg);
        }

        Session::flash('success', 'Cập nhật thành công!');
        return redirect()->intended('admin/seminars');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy($id) {
        $deleted = Seminars::where('id', $id)->delete();
        if ($deleted) {
            Session::flash('success', 'Xóa thành công!');
        } else {
            Session::flash('error', 'Error');
        }
        return redirect()->intended('admin/seminars');
    }

    /**
     * Search state from database base on some specific constraints
     *
     * @param \Illuminate\Http\Request $request
     */
    public function search(Request $request) {
        $constraints = [
            'title' => $request['name']
        ];
        $categories = $this->doSearchingQuery($constraints);

        return view('admin/seminars/index', ['categories' => $categories, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = DB::table('blog_category')
            ->select('*')
            ->where('is_deleted', 0);
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where($fields[$index], 'like', '%' . $constraint . '%');
            }

            $index++;
        }
        return $query->paginate(10);
    }

    private function validateInput($request) {
        $this->validate($request, [
            'event_day_id' => 'required',
            'event_time_id' => 'required',
            'name' => 'required|max:255',
            'link' => 'required',
            'image' => 'image|mimes:jpg,jpeg,png,gif',
        ]);
    }

    public function getUserWishlist(Request $request) {
        try {
            $seminars = [];
            $user = '';
            $req = $request->all();
            if (!empty($req['userId'])) {
                $userSeminar = UserSeminar::with('seminar')->where(['user_id' => $req['userId']])->get();
                if (!empty($userSeminar)) {
                    foreach ($userSeminar as $value) {
                        $seminars[] = [
                            'name' => $value->seminar->name,
                            'event_date' => date('d-m-Y', strtotime($value->seminar->eventDay->event_date)),
                            'start_time' => $value->seminar->eventTime->start_time,
                            'end_time' => $value->seminar->eventTime->end_time
                        ];
                    }
                }

                $user = User::find($req['userId']);
            }
            return response()->json([
                'code' => '200',
                'message' => 'OK',
                'data' => [
                    'seminars' => $seminars,
                    'user' => $user->name,
                ]
            ]);

        } catch (Exception $e) {
            return response()->json(['code' => '400', 'message' => $e->getMessage(), 'data' => null]);
        }
    }
}