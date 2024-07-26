@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-header">
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="/admincp" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <a class="breadcrumb-item" href="{{route('user.index')}}">Danh sách thành viên</a>
                    <span class="breadcrumb-item active">Thêm thành viên</span>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h2>Thêm thành viên</h2>
                @include('admin.includes.messages')
                <form class="form-horizontal" role="form" method="POST" action="{{route('user.store')}}">
                    {{ csrf_field() }}
                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="col-xs-2 control-label">Họ tên<span class="required">*</span></label>
                        <div class="col-xs-10">
                            <input type="text" placeholder="Họ và tên"  value="{{ old('name') }}" name="name"   class="form-control">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div><!--form control-->

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="col-xs-2 control-label">Email<span class="required">*</span></label>
                        <div class="col-xs-10">
                            <input type="text" placeholder="Email"  value="{{ old('email') }}" name="email"   class="form-control">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-xs-2 control-label">Password<span class="required">*</span></label>

                        <div class="col-xs-10">
                            <input id="password" placeholder="Password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="col-xs-2 control-label">Confirm Password<span class="required">*</span></label>

                        <div class="col-xs-10">
                            <input id="password-confirm" placeholder="Confirm Password" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label">Quyền<span class="required">*</span></label>
                        <div class="col-xs-10">
                            <select class="select2" name="roles[]" placeholder="Chọn quyền"  multiple="multiple">
                                @foreach($role as $r)
                                    <option value="{{$r->id}}">{{$r->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><!--form control-->
                    <div class="form-group">
                        <label class="col-xs-2 control-label"></label>
                        <div class="col-xs-10">
                            <input type="submit" class="btn btn-success m-r-5" value="Thêm" />
                            <a href="{{route('user.index')}}" class="btn btn-danger m-r-5">Thoát</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- page css -->
    <link href="assets/vendors/select2/select2.css" rel="stylesheet">

    <!-- page js -->
    <script src="assets/vendors/select2/select2.min.js"></script>

<script>
    $('.select2').select2();
</script>
@endsection