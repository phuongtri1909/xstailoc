@extends('frontend.layouts.app')

@section('title','Xổ Số Vietlott - XS Vietlott - KQXS Vietlott - Kết quả xổ số Vietlott hôm nay tại xosotailoc.live')
@section('decription','Vietlott - XS Vietlott - KQXS Vietlott ✅ - Kết quả xổ số V KQXS ietlott hôm nay được cập nhật nhanh nhất, chính xác nhất, mang cơ hội may mắn đến cho mọi người')
@section('h1','Xổ Số Vietlott - XS Vietlott - KQXS Vietlott - Kết quả xổ số Vietlott hôm nay xosotailoc.live')

@section('breadcrumb')
    <div class="linkway">

        <div class="main">
            <div class="breadcrumb">
                <ol itemscope="" itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a
                                itemprop="item" href="/" title="Trang chủ"><span itemprop="name">Trang chủ</span>
                            <meta itemprop="position" content="1">
                        </a></li>
                    <li> »
                    </li>
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a
                                itemprop="item" href="{{url()->current()}}" title="Xổ số Vietlott"
                                class="last"><span itemprop="name">Xổ số Vietlott</span>
                            <meta itemprop="position" content="2">
                        </a></li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="col-l">
        <div class="box mega645">
            <ul class="tab-panel tab-3">
                <li class="active"><a href="{{route('vietlott')}}">Vietlott</a></li>
                <li><a href="{{route('mega645')}}">Mega 6/45</a></li>
                <li><a href="{{route('power655')}}">Power 6/55</a></li>
                {{--<li><a href="#">Max 3D</a></li>--}}
                {{--<li><a href="#">Max 3D Pro</a></li>--}}
            </ul>
            <h2 class="tit-mien clearfix">
                <strong> <a class="title-a" href="{{route('mega645')}}" title="Xổ số Mega">Xổ số
                        Mega</a> {{getThu($kq_mega645->day)}} ngày {{getNgay($kq_mega645->date)}}</strong>
            </h2>
            <ul class="results">
                <li id="load_kq_mega_0">
                    <div class="box">
                        <div class="clearfix">
                            <table class="data ctrl-table-jackpot">
                                <tbody>
                                <tr>
                                    @php $daySo = explode('-', $kq_mega645->day_so); $d=1; @endphp
                                    @foreach($daySo as $value)
                                        <td><i>{{$value}}</i></td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <p class="txt-center">Giá trị Jackpot: <strong>{{number_format($kq_mega645->jackpot_gt)}} đồng</strong></p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <table class="data2">
                            <tbody>
                            <tr>
                                <td>Giải thưởng</td>
                                <td>Trùng khớp</td>
                                <td>Số lượng giải</td>
                                <td>Giá trị giải (đồng)</td>
                            </tr>
                            <tr>
                                <td class="clnote">Jackpot</td>
                                <td><i></i> <i></i> <i></i> <i></i> <i></i> <i></i></td>
                                <td>{{$kq_mega645->jackpot_sl}}</td>
                                <td class="clnote">{{number_format($kq_mega645->jackpot_gt)}}</td>
                            </tr>
                            <tr>
                                <td class="clnote">Giải nhất</td>
                                <td><i></i> <i></i> <i></i> <i></i> <i></i></td>
                                <td>{{number_format($kq_mega645->g1_sl)}}</td>
                                <td>10.000.000</td>
                            </tr>
                            <tr>
                                <td class="clnote">Giải nhì</td>
                                <td><i></i> <i></i> <i></i> <i></i></td>
                                <td>{{number_format($kq_mega645->g2_sl)}}</td>
                                <td>300.000</td>
                            </tr>
                            <tr>
                                <td class="clnote">Giải ba</td>
                                <td><i></i> <i></i> <i></i></td>
                                <td>{{number_format($kq_mega645->g3_sl)}}</td>
                                <td>30.000</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </li>
            </ul>
        </div>
        <div class="power655 box  mega645">
            <h2 class="tit-mien clearfix">
                <strong> <a class="title-a"
                            href="{{route('power655')}}"
                            title="Xổ số Power">Xổ số Power</a> {{getThu($kq_power655->day)}} ngày {{getNgay($kq_power655->date)}}</strong>
            </h2>
            <ul class="results">
                <li id="load_kq_power_0">
                    <div class="box">
                        <div class="clearfix">
                            <table class="data w-50 mb-16">
                                <tbody>
                                @php $daySo = explode('-', $kq_power655->day_so); $d=1; @endphp
                                <tr class="ctrl-number-2">
                                    <td><i>{{$daySo[0]}}</i></td>
                                    <td><i>{{$daySo[1]}}</i></td>
                                    <td><i>{{$daySo[2]}}</i></td>
                                    <td><i>{{$daySo[3]}}</i></td>
                                    <td><i>{{$daySo[4]}}</i></td>
                                    <td><i>{{$daySo[5]}}</i></td>
                                    <td><i>{{$daySo[6]}}</i></td>
                                </tr>
                                <tr>
                                    <td colspan="7">
                                        <p class="txt-center">Giá trị Jackpot 1: <strong>{{number_format($kq_power655->jackpot1_gt)}} đồng</strong>
                                        </p>

                                        <p class="txt-center">Giá trị Jackpot 2: <strong>{{number_format($kq_power655->jackpot2_gt)}} đồng</strong></p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <table class="data2">
                            <tbody>
                            <tr>
                                <td>Giải thưởng</td>
                                <td>Trùng khớp</td>
                                <td>Số lượng giải</td>
                                <td>Giá trị giải (đồng)</td>
                            </tr>
                            <tr>
                                <td class="clnote">Jackpot 1</td>
                                <td><i></i> <i></i> <i></i> <i></i> <i></i> <i></i></td>
                                <td>{{$kq_power655->jackpot1_sl}}</td>
                                <td class="clnote">{{number_format($kq_power655->jackpot1_gt)}}</td>
                            </tr>
                            <tr>
                                <td class="clnote">Jackpot 2</td>
                                <td><i></i> <i></i> <i></i> <i></i> <i></i> | <i class="clnote"></i></td>
                                <td>{{$kq_power655->jackpot2_sl}}</td>
                                <td class="clnote">{{number_format($kq_power655->jackpot2_gt)}}</td>
                            </tr>
                            <tr>
                                <td class="clnote">Giải nhất</td>
                                <td><i></i> <i></i> <i></i> <i></i> <i></i></td>
                                <td>{{number_format($kq_power655->g1_sl)}}</td>
                                <td>40.000.000</td>
                            </tr>
                            <tr>
                                <td class="clnote">Giải nhì</td>
                                <td><i></i> <i></i> <i></i> <i></i></td>
                                <td>{{number_format($kq_power655->g2_sl)}}</td>
                                <td>500.000</td>
                            </tr>
                            <tr>
                                <td class="clnote">Giải ba</td>
                                <td><i></i> <i></i> <i></i></td>
                                <td>{{number_format($kq_power655->g3_sl)}}</td>
                                <td>50.000</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </li>
            </ul>
        </div>
        <div class="box-content">
                              
                <p><span style="font-weight: 400;"><strong><a href="{{route('vietlott')}}" title="XS Vietlott"><span style="color:#0000FF"> Kết Quả XS Vietlott</span> </a></strong>. KQXS Vietlott. Kết Quả Xổ Số Vietlott. xosotailoc.live nơi cập nhật Kết quả Xổ Số Vietlott nhanh v&agrave; ch&iacute;nh x&aacute;c nhất.</span></p>
                
            <p><span style="font-weight: 400;">Xổ số Vietlott mang đến những sản phẩm xổ số tự chọn điện to&aacute;n minh bạch, cơ hội tốt hơn cho cộng đồng v&agrave; ph&uacute;c lợi x&atilde; hội.</span></p>
            <h2><strong>T&igrave;m hiểu về Xổ số Vietlott</strong></h2>
            <p><span style="font-weight: 400;">Xổ số điện to&aacute;n Vietlott thuộc c&ocirc;ng ty xổ số điện to&aacute;n Việt Nam, cung cấp h&igrave;nh thức chơi xổ số tự chọn thuộc kiểu mới kh&aacute;c biệt ho&agrave;n to&agrave;n với xổ số truyền thống. Qua đ&oacute;, người chơi c&oacute; thể tự quyết định chọn một d&atilde;y số nằm trong tất cả c&aacute;c bộ số theo quy định từng loại h&igrave;nh của xổ <strong><a href="{{route('vietlott')}}" title="XS Vietlott"><span style="color:#0000FF"> Kết Quả XS Vietlott</span> </a></strong>..</span></p>
            <p><span style="font-weight: 400;">Xổ số Vietlott mang đến mức gi&aacute; trị tiền thưởng cao hơn xổ số truyền thống. Đồng thời, c&oacute; nhiều mức tr&uacute;ng giải kh&aacute;c nhau n&ecirc;n người chơi sẽ c&oacute; nhiều cơ hội tr&uacute;ng thưởng, kiếm th&ecirc;m thu nhập cho m&igrave;nh.</span></p>
            <h2><strong>C&aacute;c h&igrave;nh thức của Xổ số Vietlott hiện nay:</strong></h2>
            <p><span style="font-weight: 400;">- Xổ số Mega 6/45: người chơi chọn 6 bộ số trong tổng số 45 bộ từ 01 đến 45. Xổ số Mega 6/45 mở thưởng v&agrave;o ng&agrave;y thứ 4, thứ 6 v&agrave; chủ nhật h&agrave;ng tuần.</span></p>
            <p><span style="font-weight: 400;"<strong><a  href="{{route('mega645')}}" title="Mega 6/45"><span style="color:#0000FF">Mega 6/45</span></a></strong>   bao gồm 3 c&aacute;ch chơi: c&aacute;ch chơi bao ( c&oacute; 5 bao gồm bao 7 -15 v&agrave; bao 18), c&aacute;ch chơi ti&ecirc;u chuẩn ( chọn ngẫu nhi&ecirc;n 6 số trong d&atilde;y số từ 1-45 ), c&aacute;ch chơi nhiều bộ số ( chọn nhiều bộ số tr&ecirc;n thẻ chọn số ).</span></p>
            <p><span style="font-weight: 400;">- Xổ số  <strong><a  href="{{route('power655')}}" title="Power 6/55"><span style="color:#0000FF">Power 6/55</span></a></strong>: người chơi chọn 6 bộ số trong tổng số 55 bộ từ 01 đến 55. Xổ số Power 6/55 mở thưởng v&agrave;o c&aacute;c ng&agrave;y thứ 3, thứ 5 v&agrave; thứ 7 h&agrave;ng tuần.</span></p>
            <p><span style="font-weight: 400;">C&oacute; 2 c&aacute;ch chơi xổ số Power 6/55: c&aacute;ch chơi&nbsp; ti&ecirc;u chuẩn ( chọn ngẫu nhi&ecirc;n 6 số trong 55 số, tối đa 6 kỳ li&ecirc;n tiếp ), c&aacute;ch chơi bao ( chọn bao tr&ecirc;n thẻ số, bao gồm 5 bao, bao 7-15 v&agrave; bao 18).</span></p>
            <p><strong>Cơ cấu giải thưởng của c&aacute;c loại h&igrave;nh xổ số Vietlott</strong></p>
            <p>Xổ số Mega 6/45:&nbsp;</p>
            <p><span style="font-weight: 400;"><strong><a  href="{{route('mega645')}}" title="Mega 6/45"><span style="color:#0000FF">Mega 6/45</span></a></strong>   bao gồm 4 giải thưởng như sau:</span></p>
            <p><span style="font-weight: 400;">- Giải đặc biệt: gi&aacute; trị giải thưởng tối thiểu l&agrave; 12 tỷ đồng, c&oacute; 6 kết quả tr&ugrave;ng với kết quả quay thưởng.</span></p>
            <p><span style="font-weight: 400;">- Giải nhất: gi&aacute; trị giải thưởng l&agrave; 10 triệu đồng, c&oacute; 5 kết quả tr&ugrave;ng với kết quả quay thưởng.</span></p>
            <p><span style="font-weight: 400;">- Giải nh&igrave;: gi&aacute; trị giải thưởng l&agrave; 300 ngh&igrave;n đồng, c&oacute; 4 kết quả tr&ugrave;ng với kết quả quay thưởng</span></p>
            <p><span style="font-weight: 400;">- Giải 3: gi&aacute; trị giải thưởng l&agrave; 30 ngh&igrave;n đồng, c&oacute; 3 kết quả tr&ugrave;ng với kết quả quay thưởng.</span></p>
            <h2>Xổ số Power 6/55:&nbsp;</h2>
            <p><span style="font-weight: 400;">Xổ số Power 6/55 gồm 5 giải thưởng, mở thưởng 1 lần mỗi kỳ để chọn ra 6 số tr&uacute;ng thưởng trong d&atilde;y số từ 1 &ndash; 55. Giải đặc biệt sẽ được quay từ 49 quả b&oacute;ng c&ograve;n lại sau khi đ&atilde; chọn ra 6 quả b&oacute;ng trước đ&oacute; để trao giải thưởng Jackpot 2. Giải thưởng cao nhất l&agrave; 30 tỷ đồng.</span></p>
            <h2><strong>Lịch quay số v&agrave; mở thưởng của <strong><a href="{{route('vietlott')}}" title="XS Vietlott"><span style="color:#0000FF"> Kết Quả XS Vietlott</span> </a></strong>.&nbsp;</strong></h2>
            <p><span style="font-weight: 400;">- Xổ số Mega 6/45:&nbsp; Bắt đầu quay thưởng v&agrave;o 18h00 ng&agrave;y thứ 4, thứ 6 v&agrave; Chủ nhật h&agrave;ng tuần.</span></p>
            <p><span style="font-weight: 400;">- Xổ số Mega 6/55:&nbsp; Bắt đầu quay thưởng v&agrave;o 18h00 ng&agrave;y thứ 3, thứ 4 v&agrave; 7 h&agrave;ng tuần.</span></p>
            <p><span style="font-weight: 400;"><strong><a href="{{route('vietlott')}}" title="XS Vietlott"><span style="color:#0000FF"> Kết Quả XS Vietlott</span> </a></strong>. với chơi đơn giản, gi&aacute; trị giải thưởng cao mang đến nhiều cơ hội tr&uacute;ng thưởng cho người chơi, g&oacute;p phần v&agrave;o c&ocirc;ng &iacute;ch x&atilde; hội.</span></p>
            <p><span style="font-weight: 400;">Kết quả Xổ Số Vietlott được cập nhật li&ecirc;n tục, nhanh ch&oacute;ng v&agrave; ch&iacute;nh x&aacute;c tại xosotailoc.live</span></p>
        </div>
    </div>
@endsection
