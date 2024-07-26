<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Max3D;
use App\Models\Max3DPro;
use App\Models\Power655;
use App\Models\Mega645;

class EmbedVietlottController extends Controller
{
    public function mega645(Request $request)
    {
        $kq_mega645 = Mega645::orderBy('date', 'DESC')->first();
        return view('frontend.embed_vietlott.mega645', compact('kq_mega645'));
    }

    public function mega645_Date($date)
    {
        $kq_mega645 = Mega645::orderBy('date', 'DESC')->where('date', getNgayLink($date))->first();
        if (empty($kq_mega645)) {
            $date = getNgayLink($date);
//            return view('frontend.embed_vietlott.mega645_nokq', compact('date'));
        }
        return view('frontend.embed_vietlott.mega645', compact('kq_mega645','date'));
    }


    public function power655(Request $request)
    {
        $kq_power655 = Power655::orderBy('date', 'DESC')->first();
        return view('frontend.embed_vietlott.power655', compact('kq_power655'));
    }

    public function power655_Date($date)
    {
        $kq_power655 = Power655::orderBy('date', 'DESC')->where('date', getNgayLink($date))->first();
        if (empty($kq_power655)) {
            $date = getNgayLink($date);
//            return view('frontend.embed_vietlott.power655_nokq', compact('date'));
        }
        return view('frontend.embed_vietlott.power655', compact('kq_power655','date'));
    }
}
