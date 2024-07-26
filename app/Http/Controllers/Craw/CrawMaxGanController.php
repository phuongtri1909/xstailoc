<?php

namespace App\Http\Controllers\Craw;

use App\Models\Province;
use App\Models\LotoGan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CrawMaxGanController extends Controller
{
    public function getAll()
    {
        $str='<table width="100%" border="0" style="margin:0 auto" class="tbView tbcenter">
 <tr class="back_ccc">
									<td>00</td>
									<td>28 ngày</td>
									<td>Từ: 10-07-2018 Đến: 08-08-2018</td></tr><tr>
									<td>01</td>
									<td>24 ngày</td>
									<td>Từ: 05-03-2018 Đến: 30-03-2018</td></tr><tr class="back_ccc">
									<td>02</td>
									<td>22 ngày</td>
									<td>Từ: 03-07-2017 Đến: 26-07-2017</td></tr><tr>
									<td>03</td>
									<td>27 ngày</td>
									<td>Từ: 22-05-2012 Đến: 19-06-2012</td></tr><tr class="back_ccc">
									<td>04</td>
									<td>34 ngày</td>
									<td>Từ: 23-11-2016 Đến: 28-12-2016</td></tr><tr>
									<td>05</td>
									<td>26 ngày</td>
									<td>Từ: 27-12-2013 Đến: 23-01-2014</td></tr><tr class="back_ccc">
									<td>06</td>
									<td>25 ngày</td>
									<td>Từ: 17-08-2008 Đến: 12-09-2008</td></tr><tr>
									<td>07</td>
									<td>28 ngày</td>
									<td>Từ: 28-07-2013 Đến: 26-08-2013</td></tr><tr class="back_ccc">
									<td>08</td>
									<td>27 ngày</td>
									<td>Từ: 25-04-2010 Đến: 23-05-2010</td></tr><tr>
									<td>09</td>
									<td>26 ngày</td>
									<td>Từ: 15-07-2008 Đến: 11-08-2008</td></tr><tr class="back_ccc">
									<td>10</td>
									<td>33 ngày</td>
									<td>Từ: 07-12-2016 Đến: 10-01-2017</td></tr><tr>
									<td>11</td>
									<td>27 ngày</td>
									<td>Từ: 28-06-2018 Đến: 26-07-2018</td></tr><tr class="back_ccc">
									<td>12</td>
									<td>25 ngày</td>
									<td>Từ: 10-06-2008 Đến: 06-07-2008</td></tr><tr>
									<td>13</td>
									<td>25 ngày</td>
									<td>Từ: 16-12-2012 Đến: 11-01-2013</td></tr><tr class="back_ccc">
									<td>14</td>
									<td>25 ngày</td>
									<td>Từ: 03-06-2017 Đến: 29-06-2017</td></tr><tr>
									<td>15</td>
									<td>23 ngày</td>
									<td>Từ: 19-10-2011 Đến: 12-11-2011</td></tr><tr class="back_ccc">
									<td>16</td>
									<td>21 ngày</td>
									<td>Từ: 22-02-2010 Đến: 16-03-2010</td></tr><tr>
									<td>17</td>
									<td>29 ngày</td>
									<td>Từ: 20-08-2017 Đến: 19-09-2017</td></tr><tr class="back_ccc">
									<td>18</td>
									<td>30 ngày</td>
									<td>Từ: 16-09-2015 Đến: 17-10-2015</td></tr><tr>
									<td>19</td>
									<td>26 ngày</td>
									<td>Từ: 18-04-2009 Đến: 15-05-2009</td></tr><tr class="back_ccc">
									<td>20</td>
									<td>25 ngày</td>
									<td>Từ: 03-10-2010 Đến: 29-10-2010</td></tr><tr>
									<td>21</td>
									<td>28 ngày</td>
									<td>Từ: 10-05-2016 Đến: 08-06-2016</td></tr><tr class="back_ccc">
									<td>22</td>
									<td>24 ngày</td>
									<td>Từ: 06-10-2016 Đến: 31-10-2016</td></tr><tr>
									<td>23</td>
									<td>29 ngày</td>
									<td>Từ: 12-04-2008 Đến: 12-05-2008</td></tr><tr class="back_ccc">
									<td>24</td>
									<td>25 ngày</td>
									<td>Từ: 01-05-2015 Đến: 27-05-2015</td></tr><tr>
									<td>25</td>
									<td>24 ngày</td>
									<td>Từ: 04-02-2013 Đến: 05-03-2013</td></tr><tr class="back_ccc">
									<td>26</td>
									<td>28 ngày</td>
									<td>Từ: 25-05-2017 Đến: 23-06-2017</td></tr><tr>
									<td>27</td>
									<td>24 ngày</td>
									<td>Từ: 20-02-2012 Đến: 16-03-2012</td></tr><tr class="back_ccc">
									<td>28</td>
									<td>30 ngày</td>
									<td>Từ: 15-07-2015 Đến: 15-08-2015</td></tr><tr>
									<td>29</td>
									<td>25 ngày</td>
									<td>Từ: 14-03-2017 Đến: 09-04-2017</td></tr><tr class="back_ccc">
									<td>30</td>
									<td>29 ngày</td>
									<td>Từ: 10-09-2015 Đến: 10-10-2015</td></tr><tr>
									<td>31</td>
									<td>38 ngày</td>
									<td>Từ: 22-06-2013 Đến: 31-07-2013</td></tr><tr class="back_ccc">
									<td>32</td>
									<td>23 ngày</td>
									<td>Từ: 15-03-2012 Đến: 08-04-2012</td></tr><tr>
									<td>33</td>
									<td>30 ngày</td>
									<td>Từ: 18-06-2010 Đến: 19-07-2010</td></tr><tr class="back_ccc">
									<td>34</td>
									<td>23 ngày</td>
									<td>Từ: 25-03-2018 Đến: 18-04-2018</td></tr><tr>
									<td>35</td>
									<td>35 ngày</td>
									<td>Từ: 19-04-2018 Đến: 25-05-2018</td></tr><tr class="back_ccc">
									<td>36</td>
									<td>27 ngày</td>
									<td>Từ: 13-11-2016 Đến: 11-12-2016</td></tr><tr>
									<td>37</td>
									<td>23 ngày</td>
									<td>Từ: 24-06-2018 Đến: 18-07-2018</td></tr><tr class="back_ccc">
									<td>38</td>
									<td>26 ngày</td>
									<td>Từ: 03-07-2016 Đến: 30-07-2016</td></tr><tr>
									<td>39</td>
									<td>38 ngày</td>
									<td>Từ: 17-06-2014 Đến: 26-07-2014</td></tr><tr class="back_ccc">
									<td>40</td>
									<td>26 ngày</td>
									<td>Từ: 01-10-2018 Đến: 28-10-2018</td></tr><tr>
									<td>41</td>
									<td>22 ngày</td>
									<td>Từ: 31-01-2015 Đến: 27-02-2015</td></tr><tr class="back_ccc">
									<td>42</td>
									<td>25 ngày</td>
									<td>Từ: 25-08-2017 Đến: 20-09-2017</td></tr><tr>
									<td>43</td>
									<td>30 ngày</td>
									<td>Từ: 31-07-2010 Đến: 31-08-2010</td></tr><tr class="back_ccc">
									<td>44</td>
									<td>30 ngày</td>
									<td>Từ: 29-04-2016 Đến: 30-05-2016</td></tr><tr>
									<td>45</td>
									<td>34 ngày</td>
									<td>Từ: 12-01-2013 Đến: 20-02-2013</td></tr><tr class="back_ccc">
									<td>46</td>
									<td>28 ngày</td>
									<td>Từ: 02-01-2013 Đến: 31-01-2013</td></tr><tr>
									<td>47</td>
									<td>29 ngày</td>
									<td>Từ: 04-12-2016 Đến: 03-01-2017</td></tr><tr class="back_ccc">
									<td>48</td>
									<td>27 ngày</td>
									<td>Từ: 08-08-2016 Đến: 05-09-2016</td></tr><tr>
									<td>49</td>
									<td>23 ngày</td>
									<td>Từ: 03-11-2015 Đến: 27-11-2015</td></tr><tr class="back_ccc">
									<td>50</td>
									<td>26 ngày</td>
									<td>Từ: 26-08-2018 Đến: 22-09-2018</td></tr><tr>
									<td>51</td>
									<td>25 ngày</td>
									<td>Từ: 06-10-2015 Đến: 01-11-2015</td></tr><tr class="back_ccc">
									<td>52</td>
									<td>21 ngày</td>
									<td>Từ: 12-03-2015 Đến: 03-04-2015</td></tr><tr>
									<td>53</td>
									<td>23 ngày</td>
									<td>Từ: 26-07-2008 Đến: 19-08-2008</td></tr><tr class="back_ccc">
									<td>54</td>
									<td>22 ngày</td>
									<td>Từ: 09-04-2015 Đến: 02-05-2015</td></tr><tr>
									<td>55</td>
									<td>25 ngày</td>
									<td>Từ: 10-12-2015 Đến: 05-01-2016</td></tr><tr class="back_ccc">
									<td>56</td>
									<td>23 ngày</td>
									<td>Từ: 06-02-2011 Đến: 02-03-2011</td></tr><tr>
									<td>57</td>
									<td>30 ngày</td>
									<td>Từ: 25-07-2013 Đến: 25-08-2013</td></tr><tr class="back_ccc">
									<td>58</td>
									<td>35 ngày</td>
									<td>Từ: 01-01-2018 Đến: 06-02-2018</td></tr><tr>
									<td>59</td>
									<td>24 ngày</td>
									<td>Từ: 22-04-2008 Đến: 17-05-2008</td></tr><tr class="back_ccc">
									<td>60</td>
									<td>25 ngày</td>
									<td>Từ: 23-05-2012 Đến: 18-06-2012</td></tr><tr>
									<td>61</td>
									<td>35 ngày</td>
									<td>Từ: 16-04-2012 Đến: 22-05-2012</td></tr><tr class="back_ccc">
									<td>62</td>
									<td>28 ngày</td>
									<td>Từ: 24-07-2017 Đến: 22-08-2017</td></tr><tr>
									<td>63</td>
									<td>26 ngày</td>
									<td>Từ: 05-09-2013 Đến: 02-10-2013</td></tr><tr class="back_ccc">
									<td>64</td>
									<td>25 ngày</td>
									<td>Từ: 14-09-2018 Đến: 10-10-2018</td></tr><tr>
									<td>65</td>
									<td>30 ngày</td>
									<td>Từ: 19-10-2009 Đến: 24-11-2009</td></tr><tr class="back_ccc">
									<td>66</td>
									<td>29 ngày</td>
									<td>Từ: 16-11-2014 Đến: 16-12-2014</td></tr><tr>
									<td>67</td>
									<td>26 ngày</td>
									<td>Từ: 23-11-2011 Đến: 20-12-2011</td></tr><tr class="back_ccc">
									<td>68</td>
									<td>27 ngày</td>
									<td>Từ: 01-05-2009 Đến: 29-05-2009</td></tr><tr>
									<td>69</td>
									<td>28 ngày</td>
									<td>Từ: 15-10-2008 Đến: 13-11-2008</td></tr><tr class="back_ccc">
									<td>70</td>
									<td>30 ngày</td>
									<td>Từ: 09-12-2013 Đến: 09-01-2014</td></tr><tr>
									<td>71</td>
									<td>28 ngày</td>
									<td>Từ: 21-08-2008 Đến: 19-09-2008</td></tr><tr class="back_ccc">
									<td>72</td>
									<td>20 ngày</td>
									<td>Từ: 18-02-2016 Đến: 10-03-2016</td></tr><tr>
									<td>73</td>
									<td>28 ngày</td>
									<td>Từ: 10-08-2013 Đến: 08-09-2013</td></tr><tr class="back_ccc">
									<td>74</td>
									<td>36 ngày</td>
									<td>Từ: 04-04-2016 Đến: 11-05-2016</td></tr><tr>
									<td>75</td>
									<td>24 ngày</td>
									<td>Từ: 08-06-2012 Đến: 03-07-2012</td></tr><tr class="back_ccc">
									<td>76</td>
									<td>25 ngày</td>
									<td>Từ: 12-05-2012 Đến: 07-06-2012</td></tr><tr>
									<td>77</td>
									<td>27 ngày</td>
									<td>Từ: 27-10-2010 Đến: 24-11-2010</td></tr><tr class="back_ccc">
									<td>78</td>
									<td>33 ngày</td>
									<td>Từ: 02-09-2017 Đến: 06-10-2017</td></tr><tr>
									<td>79</td>
									<td>21 ngày</td>
									<td>Từ: 02-03-2010 Đến: 24-03-2010</td></tr><tr class="back_ccc">
									<td>80</td>
									<td>23 ngày</td>
									<td>Từ: 04-02-2009 Đến: 28-02-2009</td></tr><tr>
									<td>81</td>
									<td>27 ngày</td>
									<td>Từ: 11-01-2011 Đến: 12-02-2011</td></tr><tr class="back_ccc">
									<td>82</td>
									<td>23 ngày</td>
									<td>Từ: 09-03-2011 Đến: 02-04-2011</td></tr><tr>
									<td>83</td>
									<td>27 ngày</td>
									<td>Từ: 06-07-2016 Đến: 03-08-2016</td></tr><tr class="back_ccc">
									<td>84</td>
									<td>29 ngày</td>
									<td>Từ: 01-06-2014 Đến: 01-07-2014</td></tr><tr>
									<td>85</td>
									<td>25 ngày</td>
									<td>Từ: 16-02-2014 Đến: 14-03-2014</td></tr><tr class="back_ccc">
									<td>86</td>
									<td>28 ngày</td>
									<td>Từ: 08-11-2016 Đến: 07-12-2016</td></tr><tr>
									<td>87</td>
									<td>23 ngày</td>
									<td>Từ: 15-08-2013 Đến: 08-09-2013</td></tr><tr class="back_ccc">
									<td>88</td>
									<td>26 ngày</td>
									<td>Từ: 27-07-2009 Đến: 23-08-2009</td></tr><tr>
									<td>89</td>
									<td>31 ngày</td>
									<td>Từ: 07-07-2009 Đến: 08-08-2009</td></tr><tr class="back_ccc">
									<td>90</td>
									<td>24 ngày</td>
									<td>Từ: 07-05-2010 Đến: 01-06-2010</td></tr><tr>
									<td>91</td>
									<td>31 ngày</td>
									<td>Từ: 19-07-2009 Đến: 20-08-2009</td></tr><tr class="back_ccc">
									<td>92</td>
									<td>26 ngày</td>
									<td>Từ: 15-07-2009 Đến: 11-08-2009</td></tr><tr>
									<td>93</td>
									<td>23 ngày</td>
									<td>Từ: 21-06-2009 Đến: 15-07-2009</td></tr><tr class="back_ccc">
									<td>94</td>
									<td>32 ngày</td>
									<td>Từ: 07-07-2011 Đến: 09-08-2011</td></tr><tr>
									<td>95</td>
									<td>27 ngày</td>
									<td>Từ: 11-04-2014 Đến: 09-05-2014</td></tr><tr class="back_ccc">
									<td>96</td>
									<td>28 ngày</td>
									<td>Từ: 25-05-2015 Đến: 23-06-2015</td></tr><tr>
									<td>97</td>
									<td>25 ngày</td>
									<td>Từ: 02-05-2018 Đến: 28-05-2018</td></tr><tr class="back_ccc">
									<td>98</td>
									<td>26 ngày</td>
									<td>Từ: 12-12-2010 Đến: 08-01-2011</td></tr>
									<tr>
									<td>99</td>
									<td>20 ngày</td>
									<td>Từ: 23-05-2016 Đến: 13-06-2016</td>
									</tr></table>';

        $html = str_get_html($str);
        foreach($html->find('tr') as $tr){
            echo '<tr>
                    <td class="col-xs-2 text-bold">'.$tr->find('td',0)->innertext.'</td>
                    <td class="col-xs-4">'.$tr->find('td',1)->innertext.'</td>
                    <td class="col-xs-6">'.$tr->find('td',2)->innertext.'</td>
                  </tr>';
        }
        die;

        set_time_limit(0);
        $arr_tinh["Miền Bắc"] = 0;
        $arr_tinh["Kiên Giang"] = 29;
        $arr_tinh["Tiền Giang"] = 30;
        $arr_tinh["Đà Lạt"] = 31;
        $arr_tinh["Kon Tum"] = 45;
        $arr_tinh["Khánh Hòa"] = 36;
        $arr_tinh["Huế"] = 32;
        $arr_tinh["Phú Yên"] = 33;
        $arr_tinh["Đồng Tháp"] = 13;
        $arr_tinh["TP.HCM"] = 14;
        $arr_tinh["Cà Mau"] = 15;
        $arr_tinh["Vũng Tàu"] = 10;
        $arr_tinh["Bến Tre"] = 16;
        $arr_tinh["Bạc Liêu"] = 17;
        $arr_tinh["Đắk Lắk"] = 34;
        $arr_tinh["Quảng Nam"] = 35;
        $arr_tinh["Đồng Nai"] = 19;
        $arr_tinh["Sóc Trăng"] = 18;
        $arr_tinh["Cần Thơ"] = 11;
        $arr_tinh["Khánh Hòa"] = 36;
        $arr_tinh["Đà Nẵng"] = 37;
        $arr_tinh["An Giang"] = 20;
        $arr_tinh["Tây Ninh"] = 21;
        $arr_tinh["Bình Thuận"] = 22;
        $arr_tinh["Bình Định"] = 38;
        $arr_tinh["Quảng Bình"] = 39;
        $arr_tinh["Quảng Trị"] = 40;
        $arr_tinh["Vĩnh Long"] = 23;
        $arr_tinh["Bình Dương"] = 24;
        $arr_tinh["Trà Vinh"] = 25;
        $arr_tinh["Ninh Thuận"] = 41;
        $arr_tinh["Gia Lai"] = 42;
        $arr_tinh["Long An"] = 26;
        $arr_tinh["TP.HCM"] = 14;
        $arr_tinh["Bình Phước"] = 27;
        $arr_tinh["Hậu Giang"] = 28;
        $arr_tinh["Quảng Ngãi"] = 43;
        $arr_tinh["Đà Nẵng"] = 37;
        $arr_tinh["Đắk Nông"] = 44;

        $lotteryId = $arr_tinh["Miền Bắc"];
        $link_daiphat = 'https://xosodaiphat.com/XSDPThongKeAjax/XSDPTKGanCucDai?lotteryId=' . $lotteryId . '&rollingNumbers=30';
        $content_maxgan = str_get_html(requestvl($link_daiphat));
        $content_maxgan->find('.input-group', 0)->outertext = '';
        $content_maxgan->find('.input-group', 1)->outertext = '';
        $content_maxgan->find('.table', 0)->outertext = '';

        LotoGan::firstOrCreate([
            'province_id' => 0,
            'content' => $content_maxgan,
        ]);

        $provinces = Province::where('mien', 3)->orWhere('mien',2)->get();
        foreach($provinces as $province){
            $lotteryId = $arr_tinh[$province->name];
            $link_daiphat = 'https://xosodaiphat.com/XSDPThongKeAjax/XSDPTKGanCucDai?lotteryId=' . $lotteryId . '&rollingNumbers=30';
            $content_maxgan = str_get_html(requestvl($link_daiphat));
            $content_maxgan->find('.input-group', 0)->outertext = '';
            $content_maxgan->find('.input-group', 1)->outertext = '';
            $content_maxgan->find('.table', 0)->outertext = '';

            LotoGan::firstOrCreate([
                'province_id' => $province->id,
                'content' => trim($content_maxgan),
            ]);
        }
        echo 'xong!';
    }


}
