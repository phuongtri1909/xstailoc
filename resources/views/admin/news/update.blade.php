@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-header">
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="/admincp" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <a class="breadcrumb-item" href="{{route('news.index')}}">Danh sách bài viết</a>
                    <span class="breadcrumb-item active">Sửa bài viết</span>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h2>Sửa bài viết</h2>
                @include('admin.includes.messages')
                <form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST"
                      action="{{route('news.update',$post->id)}}">
                    {{ csrf_field() }}
                    {{method_field('PATCH')}}
                    <div class="form-group">
                        <label class="col-xs-2 control-label">Tiêu đề<span class="required">*</span></label>

                        <div class="col-xs-10">
                            <input type="text" placeholder="Tiêu đề" value="{{ old('title',$post->title) }}" name="title"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label">Slug<span class="required">*</span></label>

                        <div class="col-xs-10">
                            <input type="text" placeholder="Slug" value="{{ old('slug',$post->slug) }}" name="slug"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label">Mô tả</label>

                        <div class="col-xs-10">
                       <textarea id="des" rows="5" name="des" placeholder="Mô tả"
                                 class="form-control">{!! old('des',$post->des) !!}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label">Nội dung<span class="required">*</span></label>

                        <div class="col-xs-10">
                            <textarea rows="20" id="content" name="content" class="form-control my-editor">{{ old('content',$post->content) }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="img" class="col-xs-2 control-label"></label>
                        <div class="col-xs-10">
                            <img src="{{$post->img}}" width="200px">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="img" class="col-xs-2 control-label">Ảnh thumb<span class="required"></span></label>

                        <div class="col-xs-10">
                            <div class="input input-icon-left input-file">
                                <input id="thumbnail" class="form-control" style="max-width: 500px;float: left;"
                                       value="{{ old('img',$post->img) }}" placeholder="Hình ảnh" type="text"
                                       name="img">
                                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary"
                                   style="margin-left: 10px">
                                    <i class="fa fa-picture-o"></i> Choose
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <img id="holder" src="{{$post->img}}" style="margin-top:5px;max-width: 150px;">
                    </div>

                    <div class="form-group">
                        <label class="col-xs-2 control-label">Meta title</label>

                        <div class="col-xs-10">
                            <input type="text" placeholder="Meta title" value="{{ old('meta_title',$post->meta_title) }}" name="meta_title"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label">Meta description</label>

                        <div class="col-xs-10">
                        <textarea id="meta_description" rows="3" name="meta_description" placeholder="Meta description"
                                  class="form-control">{!! old('meta_description',$post->meta_description) !!}</textarea>
                        </div>
                    </div>
                    {{--<div class="form-group">--}}
                        {{--<label class="col-xs-2 control-label">Meta keyword</label>--}}

                        {{--<div class="col-xs-10">--}}
                        {{--<textarea id="meta_keyword" rows="3" name="meta_keyword" placeholder="Meta keyword"--}}
                                  {{--class="form-control">{!! old('meta_keyword',$post->meta_keyword) !!}</textarea>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <div class="form-group">
                        <label class="col-md-4 control-label"></label>

                        <div class="col-md-6">
                            <input type="submit" name="insert" class="btn btn-success  m-r-5" value="Update"/>
                            <a href="{{route('news.index')}}" class="btn btn-danger  m-r-5">Hủy</a>
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