@yield('breadcrumb')
<section class="content main clearfix">
    @yield('content')
    <div class="col-center">
        <div class="content-right bullet live_mb">
            <div class="title-r"><a class="bg-blue" title="Xổ số miền bắc" href="{{ route('xsmb') }}">Xổ số miền bắc</a></div>
            <ul>
                <li @if (url()->full() == route('xsmb')) class="active" @endif><a title="Xổ số miền Bắc"
                        href="{{ route('xsmb') }}">Miền Bắc</a>
                    <i class="icon icon_live" style="display: none"><i
                            class="fas fa-spinner fa-pulse text-danger"></i></i>
                    <i class="fas fa-check icon icon_done" style="display: none"></i>
                    <span class="badge icon icon_w" style="display: none">18:05</span>
                </li>
            </ul>

        </div>

        <div class="content-right bullet live_mb">
            <div class="title-r"><a class="bg-blue" title="Xổ số vietlott" href="{{ route('vietlott') }}">Xổ số vietlott</a></div>
            <ul>
                <li @if (url()->full() == route('xsthantai')) class="active" @endif><a href="{{ route('xsthantai') }}">Thần
                        Tài
                    </a></li>
                <li @if (url()->full() == route('dientoan123')) class="active" @endif><a href="{{ route('dientoan123') }}">Điện
                        toán 123
                    </a></li>
                <li @if (url()->full() == route('dientoan6x36')) class="active" @endif><a href="{{ route('dientoan6x36') }}">Điện
                        toán 6x36</a></li>
                {{-- <li @if (url()->full() == route('max3d')) class="active" @endif><a href="#">Max 3D</a> --}}
                {{-- </li> --}}
                {{-- <li @if (url()->full() == route('max3dpro')) class="active" @endif><a href="#">Max 3D --}}
                {{-- Pro --}}
                {{-- </a></li> --}}
                <li @if (url()->full() == route('mega645')) class="active" @endif><a href="{{ route('mega645') }}">Mega
                        6/45</a></li>
                <li @if (url()->full() == route('power655')) class="active" @endif><a href="{{ route('power655') }}">Power
                        6/55
                    </a></li>
            </ul>

        </div>

        <div class="content-right bullet live_mn">
            <div class="title-r"><a class="bg-blue" title="Xổ số miền nam" href="{{ route('xsmn') }}">Xổ số
                    miền nam</a></div>
            <ul>
                @foreach ($mn_province as $pro)
                    @if (strpos($pro->ngay_quay, $day) !== false)
                        <li @if (url()->full() == route('xstinh.tinh', $pro->slug)) class="active" @endif>
                            <a href="{{ route('xstinh.tinh', $pro->slug) }}"
                                title="{{ $pro->name }}">{{ $pro->name }}
                            </a>
                            <i class="icon icon_live" style="display: none"><i
                                    class="fas fa-spinner fa-pulse text-danger"></i></i>
                            <i class="fas fa-check icon icon_done" style="display: none"></i>
                            <span class="badge icon icon_w" style="display: none">16:05</span>
                        </li>
                    @else
                        <li @if (url()->full() == route('xstinh.tinh', $pro->slug)) class="active" @endif><a
                                href="{{ route('xstinh.tinh', $pro->slug) }}"
                                @if (url()->full() == route('xstinh.tinh', $pro->slug)) @else class="list-group-item" @endif
                                title="{{ $pro->name }}">{{ $pro->name }}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>

        <div class="content-right bullet live_mt">
            <div class="title-r"><a class="bg-blue" title="Xổ số miền trung" href="{{ route('xsmt') }}">Xổ
                    số miền trung</a></div>
            <ul>
                @foreach ($mt_province as $pro)
                    @if (strpos($pro->ngay_quay, $day) !== false)
                        <li @if (url()->full() == route('xstinh.tinh', $pro->slug)) class="active" @endif>
                            <a href="{{ route('xstinh.tinh', $pro->slug) }}"
                                title="{{ $pro->name }}">{{ $pro->name }}</a>
                            <i class="icon icon_live" style="display: none"><i
                                    class="fas fa-spinner fa-pulse text-danger"></i></i>
                            <i class="fas fa-check icon icon_done" style="display: none"></i>
                            <span class="badge icon icon_w" style="display: none">17:05</span>
                        </li>
                    @else
                        <li @if (url()->full() == route('xstinh.tinh', $pro->slug)) class="active" @endif><a
                                href="{{ route('xstinh.tinh', $pro->slug) }}"
                                @if (url()->full() == route('xstinh.tinh', $pro->slug)) @else class="list-group-item" @endif
                                title="{{ $pro->name }}">{{ $pro->name }}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="content-right dd-xs">
            <div class="title-r"><a class="bg-blue" href="{{ route('dudoan.xsmb') }}" title="Dự đoán xổ số">Dự
                    đoán xổ số</a></div>
            <ul class="list-news">
                @foreach ($postTK as $item)
                
                    <?php
                    $link = str_replace('xoso.site', 'xstailoc.com', $item->link);
                    
                    ?>
                    <li class="clearfix"><a title="{{ $item->title }}" href="{{ $link }}" class="fl"><img
                                class="mag-r5 fl lazy" width="60" height="33" title="{{ $item->title }}"
                                alt="{{ $item->title }}" src="{{ $item->img }}"
                                data-src="{{ $item->img }}"></a><a href="{{ $link }}"
                            title="{{ $item->title }}">{{ $item->title }}</a></li>
                @endforeach
            </ul>
        </div>
        
    </div>
    <div class="col-right">
        
        <div class="content-right bullet tk-block ">
            <div class="title-r"><a class="bg-blue" title="Thống kê">Quay thử</a></div>
            <ul class="stastic-lotery">
                <li @if (url()->full() == route('quay_thu.mb')) class="active" @endif><a href="{{ route('quay_thu.mb') }}"
                        title="Quay thử miền Bắc">Quay thử miền Bắc</a></li>
                <li @if (url()->full() == route('quay_thu.mt')) class="active" @endif><a
                        href="{{ route('quay_thu.mt') }}" title="Quay thử miền Trung">Quay thử miền Trung</a>
                </li>
                <li @if (url()->full() == route('quay_thu.mn')) class="active" @endif><a href="{{ route('quay_thu.mn') }}"
                        title="Quay thử miền Nam">Quay thử miền Nam</a></li>
            </ul>
        </div>


        {{-- <div class="content-right bullet"> --}}
        {{-- <div class="title-r"><strong>Xổ Số Hôm Nay</strong></div> --}}
        {{-- <div> --}}
        {{-- <ul class="stastic-lotery two-column"> --}}
        {{-- @foreach ($xs_today_mn as $pro) --}}
        {{-- <li><a href="{{route('xstinh.tinh',$pro->slug)}}" --}}
        {{-- title="Xổ số {{$pro->name}}">Xổ số {{$pro->name}} ( 16h10 )</a> --}}
        {{-- </li> --}}
        {{-- @endforeach --}}
        {{-- @foreach ($xs_today_mt as $pro) --}}
        {{-- <li><a href="{{route('xstinh.tinh',$pro->slug)}}" --}}
        {{-- title="Xổ số {{$pro->name}}">Xổ số {{$pro->name}} ( 17h10 )</a> --}}
        {{-- </li> --}}
        {{-- @endforeach --}}
        {{-- <li><a href="{{route('xsmb')}}" title="Xổ số Miền Bắc">Xổ số Miền Bắc ( 18h10 )</a></li> --}}
        {{-- </ul> --}}
        {{-- </div> --}}
        {{-- </div> --}}
        <div class="content-right bullet tk-cau">
            <div class="title-r"><a class="bg-blue" title="Thống kê cầu">Thống kê cầu</a></div>
            <ul class="stastic-lotery">
                <li @if (url()->full() == route('scmb.cau-bach-thu')) class="active" @endif><a
                        href="{{ route('scmb.cau-bach-thu') }}" title="Cầu bạch thủ">Cầu bạch thủ</a></li>
                {{-- <li @if (url()->full() == route('scmb.cau-db')) class="active" @endif><a href="#" title="Cầu lô tô đặc biệt">Cầu lô tô đặc biệt</a> --}}
                {{-- </li> --}}
                <li @if (url()->full() == route('scmb.cau-truot')) class="active" @endif><a href="{{ route('scmb.cau-truot') }}"
                        title="Cầu lô tô trượt">Cầu lô tô trượt</a></li>
                <li @if (url()->full() == route('scmb.cau-loto-2nhay')) class="active" @endif><a
                        href="{{ route('scmb.cau-loto-2nhay') }}" title="Cầu lô tô 2 nháy">Cầu lô tô 2 nháy</a>
                </li>
                <li @if (url()->full() == route('scmb.cau-thu')) class="active" @endif><a href="{{ route('scmb.cau-thu') }}"
                        title="Cầu lô tô theo thứ">Cầu lô tô theo thứ</a>
                </li>
            </ul>
        </div>

        <div class="content-right bullet tk-block">
            <div class="title-r"><a class="bg-blue" title="Thống kê">Thống kê</a></div>
            <ul class="stastic-lotery">
                {{-- <li @if (url()->full() == route('tk.dac-biet', 'mb')) class="active" @endif><a href="#" title="2 số cuối giải đặc biệt">2 số cuối giải đặc biệt</a> --}}
                {{-- </li> --}}
                {{-- <li @if (url()->full() == route('tk.tan-suat-lo-to', 'mb')) class="active" @endif><a href="#" title="Tần suất loto">Tần suất loto</a></li> --}}
                <li @if (url()->full() == route('tk.dac-biet-tuan')) class="active" @endif><a href="{{ route('tk.dac-biet-tuan') }}"
                        title="Bảng đặc biệt tuần">Bảng đặc biệt tuần</a></li>
                <li @if (url()->full() == route('tk.dac-biet-thang')) class="active" @endif><a
                        href="{{ route('tk.dac-biet-thang') }}" title="Bảng đặc biệt tháng">Bảng đặc biệt tháng</a>
                </li>
                <li @if (url()->full() == route('tk.dac-biet-nam')) class="active" @endif><a href="{{ route('tk.dac-biet-nam') }}"
                        title="Bảng đặc biệt năm">Bảng đặc biệt năm</a></li>
                <li @if (url()->full() == route('tk.thong-ke-nhanh')) class="active" @endif><a
                        href="{{ route('tk.thong-ke-nhanh') }}" title="Thống kê nhanh">Thống kê nhanh</a></li>
                <li @if (url()->full() == route('tk.dau-duoi-loto', 'mb')) class="active" @endif><a
                        href="{{ route('tk.dau-duoi-loto', 'mb') }}" title="Đầu đuôi loto">Đầu đuôi loto</a></li>
                <li @if (url()->full() == route('tk.lo-gan', 'mb')) class="active" @endif><a href="{{ route('tk.lo-gan', 'mb') }}"
                        title="lô gan miền Bắc">Lô gan miền Bắc</a></li>
                <li @if (url()->full() == route('tk.lo-gan-mt')) class="active" @endif><a href="{{ route('tk.lo-gan-mt') }}"
                        title="lô gan miền Trung">Lô gan miền Trung</a></li>
                <li @if (url()->full() == route('tk.lo-gan-mn')) class="active" @endif><a href="{{ route('tk.lo-gan-mn') }}"
                        title="lô gan miền Nam">Lô gan miền Nam</a></li>
            </ul>
        </div>
    </div>
</section>
