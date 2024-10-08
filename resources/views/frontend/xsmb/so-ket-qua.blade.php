<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>

@extends('frontend.layouts.app')
@section('title',$meta_title)
@section('decription',$meta_decription)
@section('keyword',$meta_keyword)

@section('content')
    <div class="col-l">
        <div id="result-book">
            <div class="box">
                <div class="txt-center clearfix ">
                    <h2 class="tit-mien">Sổ kết quả - KQXSMB {{$n}} ngày gần nhất</h2>
                    <form id="statistic-form" class="clearfix form-horizontal">
                        <meta name="csrf-token" content="{{ csrf_token() }}"/>

                        <div class="form-group field-statisticform-numofday">
                            <label class="control-label" for="statisticform-numofday">Số ngày</label>
                            <select id="province" class="form-control" name="province">
                                <option value="{{route('xsmb.skq')}}" selected="">Sổ kết quả</option>
                                <option value="{{route('xsmb.ngay',60)}}">60 ngày</option>
                                <option value="{{route('xsmb.ngay',90)}}">90 ngày</option>
                                <option value="{{route('xsmb.ngay',100)}}">100 ngày</option>
                                <option value="{{route('xsmb.ngay',120)}}">120 ngày</option>
                                <option value="{{route('xsmb.ngay',200)}}">200 ngày</option>
                            </select>
                            <div class="help-block"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="box" id="result-box-content">
                <div class="txt-center clearfix"></div>
                @include('frontend.xsmb.block_xsmb_n_ngay')
            </div>
        </div>
        <div class="box-content">
            <p><span style="font-size:14px"><strong><a
                                href="{{route('xsmb.ngay',$n)}}"
                                title="XSMB {{$n}} ngày"><span style="color:rgb(0, 0, 255)">XSMB {{$n}} ngày</span></a></strong>&nbsp;- Tổng hợp kết quả xổ số miền Bắc mở thưởng {{$n}} ngày&nbsp;liên tiếp cùng với bảng thống kê&nbsp;lô tô và giải đặc biệt trong tháng qua.</span>
            </p>

            <p dir="ltr"><span style="font-size:14px">Sổ kết quả cung cấp nhanh thông tin của <strong><a
                                href="{{route('xsmb')}}"
                                title="KQXSMB"><span style="color:#0000FF">KQXSMB</span></a></strong> từ giải đặc biệt đến giải 7 trong 1 tháng gần đây nhất</span>
            </p>

            <p dir="ltr"><span style="font-size:14px">- Bên cạnh bảng thống kê {{$n}} lần quay kết quả truyền thống, bạn còn có thể thể xem bảng lô tô được cập nhật theo đầu/đuôi từ 0 đến 9 tương ứng.</span>
            </p>

            <p dir="ltr"><span style="font-size:14px">- Trang còn tổng hợp thông tin thống kê 2 số cuối giải đặc biệt và lô tô miền bắc&nbsp;về nhiều nhất trong {{$n}} ngày quay số.</span>
            </p>

            <p dir="ltr"><span style="font-size:14px">- Thống kê đầu đuôi và tổng 2 số cuối GĐB từ 0 đến 9 trong {{$n}} ngày này.</span>
            </p>

            <p dir="ltr"><span style="font-size:14px">- Tổng hợp các cặp lô tô về nhiều nhất, đầu đuôi và tổng lô trong {{$n}} ngày này.</span>
            </p>
            <p style="text-align: justify;"><span style="font-weight: 400;">Sổ Kết Quả Xổ Số Miền Bắc. <a title="KQXSMB" href="/so-ket-qua"><strong>KQXSMB</strong></a>. Sổ Kết Quả XSMB. Xem Kết Quả Xổ Số Miền Bắc nhanh ch&oacute;ng, ch&iacute;nh x&aacute;c v&agrave; ho&agrave;n to&agrave;n miễn ph&iacute; tại xosotailoc.vip</span></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">xosotailoc.vip nơi tổng hợp Sổ Kết Quả Xổ Số Miền Bắc nhanh ch&oacute;ng, ch&iacute;nh x&aacute;c v&agrave; ho&agrave;n to&agrave;n miễn ph&iacute;.</span></p>
            <h2 style="text-align: justify;"><strong>Sổ kết quả <a title="Xổ Số Miền Bắc" href="/xsmb-xo-so-mien-bac">Xổ Số Miền Bắc</a> l&agrave; g&igrave;?</strong></h2>
            <p style="text-align: justify;"><span style="font-weight: 400;">Sổ kết quả Xổ Số Miền Bắc (KQXSMB) l&agrave; bảng thống k&ecirc; kết quả xổ số c&ugrave;ng với bảng xổ số v&agrave; c&aacute;c giải đặc biệt trong th&aacute;ng qua.</span></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">Sổ kết quả gi&uacute;p bạn dễ d&agrave;ng nắm được th&ocirc;ng tin về kết quả từ giải đặc biệt của th&aacute;ng trước đến giải 7. B&ecirc;n cạnh bảng thống k&ecirc; xổ số truyền thống, bạn cũng sẽ thấy bảng l&ocirc; t&ocirc; với tất cả những con số đầu/đu&ocirc;i được cập nhật từ 0 đến 9. Sổ kết quả cũng tổng hợp 2 số cuối của giải đặc biệt v&agrave; thống k&ecirc; xổ số miền Bắc về nhiều nhất trong 30 ng&agrave;y qua.&nbsp;</span></p>
            <h2 style="text-align: justify;"><strong>V&igrave; sao n&ecirc;n theo d&otilde;i Sổ kết quả?</strong></h2>
            <p style="text-align: justify;"><span style="font-weight: 400;">Với nhiều người chơi, việc theo d&otilde;i kết quả xổ số theo từng ng&agrave;y bị d&agrave;n trải, dẫn đến việc kh&oacute; theo d&otilde;i kết quả một c&aacute;ch liền mạch. Do đ&oacute;, Sổ Kết Quả Xổ Số Miền Bắc gi&uacute;p người chơi dễ d&agrave;ng thống k&ecirc; nhanh kết quả xổ số theo bi&ecirc;n độ ng&agrave;y người chơi mong muốn.</span></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">Việc &aacute;p dụng c&ocirc;ng nghệ 4.0 v&agrave; xử l&yacute; thuật to&aacute;n th&ocirc;ng minh, việc thống k&ecirc; đ&atilde; trở n&ecirc;n đơn giản v&agrave; thuận tiện hơn chỉ với v&agrave;i thao t&aacute;c đơn giản.</span></p>
            <p style="text-align: justify;"><strong>C&ocirc;ng dụng v&agrave; lợi &iacute;ch của Sổ Kết Quả Xổ Số Miền Bắc&nbsp;</strong></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">Đối với những người chơi xổ số l&acirc;u d&agrave;i hay đ&aacute;nh l&ocirc; đề th&igrave; việc tham gia những nghi&ecirc;n cứu v&agrave; tham khảo những kết quả của 30 ng&agrave;y li&ecirc;n tiếp theo c&aacute;ch chơi của m&igrave;nh l&agrave; điều v&ocirc; c&ugrave;ng cần thiết. Đ&acirc;y l&agrave; một c&ocirc;ng cụ nghi&ecirc;n cứu rất hữu &iacute;ch v&agrave; cần thiết m&agrave; mọi người chơi cần sử dụng.&nbsp;</span></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">Với Sổ kết quả xổ số Miền Bắc (KQXSMB), người chơi dễ d&agrave;ng xem được kết quả xổ số &ldquo;mới nhất&rdquo; của ng&agrave;y h&ocirc;m nay v&agrave; c&ograve;n c&oacute; thể xem trực tiếp kết quả xổ số mới nhất trong 30 ng&agrave;y tăng th&ecirc;m. Điều n&agrave;y ch&iacute;nh l&agrave; ưu điểm để người chơi dễ d&agrave;ng nh&igrave;n thấy những con số may mắn hiển thị với tần suất tr&uacute;ng cao nhất v&agrave; chọn cho m&igrave;nh những con số &ldquo;hợp l&yacute;&rdquo;. Việc nghi&ecirc;n cứu c&aacute;c quy tắc về việc lựa chọn, đ&aacute;nh số như vậy gi&uacute;p người chơi dễ d&agrave;ng t&igrave;m ra được những con số của m&igrave;nh v&agrave; c&ograve;n tăng khả năng tr&uacute;ng thưởng v&agrave; giảm thiểu rủi ro nhất cho m&igrave;nh.</span></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">Xem bảng tổng hợp Kết Quả Xổ Số Miền Bắc mới nhất, nhanh nhất tại xosotailoc.vip. Sổ Kết Quả Xổ Số miền Nam, Sổ Kết Quả Xổ Số Miền Trung cũng&nbsp; được cập nhật li&ecirc;n tục tr&ecirc;n <a title="xosotailoc.vip." href="/">xosotailoc.vip.</a></span></p>
            <p style="text-align: justify;">&nbsp;</p>
        </div>
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

