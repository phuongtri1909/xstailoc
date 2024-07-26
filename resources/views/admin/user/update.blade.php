@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-header">
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="/admincp" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <a class="breadcrumb-item" href="{{route('user.index')}}">Danh sách thành viên</a>
                    <span class="breadcrumb-item active">Sửa thông tin thành viên</span>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h2>Sửa thông tin thành viên</h2>
                @include('admin.includes.messages')
                <form class="form-horizontal" role="form" method="POST" action="{{route('user.update',$row->id)}}">
                    {{csrf_field()}}
                    {{method_field('PATCH')}}
                    <input type="hidden" name="id" value="{{$row->id}}">
                    <div class="form-group">
                        <label class="col-xs-2 control-label">Họ & tên</label>
                        <div class="col-xs-10">
                            <input type="text" placeholder="Họ và tên" name="name" value="{{old('name',$row->name)}}" class="form-control" placeholder="Họ và tên">
                        </div>
                    </div><!--form control-->

                    <div class="form-group">
                        <label class="col-xs-2 control-label">Email</label>
                        <div class="col-xs-10">
                            <input type="text" placeholder="Email" name="email" value="{{old('email',$row->email)}}" class="form-control">
                        </div>
                    </div><!--form control-->
                    <div class="form-group">
                        <label class="col-xs-2 control-label">Quyền</label>
                        <div class="col-xs-10">
                            <div class="inline">
                                <select class="select2" name="roles[]" multiple="multiple">
                                    @foreach($allRoles as $role)
                                        <option value="{{$role->id}}" {{in_array($role->id,$role_old)?"selected":""}} name="permission[]" value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div><!--form control-->
                    <div class="form-group">
                        <label class="col-xs-2 control-label"></label>
                        <div class="col-xs-10">
                            <input type="submit" class="btn btn-success m-r-5" value="Sửa" />
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