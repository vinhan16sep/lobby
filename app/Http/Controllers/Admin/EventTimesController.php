<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\EventTimes;
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
//        echo '<pre>';
//        print_r($eventTimes);die;
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
            ->where('is_deleted', 0)->get();

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

        EventTimes::create($input);

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
        $detail = BlogCategory::where(['is_deleted' => 0, 'id' => $id])->first();
        
        return view('admin.event-times.edit', ['detail' => $detail]);
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
        $uniqueSlug = $this->buildUniqueSlug('blog_category', $id, $request->slug);
        $keys = ['title', 'is_active', 'description'];
        $input = $this->createQueryInput($keys, $request);
        $input['slug'] = $uniqueSlug;
        if($request->file('image')){
            $path = $request->file('image')->store(($request->type == '0') ? 'advises/category' : 'news/category');
            $input['image'] = $path;
        };
        $update = BlogCategory::where('id', $id)
            ->update($input);
        if($update){
            if($request->is_active == 1){
                Blog::where('category_id', $id)->update(['category_active' => 1]);
            }else{
                Blog::where('category_id', $id)->update(['category_active' => 0]);
            }
        }
        
        return redirect()->intended('admin/event-times');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $detail = BlogCategory::where('id', $id)->first();
        if($this->checkActive('blog', 'category_id', $detail)){
            $destroy = BlogCategory::where('id', $id)->update(['is_deleted' => 1]);

            if($destroy){
                Session::flash('success', 'Xóa thành công!');
                return redirect()->intended('admin/event-times');
            }
        }
        Session::flash('error', 'Xóa thất bại do danh mục nay tồn tại bài viết!');
        return redirect()->intended('admin/event-times');
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