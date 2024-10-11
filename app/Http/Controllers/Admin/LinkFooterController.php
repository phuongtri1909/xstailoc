<?php

namespace App\Http\Controllers\Admin;


use App\Models\LinkFooter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LinkFooterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = LinkFooter::get();
        return view('admin.link_footer.index', compact('links'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'link' => 'required|url',
        ],[
            'title.required' => 'Vui lòng nhập tên.',
            'link.required' => 'Vui lòng nhập URL.',
            'link.url' => 'URL không hợp lệ.',
        ]);

        try {
            $link = new LinkFooter();
            $link->title = $request->title;
            $link->link = $request->link;
            $link->save();
           
        } catch (\Exception $e) {
            return redirect()->route('link-footer.index')->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
        }
        return redirect()->route('link-footer.index')->with('success', 'Thêm liên kết thành công.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$linkFooter)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'link' => 'required|url',
        ], [
            'title.required' => 'Vui lòng nhập tên.',
            'link.required' => 'Vui lòng nhập URL.',
            'link.url' => 'URL không hợp lệ.',
        ]);
    
        // Find the link by ID and update it
        $link = LinkFooter::findOrFail($linkFooter);
        $link->title = $validatedData['title'];
        $link->link = $validatedData['link'];
        $link->save();
    
        // Return a success response
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($linkFooter)
    {
        $linkFooter = LinkFooter::find($linkFooter);
        if ($linkFooter) {
            try {
                $linkFooter->delete();
                return response()->json(['success' => 'Xóa liên kết thành công.']);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Có lỗi xảy ra, vui lòng thử lại.']);
            }
        }else{
            return response()->json(['error' => 'Không tìm thấy liên kết.']);
        }
    }
}
