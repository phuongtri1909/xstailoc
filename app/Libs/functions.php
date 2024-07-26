<?php
//date('d-m-Y', strtotime("-1 days"));
//date('Y-m-d', strtotime(getNgayLink('2023-11-03') . ' +1 days'));
//date('Y-m-d', strtotime('03-12-2023 +1 days'));
function solan_xuathien_trongngay($number, $vars)
{
    $total = 0;
    foreach ($vars as $value) {
        if ($number == $value) {
            $total++;
        }
    }
//    $tmp = "";
//    if($number == $vars[0])	{
//        $tmp = "<font color=red><b>".$total."</b></font>";
//    }
//    if($total == 0){
//        $tmp = "&nbsp;" ;
//    }
//    if($number != $vars[0] && $total != 0)
//    {
//        $tmp = (string)$total;
//    }
    return $total;
}

function giatri_xuathien($chuoigoc)
{
    $arr_chuoi = array("1", "2", "3", "4", "5", "6", "7", "8", "9");
    $tmp = "";
    $chuoigoc = "ABCDEF" . $chuoigoc;
    foreach ($arr_chuoi as $value) {
        $find = strpos($chuoigoc, $value);
        //echo $find;
        if ($find >= 0 && !empty($find)) {
            $tmp = $value;
            break;

        } else {
            $tmp = "";
        }
    }
    return $tmp;
}

function tach_ngay_thang($value)
{
    $arrTmp = explode('-', $value);
    return $arrTmp[2] . "<br/>" . $arrTmp[1];
}
function ngay_thang_ts($value)
{
    $arrTmp = explode('-', $value);
    return "$arrTmp[2] <br/> - <br/> $arrTmp[1]";
}
function ngay_thang($value)
{
    $arrTmp = explode('-', $value);
    return '<div>'.$arrTmp[2].'</div><div>-</div><div>'.$arrTmp[1].'</div>';
}

function getLinkLoToTheoThu($day)
{
    if ($day == 8) {
        $thu = 'chu-nhat';
    } else {
        $thu = 'thu-' . $day;
    }
    return $thu;
}

function getRouteDay($day, $xsmien)
{
    if ($day == 8) {
        $routeDay = $xsmien . '.cn';
    } else {
        $routeDay = $xsmien . '.thu_' . $day;
    }
    return $routeDay;
}

function swap(&$x, &$y)
{
    $tmp = null;
    $tmp = $x;
    $x = $y;
    $y = $tmp;
}


function themDauCach($x)
{
    $x = str_replace('-', ' - ', $x);
    return $x;
}

function getLoto($str)
{
    $ArrayResult = explode('-', $str);
    $len_array = count($ArrayResult);
    for ($j = 0; $j < $len_array; $j++) {
        if (!empty($ArrayResult[$j])) {
            $ArrayResult[$j] = trim($ArrayResult[$j]);
            $Result[] = substr($ArrayResult[$j], strlen($ArrayResult[$j]) - 2, 2);
        }
    }
    return $Result;
}

function getLoto3Cang($str)
{
    $ArrayResult = explode('-', $str);
    $len_array = count($ArrayResult);
    for ($j = 0; $j < $len_array; $j++) {
        if (!empty($ArrayResult[$j])) {
            $ArrayResult[$j] = trim($ArrayResult[$j]);
            $Result[] = substr($ArrayResult[$j], strlen($ArrayResult[$j]) - 3);
        }
    }
    return $Result;
}


function getDauInvedo($arrLoto)
{
    $arrDau = array();
    for ($i = 0; $i < 10; $i++) {
        $strTmp = '';
        foreach ($arrLoto as $value) {
            if ($value != '..') {
                if (substr($value, 0, 1) == $i) {
                    $strTmp .= substr($value, 1, 1) . ', ';
                }
            }
        }
        if (!empty($strTmp)) {
            $strTmp = substr($strTmp, 0, strlen($strTmp) - 2);
        } else {
            $strTmp = '-';
        }
//        if (strlen($strTmp) > 1) {
//            $strTmp = substr($strTmp, 0, strlen($strTmp) - 2);
//        }
        $arrDau[$i] = $strTmp;
    }
    return $arrDau;
}

function getDau($arrLoto,$gdb)
{
    sort($arrLoto);
    $arrDau = array();
    for ($i = 0; $i < 10; $i++) {
        $strTmp = '';
        foreach ($arrLoto as $value) {
            if ($value != '..') {
                if (substr($value, 0, 1) == $i) {
                    if($value==$gdb){
                        $vl = '<span class="clnote">'.$value.'</span>';
                    }else{
                        $vl = $value;
                    }
                    $strTmp .= $vl . ', ';
                }
            }
        }
        if (!empty($strTmp)) {
            $strTmp = substr($strTmp, 0, strlen($strTmp) - 2);
        } else {
            $strTmp = '';
        }
//        if (strlen($strTmp) > 1) {
//            $strTmp = substr($strTmp, 0, strlen($strTmp) - 2);
//        }
        $arrDau[$i] = $strTmp;
    }
    return $arrDau;
}

function getDuoi($arrLoto,$gdb)
{
    sort($arrLoto);
    $arrDuoi = array();
    for ($i = 0; $i < 10; $i++) {
        $strTmp = '';
        foreach ($arrLoto as $value) {
            if ($value != '..') {
                if (substr($value, 1, 1) == $i) {
                    if($value==$gdb){
                        $vl = '<span class="clnote">'.$value.'</span>';
                    }else{
                        $vl = $value;
                    }
                    $strTmp .= $vl . ', ';
                }
            }
        }
        if (!empty($strTmp)) {
            $strTmp = substr($strTmp, 0, strlen($strTmp) - 2);
        } else {
            $strTmp = '';
        }
//        if (strlen($strTmp) > 1) {
//            $strTmp = substr($strTmp, 0, strlen($strTmp) - 2);
//        }
        $arrDuoi[$i] = $strTmp;
    }
    return $arrDuoi;
}

function getDau1so($arrLoto)
{
    sort($arrLoto);
    $arrDau = array();
    for ($i = 0; $i < 10; $i++) {
        $strTmp = '';
        foreach ($arrLoto as $value) {
            if ($value != '..') {
                if (substr($value, 0, 1) == $i) {
                    $strTmp .= substr($value, 1, 1) . ',';
                }
            }
        }
        if (!empty($strTmp)) {
            $strTmp = substr($strTmp, 0, strlen($strTmp) - 1);
        } else {
            $strTmp = '-';
        }
//        if (strlen($strTmp) > 1) {
//            $strTmp = substr($strTmp, 0, strlen($strTmp) - 2);
//        }
        $arrDau[$i] = $strTmp;
    }
    return $arrDau;
}

function getDauLive($arrLoto)
{
    sort($arrLoto);
    $arrDau = array();
    for ($i = 0; $i < 10; $i++) {
        $strTmp = '';
        foreach ($arrLoto as $value) {
            if ($value != '..') {
                if (substr($value, 0, 1) == $i) {
                    $strTmp .= $value . ', ';
                }
            }
        }
        if (!empty($strTmp)) {
            $strTmp = substr($strTmp, 0, strlen($strTmp) - 2);
        } else {
            $strTmp = '-';
        }
        $arrDau[$i] = $strTmp;
    }
    return $arrDau;
}
function getDuoiLive($arrLoto)
{
    sort($arrLoto);
    $arrDau = array();
    for ($i = 0; $i < 10; $i++) {
        $strTmp = '';
        foreach ($arrLoto as $value) {
            if ($value != '..') {
                if (substr($value, 1, 1) == $i) {
                    $strTmp .= $value . ', ';
                }
            }
        }
        if (!empty($strTmp)) {
            $strTmp = substr($strTmp, 0, strlen($strTmp) - 2);
        } else {
            $strTmp = '-';
        }
        $arrDau[$i] = $strTmp;
    }
    return $arrDau;
}

function getStrtoArray($str)
{
    $arrstr = '';
    for($i=0;$i<strlen($str);$i++){
        $arrstr .= "'" . $str[$i] . "',";
    }
    return substr($arrstr, 0, -1);
}

function getNgayID($date)
{
    $arrDate = explode('-', $date);
    return $arrDate[2] . '' . $arrDate[1] . '' . $arrDate[0];
}

function getNgaycheo($date)
{
    $arrDate = explode('/', $date);
    return $arrDate[2] . '-' . $arrDate[1] . '-' . $arrDate[0];
}
function getDateLienNhau($date)
{
    $arrDate = explode('-', $date);
    return $arrDate[2]. $arrDate[1]. $arrDate[0];
}
function getNgayLink($date)
{
    $arrDate = explode('-', $date);
    return $arrDate[2] . '-' . $arrDate[1] . '-' . $arrDate[0];
}

function getNgayThang($date)
{
    $arrDate = explode('-', $date);
    return $arrDate[2] . '/' . $arrDate[1];
}

function getNgayThang1($date)
{
    $arrDate = explode('/', $date);
    return $arrDate[0] . '/' . intval($arrDate[1]);
}

function getThangNam($date)
{
    $arrDate = explode('-', $date);
    return $arrDate[1] . '/' . $arrDate[0];
}
function getNgayThangNgang($date)
{
    $arrDate = explode('-', $date);
    return $arrDate[2] . '-' . $arrDate[1];
}

function getNgay1($date)
{
    $arrDate = explode('/', $date);
    return $arrDate[0];
}

function getNgay($date)
{
    $arrDate = explode('-', $date);
    return $arrDate[2] . '/' . intval($arrDate[1]) . '/' . $arrDate[0];
}

function getNgay_Emb($date)
{
    $arrDate = explode('-', $date);
    if($arrDate[2] < 10) $arrDate[2] = substr($arrDate[2],1);
    if($arrDate[1] < 10) $arrDate[1] = substr($arrDate[1],1);
    return $arrDate[2] . '/' . $arrDate[1] . '/' . $arrDate[0];
}

function getNgay_Emb1($date)
{
    $arrDate = explode('-', $date);
    if($arrDate[2] < 10) $arrDate[2] = substr($arrDate[2],1);
    if($arrDate[1] < 10) $arrDate[1] = substr($arrDate[1],1);
    return $arrDate[2] . '-' . $arrDate[1] . '-' . $arrDate[0];
}

function getNgayThangNam2So($date)
{
    $arrDate = explode('-', $date);
    return $arrDate[2] . '/' . $arrDate[1] . '/' . substr($arrDate[0],2);
}

function getNam($date)
{
    $arrDate = explode('-', $date);
    return $arrDate[0];
}
function cal_tso_jd($d, $m, $day,$y)
{ return true; }

function getThuNumber($date)
{
    $arr = explode('-', $date);
    $ngay = $arr[2];
    $thang = $arr[1];
    $nam = $arr[0];
    $jd = cal_to_jd(CAL_GREGORIAN, $thang, $ngay, $nam);
    $day = jddayofweek($jd, 0);
    switch ($day) {
        case 0:
            $thu = 8;
            break;
        case 1:
            $thu = 2;
            break;
        case 2:
            $thu = 3;
            break;
        case 3:
            $thu = 4;
            break;
        case 4:
            $thu = 5;
            break;
        case 5:
            $thu = 6;
            break;
        case 6:
            $thu = 7;
            break;
    }
    return $thu;
}

function getThuNow()
{
    $date = date('Y-m-d', time());
    $arr = explode('-', $date);
    $ngay = $arr[2];
    $thang = $arr[1];
    $nam = $arr[0];
    $jd = cal_to_jd(CAL_GREGORIAN, $thang, $ngay, $nam);
    $day = jddayofweek($jd, 0);
    switch ($day) {
        case 0:
            return 'Chủ Nhật';
            break;
        case 1:
            return 'Thứ 2';
            break;
        case 2:
            return 'Thứ 3';
            break;
        case 3:
            return 'Thứ 4';
            break;
        case 4:
            return 'Thứ 5';
            break;
        case 5:
            return 'Thứ 6';
            break;
        case 6:
            return 'Thứ 7';
            break;
    }
}

function getListThu($listDay)
{
    $arrDay = explode(',', $listDay);
    $thu = '';
    foreach ($arrDay as $value) {
        if ($thu == '')
            $thu = getThu($value);
        else
            $thu = $thu . ',' . getThu($value);
    }
    return $thu;
}

function getThu($day)
{
    switch ($day) {
        case 2:
            return 'Thứ 2';
            break;
        case 3:
            return 'Thứ 3';
            break;
        case 4:
            return 'Thứ 4';
            break;
        case 5:
            return 'Thứ 5';
            break;
        case 6:
            return 'Thứ 6';
            break;
        case 7:
            return 'Thứ 7';
            break;
        case 8:
            return 'Chủ Nhật';
            break;
    }
}

function getThuChu($day)
{
    switch ($day) {
        case 2:
            return 'thứ hai';
            break;
        case 3:
            return 'thứ ba';
            break;
        case 4:
            return 'thứ tư';
            break;
        case 5:
            return 'thứ năm';
            break;
        case 6:
            return 'thứ sáu';
            break;
        case 7:
            return 'thứ bảy';
            break;
        case 8:
            return 'chủ nhật';
            break;
    }
}

function getNumberRandKhoang($a,$b)
{
    $number = rand($a, $b);
    if ($number < 10) {
        $number = '0' . $number;
    }
    return $number;
}

function getNumberRand1()
{
    $number = rand(00, 10);
    if ($number < 10) {
        $number = '0' . $number;
    }
    return $number;
}

function getDauDuoiRand()
{
    $number = rand(0, 9);
    return $number;
}

function getSongThuNumberRandNew()
{
    $number = rand(00, 99);
    if ($number < 10) {
        $number = '0' . $number;
    }
    while (substr($number, 0, 1) == substr($number, 1, 1)) {
        $number = rand(00, 99);
        if ($number < 10) {
            $number = '0' . $number;
        }
    }
    return $number.','.lon($number);
}

function getSongThuNumberRand()
{
    $number = rand(00, 99);
    if ($number < 10) {
        $number = '0' . $number;
    }
    while (substr($number, 0, 1) == substr($number, 1, 1)) {
        $number = rand(00, 99);
        if ($number < 10) {
            $number = '0' . $number;
        }
    }
    return $number.' - '.lon($number);
}

function getCapNumberRand()
{
    $number = rand(00, 99);
    if ($number < 10) {
        $number = '0' . $number;
    }
    return $number.','.lon($number);
}

function getNumberRand()
{
    $number = rand(00, 99);
    if ($number < 10) {
        $number = '0' . $number;
    }
    return $number;
}

function get3NumberRand()
{
    $number = rand(000, 999);
    if ($number < 10) {
        $number = '00' . $number;
    }
    if ($number < 100 && $number >= 10) {
        $number = '0' . $number;
    }
    return $number;
}

function getLoKepRand()
{
    $arr_number = array('00','11','22','33','44','55','66','77','88','99');
    $random_keys=array_rand($arr_number);
    return $arr_number[$random_keys];
}

function trim_value(&$value)
{
    $value = trim($value);
}

function print_ok($arr)
{
    echo "<pre>" . print_r($arr, true) . "</pre>";
}

function lon($x)
{
    if(substr($x, 1, 1) != substr($x, 0, 1)){
        return substr($x, 1, 1) . substr($x, 0, 1);
    }else{
        if($x=='00') return '55';
        if($x=='11') return '66';
        if($x=='22') return '77';
        if($x=='33') return '88';
        if($x=='44') return '99';
        if($x=='55') return '00';
        if($x=='66') return '11';
        if($x=='77') return '22';
        if($x=='88') return '33';
        if($x=='99') return '44';
    }

}
function ChanLe($x)
{
    if ($x%2==0) {
        return 'C';
    } else return 'L';
}

function Tong($x)
{
    if (strlen($x) == 2) {
        $kq = intval(substr($x, 1, 1)) + intval(substr($x, 0, 1));
        
        if ($kq >= 10) {
            return intval(substr($kq, 1, 1));
        } else {
            return $kq;
        }
    } else {
        return '';
    }
}


function Cham($x, $ok)
{
    if (substr($x, 1, 1) == $ok || substr($x, 0, 1) == $ok) return true;
    else return false;
}

function save_image($inPath, $outPath)
{ //Download images from remote server
    try {
        $in = fopen($inPath, "rb");
        $out = fopen($outPath, "wb");
        while ($chunk = fread($in, 8192)) {
            fwrite($out, $chunk, 8192);
        }
        fclose($in);
        fclose($out);
    } catch (Exception $e) {
    }
}

function grab_image($url, $saveto)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
    $raw = curl_exec($ch);
    curl_close($ch);
    if (file_exists($saveto)) {
        unlink($saveto);
    }
    $fp = fopen($saveto, 'w');
    fwrite($fp, $raw);
    fclose($fp);
}

function requestvl($url, $post = "", $follow = 1, $header = 0, $refer = '')
{
    global $curlstatus;
    $ch = curl_init();
    if (isset($_SERVER['HTTP_USER_AGENT']))
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//    curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie_path);
//    curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_path);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_HEADER, $header);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $follow);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_REFERER, $refer);
    curl_setopt($ch, CURLOPT_AUTOREFERER, false);
//		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    if ($post) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    $returned = curl_exec($ch);
    $curlstatus = curl_getinfo($ch);
    curl_close($ch);

    return $returned;
}

function chuyenChuoi($str)
{
// In thường
    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
    $str = preg_replace("/(đ)/", 'd', $str);
// In đậm
    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
    $str = preg_replace("/(Đ)/", 'D', $str);
    return $str; // Trả về chuỗi đã chuyển
}

function chanetitle($str)
{
    $str = trim($str);
    if ($str == "") return "";
    $str = preg_replace('/\s+/', ' ', $str);;
    $str = str_replace('”', '', $str);
    $str = str_replace('"', '', $str);
    $str = str_replace('“', '', $str);
    $str = str_replace("'", '', $str);
    $str = str_replace("?", '', $str);
    $str = str_replace("!", '', $str);
    $str = str_replace("%", '', $str);
    $str = str_replace(",", ' ', $str);
    $str = str_replace(".", '', $str);
    $str = str_replace("/", ' ', $str);
    $str = str_replace(":", ' ', $str);
    $str = str_replace("@", ' ', $str);
    $str = str_replace("#", '', $str);
    $str = str_replace("$", '', $str);
    $str = str_replace("&", ' ', $str);
    $str = str_replace("*", '', $str);
    $str = str_replace("(", '', $str);
    $str = str_replace(")", '', $str);
    $str = str_replace("=", ' ', $str);
    $str = str_replace("+", ' ', $str);
    $str = str_replace("{", '', $str);
    $str = str_replace("}", '', $str);
    $str = str_replace("[", '', $str);
    $str = str_replace("]", '', $str);
    $str = str_replace("|", '', $str);
    $str = str_replace("^", '', $str);
    $str = str_replace("̃", '', $str);
    $str = str_replace("́", '', $str);
    $str = str_replace("̀", '', $str);
    $str = str_replace("̉", '', $str);
    $str = str_replace("̣", '', $str);
    $str = str_replace(".", '', $str);
    $str = str_replace("~", '', $str);
    $str = str_replace("_", '', $str);
    $str = str_replace("`", '', $str);
    $str = str_replace(";", '', $str);
    $str = str_replace("<", '', $str);
    $str = str_replace(">", '', $str);
    $str = str_replace("★", '', $str);
    $str = str_replace("–", '', $str);
    $ok = ' \ ';
    $str = str_replace(trim($ok), '', $str);
    $str = trim($str);
    $str = chuyenChuoi($str);
    $str = mb_convert_case($str, MB_CASE_LOWER, 'utf-8');
    $str = str_replace(' ', '-', $str);
    $str = str_replace('amp;', '-', $str);
    $str = str_replace('---', '-', $str);
    $str = str_replace('--', '-', $str);
    return $str;
}

function limitWord($str, $limit)
{
    $str = trim($str);
    $count = 1;
    for ($i = 0; $i < strlen($str); $i++) {
        if (($str[$i] == " ") && ($str[$i + 1] != " ")) {
            $count++;
        }
        if ($count == ($limit + 1)) {
            $str = substr($str, 0, $i);
        }
    }
    if ($limit < $count) {
        return $str . '...';
    } else {
        return $str;
    }
}

?>