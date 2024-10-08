<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app')

@section('title','Thống kê đầu đuôi loto '.$province_name)
@section('decription','Thống kê đầu đuôi loto '.$province_name.': bảng thống kê số lần về theo đầu, đuôi, tổng lotto truyền thống XS'.strtoupper($short_name))
@section('h1','Thống kê đầu đuôi loto '.$province_name)

@section('breadcrumb')
    <div class="linkway">
        <div class="main">
            <div class="breadcrumb"><ol itemscope="" itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="/" title="Trang chủ"><span itemprop="name">Trang chủ</span><meta itemprop="position" content="1"></a></li><li> »
                    </li><li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="{{url()->current()}}" title="Thống kê đầu đuôi loto {{$province_name}}" class="last"><span itemprop="name">Thống kê đầu đuôi loto {{$province_name}}</span><meta itemprop="position" content="2"></a></li>
                </ol></div>
        </div>
    </div>
@endsection
@section('content')
    <div class="col-l">
        <div class="box tbl-row-hover tk-dauduoi">
            <h2 class="tit-mien mag0">
                <strong>Thống kê đầu đuôi lô tô xổ số miền Bắc</strong>
            </h2>
            <form id="statistic-form" class="form-horizontal">
                <div class="form-group field-statisticform-provinceid">
                    <label class="control-label" for="statisticform-provinceid">Chọn tỉnh</label>
                    <select name="selectProvince" id="selectProvince" class="form-control">
                        <option value="{{route('tk.dau-duoi-loto','mb')}}"
                                @if($short_name=='mb') selected @endif>Miền Bắc</option>
                        @foreach($provinces as $pro)
                            <option value="{{route('tk.dau-duoi-loto',$pro->short_name)}}"
                                    @if($short_name==$pro->short_name) selected @endif>{{$pro->name}}</option>
                        @endforeach
                    </select>
                    <div class="help-block"></div>
                </div>
                <div class="form-group field-statisticform-todate">
                    <label class="control-label" for="statisticform-todate">Đến ngày</label>
                    <input class="form-control" type="text" id="end_date" name="end_date" placeholder="Chọn ngày" value="{{date('d/m/Y')}}">
                </div>
                <div class="form-group field-statisticform-numofday">
                    <label class="control-label" for="statisticform-numofday">Số ngày</label>
                    <input class="form-control" type="number" id="count" name="count" placeholder="Số ngày: 1-100" value="30">
                    <div class="help-block"></div>
                </div>
                <div class="txt-center">
                    <button type="button" class="btn btn-danger" onclick="getThongKeLo()">Xem kết quả</button>
                </div>
            </form>
        </div>
        <div class="box tbl-row-hover" id="thongKe">
            <h2 class="bg_red pad10-5">
                Thống kê đầu loto {{$province_name}} trong vòng {{$rollingNumber}} ngày trước {{date('d/m/Y')}}
            </h2>
            <div class="scoll">
                <table class="mag0">
                    <tbody><tr>
                        <th class="pad0"><div class="ic ic-img2"></div></th>
                        <th>0</th>
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <th>4</th>
                        <th>5</th>
                        <th>6</th>
                        <th>7</th>
                        <th>8</th>
                        <th>9</th>
                    </tr>
                    @foreach($ArrayCollect as $key=>$value)
                        <tr>
                            @if($short_name=='mb')
                                <td style="width:68px" class="s12"><a target="_blank" href="{{route('xsmb.date',str_replace('/','-',getNgay($key)))}}">{{getNgay($key)}}</a></td>
                            @else
                                <td style="width:68px" class="s12"><a target="_blank" href="{{route('xstinh.date',[$short_name,str_replace('/','-',getNgay($key))])}}">{{getNgay($key)}}</a></td>
                            @endif
                            @for ($t = 0; $t < 10; $t++)
                                <td class="tt_dau_lt"><div class="w40">{{$value[$t]}}</div></td>
                            @endfor
                        </tr>
                    @endforeach
                    <tr class="row-rate">
                        <td><strong>Tổng</strong></td>
                        @for ($t = 0; $t < 10; $t++)
                            <td>
                                <strong>{{$tongDau[$t]}}</strong>
                                <div class="rate txt-center">
                                    <span style="height:{{$tongDau[$t]}}px" class="hrate"></span>
                                </div>
                            </td>
                        @endfor
                    </tr>
                    </tbody>
                </table>

            </div>

            <h2 class="bg_red pad10-5">Thống kê theo Đuôi loto {{$province_name}} trong vòng {{$rollingNumber}} ngày trước {{date('d/m/Y')}}
            </h2>
            <div class="scoll">
                <table class="mag0">
                    <tbody><tr>
                        <th class="pad0"><div class="ic ic-img5"></div></th>
                        <th><div class="w40">0</div></th>
                        <th><div class="w40">1</div></th>
                        <th><div class="w40">2</div></th>
                        <th><div class="w40">3</div></th>
                        <th><div class="w40">4</div></th>
                        <th><div class="w40">5</div></th>
                        <th><div class="w40">6</div></th>
                        <th><div class="w40">7</div></th>
                        <th><div class="w40">8</div></th>
                        <th><div class="w40">9</div></th>
                    </tr>
                    @foreach($ArrayCollect_Duoi as $key=>$value)
                        <tr>
                            @if($short_name=='mb')
                                <td style="width:68px" class="s12"><a target="_blank" href="{{route('xsmb.date',str_replace('/','-',getNgay($key)))}}">{{getNgay($key)}}</a></td>
                            @else
                                <td style="width:68px" class="s12"><a target="_blank" href="{{route('xstinh.date',[$short_name,str_replace('/','-',getNgay($key))])}}">{{getNgay($key)}}</a></td>
                            @endif
                            @for ($t = 0; $t < 10; $t++)
                                <td class="tt_dau_lt"><div class="w40">{{$value[$t]}}</div></td>
                            @endfor
                        </tr>
                    @endforeach
                    <tr class="row-rate">
                        <td><strong>Tổng</strong></td>
                        @for ($t = 0; $t < 10; $t++)
                            <td>
                                <strong>{{$tongDuoi[$t]}}</strong>
                                <div class="rate txt-center">
                                    <span style="height:{{$tongDuoi[$t]}}px" class="hrate"></span>
                                </div>
                            </td>
                        @endfor
                    </tr>
                    </tbody>
                </table>
            </div>
            <h2 class="bg_red pad10-5">Thống kê theo Tổng loto {{$province_name}} trong vòng {{$rollingNumber}} ngày trước {{date('d/m/Y')}}
            </h2>
            <div class="scoll">
                <table class="mag0">
                    <tbody><tr>
                        <th class="pad0"><div class="ic ic-img5"></div></th>
                        <th><div class="w40">0</div></th>
                        <th><div class="w40">1</div></th>
                        <th><div class="w40">2</div></th>
                        <th><div class="w40">3</div></th>
                        <th><div class="w40">4</div></th>
                        <th><div class="w40">5</div></th>
                        <th><div class="w40">6</div></th>
                        <th><div class="w40">7</div></th>
                        <th><div class="w40">8</div></th>
                        <th><div class="w40">9</div></th>
                    </tr>
                    @foreach($ArrayCollect_Tong as $key=>$value)
                        <tr>
                            @if($short_name=='mb')
                                <td style="width:68px" class="s12"><a target="_blank" href="{{route('xsmb.date',str_replace('/','-',getNgay($key)))}}">{{getNgay($key)}}</a></td>
                            @else
                                <td style="width:68px" class="s12"><a target="_blank" href="{{route('xstinh.date',[$short_name,str_replace('/','-',getNgay($key))])}}">{{getNgay($key)}}</a></td>
                            @endif
                            @for ($t = 0; $t < 10; $t++)
                                <td class="tt_dau_lt"><div class="w40">{{$value[$t]}}</div></td>
                            @endfor
                        </tr>
                    @endforeach
                    <tr class="row-rate">
                        <td><strong>Tổng</strong></td>
                        @for ($t = 0; $t < 10; $t++)
                            <td>
                                <strong>{{$tongTong[$t]}}</strong>
                                <div class="rate txt-center">
                                    <span style="height:{{$tongTong[$t]}}px" class="hrate"></span>
                                </div>
                            </td>
                        @endfor
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="see-more">
                <ul class="list-html-link two-column">
                    <li>Xem thống kê <a href="{{route('tk.lo-gan','mb')}}" title="lô gan miền Bắc">lô gan miền Bắc</a>        </li>
                    <li>Xem thêm <a href="#" title="thống kê 2 số cuối giải đặc biệt miền Bắc">thống kê 2 số cuối giải đặc biệt miền Bắc</a></li>
                    <li>Mời bạn <a href="{{route('quay_thu.mb')}}" title="quay thử miền Bắc">quay thử miền Bắc</a></li>
                    <li>Xem thêm <a href="#" title="Thống kê tần suất lô tô">thống kê tần suất lô tô</a></li>
                </ul>
            </div>
        </div>
        {{--<div class="box tbl-row-hover">--}}
            {{--<h3 class="tit-mien"><strong>Thảo luận</strong></h3>--}}
            {{--<div id="comment" class="fb-comments  fb_iframe_widget fb_iframe_widget_fluid_desktop" data-href="" data-lazy="true" data-numposts="5" data-colorscheme="light" data-width="100%" data-order-by="reverse_time" fb-xfbml-state="rendered" fb-iframe-plugin-query="app_id=224529274568575&amp;color_scheme=light&amp;container_width=628&amp;height=100&amp;href=https%3A%2F%2Fxoso.mobi%2Fthong-ke-dau-duoi-lo-to-mien-bac-xsmb.html&amp;lazy=true&amp;locale=vi_VN&amp;numposts=5&amp;order_by=reverse_time&amp;sdk=joey&amp;version=v7.0&amp;width=" style="width: 100%;"><span style="vertical-align: bottom; width: 100%; height: 202px;"><iframe name="f27cca07e76ff64" width="1000px" height="100px" data-testid="fb:comments Facebook Social Plugin" title="fb:comments Facebook Social Plugin" frameborder="0" allowtransparency="true" allowfullscreen="true" scrolling="no" allow="encrypted-media" loading="lazy" src="https://www.facebook.com/v7.0/plugins/comments.php?app_id=224529274568575&amp;channel=https%3A%2F%2Fstaticxx.facebook.com%2Fx%2Fconnect%2Fxd_arbiter%2F%3Fversion%3D46%23cb%3Df331dd46864de7c%26domain%3Dxoso.mobi%26is_canvas%3Dfalse%26origin%3Dhttps%253A%252F%252Fxoso.mobi%252Ff22adfccb3941dc%26relation%3Dparent.parent&amp;color_scheme=light&amp;container_width=628&amp;height=100&amp;href=https%3A%2F%2Fxoso.mobi%2Fthong-ke-dau-duoi-lo-to-mien-bac-xsmb.html&amp;lazy=true&amp;locale=vi_VN&amp;numposts=5&amp;order_by=reverse_time&amp;sdk=joey&amp;version=v7.0&amp;width=" style="border: none; width: 100%; height: 202px; visibility: visible;" class=""></iframe></span></div>--}}
            {{--<script>--}}
            {{--</script>--}}
        {{--</div>--}}
        <div class="box-content">
            <p><strong><a href="{{route('tk.dau-duoi-loto','mb')}}" title="Thống kê đầu đuôi lô tô xổ số Miền Bắc"><span style="color:rgb(0, 0, 255)">Thống kê đầu đuôi lô tô xổ số Miền Bắc XSMB </span></a></strong> theo tuần, theo tháng gần đây nhất là thống kê chi tiết số lần về của bộ số có đầu/đuôi, và bộ số bao nhiêu. (Mời di chuột vào từng số để xem chi tiết)</p>

            <p>- Tính năng này giúp bạn xem được thống kê đầu/đuôi loto XSMB  của từng giải theo khoảng thời gian tùy chọn hoặc xem thống kê theo biên độ 30 lần, 60 lần và 100 lần mở thưởng gần đây nhất.</p>

            <p>- Việc kiểm tra thống kê đầu đuôi sẽ giúp bạn có thể ghép được bộ cầu tốt nhất cho mình trong ngày. Tham khảo thêm&nbsp;<a href="#" style="color: rgb(51, 51, 51); text-decoration-line: none;" title="thống kê 2 số cuối giải đặc biệt"><span style="color:rgb(255, 0, 0)"><strong>thống kê 2 số cuối giải đặc biệt</strong></span></a>&nbsp;để xác định được đầu đuôi lô tô dễ trúng nhất trong các kỳ tiếp theo.</p>

            <p><strong>Xem kết quả&nbsp;tối nay nhanh và chính xác nhất tại:&nbsp;</strong><strong><a href="{{route('xsmb')}}" title="Xổ số miền Bắc"><span style="color:#FF0000">Xổ số miền Bắc</span></a></strong></p>
            
           <p><span style="font-weight: 400;">Thống K&ecirc; Đầu Đu&ocirc;i Loto <a title="Xổ Số Miền Bắc" href="/xsmb-xo-so-mien-bac"><strong>Xổ Số Miền Bắc</strong></a>. TK Đầu đu&ocirc;i Loto XSMB. Xem Bảng Thống K&ecirc; Đầu Đu&ocirc;i Loto Xổ Số Miền Bắc nhanh ch&oacute;ng, ch&iacute;nh x&aacute;c tại xosotailoc.vip</span></p>
            <p><span style="font-weight: 400;">xosotailoc.vip nơi cập nhật thống k&ecirc; Đầu đu&ocirc;i Loto Miền Bắc nhanh ch&oacute;ng, ch&iacute;nh x&aacute;c nhất.</span></p>
            <p><span style="font-weight: 400;">Thống k&ecirc; đầu đu&ocirc;i l&ocirc; t&ocirc; xổ số Miền Bắc theo tuần, theo th&aacute;ng gần đ&acirc;y nhất l&agrave; thống k&ecirc; chi tiết số lần về của bộ số c&oacute; đầu/đu&ocirc;i, v&agrave; bộ số bao nhi&ecirc;u.&nbsp;</span></p>
            <p><span style="font-weight: 400;">Xổ Số VN nơi cập nhật thống k&ecirc; đầu đu&ocirc;i loto Miền Biền ch&iacute;nh x&aacute;c v&agrave; nhanh nhất.</span></p>
            <h2><strong>Thống k&ecirc; đầu đu&ocirc;i l&ocirc; t&ocirc; Miền Bắc l&agrave; g&igrave;?</strong></h2>
            <p><span style="font-weight: 400;">Thống k&ecirc; đầu đu&ocirc;i l&ocirc; t&ocirc; l&agrave; bảng tổng hợp chu kỳ ra đầu đu&ocirc;i của c&aacute;c cặp l&ocirc; t&ocirc; 2 số trong đ&oacute;: đầu l&ocirc; l&agrave; h&agrave;ng chục v&agrave; đu&ocirc;i l&ocirc; l&agrave; h&agrave;ng đơn vị của tất cả c&aacute;c giải thưởng xổ số Miền Bắc về trong ng&agrave;y.</span></p>
            <h2><strong>Lợi &iacute;ch của thống k&ecirc; đầu đu&ocirc;i l&ocirc; t&ocirc; Miền Bắc</strong></h2>
            <p><span style="font-weight: 400;">Đ&acirc;y l&agrave; một c&ocirc;ng cụ hữu &iacute;ch gi&uacute;p bạn t&iacute;nh to&aacute;n nhanh số lần về của to&agrave;n bộ c&aacute;c đầu, đu&ocirc;i xổ số trong giai đoạn m&agrave; bạn lựa chọn. Bạn sẽ dễ d&agrave;ng nhận biết được đầu số n&agrave;o c&oacute; tổng số lần về nhiều nhất, giai đoạn n&agrave;o ''sốt'' của con số đ&oacute;, con số m&agrave; bạn lựa chọn c&oacute; thuộc nh&oacute;m những con số tiềm năng hay kh&ocirc;ng. Từ đ&oacute;, gi&uacute;p bạn sẽ cải thiện cơ hội tr&uacute;ng thưởng của bạn l&ecirc;n rất nhiều.</span></p>
            <p><span style="font-weight: 400;">- T&iacute;nh năng n&agrave;y gi&uacute;p bạn xem được thống k&ecirc; đầu/đu&ocirc;i loto của từng giải theo khoảng thời gian t&ugrave;y chọn hoặc xem thống k&ecirc; theo bi&ecirc;n độ 30 lần, 60 lần v&agrave; 100 lần mở thưởng gần đ&acirc;y nhất.</span></p>
            <p><span style="font-weight: 400;">- Việc kiểm tra thống k&ecirc; đầu đu&ocirc;i sẽ gi&uacute;p bạn c&oacute; thể gh&eacute;p được bộ cầu tốt nhất cho m&igrave;nh trong ng&agrave;y. Tham khảo th&ecirc;m thống k&ecirc; 2 số cuối giải đặc biệt để x&aacute;c định được đầu đu&ocirc;i l&ocirc; t&ocirc; dễ tr&uacute;ng nhất trong c&aacute;c kỳ tiếp theo.</span></p>
            <h2><strong>Hướng dẫn c&aacute;ch xem TK Đầu đu&ocirc;i Loto Miền Bắc</strong></h2>
            <p><strong>Chọn Tỉnh, TP</strong><span style="font-weight: 400;">: Chọn một tỉnh hoặc l&agrave; th&agrave;nh phố m&agrave; bạn cần để xem thống k&ecirc; tần suất ng&agrave;y xuất hiện/chưa xuất hiện đầu đu&ocirc;i v&agrave; dữ liệu sẽ hiển thị kết quả một c&aacute;ch chi tiết l&agrave; ng&agrave;y n&agrave;o xuất hiện gần nhất tr&ecirc;n bảng TK Đầu Đu&ocirc;i Loto.</span></p>
            <p><span style="font-weight: 400;">Chọn Bi&ecirc;n độ: Chọn số ng&agrave;y m&agrave; bạn muốn xem thống k&ecirc; Đầu đu&ocirc;i Loto Miền Bắc.</span></p>
            <p><span style="font-weight: 400;">xosotailoc.vip địa chỉ cung cấp cho bạn những th&ocirc;ng tin uy t&iacute;n, kịp thời mang đến cho bạn những tin mới nhất về xổ số. Truy cập xosotailoc.vip thường xuy&ecirc;n để c&oacute; th&ecirc;m nhiều th&ocirc;ng tin hữu &iacute;ch nh&eacute;!</span></p>
            <p><span style="font-weight: 400;">Tk theo đầu đu&ocirc;i l&ocirc; t&ocirc; Miền Bắc. Bảng thống k&ecirc; theo đầu đu&ocirc;i l&ocirc; t&ocirc;. Xem thống k&ecirc; đầu đu&ocirc;i l&ocirc; t&ocirc; Miền Bắc nhanh ch&oacute;ng, ch&iacute;nh x&aacute;c tại xosotailoc.vip.</span></p>
        </div>
        <script>
        </script>
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
        function getThongKeLo() {
            $("#thongKe").html('<div class="row justify-content-center "><div class="col-md-12" style="text-align: center;padding: 50px 0px"><i class="fas fa-spinner fa-spin"></i> Đang tải dữ liệu...</div></div>');
            var count = $('#count').val();
            var dateEnd = $('#end_date').val();
            var short_name = '{{$short_name}}';
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.post("{{route('tk.dau-duoi-loto-ajax')}}", {
                _token: CSRF_TOKEN,
                count: count,
                dateEnd: dateEnd,
                short_name: short_name,
            }, function (result) {
                var data = $.parseJSON(result);
                console.log(data);
                $("#thongKe").html(data.template);
            });

            $('html, body').animate({
                scrollTop: $("#thongKe").offset().top
            }, 100);
        }
    </script>
@endsection