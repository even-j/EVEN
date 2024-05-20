
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
        <style type="text/css">
            <!--
            .STYLE1 {color: #0000CC}
            -->
        </style>
        <style>
            body{ background: #FFFFFF ;}
            .header { background: #79b4ff!important;}
            .down_hd{ background-image: linear-gradient(120deg, #7eb5ff 0%, #51afff 100%); text-align: center; padding-top: 30px;}
            .app_down_rwm{  background: url(public/wap/images/down/app_rwm.png) no-repeat center;  background-size: 350px;  margin: 0 auto;}
            .app_down_rwm img{ width: 40%;  margin-top: 30px;}
            .inputBox{ width: 276px; background: url(public/wap/images/down/app_button.png) no-repeat; background-size: 276px;margin: 30px auto; height: 46px;}
            .inputBox input{ border: none ; background: none; font-size: 16px; color: #ffffff; width: 180px;float: left;  margin-left: 19px; margin-top: 22px;}
            .inputBox button{ border: none; background: none;height: 30px; width: 70px;margin-top: 16px;margin-left: 5px; cursor:pointer;color:#fd5440;text-align: center;}
            .down_hd p{font-size: 16px;color: #fff; line-height: 22px;}
            .shuoming{ line-height: 25px; padding: 15px;padding-left: 250px}
            .shuoming p{ color: #776f6f; font-size: 14px; padding-top: 10px;}
            .shuoming p span{ background:url(public/wap/images/down/nub.png) no-repeat ; width: 44px; height: 18px; float: left; font-size: 14px; color: #fff; margin-right: 5px; display: block; text-align: center;background-size: 45px;
                              line-height: 19px;}
            h4{ color: #51afff; font-size: 16px; text-align: center;}
            .shuoming img{ text-align: center;  display: block; padding: 10px 0; margin: 0 auto;}
            dd strong{color:#5ab0ff;font-size:16px}
            .down_img{margin-top: 40px}
            .down_img li{float:left;width:24%;height:200px;margin:10px 4.5%;position: relative}
            .down_img li img{width:100%}
            .down_img li .ewm{position: absolute;top:77px;left:29px;width: 180px;}
        </style>
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
                <p class="title1"><b>交易软件</b></p>
                <div class="aboutM"><script type="text/javascript">
                    $(function () {
                        $('dt').click(function () {
                            if ($(this).parent().attr('class') == 'hover') {
                                $(this).parent().removeClass('hover');
                            } else {
                                $(this).parent().addClass('hover');
                            }

                        });
                    });
                    </script>
                    <?php $params_ewm = \Model\Admin\Params::get('ewm');?>
                    <div class="helpbox">
                        <div style="padding-top:40px;height:550px;display:block;background: url('/public/web/images/down/pc_bg.png') no-repeat;background-size: 100% 100%" class="hbc">
                            <img src="/public/web/images/down/down_text.png" style="display:block;margin:0px auto;height: 40px"/>
                            <ul class="down_img">
                                <li>
                                    <a href="/华亿交易端.exe"><img src="/public/web/images/down/win_icon.png"/></a>
                                </li>
                                <li><img src="/public/web/images/down/and_icon.png"/>
                                    <img class="ewm" src="<?php echo $params_ewm['tradeapp_path'];?>"/>
                                </li>
                                <li><img src="/public/web/images/down/ios_icon.png"/>
                                    <img class="ewm" src="<?php echo $params_ewm['tradeapp_path'];?>"/></li>
                            </ul>
                            

                        </div>
                        <dd><strong>电脑端下载说明：</strong></dd>
                        <dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;①点击“电脑版下载“将安装包下载到桌面；</dd>
                        <dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;②打开“华亿交易端.exe”安装包进行安装，点击“华亿交易端”即可登入交易。</dd>
                        <br>
                        <dd><strong>安卓版APP下载说明：</strong></dd>
                        <dd>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;①使用安卓手机扫码“安卓APP下载”二维码按照提示进行下载安装。</dd>
                        <br>
                        <dd><strong>苹果手机添加信任操作说明：</strong></dd>
                        
                        <div class="shuoming">
                
                <p><span>1</span>点击“华亿交易端”弹出下面对话框！</p>
                <img src="public/wap/images/down/J/p01.png?v=1" style="margin-left:50px"/>        	
                <p><span>2</span>点击“设置”！</p>
                <img src="public/wap/images/down/J/p02.png?v=1" style="margin-left:50px"/>
                <p><span>3</span>点击“通用”！</p>
                <img src="public/wap/images/down/J/p03.png?v=1" style="margin-left:50px"/>
                <p><span>4</span>点击“设备管理”！</p>
                <img src="public/wap/images/down/J/p04.png?v=1" style="margin-left:50px"/>
                <p><span>5</span>点击“企业级应用”-“...”！</p>
                <img src="public/wap/images/down/J/p05.png?v=1" style="margin-left:50px"/>
                <p><span>6</span>点击“信任...”！</p>
                <img src="public/wap/images/down/J/p06.png?v=1" style="margin-left:50px"/>
                <p><span>7</span>点击“信任”OK 完成！</p>
                <img src="public/wap/images/down/J/p07.png?v=1" style="margin-left:50px"/>
                <p><span>8</span>完成操作，可以正常使用“华亿交易端”了！</p>
            </div>
            <div style="clear: both"></div>
        </div>
                    </div>

            </div>

            
        <!-- Content End -->
        <script type="text/javascript">
            $(function (e) {
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