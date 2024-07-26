<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lottery;
use App\Models\Province;
use Cache;

class QuayThuXSController extends Controller
{
    public function getQuayThu()
    {
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.quay_thu.quay_thu',compact('provinces'));
    }
    public function getQuayThuMB()
    {
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.quay_thu.quay_thu_mb',compact('provinces'));
    }
    public function getQuayThuMN()
    {
        $day = getThuNumber(date('Y-m-d', time()));
        $arr_province = Province::where('mien',3)->where('ngay_quay','like','%'.$day.'%')->get();

        $provinces = Province::where('mien', 3)->get();
        return view('frontend.quay_thu.quay_thu_mn',compact('provinces','arr_province'));
    }
    public function getQuayThuMT()
    {
        $day = getThuNumber(date('Y-m-d', time()));
        $arr_province = Province::where('mien',2)->where('ngay_quay','like','%'.$day.'%')->get();

        $provinces = Province::where('mien', 2)->get();
        return view('frontend.quay_thu.quay_thu_mt',compact('provinces','arr_province'));
    }
    public function getQuayThuTheoTinh($slug)
    {
        $province = Province::where('short_name',$slug)->first();
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        $short_name_upper = strtoupper($province->short_name);
        $name = $province->name;

        $meta_title = 'Quay thử XS'.$short_name_upper.' - Quay thử Xổ số '.$name.' hôm nay';
        $meta_description = 'Quay thử XS'.$short_name_upper.' ✅ - Quay thử Xổ số '.$name.' lấy hên trước giờ tường thuật xổ số, Quay thử Xổ số '.$name.' hôm nay trước khi mua vé xổ số kiến thiết '.$short_name_upper.', chúc bạn may mắn!';
        $meta_keyword ='Quay thử XS'.$short_name_upper.', quay thu xs'.$short_name_upper.', quay thử xổ số '.$name.', quay thử xổ số '.$name.' hôm nay';

        return view('frontend.quay_thu.quay_thu_tinh_tn',compact('province','provinces','meta_title','meta_description','meta_keyword'));
    }
}
