@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-header">
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="/admincp" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <span class="breadcrumb-item active">Nội dung 
                        @if($htmlContent->key == 'footer')
                            footer
                        @else
                            header
                        @endif
                    </span>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h2>Nội dung
                    @if($htmlContent->key == 'footer')
                        footer
                    @else
                        header
                    @endif
                </h2>
                @include('admin.includes.messages')
                

                <div class="m-t-25">
                    <form action="{{ route('content_html.update', $htmlContent->key) }}" method="POST">
                        @csrf
                        <textarea name="content" id="editor">{{ $htmlContent->content }}</textarea>

                        <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.0/codemirror.min.js"></script>
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.0/codemirror.min.css">
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.0/mode/xml/xml.min.js"></script>

                        <script>
                            var editor = CodeMirror.fromTextArea(document.getElementById("editor"), {
                                mode: "text/html",
                                lineNumbers: true,
                                theme: "default"
                            });
                        </script>

                        <button type="submit">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
