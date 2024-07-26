<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app')

@section('title', 'Lô gan ' . $province_name . ' - Thống kê lô gan Với Xổ Số Tài Lộc')
@section('decription', 'Lô gan ' . $province_name . ' - Thống kê lô gan Với Xổ Số Tài Lộc - Thống kê các cặp Lô tô gan lâu
    ngày chưa về. Thống kê Xổ số nhanh, chính xác')
@section('keyword', 'lo gan, lô gan, Lô gan ' . $province_name . ', Thống kê lô gan, thong ke lo gan')
@section('h1', 'Lô gan ' . $province_name)
@section('breadcrumb')
    <div class="linkway">
        <div class="main">
            <div class="breadcrumb">
                <ol itemscope="" itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item"
                            href="/" title="Trang chủ"><span itemprop="name">Trang chủ</span>
                            <meta itemprop="position" content="1">
                        </a></li>
                    <li> »
                    </li>
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item"
                            href="{{ route('tk.lo-gan', $short_name) }}" title="Thống kê lô gan {{ $province_name }}"
                            class="last"><span itemprop="name">Thống kê lô gan {{ $province_name }}</span>
                            <meta itemprop="position" content="2">
                        </a></li>
                </ol>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="col-l">
        <ul class="tab-panel tab-auto">
            <li @if ($province->mien == 1) class="active" @endif><a href="{{ route('tk.lo-gan', 'mb') }}"
                    title="Lô gan MB">Lô gan MB</a></li>
            <li @if ($province->mien == 3) class="active" @endif><a href="{{ route('tk.lo-gan-mn') }}"
                    title="Lô gan MN">Lô gan MN</a></li>
            <li @if ($province->mien == 2) class="active" @endif><a href="{{ route('tk.lo-gan-mt') }}"
                    title="Lô gan MT">Lô gan MT</a></li>

        </ul>
        <div class="box tbl-row-hover">
            <h2 class="tit-mien">
                <strong>Thống kê lô tô gan {{ $province_name }} ngày {{ date('d/m/Y') }}</strong>
            </h2>
            <form id="statistic-form" class="form-horizontal">
                <div class="form-group field-statisticform-provinceid">
                    <label class="control-label" for="statisticform-provinceid">Chọn tỉnh</label>
                    <select id="selectProvince" class="form-control" name="selectProvince">
                        <option class="text-selected" value="{{ route('tk.lo-gan', 'mb') }}"
                            @if ($short_name == 'mb') selected @endif>Miền Bắc</option>
                        @foreach ($provinces as $pro)
                            <option class="text-selected" value="{{ route('tk.lo-gan', $pro->short_name) }}"
                                @if ($pro->short_name == $short_name) selected @endif>{{ $pro->name }}</option>
                        @endforeach
                    </select>
                    <div class="help-block"></div>
                </div>
                <div class="form-group field-statisticform-numofday">
                    <label class="control-label" for="statisticform-numofday">Chọn biên độ</label>
                    <select class="form-control" name="count" id="count">
                        @for ($n = 10; $n <= 50; $n++)
                            <option value="{{ $n }}">{{ $n }}</option>
                        @endfor
                    </select>
                    <div class="hint-block">(Số lần mở thưởng gần đây nhất)</div>
                    <div class="help-block"></div>
                </div>
                <div class="txt-center">
                    <button class="btn btn-danger" onclick="getThongKeLo()" type="button"><strong>Xem kết
                            quả</strong></button>
                </div>
            </form>
        </div>

        <div id="thongKeLo_Table">
            <div class="box tbl-row-hover">

                <h2 class="tit-mien bold"><a href="{{ route('tk.lo-gan', $short_name) }}"
                        title="thống kê lô gan {{ $province_name }}" class="title-a">Thống kê lô gan
                        {{ $province_name }}</a> lâu chưa về nhất tính đến ngày hôm nay
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
                            @for ($t = 0; $t < count($ArrayCollect); $t++)
                                @if ($ArrayCollect[$t][2] >= 10)
                                    <tr>
                                        <td><strong class="s18">{{ $ArrayCollect[$t][0] }}</strong></td>
                                        @if (!empty($ArrayCollect[$t][1]))
                                            @if ($short_name == 'mb')
                                                <td><a class="sub-title"
                                                        href="{{ route('xsmb.date', getNgayLink($ArrayCollect[$t][1])) }}"
                                                        title="xổ số {{ $province_name }} ngày {{ getNgay($ArrayCollect[$t][1]) }}">{{ getNgay($ArrayCollect[$t][1]) }}</a>
                                                </td>
                                            @else
                                                <td><a class="sub-title"
                                                        href="{{ route('xstinh.date', [$short_name, getNgayLink($ArrayCollect[$t][1])]) }}"
                                                        title="xổ số {{ $province_name }} ngày {{ getNgay($ArrayCollect[$t][1]) }}">{{ getNgay($ArrayCollect[$t][1]) }}</a>
                                                </td>
                                            @endif
                                        @else
                                            <td></td>
                                        @endif
                                        <td class="s18 clred bold">{{ $ArrayCollect[$t][2] }}</td>

                                        @if (!empty($maxgan))
                                            <td class="s18 clred bold">{{ $maxgan[$ArrayCollect[$t][0]] }}</td>
                                        @else
                                            <td></td>
                                        @endif
                                    </tr>
                                @endif
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box tbl-row-hover clearfix">

                <h2 class="tit-mien bold"><a href="{{ route('tk.lo-gan', $short_name) }}"
                        title="thống kê lô gan {{ $province_name }}" class="title-a">Cặp lô gan {{ $province_name }}</a>
                    lâu chưa về nhất tính đến ngày hôm nay
                </h2>
                <div>
                    <table class="mag0">
                        <tbody>
                            <tr>
                                <th>Cặp số</th>
                                <th>Ngày ra gần đây</th>
                                <th>Số ngày gan</th>
                                <th>Gan cực đại</th>
                            </tr>
                            @for ($t = 0; $t < count($ArrayCollect_cap); $t++)
                                @if ($ArrayCollect_cap[$t][2] >= 3)
                                    <tr>
                                        <td class="s18 bold">
                                            {{ $ArrayCollect_cap[$t][0] }}-{{ lon($ArrayCollect_cap[$t][0]) }}</td>
                                        @if (!empty($ArrayCollect_cap[$t][1]))
                                            @if ($short_name == 'mb')
                                                <td><a class="sub-title"
                                                        href="{{ route('xsmb.date', getNgayLink($ArrayCollect_cap[$t][1])) }}"
                                                        title="xổ số {{ $province_name }} ngày {{ getNgay($ArrayCollect_cap[$t][1]) }}">{{ getNgay($ArrayCollect_cap[$t][1]) }}</a>
                                                </td>
                                            @else
                                                <td><a class="sub-title"
                                                        href="{{ route('xstinh.date', [$short_name, getNgayLink($ArrayCollect_cap[$t][1])]) }}"
                                                        title="xổ số {{ $province_name }} ngày {{ getNgay($ArrayCollect_cap[$t][1]) }}">{{ getNgay($ArrayCollect_cap[$t][1]) }}</a>
                                                </td>
                                            @endif
                                        @else
                                            <td></td>
                                        @endif
                                        <td class="s18 clred bold">{{ $ArrayCollect_cap[$t][2] }}</td>
                                        @if (!empty($maxgan_cap))
                                            <td class="s18 clred bold">{{ $maxgan_cap[$ArrayCollect_cap[$t][0]] }}</td>
                                        @else
                                            <td></td>
                                        @endif
                                    </tr>
                                @endif
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box tbl-row-hover clearfix">
                <h2 class="tit-mien bold"><a href="{{ route('tk.lo-gan', $short_name) }}"
                        title="thống kê lô gan {{ $province_name }}" class="title-a">Gan cực đại {{ $province_name }}</a>
                    các số từ 00-99 từ trước đến nay
                </h2>
                <div>
                    <table class="mag0">
                        <tbody>
                            <tr>
                                <th>Số</th>
                                <th>Gan max</th>
                                <th>Thời gian</th>
                                <th>Ngày về gần đây</th>
                            </tr>
                            @php $d=0; @endphp
                            @foreach ($kqgan as $item)
                                <tr>
                                    <td class="s18 bold">{{ $item->loto }}</td>
                                    <td class="s18 clred bold">{{ $item->max }}</td>
                                    <td class="s18 bold"><b>{{ getNgay($item->date) }}</b> đến
                                        <b>{{ getNgay($item->date_end) }}</b></td>
                                    @if (!empty($logan_arr[$d][1]))
                                        @if ($short_name == 'mb')
                                            <td><a class="sub-title"
                                                    href="{{ route('xsmb.date', getNgayLink($logan_arr[$d][1])) }}"
                                                    title="xổ số {{ $province_name }} ngày {{ getNgay($logan_arr[$d][1]) }}">{{ getNgay($logan_arr[$d][1]) }}</a>
                                            </td>
                                        @else
                                            <td><a class="sub-title"
                                                    href="{{ route('xstinh.date', [$short_name, getNgayLink($logan_arr[$d][1])]) }}"
                                                    title="xổ số {{ $province_name }} ngày {{ getNgay($logan_arr[$d][1]) }}">{{ getNgay($logan_arr[$d][1]) }}</a>
                                            </td>
                                        @endif
                                    @else
                                        <td></td>
                                    @endif
                                </tr>
                                @php $d++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box tbl-row-hover clearfix">
                <h2 class="tit-mien bold"><a href="{{ route('tk.lo-gan', $short_name) }}"
                        title="thống kê lô gan {{ $province_name }}" class="title-a">Gan cực đại
                        {{ $province_name }}</a> các cặp lô từ trước đến nay
                </h2>
                <div>
                    <table class="mag0">
                        <tbody>
                            <tr>
                                <th>Cặp</th>
                                <th>Gan max</th>
                                <th>Thời gian</th>
                                <th>Ngày về gần đây</th>
                            </tr>
                            @php $d=0; @endphp
                            @foreach ($kqgan_cap as $item)
                                <tr>
                                    <td class="s18 bold">{{ $item->loto }}-{{ lon($item->loto) }}</td>
                                    <td class="s18 clred bold">{{ $item->max }}</td>
                                    <td class="s18 bold"><b>{{ getNgay($item->date) }}</b> đến
                                        <b>{{ getNgay($item->date_end) }}</b></td>
                                    @if (!empty($logan_cap_arr[$d][1]))
                                        @if ($short_name == 'mb')
                                            <td><a class="sub-title"
                                                    href="{{ route('xsmb.date', getNgayLink($logan_cap_arr[$d][1])) }}"
                                                    title="xổ số {{ $province_name }} ngày {{ getNgay($logan_cap_arr[$d][1]) }}">{{ getNgay($logan_cap_arr[$d][1]) }}</a>
                                            </td>
                                        @else
                                            <td><a class="sub-title"
                                                    href="{{ route('xstinh.date', [$short_name, getNgayLink($logan_cap_arr[$d][1])]) }}"
                                                    title="xổ số {{ $province_name }} ngày {{ getNgay($logan_cap_arr[$d][1]) }}">{{ getNgay($logan_cap_arr[$d][1]) }}</a>
                                            </td>
                                        @endif
                                    @else
                                        <td></td>
                                    @endif
                                </tr>
                                @php $d++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box tbl-row-hover">
                <h2 class="tit-mien bold">Thống kê giải đặc biệt {{ $province_name }} lâu chưa về nhất tính đến ngày hôm
                    nay</h2>
                <div>
                    <table class="mag0">
                        <tbody>
                            <tr>
                                <th>Số</th>
                                <th>Gan/Ngày</th>
                                <th>Gan Max</th>
                            </tr>
                            @for ($t = 0; $t < count($Array_Boso); $t++)
                                @if ($Array_Boso[$t][1] >= 0)
                                    <tr>
                                        <td class="s18 bold">{{ $Array_Boso[$t][0] }}</td>
                                        <td class="s18 bold"><span class="clred">{{ $Array_Boso[$t][1] }}</span> ngày
                                        </td>
                                        @if (!empty($maxgan_boso))
                                            <td class="s18 bold"><span
                                                    class="clred">{{ $maxgan_boso[$Array_Boso[$t][0]] }}</span> ngày</td>
                                        @else
                                            <td></td>
                                        @endif
                                    </tr>
                                @endif
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box tbl-row-hover">
                <h2 class="tit-mien bold">Thống kê đầu giải đặc biệt {{ $province_name }} lâu chưa ra
                </h2>
                <div>
                    <table class="mag0">
                        <tbody>
                            <tr>
                                <th>Đầu</th>
                                <th>Gan/Ngày</th>
                                <th>Gan Max</th>
                            </tr>
                            @for ($t = 0; $t < count($Array_Dau); $t++)
                                @if ($Array_Dau[$t][1] >= 0)
                                    <tr>
                                        <td class="s18 bold">{{ $Array_Dau[$t][0] }}</td>
                                        <td class="s18 bold"><span class="clred">{{ $Array_Dau[$t][1] }}</span> ngày
                                        </td>
                                        @if (!empty($maxgan_dau))
                                            <td class="s18 bold"><span
                                                    class="clred">{{ $maxgan_dau[$Array_Dau[$t][0]] }}</span> ngày</td>
                                        @else
                                            <td></td>
                                        @endif
                                    </tr>
                                @endif
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box tbl-row-hover">
                <h2 class="tit-mien bold">Thống kê đuôi giải đặc biệt {{ $province_name }} lâu chưa về
                </h2>
                <div class="scoll">
                    <table class="mag0">
                        <tbody>
                            <tr>
                                <th>Đuôi</th>
                                <th>Gan/Ngày</th>
                                <th>Gan Max</th>
                            </tr>
                            @for ($t = 0; $t < count($Array_Duoi); $t++)
                                @if ($Array_Duoi[$t][1] >= 0)
                                    <tr>
                                        <td class="s18 bold">{{ $Array_Duoi[$t][0] }}</td>
                                        <td class="s18 bold"><span class="clred">{{ $Array_Duoi[$t][1] }}</span> ngày
                                        </td>
                                        @if (!empty($maxgan_dau))
                                            <td class="s18 bold"><span
                                                    class="clred">{{ $maxgan_dau[$Array_Duoi[$t][0]] }}</span> ngày</td>
                                        @else
                                            <td></td>
                                        @endif
                                    </tr>
                                @endif
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box tbl-row-hover">
                <h2 class="tit-mien bold">Thống kê tổng giải đặc biệt {{ $province_name }} lâu chưa về
                </h2>
                <div class="scoll">
                    <table class="mag0">
                        <tbody>
                            <tr>
                                <th>Tổng</th>
                                <th>Gan/Ngày</th>
                                <th>Gan Max</th>
                            </tr>
                            @for ($t = 0; $t < count($Array_Tong); $t++)
                                @if ($Array_Tong[$t][1] >= 0)
                                    <tr>
                                        <td class="s18 bold">{{ $Array_Tong[$t][0] }}</td>
                                        <td class="s18 bold"><span class="clred">{{ $Array_Tong[$t][1] }}</span> ngày
                                        </td>
                                        @if (!empty($maxgan_dau))
                                            <td class="s18 bold"><span
                                                    class="clred">{{ $maxgan_dau[$Array_Tong[$t][0]] }}</span> ngày</td>
                                        @else
                                            <td></td>
                                        @endif
                                    </tr>
                                @endif
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="box-content">
            <h2>
                <strong><a href="{{ route('tk.lo-gan', $short_name) }}"
                        title="Lô gan {{ strtoupper($short_name) }}"><span style="color:rgb(0, 0, 255)">Lô gan
                            {{ strtoupper($short_name) }}</span></a>
                </strong> - Thống kê Lô Gan TKLG {{ strtoupper($short_name) }} lâu chưa về,✅&nbsp; Lô gan
                XS{{ strtoupper($short_name) }}. Cặp Số Thành Phố {{ $province_name }} lâu ra nhất,✅&nbsp; Bộ số
                XS{{ strtoupper($short_name) }} lâu chưa ra nhanh và CHUẨN 100%
            </h2>
            <p>Lô gan {{ strtoupper($short_name) }} &nbsp;hôm nay sẽ tổng hợp các cặp số lâu chưa về nhất hiện nay hay còn
                gọi là số vắng {{ $province_name }} trong kết quả&nbsp;mở thưởng thời gian gần nhất tại
                {{ $province_name }} .</p>

            <h2 dir="ltr"><strong>Các thông số trong bảng thống kê lô gan LG {{ $province_name }}:</strong></h2>

            <p dir="ltr">- Cột bộ số: Tổng hợp tất cả các lô đã lên gan của đài {{ $province_name }} , tức là cặp 2
                số cuối của các giải có ít nhất 10 kỳ chưa xuất hiện trong bảng kết quả lô gan của đài
                {{ strtoupper($short_name) }}.</p>

            <p dir="ltr">- Cột 2: ngày ra gần nhất của các cặp số lâu về nhất của đài {{ strtoupper($short_name) }}.
            </p>

            <p dir="ltr">- Cột 3: Số ngày lâu ra của 2 số cuối lô tô của đài {{ strtoupper($short_name) }}.</p>

            <p dir="ltr">- Cột 4:&nbsp;Ngày lô gan cực đại LGCĐ của cặp số đó, điều này giúp cho bạn xác định được
                thời cơ nên nuôi của đài XS {{ $province_name }} : nếu nó khan tiếp cận với số này thì có khả năng sẽ sắp
                xuất hiện trong bảng <strong><a href="{{ route('xstinh.tinh', $province_slug) }}"
                        title="XS{{ strtoupper($short_name) }}"><span style="color:#0000FF">Xổ Số {{ $province_name }}
                        </span></a></strong>.</p>

            <h2 dir="ltr"><strong>Thông số trong bảng thống kê các cặp số lâu về nhất
                    XS{{ strtoupper($short_name) }}:</strong></h2>

            <p dir="ltr">- Cột 1: Tổng hợp theo xuôi và lộn các cặp số lâu về của đài Xổ Số {{ $province_name }}
                trong 100 số từ 00 tới 99.</p>

            <p dir="ltr">- Cột 2: ngày ra gần nhất của các cặp lô CL khan {{ strtoupper($short_name) }} đó.</p>

            <p dir="ltr">- Cột 3: Số ngày lâu ra của 2 số cuối lô tô LT {{ strtoupper($short_name) }}.</p>

            <p dir="ltr">- Cột 4: Ngày gan cực đại của cặp lô tô đó của đài {{ $province_name }}.</p>

            <h2 dir="ltr"><strong>Thông số trong bảng thống kê gan cực đại của đài
                    XS{{ strtoupper($short_name) }}:</strong></h2>

            <p dir="ltr">- Cột 1 và cột 3: Tổng hợp các số được sắp xếp từ 00 tới 99. của
                XS{{ strtoupper($short_name) }}</p>

            <p dir="ltr">- Cột 2 và cột 4: ngày lâu ra nhất của lô thuộc đài {{ $province_name }}.</p>

            <h2 dir="ltr"><strong>Bảng thống kê giải đặc biệt xổ số {{ $province_name }} lâu chưa xuất hiện
                    nhất:</strong></h2>

            <p dir="ltr">- Cột 1: Tổng hợp 2 số cuối GĐB lâu chưa ra của kết quả đài Xổ Số {{ $province_name }}.</p>

            <p dir="ltr">- Cột 2: ngày ra gần nhất của lô đó đài {{ $province_name }}.</p>

            <p dir="ltr">- Cột 3: Số ngày gan đài {{ $province_name }}.</p>

            <h2 dir="ltr"><strong>Thống kê theo đầu (số hàng chục) hoặc đuôi (hàng đơn vị) của đài xổ số
                    {{ $province_name }} lâu chưa ra</strong></h2>

            <p dir="ltr">- Cột 1: Tổng hợp đầu hoặc đuôi của 2 số cuối giải đặc biệt của đài {{ $province_name }}
                được sắp xếp theo thứ tự lâu ra nhất trở xuống.</p>

            <p dir="ltr">- Cột 2: ngày ra gần đây nhất của nó của đài xổ số {{ $province_name }}</p>

            <p dir="ltr">- Cột 3: Số ngày gan của đài {{ $province_name }}.</p>

            <p dir="ltr"><strong>Mời các bạn vào link dưới đây để xem kết quả miền nam KQMN trực tiếp chiều
                    nay:</strong></p>
        </div>
    </div>
@endsection

@section('afterJS')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script type="text/javascript">
        $(document).ready(function() {
            $('#selectProvince').change(function() {
                let urlChaneg = $('#selectProvince option:selected').val();
                window.location.href = urlChaneg;
            });
        });

        function getThongKeLo() {
            $("#thongKeLo_Table").html(
                '<div class="row"><div class="col-md-12" style="text-align: center;padding: 50px 0px"><i class="fas fa-spinner fa-spin"></i> Đang tải dữ liệu...</div></div>'
                );
            var count = $('#count').val();
            var short_name = '{{ $short_name }}';
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.post("{{ route('tk.lo-gan-ajax') }}", {
                _token: CSRF_TOKEN,
                count: count,
                short_name: short_name,
            }, function(result) {
                var data = $.parseJSON(result);
                console.log(data);
                $("#thongKeLo_Table").html(data.template);
            });
        }
    </script>
@endsection
