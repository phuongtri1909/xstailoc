<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SoMo;
use App\Models\SoMoNew;
use Cache;

class SomoController extends Controller
{
    public function getSomo()
    {
        $somo = SoMo::inRandomOrder();
        $somo = $somo->paginate(30);

//        $somonew = SoMoNew::inRandomOrder()->paginate(15);
//        $somonew_lastPage = SoMoNew::inRandomOrder()->paginate(15)->lastPage();
        return view('frontend.somo.list', compact('somo'));
    }

    public function getSomo_Ajax(Request $request){

        $somo = SoMo::inRandomOrder();
        if(!empty($request->giacmo)){
            $somo->where('mo','like','%'.$request->giacmo.'%');
        }
        if(!empty($request->numbers)){
            $somo->where('so','like','%'.$request->numbers.'%');
        }
        $somo = $somo->take(100)->get();

        $dataReturn = ["template" => view('frontend.somo.list-ajax', compact('somo'))->render()];
        return json_encode($dataReturn);
    }

    public function getPostSomo($slug){
        $post = SoMo::where('slug',$slug)->first();
        if(empty($post)){
            return view('errors.404');
        }
        $post_lq = SoMo::inRandomOrder()->take(10)->get();
        return view('frontend.somo.post', compact('post','post_lq'));
    }

    public function getDetail($slug)
    {
        $qa = SoMoNew::where('slug', $slug)->first();
        if(empty($qa)) return view('errors.404');
        $qa_more_bottom = SoMoNew::orderBy('id', 'DESC')->take(6)->get();
//        if (count($qa_more_bottom) == 0)
//            $qa_more_bottom = Qa::take(10)->get();

        return view('frontend.somo.somonew_post', compact('qa', 'qa_more_bottom'));
    }

    public function getSomonewXemThem()
    {
        $somonew = SoMoNew::orderBy('id', 'DESC')->paginate(15);
        $dataReturn = [
            "template" => view('frontend.somo.somonew_them', compact('somonew'))->render(),
        ];
        return json_encode($dataReturn);

    }
}
