<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data,
            [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:8|confirmed',
                'phone' => 'required|numeric|digits_between:9,11',
            ],
            [
                'name.required' => 'Không được để trống',
                'email.required' => 'Không được để trống',
                'email.email' => 'Không đúng định dạng email',
                'email.unique' => 'Email đã tồn tại',
                'password.required' => 'Không được để trống',
                'password.min' => 'Phải nhiều hơn 8 ký tự',
                'password.confirmed' => 'Xác nhận mật khẩu chưa khớp',
                'phone.required' => 'Không được để trống',
                'phone.numeric' => 'Số điện thoại phải dạng số nguyên',
                'phone.digits_between' => 'Số điện thoại chỉ cho phép 10 ký tự',

            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data) {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'],
            'position' => $data['position'],
            'company' => $data['company'],
            'address' => $data['address'],
        ]);
    }
}
