<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

//    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $redirectToAdmin = '/admincp';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make(
            $input,
            [
                'email' => 'required|string',
                'password' => 'required|string',
            ],
            [
                'required' => ':attribute không được để rỗng',
            ]
        );
        if ($validator->fails()) {
            return Redirect::route('login')
                ->withErrors($validator)
                ->withInput($request->except(['password']));
        }

        $credentials = [
            'email' => $input['email'],
            'password' => $input['password'],
        ];
        $remember = $request->remember == 'on' ? true : false;
        if (Auth::attempt($credentials,$remember)) {
            if (isset($input['url'])) {
                return redirect($input['url']);
            } else {
                // check if admin redirect to admincp
                if (!Auth::user()->can('view-backend')) {
                    return redirect($this->redirectTo);
                } else {
                    return redirect($this->redirectToAdmin);
                }
            }
        } else {
            return redirect()->back()->withErrors('Sai email đăng nhập hoặc mật khẩu.');
        }
    }
}
