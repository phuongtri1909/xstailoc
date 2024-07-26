<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lottery;
use App\Models\Province;

class EmbedController extends Controller
{
    public function getMaNhung(){
        $province_name = 'Miền Bắc';
        $height = '980';
        $link = route('embed.xsmb');
        $link_ngay = route('embed.xsmb.date',date('d-m-Y',strtotime("-1 days")));
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.embed.ma-nhung', compact('provinces','height','link','province_name','link_ngay'));
    }
    public function getMaNhung_Ajax(Request $request){
        $province_id = $request->province_id;
        if($province_id == 'mb'){
            $province_name = 'Miền Bắc';
            $height = '980';
            $link = route('embed.xsmb');
            $link_ngay = route('embed.xsmb.date',date('d-m-Y',strtotime("-1 days")));
        }elseif($province_id == 'mt'){
            $province_name = 'Miền Trung';
            $height = '1200';
            $link = route('embed.xsmt');
            $link_ngay = route('embed.xsmt.date',date('d-m-Y',strtotime("-1 days")));
        }elseif($province_id == 'mn'){
            $province_name = 'Miền Nam';
            $height = '1200';
            $link = route('embed.xsmn');
            $link_ngay = route('embed.xsmn.date',date('d-m-Y',strtotime("-1 days")));
        }else{
            $height = '945';
            $province = Province::find($province_id);
            $province_name = $province->name;
            $link = route('embed.tinh',$province->slug_sc);
            $xs = Lottery::where('province_id', $province_id)->orderBy('date', 'DESC')->first();
            $link_ngay = route('embed.tinh.date',[$province->slug_sc,getNgayLink($xs->date)]);
        }
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        $dataReturn = ["template" => view('frontend.embed.ma-nhung-ajax', compact('provinces','height','link','province_name','link_ngay'))->render()];
        return json_encode($dataReturn);
    }
    public function getXsmbEmbed(Request $request)
    {
//        if (!empty($request->ngay_quay)) {
//            $xsmb = Lottery::where('mien', 1)->where('date', getNgayLink($request->ngay_quay))->first();
//
//            if (empty($xsmb)) {
//                $date = getNgayLink($request->ngay_quay);
//                return view('frontend.embed.xsmb_embed_nokq', compact('date'));
//            }
//        } else {
            $xsmb = Lottery::where('mien', 1)->orderBy('date', 'DESC')->first();
//        }
        return view('frontend.embed.xsmb_embed', compact('xsmb'));
    }

    public function getXsmnEmbed(Request $request)
    {
//        if (!empty($request->ngay_quay)) {
//            $xsmns = Lottery::where('mien', 3)->where('date', getNgayLink($request->ngay_quay))->get();
//
//            if (count($xsmns) == 0) {
//                $date = getNgayLink($request->ngay_quay);
//                $day = getThuNumber(getNgayLink($request->ngay_quay));
//                $arr_province = Province::where('mien', 3)->where('ngay_quay', 'like', '%' . $day . '%')->get();
//
//                $provinces = Province::where('mien', 3)->get();
//                return view('frontend.embed.xsmn_embed_nokq', compact('provinces', 'arr_province', 'date'));
//            }
//        } else {
            $xsmn_new = Lottery::where('mien', 3)->orderBy('date', 'DESC')->first();
            $xsmns = Lottery::where('mien', 3)->where('date', $xsmn_new->date)->get();
//        }

        return view('frontend.embed.xsmn_embed', compact('xsmns'));
    }

    public function getXsmtEmbed(Request $request)
    {
//        if (!empty($request->ngay_quay)) {
//            $xsmts = Lottery::where('mien', 2)->where('date', getNgayLink($request->ngay_quay))->get();
//
//            if (count($xsmts) == 0) {
//                $date = getNgayLink($request->ngay_quay);
//                $day = getThuNumber(getNgayLink($request->ngay_quay));
//                $arr_province = Province::where('mien', 2)->where('ngay_quay', 'like', '%' . $day . '%')->get();
//
//                $provinces = Province::where('mien', 2)->get();
//                return view('frontend.embed.xsmt_embed_nokq', compact('provinces', 'arr_province', 'date'));
//            }
//        } else {
            $xsmt_new = Lottery::where('mien', 2)->orderBy('date', 'DESC')->first();
            $xsmts = Lottery::where('mien', 2)->where('date', $xsmt_new->date)->get();
//        }

        return view('frontend.embed.xsmt_embed', compact('xsmts'));
    }


    public function getXsmbEmbed_Date($date)
    {
        $xsmb = Lottery::where('mien', 1)->where('date', getNgayLink($date))->first();
        if (empty($xsmb)) {
            $date = getNgayLink($date);
            return view('frontend.embed.xsmb_embed_nokq', compact('date'));
        }
        return view('frontend.embed.xsmb_embed', compact('xsmb','date'));
    }

    public function getXsmnEmbed_Date($ngay)
    {
        $xsmns = Lottery::where('mien', 3)->where('date', getNgayLink($ngay))->get();

        if (count($xsmns) == 0) {
            $date = getNgayLink($ngay);
            $day = getThuNumber(getNgayLink($ngay));
            $arr_province = Province::where('mien', 3)->where('ngay_quay', 'like', '%' . $day . '%')->get();

            $provinces = Province::where('mien', 3)->get();
            return view('frontend.embed.xsmn_embed_nokq', compact('provinces', 'arr_province', 'date'));
        }
        return view('frontend.embed.xsmn_embed', compact('xsmns','ngay'));
    }

    public function getXsmtEmbed_Date($ngay)
    {
        $xsmts = Lottery::where('mien', 2)->where('date', getNgayLink($ngay))->get();

        if (count($xsmts) == 0) {
            $date = getNgayLink($ngay);
            $day = getThuNumber(getNgayLink($ngay));
            $arr_province = Province::where('mien', 2)->where('ngay_quay', 'like', '%' . $day . '%')->get();

            $provinces = Province::where('mien', 2)->get();
            return view('frontend.embed.xsmt_embed_nokq', compact('provinces', 'arr_province', 'date'));
        }

        return view('frontend.embed.xsmt_embed', compact('xsmts','ngay'));
    }


    public function getXsEmbed_Tinh($slug)
    {
        $province = Province::where('slug_sc', $slug)->first();
        if (!empty($province)) {
            $xs = Lottery::where('province_id', $province->id)->orderBy('date', 'DESC')->first();
            if ($province->mien == 3){
                return view('frontend.embed.xsmn_tinh_embed', compact('xs', 'province'));
            }elseif ($province->mien == 2){
                return view('frontend.embed.xsmt_tinh_embed', compact('xs', 'province'));
            }elseif($province->mien == 1){
                return view('frontend.embed.xsmb_tinh_embed', compact('xs', 'province'));
            }
        } else {
            return view('errors.404');
        }
    }

    public function getXsEmbed_Tinh_Date($slug,$date)
    {
        $province = Province::where('slug_sc', $slug)->first();
        if (!empty($province)) {
            $xs = Lottery::where('province_id', $province->id)->where('date', getNgayLink($date))->orderBy('date', 'DESC')->first();
            if(empty($xs)){
                $date = getNgayLink($date);
                if ($province->mien == 3){
                    return view('frontend.embed.xsmn_tinh_embed_nokq', compact('province', 'date'));
                }elseif ($province->mien == 2){
                    return view('frontend.embed.xsmt_tinh_embed_nokq', compact('province', 'date'));
                }elseif($province->mien == 1){
                    return view('frontend.embed.xsmb_tinh_embed_nokq', compact('province', 'date'));
                }
            }
            if ($province->mien == 3){
                return view('frontend.embed.xsmn_tinh_embed', compact('xs', 'province', 'date'));
            }elseif ($province->mien == 2){
                return view('frontend.embed.xsmt_tinh_embed', compact('xs', 'province', 'date'));
            }elseif($province->mien == 1){
                return view('frontend.embed.xsmb_tinh_embed', compact('xs', 'province', 'date'));
            }
        } else {
            return view('errors.404');
        }
    }
}
