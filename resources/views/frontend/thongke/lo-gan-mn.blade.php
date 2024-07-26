<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app')

@section('title','Lô gan miền Nam - Thống kê lô gan Với Xổ Số Tài Lộc')
@section('decription','Lô gan miền Nam Với Xổ Số Tài Lộc - Thống kê lô gan - Thống kê các cặp Lô tô gan lâu ngày chưa về. Thống kê Xổ số nhanh, chính xác')
@section('keyword','lo gan, lô gan, Lô gan miền Nam, Thống kê lô gan, thong ke lo gan')
@section('h1','Lô gan miền Nam - Thống kê lô gan Với Xổ Số Tài Lộc')
@section('breadcrumb')
    <div class="linkway">
        <div class="main">
            <div class="breadcrumb"><ol itemscope="" itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="/" title="Trang chủ"><span itemprop="name">Trang chủ</span><meta itemprop="position" content="1"></a></li><li> »
                    </li><li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="{{route('tk.lo-gan-mn')}}" title="Thống kê lô gan miền Nam" class="last"><span itemprop="name">Thống kê lô gan miền Nam</span><meta itemprop="position" content="2"></a></li>
                </ol></div>
        </div>
    </div>
@endsection
@section('content')
    <div class="col-l">
        <ul class="tab-panel tab-auto">
            <li><a href="{{route('tk.lo-gan','mb')}}" title="Lô gan MB">Lô gan MB</a></li>
            <li class="active"><a href="{{route('tk.lo-gan-mn')}}" title="Lô gan MN">Lô gan MN</a></li>
            <li><a href="{{route('tk.lo-gan-mt')}}" title="Lô gan MT">Lô gan MT</a></li>

        </ul>
        <div class="box tbl-row-hover">
            <h2 class="tit-mien">
                <strong>Thống kê lô tô gan miền Nam ngày {{date('d/m/Y')}}</strong>
            </h2>

            <form id="statistic-form" class="form-horizontal">
                <div class="form-group field-statisticform-provinceid">
                    <label class="control-label" for="statisticform-provinceid">Chọn tỉnh</label>
                    <select id="selectProvince" class="form-control" name="selectProvince">
                        <option class="text-selected" value="">---Chọn tỉnh---</option>
                        @foreach($provinces as $pro)
                            <option class="text-selected" value="{{route('tk.lo-gan',$pro->short_name)}}">{{$pro->name}}</option>
                        @endforeach
                    </select>

                    <div class="help-block"></div>
                </div>
                <div class="form-group field-statisticform-numofday">
                    <label class="control-label" for="statisticform-numofday">Chọn biên độ</label>
                    <select class="form-control" name="count" id="count">
                        @for($n=10;$n<=50;$n++)
                            <option value="{{$n}}">{{$n}}</option>
                        @endfor
                    </select>

                    <div class="hint-block">(Số lần mở thưởng gần đây nhất)</div>
                    <div class="help-block"></div>
                </div>
            </form>
        </div>

        <div id="thongKeLo_Table">
            <?php
            $day_now = getThuNumber(date('Y-m-d', time()));
            $list_provinces = \App\Models\Province::where('mien', 3)->where('ngay_quay', 'like', "%$day_now%")->get();
            ?>
            @foreach ($list_provinces as $province)
                <?php
                $kqs = \App\Models\Lottery::where('province_id', $province->id)->where('status', 1)->orderBy('date', 'DESC')->take(30)->get();
                // tạo mảng bộ số từ 00->99
                $ArrayCollect = array();
                for ($i = 0; $i < 100; $i++) {
                    if ($i < 10) {
                        $ArrayCollect[$i][0] = '0' . $i;
                    } else {
                        $ArrayCollect[$i][0] = $i;
                    }
                    $ArrayCollect[$i][1] = ''; // ngày về gần nhất
                    $ArrayCollect[$i][2] = -1; // số ngày chưa về

                }
                $len_collect = count($ArrayCollect);
                $number_date = 0;
                foreach ($kqs as $kq) {
                    $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
                    $arr_kq = getLoto($tmp_result1);
                    for ($t = 0; $t < $len_collect; $t++) {
                        if (in_array($ArrayCollect[$t][0], $arr_kq)) {
                            if ($ArrayCollect[$t][2] == -1) {
                                $ArrayCollect[$t][1] = $kq->date;
                                /*Tinh so ngay chua ve*/
                                $ArrayCollect[$t][2] = $number_date;
                            }
                        }
                    }
                    $number_date++;
                }
                $logan_arr = $ArrayCollect;
                for ($e = 0; $e < $len_collect - 1; $e++) {
                    for ($f = $e + 1; $f < $len_collect; $f++) {
                        if ($ArrayCollect[$e][2] < $ArrayCollect[$f][2]) {
                            swap($ArrayCollect[$e][2], $ArrayCollect[$f][2]);
                            swap($ArrayCollect[$e][0], $ArrayCollect[$f][0]);
                            swap($ArrayCollect[$e][1], $ArrayCollect[$f][1]);
                        }
                    }
                }

                $maxgan = array();
                $kqgan = \App\Models\Gan::where('province_id', $province->id)->where('type', 1)->orderBy('max', 'DESC')->get();
                foreach ($kqgan as $item) {
                    $maxgan[$item->loto] = $item->max;
                }
                ?>
                <div class="box tbl-row-hover">
                    <h2 class="tit-mien bold">Thống kê
                        <a href="{{route('tk.lo-gan',$province->short_name)}}"
                                                 title="thống kê lô gan {{$province->name}}" class="title-a">Thống kê lô
                            gan {{$province->name}}</a> lâu chưa về nhất tính đến ngày hôm nay
                    </h2>
                    <div>
                        <table class="mag0">
                            <tbody>
                            <tr>
                                <th>Bộ số</th>
                                <th>Ngày ra gần đây</th>
                                <th>Số ngày gan</th>
                                <th>Gan cực đại</th>
                            </tr>
                            @for($t = 0; $t< count($ArrayCollect); $t++)
                                @if($ArrayCollect[$t][2] >=10)
                                    <tr>
                                        <td><strong class="s18">{{$ArrayCollect[$t][0]}}</strong></td>
                                        @if(!empty($ArrayCollect[$t][1]))
                                            <td><a class="sub-title"
                                                   href="{{route('xstinh.date',[$province->short_name,getNgayLink($ArrayCollect[$t][1])])}}"
                                                   title="xổ số {{$province->name}} ngày {{getNgay($ArrayCollect[$t][1])}}">{{getNgay($ArrayCollect[$t][1])}}</a>
                                            </td>
                                        @else
                                            <td></td>
                                        @endif
                                        <td class="s18 clred bold">{{$ArrayCollect[$t][2]}}</td>
                                        <td class="s18 clred bold">{{$maxgan[$ArrayCollect[$t][0]]}}</td>
                                    </tr>
                                @endif
                            @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach

        </div>

        <div class="box-content">
            <p><span style="font-size:14px"><strong><a href="{{route('tk.lo-gan-mn')}}" title="Lô gan MN"><span style="color:rgb(0, 0, 255)">Lô Gan MN</span></a></strong> - Thống kê lô gan miền Nam LGMN lâu chưa về:&nbsp;xem những cặp số miền Nam lâu chưa ra nhất đến ngày hôm nay</span></p>

            <h2 dir="ltr"><span style="font-size:14px"><strong>Bảng thống kê lô gan miền Nam&nbsp;cung cấp những thông tin rất hữu ích sau:</strong></span></h2>

            <p dir="ltr"><span style="font-size:14px">- <strong>Cột 1:</strong> Những bộ số lâu ra nhất miền nam dựa theo <strong><a href="{{route('home')}}" title="kết quả xổ số"><span style="color:#0000FF">kết quả xổ số</span></a></strong> của tất cả các tỉnh mở thưởng hôm nay theo biên độ từ 1 đến 10 ngày.</span></p>

            <p dir="ltr"><span style="font-size:14px">- <strong>Cột 2:</strong> Thông tin ngày ra gần đây của những cặp số lâu về nhất tính đến ngày hôm nay của tỉnh miền nam đó.</span></p>

            <p dir="ltr"><span style="font-size:14px">-<strong> Cột 3:</strong> Số ngày lô đó khan trong các kỳ quay xổ số miền nam gần đây.</span></p>

            <p dir="ltr"><span style="font-size:14px">- <strong>Cột 4:</strong> Ngày lô gan cực đại của số đó tương ứng với từng tỉnh miền nam ba đài mở thưởng trong lịch sử.</span></p>

            <h2 dir="ltr"><span style="font-size:14px"><strong>Cách đánh số theo lô gan hiệu quả:</strong></span></h2>

            <p dir="ltr"><span style="font-size:14px">- Loại bỏ những bộ số gan&nbsp;trên 18 kỳ quay số.</span></p>

            <p dir="ltr"><span style="font-size:14px">- Thường thì khi các cặp số lâu về miền Nam gần với số ngày cực đại sẽ có khả năng về cao hơn. Xem kỹ phần gan cực đại</span></p>
            <p><span style="font-weight: 400;">L&ocirc; gan XSMN. Thống k&ecirc; L&ocirc; Gan XSMN l&acirc;u chưa về. Xem Bảng Thống K&ecirc; L&ocirc; Gan Xổ Số Miền Nam nhanh ch&oacute;ng, ch&iacute;nh x&aacute;c tại xstailoc.com</span></p>
            <p><span style="font-weight: 400;">xstailoc.com nơi cập nhật Thống k&ecirc; l&ocirc; gan Miền Nam nhanh ch&oacute;ng, kịp thời, ch&iacute;nh x&aacute;c nhất v&agrave; ho&agrave;n to&agrave;n miễn ph&iacute;.</span></p>
            <h2><strong>Thống k&ecirc; L&ocirc; Gan Miền Nam l&agrave; g&igrave;?</strong></h2>
            <p><span style="font-weight: 400;">Thống k&ecirc; l&ocirc; gan Miền Nam (hay c&ograve;n gọi l&agrave; l&ocirc; khan Miền Nam) l&agrave; thống k&ecirc; những cặp số l&ocirc; t&ocirc; (2 số cuối) l&acirc;u chưa về tr&ecirc;n bảng KQXS Miền Nam trong một khoảng thời gian, v&iacute; dụ như 5 ng&agrave;y hay 10 ng&agrave;y. Đ&acirc;y l&agrave; những con loto gan lỳ kh&ocirc;ng chịu xuất hiện. Số ng&agrave;y gan (kỳ gan) l&agrave; số lần mở thưởng m&agrave; bộ số đ&oacute; chưa về đến h&ocirc;m nay.</span></p>
            <p><span style="font-weight: 400;">V&iacute; dụ: Với bi&ecirc;n độ gan = 10, bạn sẽ xem được thống k&ecirc; c&aacute;c bộ số chưa về trong 10 ng&agrave;y t&iacute;nh đến ng&agrave;y h&ocirc;m nay.</span></p>
            <h2><strong>Những th&ocirc;ng tin tr&ecirc;n bảng Thống k&ecirc; l&ocirc; gan Miền Nam&nbsp;</strong></h2>
            <p><span style="font-weight: 400;">Những con l&ocirc; l&acirc;u chưa về (l&ocirc; l&ecirc;n gan) từ 00-99, số ng&agrave;y gan v&agrave; số ng&agrave;y gan cực đại, kỷ lục l&acirc;u chưa về nhất (gan max) tổng bao nhi&ecirc;u ng&agrave;y</span></p>
            <p><span style="font-weight: 400;">Thống k&ecirc; cặp l&ocirc; gan xổ số Miền Nam (gồm 1 số v&agrave; số lộn của ch&iacute;nh n&oacute;) l&acirc;u chưa về t&iacute;nh đến h&ocirc;m nay c&ugrave;ng với thời gian gan cực đại của c&aacute;c cặp số đ&oacute;.</span></p>
            <p><span style="font-weight: 400;">Người chơi xổ số sẽ dễ d&agrave;ng nhận biết l&ocirc; gan XSMN bằng c&aacute;ch theo d&otilde;i thống k&ecirc; những con l&ocirc; &iacute;t xuất hiện nhất trong bảng kết quả. Gan Cực Đại l&agrave; số lần kỷ lục m&agrave; một con số l&acirc;u nhất chưa về. Trường hợp l&ocirc; k&eacute;p l&acirc;u ng&agrave;y xuất hiện th&igrave; được l&agrave; l&ocirc; k&eacute;p gan (hay l&ocirc; k&eacute;p khan).</span></p>
            <h2><strong>&Yacute; nghĩa c&aacute;c cột bảng l&ocirc; gan:</strong></h2>
            <p><span style="font-weight: 400;">- Cột số: thống k&ecirc; những cặp loto đ&atilde; l&ecirc;n gan, tức l&agrave; cặp 2 số cuối của c&aacute;c giải c&oacute; &iacute;t nhất 10 ng&agrave;y li&ecirc;n tiếp chưa xuất hiện trong bảng kết quả đ&atilde; về 24h qua.</span></p>
            <p><span style="font-weight: 400;">- Ng&agrave;y ra gần nhất: thời điểm về của c&aacute;c cặp l&ocirc; gan, tức l&agrave; ng&agrave;y cuối c&ugrave;ng m&agrave; l&ocirc; đ&oacute; xuất hiện trước khi l&igrave; kh&ocirc;ng về trong kết quả xổ số Miền Nam tới nay.</span></p>
            <p><span style="font-weight: 400;">- Số ng&agrave;y gan: số ng&agrave;y m&agrave; con số l&ocirc; t&ocirc; đ&oacute; chưa ra.</span></p>
            <p><span style="font-weight: 400;">Tại đ&acirc;y, trang cung cấp cho người xem th&ocirc;ng tin của 5 bảng li&ecirc;n quan:</span></p>
            <p><span style="font-weight: 400;">- C&aacute;c bộ số v&agrave; cặp số l&ocirc; gan KQXSMN nhất hiện nay v&agrave; n&oacute; đ&atilde; gan bao nhi&ecirc;u ng&agrave;y.&nbsp;</span></p>
            <p><span style="font-weight: 400;">- Soi cầu l&ocirc; gan Namh thủ giải đặc biệt Miền Nam l&acirc;u chưa về nhất l&agrave; c&aacute;c số n&agrave;o.</span></p>
            <p><span style="font-weight: 400;">- Đầu đu&ocirc;i giải đặc biệt l&acirc;u chưa ra về trong thời gian gần đ&acirc;y.</span></p>
            <h2><strong>Phương ph&aacute;p đ&aacute;nh theo l&ocirc; gan hiệu quả:</strong></h2>
            <p><span style="font-weight: 400;">- Những cặp số xu&ocirc;i v&agrave; số lộn của ch&iacute;nh n&oacute; hay đi c&ugrave;ng nhau l&acirc;u chưa về v&agrave; thời gian gan cực đại của cặp đ&oacute;.</span></p>
            <p><span style="font-weight: 400;">- Thống k&ecirc; giải đặc biệt l&acirc;u chưa xuất hiện.</span></p>
            <p><span style="font-weight: 400;">- Thống k&ecirc; ng&agrave;y ra theo đầu &ndash; số h&agrave;ng chục hoặc đu&ocirc;i &ndash; h&agrave;ng đơn vị của 2 số cuối giải đặc biệt.</span></p>
            <p><span style="font-weight: 400;">- Tổng gan cực đại.</span></p>
            <h2><strong>C&aacute;c th&ocirc;ng số trong bảng thống k&ecirc; l&ocirc; gan Miền Nam:</strong></h2>
            <p><span style="font-weight: 400;">- Cột bộ số: Tổng hợp c&aacute;c l&ocirc; đ&atilde; l&ecirc;n gan, tức l&agrave; cặp 2 số cuối của c&aacute;c giải c&oacute; &iacute;t nhất 10 kỳ chưa xuất hiện trong bảng kết quả MN.</span></p>
            <p><span style="font-weight: 400;">- Cột 2: ng&agrave;y ra gần nhất của c&aacute;c cặp số l&acirc;u về đ&agrave;i MN.</span></p>
            <p><span style="font-weight: 400;">- Cột 3: Số ng&agrave;y l&acirc;u ra của 2 số cuối l&ocirc; t&ocirc; MN.</span></p>
            <p><span style="font-weight: 400;">- Cột 4: Ng&agrave;y l&ocirc; gan cực đại của cặp số đ&oacute;, điều n&agrave;y gi&uacute;p cho bạn x&aacute;c định được thời cơ n&ecirc;n nu&ocirc;i: nếu n&oacute; khan tiếp cận với số n&agrave;y th&igrave; c&oacute; khả năng sẽ sắp xuất hiện trong bảng XSMN.</span></p>
            <h2><strong>Th&ocirc;ng số trong bảng thống k&ecirc; cặp số l&acirc;u về MN:</strong></h2>
            <p><span style="font-weight: 400;">- Cột 1: Tổng hợp theo xu&ocirc;i v&agrave; lộn c&aacute;c cặp số l&acirc;u về MN trong 100 số từ 00 tới 99.</span></p>
            <p><span style="font-weight: 400;">- Cột 2: ng&agrave;y ra gần nhất của c&aacute;c cặp l&ocirc; khan MN đ&oacute;.</span></p>
            <p><span style="font-weight: 400;">- Cột 3: Số ng&agrave;y l&acirc;u ra của 2 số cuối l&ocirc; t&ocirc; MN.</span></p>
            <p><span style="font-weight: 400;">- Cột 4: Ng&agrave;y gan cực đại của cặp l&ocirc; t&ocirc; đ&oacute;.</span></p>
            <h2><strong>Th&ocirc;ng số trong bảng thống k&ecirc; gan cực đại MN:</strong></h2>
            <p><span style="font-weight: 400;">- Cột 1 v&agrave; cột 3: Tổng hợp số được sắp xếp từ 00 tới 99.</span></p>
            <p><span style="font-weight: 400;">- Cột 2 v&agrave; cột 4: ng&agrave;y l&acirc;u ra nhất của l&ocirc; đ&oacute;.</span></p>
            <h2><strong>Bảng thống k&ecirc; giải đặc biệt xổ số Miền Nam l&acirc;u chưa xuất hiện:</strong></h2>
            <p><span style="font-weight: 400;">- Cột 1: Tổng hợp 2 số cuối GĐB l&acirc;u chưa ra của kết quả đ&agrave;i Miền Nam.</span></p>
            <p><span style="font-weight: 400;">- Cột 2: ng&agrave;y ra gần nhất của l&ocirc; đ&oacute;.</span></p>
            <p><span style="font-weight: 400;">- Cột 3: Số ng&agrave;y gan.</span></p>
            <h2><strong>Thống k&ecirc; theo đầu (số h&agrave;ng chục) hoặc đu&ocirc;i (h&agrave;ng đơn vị) đ&agrave;i Miền Nam l&acirc;u chưa ra</strong></h2>
            <p><span style="font-weight: 400;">- Cột 1: Tổng hợp đầu hoặc đu&ocirc;i của 2 số cuối giải đặc biệt được sắp xếp theo thứ tự l&acirc;u ra nhất trở xuống.</span></p>
            <p><span style="font-weight: 400;">- Cột 2: ng&agrave;y ra gần đ&acirc;y nhất của n&oacute;.</span></p>
            <p><span style="font-weight: 400;">- Cột 3: Số ng&agrave;y gan.</span></p>
            <p><span style="font-weight: 400;">xstailoc.com cung cấp cho bạn thống k&ecirc; l&ocirc; gan Miền Nam ch&iacute;nh x&aacute;c nhất. Với t&iacute;nh năng n&agrave;y, người chơi xổ số sẽ c&oacute; th&ecirc;m th&ocirc;ng tin tham khảo để chọn cho m&igrave;nh con số may mắn, mang đến cơ hội tr&uacute;ng thưởng cao hơn. Ch&uacute;c c&aacute;c bạn may mắn!</span></p>
            <p><span style="font-weight: 400;">Thống k&ecirc; l&ocirc; gan. Tk l&ocirc;. Thống k&ecirc; l&ocirc; gan Miền Nam. L&ocirc; gan Miền Nam. L&ocirc; Gan. Xem thống k&ecirc; l&ocirc; gan h&ocirc;m nay nhanh ch&oacute;ng v&agrave; ch&iacute;nh x&aacute;c nhất tại xstailoc.com.</span></p>
            
        </div>
    </div>
@endsection

@section('afterJS')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#selectProvince').change(function () {
                let urlChaneg = $('#selectProvince option:selected').val();
                window.location.href = urlChaneg;
            });
        });
    </script>
@endsection