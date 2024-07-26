
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - {{$_SERVER['HTTP_HOST']}}</title>

    <link rel="shortcut icon" size="48x48" href="/frontend/images/favicon.png">
    <!-- Core css -->
    <link href="/assets/css/app.min.css" rel="stylesheet">
</head>

<body>
<div class="app">
    <div class="container-fluid p-h-0 p-v-20 bg full-height d-flex" style="background-image: url('/assets/images/others/login-3.png')">
        <div class="d-flex flex-column justify-content-between w-100">
            <div class="container d-flex h-100">
                <div class="row align-items-center w-100" style="margin: auto">
                    <div class="col-md-7 col-lg-5 m-h-auto">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between m-b-30">
                                    <img class="img-fluid" style="width:170px;margin: auto" alt="" src="/frontend/images/logo.png">
                                    {{--<h2 class="m-b-0">Đăng Nhập</h2>--}}
                                </div>
                                @include('admin.includes.messages')
                                <form action="{{route('login.post')}}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label class="font-weight-semibold" for="email">Email:</label>
                                        <div class="input-affix">
                                            <i class="prefix-icon anticon anticon-user"></i>
                                            <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-semibold" for="password">Password:</label>
                                        <div class="input-affix m-b-10">
                                            <i class="prefix-icon anticon anticon-lock"></i>
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="checkbox">
                                                <input id="remember" name="remember" type="checkbox" checked="">
                                                <label for="remember">Remember Me</label>
                                            </div>
                                            <button class="btn btn-primary">Đăng nhập</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-none d-md-flex p-h-40 justify-content-between">
                <span class="">© 2023 {{$_SERVER['HTTP_HOST']}}</span>
            </div>
        </div>
    </div>
</div>


<!-- Core Vendors JS -->
<script src="/assets/js/vendors.min.js"></script>

<!-- page js -->

<!-- Core JS -->
<script src="/assets/js/app.min.js"></script>

</body>

</html>