<?php

namespace App\Http\Controllers\Admin;

use App\Models\SoMo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Session;
use Cache;
use Illuminate\Validation\Rule;

class SoMoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $posts = SoMo::orderBy('id', 'DESC')
            ->where(function ($query) use ($input) {
                if(!empty($input['keyword'])){
                    $query->where('mo', 'like', '%'.$input['keyword'].'%');
                }
            })
            ->paginate(30);
        return view('admin.somo.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.somo.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $v = Validator::make($data,
            [
                'mo' => 'required|unique:so_mo',
                'so' => 'required',
//                'title' => 'required',
//                'content' => 'required',
            ]);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }

        // lưu vào DB
        $post = SoMo::create([
//            'title' => trim($data['title']),
            'mo' => trim($data['mo']),
//            'slug' => empty(trim($data['slug']))?chanetitle($data['title']):trim($data['slug']),
            'so' => trim($data['so']),
            'link' => trim($data['link']),
            'content' => trim($data['content']),
//            'img' => $data['img'],
//            'meta_title' => $data['meta_title'],
//            'meta_description' => $data['meta_description']
        ]);

        if (!$post) {
            Session::flash('flash_warning', 'Lỗi không thêm được bài viết');
            return redirect()->back()->withErrors($v->errors())->withInput();
        }
        Session::flash('flash_success', 'Thêm bài viết thành công');
        return redirect()->route('somo.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = SoMo::find($id);
        if (!$post) {
            Session::flash('flash_warning', 'Không tồn tại!');
            return redirect()->back()->withInput();
        }

        return view('admin.somo.update', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $qa = SoMo::find($id);
        $v = \Validator::make($data,
            [
                'so' => 'required',
                'mo' => 'required',
            ]);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }
        
//        $qa->title = trim($data['title']);
        $qa->mo = trim($data['mo']);
//        $qa->slug = empty(trim($data['slug']))?chanetitle($data['title']):trim($data['slug']);
        $qa->so = trim($data['so']);
        $qa->link = trim($data['link']);
        $qa->content = trim($data['content']);
//        $qa->img = trim($data['img']);
//        $qa->meta_title = trim($data['meta_title']);
//        $qa->meta_description = trim($data['meta_description']);
        $qa->save();

        if (!$qa->save()) {
            Session::flash('flash_warning', 'Lỗi không sửa được thông tin bài viết');
            return redirect()->back()->withErrors($v->errors())->withInput();
        }
        Session::flash('flash_success', 'Update thông tin bài viết thành công');
        return redirect()->route('somo.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = SoMo::find($id)->delete();
        if (!$post) {
            return response()->json(array('code' => 0, 'msg' => 'Không xóa được'));
        }
        return response()->json(array('code' => 1, 'msg' => 'Xóa thành công'));
    }
}
