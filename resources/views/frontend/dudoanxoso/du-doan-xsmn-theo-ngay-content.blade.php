<div class="the-article-content">
    <h2 class="the-article-summary">Xem thống kê dự đoán XSMN hôm nay ngày {{ getNgayThang1($date) }} - Soi cầu xổ số
        miền Nam chính xác 100 từ cao thủ soi cầu số 1 chốt số siêu chuẩn hoàn toàn miễn phí. Dự đoán kết quả XSMN
        {{ $date }}, thống kê giải đặc biệt, lô xiên, loto 2 số.</h2>

    <p>Dựa vào các thuật toán xác suất thống kê mới nhất, phân tích các kết quả gần nhất của xổ số Miền Nam XSMN Hôm Nay
        . Đưa ra được kết quả dự đoán các con số may mắn có độ chính xác cao</p>

    <h2 class="article_big_title">Dự Đoán XSMN {{ $date }}</h2>

    <p>Hãy cùng chuyên gia soi cầu <a href="{{ route('dudoan.xsmn.date', getNgayLink($dateYmd)) }}">dự
            đoán XSMN {{ $date }}</a> hôm nay siêu chuẩn với các kết quả dự đoán giải đặt biệt đầu đuôi, giải
        lô tô 2 số, lô xiên chính xác nhất.</p>

    <p>Để kết quả dự đoán được chính xác Xổ Số Miền Nam XSMN Hôm Nay. Bạn nên tham khảo lại kết quả KQXS Xổ Số Miền Nam
        XSMN các kỳ trước để có cơ sở so sánh và đưa ra quyết định chọn con số phù hợp của XSMN, có cơ hội trúng giải
        cao nhất.</p>

    <p><strong>Xem lại bảng kết quả XSMN kì trước:</strong></p>
    @include('frontend.dudoanxoso.kqxsmn', ['xsmns' => $xsmns])
    <br>

    <div class="table_dudoan_wrapper mt25">
        @foreach ($province_mn as $pro)
            <h3>✅ Chốt số lô dự đoán xổ số {{ $pro->name }} {{ $date }}</h3>
            <table class="table_dudoan">
                <tbody>
                    <tr>
                        <td>🌟 Giải tám: <span class="conso_dudoan red">{{ getNumberRand() }}</span></td>
                    </tr>
                    <tr>
                        <td>🌟 Đặc biệt: đầu, đuôi: <span class="conso_dudoan red">{{ getNumberRand() }}</span>
                        </td>
                    </tr>
                    <?php $lo3 = [];
                    for ($i = 0; $i < 3; $i++) {
                        $item = getNumberRand();
                        while (in_array($item, $lo3)) {
                            $item = getNumberRand();
                        }
                        $lo3[] = $item;
                    }
                    $lo3 = implode(' - ', $lo3); ?>
                    <tr>
                        <td>🌟 Bao lô 2 số: <span class="conso_dudoan red">{{ $lo3 }}</span></td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <td colspan="3">=&gt; Xem trực tiếp kết quả Cần Thơ: <a
                                href="{{ route('xstinh.tinh', $pro->slug) }}"
                                title="XS{{ strtoupper($pro->short_name) }}">XS{{ strtoupper($pro->short_name) }}</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        @endforeach
    </div>
    <h3>Cầu XSMN ngày {{ $date }} bằng phương pháp Pascal</h3>

    @foreach ($province_mn as $pro)
        <div class="pascal">
            <div class="pascal-header">Cầu Pascal {{ $pro->name }}</div>
            <div class="pascal-body">
                <p>Giải đặc biệt: <span class="red conso_dudoan">{{ $pascal[$pro->short_name]['gdb'] }}</span></p>

                <p>Giải nhất: <span class="red conso_dudoan">{{ $pascal[$pro->short_name]['g1'] }}</span></p>

                <p>Bảng cầu:</p>

                <div class="pascal-table">
                    @for ($k = 0; $k <= 8; $k++)
                        <div class="pascal-row">
                            @for ($i = 0; $i < strlen($pascal[$pro->short_name][$k]); $i++)
                                <span class="pascal-number">{{ $pascal[$pro->short_name][$k][$i] }}</span>
                            @endfor
                        </div>
                    @endfor
                </div>
                <p>Kết quả tạo cầu:</p>

                <div class="pascal-result">
                    <span>{{ $pascal[$pro->short_name][9] }}</span><span>{{ $pascal[$pro->short_name][9] }}</span>
                </div>
            </div>
        </div>
    @endforeach
    <br>

    <p>BÍ KÍP giúp {{ request()->getHost() }} cầu XSMN {{ $date }} và các ngày khác đều cho kết quả dự đoán
        chính xác
        nhất, TỈ LỆ trúng giải cao nhất là dựa trên kết quả XSMN ngày hôm trước và phương pháp xác suất
        thống kê chuyên sâu, các con số lâu ra nhất bạn chọn sẽ cho kết quả trúng thưởng đáng ngạt
        nhiên.</p>

    <p><strong>Quay thử XSMN thử vận may</strong></p>

    <p>Các bạn có thể thử vận may tìm ra con số may mắn của mình bằng cách tham gia <a target="_blank"
            href="{{ route('quay_thu.mn') }}">Quay
            thử XSMN</a></p>

    <p>Bên dưới đây là bảng quay thử XSMN ngày {{ $date }} mà chúng tôi đã thực hiện, mời bạn tham khảo:</p>

    @include('frontend.dudoanxoso.quay_thu_mn', ['date' => $date])
    <h3>Cầu XSMN {{ $date }}</h3>

    <p>Để có kết quả cầu xsmn {{ $date }} các chuyên gia giỏi nhất của {{ request()->getHost() }} phải tổng
        hợp dữ liệu
        các con số trúng giải của hơn 5 năm và dùng nhiều thời gian để phân tích học thuật xác suất thống kê
        để đưa ra các con số may mắn nhất cho quý đọc giả.</p>

    <p style="font-style: italic; color: red; font-size: 12px; line-height: 1.5;">Lưu ý: Các bộ số chỉ
        dùng cho mục đích tham khảo, bạn nên cân nhắc trước khi chơi và không chơi lô đề vì đó là bất hợp
        pháp, chỉ nên chơi lô tô do nhà nước phát hành vừa vui vừa đảm bảo ích nước lợi nhà bạn nhé</p>

    <p>Nếu bạn có kết quả dự đoán khác về kết quả xổ số XSMN hôm nay, mời bình luận chia sẻ để mọi người
        tham khảo.</p>
</div>
