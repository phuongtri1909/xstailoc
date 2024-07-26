<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SXLive;

class XSLiveController extends Controller
{
    public function edit($id)
    {
        $row = SXLive::find($id);
        if(!$row){
            \Session::flash('flash_warning','Không có thành viên này');
            return redirect()->back()->withInput();
        }
        return view('admin.live.update', compact('row'));
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
                'isSocket' => 'required',
            ]);
        if($v->fails()){
            return redirect()->back()->withErrors($v->errors())->withInput();
        }
        $xslive=SXLive::find($id);
        $xslive->is_socket = $input['isSocket'];
        $xslive->save();
        \Session::flash('flash_success','Cập nhật thành công!');
        return redirect()->route('live.edit',1);
    }
}
