<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use App\Models\SocialLogin;
use Illuminate\Support\Facades\Session;
use Socialite;
use Auth;
use DB;
use Exception;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
//            'g-recaptcha-response' => 'required|captcha',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $user->attachRole(Role::where('name', 'user')->first());
        return $user;
    }

    public function register(Request $request)
    {
        $input = $request->all();
        $validator = $this->validator($input);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $result = $this->create($input);
        return redirect(route('login'))->with('status', 'Bạn tạo tài khoản thành công.Vui lòng đăng nhập!');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
            Session::put('token_gg',$user->token);
//            echo  Session::get('token_gg');die;
            $createdUser = $this->addNewSocialLogin($user, $provider);
            // tạo user mới
//            if($createdUser['code'] == 1){
//                $user_system = User::where('email', config('constant.system_email'))->first();
//                if(!$user_system)
//                    $user_system = User::where('email', 'nguyenngochoangit.tb@gmail.com')->first();
//                $message = trans('labels.welcome');
//                $conversation = $this->_conversation->messageWelcome($user_system->id, $createdUser['result']->id, $message);
//            }
            $auth = Auth::loginUsingId($createdUser['result']->id);
            return redirect()->intended('/');
        } catch (Exception $e) {
            return redirect('auth/social/'.$provider);
        }
    }

    public function addNewSocialLogin($user, $provider)
    {
        $user_model = User::where('email', $user->email)->first();
        $result = null;
        $code = 0;
        if($user_model){
            $social_model = SocialLogin::where('provider', $provider)->where('user_id', $user_model->id)->first();
            if($social_model){
                $result = $user_model;
            }else{
                $social = SocialLogin::create([
                    'user_id' => $user_model->id,
                    'provider' => $provider,
                    'provider_id' => $user->id,
                    'avatar' => $user->avatar,
                    'token' => $user->token
                ]);
                if(!$social)
                    throw new \Exception();
                $result = $user_model;
            }
        }else{
            DB::beginTransaction();
            try {
//                $userImage = null;
//                if(!empty($user->avatar)){
//                    $ext = 'jpg';
//                    $userImage = time() . md5(uniqid(rand(), true)) . '.' . $ext; // renaming image
//                    $output = '/avatars/' . $userImage;
//                    $public_disk = \Storage::disk('public');
//                    $public_disk->put($output, file_get_contents($user->avatar));
//                }
                $result = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->avatar,
//                    'notifi_config' => 1,
//                    'confirmed' => 1
                ]);
                $code = 1;
                if (!$result)
                    throw new \Exception();

                $social = SocialLogin::create([
                    'user_id' => $result->id,
                    'provider' => $provider,
                    'provider_id' => $user->id,
                    'avatar' => $user->avatar,
                    'token' => $user->token
                ]);
                if (!$social)
                    throw new \Exception();
                DB::commit();
            } catch(\ValidationException $e){
                // Rollback and then redirect
                DB::rollback();
            } catch(\Exception $e){
                DB::rollback();
            }
        }
        $data['result'] = $result;
        $data['code'] = $code;
        return $data;
    }
}


//Laravel\Socialite\Two\User Object
//(
//    [token] => EAAMldwwg45oBAPONIA6k1ZANQ5ygrKO0eMxFveCU7SHHNiSgO4YtSybCIv6WJP2dYr3M5TgyEZAvDOgnN1EmZBdXpRUBf7ZCpZC9ZCZBuWDPbrHAktQatVBJZCtegUZC3PDYbW6OqlcQfVZC8Xi0YiL2gdtPGIC9zBc4ZAMXEhBgZCGZCCgZDZD
//    [refreshToken] =>
//    [expiresIn] => 5184000
//    [id] => 1587861467942552
//    [nickname] =>
//    [name] => Văn Huyến
//    [email] => duyhuyentk5@gmail.com
//    [avatar] => https://graph.facebook.com/v2.10/1587861467942552/picture?type=normal
//    [user] => Array
//(
//    [name] => Văn Huyến
//            [email] => duyhuyentk5@gmail.com
//            [gender] => male
//            [verified] => 1
//            [link] => https://www.facebook.com/app_scoped_user_id/1587861467942552/
//            [id] => 1587861467942552
//        )
//
//    [avatar_original] => https://graph.facebook.com/v2.10/1587861467942552/picture?width=1920
//    [profileUrl] => https://www.facebook.com/app_scoped_user_id/1587861467942552/
//)



//Laravel\Socialite\Two\User Object
//(
//    [token] => ya29.GlsHBaJQbxe-TzNDHiYuzSXonL1IliF7_mv6Cky8E6h_Qsckj7A3UK0ucCOHOXE3KmkINNgf_ZgwxwuoovQKKHVtjTiBgWXTrjkVVZ1mDS1OmGau2IqnlKZwjLtU
//    [refreshToken] =>
//    [expiresIn] => 3600
//    [id] => 116377281429203206871
//    [nickname] =>
//    [name] => Mr Huyen
//    [email] => huyenha19891992@gmail.com
//    [avatar] => https://lh4.googleusercontent.com/-iQpoYjczfeg/AAAAAAAAAAI/AAAAAAAAAEg/mKLBMe0ml1k/photo.jpg?sz=50
//    [user] => Array
//(
//    [kind] => plus#person
//            [etag] => "ucaTEV-ZanNH5M3SCxYRM0QRw2Y/hYTYVDCAJUdkmfbz3eSVXQ__XyM"
//            [emails] => Array
//(
//    [0] => Array
//    (
//        [value] => huyenha19891992@gmail.com
//                            [type] => account
//                        )
//
//                )
//
//            [objectType] => person
//            [id] => 116377281429203206871
//            [displayName] => Mr Huyen
//            [name] => Array
//(
//    [familyName] => Huyen
//                    [givenName] => Mr
//                )
//
//            [url] => https://plus.google.com/116377281429203206871
//            [image] => Array
//(
//    [url] => https://lh4.googleusercontent.com/-iQpoYjczfeg/AAAAAAAAAAI/AAAAAAAAAEg/mKLBMe0ml1k/photo.jpg?sz=50
//                    [isDefault] =>
//                )
//
//            [isPlusUser] => 1
//            [language] => vi
//            [circledByCount] => 1
//            [verified] =>
//        )
//
//    [avatar_original] => https://lh4.googleusercontent.com/-iQpoYjczfeg/AAAAAAAAAAI/AAAAAAAAAEg/mKLBMe0ml1k/photo.jpg
//)
