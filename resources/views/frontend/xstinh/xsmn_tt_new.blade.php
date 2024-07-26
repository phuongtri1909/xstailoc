<div class="tit-mien clearfix" id="provinceLiveTitle">
    <h2>XS' + r.LotteryCode.toUpperCase() + ' - Kết quả Xổ số ' + r.LotteryName + ' - SX' + r.LotteryCode.toUpperCase() + ' hôm nay</h2>

    <div>
        <a class="sub-title" href="/xs' + o + '-xo-so-' + l + '" title="Kết quả xổ số ' + i + '">' + m + '</a>
        » <a class="sub-title" href="' + getLotteryByDayOfWeekLink(o, p[0]) + '"
             title="' + i + ' ' + p[0] + '">' + m + ' ' + p[0] + '</a>
        » <a class="sub-title"
             href="' + getLotteryLink(r.LotteryId, r.LotteryCode, r.LotteryName) + '"
             title="XS' + r.LotteryCode.toUpperCase() + '">XS' + r.LotteryCode.toUpperCase() + ' ' + r.CrDateTime.toString()+ '</a>
    </div>
</div>
<div id="load_kq_tinh_live">
    <div data-id="kq" data-zoom="0" class="one-city">
        <table class="kqmb extendable kqtinh">
            <tbody>
            <tr class="g8">
                <td class="txt-giai">G.8</td>

                <td class="v-giai number"><span data-nc="2" class="v-g8 "
                                                id="' + r.LotteryCode + '_prize_8_item_0"><i class="fas fa-spinner fa-spin"></i></span>
                </td>


            </tr>
            <tr class="bg_ef">
                <td class="txt-giai">G.7</td>

                <td class="v-giai number"><span data-nc="3" class="v-g7 "
                                                id="' + r.LotteryCode + '_prize_7_item_0"><i class="fas fa-spinner fa-spin"></i></span>
                </td>
            </tr>
            <tr>
                <td class="txt-giai">G.6</td>
                <td class="v-giai number">
                                <span data-nc="4" class="v-g6-0 "
                                      id="' + r.LotteryCode + '_prize_6_item_0"><i class="fas fa-spinner fa-spin"></i></span><span
                            data-nc="4" class="v-g6-1 "
                            id="' + r.LotteryCode + '_prize_6_item_1"><i class="fas fa-spinner fa-spin"></i></span><span
                            data-nc="4" class="v-g6-2 "
                            id="' + r.LotteryCode + '_prize_6_item_2"><i class="fas fa-spinner fa-spin"></i></span>
                </td>
            </tr>
            <tr class="bg_ef">
                <td class="txt-giai">G.5</td>
                <td class="v-giai number">
                                <span data-nc="4" class="v-g5 "
                                      id="' + r.LotteryCode + '_prize_5_item_0"><i class="fas fa-spinner fa-spin"></i></span>
                </td>
            </tr>

            <tr class="g4">
                <td class="titgiai">G.4</td>
                <td class="v-giai number">
                                <span data-nc="5" class="v-g4-0 "
                                      id="' + r.LotteryCode + '_prize_4_item_0"><i class="fas fa-spinner fa-spin"></i></span><!--
                                    --><span data-nc="5" class="v-g4-1 "
                                             id="' + r.LotteryCode + '_prize_4_item_1"><i class="fas fa-spinner fa-spin"></i></span><!--
                                    --><span data-nc="5" class="v-g4-2 "
                                             id="' + r.LotteryCode + '_prize_4_item_2"><i class="fas fa-spinner fa-spin"></i></span><!--
                                    --><span data-nc="5" class="v-g4-3 "
                                             id="' + r.LotteryCode + '_prize_4_item_3"><i class="fas fa-spinner fa-spin"></i></span><!--
                                    --><span data-nc="5" class="v-g4-4 "
                                             id="' + r.LotteryCode + '_prize_4_item_4"><i class="fas fa-spinner fa-spin"></i></span><!--
                                    --><span data-nc="5" class="v-g4-5 "
                                             id="' + r.LotteryCode + '_prize_4_item_5"><i class="fas fa-spinner fa-spin"></i></span><!--
                                    --><span data-nc="5" class="v-g4-6 "
                                             id="' + r.LotteryCode + '_prize_4_item_6"><i class="fas fa-spinner fa-spin"></i></span>
                </td>
            </tr>

            <tr class="bg_ef">
                <td class="txt-giai">G.3</td>
                <td class="v-giai number">
                                <span data-nc="5" class="v-g3-0 "
                                      id="' + r.LotteryCode + '_prize_3_item_0"><i class="fas fa-spinner fa-spin"></i></span><!--
                                        --><span data-nc="5" class="v-g3-1 "
                                                 id="' + r.LotteryCode + '_prize_3_item_1"><i class="fas fa-spinner fa-spin"></i></span>
                </td>
            </tr>
            <tr>
                <td class="txt-giai">G.2</td>
                <td class="v-giai number">
                                <span data-nc="5" class="v-g2 "
                                      id="' + r.LotteryCode + '_prize_2_item_0"><i class="fas fa-spinner fa-spin"></i></span>
                </td>
            </tr>
            <tr class="bg_ef">
                <td class="txt-giai">G.1</td>
                <td class="v-giai number"><span data-nc="5" class="v-g1 "
                                                id="' + r.LotteryCode + '_prize_1_item_0"><i class="fas fa-spinner fa-spin"></i></span>
                </td>
            </tr>
            <tr class="gdb db">
                <td class="txt-giai">ĐB</td>
                <td class="v-giai number"><span data-nc="6" class="v-gdb "
                                                id="' + r.LotteryCode + '_prize_db_item_0"><i class="fas fa-spinner fa-spin"></i></span>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="control-panel">
            <form class="digits-form"><label class="radio" data-value="0"><input type="radio"
                                                                                 name="showed-digits"
                                                                                 value="0"><b></b><span></span></label><label
                        class="radio" data-value="2"><input type="radio" name="showed-digits"
                                                            value="2"><b></b><span></span></label><label
                        class="radio" data-value="3"><input type="radio" name="showed-digits"
                                                            value="3"><b></b><span></span></label></form>
            <div class="buttons-wrapper"><span class="capture-button"><i
                            class="icon capture-icon"></i><span></span></span>

                <div class="subscription-button dspnone"><input id="load_kq_tinh_1_chx" type="checkbox"
                                                                class="ntf-sub cbx dspnone"
                                                                sub-type-id="null"><label
                            id="load_kq_tinh_1_chx_lbl" sub-type-id="null" class="lbl1"
                            for="load_kq_tinh_1_chx"></label><span></span></div>
            </div>
        </div>
    </div>
    <div class="buttons-wrapper"></div>
    <div data-id="dd" class="col-firstlast" id="livebangkqloto_' + r.LotteryCode.toUpperCase() +'">
        <table class="firstlast-mb fl">
            <tbody>
            <tr class="header">
                <th>Đầu</th>
                <th>Đuôi</th>
            </tr>
            <tr>
                <td class="clred">0</td>
                <td class="v-loto-dau-0" id="loto_' + r.LotteryCode + '_0"></td>
            </tr>
            <tr>
                <td class="clred">1</td>
                <td class="v-loto-dau-1" id="loto_' + r.LotteryCode + '_1"></td>
            </tr>
            <tr>
                <td class="clred">2</td>
                <td class="v-loto-dau-2" id="loto_' + r.LotteryCode + '_2"></td>
            </tr>
            <tr>
                <td class="clred">3</td>
                <td class="v-loto-dau-3" id="loto_' + r.LotteryCode + '_3"></td>
            </tr>
            <tr>
                <td class="clred">4</td>
                <td class="v-loto-dau-4" id="loto_' + r.LotteryCode + '_4"></td>
            </tr>
            <tr>
                <td class="clred">5</td>
                <td class="v-loto-dau-5" id="loto_' + r.LotteryCode + '_5"></td>
            </tr>
            <tr>
                <td class="clred">6</td>
                <td class="v-loto-dau-6" id="loto_' + r.LotteryCode + '_6"></td>
            </tr>
            <tr>
                <td class="clred">7</td>
                <td class="v-loto-dau-7" id="loto_' + r.LotteryCode + '_7"></td>
            </tr>
            <tr>
                <td class="clred">8</td>
                <td class="v-loto-dau-8" id="loto_' + r.LotteryCode + '_8"></td>
            </tr>
            <tr>
                <td class="clred">9</td>
                <td class="v-loto-dau-9" id="loto_' + r.LotteryCode + '_9"></td>
            </tr>
            </tbody>
        </table>
        <table class="firstlast-mb fr">
            <tbody>
            <tr class="header">
                <th>Đầu</th>
                <th>Đuôi</th>
            </tr>
            <tr>
                <td class="v-loto-duoi-0" id="loto_' + r.LotteryCode + '_d0"></td>
                <td class="clred">0</td>
            </tr>
            <tr>
                <td class="v-loto-duoi-1" id="loto_' + r.LotteryCode + '_d1"></td>
                <td class="clred">1</td>
            </tr>
            <tr>
                <td class="v-loto-duoi-2" id="loto_' + r.LotteryCode + '_d2"></td>
                <td class="clred">2</td>
            </tr>
            <tr>
                <td class="v-loto-duoi-3" id="loto_' + r.LotteryCode + '_d3"></td>
                <td class="clred">3</td>
            </tr>
            <tr>
                <td class="v-loto-duoi-4" id="loto_' + r.LotteryCode + '_d4"></td>
                <td class="clred">4</td>
            </tr>
            <tr>
                <td class="v-loto-duoi-5" id="loto_' + r.LotteryCode + '_d5"></td>
                <td class="clred">5</td>
            </tr>
            <tr>
                <td class="v-loto-duoi-6" id="loto_' + r.LotteryCode + '_d6"></td>
                <td class="clred">6</td>
            </tr>
            <tr>
                <td class="v-loto-duoi-7" id="loto_' + r.LotteryCode + '_d7"></td>
                <td class="clred">7</td>
            </tr>
            <tr>
                <td class="v-loto-duoi-8" id="loto_' + r.LotteryCode + '_d8"></td>
                <td class="clred">8</td>
            </tr>
            <tr>
                <td class="v-loto-duoi-9" id="loto_' + r.LotteryCode + '_d9"></td>
                <td class="clred">9</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="clearfix"></div>
</div>
