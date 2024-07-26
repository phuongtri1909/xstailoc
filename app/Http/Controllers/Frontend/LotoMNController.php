<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lottery;
use App\Models\Province;
use Cache;

class LotoMNController extends Controller
{
    public function getXsmn()
    {
        // lấy tổng số page
        $total = Lottery::where('mien', 3)->where('status', 1)->select('date')->orderBy('date', 'DESC')->distinct()->get()->toArray();
        $lastPage = floor(count($total) / 7);

        // lấy mảng kết quả 7 ngày
        $list_7day = Lottery::where('mien', 3)->where('status', 1)->select('date')->orderBy('date', 'DESC')->distinct()->take(7)->get();

        $kqxsmns = array();
        foreach ($list_7day as $item) {
            $kqxsmns[$item->date] = Lottery::where('mien', 3)->where('status', 1)->where('date',$item->date)->get();
        }

        return view('frontend.loto_mn.xsmn', compact('kqxsmns', 'lastPage'));
    }

    public function getXsmnXemThem(Request $request)
    {
        $skip = $request->skip;

        // lấy mảng kết quả 7 ngày
        $list_7day = Lottery::where('mien', 3)->where('status', 1)->select('date')->orderBy('date', 'DESC')->distinct()->skip($skip)->take(7)->get();

        $kqxsmns = array();
        foreach ($list_7day as $item) {
            $kqxsmns[$item->date] = Lottery::where('mien', 3)->where('status', 1)->where('date',$item->date)->get();
        }
        $view = $this->__buildTeamPlateXsmn($kqxsmns);
        $dataReturn = [
            "template" => $view->render(),
        ];
        return json_encode($dataReturn);
    }

    private function __buildTeamPlateXsmn($kqxsmns)
    {
        return view('frontend.loto_mn.block_xsmn', compact('kqxsmns'));
    }


    public function getXsmnThu($day)
    {
        if ($day == 'chu-nhat') $day = 8;
        else $day = substr($day, strlen($day) - 1);

        // lấy tổng số page
        $total = Lottery::where('mien', 3)->where('day', $day)->where('status', 1)->select('date')->orderBy('date', 'DESC')->distinct()->get()->toArray();
        $lastPage = floor(count($total) / 7);

        // lấy mảng kết quả 7 ngày
        $list_7day = Lottery::where('mien', 3)->where('day', $day)->where('status', 1)->select('date')->orderBy('date', 'DESC')->distinct()->take(7)->get();

        $kqxsmns = array();
        foreach ($list_7day as $item) {
            $kqxsmns[$item->date] = Lottery::where('mien', 3)->where('day', $day)->where('status', 1)->where('date',$item->date)->get();
        }

        $thu = getThu($day);
        $title = 'Lô tô miền nam ' . $thu;

        return view('frontend.loto_mn.xsmn-thu', compact('kqxsmns', 'lastPage', 'day', 'title'));
    }

    public function getXsmnXemThemTheoThu(Request $request)
    {
        $skip = $request->skip;
        $day = $request->day;

        // lấy mảng kết quả 7 ngày
        $list_7day = Lottery::where('mien', 3)->where('day', $day)->where('status', 1)->select('date')->orderBy('date', 'DESC')->distinct()->skip($skip)->take(7)->get();

        $kqxsmns = array();
        foreach ($list_7day as $item) {
            $kqxsmns[$item->date] = Lottery::where('mien', 3)->where('day', $day)->where('status', 1)->where('date',$item->date)->get();
        }
        $view = $this->__buildTeamPlateXsmn($kqxsmns);
        $dataReturn = [
            "template" => $view->render(),
        ];
        return json_encode($dataReturn);
    }

}
