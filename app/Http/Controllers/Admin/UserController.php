<?php

namespace App\Http\Controllers\Admin;

use App\UserSeminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\EventDays;
use App\User;
use App\Blog;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Response;
use Session;
use File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use ZipStream\Exception;

class UserController extends Controller
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
        $users = DB::table('users')
            ->select('*')
            ->paginate(100);
        return view('admin/user/index', ['users' => $users]);
    }

    public function import(){
        return view('admin/user/import');
    }

    public function export(){
        $fileName = 'Danh_sach_user_' . time() . '.xlsx';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'Họ tên',
            'Email',
            'Số điện thoại',
            'Đơn vị',
            'Chức danh',
            'Địa chỉ'
        ];
        for ($i = 0; $i < count($headers); $i++) {
            $sheet->setCellValueByColumnAndRow($i + 1, 1, $headers[$i]);
        }

        $users = DB::table('users')->get()->toArray();
        for ($i = 0; $i < count($users); $i++) {
            if ($users[$i]) {
                $data = (array) $users[$i];
                $user = [
                    $data['name'],
                    $data['email'],
                    $data['phone'],
                    $data['company'],
                    $data['position'],
                    $data['address']
                ];

                $j = 0;
                foreach($user as $key => $val) {
                    $sheet->setCellValueByColumnAndRow($j + 1, ($i + 1 + 1), $val);
                    $j++;
                }
            }
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create(){
        return view('admin/user/create');
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     */
    public function doImport(Request $request) {
        if($request->hasFile('file')) {
            $path = $request->file('file')->getRealPath();
            $spreadsheet = IOFactory::load($path);
            $data = $spreadsheet->getActiveSheet()->toArray();
            if (count($data) > 1) {
                DB::beginTransaction();
                try {
                    foreach ($data as $dataKey => $dataVal) {
                        if ($dataKey == 0) {
                            continue;
                        }
                        $emptyRow = true;
                        foreach ($dataVal as $val) {
                            if (!empty($val)) {
                                $emptyRow = false;
                                break;
                            }
                        }
                        if (!$emptyRow) {
                            $user = User::create([
                                'name' => $dataVal[0],
                                'email' => $dataVal[1],
                                'password' => bcrypt(str_replace(' ', '', $dataVal[2])),
                                'phone' => str_replace(' ', '', $dataVal[3]),
                                'company' => $dataVal[4],
                                'position' => $dataVal[5],
                                'address' => $dataVal[6]
                            ]);
                            if ($user) {
                                $events = explode(',', $dataVal[7]);
                                $relateData = [];
                                if (!empty($events)) {
                                    foreach ($events as $key => $value) {
                                        $relateData[$key] = [
                                            'user_id' => $user->id,
                                            'seminar_id' => $value,
                                            'created_by' => Auth::user()->id,
                                            'updated_by' => Auth::user()->id
                                        ];
                                    }
                                    UserSeminar::insert($relateData);
                                }
                            }
                        }
                    }
                    DB::commit();
                    return redirect()->intended('admin/user');

                } catch (\Exception $e) {
                    echo '<pre>';
                    print_r($e->getMessage());die;
                    DB::rollback();
                }
            } else {

            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request){
        $this->validateInput($request);

        $keys = ['event_date', 'is_active'];
        $input = $this->createQueryInput($keys, $request);
        $input['created_by'] = Auth::user()->id;
        $input['updated_by'] = Auth::user()->id;

        EventDays::create($input);

        return redirect()->intended('admin/user');
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
        
        return view('admin.user.edit', ['detail' => $detail]);
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
        
        return redirect()->intended('admin/user');
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
                return redirect()->intended('admin/user');
            }
        }
        Session::flash('error', 'Xóa thất bại do danh mục nay tồn tại bài viết!');
        return redirect()->intended('admin/user');
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

        return view('admin/user/index', ['categories' => $categories, 'searchingVals' => $constraints]);
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
            'event_date' => 'required',
        ]);
    }

    public function getUserInfo(Request $request) {
        try {
            $user = '';
            $req = $request->all();
            if (!empty($req['userId'])) {
                $user = User::find($req['userId']);
            }
            return response()->json([
                'code' => '200',
                'message' => 'OK',
                'data' => [
                    'user' => $user
                ]
            ]);

        } catch (Exception $e) {
            return response()->json(['code' => '400', 'message' => $e->getMessage(), 'data' => null]);
        }
    }

    public function changePassword(Request $request) {
        try {
            $req = $request->all();
            if (!empty($req['userId']) && !empty($req['pwd'])) {
                $input = [
                    'password' => bcrypt($req['pwd'])
                ];
                $update = User::where('id', $req['userId'])->update($input);
            }
            return response()->json([
                'code' => '200',
                'message' => 'OK',
                'data' => [
                    'new_password' => $req['pwd']
                ]
            ]);

        } catch (Exception $e) {
            return response()->json(['code' => '400', 'message' => $e->getMessage(), 'data' => null]);
        }
    }
}