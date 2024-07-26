@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-header">
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="/admincp" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <span class="breadcrumb-item active">Kênh Live Xổ Số</span>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h2>Kênh Live Xổ Số</h2>
                @include('admin.includes.messages')
                <form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST"
                      action="{{route('live.update',$row->id)}}">
                    {{ csrf_field() }}
                    <div class="radio">
                        <input id="radio1" name="isSocket" type="radio" value="1" @if($row->is_socket==1) checked="" @endif>
                        <label for="radio1">Socket Live</label>
                    </div>
                    <div class="radio">
                        <input id="radio2" name="isSocket" type="radio" value="0"  @if($row->is_socket==0) checked="" @endif>
                        <label for="radio2">Ajax Live</label>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label"></label>

                        <div class="col-md-6">
                            <input type="submit" name="insert" class="btn btn-success m-r-5" value="Update"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection