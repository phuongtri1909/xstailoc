<?php

date_default_timezone_set('Asia/Ho_Chi_Minh');

?>

@extends('frontend.layouts.app')

@section('title',$meta_title)
@section('decription',$meta_decription)
@section('keyword',$meta_keyword)

@section('content')
    <div class="col-l" style="height: auto !important;">
        <div class="box" id="result-book">
            <h2 class="tit-mien">Sổ kết quả - KQXSMT {{$n}} ngày gần nhất</h2>
            <form id="statistic-form" class="clearfix form-horizontal">
                <meta name="csrf-token" content="{{ csrf_token() }}"/>

                <div class="form-group field-statisticform-numofday">
                    <label class="control-label" for="statisticform-numofday">Số ngày</label>
                    <select id="province" class="form-control" name="province">
                        <option value="{{route('xsmt.skq')}}" @if(url()->full()==route('xsmt.skq')) selected @endif>Sổ kết quả</option>
                        <option value="{{route('xsmt.ngay',60)}}" @if(url()->full()==route('xsmt.ngay',60)) selected @endif>60 ngày</option>
                        <option value="{{route('xsmt.ngay',90)}}" @if(url()->full()==route('xsmt.ngay',90)) selected @endif>90 ngày</option>
                        <option value="{{route('xsmt.ngay',100)}}" @if(url()->full()==route('xsmt.ngay',100)) selected @endif>100 ngày</option>
                        <option value="{{route('xsmt.ngay',120)}}" @if(url()->full()==route('xsmt.ngay',120)) selected @endif>120 ngày</option>
                        <option value="{{route('xsmt.ngay',200)}}" @if(url()->full()==route('xsmt.ngay',200)) selected @endif>200 ngày</option>
                    </select>
                    <div class="help-block"></div>
                </div>
            </form>
        </div>
        <div class="box" id="result-box-content" style="height: auto !important;">
            @include('frontend.xsmt.block_xsmt_n_ngay')

            <div class="see-more">
                <div class="bold see-more-title">⇒ Ngoài ra bạn có thể xem thêm:</div>
                <ul class="list-unstyle list-html-link">
                    <li>Xem thêm <a href="{{route('xsmt')}}"
                                    title="Kết Quả XSMT">kết quả XSMT</a></li>
                    <li>Mời bạn <a href="{{route('quay_thu.mt')}}" title="Quay thử XSMT">quay thử
                            XSMT</a> hôm nay để thử vận may
                    </li>
                    <li>Xem thêm <a
                                href="{{route('vietlott')}}"
                                title="kết quả xổ số Vietlott">kết quả xổ số Vietlott</a></li>
                    <li>Xem thêm <a
                                href="{{route('mega645')}}">kết
                            quả xổ số Mega 6/45</a></li>
                    <li>Xem thêm <a
                                href="{{route('power655')}}"
                                title="Xổ số Power 6/55">kết quả xổ số Power 6/55</a></li>
                    <li>Xem thêm <a href="#" title="Xổ số Max 3D Pro">kết quả xổ số
                            Max 3D Pro</a></li>
                    <li>Xem thêm <a href="#"
                                    title="Xổ số Max 3D">kết quả xổ số Max 3D</a></li>
                </ul>
            </div>

        </div>
        <div class="box-content">

            <p dir="ltr"><a href="{{url()->full()}}"
                            title="XSMT {{$n}} ngày">XSMT {{$n}} ngày</a> - Tổng hợp kết quả xổ số miền Trung {{$n}} ngày gần đây nhất
                gồm: Thống kê KQXSMT {{$n}} ngày, Bảng kết quả&nbsp;<a
                        href="{{route('xsmt')}}" title="SXMT">SXMT</a> {{$n}}
                ngày liên tiếp giúp bạn theo dõi quy luật ra số của các đài miền Trung</p>

             <p><span style="font-weight: 400;">Sổ Kết Quả Xổ Số Miền Trung. <strong>KQXSMT</strong>. Sổ Kết Quả XSMT. Xem Kết Quả Xổ Số Miền Trung nhanh ch&oacute;ng, ch&iacute;nh x&aacute;c v&agrave; ho&agrave;n to&agrave;n miễn ph&iacute; tại xosotailoc.vip</span></p>
            <p><span style="font-weight: 400;">xosotailoc.vip nơi tổng hợp Sổ Kết Quả Xổ Số Miền Trung nhanh ch&oacute;ng, ch&iacute;nh x&aacute;c v&agrave; ho&agrave;n to&agrave;n miễn ph&iacute;.</span></p>
            <h2><strong>Sổ kết quả Xổ Số Miền Trung l&agrave; g&igrave;?</strong></h2>
            <p><span style="font-weight: 400;">Sổ kết quả Xổ Số Miền Trung (KQXSMT) l&agrave; bảng thống k&ecirc; kết quả xổ số c&ugrave;ng với bảng xổ số v&agrave; c&aacute;c giải đặc biệt trong th&aacute;ng qua.</span></p>
            <p><span style="font-weight: 400;">Sổ kết quả gi&uacute;p bạn dễ d&agrave;ng nắm được th&ocirc;ng tin về kết quả từ giải đặc biệt của th&aacute;ng trước đến giải 7. B&ecirc;n cạnh bảng thống k&ecirc; xổ số truyền thống, bạn cũng sẽ thấy bảng l&ocirc; t&ocirc; với tất cả những con số đầu/đu&ocirc;i được cập nhật từ 0 đến 9. Sổ kết quả cũng tổng hợp 2 số cuối của giải đặc biệt v&agrave; thống k&ecirc; xổ số miền Trung về nhiều nhất trong 30 ng&agrave;y qua.&nbsp;</span></p>
            <h2><strong>V&igrave; sao n&ecirc;n theo d&otilde;i Sổ kết quả?</strong></h2>
            <p><span style="font-weight: 400;">Với nhiều người chơi, việc theo d&otilde;i kết quả xổ số theo từng ng&agrave;y bị d&agrave;n trải, dẫn đến việc kh&oacute; theo d&otilde;i kết quả một c&aacute;ch liền mạch. Do đ&oacute;, Sổ Kết Quả Xổ Số Miền Trung gi&uacute;p người chơi dễ d&agrave;ng thống k&ecirc; nhanh kết quả xổ số theo bi&ecirc;n độ ng&agrave;y người chơi mong muốn.</span></p>
            <p><span style="font-weight: 400;">Việc &aacute;p dụng c&ocirc;ng nghệ 4.0 v&agrave; xử l&yacute; thuật to&aacute;n th&ocirc;ng minh, việc thống k&ecirc; đ&atilde; trở n&ecirc;n đơn giản v&agrave; thuận tiện hơn chỉ với v&agrave;i thao t&aacute;c đơn giản.</span></p>
            <h2><strong>C&ocirc;ng dụng v&agrave; lợi &iacute;ch của Sổ Kết Quả Xổ Số Miền Trung&nbsp;</strong></h2>
            <p><span style="font-weight: 400;">Đối với những người chơi xổ số l&acirc;u d&agrave;i hay đ&aacute;nh l&ocirc; đề th&igrave; việc tham gia những nghi&ecirc;n cứu v&agrave; tham khảo những kết quả của 30 ng&agrave;y li&ecirc;n tiếp theo c&aacute;ch chơi của m&igrave;nh l&agrave; điều v&ocirc; c&ugrave;ng cần thiết. Đ&acirc;y l&agrave; một c&ocirc;ng cụ nghi&ecirc;n cứu rất hữu &iacute;ch v&agrave; cần thiết m&agrave; mọi người chơi cần sử dụng.&nbsp;</span></p>
            <p><span style="font-weight: 400;">Với Sổ kết quả xổ số Miền Trung (KQXSMT), người chơi dễ d&agrave;ng xem được kết quả xổ số &ldquo;mới nhất&rdquo; của ng&agrave;y h&ocirc;m nay v&agrave; c&ograve;n c&oacute; thể xem trực tiếp kết quả xổ số mới nhất trong 30 ng&agrave;y tăng th&ecirc;m. Điều n&agrave;y ch&iacute;nh l&agrave; ưu điểm để người chơi dễ d&agrave;ng nh&igrave;n thấy những con số may mắn hiển thị với tần suất tr&uacute;ng cao nhất v&agrave; chọn cho m&igrave;nh những con số &ldquo;hợp l&yacute;&rdquo;. Việc nghi&ecirc;n cứu c&aacute;c quy tắc về việc lựa chọn, đ&aacute;nh số như vậy gi&uacute;p người chơi dễ d&agrave;ng t&igrave;m ra được những con số của m&igrave;nh v&agrave; c&ograve;n tăng khả năng tr&uacute;ng thưởng v&agrave; giảm thiểu rủi ro nhất cho m&igrave;nh.</span></p>
            <p><span style="font-weight: 400;">Xem bảng tổng hợp Kết Quả Xổ Số Miền Trung mới nhất, nhanh nhất tại xosotailoc.vip. Sổ Kết Quả Xổ Số miền Bắc, Sổ Kết Quả Xổ Số Miền Nam cũng được cập nhật li&ecirc;n tục tr&ecirc;n <a title="xosotailoc.vip." href="/">xosotailoc.vip.</a></span></p>
        </div>

        <script>
        </script>
    </div>
@endsection

@section('afterJS')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#province').change(function () {
                let urlChaneg = $('#province option:selected').val();
                window.location.href = urlChaneg;
            });
        });
    </script>
@endsection