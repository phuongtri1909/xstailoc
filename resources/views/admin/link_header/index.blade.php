@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-header">
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="/admincp" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <span class="breadcrumb-item active">Danh sách liên kết header</span>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h2>Danh sách liên kết header</h2>
                @include('admin.includes.messages')
                <div class="form-group text-right">
                    <button class="btn btn-success m-r-5 btn-sm add-link">Thêm liên kết header</button>
                </div>

                <div class="m-t-25">
                    <div class="table-responsive">
                        @if (count($links))
                            <table class="table table-bordered" id="newsIndex">
                                <thead>
                                    <tr>
                                        <th style="width: 15%">Tiêu đề</th>
                                        <th style="width: 20%">Link</th>
                                        <th style="width: 5%">Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody id="bxbCat">
                                    @foreach ($links as $key => $row)
                                        <tr id="row-{{ $row->id }}" data-id="{{ $row->id }}">
                                            <td>
                                                <input type="text" value="{{ $row->title }}" class="form-control"
                                                    disabled>
                                            </td>
                                            <td>
                                                <input type="text" value="{{ $row->link }}" class="form-control"
                                                    disabled>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0);" class="edit"
                                                    data-id="{{ $row->id }}"><i
                                                        class="fa fa-edit"></i>&nbsp;Sửa</a>&nbsp;-&nbsp;
                                                <a href="javascript:void(0);" class="delete"
                                                    data-id="{{ $row->id }}"><i class="fa fa-trash"></i>&nbsp;Xóa</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h4 class="ml-10 red">Không tồn tại bản ghi nào!</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addLinkModal" tabindex="-1" aria-labelledby="addLinkModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addLinkModalLabel">Thêm liên kết mới</h5>
            </div>
            <div class="modal-body">
                <form id="addLinkForm" action="{{ route('link-header.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                      <label for="linkTitle" class="form-label">Title</label>
                      <input type="text" class="form-control" id="linkTitle" name="title" required>
                      @if ($errors->has('title'))
                          <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                      @endif
                    </div>
                    <div class="mb-3">
                      <label for="linkUrl" class="form-label">Link</label>
                      <input type="url" class="form-control" id="linkUrl" name="link" required>
                      @if ($errors->has('link'))
                          <div class="invalid-feedback">{{ $errors->first('link') }}</div>
                      @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </form>
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
                    <button type="button" data-dismiss="modal" class="btn">Hủy</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="responseModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" id="responseModalBody">
                    <!-- Nội dung thông báo sẽ được cập nhật ở đây -->
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script type="text/javascript">
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('.delete').on('click', function(e) {
            var id = $(this).attr('data-id');
            var url = '/admincp/link-header/' + id;

            $('#confirm').modal({
                    backdrop: 'static'
                })
                .one('click', '#delete', function() {
                    $.ajax({
                        url: url,
                        type: "DELETE",
                        data: {
                            _token: CSRF_TOKEN
                        },
                        success: function(res) {
                            $('#row-' + id).remove();
                        }
                    });
                });
        });

        $('#bxbCat').on('click', '.edit', function() {
            var row = $(this).closest('tr');
            var inputs = row.find('input');
            var editButton = $(this);
            inputs.prop('disabled', false);

            editButton.html('<i class="fa fa-save"></i>&nbsp;Lưu');
            editButton.removeClass('edit').addClass('save');
        });

        $('#bxbCat').on('click', '.save', function() {
            var row = $(this).closest('tr');
            var inputs = row.find('input');
            var saveButton = $(this);
            var id = row.data('id');
            var title = row.find('input').eq(0).val();
            var link = row.find('input').eq(1).val();

         
            $.ajax({
                url: '/admincp/link-header/' + id, 
                type: 'PUT',
                data: {
                    _token: CSRF_TOKEN,
                    title: title,
                    link: link
                },
                success: function(response) {
                  
                    inputs.prop('disabled', true);

                    saveButton.html('<i class="fa fa-edit"></i>&nbsp;Sửa');
                    saveButton.removeClass('save').addClass('edit');

                    $('#responseModalBody').text('Cập nhật thành công.');
                    $('#responseModal').modal('show');
                },
                error: function(xhr, status, error) {
                    var errorMessage = 'Cập nhật thất bại: ';
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        errorMessage = 'Cập nhật thất bại:\n';
                        for (var key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorMessage += errors[key][0] + '\n';
                            }
                        }
                    } else {
                        errorMessage += error;
                    }

                    $('#responseModalBody').text(errorMessage);
                    $('#responseModal').modal('show');
                }
            });
        });

        $('.add-link').on('click', function() {
            $('#addLinkModal').modal('show');
        });
    </script>
@endsection
