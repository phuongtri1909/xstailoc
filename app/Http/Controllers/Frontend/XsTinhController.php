<?php


namespace App\Http\Controllers\Frontend;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\Lottery;

use App\Models\Province;

use Cache;


class XsTinhController extends Controller

{

    public function getXsTinh($slug)

    {

        $province = Province::where('slug', $slug)->first();
        if (empty($province)) {
            return view('errors.404');
        }

        if ($province->mien == 1) {

            return $this->getXsmb($province);
        }

        if ($province->mien == 2) {

            return $this->getXsmt($province);
        }

        if ($province->mien == 3) {

            return $this->getXsmn($province);
        }
    }


    // XS miền bắc

    public function getXsmb($province)

    {

        $lastPage = Lottery::where('province_id', $province->id)->where('status', 1)->orderBy('date', 'DESC')->paginate(7)->lastPage();

        $xsmbs = Lottery::where('province_id', $province->id)->where('status', 1)->orderBy('date', 'DESC')->take(7)->get();


        $checkKQMBToday = $this->checkKQMBToDay();


        $name = $province->name;

        $name_kd = chuyenChuoi($province->name);

        $short_name = strtoupper($province->short_name);

        $meta_title = 'XS' . $short_name . ' - SX' . $short_name . ' - Kết Quả Xổ Số ' . $name . ' Hôm Nay';

        $meta_description = 'XS' . $short_name . ' - SX' . $short_name . ' - Kết quả xổ số ' . $name . ' ✅ ' . getListThu($province->ngay_quay) . ' hàng tuần trực tiếp nhanh chóng, chính xác.Xo So ' . $name_kd . ', XS ' . $name . ', xổ số ' . $name . ', XS' . $short_name . ' hom nay';

        $meta_keyword = 'XS' . $short_name . ', SX' . $short_name . ', Xo So ' . $name_kd . ', XS' . $short_name . ' hom nay, Xổ Số ' . $name . ', Kết Quả Xổ Số ' . $name . ', XS ' . $name . ', XS ' . $name . ' hôm nay, ket qua ' . $name_kd;


        return view('frontend.xstinh.xsmb', compact('xsmbs', 'lastPage', 'province', 'checkKQMBToday', 'meta_title', 'meta_description', 'meta_keyword'));
    }


    public function getXsmbXemThem(Request $request)

    {

        $province_id = $request->province_id;

        $xsmbs = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->paginate(7);

        $view = $this->__buildTeamPlateXsmb($xsmbs);

        $dataReturn = [

            "template" => $view->render(),

        ];

        return json_encode($dataReturn);
    }


    private function __buildTeamPlateXsmb($xsmbs)

    {

        return view('frontend.xstinh.block_xsmb', compact('xsmbs'));
    }

    // End miền Bắc


    // XS miền Nam

    public function getXsmn($province)

    {

        $lastPage = Lottery::where('province_id', $province->id)->orderBy('date', 'DESC')->paginate(7)->lastPage();

        $xsmns = Lottery::where('province_id', $province->id)->orderBy('date', 'DESC')->take(7)->get();


        $checkKQMNToday = $this->checkKQMNToDay();


        $name = $province->name;

        $name_kd = chuyenChuoi($province->name);

        $short_name = strtoupper($province->short_name);

        $duoiDesc = '';
        $duoi = ' - Xo so tai loc';
        switch ($short_name) {
            case 'DL':
                $data = [
                    "XSDL - Kết quả xổ số Đà Lạt hôm nay",
                    "KQXS Da Lat - Xổ số Đà Lạt hôm qua",
                    "SXDL - Xổ số đài Đà Lạt ngày",
                    "XS Đà Lạt - Xổ số kiến thiết Đà Lạt",
                    "XSKT Đà Lạt - sổ xố Đà Lạt",
                    "Xổ số Đà Lạt chủ nhật ngày",
                    "Xsdalat - Xổ số miền nam Đà Lạt"
                ];
                $thu = 'chủ nhật';
                $location = 'số 4-6 Hồ Tùng Mậu, phường 3, thành phố Đà Lạt, Lâm Đồng';
                $duoi = ' - XSĐL';
                break;
            case 'TG':
                $data = [
                    "XSTG - Kết quả xổ số Tiền Giang hôm nay",
                    "KQXS Tien Giang - Xổ số Tiền Giang hôm qua",
                    "SXTG - Xổ số đài Tiền Giang ngày",
                    "XS Tiền Giang - Xổ số kiến thiết Tiền Giang",
                    "XSKT Tiền Giang - sổ xố Tiền Giang",
                    "Xổ số Tiền Giang chủ nhật ngày",
                    "XSTGIANG - Xổ số Tiền Giang tài lộc"
                ];
                $thu = 'chủ nhật';
                $location = 'số 5 Thủ Khoa Huân, Phường 1, Thành phố Mỹ Tho, Tiền Giang';

                break;
            case 'KG':
                $data = [
                    "XSKG - Kết quả xổ số Kiên Giang hôm nay",
                    "KQXS Kien Giang - Xổ số Kiên Giang hôm qua",
                    "SXKG - Xổ số đài Kiên Giang ngày",
                    "XS Kiên Giang - Xổ số kiến thiết Kiên Giang",
                    "XSKT Kiên Giang - sổ xố Kiên Giang",
                    "Xổ số Kiên Giang chủ nhật ngày",
                    "XSKGIANG - Xổ số Kiên Giang tài lộc"
                ];
                $thu = 'chủ nhật';
                $location = 'Số 94 Đường 3 Tháng 2, Phường Vĩnh Bảo, TP. Rạch Giá, Kiên Giang';
                break;
            case 'HG':
                $data = [
                    "XSHG - Kết quả xổ số Hậu Giang hôm nay",
                    "KQXS Hau Giang - Xổ số Hậu Giang hôm qua",
                    "SXHG - Xổ số đài Hậu Giang ngày",
                    "XS Hậu Giang - Xổ số kiến thiết Hậu Giang",
                    "XSKT Hậu Giang - sổ xố Hậu Giang",
                    "Xổ số Hậu Giang thứ 7 ngày",
                    "XSHGIANG - Xổ số miền nam Hậu Giang"
                ];
                $thu = 'thứ 7';
                $location =  'Số 151, đường 3 tháng 2, phường 5, TP. Vị Thanh, tỉnh Hậu Giang';
                break;
            case 'BP':
                $data = [
                    "XSBP - Kết quả xổ số Bình Phước hôm nay",
                    "KQXS Binh Phuoc - Xổ số Bình Phước hôm qua",
                    "SXBP - Xổ số đài Bình Phước ngày",
                    "XS Bình Phước - Xổ số kiến thiết Bình Phước",
                    "XSKT Bình Phước - sổ xố Bình Phước",
                    "Xổ số Bình Phước thứ 7 ngày",
                    "Xsbph - Xổ số miền nam Bình Phước"
                ];
                $thu = 'thứ 7';
                $location =  '725 QL 14, phường Tân Bình, TP Đồng Xoài, Bình Phước';
                break;
            case 'LA':
                $data = [
                    "XSLA - Kết quả xổ số Long An hôm nay",
                    "KQXS Long An - Xổ số Long An hôm qua",
                    "SXLA - Xổ số đài Long An ngày",
                    "XS Long An - Xổ số kiến thiết Long An",
                    "XSKT Long An - sổ xố Long An",
                    "Xổ số Long An thứ bảy ngày",
                    "Xslong An - Xổ số Long An tài lộc"
                ];
                $thu = 'thứ 7';
                $location =  'Số 120, Tuyến tránh Quốc lộ 1, khu phố Bình Cư 3, phường 6, thành phố Tân An, tỉnh Long An';
                break;
            case 'TV':

                $data = [
                    "XSTV - Kết quả xổ số Trà Vinh hôm nay",
                    "KQXS Tra Vinh - Xổ số Trà Vinh hôm qua",
                    "SXTV - Xổ số đài Trà Vinh ngày",
                    "XS Trà Vinh - Xổ số kiến thiết Trà Vinh",
                    "XSKT Trà Vinh - sổ xố Trà Vinh",
                    "Xổ số Trà Vinh thứ 6 ngày",
                    "XSTRV - Xổ số miền nam Trà Vinh"
                ];
                $thu = 'thứ 6';
                $location =  '54A Phạm Ngũ Lão, Phường 1, Tp. Trà Vinh, tỉnh Trà Vinh';
                break;
            case 'BD':
                $data = [
                    "XSBD - Kết quả xổ số Bình Dương hôm nay",
                    "KQXS Binh Duong - Xổ số Bình Dương hôm qua",
                    "SXBD - Xổ số đài Bình Dương ngày",
                    "XS Bình Dương - Xổ số kiến thiết Bình Dương",
                    "XSKT Bình Dương - sổ xố Bình Dương",
                    "Xổ số Bình Dương thứ 6 ngày",
                    "XSBDuong - Xổ số miền nam Bình Dương"
                ];
                $thu = 'thứ 6';
                $location =  '01 Huỳnh Văn Nghệ, Phú Lợi, Thủ Dầu Một, Bình Dương';
                break;
            case 'VL':
                $data = [
                    "XSVL - Kết quả xổ số Vĩnh Long hôm nay",
                    "KQXS Vinh Long - Xổ số Vĩnh Long hôm qua",
                    "SXVL - Xổ số đài Vĩnh Long ngày",
                    "XS Vĩnh Long - Xổ số kiến thiết Vĩnh Long",
                    "XSKT Vĩnh Long - sổ xố Vĩnh Long",
                    "Xổ số Vĩnh Long thứ 6 ngày",
                    "XS VL - Xổ số Vĩnh Long tài lộc"
                ];
                $duoiDesc = ' xo so vinh long';
                $thu = 'thứ 6';
                $location =  '51E Nguyễn Trung Trực, phường 8, tp Vĩnh Long';
                break;
            case 'BTH':
                $data = [
                    "XSBTH - Kết quả xổ số Bình Thuận hôm nay",
                    "KQXS Binh Thuan - Xổ số Bình Thuận hôm qua",
                    "SXBTH - Xổ số đài Bình Thuận ngày",
                    "XS Bình Thuận - Xổ số kiến thiết Bình Thuận",
                    "XSKT Bình Thuận - sổ xố Bình Thuận",
                    "Xổ số Bình Thuận thứ 5 ngày",
                    "XSBTHUAN - Xổ số miền nam Bình Thuận"
                ];
                $duoiDesc = ' XSBTHUAN';
                $thu = 'thứ 5';
                $location =  '343 Võ Văn Kiệt, Phường Phú Thủy, TP Phan Thiết, Tỉnh Bình Thuận';
                break;
            case 'TN':
                $data = [
                    "XSTN - Kết quả xổ số Tây Ninh hôm nay",
                    "KQXS Tay Ninh - Xổ số Tây Ninh hôm qua",
                    "SXTN - Xổ số đài Tây Ninh ngày",
                    "XS Tây Ninh - Xổ số kiến thiết Tây Ninh",
                    "XSKT Tây Ninh - sổ xố Tây Ninh",
                    "Xổ số Tây Ninh thứ 5 ngày",
                    "XS TN - Xổ số Tây Ninh tài lộc"
                ];
                $thu = 'thứ 5';
                $location =  '64C Nguyễn Thái Học, phường Mỹ Bình, TP Long Xuyên, Tây Ninh';
                break;
            case 'AG':

                $data = [
                    "XSAG - Kết quả xổ số An Giang hôm nay",
                    "KQXS AG - Xổ số An Giang hôm qua",
                    "SXAG - Xổ số đài An Giang ngày",
                    "XS An Giang - Xổ số kiến thiết An Giang",
                    "XSKT An Giang - sổ xố An Giang",
                    "Xổ số An Giang thứ năm ngày",
                    "Xổ số AG - Xổ số An Giang tài lộc"
                ];
                $thu = 'thứ 5';
                $location =  '64C Nguyễn Thái Học, phường Mỹ Bình, TP Long Xuyên, An Giang';
                break;
            case 'DN':
                $data = [
                    "XSDN - Kết quả xổ số Đồng Nai hôm nay",
                    "KQXS Dong Nai - Xổ số Đồng Nai hôm qua",
                    "SXDN - Xổ số đài Đồng Nai ngày",
                    "XS Đồng Nai - Xổ số kiến thiết Đồng Nai",
                    "XSKT Đồng Nai - sổ xố Đồng Nai",
                    "Xổ số Đồng Nai thứ tư ngày",
                    "XSĐN - Xổ số Đồng Nai tài lộc"
                ];
                $duoi = ' - XSĐN';
                $thu = 'thứ 4';
                $location =  'Số 1894, đường Nguyễn Ái Quốc, khu phố 4, Phường Quang Vinh, Thành phố Biên Hoà, Tỉnh Đồng Nai';
                break;
            case 'ST':
                $data = [
                    "XSST - Kết quả xổ số Sóc Trăng hôm nay",
                    "KQXS Soc Trang - Xổ số Sóc Trăng hôm qua",
                    "SXST - Xổ số đài Sóc Trăng ngày",
                    "XS Sóc Trăng - Xổ số kiến thiết Sóc Trăng",
                    "XSKT Sóc Trăng - sổ xố Sóc Trăng",
                    "Xổ số Sóc Trăng thứ ba ngày",
                    "XSSTR - Xổ số Sóc Trăng tài lộc"
                ];
                $duoi = ' - XSSTR';
                $thu = 'thứ 3';
                $location =  '16 Trần Hưng Đạo, phường 2, thành phố Sóc Trăng';
                break;
            case 'BL':
                $data = [
                    "XSBL - Kết quả xổ số Bạc Liêu hôm nay",
                    "KQXS Bạc Liêu - Xổ số Bạc Liêu hôm qua",
                    "SXBL - Xổ số đài Bạc Liêu ngày",
                    "XS Bạc Liêu - Xổ số kiến thiết Bạc Liêu",
                    "XSKT Bạc Liêu - sổ xố Bạc Liêu",
                    "Xổ số Bạc Liêu thứ ba ngày",
                    "XSBLIEU - Xổ số Bạc Liêu tài lộc"
                ];
                $duoi = ' - XSKT Bac Lieu';
                $thu = 'thứ 3';
                $location =  'Số 9, Phan Ngọc Hiển, Phường 4, Tp Bạc Liêu';
                break;
            case 'BTR':
                $data = [
                    "XSBTR - Kết quả xổ số Bến Tre hôm nay",
                    "KQXS Ben Tre - Xổ số Bến Tre hôm qua",
                    "SXBT - Xổ số đài Bến Tre ngày",
                    "XS Bến Tre - Xổ số kiến thiết Bến Tre",
                    "XSKT Bến Tre - sổ xố Bến Tre",
                    "Kết quả XSBT thứ ba ngày",
                    "XSBTRE - Xổ số miền nam Bến Tre"
                ];
                $duoi = ' - KQXS Ben Tre';
                $thu = 'thứ 3';
                $location =  'Số 9, Phan Ngọc Hiển, Phường 4, Tp Bến Tre';
                break;
            case 'CM':
                $data = [
                    "XSCM - Kết quả xổ số Cà Mau hôm nay",
                    "KQXS Ca Mau - Xổ số Cà Mau hôm qua",
                    "SXCM - Xổ số đài Cà Mau ngày",
                    "XS Cà Mau - Xổ số kiến thiết Cà Mau",
                    "XSKT Cà Mau - sổ xố Cà Mau",
                    "Kết quả XSCM thứ hai ngày",
                    "XSCa Mau - Xổ số miền nam cà mau"
                ];
                $duoi = ' - KQXS Ca Mau';
                $thu = 'thứ 2';
                $location =  'Số 9, Phan Ngọc Hiển, Phường 4, Tp Cà Mau';
                break;
            case 'HCM':
                $data = [
                    "XSHCM - Kết quả xổ số Hồ Chí Minh hôm nay",
                    "KQXSHCM - Xổ số Hồ Chí Minh hôm qua",
                    "SXHCM - Xổ số đài Hồ Chí Minh ngày",
                    "XS Hồ Chí Minh - Xổ số kiến thiết Hồ Chí Minh",
                    "XSKT Hồ Chí Minh - sổ xố Hồ Chí Minh",
                    "Kết quả XSHCM thứ hai ngày",
                    "XSTP - Xổ số miền nam Hồ Chí Minh"
                ];
                $duoi = ' - XSTP';
                $thu = 'thứ 2 và thứ 7';
                $location =  '77 Đ. Trần Nhân Tôn, Phường 9, Quận 5, Hồ Chí Minh';
                break;
            case 'DT':
                $data = [
                    "XSDT - Kết quả xổ số Đồng Tháp hôm nay",
                    "KQXS Dong Thap - Xổ số Đồng Tháp hôm qua",
                    "SXDT - Xổ số đài Đồng Tháp ngày",
                    "XS Đồng Tháp - Xổ số kiến thiết Đồng Tháp",
                    "XSKT Đồng Tháp - sổ xố Đồng Tháp",
                    "Kết quả XSDT thứ hai ngày",
                    "XSĐT - Xổ số Đồng Tháp tài lộc"
                ];

                $duoi = ' - XSĐT';
                $thu = 'thứ 2';
                $location =  'Số 1 Duy Tân, Phường Mỹ Phú, TP. Cao Lãnh, Đồng Tháp';
                break;
            case 'CT':
                $data = [
                    "XSCT - Kết quả xổ số Cần Thơ hôm nay",
                    "KQXSCT - Xổ số Cần Thơ hôm qua",
                    "SXCT - Xổ số đài Cần Thơ ngày",
                    "XS Cần Thơ - Xổ số kiến thiết Cần Thơ",
                    "XSKT Cần Thơ - sổ xố Cần Thơ",
                    "Kết quả XSCT thứ tư ngày",
                    "XSCTHO - Xổ số Cần Thơ tài lộc"
                ];

                $duoi = ' - XSKTCT';
                $thu = 'thứ 4';
                $location =  '29, Cách Mạng Tháng Tám, phường Thới Bình, quận Ninh Kiều, thành phố Cần Thơ';
                break;
            case 'VT':

                $data = [
                    "XSVT - Kết quả xổ số Vũng Tàu hôm nay",
                    "KQXSVT - Xổ số Vũng Tàu hôm qua",
                    "SXVT - Xổ số đài Vũng tàu ngày",
                    "XSBRVT - KQXS Vũng Tàu",
                    "Kết quả xổ số Bà Rịa Vũng Tàu",
                    "Kết quả XS VT thứ 3 ngày",
                    "XSVTAU - Xổ số Vũng Tàu tài lộc"
                ];

                $duoi = ' - XSBRVT';
                $thu = 'thứ 3';
                $location =  '31 Đường 3 Tháng 2, Phường 8, TP. Vũng Tàu, Tỉnh Bà Rịa - Vũng Tàu';
                break;
        }

        $meta_title = 'XS' . $short_name . ' - Kết Quả Xổ Số ' . $name . ' hôm Nay' . ' - SX' . $short_name . $duoi;

        $meta_description = 'KQXD ' . $name . ' - XS' . $short_name . ' - Xổ số ' . $name . ' hôm nay - Trực tiếp kết quả XS' . $short_name . ' lúc 16:15 ' . $thu . ' hàng tuần nhanh nhất và chính xác nhất' . $duoiDesc . '.';

        $meta_keyword = 'XS' . $short_name . ', SX' . $short_name . ', Xo So ' . $name_kd . ', XS' . $short_name . ' hom nay, Xổ Số ' . $name . ', Kết Quả Xổ Số ' . $name . ', XS ' . $name . ', XS ' . $name . ' hôm nay, ket qua ' . $name_kd;

        foreach ($data as $index => $value) {
            $xsmns[$index]->data = $value;
        }
        return view('frontend.xstinh.xsmn', compact('thu', 'location', 'xsmns', 'lastPage', 'province', 'checkKQMNToday', 'meta_title', 'meta_description', 'meta_keyword'));
    }


    public function getXsmnXemThem(Request $request)

    {

        $province_id = $request->province_id;

        $xsmns = Lottery::where('province_id', $province_id)->orderBy('date', 'DESC')->paginate(7);

        $view = $this->__buildTeamPlateXsmn($xsmns);

        $dataReturn = [

            "template" => $view->render(),

        ];

        return json_encode($dataReturn);
    }


    private function __buildTeamPlateXsmn($xsmns)

    {

        return view('frontend.xstinh.block_xsmn', compact('xsmns'));
    }

    // End miền Nam


    // XS miền Trung

    public function getXsmt($province)

    {

        $lastPage = Lottery::where('province_id', $province->id)->orderBy('date', 'DESC')->paginate(7)->lastPage();

        $xsmts = Lottery::where('province_id', $province->id)->orderBy('date', 'DESC')->take(7)->get();


        $checkKQMTToday = $this->checkKQMTToDay();


        $name = $province->name;

        $name_kd = chuyenChuoi($province->name);

        $short_name = strtoupper($province->short_name);

        $duoiDesc = ' ';
        switch ($short_name) {
            case 'QT':
                $data = [
                    "XSQT - Kết quả xổ số Quảng Trị hôm nay",
                    "KQXS quang tri - Xổ số Quảng Trị hôm qua",
                    "SXQT - Xổ số đài Quảng Trị ngày",
                    "XS Quảng Trị - Xổ số kiến thiết Quảng Trị",
                    "XSKT Quảng Trị - So xo Quang Tri",
                    "XSQUANGTRI - Xổ số Quảng Trị thứ năm",
                    "XSQTRI – SX Quảng Trị"
                ];
                $duoiDesc = ' SXQT';
                $duoi = " - XSQT - XSQTRI";
                $thu = 'thứ 5';
                $location = 'Số 02 đường Huyền Trân Công Chúa, Phường 1, Thành phố Đông Hà, Tỉnh Quảng Trị';
                break;
            case 'QB':

                $data = [
                    "XSQB - Kết quả xổ số Quảng Bình hôm nay",
                    "KQXS quang binh - Xổ số Quảng Bình hôm qua",
                    "SXQB - Xổ số đài Quảng Bình ngày",
                    "XS Quảng Bình - Xổ số kiến thiết Quảng Bình",
                    "Xskt Quảng Bình - So xo Quang Binh",
                    "Xsquangbinh - Xổ số Quảng Bình thứ năm",
                    "Xsqbinh – sx Quảng Bình"
                ]; 

                $duoi = " - XSQB - Xsqbinh";
                $thu = 'thứ 5';
                $location = '08B Hương Giang, Phường Đồng Hải, Thành phố Đồng Hới, Tỉnh Quảng Bình';
                break;
            case 'BDI':
                $data = [
                    "XSBDI - Kết quả xổ số Bình Định hôm nay",
                    "KQXS Bình Định - Xổ số Bình Định hôm qua",
                    "SXBDI - Xổ số đài Bình Định ngày",
                    "XS Bình Định - Xổ số kiến thiết Bình Định",
                    "Xskt Bình Định - So xo Binh Dinh",
                    "Xsbdinh - Xổ số Bình Định thứ năm",
                    "Xsbinh dinh – sx Bình Định"
                ];

                $duoi = " - SXBDI - XSBDINH";
                $thu = 'thứ 5';
                $location = '304 Phan Bội Châu, Trần Hưng Đạo, Thành phố Qui Nhơn, Bình Định';
                break;
            case 'DNA':

                $data = [
                    "XSDNA - Kết quả xổ số Đà Nẵng hôm nay",
                    "KQXS Da Nang - Xổ số Đà Nẵng hôm qua",
                    "XSDNG - Xổ số đài Đà Nẵng ngày",
                    "Xs Đà Nẵng - Xổ số kiến thiết Đà Nẵng",
                    "Xskt Đà Nẵng - So xo Da Nang",
                    "Xsdnang - Xổ số Đà Nẵng thứ bảy",
                    "Xsda nang - kết quả Đà Nẵng"
                ];

                $duoi = " - XSDNG - XS Da Nang ";

                $thu = 'thứ 7';
                $location =  '308 Đ. 2 Tháng 9, Hoà Cường Bắc, Hải Châu, Đà Nẵng';
                break;
            case 'KH':
                $data = [
                    "XSKH - Kết quả xổ số Khánh Hoà hôm nay",
                    "KQXS Khanh Hoa - Xổ số Khánh Hoà hôm qua",
                    "SXKH - Xổ số đài Khánh Hoà ngày",
                    "Xs Khánh Hoà - Xổ số kiến thiết Khánh Hoà",
                    "Xskt Khánh Hoà - So xo khanh hoa",
                    "Xổ số Khánh Hoà thứ tư",
                    "Xskhanhoa – xo so khanh hoa"
                ];
                
                $duoi = " - XS Khanh Hoa";
                $thu = 'thứ 4 và chủ nhật';
                $location =  '03 Pasteur, Xương Huân, Nha Trang, Khánh Hòa';
                break;
            case 'QNA':
                $data = [
                    "XSQNA - Kết quả xổ số Quảng Nam hôm nay",
                    "KQXS Quang Nam - Xổ số Quảng Nam hôm qua",
                    "SXQNA - Xổ số đài Quảng Nam ngày",
                    "Xsqnm - Xổ số kiến thiết Quảng Nam",
                    "Xskt Quảng Nam - So xo quang nam",
                    "XS Quang Nam - xs qnm",
                    "Xsqnam - xs quang nam"
                ];
                $duoiDesc = 'xsqnam';
                $duoi = " - XSQNM";
                $thu = 'thứ 3';
                $location =  '04 Trần Phú, Phường Tân Thạnh, Thành phố Tam Kỳ, Tỉnh Quảng Nam';
                break;
            case 'DLK':
                $data = [
                    "XSDLK - Kết quả xổ số Đắk Lắk hôm nay",
                    "KQXS daklak - Xổ số Đắk Lắk hôm qua",
                    "SXDLK - Xổ số đài Đắk Lắk ngày",
                    "XS Dak Lak - Xổ số kiến thiết Đắk Lắk",
                    "Xo so daklak - So xo dak lak",
                    "Xsdlak - Xổ số Đắc Lắc"
                ];
                $duoi = " - SXDLK - xs daklak";
                $thu = 'thứ 3';
                $location =  'Số 02 Đinh Tiên Hoàng, phường Tự An, thành phố Buôn Ma Thuột, tỉnh Đắk Lắk';
                break;
            case 'PY':
                $data = [
                    "XSPY - Kết quả xổ số Phú Yên hôm nay",
                    "KQXS Phu Yen - Xổ số Phú Yên hôm qua",
                    "SXPY - Xổ số đài Phú Yên ngày",
                    "XS Phú Yên - Xổ số kiến thiết Phú Yên",
                    "XSKT Phú Yên - sổ xố Phú Yên",
                    "Xổ số Phú Yên thứ hai ngày",
                    "Xsphu yen - xo so phu yen"
                ];

                $duoi = " - SXPY - Xo so tai loc";
                $thu = 'thứ 2';
                $location =  '204 Trần Hưng Đạo, Phường 4, Tuy Hòa, Phú Yên';
                break;
            case 'TTH':

                $data = [
                    "XSTTH - Kết quả xổ số Thừa Thiên Huế hôm nay",
                    "KQXS Hue - Xổ số Thừa Thiên Huế hôm qua",
                    "SXTTH - Xổ số đài Huế ngày",
                    "XS Hue - Xổ số kiến thiết Thừa Thiên Huế",
                    "XSKT Thừa Thiên Huế - so xo thua thien hue",
                    "Kết quả xổ số Huế",
                    "Xstthue - Xổ số miền trung Thừa Thiên Huế"
                ];

                $duoiDesc = 'xổ số Huế';
                $duoi = " - Xổ số Huế";
                $thu = 'thứ 2 và chủ nhật';
                $location =  'Lô SN1, đường Hoàng Quốc Việt, xã Thủy Thanh, thị xã Hương Thủy, tỉnh Thừa Thiên Huế';
                break;
            case 'KT':

                $data = [
                    "XSKT - Kết quả xổ số Kon Tum hôm nay",
                    "KQXS Kon Tum - Xổ số Kon Tum hôm qua",
                    "SXKT - Xổ số đài Kon Tum ngày",
                    "XS Kon Tum - Xổ số kiến thiết Kon Tum",
                    "XSKT Kon Tum - So xo Kon Tum",
                    "Xổ số Kon Tum chủ nhật",
                    "XSKTUM - SX Kon Tum"
                ];

                $duoiDesc = 'SXKT';
                $duoi = " - SXKT - XSKT";
                $thu = 'chủ nhật';
                $location =  '198 Bà Triệu, Quang Trung, Kon Tum';
                break;
            case 'DNO':

                $data = [
                    "XSDNO - Kết quả xổ số Đắk Nông hôm nay",
                    "KQXS Dak Nong - Xổ số Đắk Nông hôm qua",
                    "SX Đak Nong - Xổ số đài Đắk Nông ngày",
                    "XS Đắc Nông - Xổ số kiến thiết Đắk Nông",
                    "XSKT Đắk Nông - So xo Dac Nong",
                    "XS Dac Nong - Xổ số Đăk Nông thứ bảy",
                    "XS DAKNONG - SX Đắk Nông"
                ];
                $duoiDesc = 'xs đắc nông';
                $duoi = " – XS DAKNONG";
                $thu = 'thứ 7';
                $location =  'số nhà 88 đường 23/3, phường Nghĩa Đức, thành phố Gia Nghĩa, tỉnh Đắk Nông';
                break;
            case 'QNG':
                $data = [
                    "XSQNG - Kết quả xổ số Quảng Ngãi hôm nay",
                    "KQXS Quang Ngai - Xổ số Quảng Ngãi hôm qua",
                    "SXQNG - Xổ số đài Quảng Ngãi ngày",
                    "XS Quảng Ngãi - Xổ số kiến thiết Quảng Ngãi",
                    "XSKT Quảng Ngãi - So xo Quang Ngai",
                    "XSQNGH - Xổ số Quảng Ngãi thứ bảy ",
                    "XSQNGAI - SX Quảng Ngãi"
                ];
                $duoiDesc = 'SXQNG';
                $duoi = " - SXQNG - XSQNGAI";
                $thu = 'thứ 7';
                $location =  'Số 04 Đ. Trương Quang Giao, Nghĩa Chánh Bắc, Quảng Ngãi';
                break;
            case 'GL':
                $data = [
                    "XSGL - Kết quả xổ số Gia Lai hôm nay",
                    "KQXS Gia Lai - Xổ số Gia Lai hôm qua",
                    "SXGL - Xổ số đài Gia Lai ngày",
                    "XS Gia Lai - Xổ số kiến thiết Gia Lai",
                    "XSKT Gia Lai - So xo Gia Lai",
                    "XSGIALAI - Xổ số Gia Lai thứ sáu",
                    "XSGLAI - SX Gia Lai"
                ];
                $duoiDesc = 'SXGL';
                $duoi = " - SXGL - XSGLAI";
                $thu = 'thứ 6';
                $location =  '60 Trần Phú (nối dài), Phường Tây Sơn, Thành phố Pleiku, Tỉnh Gia Lai';
                break;
            case 'NT':
                $data = [
                    "XSNT - Kết quả xổ số Ninh Thuận hôm nay",
                    "KQXS Ninh Thuan - Xổ số Ninh Thuận hôm qua",
                    "SXNT - Xổ số đài Ninh Thuận ngày",
                    "XS Ninh Thuận - Xổ số kiến thiết Ninh Thuận",
                    "XSKT Ninh Thuận - So xo Ninh Thuan",
                    "XSNTH - Xổ số Ninh Thuận thứ sáu",
                    "XSNTHUAN - SX Ninh Thuận"
                ];
                $duoiDesc = 'SXNT';
                $duoi = " - SXNT - XSNTHUAN";
                $thu = 'thứ 6';
                $location =  'Số 32 Đường 16 tháng 4, Phường Kinh Dinh, TP. Phan Rang - Tháp Chàm, Tỉnh Ninh Thuận';
                break;
        }


        $meta_title = 'XS' . $name . ' Kết quả xổ số ' . $name . ' hôm nay' . $duoi;

        $meta_description = 'XS ' . $short_name . ' - XS' . $short_name . ' - Xổ số ' . $name . ' hôm nay - Trực tiếp kết quả XS' . $short_name . ' lúc 17:15 ' . $thu . ' hàng tuần nhanh nhất và chính xác nhất' .$duoiDesc.'.';
        $meta_keyword = 'XS' . $short_name . ', SX' . $short_name . ', Xo So ' . $name_kd . ', XS' . $short_name . ' hom nay, Xổ Số ' . $name . ', Kết Quả Xổ Số ' . $name . ', XS ' . $name . ', XS ' . $name . ' hôm nay, ket qua ' . $name_kd;

        foreach ($data as $index => $value) {
            $xsmts[$index]->data = $value;
        }
        return view('frontend.xstinh.xsmt', compact('thu', 'location', 'xsmts', 'lastPage', 'province', 'checkKQMTToday', 'meta_title', 'meta_description', 'meta_keyword'));
    }


    public function getXsmtXemThem(Request $request)

    {

        $province_id = $request->province_id;

        $xsmts = Lottery::where('province_id', $province_id)->orderBy('date', 'DESC')->paginate(7);

        $view = $this->__buildTeamPlateXsmt($xsmts);

        $dataReturn = [

            "template" => $view->render(),

        ];

        return json_encode($dataReturn);
    }


    private function __buildTeamPlateXsmt($xsmts)

    {

        return view('frontend.xstinh.block_xsmt', compact('xsmts'));
    }

    // End miền Trung


    public function getXsTinhTheoNgay($short_name, $date)

    {

        $date_2 = str_replace('-', '/', $date);

        $date = getNgayLink($date);

        $province = Province::where('short_name', $short_name)->first();
        if (empty($province)) return view('errors.404');

        $xs_name = 'XS' . strtoupper($short_name);

        $xs_name_2 = 'SX' . strtoupper($short_name);

        $name = $province->name;

        $meta_title = $xs_name . ' ' . $date_2 . ' - Xổ số ' . $name . ' ngày ' . $date_2 . ' - ' . $xs_name_2 . ' ' . $date_2;

        $meta_description = $meta_title . ' - Kết quả Xổ số ' . $name . ' ngày ' . $date_2 . '. Tường thuật kết quả Xổ số ' . $name . ' từ trường quay nhanh, chính xác nhất';

        $meta_keyword = $xs_name . ' ' . $date_2 . ', Xổ số ' . $name . ' ngày ' . $date_2 . ', ' . $xs_name_2 . ' ' . $date_2 . ',' . $xs_name . ',' . $xs_name_2;


        if ($province->mien == 3) {

            $xsmn = Lottery::where('province_id', $province->id)->where('date', $date)->orderBy('date', 'DESC')->first();

            return view('frontend.xstinh.xsmn_date', compact('xsmn', 'province', 'meta_title', 'meta_description', 'meta_keyword', 'date_2', 'date'));


            //            return $this->getXsMNTheoNgay($kqxs,$province,$meta_title,$meta_description,$meta_keyword);

        }

        if ($province->mien == 2) {

            $xsmt = Lottery::where('province_id', $province->id)->where('date', $date)->orderBy('date', 'DESC')->first();

            return view('frontend.xstinh.xsmt_date', compact('xsmt', 'province', 'meta_title', 'meta_description', 'meta_keyword', 'date_2', 'date'));


            //            return $this->getXsMTTheoNgay($kqxs,$province,$meta_title,$meta_description,$meta_keyword);

        }

        if ($province->mien == 1) {

            $xsmb = Lottery::where('province_id', $province->id)->where('date', $date)->orderBy('date', 'DESC')->first();

            return view('frontend.xstinh.xsmb_date', compact('xsmb', 'province', 'meta_title', 'meta_description', 'meta_keyword', 'date_2', 'date'));


            //            return $this->getXsMTTheoNgay($kqxs,$province,$meta_title,$meta_description,$meta_keyword);

        }
    }


    public function getXsMNTheoNgay($xsmn, $province, $meta_title, $meta_description, $meta_keyword)

    {

        return view('frontend.xstinh.xsmn_date', compact('xsmn', 'province', 'meta_title', 'meta_description', 'meta_keyword'));
    }

    public function getXsMTTheoNgay($xsmt, $province, $meta_title, $meta_description, $meta_keyword)

    {

        return view('frontend.xstinh.xsmt_date', compact('xsmt', 'province', 'meta_title', 'meta_description', 'meta_keyword'));
    }


    public function checkKQMBToDay()

    {

        $date = date('Y-m-d', time());

        $xsmb = Lottery::where('mien', 1)->where('date', $date)->get();

        if (count($xsmb) > 0) {

            return true;
        } else {

            return false;
        }
    }


    public function checkKQMNToDay()

    {

        $date = date('Y-m-d', time());

        $xsmns = Lottery::where('mien', 3)->where('date', $date)->get();

        if (count($xsmns) > 0) {

            return true;
        } else {

            return false;
        }
    }


    public function checkKQMTToDay()

    {

        $date = date('Y-m-d', time());

        $xsmns = Lottery::where('mien', 2)->where('date', $date)->get();

        if (count($xsmns) > 0) {

            return true;
        } else {

            return false;
        }
    }
}
