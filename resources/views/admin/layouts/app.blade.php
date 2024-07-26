
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{$_SERVER['HTTP_HOST']}} - Admin Dashboard</title>

    <link rel="shortcut icon" size="48x48" href="/frontend/images/favicon.png">
    <!-- page css -->
    <link href="/assets/vendors/select2/select2.css" rel="stylesheet">
    <link href="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">
    <script src="{{url('frontend/js/jquery.3.4.1.min.js')}}"></script>
    <!-- Core css -->
    <link href="/assets/css/app.min.css" rel="stylesheet">

</head>

<body>
<div class="app">
    <div class="layout">
        <!-- Header START -->
        <div class="header">
            <div class="logo logo-dark">
                <a href="{{route('home')}}">
                    <img style="width: 50px;margin-top: 15px" src="/frontend/images/favicon.png" alt="Logo">
                    <img style="margin-top: 10px;margin-left: 16px;width:45px" class="logo-fold" src="/frontend/images/favicon.png" alt="Logo">
                </a>
            </div>
            <div class="logo logo-white">
                <a href="{{route('home')}}">
                    <img style="width: 170px;margin-top: 15px" src="/frontend/images/favicon.png" alt="Logo">
                    <img style="margin-top: 10px;margin-left: 16px;width:45px" class="logo-fold" src="/frontend/images/favicon.png" alt="Logo">
                </a>
            </div>
            <div class="nav-wrap">
                <ul class="nav-left">
                    <li class="desktop-toggle">
                        <a href="javascript:void(0);">
                            <i class="anticon"></i>
                        </a>
                    </li>
					<li class="desktop-toggle">
                        <form method="POST" action="{{ route('createsitemap') }}">
                    {{ csrf_field() }}
                    <button type="submit">sitemap</button>
                </form>
                    </li>
                    <li class="mobile-toggle">
                        <a href="javascript:void(0);">
                            <i class="anticon"></i>
                        </a>
                    </li>
                </ul>
                <ul class="nav-right">
                    <li class="dropdown dropdown-animated scale-left">
                        <div class="pointer" data-toggle="dropdown">
                            <div class="avatar avatar-image  m-h-10 m-r-15">
                                <img src="/assets/images/avatars/thumb-3.jpg"  alt="">
                            </div>
                        </div>
                        <div class="p-b-15 p-t-20 dropdown-menu pop-profile">
                            <div class="p-h-20 p-b-15 m-b-10 border-bottom">
                                <div class="d-flex m-r-50">
                                    <div class="avatar avatar-lg avatar-image">
                                        <img src="/assets/images/avatars/thumb-3.jpg" alt="">
                                    </div>
                                    <div class="m-l-10">
                                        <p class="m-b-0 text-dark font-weight-semibold">{{ Auth::user()->name }}</p>
                                        <p class="m-b-0 opacity-07">Quản trị viên</p>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('user.changePass') }}" class="dropdown-item d-block p-h-15 p-v-10">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <i class="anticon opacity-04 font-size-16 anticon-user"></i>
                                        <span class="m-l-10">Đổi Mật khẩu</span>
                                    </div>
                                    <i class="anticon font-size-10 anticon-right"></i>
                                </div>
                            </a>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item d-block p-h-15 p-v-10">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <i class="anticon opacity-04 font-size-16 anticon-logout"></i>
                                        <span class="m-l-10">Logout</span>
                                    </div>
                                    <i class="anticon font-size-10 anticon-right"></i>
                                </div>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                    <li>
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#quick-view">
                            <i class="anticon anticon-appstore"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Header END -->

        <!-- Side Nav START -->
        <div class="side-nav">
            <div class="side-nav-inner">
                <ul class="side-nav-menu scrollable">
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="javascript:void(0);">
                                <span class="icon-holder">
                                    <i class="anticon anticon-hdd"></i>
                                </span>
                            <span class="title">Sổ mơ</span>
                                <span class="arrow">
                                    <i class="arrow-icon"></i>
                                </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{route('somo.index')}}">Danh sách sổ mơ</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="javascript:void(0);">
                                <span class="icon-holder">
                                    <i class="anticon anticon-form"></i>
                                </span>
                            <span class="title">Tin tức</span>
                                <span class="arrow">
                                    <i class="arrow-icon"></i>
                                </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{route('news.index')}}">Bài viết</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="{{route('updatekq')}}">
                                <span class="icon-holder">
                                    <i class="anticon anticon-schedule"></i>
                                </span>
                            <span class="title">Cập nhật KQ</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="javascript:void(0);">
                                <span class="icon-holder">
                                    <i class="anticon anticon-team"></i>
                                </span>
                            <span class="title">User</span>
                                <span class="arrow">
                                    <i class="arrow-icon"></i>
                                </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{route('user.index')}}">List User</a>
                            </li>
                            <li>
                                <a href="{{route('user.create')}}">Thêm User</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Side Nav END -->

        <!-- Page Container START -->
        <div class="page-container">

            @yield('content')
            <!-- Footer START -->
            <footer class="footer">
                <div class="footer-content justify-content-between">
                    <p class="m-b-0">Copyright © 2023 {{$_SERVER['HTTP_HOST']}}. All rights reserved.</p>
                </div>
            </footer>
            <!-- Footer END -->

        </div>
        <!-- Page Container END -->

        <!-- Search Start-->
        <div class="modal modal-left fade search" id="search-drawer">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header justify-content-between align-items-center">
                        <h5 class="modal-title">Search</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <i class="anticon anticon-close"></i>
                        </button>
                    </div>
                    <div class="modal-body scrollable">
                        <div class="input-affix">
                            <i class="prefix-icon anticon anticon-search"></i>
                            <input type="text" class="form-control" placeholder="Search">
                        </div>
                        <div class="m-t-30">
                            <h5 class="m-b-20">Files</h5>
                            <div class="d-flex m-b-30">
                                <div class="avatar avatar-cyan avatar-icon">
                                    <i class="anticon anticon-file-excel"></i>
                                </div>
                                <div class="m-l-15">
                                    <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Quater Report.exl</a>
                                    <p class="m-b-0 text-muted font-size-13">by Finance</p>
                                </div>
                            </div>
                            <div class="d-flex m-b-30">
                                <div class="avatar avatar-blue avatar-icon">
                                    <i class="anticon anticon-file-word"></i>
                                </div>
                                <div class="m-l-15">
                                    <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Documentaion.docx</a>
                                    <p class="m-b-0 text-muted font-size-13">by Developers</p>
                                </div>
                            </div>
                            <div class="d-flex m-b-30">
                                <div class="avatar avatar-purple avatar-icon">
                                    <i class="anticon anticon-file-text"></i>
                                </div>
                                <div class="m-l-15">
                                    <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Recipe.txt</a>
                                    <p class="m-b-0 text-muted font-size-13">by The Chef</p>
                                </div>
                            </div>
                            <div class="d-flex m-b-30">
                                <div class="avatar avatar-red avatar-icon">
                                    <i class="anticon anticon-file-pdf"></i>
                                </div>
                                <div class="m-l-15">
                                    <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Project Requirement.pdf</a>
                                    <p class="m-b-0 text-muted font-size-13">by Project Manager</p>
                                </div>
                            </div>
                        </div>
                        <div class="m-t-30">
                            <h5 class="m-b-20">Members</h5>
                            <div class="d-flex m-b-30">
                                <div class="avatar avatar-image">
                                    <img src="/assets/images/avatars/thumb-1.jpg" alt="">
                                </div>
                                <div class="m-l-15">
                                    <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Erin Gonzales</a>
                                    <p class="m-b-0 text-muted font-size-13">UI/UX Designer</p>
                                </div>
                            </div>
                            <div class="d-flex m-b-30">
                                <div class="avatar avatar-image">
                                    <img src="/assets/images/avatars/thumb-2.jpg" alt="">
                                </div>
                                <div class="m-l-15">
                                    <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Darryl Day</a>
                                    <p class="m-b-0 text-muted font-size-13">Software Engineer</p>
                                </div>
                            </div>
                            <div class="d-flex m-b-30">
                                <div class="avatar avatar-image">
                                    <img src="/assets/images/avatars/thumb-3.jpg" alt="">
                                </div>
                                <div class="m-l-15">
                                    <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">Marshall Nichols</a>
                                    <p class="m-b-0 text-muted font-size-13">Data Analyst</p>
                                </div>
                            </div>
                        </div>
                        <div class="m-t-30">
                            <h5 class="m-b-20">News</h5>
                            <div class="d-flex m-b-30">
                                <div class="avatar avatar-image">
                                    <img src="/assets/images/others/img-1.jpg" alt="">
                                </div>
                                <div class="m-l-15">
                                    <a href="javascript:void(0);" class="text-dark m-b-0 font-weight-semibold">5 Best Handwriting Fonts</a>
                                    <p class="m-b-0 text-muted font-size-13">
                                        <i class="anticon anticon-clock-circle"></i>
                                        <span class="m-l-5">25 Nov 2018</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Search End-->

        <!-- Quick View START -->
        <div class="modal modal-right fade quick-view" id="quick-view">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header justify-content-between align-items-center">
                        <h5 class="modal-title">Theme Config</h5>
                    </div>
                    <div class="modal-body scrollable">
                        <div class="m-b-30">
                            <h5 class="m-b-0">Header Color</h5>
                            <p>Config header background color</p>
                            <div class="theme-configurator d-flex m-t-10">
                                <div class="radio">
                                    <input id="header-default" name="header-theme" type="radio" checked value="default">
                                    <label for="header-default"></label>
                                </div>
                                <div class="radio">
                                    <input id="header-primary" name="header-theme" type="radio" value="primary">
                                    <label for="header-primary"></label>
                                </div>
                                <div class="radio">
                                    <input id="header-success" name="header-theme" type="radio" value="success">
                                    <label for="header-success"></label>
                                </div>
                                <div class="radio">
                                    <input id="header-secondary" name="header-theme" type="radio" value="secondary">
                                    <label for="header-secondary"></label>
                                </div>
                                <div class="radio">
                                    <input id="header-danger" name="header-theme" type="radio" value="danger">
                                    <label for="header-danger"></label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div>
                            <h5 class="m-b-0">Side Nav Dark</h5>
                            <p>Change Side Nav to dark</p>
                            <div class="switch d-inline">
                                <input type="checkbox" name="side-nav-theme-toogle" id="side-nav-theme-toogle">
                                <label for="side-nav-theme-toogle"></label>
                            </div>
                        </div>
                        <hr>
                        <div>
                            <h5 class="m-b-0">Folded Menu</h5>
                            <p>Toggle Folded Menu</p>
                            <div class="switch d-inline">
                                <input type="checkbox" name="side-nav-fold-toogle" id="side-nav-fold-toogle">
                                <label for="side-nav-fold-toogle"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Quick View END -->
    </div>
</div>


<!-- Core Vendors JS -->
<script src="/assets/js/vendors.min.js"></script>

<!-- page js -->
<script src="/assets/vendors/select2/select2.min.js"></script>
<script src="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="/assets/vendors/quill/quill.min.js"></script>
<script src="/assets/js/pages/form-elements.js"></script>

<!-- Core JS -->
<script src="/assets/js/app.min.js"></script>

</body>

</html>