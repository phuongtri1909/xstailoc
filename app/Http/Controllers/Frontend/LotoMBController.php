<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lottery;
use App\Models\Province;
use Cache;

class LotoMBController extends Controller
{
    // LÔ tô miền bắc
    public function getXsmb()
    {
        $lastPage = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->paginate(7)->lastPage();
        $xsmbs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take(7)->get();

        return view('frontend.loto_mb.loto_xsmb', compact('xsmbs', 'lastPage'));
    }

    public function getXsmbXemThem()
    {
        $xsmbs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->paginate(7);
        $view = $this->__buildTeamPlateXsmb($xsmbs);
        $dataReturn = [
            "template" => $view->render(),
        ];
        return json_encode($dataReturn);
    }
    //END LÔ tô miền bắc

    private function __buildTeamPlateXsmb($xsmbs)
    {
        return view('frontend.loto_mb.block_loto_xsmb', compact('xsmbs'));
    }

    // Lô tô miền bắc theo thứ
    public function getXsmbThu($day)
    {
        if ($day == 'chu-nhat') $day = 8;
        else $day = substr($day, strlen($day) - 1);

        $lastPage = Lottery::where('mien', 1)->where('day', $day)->where('status', 1)->orderBy('date', 'DESC')->paginate(7)->lastPage();
        $xsmbs = Lottery::where('mien', 1)->where('day', $day)->where('status', 1)->orderBy('date', 'DESC')->take(7)->get();
        $thu = getThu($day);
        $title = 'Lô tô miền Bắc ' . $thu;

        return view('frontend.loto_mb.loto_xsmb_thu', compact('xsmbs', 'lastPage', 'day', 'title'));
    }

    public function getXsmbXemThemTheoThu(Request $request)
    {
        $day = $request->day;
        if ($day == 'chu-nhat') $day = 8;
        else $day = substr($day, strlen($day) - 1);

        $xsmbs = Lottery::where('mien', 1)->where('day', $day)->where('status', 1)->orderBy('date', 'DESC')->paginate(7);
        $view = $this->__buildTeamPlateXsmbThu($xsmbs);
        $dataReturn = [
            "template" => $view->render(),
        ];
        return json_encode($dataReturn);
    }
    private function __buildTeamPlateXsmbThu($xsmbs)
    {
        return view('frontend.loto_mb.block_loto_xsmb', compact('xsmbs'));
    }
    //END Lô tô miền bắc theo thứ

    public function getLotoMN()
    {
    }

    public function getLotoMT()
    {
    }
}
