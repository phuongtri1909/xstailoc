<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app')

@section('title','Cách Chèn Nhúng Trực Tiếp Kết Quả Xổ Số Miền Bắc Vào Website/Blog')
@section('decription','Cách Chèn Nhúng Trực Tiếp Kết Quả Xổ Số Miền Bắc Vào Website/Blog của bạn để cập nhật kqxs 1 cách nhanh nhất')
@section('h1','Cách Chèn Nhúng Trực Tiếp Kết Quả Xổ Số Miền Bắc Vào Website/Blog')

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
                                itemprop="item" href="{{url()->current()}}" title="Thống kê nhanh" class="last"><span
                                    itemprop="name">Tạo mã nhúng kết quả xổ số</span>
                            <meta itemprop="position" content="2">
                        </a></li>
                </ol>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="col-l">
        <div class="box tbl-row-hover">
            <h2 class="tit-mien mag0"><strong>Tạo mã nhúng kết quả xổ số</strong></h2>
            <form id="statistic-form" class="form-horizontal">
                <div class="form-group drp-container">
                    <label>Chọn tỉnh</label>
                    <select name="province" id="selectProvince"  class="form-control">
                        <option value="mb">Miền Bắc</option>
                        <option value="mt">Miền Trung</option>
                        <option value="mn">Miền Nam</option>
                        @foreach($provinces as $pro)
                            <option value="{{$pro->id}}">{{$pro->name}}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        <div class="box tbl-row-hover tknhanh" id="MaNhung">
            <h2 class="bg_red pad10-5">Mã nhúng kết quả xổ số {{$province_name}}</h2>
            <div class="pad5">
                <h3><strong>- Mã code nhúng hiển thị kết quả xổ số {{$province_name}} lần quay gần nhất (trực tiếp kết quả xổ số cho lần quay tiếp theo)</strong></h3>
                <p><code><span style="font-weight: 400;">&lt;iframe src="</span><a href="{{$link}}" target="_blank" rel="noopener"><strong>{{$link}}</strong></a><span style="font-weight: 400;">" width="100%" height="<span style="color: #e03e2d;">{{$height}}</span>" frameborder="0" scrolling="yes"&gt;&lt;/iframe&gt;</span></code></p>
                <h3><strong>- Mã code nhúng hiển thị kết quả xổ số {{$province_name}} theo ngày cố định:</strong></h3>
                <p><code><span style="font-weight: 400;">&lt;iframe src="</span><a href="{{$link_ngay}}" target="_blank" rel="noopener"><strong>{{$link_ngay}}</strong></a><span style="font-weight: 400;">" width="100%" height="<span style="color: #e03e2d;">{{$height}}</span>" frameborder="0" scrolling="yes"&gt;&lt;/iframe&gt;</span></code></p>
                <p>Copy mã nguồn trên đây và để vào nơi nào bạn muốn đặt widget trên website của bạn!</p>
                <h2><strong>C&aacute;ch Ch&egrave;n Trực Tiếp Kết Quả Xổ Số Miền Bắc V&agrave;o Website/Blog</strong></h2>
                <p>Ch&egrave;n m&atilde; nh&uacute;ng KQXSMB trực tiếp v&agrave;o website, blog hay bất cứ nền tảng n&agrave;o để gi&uacute;p bạn thu h&uacute;t được đ&ocirc;ng đảo người truy cập v&agrave; mang đến rất nhiều tiện &iacute;ch.</p>
                <h3><strong>M&atilde; nh&uacute;ng kết quả sổ xố miền Bắc l&agrave; g&igrave;?</strong></h3>
                <p><a title="M&atilde; nh&uacute;ng kết quả xổ số" href="/ma-nhung">M&atilde; nh&uacute;ng kết quả xổ số</a> miền Bắc ch&iacute;nh l&agrave; một đoạn code được đưa v&agrave;o b&agrave;i viết. Điều n&agrave;y gi&uacute;p bạn tạo ra ra những hiển thị kết quả xổ số đ&aacute;ng tin cậy tr&ecirc;n website, blog hay bất kỳ nền tảng online n&agrave;o.</p>
                <h3><strong>Ưu điểm khi ch&egrave;n m&atilde; nh&uacute;ng kết quả xổ số miền Bắc</strong></h3>
                <p><strong>Ưu điểm dễ nhận thấy nhất khi ch&egrave;n m&atilde; nh&uacute;ng để hiển thị kết quả xổ số miền Bắc tr&ecirc;n website, blog, c&aacute;c diễn đ&agrave;n l&agrave;:</strong></p>
                <p>- Kết quả hiển thị tr&ecirc;n website trở n&ecirc;n nhanh ch&oacute;ng v&agrave; ch&iacute;nh x&aacute;c hơn</p>
                <p>- Thu h&uacute;t đ&ocirc;ng đảo người d&ugrave;ng tr&ecirc;n trang nhờ khung giờ quay mở thưởng xổ số trực tiếp</p>
                <p>- Bạn c&oacute; thể dễ d&agrave;ng t&ugrave;y chỉnh thời gian cũng như k&ecirc;nh m&agrave; bạn muốn hiển thị kết quả xổ số</p>
                <p>- H&igrave;nh ảnh kết quả xổ số được hiện thị r&otilde; n&eacute;t, chất lượng.</p>
                <p>- Webstie của bạn sẽ tiếp cận được nhiều người d&ugrave;ng hơn.</p>
                <p>- Kh&ocirc;ng mất nhiều thời gian để chỉnh sửa ảnh.</p>
                <h3><strong>C&aacute;ch ch&egrave;n m&atilde; nh&uacute;ng hiện thị KQSXMB v&agrave;o website/ blog chi tiết nhất</strong></h3>
                <p><strong>Bước 1: Truy cập v&agrave;o </strong><strong>website/ blog</strong><strong> </strong></p>
                <p>Đầu ti&ecirc;n, bạn cần truy cập v&agrave;o t&agrave;i khoản admin của website hoặc blog muốn ch&egrave;n m&atilde; code nh&uacute;ng KQSXMB. Sau khi đ&atilde; đăng nhập th&agrave;nh c&ocirc;ng, bạn chọn khu vực m&igrave;nh muốn ch&egrave;n đoạn code như chuy&ecirc;n mục, b&agrave;i viết, m&ocirc; tả,&hellip; Ngo&agrave;i ra, bạn cũng c&oacute; thể tuỳ chỉnh theo m&agrave;u sắc, font chữ ph&ugrave; hợp với trang của bạn.</p>
                <p><strong>Bước 2: Chuyển sang chế độ hiển thị m&atilde; HTML &lt;&gt; Source</strong></p>
                <p>Nếu bạn đang ở chế độ soạn thỏa b&agrave;i viết th&igrave; h&atilde;y chuyển sang chế độ hiển thị HTML &lt;&gt; Source ngay g&oacute;c b&ecirc;n phải tr&ecirc;n khu vực soạn thảo. Điều n&agrave;y gi&uacute;p cho website/ blog của bạn c&oacute; thể dễ d&agrave;ng hiểu được c&aacute;c đoạn m&atilde; code ch&egrave;n v&agrave;o v&agrave; cho ph&eacute;p ch&uacute;ng hiển thị tr&ecirc;n site của m&igrave;nh.</p>
                <p><strong>Bước 3: Ch&egrave;n m&atilde; nh&uacute;ng</strong></p>
                <p>L&uacute;c n&agrave;y, bạn chỉ cần Copy đoạn code m&atilde; nh&uacute;ng KQSXMB v&agrave; d&aacute;n v&agrave;o khu vực cần ch&egrave;n.</p>
                <p><strong>Bước 4: Kiểm tra lại hiển thị v&agrave; lưu</strong></p>
                <p>Sau khi đ&atilde; ch&egrave;n xong đoạn m&atilde; nh&uacute;ng, bạn h&atilde;y chọn lại chế độ hiển thị b&igrave;nh thường để kiểm tra lại bảng kết quả sổ xố miền Bắc vừa cập nhật. H&atilde;y đảm bảo font chữ, m&agrave;u sắc, k&iacute;ch thước,... đ&atilde; được hiển thị đ&uacute;ng với mong muốn của bạn. Nếu chưa đ&uacute;ng, bạn c&oacute; thể chọn lại chế độ hiển thị HTML &lt;&gt; Source để chỉnh sửa cho vừa &yacute;. Cuối c&ugrave;ng, bạn chỉ cần nhấn lưu hoặc cập nhật b&agrave;i viết khi đ&atilde; xuất bản.&nbsp;</p>
                <p>Tr&ecirc;n đ&acirc;y l&agrave; những th&ocirc;ng tin chia sẻ về m&atilde; code nh&uacute;ng kết quả xổ số miền Bắc cũng như c&aacute;ch ch&egrave;n v&ocirc; c&ugrave;ng đơn giản. Ch&uacute;c c&aacute;c bạn sẽ c&oacute; được lượt tương t&aacute;c tốt hơn, tiếp cận nhiều người d&ugrave;ng, tiết kiệm được thời gian v&agrave; thể hiện được sự chuy&ecirc;n nghiệp của m&igrave;nh khi sử dụng m&atilde; nh&uacute;ng của xosotailoc.vip để hiện thị Kết quả xổ số miền Bắc hằng ng&agrave;y.</p>
            </div>
        </div>
    </div>
@endsection

@section('afterJS')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#selectProvince').change(function () {
                getMaNhung();
            });
        });
        function getMaNhung() {
            $("#MaNhung").html('<div class="row justify-content-center "><div class="col-md-12" style="text-align: center;padding: 50px 0px"><i class="fas fa-spinner fa-spin"></i> Đang tải dữ liệu...</div></div>');
            let province_id = $('#selectProvince option:selected').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.post("{{route('ma-nhung-ajax')}}", {
                _token: CSRF_TOKEN,
                province_id: province_id,
            }, function (result) {
                var data = $.parseJSON(result);
                console.log(data);
                $("#MaNhung").html(data.template);
            });
        }
    </script>
@endsection
