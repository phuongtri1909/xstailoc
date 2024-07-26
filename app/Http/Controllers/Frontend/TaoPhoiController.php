<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lottery;
use App\Models\Province;
use Cache;

class TaoPhoiController extends Controller
{

    public function getTaoPhoi()
    {
        return view('frontend.tao_phoi.tao-phoi');
    }

    public function getTaoPhoi_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $count = $request->count;
        $thu = $request->thu;

        if($thu==1){
            $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take($count)->get();
        }else{
            $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('day', $thu)->where('date', '<=', $date)->orderBy('date', 'DESC')->take($count)->get();
        }


        $arrdates = '';
        $arrPos = '';
        $arrPos_first = '';
        foreach ($xsmbs as $xsmb) {
            $date_section = getDateLienNhau($xsmb->date);
            $arrdates .= "'" . $date_section . "',";
            $arrPos .= "A" . $date_section . ",";
            if (empty($arrPos_first)) {
                $arrPos_first = "A" . $date_section;
            }
        }
        $arrdates = substr($arrdates, 0, -1);
        $arrPos = substr($arrPos, 0, -1);

        $lifetime = '';
        $valuelt = '';
        $positionOne = '';
        $positionTwo = '';

        $arr_js['arrdates'] = $arrdates;
        $arr_js['arrPos'] = $arrPos;
        $arr_js['lifetime'] = $lifetime;
        $arr_js['positionOne'] = $positionOne;
        $arr_js['positionTwo'] = $positionTwo;
        $arr_js['valuelt'] = $valuelt;
        $arr_js['arrPos_first'] = $arrPos_first;

        $view = view('frontend.tao_phoi.tao-phoi-ajax',compact('xsmbs','arr_js'))->render();
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }
}
