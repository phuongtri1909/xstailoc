@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-header">
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="/admincp" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <span class="breadcrumb-item active">Cập nhật kết quả</span>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h2>Cập nhật kết quả</h2>
                <div class="m-t-25">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="text-align: center">
                            <tbody>
                            <tr>
                                <th style="text-align: center">Xổ Số</th>
                                <th style="text-align: center">Link cập nhật</th>
                            </tr>

                            <tr>
                                <td>XSMB</td>
                                <td><a href="/get-xsmb" target="_blank"> Lấy KQ XSMB</a></td>
                            </tr>
                            <tr>
                                <td>XSMN</td>
                                <td><a href="/get-xsmn" target="_blank"> Lấy KQ XSMN</a></td>
                            </tr>
                            <tr>
                                <td>XSMT</td>
                                <td><a href="/get-xsmt" target="_blank"> Lấy KQ XSMT</a></td>
                            </tr>
                            <tr>
                                <td>Max3D</td>
                                <td><a href="/get-max3d" target="_blank"> Lấy KQ Max3D</a></td>
                            </tr>
                            <tr>
                                <td>Max3D Pro</td>
                                <td><a href="/get-max3dpro" target="_blank"> Lấy KQ Max3D Pro</a></td>
                            </tr>
                            <tr>
                                <td>Mega645</td>
                                <td><a href="/get-mega645" target="_blank"> Lấy KQ Mega645</a></td>
                            </tr>
                            <tr>
                                <td>Power655</td>
                                <td><a href="/get-power655" target="_blank"> Lấy KQ Power655</a></td>
                            </tr>
                            <tr>
                                <td>Thần Tài 4</td>
                                <td><a href="/get-thanTai4" target="_blank"> Lấy KQ Thần Tài 4</a></td>
                            </tr>
                            <tr>
                                <td>Điện Toán 123</td>
                                <td><a href="/get-dienToan123" target="_blank"> Lấy KQ Điện Toán 123</a></td>
                            </tr>
                            <tr>
                                <td>Điện Toán 636</td>
                                <td><a href="/get-dienToan636" target="_blank"> Lấy KQ Điện Toán 636</a></td>
                            </tr>
                            <tr>
                                <td>Tạo bài viết dự đoán</td>
                                <td><a href="/taodd" target="_blank"> Tạo bài viết dự đoán (10 bài gần nhất 3 miền)</a></td>
                            </tr>
                            </tbody></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection