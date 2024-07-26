<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DienToan;
use Cache;

class DienToanController extends Controller
{
    public function getDienToan6x36()
    {
        $lastPage = DienToan::where('type', 1)->orderBy('date', 'DESC')->paginate(10)->lastPage();
        $kqs = DienToan::where('type', 1)->orderBy('date', 'DESC')->take(10)->get();

        return view('frontend.dien_toan.dien_toan_6x36', compact('kqs', 'lastPage'));
    }

    public function getDienToan123()
    {
        $lastPage = DienToan::where('type', 2)->orderBy('date', 'DESC')->paginate(10)->lastPage();
        $kqs = DienToan::where('type', 2)->orderBy('date', 'DESC')->take(10)->get();

        return view('frontend.dien_toan.dien_toan_123', compact('kqs', 'lastPage'));
    }

    public function getXsThanTai()
    {
        $lastPage = DienToan::where('type', 3)->orderBy('date', 'DESC')->paginate(10)->lastPage();
        $kqs = DienToan::where('type', 3)->orderBy('date', 'DESC')->take(10)->get();

        return view('frontend.dien_toan.than_tai_4', compact('kqs', 'lastPage'));
    }

    public function getDienToanXemThem(Request $request)
    {
        $type = $request->type;
        if ($type == 1) {
            $block = 'block_6x36';
        } elseif ($type == 2) {
            $block = 'block_123';
        } elseif ($type == 3) {
            $block = 'block_tt4';
        }
        $kqs = DienToan::where('type', $type)->orderBy('date', 'DESC')->paginate(10);
        $view = $this->__buildTeamPlateDT($kqs, $block);
        $dataReturn = [
            "template" => $view->render(),
        ];
        return json_encode($dataReturn);
    }

    private function __buildTeamPlateDT($kqs, $block)
    {
        return view('frontend.dien_toan.' . $block, compact('kqs'));
    }
}
