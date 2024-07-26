<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app_full')

@section('title','Thống kê tần suất lô tô '.$province_name)
@section('decription','Thống kê tần suất lô tô '.$province_name.'. Thống kê tần suất loto siêu chính xác')
@section('h1','Thống kê tần suất lô tô '.$province_name)

@section('content')
    <div class="linkway">
        <div class="main">
            <div class="breadcrumb"><ol itemscope="" itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="/" title="Trang chủ"><span itemprop="name">Trang chủ</span><meta itemprop="position" content="1"></a></li><li> »
                    </li><li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="{{url()->current()}}" title="Thống kê tần suất lô tô {{$province_name}}" class="last"><span itemprop="name">Thống kê tần suất lô tô {{$province_name}}</span><meta itemprop="position" content="2"></a></li>
                </ol></div>
        </div>
    </div>
    <div class="content tktansuat">
        <div class="main clearfix">

            <div class="box statis-loto">
                <h2 class="title-bor mag0">Thống kê tần suất lô tô {{$province_name}}</h2>
                <form id="statistic-form" class="form-horizontal">
                    <div class="form-group drp-container">
                        <label>Chọn tỉnh</label>
                        <select name="selectProvince" id="selectProvince" class="form-control">
                            <option class="text-selected" value="#"
                                    @if($short_name=='mb') selected @endif>Miền Bắc</option>
                            @foreach($provinces as $pro)
                                <option class="text-selected" value="{{route('tk.tan-suat-lo-to',$pro->short_name)}}"
                                        @if($short_name==$pro->short_name) selected @endif>{{$pro->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group field-statisticform-todate">
                        <label class="control-label" for="statisticform-todate">Đến ngày</label>
                        <input type="text" id="end_date" class="form-control" name="StatisticForm[toDate]"
                               value="{{date('d/m/Y')}}">
                    </div>
                    <div class="form-group drp-container">
                        <label>Số ngày</label>
                        <input type="number" class="form-control" name="count" id="count" placeholder="Số ngày: 1-1000" value="40">
                    </div>
                    <div class="txt-center">
                        <button type="button" class="btn btn-danger" onclick="getThongKeLo()">Xem kết quả</button>
                    </div>
                </form>
                <div class="bg_org clearfix pad10-5">
                    <h2 class="title-bor mag0">Chọn bộ số cần thống kê</h2>
                    <div class="clearfix"></div>
                    <div class="overflow pb-0">
                        <div class="scroll">
                            <table id="number_selector"
                                   class="kq-table-hover table table-condensed kqcenter kqbackground border w-100 layout-fixed">
                                <thead>
                                <tr class="info">
                                    <th colspan="11">

                                        <button class="btn btn-default col-sm-2 col-sm-offset-1 active"
                                                onclick="return set_view(0);">
                                            <span class="d-md-block d-none">Tất cả các số </span><span
                                                    class="d-md-none">Tất cả</span>
                                        </button>

                                        <button class="btn btn-default col-sm-2"
                                                onclick="return set_view(1);"><span class="d-md-block d-none">Không
                                                        số
                                                        nào </span><span class="d-md-none">Không chọn</span>
                                        </button>
                                        <button class="btn btn-default col-sm-2"
                                                onclick="return set_view(2);"><span class="d-md-block d-none">Chỉ
                                                        chọn số chẵn </span><span class="d-md-none">Số chẵn</span>
                                        </button>
                                        <button class="btn btn-default col-sm-2"
                                                onclick="return set_view(3);"><span class="d-md-block d-none">Chỉ
                                                        chọn số lẻ </span><span class="d-md-none">Số lẻ</span>
                                        </button>


                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <label id="lb_0">
                                            <input type="checkbox" class="number_indi" value="0" id="cb_0"
                                                   checked=""> 00</label>
                                    </td>
                                    <td>
                                        <label id="lb_1">
                                            <input type="checkbox" class="number_indi" value="1" id="cb_1"
                                                   checked=""> 01</label>
                                    </td>
                                    <td>
                                        <label id="lb_2">
                                            <input type="checkbox" class="number_indi" value="2" id="cb_2"
                                                   checked=""> 02</label>
                                    </td>
                                    <td>
                                        <label id="lb_3">
                                            <input type="checkbox" class="number_indi" value="3" id="cb_3"
                                                   checked=""> 03</label>
                                    </td>
                                    <td>
                                        <label id="lb_4">
                                            <input type="checkbox" class="number_indi" value="4" id="cb_4"
                                                   checked=""> 04</label>
                                    </td>
                                    <td>
                                        <label id="lb_5">
                                            <input type="checkbox" class="number_indi" value="5" id="cb_5"
                                                   checked=""> 05</label>
                                    </td>
                                    <td>
                                        <label id="lb_6">
                                            <input type="checkbox" class="number_indi" value="6" id="cb_6"
                                                   checked=""> 06</label>
                                    </td>
                                    <td>
                                        <label id="lb_7">
                                            <input type="checkbox" class="number_indi" value="7" id="cb_7"
                                                   checked=""> 07</label>
                                    </td>
                                    <td>
                                        <label id="lb_8">
                                            <input type="checkbox" class="number_indi" value="8" id="cb_8"
                                                   checked=""> 08</label>
                                    </td>
                                    <td>
                                        <label id="lb_9">
                                            <input type="checkbox" class="number_indi" value="9" id="cb_9"
                                                   checked=""> 09</label>
                                    </td>
                                    <td class="info">
                                        <button class="btn btn-xs btn-default"
                                                onclick="return set_view(10);"><span class="d-md-block d-none">Đầu 0
                                                    </span><span class="d-md-none">*0</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label id="lb_10">
                                            <input type="checkbox" class="number_indi" value="10" id="cb_10"
                                                   checked=""> 10</label>
                                    </td>
                                    <td>
                                        <label id="lb_11">
                                            <input type="checkbox" class="number_indi" value="11" id="cb_11"
                                                   checked=""> 11</label>
                                    </td>
                                    <td>
                                        <label id="lb_12">
                                            <input type="checkbox" class="number_indi" value="12" id="cb_12"
                                                   checked=""> 12</label>
                                    </td>
                                    <td>
                                        <label id="lb_13">
                                            <input type="checkbox" class="number_indi" value="13" id="cb_13"
                                                   checked=""> 13</label>
                                    </td>
                                    <td>
                                        <label id="lb_14">
                                            <input type="checkbox" class="number_indi" value="14" id="cb_14"
                                                   checked=""> 14</label>
                                    </td>
                                    <td>
                                        <label id="lb_15">
                                            <input type="checkbox" class="number_indi" value="15" id="cb_15"
                                                   checked=""> 15</label>
                                    </td>
                                    <td>
                                        <label id="lb_16">
                                            <input type="checkbox" class="number_indi" value="16" id="cb_16"
                                                   checked=""> 16</label>
                                    </td>
                                    <td>
                                        <label id="lb_17">
                                            <input type="checkbox" class="number_indi" value="17" id="cb_17"
                                                   checked=""> 17</label>
                                    </td>
                                    <td>
                                        <label id="lb_18">
                                            <input type="checkbox" class="number_indi" value="18" id="cb_18"
                                                   checked=""> 18</label>
                                    </td>
                                    <td>
                                        <label id="lb_19">
                                            <input type="checkbox" class="number_indi" value="19" id="cb_19"
                                                   checked=""> 19</label>
                                    </td>
                                    <td class="info">
                                        <button class="btn btn-xs btn-default" onclick="return set_view(11);">
                                            <span class="d-md-block d-none">Đầu 1 </span><span
                                                    class="d-md-none">1*</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label id="lb_20">
                                            <input type="checkbox" class="number_indi" value="20" id="cb_20"
                                                   checked=""> 20</label>
                                    </td>
                                    <td>
                                        <label id="lb_21">
                                            <input type="checkbox" class="number_indi" value="21" id="cb_21"
                                                   checked=""> 21</label>
                                    </td>
                                    <td>
                                        <label id="lb_22">
                                            <input type="checkbox" class="number_indi" value="22" id="cb_22"
                                                   checked=""> 22</label>
                                    </td>
                                    <td>
                                        <label id="lb_23">
                                            <input type="checkbox" class="number_indi" value="23" id="cb_23"
                                                   checked=""> 23</label>
                                    </td>
                                    <td>
                                        <label id="lb_24">
                                            <input type="checkbox" class="number_indi" value="24" id="cb_24"
                                                   checked=""> 24</label>
                                    </td>
                                    <td>
                                        <label id="lb_25">
                                            <input type="checkbox" class="number_indi" value="25" id="cb_25"
                                                   checked=""> 25</label>
                                    </td>
                                    <td>
                                        <label id="lb_26">
                                            <input type="checkbox" class="number_indi" value="26" id="cb_26"
                                                   checked=""> 26</label>
                                    </td>
                                    <td>
                                        <label id="lb_27">
                                            <input type="checkbox" class="number_indi" value="27" id="cb_27"
                                                   checked=""> 27</label>
                                    </td>
                                    <td>
                                        <label id="lb_28">
                                            <input type="checkbox" class="number_indi" value="28" id="cb_28"
                                                   checked=""> 28</label>
                                    </td>
                                    <td>
                                        <label id="lb_29">
                                            <input type="checkbox" class="number_indi" value="29" id="cb_29"
                                                   checked=""> 29</label>
                                    </td>
                                    <td class="info">
                                        <button class="btn btn-xs btn-default"
                                                onclick="return set_view(12);"><span class="d-md-block d-none">Đầu 2
                                                    </span><span class="d-md-none">2*</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label id="lb_30">
                                            <input type="checkbox" class="number_indi" value="30" id="cb_30"
                                                   checked=""> 30</label>
                                    </td>
                                    <td>
                                        <label id="lb_31">
                                            <input type="checkbox" class="number_indi" value="31" id="cb_31"
                                                   checked=""> 31</label>
                                    </td>
                                    <td>
                                        <label id="lb_32">
                                            <input type="checkbox" class="number_indi" value="32" id="cb_32"
                                                   checked=""> 32</label>
                                    </td>
                                    <td>
                                        <label id="lb_33">
                                            <input type="checkbox" class="number_indi" value="33" id="cb_33"
                                                   checked=""> 33</label>
                                    </td>
                                    <td>
                                        <label id="lb_34">
                                            <input type="checkbox" class="number_indi" value="34" id="cb_34"
                                                   checked=""> 34</label>
                                    </td>
                                    <td>
                                        <label id="lb_35">
                                            <input type="checkbox" class="number_indi" value="35" id="cb_35"
                                                   checked=""> 35</label>
                                    </td>
                                    <td>
                                        <label id="lb_36">
                                            <input type="checkbox" class="number_indi" value="36" id="cb_36"
                                                   checked=""> 36</label>
                                    </td>
                                    <td>
                                        <label id="lb_37">
                                            <input type="checkbox" class="number_indi" value="37" id="cb_37"
                                                   checked=""> 37</label>
                                    </td>
                                    <td>
                                        <label id="lb_38">
                                            <input type="checkbox" class="number_indi" value="38" id="cb_38"
                                                   checked=""> 38</label>
                                    </td>
                                    <td>
                                        <label id="lb_39">
                                            <input type="checkbox" class="number_indi" value="39" id="cb_39"
                                                   checked=""> 39</label>
                                    </td>
                                    <td class="info">
                                        <button class="btn btn-xs btn-default"
                                                onclick="return set_view(13);"><span class="d-md-block d-none">Đầu 3
                                                    </span><span class="d-md-none">3*</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label id="lb_40">
                                            <input type="checkbox" class="number_indi" value="40" id="cb_40"
                                                   checked=""> 40</label>
                                    </td>
                                    <td>
                                        <label id="lb_41">
                                            <input type="checkbox" class="number_indi" value="41" id="cb_41"
                                                   checked=""> 41</label>
                                    </td>
                                    <td>
                                        <label id="lb_42">
                                            <input type="checkbox" class="number_indi" value="42" id="cb_42"
                                                   checked=""> 42</label>
                                    </td>
                                    <td>
                                        <label id="lb_43">
                                            <input type="checkbox" class="number_indi" value="43" id="cb_43"
                                                   checked=""> 43</label>
                                    </td>
                                    <td>
                                        <label id="lb_44">
                                            <input type="checkbox" class="number_indi" value="44" id="cb_44"
                                                   checked=""> 44</label>
                                    </td>
                                    <td>
                                        <label id="lb_45">
                                            <input type="checkbox" class="number_indi" value="45" id="cb_45"
                                                   checked=""> 45</label>
                                    </td>
                                    <td>
                                        <label id="lb_46">
                                            <input type="checkbox" class="number_indi" value="46" id="cb_46"
                                                   checked=""> 46</label>
                                    </td>
                                    <td>
                                        <label id="lb_47">
                                            <input type="checkbox" class="number_indi" value="47" id="cb_47"
                                                   checked=""> 47</label>
                                    </td>
                                    <td>
                                        <label id="lb_48">
                                            <input type="checkbox" class="number_indi" value="48" id="cb_48"
                                                   checked=""> 48</label>
                                    </td>
                                    <td>
                                        <label id="lb_49">
                                            <input type="checkbox" class="number_indi" value="49" id="cb_49"
                                                   checked=""> 49</label>
                                    </td>
                                    <td class="info">
                                        <button class="btn btn-xs btn-default"
                                                onclick="return set_view(14);"><span class="d-md-block d-none">Đầu 4
                                                    </span><span class="d-md-none">4*</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label id="lb_50">
                                            <input type="checkbox" class="number_indi" value="50" id="cb_50"
                                                   checked=""> 50</label>
                                    </td>
                                    <td>
                                        <label id="lb_51">
                                            <input type="checkbox" class="number_indi" value="51" id="cb_51"
                                                   checked=""> 51</label>
                                    </td>
                                    <td>
                                        <label id="lb_52">
                                            <input type="checkbox" class="number_indi" value="52" id="cb_52"
                                                   checked=""> 52</label>
                                    </td>
                                    <td>
                                        <label id="lb_53">
                                            <input type="checkbox" class="number_indi" value="53" id="cb_53"
                                                   checked=""> 53</label>
                                    </td>
                                    <td>
                                        <label id="lb_54">
                                            <input type="checkbox" class="number_indi" value="54" id="cb_54"
                                                   checked=""> 54</label>
                                    </td>
                                    <td>
                                        <label id="lb_55">
                                            <input type="checkbox" class="number_indi" value="55" id="cb_55"
                                                   checked=""> 55</label>
                                    </td>
                                    <td>
                                        <label id="lb_56">
                                            <input type="checkbox" class="number_indi" value="56" id="cb_56"
                                                   checked=""> 56</label>
                                    </td>
                                    <td>
                                        <label id="lb_57">
                                            <input type="checkbox" class="number_indi" value="57" id="cb_57"
                                                   checked=""> 57</label>
                                    </td>
                                    <td>
                                        <label id="lb_58">
                                            <input type="checkbox" class="number_indi" value="58" id="cb_58"
                                                   checked=""> 58</label>
                                    </td>
                                    <td>
                                        <label id="lb_59">
                                            <input type="checkbox" class="number_indi" value="59" id="cb_59"
                                                   checked=""> 59</label>
                                    </td>
                                    <td class="info">
                                        <button class="btn btn-xs btn-default"
                                                onclick="return set_view(15);"><span class="d-md-block d-none">Đầu 5
                                                    </span><span class="d-md-none">5*</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label id="lb_60">
                                            <input type="checkbox" class="number_indi" value="60" id="cb_60"
                                                   checked=""> 60</label>
                                    </td>
                                    <td>
                                        <label id="lb_61">
                                            <input type="checkbox" class="number_indi" value="61" id="cb_61"
                                                   checked=""> 61</label>
                                    </td>
                                    <td>
                                        <label id="lb_62">
                                            <input type="checkbox" class="number_indi" value="62" id="cb_62"
                                                   checked=""> 62</label>
                                    </td>
                                    <td>
                                        <label id="lb_63">
                                            <input type="checkbox" class="number_indi" value="63" id="cb_63"
                                                   checked=""> 63</label>
                                    </td>
                                    <td>
                                        <label id="lb_64">
                                            <input type="checkbox" class="number_indi" value="64" id="cb_64"
                                                   checked=""> 64</label>
                                    </td>
                                    <td>
                                        <label id="lb_65">
                                            <input type="checkbox" class="number_indi" value="65" id="cb_65"
                                                   checked=""> 65</label>
                                    </td>
                                    <td>
                                        <label id="lb_66">
                                            <input type="checkbox" class="number_indi" value="66" id="cb_66"
                                                   checked=""> 66</label>
                                    </td>
                                    <td>
                                        <label id="lb_67">
                                            <input type="checkbox" class="number_indi" value="67" id="cb_67"
                                                   checked=""> 67</label>
                                    </td>
                                    <td>
                                        <label id="lb_68">
                                            <input type="checkbox" class="number_indi" value="68" id="cb_68"
                                                   checked=""> 68</label>
                                    </td>
                                    <td>
                                        <label id="lb_69">
                                            <input type="checkbox" class="number_indi" value="69" id="cb_69"
                                                   checked=""> 69</label>
                                    </td>
                                    <td class="info">
                                        <button class="btn btn-xs btn-default"
                                                onclick="return set_view(16);"><span class="d-md-block d-none">Đầu 6
                                                    </span><span class="d-md-none">6*</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label id="lb_70">
                                            <input type="checkbox" class="number_indi" value="70" id="cb_70"
                                                   checked=""> 70</label>
                                    </td>
                                    <td>
                                        <label id="lb_71">
                                            <input type="checkbox" class="number_indi" value="71" id="cb_71"
                                                   checked=""> 71</label>
                                    </td>
                                    <td>
                                        <label id="lb_72">
                                            <input type="checkbox" class="number_indi" value="72" id="cb_72"
                                                   checked=""> 72</label>
                                    </td>
                                    <td>
                                        <label id="lb_73">
                                            <input type="checkbox" class="number_indi" value="73" id="cb_73"
                                                   checked=""> 73</label>
                                    </td>
                                    <td>
                                        <label id="lb_74">
                                            <input type="checkbox" class="number_indi" value="74" id="cb_74"
                                                   checked=""> 74</label>
                                    </td>
                                    <td>
                                        <label id="lb_75">
                                            <input type="checkbox" class="number_indi" value="75" id="cb_75"
                                                   checked=""> 75</label>
                                    </td>
                                    <td>
                                        <label id="lb_76">
                                            <input type="checkbox" class="number_indi" value="76" id="cb_76"
                                                   checked=""> 76</label>
                                    </td>
                                    <td>
                                        <label id="lb_77">
                                            <input type="checkbox" class="number_indi" value="77" id="cb_77"
                                                   checked=""> 77</label>
                                    </td>
                                    <td>
                                        <label id="lb_78">
                                            <input type="checkbox" class="number_indi" value="78" id="cb_78"
                                                   checked=""> 78</label>
                                    </td>
                                    <td>
                                        <label id="lb_79">
                                            <input type="checkbox" class="number_indi" value="79" id="cb_79"
                                                   checked=""> 79</label>
                                    </td>
                                    <td class="info">
                                        <button class="btn btn-xs btn-default"
                                                onclick="return set_view(17);"><span class="d-md-block d-none">Đầu 7
                                                    </span><span class="d-md-none">7*</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label id="lb_80">
                                            <input type="checkbox" class="number_indi" value="80" id="cb_80"
                                                   checked=""> 80</label>
                                    </td>
                                    <td>
                                        <label id="lb_81">
                                            <input type="checkbox" class="number_indi" value="81" id="cb_81"
                                                   checked=""> 81</label>
                                    </td>
                                    <td>
                                        <label id="lb_82">
                                            <input type="checkbox" class="number_indi" value="82" id="cb_82"
                                                   checked=""> 82</label>
                                    </td>
                                    <td>
                                        <label id="lb_83">
                                            <input type="checkbox" class="number_indi" value="83" id="cb_83"
                                                   checked=""> 83</label>
                                    </td>
                                    <td>
                                        <label id="lb_84">
                                            <input type="checkbox" class="number_indi" value="84" id="cb_84"
                                                   checked=""> 84</label>
                                    </td>
                                    <td>
                                        <label id="lb_85">
                                            <input type="checkbox" class="number_indi" value="85" id="cb_85"
                                                   checked=""> 85</label>
                                    </td>
                                    <td>
                                        <label id="lb_86">
                                            <input type="checkbox" class="number_indi" value="86" id="cb_86"
                                                   checked=""> 86</label>
                                    </td>
                                    <td>
                                        <label id="lb_87">
                                            <input type="checkbox" class="number_indi" value="87" id="cb_87"
                                                   checked=""> 87</label>
                                    </td>
                                    <td>
                                        <label id="lb_88">
                                            <input type="checkbox" class="number_indi" value="88" id="cb_88"
                                                   checked=""> 88</label>
                                    </td>
                                    <td>
                                        <label id="lb_89">
                                            <input type="checkbox" class="number_indi" value="89" id="cb_89"
                                                   checked=""> 89</label>
                                    </td>
                                    <td class="info">
                                        <button class="btn btn-xs btn-default"
                                                onclick="return set_view(18);"><span class="d-md-block d-none">Đầu 8
                                                    </span><span class="d-md-none">8*</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label id="lb_90">
                                            <input type="checkbox" class="number_indi" value="90" id="cb_90"
                                                   checked=""> 90</label>
                                    </td>
                                    <td>
                                        <label id="lb_91">
                                            <input type="checkbox" class="number_indi" value="91" id="cb_91"
                                                   checked=""> 91</label>
                                    </td>
                                    <td>
                                        <label id="lb_92">
                                            <input type="checkbox" class="number_indi" value="92" id="cb_92"
                                                   checked=""> 92</label>
                                    </td>
                                    <td>
                                        <label id="lb_93">
                                            <input type="checkbox" class="number_indi" value="93" id="cb_93"
                                                   checked=""> 93</label>
                                    </td>
                                    <td>
                                        <label id="lb_94">
                                            <input type="checkbox" class="number_indi" value="94" id="cb_94"
                                                   checked=""> 94</label>
                                    </td>
                                    <td>
                                        <label id="lb_95">
                                            <input type="checkbox" class="number_indi" value="95" id="cb_95"
                                                   checked=""> 95</label>
                                    </td>
                                    <td>
                                        <label id="lb_96">
                                            <input type="checkbox" class="number_indi" value="96" id="cb_96"
                                                   checked=""> 96</label>
                                    </td>
                                    <td>
                                        <label id="lb_97">
                                            <input type="checkbox" class="number_indi" value="97" id="cb_97"
                                                   checked=""> 97</label>
                                    </td>
                                    <td>
                                        <label id="lb_98">
                                            <input type="checkbox" class="number_indi" value="98" id="cb_98"
                                                   checked=""> 98</label>
                                    </td>
                                    <td>
                                        <label id="lb_99">
                                            <input type="checkbox" class="number_indi" value="99" id="cb_99"
                                                   checked=""> 99</label>
                                    </td>
                                    <td class="info">
                                        <button class="btn btn-xs btn-default"
                                                onclick="return set_view(19);"><span class="d-md-block d-none">Đầu 9
                                                    </span><span class="d-md-none">9*</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="info">
                                    <td>
                                        <button class="btn btn-default" onclick="return set_view(20);">
                                            <span class="d-md-block d-none">Đuôi 0 </span><span
                                                    class="d-md-none">*0</span>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-default" onclick="return set_view(21);">
                                            <span class="d-md-block d-none">Đuôi 1 </span><span
                                                    class="d-md-none">*1</span>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-default" onclick="return set_view(22);">
                                            <span class="d-md-block d-none">Đuôi 2 </span><span
                                                    class="d-md-none">*2</span>
                                        </button>

                                    </td>
                                    <td>
                                        <button class="btn btn-default" onclick="return set_view(23);">

                                            <span class="d-md-block d-none">Đuôi 3 </span><span
                                                    class="d-md-none">*3</span>
                                        </button>


                                    </td>
                                    <td>
                                        <button class="btn btn-default" onclick="return set_view(24);">

                                            <span class="d-md-block d-none">Đuôi 4 </span><span
                                                    class="d-md-none">*4</span>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-default" onclick="return set_view(25);"> <span
                                                    class="d-md-block d-none">Đuôi 5 </span><span
                                                    class="d-md-none">*5</span>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-default" onclick="return set_view(26);"> <span
                                                    class="d-md-block d-none">Đuôi 6 </span><span
                                                    class="d-md-none">*6</span>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-default" onclick="return set_view(27);"> <span
                                                    class="d-md-block d-none">Đuôi 7 </span><span
                                                    class="d-md-none">*7</span>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-default" onclick="return set_view(28);"> <span
                                                    class="d-md-block d-none">Đuôi 8 </span><span
                                                    class="d-md-none">*8</span>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-default" onclick="return set_view(29);"> <span
                                                    class="d-md-block d-none">Đuôi 9 </span><span
                                                    class="d-md-none">*9</span>
                                        </button>
                                    </td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box tk-tansuat" id="tkloto">
                <h2 class="tit-mien bold">Thống kê tần suất lô tô {{$province_name}} trong vòng {{$rollingNumber}} ngày trước {{date('d/m/Y')}}</h2>
                <div class="scoll scoll-noheight">
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="colgiai tk-txloto" id="tk-txloto">
                        <thead id="tk-txloto-head">
                        <tr><th>Bộ số</th>
                            @for ($i =1; $i < $soboso+1; $i++)
                                <th class="nh {{$i-1}}"><a class="num" href="#">{!!$arrayCollect[$i][0]!!}</a></th>
                            @endfor

                        </tr>
                        </thead>
                        <tbody>
                        @for ($i=1; $i < $soboso+1; $i++)
                            @php $ok[$i] = true; @endphp
                        @endfor
                        @for ($j = 1; $j < $rollingNumber; $j++)
                            <tr>
                                <td>{!!$arrayCollect[0][$j]!!}</td>
                                @for ($i =1; $i < $soboso+1; $i++)
                                    @if($arrayCollect[$i][$j][0]!==0)
                                        @php $ok[$i] = false; @endphp
                                        @if($arrayCollect[$i][$j][1]==1)
                                            <td class="c {{$i-1}} c1"> {!!$arrayCollect[$i][$j][0]!!} </td>
                                        @else
                                            <td class="c {{$i-1}} c{!!$arrayCollect[$i][$j][0] + 1!!}"> {!!$arrayCollect[$i][$j][0]!!} </td>
                                        @endif
                                    @else
                                        @if($ok[$i])
                                            <td class="c {{$i-1}} c0"></td>
                                        @else
                                            <td class="c {{$i-1}} c_"></td>
                                        @endif
                                    @endif
                                @endfor
                            </tr>
                        @endfor
                        <tr>
                            <td>
                                Lần
                            </td>
                            @for ($i =1; $i < $soboso+1; $i++)
                                <td class="s rate"><span>{!!$arrayCollect[$i][$rollingNumber+1]!!}</span><span class="hrate" style="height:{!!$arrayCollect[$i][$rollingNumber+1]!!}px"></span></td>
                            @endfor
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="fullscreen fullscreen-note mag10-5 clearfix">
                    <ul class="box-note-table">
                        <li class=" pad5"><strong class="c c2">&nbsp;1&nbsp;</strong>: Về 1 nháy</li>
                        <li class=" pad5"><strong class="c c1">&nbsp;1&nbsp;</strong>: Giải đặc biệt</li>
                        <li class=" pad5"><strong class="c c3">&nbsp;2&nbsp;</strong>: Về 2 nháy</li>
                        <li class=" pad5"><strong class="c c4">&nbsp;3&nbsp;</strong>: Về 3 nháy</li>
                        <li class=" pad5"><strong class="c c5">&nbsp;4&nbsp;</strong>: Về 4 nháy</li>
                    </ul>
                 </div>
            </div>
            <div class="box box-note">
                <div class=" see-more ">
                    <ul class="list-html-link two-column">
                        <li>Xem thống kê <a href="{{route('tk.lo-gan','mb')}}" title="lô gan miền Bắc">lô gan miền Bắc</a>        </li>
                        <li>Xem thêm <a href="#" title="thống kê 2 số cuối giải đặc biệt miền Bắc">thống kê 2 số cuối giải đặc biệt miền Bắc</a></li>
                        <li>Mời bạn <a href="{{route('quay_thu.mb')}}" title="quay thử miền Bắc">quay thử miền Bắc</a></li>
                        <li>Xem kết quả <a href="{{route('xsmb')}}" title="xổ số miền Bắc">xổ số miền Bắc</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('afterJS')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#selectProvince').change(function () {
                let urlChaneg = $('#selectProvince option:selected').val();
                window.location.href = urlChaneg;
            });

        });

        function getThongKeLo() {
            $("#tkloto").html('<div class="row"><div class="col-md-12" style="text-align: center;padding: 50px 0px"><i class="fas fa-spinner fa-spin"></i> Đang tải dữ liệu...</div></div>');
            var short_name = '{{$short_name}}';
            var rollingNumber = $('#count').val();
            var dateEnd = $('#dateEnd').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.post("{{route('tk.tan-suat-lo-to-ajax')}}", {
                _token: CSRF_TOKEN,
                rollingNumber: rollingNumber,
                dateEnd: dateEnd,
                short_name: short_name,
            }, function (result) {
                var data = $.parseJSON(result);
                console.log(data);
                $("#tkloto").html(data.template);

                $('html, body').animate({
                    scrollTop: $("#tkloto").offset().top
                }, 100);
            });
        }
    </script>
@endsection