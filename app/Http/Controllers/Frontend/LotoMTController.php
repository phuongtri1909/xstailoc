<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lottery;
use App\Models\Province;
use Cache;

class LotoMTController extends Controller
{
    public function getXsmt()
    {
        // lấy tổng số page
        $total = Lottery::where('mien', 2)->where('status', 1)->select('date')->orderBy('date', 'DESC')->distinct()->get()->toArray();
        $lastPage = floor(count($total) / 7);

        // lấy mảng kết quả 7 ngày
        $list_7day = Lottery::where('mien', 2)->where('status', 1)->select('date')->orderBy('date', 'DESC')->distinct()->take(7)->get();

        $kqxsmts = array();
        foreach ($list_7day as $item) {
            $kqxsmts[$item->date] = Lottery::where('mien', 2)->where('status', 1)->where('date',$item->date)->get();
        }

        return view('frontend.loto_mt.xsmt', compact('kqxsmts', 'lastPage'));
    }

    public function getXsmtXemThem(Request $request)
    {
        $skip = $request->skip;

        // lấy mảng kết quả 7 ngày
        $list_7day = Lottery::where('mien', 2)->where('status', 1)->select('date')->orderBy('date', 'DESC')->distinct()->skip($skip)->take(7)->get();

        $kqxsmts = array();
        foreach ($list_7day as $item) {
            $kqxsmts[$item->date] = Lottery::where('mien', 2)->where('status', 1)->where('date',$item->date)->get();
        }
        $view = $this->__buildTeamPlateXsmt($kqxsmts);
        $dataReturn = [
            "template" => $view->render(),
        ];
        return json_encode($dataReturn);
    }

    private function __buildTeamPlateXsmt($kqxsmts)
    {
        return view('frontend.loto_mt.block_xsmt', compact('kqxsmts'));
    }


    public function getXsmtThu($day)
    {
        if ($day == 'chu-nhat') $day = 8;
        else $day = substr($day, strlen($day) - 1);

        // lấy tổng số page
        $total = Lottery::where('mien', 2)->where('day', $day)->where('status', 1)->select('date')->orderBy('date', 'DESC')->distinct()->get()->toArray();
        $lastPage = floor(count($total) / 7);

        // lấy mảng kết quả 7 ngày
        $list_7day = Lottery::where('mien', 2)->where('day', $day)->where('status', 1)->select('date')->orderBy('date', 'DESC')->distinct()->take(7)->get();

        $kqxsmts = array();
        foreach ($list_7day as $item) {
            $kqxsmts[$item->date] = Lottery::where('mien', 2)->where('day', $day)->where('status', 1)->where('date',$item->date)->get();
        }

        $thu = getThu($day);
        $title = 'Lô tô miền trung ' . $thu;

        return view('frontend.loto_mt.xsmt-thu', compact('kqxsmts', 'lastPage', 'day', 'title'));
    }

    public function getXsmtXemThemTheoThu(Request $request)
    {
        $skip = $request->skip;
        $day = $request->day;

        // lấy mảng kết quả 7 ngày
        $list_7day = Lottery::where('mien', 2)->where('day', $day)->where('status', 1)->select('date')->orderBy('date', 'DESC')->distinct()->skip($skip)->take(7)->get();

        $kqxsmts = array();
        foreach ($list_7day as $item) {
            $kqxsmts[$item->date] = Lottery::where('mien', 2)->where('day', $day)->where('status', 1)->where('date',$item->date)->get();
        }
        $view = $this->__buildTeamPlateXsmt($kqxsmts);
        $dataReturn = [
            "template" => $view->render(),
        ];
        return json_encode($dataReturn);
    }

}
