@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-header">
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="/admincp" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <a class="breadcrumb-item" href="{{route('user.index')}}">Danh sách thành viên</a>
                    <span class="breadcrumb-item active">Đổi Mật khẩu</span>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h2>Đổi Mật khẩu</h2>
                @include('admin.includes.messages')
                <form class="form-horizontal" role="form" method="POST" action="{{ route('user.changePass.post') }}" enctype="multipart/form-data">
                    {{ csrf_field() }} 
                    <div class="modal-body">
                        <div class="form-group{{ $errors->has('password_old') ? ' has-error' : '' }}">
                            <label for="password_old" class="col-xs-2 control-label">Mật khẩu cũ</label>

                            <div class="col-xs-10">
                                <input id="password_old" type="password" class="form-control" name="password_old" required>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-xs-2 control-label">Mật khẩu mới</label>

                            <div class="col-xs-10">
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-xs-2 control-label">Xác nhận mật khẩu</label>

                            <div class="col-xs-10">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label"></label>
                        <div class="col-xs-10">
                            <input type="submit" class="btn btn-success m-r-5" value="Sửa" />
                            <a href="{{route('admin')}}" class="btn btn-danger m-r-5">Thoát</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection