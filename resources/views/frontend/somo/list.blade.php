<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app')

@section('title','Sổ mơ - Giải mã giấc mơ - giải mộng chiêm bao Với Xổ Số Tài Lộc')
@section('decription','Sổ mơ Với Xổ Số Tài Lộc- Giải mã giấc mơ ✅ - giải mộng chiêm bao.Bảng tra sổ mơ số đẹp đầy đủ và chính xác nhất. Giấc mơ của bạn có ý nghĩa gì, con số tương ứng ra sao? Chúng tôi sẽ giải mã giúp bạn!')
@section('h1','Sổ mơ - Giải mã giấc mơ - giải mộng chiêm bao Với Xổ Số Tài Lộc')

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
                                itemprop="item" href="{{url()->current()}}"
                                title="Sổ mơ" class="last"><span itemprop="name">Sổ mơ</span>
                            <meta itemprop="position" content="2">
                        </a></li>
                </ol>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="col-l" style="height: auto !important;">
        <div class="box-dream box">
            <h2 class="tit-mien mag0"><strong>Giải mã giấc mơ - giải mộng chiêm bao</strong></h2>

            <div class="search-dream pad10">
                <div class="box-search clearfix">
                    <form id="w0">
                        <span class="bor-1 fl mr-10"><input type="text" id="giacmo" name="giacmo"
                                                      placeholder="Nhập tên giấc mơ"/></span>
                        <button type="button" class="btn-primary" onclick="getSoMo()">Xem kết quả</button>
                    </form>
                </div>
                <div id="SoMoTable">
                    <table>
                        <tbody id="article-list">
                        <tr>
                            <th>STT</th>
                            <th>Chiêm bao thấy</th>
                            <th>Con số giải mã</th>
                        </tr>
                        @php $d=1; @endphp
                        @foreach($somo as $item)
                            <tr>
                                <td class="center">{{$d++}}</td>
                                <td class="center">{{$item->mo}}</td>
                                <td class="center"><span class="red-text bold">{{$item->so}}</span></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="txt-center phantrang">
                        {!! $somo->links('pagination::bootstrap-4') !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="box-content">
            <div class="box-nd">
                <div class="pad10">
                    <p><span style="color:#FF0000"><strong><em>* Lưu ý: Sổ mơ chỉ mang tính chất tham khảo và sử dụng
                                    vào mục đích chơi xổ số lô tô do nhà nước phát hành, không chơi lô đề vì đó là hành
                                    vi trái pháp luật</em></strong></span></p>

                    <h2><strong>Sổ mơ giải mộng theo kinh nghiệm dân gian</strong></h2>
                    
                    <p><span style="font-weight: 400;"><strong>Sổ Mơ</strong>. Giải m&atilde; giấc mơ. Tra cứu những giấc mơ v&agrave; c&aacute;c con số linh nghiệm tại xosotailoc.vip</span></p>
                    <p><span style="font-weight: 400;"><strong><a href="{{route('home')}}" title="XS"><span style="color:#0000FF">Xổ Số Tài Lộc </span></a></strong> nơi tra cứu giấc mơ nhanh ch&oacute;ng, ch&iacute;nh x&aacute;c nhất.</span></p>
                    <h2><strong>Sổ mơ l&agrave; g&igrave;</strong></h2>
                    <p><span style="font-weight: 400;"><a title="Sổ mơ" href="/so-mo"><strong>Sổ mơ</strong></a> l&agrave; bảng để tra cứu những con số may mắn tương ứng với từng hiện tượng giấc mơ cụ thể của mỗi người. Đ&acirc;y l&agrave; một trong những cuốn số tổng hợp chi tiết nhất từ A- Z theo kinh nghiệm d&acirc;n gian, d&ugrave;ng để giải m&atilde; những giấc mơ m&agrave; ta đ&atilde; mơ từ tối h&ocirc;m trước.</span></p>
                    <p><span style="font-weight: 400;">Những con số may mắn n&agrave;y, bạn c&oacute; thể sử dụng như một c&aacute;ch thử vận may để t&igrave;m kiếm sự vui vẻ trong ng&agrave;y h&ocirc;m đ&oacute;. Nhưng bạn h&atilde;y nhớ rằng, chỉ thử vận may v&agrave;o những tr&ograve; chơi được ph&aacute;p luật chấp nhận như v&eacute; số, mua vietlott hoặc chơi l&ocirc; t&ocirc;.</span></p>
                    <h2><strong>Tra cứu giấc mơ v&agrave; những con số linh nghiệm</strong></h2>
                    <p><span style="font-weight: 400;">Sau khi nằm mơ thấy một điều g&igrave; đ&oacute;, nhiều người c&oacute; th&oacute;i quen xem b&oacute;i v&agrave; giải m&atilde; giấc chi&ecirc;m bao của m&igrave;nh theo nhiều nguồn tin tr&ecirc;n mạng, nhưng liệu những đ&aacute;p &aacute;n đ&oacute; c&oacute; được độ ch&iacute;nh x&aacute;c cao hay kh&ocirc;ng?</span></p>
                    <p><span style="font-weight: 400;">Tại <strong><a href="{{route('home')}}" title="XS"><span style="color:#0000FF">Xổ Số Tài Lộc </span></a></strong> những th&ocirc;ng tin về sổ mơ sẽ được tổng hợp một c&aacute;ch cụ thể, chi tiết v&agrave; ch&iacute;nh x&aacute;c nhất th&ocirc;ng qua những nguồn tin chuẩn x&aacute;c. Th&ecirc;m v&agrave;o đ&oacute;, những th&ocirc;ng tin n&agrave;y c&ograve;n được ph&acirc;n t&iacute;ch từ c&aacute;c chuy&ecirc;n gia sẽ gi&uacute;p cho bạn t&igrave;m được c&aacute;c con số tương ứng ch&iacute;nh x&aacute;c nhất.</span></p>
                    <h2><strong>L&agrave;m thế n&agrave;o để tra cứu 2000 giấc mơ nhanh ch&oacute;ng</strong></h2>
                    <p><span style="font-weight: 400;">Để c&oacute; thể tra cứu giấc mơ của bạn tương ứng với những con số n&agrave;o một c&aacute;ch dễ d&agrave;ng, bạn cần thực hiện theo c&aacute;c bước sau đ&acirc;y:</span></p>
                    <p><span style="font-weight: 400;"><strong>- Bước 1: </strong>Nhập từ kh&oacute;a con người, con vật hoặc hiện tượng m&agrave; bạn cần t&igrave;m v&agrave;o mục t&igrave;m kiếm. Sau đ&oacute;, bạn nhấn v&agrave;o T&Igrave;M KIẾM, lưu &yacute; nội dung bạn cần t&igrave;m được r&uacute;t gọn v&agrave; ngắn nhất để gi&uacute;p cho việc tra cứu trở n&ecirc;n dễ d&agrave;ng hơn.</span></p>
                    <p><span style="font-weight: 400;">VD: Bạn nằm ngủ mơ thấy người y&ecirc;u b&ecirc;n nhau th&igrave; chỉ cần nhập NGƯỜI Y&Ecirc;U v&agrave;o &ocirc; t&igrave;m kiếm.</span></p>
                    <p><span style="font-weight: 400;"><strong>- Bước 2: </strong>Sau khi hiện danh s&aacute;ch nội dung li&ecirc;n quan, bạn chọn mục gần nhất với giấc mộng của bạn.</span></p>
                    <p><span style="font-weight: 400;"><strong>VD:</strong> Nhập &ldquo;<strong>NGƯỜI Y&Ecirc;U</strong>&rdquo; th&igrave; sẽ hiện ra</span></p>
                    <ul>
                    <li><span style="font-weight: 400;"> Y&ecirc;u đương&nbsp; 24, 87, 86</span></li>
                    <li><span style="font-weight: 400;">2 . y&ecirc;u&nbsp; 75, 70</span></li>
                    <li>&hellip;.</li>
                    </ul>
                    <p><span style="font-weight: 400;">Bước n&agrave;y bạn c&oacute; thể t&igrave;m xem h&ocirc;m nay mơ thấy người chết, ma, tiền,... đ&aacute;nh con g&igrave;?</span></p>
                    <p><span style="font-weight: 400;"><strong>- Bước 3:</strong> Bạn c&oacute; thể chọn mục 1 hoặc 2 t&ugrave;y theo &yacute; nghĩa m&agrave; m&igrave;nh nhận định.</span></p>
                    <p><span style="font-weight: 400;">Kết quả hiển thị cho bạn biết: Những trường hợp li&ecirc;n quan đến từ m&agrave; bạn chọn c&ugrave;ng c&aacute;c con số tương ứng.</span></p>
                    <p><span style="font-weight: 400;">Nếu người chơi muốn biết &yacute; nghĩa chi tiết của giấc mơ đ&oacute; th&igrave; nhấn v&agrave;o c&aacute;c từ trong cột &ldquo;Chi&ecirc;m bao thấy&rdquo; để b&agrave;i đ&oacute; hiển thị th&ocirc;ng tin giải m&atilde; cụ thể.</span></p>
                    <p><span style="font-weight: 400;">Sổ Mơ. Xem giải m&atilde; giấc mơ v&agrave; những con số may mắn tương ứng nhanh ch&oacute;ng, ch&iacute;nh x&aacute;c tại <strong><a href="{{route('home')}}" title="XS"><span style="color:#0000FF">Xổ Số Tài Lộc </span></a></strong>.</span></p>
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@section('afterJS')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <script type="text/javascript">
        function getSoMo() {
            $("#SoMoTable").html('<div class="row justify-content-center"><div class="col-md-12" style="text-align: center;padding: 50px 0px"><i class="fas fa-spinner fa-spin"></i> Đang tải dữ liệu...</div></div>');
            var giacmo = $('#giacmo').val();
            var numbers = $('#numbers').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.post("{{route('somo-ajax')}}", {
                _token: CSRF_TOKEN,
                giacmo: giacmo,
                numbers: numbers,
            }, function (result) {
                var data = $.parseJSON(result);
                console.log(data);
                $("#SoMoTable").html(data.template);
            });

            $('html, body').animate({
                scrollTop: $("#SoMoTable").offset().top
            }, 100);
        }
    </script>
@endsection
