@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-header">
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="/admincp" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <span class="breadcrumb-item active">Danh sách thành viên</span>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h2>Danh sách thành viên</h2>
                @include('admin.includes.messages')
                <div class="form-group text-right">
                    <a href="{!! route('user.create') !!}" class="btn btn-success m-r-5 btn-sm">Thêm thành viên</a>
                </div>
                <div class="m-t-25">
                    <div class="table-responsive">
                            <p>Có {{$users->total()}} thành viên</p>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10px">STT</th>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>Quyền</th>
                                    <th></th>
                                </tr>  </thead>
                                <tbody>
                                @forelse($users as $key => $user)
                                    <tr id="row-{{ $user->id }}">
                                        <td>{{$key+1}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            @foreach($user->roles as $role)
                                                <span class="badge badge-pill badge-cyan font-size-12">{{$role->name}}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{!! route('user.edit',[$user->id]) !!}" class="btn btn-xs btn-success"><i class="ace-icon fa fa-edit"></i>&nbsp;Sửa</a>
                                            <a class="btn btn-xs btn-danger delete" href="javascript:void(0);" data-id="{{ $user->id }}">
                                                <i class="ace-icon fa fa-trash-o"></i>
                                                Xóa
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <td colspan="9">no users</td>
                                @endforelse
                                </tbody>
                            </table>
                            <div class="txt-center" style="margin: 10px;padding-bottom: 10px;">
                                {!! $users->links('pagination::bootstrap-4') !!}
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="confirm" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">Bạn có muốn xóa ?</div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Xóa</button>
                    <button type="button" data-dismiss="modal" class="btn">Thoát</button>
                </div>
            </div>
        </div>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <script type="text/javascript">
        $('.delete').on('click', function(e){
            var id = $(this).attr('data-id');
            var  url = '/admincp/user/'+id;
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $('#confirm').modal({ backdrop: 'static' })
                    .one('click', '#delete', function() {
                        $.ajax({
                            url: url, //
                            type: "DELETE",
                            data: {_token:CSRF_TOKEN},
                            success: function(res){
                                $('#row-'+id).remove();
                            }
                        });
                    });
        });
    </script>
@endsection