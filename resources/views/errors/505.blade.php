@extends('frontend.layouts.app')
@section('title','Rất tiếc, trang bạn yêu cầu không tồn tại')
@section('content')
    <div class="col-l">
        <div class="box">
            <div class="text-center">
                <div class="message-404">
                    Rất tiếc, trang bạn yêu cầu không tồn tại. <br>
                    Vui lòng nhấn vào <a href="{{URL::to('/')}}">GO HOME</a> để quay về trang chủ !
                </div>
            </div>
        </div>
    </div>
@endsection