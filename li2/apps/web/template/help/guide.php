
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
    </head>

    <body class="index">
        <!-- Header Start -->
        <div id="top">
            <!--include file "header.php"-->
            <!--include file "nav.php"-->
        </div>
        <link href="/public/web/css/article.css" rel="stylesheet" type="text/css" media="screen,projection" />
        <!-- Content Start -->
        <div class="bar">
            <div class="aboutNav">
                <!--include file "help_left_menu.php"-->
            </div>
            <div class="aboutMain" style="">
                <p class="title1"><b>新手指南</b></p>
                <div class="aboutM">
                    <style>
                    .pl40 { padding-left: 40px; }
                    .pr40 { padding-right: 40px; }
                    .pg-guide-content { color: #636363 }
                    .pg-guide-title h3 { margin-bottom: 20px }
                    .pg-guide-title ul { border-bottom: 1px solid #FFF; padding-bottom: 25px }
                    .pg-guide-title ul li { float: left; position: relative; top: 4px; padding: 0 20px 10px; background: 0; color: #09d; font-size: 18px }
                    .pg-guide-title ul li.active, .pg-guide-title ul li.active:hover { border-bottom: 4px solid #2ea7e0 }
                    .pg-guide-title ul li.active a, .pg-guide-title ul li.active a:hover { color: #2ea7e0 }
                    .pg-guide-item { background: #fcfcfc; padding: 20px 0; line-height: 30px }
                    .pg-guide-item.dark { background: #f4f6f9 }
                    .pg-guide-item h4 { height: 70px; left: -16px; position: relative; z-index: 2; background: url(/tpl/Home/default/Res/img/guide-titlebg.png) no-repeat scroll left 0; color: #fff }
                    .pg-guide-item h4 span { display: inline-block; min-width: 145px; padding: 0 44px 0 16px; line-height: 50px }
                    .pg-guide-item .h4bg-bule span { background: #1bb8e2 }
                    .pg-guide-item .h4bg-green { background-position: left -97px }
                    .pg-guide-item .h4bg-green span { background: #aabc64 }
                    .pg-guide-item .h4bg-yellow { background-position: left -186px }
                    .pg-guide-item .h4bg-yellow span { background: #ffc400 }
                    .pg-guide-item .h4bg-cyanblue { background-position: left -281px }
                    .pg-guide-item .h4bg-cyanblue span { background: #4ca499 }
                    .pg-guide-item .h4bg-orange { background-position: left -369px }
                    .pg-guide-item .h4bg-orange span { background: #fb5a00 }
                    .pg-guide-item dl { margin-bottom: 10px }
                    .pg-guide-item dl dt { margin-bottom: 10px; font-size: 24px }
                    .pg-guide-sercurity .pg-guide-item dl dt { font-size: 22px }
                    .pg-guide-item dl dd { margin-bottom: 20px; color: gray; line-height: 24px }
                    .pg-guide-item dl dd p { line-height: 24px }
                    .pg-guide-item dl.mb30 { margin-bottom: 30px }
                    .pg-guide-item dl.mb20 { margin-bottom: 20px }
                    .guide-first-word { float: left; margin-right: 6px; *margin-top: -6px; height: 60px; line-height: 60px; font-size: 48px; font-weight: 700 }
                    .guide-item-link { margin: 22px 0 0 }
                    .pg-guide-item .performance { position: relative }
                    .pg-guide-item .performance-item { position: absolute; left: 170px; color: #00a8e8 }
                    .pg-guide-item .performance-item.borrow { left: 135px }
                    .pg-guide-item .performance-item-trade { top: 90px }
                    .pg-guide-item .performance-item-interest { top: 240px }
                    .pg-guide-item .performance-item-count { top: 270px }
                    .pg-guide-item .img-container { position: relative; height: 350px }
                    .pg-guide-item .img-container img { position: absolute }
                    .pg-guide-item .img-container .icon-plan { top: 10px; left: 160px }
                    .pg-guide-item .img-container .icon-loan { top: 125px; left: 290px }
                    .pg-guide-item .img-container .icon-transfer { top: 175px; left: 120px }
                    .pg-guide-item .img-container .icon-work { top: 30px; left: 180px }
                    .pg-guide-item .img-container .icon-biz { top: 155px; left: 45px }
                    .pg-guide-item .img-container .icon-ecomm { top: 210px; left: 220px }
                    .pg-guide-security h1 { padding-top: 20px; font-size: 30px; color: #0697da }
                    .pg-guide-security h2 { padding-bottom: 10px; font-size: 24px; color: #0697da }
                    .pg-guide-security h3 { color: #474747; font-size: 18px }
                    .pg-guide-security .ph20 { padding-bottom: 30px }
                    .pg-guide-security p.last { margin-bottom: 5px }
                    .pg-guide-security .section { margin: 30px 0 }
                    .pg-guide-security .section.first { margin-top: 10px }
                    .pg-guide-security .section.last { margin-bottom: 10px }

                    </style>
                    <script type="text/javascript">
                        $(function(){
                            $('.rrd-dimgray').click(function(){
                                $('.pg-guide-info').hide();
                                $('.rrd-dimgray').removeClass('active');
                                $('#'+$(this).attr('target')).show();
                                $(this).addClass('active');
                            });
                        });
                    </script>
                    <div class="grid_12"> 
                        <div class="pg-guide-content">
                            <div class="pg-guide-title">
                                <ul class="mt10 fn-clear">
                                    <li class="rrd-dimgray active" target="stock"><a href="#nogo">股票策略</a></li>
                                </ul>
                            </div>


                            <div id="stock" class="pg-guide-info mt20">

                                <div class="pg-guide-item dark">
                                    <h4 class="h4bg-green"><span>什么是股票策略？</span></h4>
                                    <div class="pl40 pr40">
                                        <dl>
                                            <dt></dt>
                                            <dd>股票策略是一种创新的股票投资工具，通过股票策略，能有效的提高投资收益，堪称炒股利器。在系统性或确定性机会出现时，投资者运用策略工具，可以在华亿策略获得自有资金1—10倍的资金，能够将收益水平放大到几倍。投资者需要注意，策略工具在放大收益也会放大风险，投资者应在投资机会比较确定并管理好风险的前提下使用，宜投资相对稳健的品种。</dd>
                                        </dl>
                                    </div>
                                </div>
                                <div class="pg-guide-item">
                                    <h4 class="h4bg-yellow"><span>策略后如何进行股票交易？</span></h4>
                                    <div class="pl40 pr40">
                                        <dl>
                                            <dt></dt>
                                            <dd>策略成功后，华亿策略平台会为客户在合作券商处分配股票交易实盘账户，用户可在会员中心 >> 操盘管理 >> 按天/按月策略的目录下查看证券账号和查看交易密码。（首次策略用户必须点击下载“交易软件”才可以开始交易）。</dd>
                                        </dl>
                                    </div>

                                    <div class="pg-guide-item dark">
                                        <h4 class="h4bg-bule"><span>华亿策略如何进行股票策略的风险管理？</span></h4>
                                        <div class="pl40 pr40">
                                            <dl>
                                                <dt></dt>
                                                <dd>股票策略完成后，您获得一个证券公司的股票交易账号和密码，然后就可以开始交易了。为了保护策略资金安全，同时帮您养成良好的投资习惯，交易账户会设置警戒线和平仓线。亏损警戒线：当总操盘资金低于警戒线（亏损至本金*60%）以下时，只能平仓不能建仓。亏损平仓线：当总操盘资金低于平仓线（亏损至本金*80%）以下时，华亿策略将有权把您的股票进行平仓。为避免平仓发生，请时刻关注本金是否充足。如果未强平成功，继续亏损至本金*100%情况下，券商有权强制收回交易账号进行结算，穿仓部分客户无需赔偿。</dd>
                                            </dl>
                                        </div>
                                    </div>
                                    <div class="pg-guide-item">
                                        <h4 class="h4bg-green"><span>股票策略限制购买的股票有哪些？</span></h4>
                                        <div class="pl40 pr40">
                                            <dl>
                                                <dt></dt>
                                                <dd>1、不得购买权证类可以T+0交易的证券；
												<br/> 2、用户不得买入当天禁买股，禁买股包括但不仅限于：ST、*ST、SST、*SST、分级基金等被证券交易所特别处理的股票；
												<br/> 3、不得购买首日上市新股（或复牌首日股票）等当日不设涨跌停板限制的股票；
												<br/> 4、已发布停牌、退市公告或有潜在退市风险的股票；
												<br/> 5、有可能导致结算日无法正常卖出或亏损超过保证金的股票；
												<br/> 6、上市20日以内的新股；
                                                    <br/> 7、不得进行坐庄、对敲、接盘、大宗交易、内幕信息等违反股票交易法律法规及证券公司规定的交易。
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                    <div class="pg-guide-item dark">
                                        <h4 class="h4bg-yellow"><span>股票策略的注意事项有哪些？</span></h4>
                                        <div class="pl40 pr40">
                                            <dl>
                                                <dt></dt>
                                                <dd>操盘前必读
                                                    <br/> 请尽量保持操盘保证金高于亏损警戒线，及时添加风险保证金，以免到达亏损平仓线被强制平仓；
                                                    <br/> 股票停牌处理
													<br/> 如果您买的股票遇到停牌，到期后可以选择继续持有或者放弃。继续持有就是继续缴纳管理费（利息）直至股票复牌，如果放弃持有，选择以停牌前一交易日收盘价作为计算价格对停牌股票进行清算。
                                                    <br/> 交易手续费
                                                    <br/> 手续费包含印花税、过户费和交易佣金，印花税和过户费按财政部和交易所规定收取，交易佣金0.02%（万二）由券商收取。
                                                    <br/> 其他注意事项
                                                    <br/> 1、投资盈利部分可在平仓结算后随时提现，申请结算（工作时间内）及时到达您账户，如您申请提款到银行卡，工作时间内秒到您银行卡（节假日无休）；
                                                    <br/> 2、按天策略支付管理费，如6月25日策略，6月25日支付第1天管理费，6月26日（08:30分）支付第二天管理费，以此类推；
													<br/> 3、按月策略支付利息，如6月25日策略，6月25日支付第1个月利息，7月25日支付第2个月利息，以此类推；
                                                    <br/> 4、策略到期前一个交易日，应将股票账号平仓，进行结算。如到期未结算，系统将自动延期收取对应费用。
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                    <div class="pg-guide-item">
                                        <h4 class="h4bg-cyanblue"><span>策略与融资融券业务的区别是什么？</span></h4>
                                        <div class="pl40 pr40">
                                            <dl>
                                                <dt></dt>
                                                <dd>股票策略业务与融资融券业务从本质上讲都是增加投资者的操盘资金，但两者又有着很大的差别。
                                                    <br/> 股票策略是股民在一定本金的情况下，提供放大资金比例操盘，然后支付一定的利息；融资融券则是投资者向具有上海证券交易所或深圳证券交易所会员资格的证券公司提供担保物，借入资金买入本所上市证券或借入本所上市证券并卖出的行为。但是在融资融券实际操作中存在着诸多的限制，以下对两项业务做个对比：
                                                    <table border="1" cellpadding="0" cellspacing="0">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <p>
                                                                        融资融券</p>
                                                                </td>
                                                                <td>
                                                                    <p>
                                                                        股票策略</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>
                                                                        开户必须满6个月</p>
                                                                </td>
                                                                <td>
                                                                    <p>
                                                                        无限制</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>
                                                                        资金要求最低50万</p>
                                                                </td>
                                                                <td>
                                                                    <p>
                                                                        100元起</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>
                                                                        标的股少（可交易的股票少）</p>
                                                                </td>
                                                                <td>
                                                                    <p>
                                                                        可交易的股票多</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>
                                                                        融资额度低（一般50%）</p>
                                                                </td>
                                                                <td>
                                                                    <p>
                                                                        策略额度高（1-10倍杠杆）</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>
                                                                        交易佣金高（通常在千分之1以上）</p>
                                                                </td>
                                                                <td>
                                                                    <p>
                                                                        交易佣金低（万分之2）</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>
                                                                        融资最长期限6个月</p>
                                                                </td>
                                                                <td>
                                                                    <p>
                                                                        策略期限无限制</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>
                                                                        需要足额的担保物</p>
                                                                </td>
                                                                <td>
                                                                    <p>
                                                                        不需要</p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div style="clear: both"></div>
        </div>
        <!-- Content End -->
        <script type="text/javascript">
            $(function(e) {
//                $(window).scroll(function() {
//                    if ($(document).scrollTop() > 140) {
//                        $('.aboutNav').css('position', 'fixed');
//                        $('.aboutNav').css('top', '0px');
//                        $('.aboutMain').css('margin-left', '190px');
//                    } else {
//                        $('.aboutNav').css('position', '');
//                        $('.aboutMain').css('margin-left', '');
//                    }
//                });
            });
        </script>
        <!-- Footer Start -->
        <!--include file "footer.php"-->
    </body>
</html>