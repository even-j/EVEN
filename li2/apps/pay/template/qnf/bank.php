<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
        <style type="text/css">
            body{background: #fff;}
            .ms-c6-bank{width:1000px;margin: 40px auto;border:1px solid #ddd;text-align: center}
            .ms-c6-bank h3{line-height: 40px;font-size: 16px;border-bottom: 1px solid #ddd;padding:0 20px}
            .ms-c6-bank li{display: inline-block;margin:10px 10px}
            .iw {
                display: inline-block;
                vertical-align: middle;
                width: 114px;
                height: 25px;
                padding-top: 5px;
                padding-left: 10px;
                background: url(/public/web/images/bank/bank_logo.png) no-repeat;
                border: #DDD solid 1px;
                text-indent: -9999px;
            }

            /******借记卡信用卡logo******/
            .ABC { background-position: 0px 0px !important;/*农业银行*/ }
            .CCB { background-position: 0px -93px !important;/*建设银行*/ }
            .ICBC { background-position: 0px -186px !important;/*工商银行*/ }
            .BOC { background-position: -12px -279px !important;/*中国银行*/ }
            .BOCO { background-position: 0px -372px !important;/*交通银行*/ }
            .CMBCHINA { background-position: -8px -465px !important;/*招商银行*/ }
            .CMBC { background-position: 0px -558px !important;/*民生银行*/ }
            .CIB { background-position: 0px -651px !important;/*兴业银行*/ }
            .CEB { background-position: 0px -744px !important;/*光大银行*/ }
            .ECITIC { background-position: -5px -837px !important;/*中信银行*/ }
            .POST { background-position: 0px -930px !important;/*邮政储蓄银行*/ }
            .BCCB { background-position: -7px -1023px !important;/*北京银行*/ }
            .GDB { background-position: 0px -1116px !important;/*广发银行*/ }
            .SDB { background-position: 0px -1209px !important;/*深圳发展银行*/ }
            .SPDB { background-position: -5px -1302px !important;/*浦发银行*/ }
            .HXB { background-position: -5px -1395px !important;/*华夏银行*/ }
            .BJRCB { background-position: 0px -1488px !important;/*北京农商银行*/ }
            .SHB { background-position: -150px 0px !important;/*上海银行*/ }
            .CZ { background-position: -148px -93px !important;/*浙商银行*/ }
            .SDE { background-position: -137px -186px !important;/*顺德信用社*/ }
            .SCCB { background-position: -140px -372px !important;/*河北银行*/ }
            .EGB { background-position: -145px -465px !important;/*恒丰银行*/ }
            .ZJTLCB { background-position: -135px -558px !important;/*浙江泰隆商业银行*/ }
            .CBHB { background-position: -138px -651px !important;/*渤海银行*/ }
            .HKBEA { background-position: -138px -744px !important;/*东亚银行*/ }
            .NJCB { background-position: -145px -930px !important;/*南京银行*/ }
            .NBCB { background-position: -148px -1023px !important;/*宁波银行*/ }
            .GZCB { background-position: -137px -1116px !important;/*广州市商业银行*/ }
            .SRCB { background-position: -137px -1209px !important;/*上海农村商业银行*/ }
            .HZBANK { background-position: -145px -1302px !important;/*杭州银行*/ }
            .NCBBANK { background-position: -140px -1395px !important;/*南洋商业银行*/ }
            .PINGANBANK { background-position: -137px -1488px !important;/*平安银行*/ }
            /******借记卡信用卡logo结束******/

        </style>
        
    </head>

    <body class="index">
            <div class="ms-c6-bank">
                <h3>选择充值银行</h3>
                <div>
                    <ul class="clearfix">
                        <li title="工商银行">
                            <input type="radio" name="bank" class="radio" value="icbc"/>
                            <div class="iw ICBC" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="工商银行"></div>
                        </li>
                        <li title="农业银行">
                            <input type="radio" name="bank" class="radio" value="abc"/>
                            <div class="iw ABC" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="农业银行"></div>
                        </li>
                        <li title="中国银行">
                            <input type="radio" name="bank" class="radio" value="boc"/>
                            <div class="iw BOC" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="中国银行"></div>
                        </li>
                        <li title="建设银行">
                            <input type="radio" name="bank" class="radio" value="ccb"/>
                            <div class="iw CCB" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="建设银行"></div>
                        </li>
                        <li title="招商银行">
                            <input type="radio" name="bank" class="radio" value="cmb"/>
                            <div class="iw CMBCHINA" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="招商银行"></div>
                        </li>
                        <li title="交通银行">
                            <input type="radio" name="bank" class="radio" value="bcom"/>
                            <div class="iw BOCO" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="交通银行"></div>
                        </li>
                        <li title="兴业银行">
                            <input type="radio" name="bank" class="radio" value="cib"/>
                            <div class="iw CIB" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="兴业银行"></div>
                        </li>
                        <li title="光大银行">
                            <input type="radio" name="bank" class="radio" value="ceb"/>
                            <div class="iw CEB" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="光大银行"></div>
                        </li>
                        <li title="中信银行">
                            <input type="radio" name="bank" class="radio" value="citic"/>
                            <div class="iw ECITIC" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="中信银行"></div>
                        </li>
                        <li title="民生银行">
                            <input type="radio" name="bank" class="radio" value="cmbc"/>
                            <div class="iw CMBC" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="民生银行"></div>
                        </li>
                        <li title="邮储银行">
                            <input type="radio" name="bank" class="radio" value="psbc"/>
                            <div class="iw POST" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="邮储银行"></div>
                        </li>

                        <li title="广发银行">
                            <input type="radio" name="bank" class="radio" value="1114"/>
                            <div class="iw GDB" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="广发银行"></div>
                        </li>
                        <li title="上海浦东发展银行">
                            <input type="radio" name="bank" class="radio" value="1109"/>
                            <div class="iw SPDB" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="上海浦东发展银行"></div>
                        </li>
                        <li title="平安银行">
                            <input type="radio" name="bank" class="radio" value="1121"/>
                            <div class="iw PINGANBANK" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="平安银行"></div>
                        </li>
                        <li title="南京银行">
                            <input type="radio" name="bank" class="radio" value="1115"/>
                            <div class="iw NJCB" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="南京银行"></div>
                        </li>
                        <li title="上海银行">
                            <input type="radio" name="bank" class="radio" value="1116"/>
                            <div class="iw SHB" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="上海银行"></div>
                        </li>
                        <li title="渤海银行">
                            <input type="radio" name="bank" class="radio" value="1123"/>
                            <div class="iw CBHB" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="渤海银行"></div>
                        </li>
                        <li title="华夏银行">
                            <input type="radio" name="bank" class="radio" value="1111"/>
                            <div class="iw HXB" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="华夏银行"></div>
                        </li>
                        <li title="北京农商银行">
                            <input type="radio" name="bank" class="radio" value="1124"/>
                            <div class="iw BJRCB" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="北京农商银行"></div>
                        </li>
                        <li title="东亚银行">
                            <input type="radio" name="bank" class="radio" value="1122"/>
                            <div class="iw HKBEA" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="东亚银行"></div>
                        </li>

                    </ul>
                </div>
            </div>
        <script type="text/javascript">
            $(function() {
                $('dd').click(function() {
                    $('dd').removeClass('current');
                    $(this).addClass('current');
                    $('#mainFrame').css('height', '0px');
                    $('#loading').css('display', 'block');
                });
            });
        </script>
    </body>
</html>