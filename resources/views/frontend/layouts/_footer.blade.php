{{--<link rel="stylesheet" type="text/css" href="{{url('frontend/css/bootstrap.min.css')}}" media="all">--}}
{{--<link rel="stylesheet" type="text/css" href="{{url('frontend/css/main_2.css')}}?v={{rand(1000,100000)}}" media="all">--}}

<footer class="text-center text-lg-start text-muted">
    <!-- Section: Links  -->
    <section class="p-4">
        <div class="container text-center mt-4">
            <!-- Grid row -->
            <div class="row mt-3">
                <!-- Grid column -->
                
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-ft-2 col-12  col-sm-6 col-md-3 col-lg-3 col-fttt">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4 ftr-heading">
                        Kết quả xổ số
                    </h6>
                    <p>
                        <a href="{{route('xsmb')}}" class=" text-reset">
                            <i class="fas fa-circle clor"></i>
                            <span>Xổ số miền Bắc</span>
                        </a>
                    </p>
                    <p>
                        <a href="{{route('xsmt')}}" class="text-reset">
                            <i class="fas fa-circle clor"></i>
                            <span>Xổ số miền Trung</span>
                        </a>
                    </p>
                    <p>
                        <a href="{{route('xsmn')}}" class="text-reset">
                            <i class="fas fa-circle clor"></i>
                            <span>Xổ số miền Nam</span>
                        </a>
                    </p>
                    <p>
                        <a href="{{route('mega645')}}" class="text-reset">
                            <i class="fas fa-circle clor"></i>
                            <span>Mega 645</span>
                        </a>
                    </p>
                    <p>
                        <a href="{{route('power655')}}" class="text-reset">
                            <i class="fas fa-circle clor"></i>
                            <span>Power 655</span>
                        </a>
                    </p>

                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-ft-2 col-12 col-sm-6 col-md-3 col-lg-3 col-fttt">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4 ftr-heading">
                        Tiện ích mở rộng
                    </h6>
                    <p>
                        <a href="{{route('xsmb.skq')}}" class="text-reset">
                            <i class="fas fa-circle clor"></i>
                            <span>Sổ kết quả</span>
                        </a>
                    </p>
                    <p>
                        <a href="{{route('xsmt.skq')}}" class="text-reset">
                            <i class="fas fa-circle clor"></i>
                            <span>Sổ kết quả MT</span>
                        </a>
                    </p>
                    <p>
                        <a href="{{route('xsmn.skq')}}" class="text-reset">
                            <i class="fas fa-circle clor"></i>
                            <span>Sổ kết quả MN</span>
                        </a>
                    </p>
                    <p>
                        <a href="{{route('ma-nhung')}}" class="text-reset">
                            <i class="fas fa-circle clor"></i>
                            <span>Mã nhúng</span>
                        </a>
                    </p>
                    <p>
                        <a href="{{route('quay_thu.mb')}}" class="text-reset">
                            <i class="fas fa-circle clor"></i>
                            <span>Quay thử</span>
                        </a>
                    </p>
                </div>
                <!-- Grid column -->
                <!-- Grid column -->
                <div class="col-ft-2 col-12 col-sm-6 col-md-3 col-lg-3 col-fttt">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4 ftr-heading">Thống kê cầu</h6>
                    <p>
                        <a href="{{route('scmb.cau-bach-thu')}}" class="text-reset">
                            <i class="fas fa-circle clor"></i>
                            <span>Cầu bạch thủ</span>
                        </a>
                    </p>
                    <p>
                        <a href="{{route('scmb.cau-truot')}}" class="text-reset">
                            <i class="fas fa-circle clor"></i>
                            <span>Cầu lô tô trượt</span>
                        </a>
                    </p>
                    <p>
                        <a href="{{route('scmb.cau-loto-2nhay')}}" class="text-reset">
                            <i class="fas fa-circle clor"></i>
                            <span>Cầu lô tô 2 nháy</span>
                        </a>
                    </p>
                    <p>
                        <a href="{{route('scmb.cau-thu')}}" class="text-reset">
                            <i class="fas fa-circle clor"></i>
                            <span>Cầu lô tô theo thứ</span>
                        </a>
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-ft-2 col-12 col-sm-6 col-md-3 col-lg-3 col-fttt">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4 ftr-heading">Thống kê Hot</h6>
                    <p>
                        <a href="{{route('tk.lo-gan','mb')}}" class="text-reset">
                            <i class="fas fa-circle clor"></i>
                            <span>Thống kê loto gan</span>
                        </a>
                    </p>
                    <p>
                        <a href="{{route('tk.thong-ke-nhanh')}}" class="text-reset">
                            <i class="fas fa-circle clor"></i>
                            <span>Thống kê nhanh</span>
                        </a>
                    </p>

                    <p>
                        <a href="{{route('tk.dac-biet-tuan')}}" class="text-reset">
                            <i class="fas fa-circle clor"></i>
                            <span>Bảng đặc biệt tuần</span>
                        </a>
                    </p>
                    <p>
                        <a href="{{route('tk.dac-biet-thang')}}" class="text-reset">
                            <i class="fas fa-circle clor"></i>
                            <span>Bảng đặc biệt tháng</span>
                        </a>
                    </p>
                    <p>
                        <a href="{{route('tk.dac-biet-nam')}}" class="text-reset">
                            <i class="fas fa-circle clor"></i>
                            <span>Bảng đặc biệt năm</span>
                        </a>
                    </p>
                    <p>
                        <a href="{{route('tk.dau-duoi-loto','mb')}}" class="text-reset">
                            <i class="fas fa-circle clor"></i>
                            <span>Đầu đuôi loto</span>
                        </a>
                    </p>
                </div>
                <!-- Grid column -->

            </div>
            <!-- Grid row -->

            <style>
            @keyframes sparkle {
                0% {
                    background-position: 0% 50%;
                }
                50% {
                    background-position: 100% 50%;
                }
                100% {
                    background-position: 0% 50%;
                }
            }
    
            .sparkle {
                background-size: 400% 400%;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                animation: sparkle 3s ease infinite;
            }
    
            </style>
    
            <div class="bg-white container mt-3">
                <div class="text-center">
                    @foreach ($links_footer as $item)
                        <?php
                            // Tạo 3 màu random dạng hex cho gradient
                            $color1 = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                            $color2 = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                            $color3 = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                        ?>
                        <a class="fw-bold sparkle" style="
                            background: linear-gradient(270deg, {{ $color1 }}, {{ $color2 }}, {{ $color3 }});
                            background-size: 400% 400%;
                            -webkit-background-clip: text;
                            -webkit-text-fill-color: transparent;
                            margin-right: 10px;
                            margin-bottom: 10px;
                            display: inline-block;
                            color: #0000008c;
                            " href="{{ $item->link }}">
                            {{ $item->title }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- Section: Links  -->

    <!-- Copyright -->
    <section class="ft-sesion-bt">
        <div class="border-top container py-3 d-flex pt-4 justify-content-between flex-wrap text-left">
            <div class="ft-bt-el">
                <span style="line-height: 40px">Copyright © 2024 <a href="{{ route('home') }}">xosotailoc.vip</a></span><br>
            </div>
        </div>
    </section>
    <!-- Copyright -->
</footer>
<button onclick="xsCommon.goTop()" id="go-top" title="Go to top" class="hidden">&#x2191;</button>


<script src="{{url('frontend/js/jquery-ui.1.12.1.custom.min.js')}}"></script>
<script src="{{url('frontend/js/html2canvas.min.js')}}"></script>
<script src="{{url('frontend/js/daterangepicker.min.js')}}"></script>
<script src="{{url('frontend/js/main.js')}}?v={{rand(1000,100000)}}"></script>
<script src="{{url('frontend/js/xsdp.min.js')}}?v={{rand(1000,100000)}}"></script>
<script src="{{url('frontend/js/lich_quay.js')}}"></script>

@yield('afterJS')
<script>
    $("#searchDateMB").datepicker({
        dateFormat: "dd/mm/yy",
        changeMonth: !0,
        changeYear: !0,
        showAnim: "fold",
        buttonText: !1,
        endDate: '+1d',
        yearRange: "2002:" + ((new Date).getFullYear() + 1),
        onSelect: function (a, o) {
            var s = a.substring(0, 2), i = a.substring(3, 5), r = a.substring(6, 10);
            window.location = document.location.origin + '/xsmb-' + s + "-" + i + "-" + r;
        }
    })
    $("#searchDateMT").datepicker({
        dateFormat: "dd/mm/yy",
        changeMonth: !0,
        changeYear: !0,
        showAnim: "fold",
        buttonText: !1,
        endDate: '+1d',
        yearRange: "2002:" + ((new Date).getFullYear() + 1),
        onSelect: function (a, o) {
            var s = a.substring(0, 2), i = a.substring(3, 5), r = a.substring(6, 10);
            window.location = document.location.origin + '/xsmt-' + s + "-" + i + "-" + r;
        }
    })
    $("#searchDateMN").datepicker({
        dateFormat: "dd/mm/yy",
        changeMonth: !0,
        changeYear: !0,
        showAnim: "fold",
        buttonText: !1,
        endDate: '+1d',
        yearRange: "2002:" + ((new Date).getFullYear() + 1),
        onSelect: function (a, o) {
            var s = a.substring(0, 2), i = a.substring(3, 5), r = a.substring(6, 10);
            window.location = document.location.origin + '/xsmn-' + s + "-" + i + "-" + r;
        }
    })
    $("#start_date,#end_date").datepicker({
        dateFormat: "dd/mm/yy",
        changeMonth: !0,
        changeYear: !0,
        showAnim: "fold",
        buttonText: !1,
        endDate: '+1d',
        yearRange: "2002:" + ((new Date).getFullYear() + 1),
        language: 'vi'
    })
</script>
<script>
    xsdp.init();
    xsdp.lazyLoad();
    function showmnc2(id_mnu2) {
        if (document.getElementById(id_mnu2).style.visibility == 'visible') {
            document.getElementById(id_mnu2).style.visibility = 'hidden';
        } else {
            document.getElementById(id_mnu2).style.visibility = 'visible';
        }
    }
    function showDrawerMenu() {
        document.querySelector('html').classList.toggle('menu-active');
        showmnc2("nav-horizontal");
    }
    expand = function (itemId) {
        Array.from(document.getElementsByClassName('menu-c2')).forEach((e, i) => {
            if (e.id != itemId)
            e.style.display = 'none'
    });
        elm = document.getElementById(itemId);
        elm.style.display = elm.style.display == 'block' ? 'none' : 'block'
    }

//    xsCommon.paragraphStyle(["paragraph", "box-html"]);
</script>
    @php
        $htmlContent = \App\Models\HtmlContent::where('key', 'footer')->first();
    @endphp

    @if ($htmlContent)
        {!! $htmlContent->content !!}
    @endif
 
 
</body>
</html>
