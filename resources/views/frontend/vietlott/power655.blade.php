@extends('frontend.layouts.app')
@section('title','Kết quả xổ số Power 6/55 trực tiếp hôm nay')
@section('decription','Kết quả xổ số Power 6/55 cập nhật mới nhất hôm nay, Theo dõi trực tiếp kqxs Power 6/55 hàng ngày nhanh và chính xác.')
@section('h1','Kết quả xổ số Power 6/55 trực tiếp hôm nay')

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
                                itemprop="item" href="{{url()->current()}}" title="XS Power 6/55"
                                class="last"><span itemprop="name">Xổ số Power 6/55</span>
                            <meta itemprop="position" content="2">
                        </a></li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="col-l">
        <ul class="tab-panel tab-3">
            <li><a href="{{route('vietlott')}}">Vietlott</a></li>
            <li><a href="{{route('mega645')}}">Mega 6/45</a></li>
            <li class="active"><a href="{{route('power655')}}">Power 6/55</a></li>
            {{--<li><a href="#">Max 3D</a></li>--}}
            {{--<li><a href="#">Max 3D Pro</a></li>--}}
        </ul>
        @foreach($kqs as $kq_power655)
            <div class="power655 box  mega645">
                <h2 class="tit-mien clearfix">
                    <strong> <a class="title-a"
                                href="{{route('power655')}}"
                                title="Xổ số Power">Xổ số Power 6/55</a> {{getThu($kq_power655->day)}} ngày {{getNgay($kq_power655->date)}}</strong>
                </h2>
                <ul class="results">
                    <li id="load_kq_power_0">
                        <div class="box">
                            <div class="clearfix">
                                <table class="data">
                                    <tbody>
                                    @php $daySo = explode('-', $kq_power655->day_so); $d=1; @endphp
                                    <tr>
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
        @endforeach
        <div class="VietlottResult"></div>
        <input type="hidden" value="2" id="page">
        <input type="hidden" value="{{$lastPage}}" id="last_page">
        <meta name="csrf-token" content="{{ csrf_token() }}"/>

        <div class="bg-viewmore">
            <i class="fas fa-spinner fa-spin loadmoreimg"></i>
            <p class="btn-viewmore">
                <span> <a rel="nofollow" class="btn-see-more magb10" id="xem_them" style="text-align: center" href="javascript:void(0)" title="Xem thêm 7 kết quả XSMB">Xem Thêm</a></span>
            </p>    
        </div>
        <script>
            $(document).ready(function () {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $('#xem_them').click(function (event) {
                    event.preventDefault();
                    var page = parseInt($('#page').val());
                    var last_page = parseInt($('#last_page').val());
                    if (page <= last_page) {
                        $('.loadmoreimg').css('display', 'inline');
                        $('.btn-viewmore').css('display', 'none');
                        $.post("{{route('power655.xem_them')}}", {
                            page: page,
                            _token: CSRF_TOKEN
                        }, function (result) {
                            var data = $.parseJSON(result);
                            $(".VietlottResult").append(data.template);

                            // cập nhật các tham số
                            $('.loadmoreimg').css('display', 'none');
                            $('.btn-viewmore').css('display', 'block');
                            $('#page').val(page + 1);
                            if (page == last_page) {
                                $("#xem_them").hide();
                            }
                        });
                    }
                });
            });
        </script>
    </div>
@endsection