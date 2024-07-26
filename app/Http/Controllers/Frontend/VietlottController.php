<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Max3D;
use App\Models\Max3DPro;
use App\Models\Power655;
use App\Models\Mega645;
use Cache;

class VietlottController extends Controller
{
    public function index()
    {
        $kq_power655 = Power655::orderBy('date', 'DESC')->first();
        $kq_mega645 = Mega645::orderBy('date', 'DESC')->first();
        $kq_max3d = Max3D::orderBy('date', 'DESC')->first();
        $kq_max3d_pro = Max3DPro::orderBy('date', 'DESC')->first();

        return view('frontend.vietlott.vietlott', compact('kq_power655','kq_mega645','kq_max3d','kq_max3d_pro'));
    }

    public function getMega()
    {
        $lastPage = Mega645::orderBy('date', 'DESC')->paginate(10)->lastPage();
        $kqs = Mega645::orderBy('date', 'DESC')->take(10)->get();


        // check KQ ngày hôm nay
        $date = date('Y-m-d', time());
        $kq = Mega645::where('date', $date)->get();
        if (count($kq) > 0) {
            $kq_today = true;
        } else {
            $kq_today = false;
        }

        return view('frontend.vietlott.mega645', compact('kqs', 'lastPage', 'kq_today'));
    }

    public function getMegaXemThem()
    {
        $kqs = Mega645::orderBy('date', 'DESC')->paginate(10);
        $dataReturn = [
            "template" => view('frontend.vietlott.block_mega645', compact('kqs'))->render(),
        ];
        return json_encode($dataReturn);
    }

    public function getPower()
    {
        $lastPage = Power655::orderBy('date', 'DESC')->paginate(10)->lastPage();
        $kqs = Power655::orderBy('date', 'DESC')->take(10)->get();

        // check KQ ngày hôm nay
        $date = date('Y-m-d', time());
        $kq = Power655::where('date', $date)->get();
        if (count($kq) > 0) {
            $kq_today = true;
        } else {
            $kq_today = false;
        }
        return view('frontend.vietlott.power655', compact('kqs','lastPage','kq_today'));
    }

    public function getPowerXemThem()
    {
        $kqs = Power655::orderBy('date', 'DESC')->paginate(10);
        $dataReturn = [
            "template" => view('frontend.vietlott.block_power655', compact('kqs'))->render(),
        ];
        return json_encode($dataReturn);
    }

    public function getMax3d()
    {
        $lastPage = Max3D::orderBy('date', 'DESC')->paginate(10)->lastPage();
        $kqs = Max3D::orderBy('date', 'DESC')->take(10)->get();

        // check KQ ngày hôm nay
        $date = date('Y-m-d', time());
        $kq = Max3D::where('date', $date)->get();
        if (count($kq) > 0) {
            $kq_today = true;
        } else {
            $kq_today = false;
        }

        return view('frontend.vietlott.max3d', compact('kqs','lastPage','kq_today'));
    }

    public function getMax3dXemThem()
    {
        $kqs = Max3D::orderBy('date', 'DESC')->paginate(10);
        $dataReturn = [
            "template" => view('frontend.vietlott.block_max3d', compact('kqs'))->render(),
        ];
        return json_encode($dataReturn);
    }

    public function getMax3dPro()
    {
        $lastPage = Max3DPro::orderBy('date', 'DESC')->paginate(10)->lastPage();
        $kqs = Max3DPro::orderBy('date', 'DESC')->take(10)->get();

        // check KQ ngày hôm nay
        $date = date('Y-m-d', time());
        $kq = Max3DPro::where('date', $date)->get();
        if (count($kq) > 0) {
            $kq_today = true;
        } else {
            $kq_today = false;
        }
        return view('frontend.vietlott.max3dpro', compact('kqs','lastPage','kq_today'));
    }

    public function getMax3dProXemThem()
    {
        $kqs = Max3DPro::orderBy('date', 'DESC')->paginate(10);
        $dataReturn = [
            "template" => view('frontend.vietlott.block_max3dpro', compact('kqs'))->render(),
        ];
        return json_encode($dataReturn);
    }


    public function mega645_ajax()
    {
        $date = date('Y-m-d', time());
        $kq_mega645 = Mega645::where('date', $date)->first();
        return view('frontend.vietlott.ajax_mega645', compact('kq_mega645','date'));
    }

    public function power655_ajax()
    {
        $date = date('Y-m-d', time());
        $kq_power655 = Power655::where('date', $date)->first();
        return view('frontend.vietlott.ajax_power655', compact('kq_power655','date'));
    }

    public function max3d_ajax()
    {
        $date = date('Y-m-d', time());
        $kq_max3d = Max3D::where('date', $date)->first();
        return view('frontend.vietlott.ajax_max3d', compact('kq_max3d','date'));
    }

    public function max3dpro_ajax()
    {
        $date = date('Y-m-d', time());
        $kq_max3d_pro = Max3DPro::where('date', $date)->first();
        return view('frontend.vietlott.ajax_max3dpro', compact('kq_max3d_pro','date'));
    }
}
