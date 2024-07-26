<?php

namespace App\Http\Controllers\Backend;

use App\Models\GiaiMaGiacMo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Session;
use Cache;
use Illuminate\Validation\Rule;

class GiaiMaGiacMoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = GiaiMaGiacMo::orderBy('id', 'DESC')->paginate(30);
        return view('admin.giaimagiacmo.index', compact(['posts']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.giaimagiacmo.create');
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
                'title' => 'required|unique:giai_ma_giac_mo',
                'content' => 'required',
            ]);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }

        // lưu vào DB
        $post = GiaiMaGiacMo::create([
            'title' => $data['title'],
            'slug' => empty(trim($data['slug']))?chanetitle($data['title']):trim($data['slug']),
            'des' => $data['des'],
            'content' => $data['content'], 
            'img' => $data['img'],
            'meta_title' => $data['meta_title'],
            'meta_description' => $data['meta_description'],
            'meta_keyword' => $data['meta_keyword'],
        ]);

        if (!$post) {
            Session::flash('flash_warning', 'Lỗi không thêm được bài viết');
            return redirect()->back()->withErrors($v->errors())->withInput();
        }
        Session::flash('flash_success', 'Thêm bài viết thành công');
        return redirect()->route('giaimagiacmo.index');
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
        $post = GiaiMaGiacMo::find($id);
        if (!$post) {
            Session::flash('flash_warning', 'Không tồn tại!');
            return redirect()->back()->withInput();
        }

        return view('admin.giaimagiacmo.update', compact('post'));
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
        $qa = GiaiMaGiacMo::find($id);
        $v = \Validator::make($data,
            [
                'title' => [
                    'required',
                    Rule::unique('giai_ma_giac_mo')->ignore($id),
                ],
                'content' => 'required',
                'slug' => 'required',
            ]);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }

        $qa->title = $data['title'];
        $qa->slug = trim($data['slug']);
        $qa->des = $data['des'];
        $qa->content = $data['content'];
        $qa->img = $data['img'];
        $qa->meta_title = $data['meta_title'];
        $qa->meta_description = $data['meta_description'];
        $qa->meta_keyword = $data['meta_keyword'];
        $qa->save();

        if (!$qa->save()) {
            Session::flash('flash_warning', 'Lỗi không sửa được thông tin bài viết');
            return redirect()->back()->withErrors($v->errors())->withInput();
        }
        Session::flash('flash_success', 'Update thông tin bài viết thành công');
        return redirect()->route('giaimagiacmo.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = GiaiMaGiacMo::find($id)->delete();
        if (!$post) {
            return response()->json(array('code' => 0, 'msg' => 'Không xóa được'));
        }
        return response()->json(array('code' => 1, 'msg' => 'Xóa thành công'));
    }
}
