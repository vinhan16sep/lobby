<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Seminars;
use Response;
use Session;
use File;

class SeminarsController extends Controller
{
    private $seminarPath = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth:admin');
        $this->seminarPath = public_path().'/uploads/seminars/';
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(){
        $seminars = Seminars::with(['eventDay', 'eventTime'])
            ->where('is_deleted', 0)
            ->paginate(10);
//        echo '<pre>';
//        print_r($seminars);die;
//        $seminars = DB::table('seminars')
//            ->select('*')
//            ->where('is_deleted', 0)
//            ->paginate(10);
        return view('admin/seminars/index', ['seminars' => $seminars]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create(){
        $eventDays = DB::table('event_days')
            ->select('*')
            ->where('is_deleted', 0)->get();

        return view('admin/seminars/create', ['eventDays' => $eventDays]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request){
        $this->validateInput($request);
        $fn = '';
        if($request->hasFile('image')){
            $file = $request->file('image');
            $extension = $file->extension();
            $fn = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1, 10) . time() . '.' . $extension;
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

        Seminars::create($input);

        return redirect()->intended('admin/seminars');
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
        $detail = Seminars::where(['is_deleted' => 0, 'id' => $id])->first();
        $eventDays = DB::table('event_days')
            ->select('*')
            ->where('is_deleted', 0)->get();
        $eventTimes = DB::table('event_times')
            ->select('*')
            ->where('is_deleted', 0)->get();
        
        return view('admin.seminars.edit', [
            'detail' => $detail,
            'eventDays' => $eventDays,
            'eventTimes' => $eventTimes
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $oldSem = Seminars::where(['id' => $id])->first();
        $oldImg = $oldSem['image'];

        $this->validateInput($request);
        $fn = '';
        $isUploaded = false;
        if($request->hasFile('image')){
            $file = $request->file('image');
            $extension = $file->extension();
            $fn = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1, 10) . time() . '.' . $extension;
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
        $input['image'] = $fn;
        $input['updated_by'] = Auth::user()->id;

        $update = Seminars::where('id', $id)
            ->update($input);
        if ($update && $isUploaded && !empty($oldImg)) {
            unlink($this->seminarPath . $oldImg);
        }
        
        return redirect()->intended('admin/seminars');
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
                return redirect()->intended('admin/seminars');
            }
        }
        Session::flash('error', 'Xóa thất bại do danh mục nay tồn tại bài viết!');
        return redirect()->intended('admin/seminars');
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

        return view('admin/seminars/index', ['categories' => $categories, 'searchingVals' => $constraints]);
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
            'event_time_id' => 'required',
            'name' => 'required|max:255',
            'link' => 'required',
            'image' => 'image|mimes:jpg,jpeg,png,gif',
        ]);
    }

    private function buildNewFolderPath($path, $fileName){
        $newPath = $path . '/' . $fileName;
        $newName = $fileName;
        $counter = 1;
        while (file_exists($newPath)) {
            $newName = $counter . '-' . $fileName;
            $newPath = $path . '/' . $newName;
            $counter++;
        }

        return array($newName, $newPath);
    }
}