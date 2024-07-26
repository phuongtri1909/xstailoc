@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-header">
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="/admincp" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <span class="breadcrumb-item active">Danh sách bài viết</span>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h2>Danh sách bài viết</h2>
                @include('admin.includes.messages')
                <div class="form-group text-right">
                    <a href="{{ route('news.create') }}" class="btn btn-success m-r-5 btn-sm">Thêm</a>
                </div>
                <div class="m-t-25">
                    <div class="table-responsive">
                        @if(count($posts))
                            <table class="table table-bordered" id="newsIndex">
                                <thead>
                                <tr>
                                    <th  style="width: 20%">Tiêu đề</th>
                                    <th  style="width: 20%">Mô tả</th>
                                    <th  style="width: 30%">Nội dung</th>
                                    <th  style="width: 15%">Ảnh</th>
                                    <th  style="width: 15%">Chức năng</th>
                                </tr>
                                </thead>
                                <tbody id="bxbCat">
                                @foreach ($posts as $key => $row)
                                    <tr id="row-{{ $row->id }}">
                                        <td>{{ $row->title }}</td>
                                        <td> {{ $row->des }}</td>
                                        <td> {{ substr($row->content,0,200).'...'  }}</td>
                                        <td>
                                            <img src="{{ $row->img }}" width="100px">
                                        </td>
                                        <td>
                                            <a href="{{route('news.edit',$row->id)}}"><i class="fa fa-edit"></i>&nbsp;Sửa</a>&nbsp;-&nbsp;
                                            <a href="javascript:void(0);" data-id="{{ $row->id }}" class="delete"><i class="fa fa-trash-o"></i>&nbsp;Xóa</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="txt-center" style="margin: 10px;padding-bottom: 10px;">
                                {!! $posts->links('pagination::bootstrap-4') !!}
                            </div>
                        @else
                            <h4 class="ml-10 red">Không tồn tại bản ghi nào!</h4>
                        @endif
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
        $('.delete').on('click', function (e) {
            var id = $(this).attr('data-id');
            var url = '/admincp/news/' + id;
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $('#confirm').modal({backdrop: 'static'})
                    .one('click', '#delete', function () {
                        $.ajax({
                            url: url,
                            type: "DELETE",
                            data: {_token:CSRF_TOKEN},
                            success: function (res) {
                                $('#row-' + id).remove();
                            }
                        });
                    });
        });
    </script>
@endsection