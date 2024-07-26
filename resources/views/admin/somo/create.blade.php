@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-header">
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="/admincp" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <a class="breadcrumb-item" href="{{route('somo.index')}}">Danh sách sổ mơ</a>
                    <span class="breadcrumb-item active">Thêm sổ mơ</span>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h2>Thêm sổ mơ</h2>
                @include('admin.includes.messages')
                <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST"
                      action="{{route('somo.store')}}">
                    {{ csrf_field() }}
                    {{--<div class="form-group">--}}
                        {{--<label class="col-xs-2 control-label">Tiêu đề<span class="required">*</span></label>--}}
                        {{--<div class="col-xs-10">--}}
                            {{--<input type="text" placeholder="Tiêu đề" value="{{ old('title') }}" name="title"--}}
                                   {{--class="form-control" required>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label class="col-xs-2 control-label">Đường dẫn</label>--}}
                        {{--<div class="col-xs-10">--}}
                            {{--<input type="text" placeholder="Đường dẫn" value="{{ old('slug') }}" name="slug"--}}
                                   {{--class="form-control">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class="form-group">
                        <label class="col-xs-2 control-label">Mơ thấy gì?<span class="required">*</span></label>
                        <div class="col-xs-10">
                            <input type="text" placeholder="Mơ thấy gì?" value="{{ old('mo') }}" name="mo"
                                   class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label">Link bài viết</label>
                        <div class="col-xs-10">
                            <input type="text" placeholder="Link bài viết" value="{{ old('link') }}" name="link"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label">Số tương ứng<span class="required">*</span></label>
                        <div class="col-xs-10">
                            <input type="text" placeholder="Số tương ứng" value="{{ old('so') }}" name="so"
                                   class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label">Nội dung</label>
                        <div class="col-xs-10">
                            <textarea rows="20" id="content" name="content" class="form-control my-editor">{!! old('content') !!}</textarea>
                        </div>
                    </div>
                    {{--<div class="form-group">--}}
                        {{--<label for="img" class="col-xs-2 control-label">Ảnh thumb<span class="required"></span></label>--}}
                        {{--<div class="col-xs-10">--}}
                            {{--<div class="input input-icon-left input-file">--}}
                                {{--<input id="thumbnail" class="form-control" style="max-width: 500px;float: left;"  value="{{ old('img') }}" placeholder="Hình ảnh" type="text" name="img">--}}
                                {{--<a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary"  style="margin-left: 10px">--}}
                                    {{--<i class="fa fa-picture-o"></i> Choose--}}
                                {{--</a>--}}
                            {{--</div>--}}
                            {{--<img id="holder" style="margin-top:15px;max-height:100px;">--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="form-group">--}}
                        {{--<label class="col-xs-2 control-label">Meta Title</label>--}}
                        {{--<div class="col-xs-10">--}}
                            {{--<input type="text" placeholder="Meta Title" value="{{ old('meta_title') }}" name="meta_title"--}}
                                   {{--class="form-control">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label class="col-xs-2 control-label">Meta Description</label>--}}
                        {{--<div class="col-xs-10">--}}
                         {{--<textarea id="meta_keyword" rows="3" name="meta_description" placeholder="Meta Description"--}}
                                   {{--class="form-control">{!! old('meta_description') !!}</textarea>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class="form-group">
                        <label class="col-xs-4 control-label"></label>

                        <div class="col-xs-6">
                            <input type="submit" name="insert" class="btn btn-success m-r-5" value="Thêm"/>
                            <a href="{{route('somo.index')}}" class="btn btn-danger m-r-5">Hủy</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    {{--<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
//        var options = {
//            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
//            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
//            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
//            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
//        };
//        CKEDITOR.replace('content', options);

        var route_prefix = "/laravel-filemanager";
        $('#lfm').filemanager('image', {prefix: route_prefix});
    </script>

    <script src="https://cdn.tiny.cloud/1/zdhytotn6didnbv96jldpbc09tz6rra5sizmzx12h3ap5qb5/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        var editor_config = {
            path_absolute : "/",
            selector: 'textarea.my-editor',
            relative_urls: false,
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table directionality",
                "emoticons template paste textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            file_picker_callback : function(callback, value, meta) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
                if (meta.filetype == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.openUrl({
                            url : cmsURL,
                            title : 'Filemanager',
                            width : x * 0.8,
                            height : y * 0.8,
                            resizable : "yes",
                            close_previous : "no",
                            onMessage: (api, message) => {
                            callback(message.content);
            }
            });
            }
        };

        tinymce.init(editor_config);
    </script>

@endsection