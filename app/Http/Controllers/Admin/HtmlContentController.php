<?php

namespace App\Http\Controllers\Admin;

use App\Models\HtmlContent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HtmlContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $key = $request->key;
        $htmlContent = HtmlContent::where('key', $key)->first();
        return view('admin.html_content.index', compact('htmlContent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$key)
    {
        
        $htmlContent = HtmlContent::where('key', $key)->first();

        if(!$htmlContent){
            return redirect()->route('content_html', ['key' => $key])->with('error', 'Không tìm thấy nội dung');
        }

        $htmlContent->content = $request->content;
        $htmlContent->save();
        return redirect()->route('content_html', ['key' => $key])->with('success', 'Cập nhật thành công');
    }
}
