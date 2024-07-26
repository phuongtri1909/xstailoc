<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;
use Hash;

class UserController extends Controller
{
    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $users=User::orderBy('created_at', 'DESC')
            ->where(function ($query) use ($input) {
                if(!empty($input['keyword'])){
                    $query->where('phone', 'like', '%'.$input['keyword'].'%')
                        ->orWhere('name', 'like', '%'.$input['keyword'].'%')
                        ->orWhere('email', 'like', '%'.$input['keyword'].'%');
                }
            })
            ->paginate(30);
        return view('admin.user.index',compact(['users','input']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Role::orderBy('created_at', 'DESC')->get();
        return view('admin.user.add', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $v = \Validator::make($data,
            [
                'name' => 'required',
                'email' => 'required|email|max:191|unique:users',
                'password' => 'required|min:6|confirmed',
                'roles' => 'required',
            ]);
        if($v->fails()){
            return redirect()->back()->withErrors($v->errors())->withInput();
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);
        $roles=$request->roles;
        foreach ($roles as $role){
            $user->assignRole($role);
        }

        if(!$user){
            \Session::flash('flash_warning','Lỗi không tạo được thành viên');
            return redirect()->back()->withErrors($v->errors())->withInput();
        }
        \Session::flash('flash_success','Thêm thành viên thành công');
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showUser()
    {
        $row = User::find(Auth::user()->id);
        if(!$row){
            \Session::flash('flash_warning','Không có thành viên này');
            return redirect()->back()->withInput();
        }
        return view('admin.user.show_user', compact('row'));
    }

    public function postUpdate(Request $request)
    {
        $input = $request->all();
        $v = \Validator::make($input,
            [
                'name' => 'required',
                'email' => 'required|email|max:191',
            ]);
        if($v->fails()){
            return redirect()->back()->withErrors($v->errors())->withInput();
        }
        $user=User::find(Auth::user()->id);
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->save();
        \Session::flash('flash_success','Cập nhật thành công!');
        return redirect()->route('admin.account.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = User::find($id);
        if(!$row){
            \Session::flash('flash_warning','Không có thành viên này');
            return redirect()->back()->withInput();
        }
        $role_old = [];
        foreach($row->roles as $r){
            array_push($role_old, $r->id);
        }

        $allRoles=Role::orderBy('created_at', 'DESC')->get();
        return view('admin.user.update', compact('row','allRoles','role_old'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $v = \Validator::make($input,
            [
                'name' => 'required',
                'email' => 'required|email|max:191',
                'roles' => 'required',
            ]);
        if($v->fails()){
            return redirect()->back()->withErrors($v->errors())->withInput();
        }
        $user=User::find($input['id']);
        $roles=$request->roles;
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        foreach ($roles as $role){
            $user->assignRole($role);
        }
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->save();
        \Session::flash('flash_success','Cập nhật thành công!');
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        $row = User::find($id);
        if(!$row){
            return 'ko có thành viên này!';
        }
        $user = User::find($id)->delete();
        if($user)
        {
            return 'đã xóa';
        }else{
            return 'xóa ko thành công!';
        }
    }

    public function showUpdatePassword(){
        return view('admin.user.change_pass');
    }
    public function updatePassword(Request $request){
        $data = $request->all();
//        dd($data);
        $v = \Validator::make($data,
            [
                'password_old'  => 'required|min:6',
                'password'      => 'required|min:6|confirmed',
            ]);
        if($v->fails()){
            return redirect()->back()->withErrors($v->errors())->withInput();
        }
//dd(Auth::User());
        // check password old
        if(Hash::check($data['password_old'], Auth::User()->password))
        {
//            dd($data);
            $update = User::where('id',Auth::user()->id)
                ->update(['password' => bcrypt($data['password'])]);

            if(!$update){
                \Session::flash('flash_warning','Lỗi cập nhật');
                return redirect()->back()->withErrors($v->errors())->withInput();
            }
            \Session::flash('flash_success','Đổi mật khẩu thành công');
            return redirect()->back()->withErrors($v->errors())->withInput();
        }else{
            \Session::flash('flash_warning','Sai mật khẩu cũ');
            return redirect()->back()->withErrors($v->errors())->withInput();
        }
    }
}
